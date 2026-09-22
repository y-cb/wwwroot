<?php
namespace database;
use database\MysqlDb;
use PDO;

Class ReportCache{
    private $database;
    private $dbname = '/mnt1/report_cache.db';
    function __construct()
    {
        if (!file_exists('/mnt1/mysql/')) {
            return;
        }
        //连接sqlite缓存数据库
        $this->db_connect();

        // $this->run();

    }

    function __destruct()
    {
        //关闭数据库连接
        unset($this->database);

        exit(0);
    }

    function run() {
        $start = time() - 30 * 86400;
        $end = time();


        for ($i = $start; $i <= $end; $i += 86400) {
            $webtable = 'web_username_' . date('Ymd', $i);
            $ipstable = 'ips_' . date('Ymd', $i);
            $avtable = 'av_' . date('Ymd', $i);

            if(!$this->table_ifexists($webtable)) {
                $data = $this->mysql_data_query('web_access_'.date("Ymd",$i), 'web_access');
                if ($data) {
                    $this->create_web_table('username', $i);
                    $this->create_web_table('host', $i);
                    $this->create_web_table('category', $i);

                    $tmp = 'username';
                    $this->cache_data_add($data[$tmp], 'web_'.$tmp.'_'.date('Ymd', $i), $tmp);
                    $tmp = 'host';
                    $this->cache_data_add($data[$tmp], 'web_'.$tmp.'_'.date('Ymd', $i), $tmp);
                    $tmp = 'category';
                    $this->cache_data_add($data[$tmp], 'web_'.$tmp.'_'.date('Ymd', $i), $tmp);
                }
            }

            if(!$this->table_ifexists($ipstable)) {
                $tmp = 'ips';
                $data = $this->mysql_data_query($tmp.'_' . date('Ymd', $i), $tmp);


                if ($data) {
                    $this->create_table('ips', 'eventname', $i);
                    $this->cache_data_add($data, $tmp.'_' . date('Ymd', $i), 'eventname');
                }

            }

            if(!$this->table_ifexists($avtable)) {
                $tmp = 'av';
                $data = $this->mysql_data_query($tmp . '_' . date('Ymd', $i), $tmp);

                if ($data) {
                    $this->create_table($tmp, 'virusname',$i);
                    $this->cache_data_add($data, $tmp.'_' . date('Ymd', $i), 'virusname');
                }

            }
        }

        //删除旧缓存表
        $table = 'web_username_'.time("Ymd", $start - 86400);
        $this->clean_table($table);

        $table = 'web_host_' . time("Ymd", $start - 86400);
        $this->clean_table($table);

        $table = 'web_category_' . time("Ymd", $start - 86400);
        $this->clean_table($table);

        $table = 'ips_' . time("Ymd", $start - 86400);
        $this->clean_table($table);

        $table = 'av_' . time("Ymd", $start - 86400);
        $this->clean_table($table);
    }

    private function sql_exec($sql) {
        if (!empty($sql)) {
            $res = $this->database->exec($sql);

            //返回如果为false,返回错误数据，否则返回空
            if ($this->database->errorcode()!=='00000') {
                $rtn = $this->database->errorInfo();

                // var_dump($sql);
                // echo "<br>";
                // var_dump($rtn[0].":".$rtn[2]);
                // die;
                return false;
            }
            return true;
        }
    }

    private function sql_query($sql) {
        if (!empty($sql)) {
            // var_dump(date('Ymd H:i:s',time()));
            $res = $this->database->query($sql);
            // var_dump(date('Ymd H:i:s',time()));
            $data = array();
            //返回如果为false,返回错误数据，否则返回空
            if ($res != false) {
                while($row = $res->fetch()) {
                    $data[] = $row;
                }
                return $data;
            }
        }
    }

    private function db_connect() {
        //链接数据库，如果为空则会进行创建
        $this->database = new PDO('sqlite:'.$this->dbname);
        $sql = "PRAGMA synchronous = off";
        $this->sql_exec($sql);
    }
    private function clean_table($table) {
        if ($table) {
            $sql = "drop table IF EXISTS ".$table;
            $this->sql_exec($sql);
        }
    }

    private function table_ifexists($name) {
        $sql = "SELECT count(*) as count FROM sqlite_master WHERE type='table' AND name='".$name."'";
        $res = $this->database->query($sql);
        $rtn = $res->fetch();

        if (empty($rtn['count'])) {
            return false;
        } else {
            return true;
        }
    }

    private function create_web_table($field, $time){
        $tablename = 'web_' . $field . '_' . date('Ymd', $time);

        if ($this->table_ifexists($tablename)) {
            return;
        }

        $sql = "CREATE TABLE `".$tablename."` (
          `id` INTEGER PRIMARY KEY AUTOINCREMENT,
          `" . $field . "` varchar(64),
          `num` int
        )";

        $this->sql_exec($sql);

        $index_sql = "CREATE INDEX IF NOT EXISTS `report".$field."` ON ".$tablename."(`".$field."`)";

        return $this->sql_exec($index_sql);
    }

    private function create_cache_table($table, $field) {

        /*if ($this->table_ifexists($tablename)) {
            return;
        }*/

        $sql = "CREATE TABLE `".$table."` (
          `id` INTEGER PRIMARY KEY AUTOINCREMENT,
          `" . $field . "` varchar(128),
          `num` int
        )";

        $this->sql_exec($sql);

        $index_sql = "CREATE INDEX IF NOT EXISTS `report".$field."` ON ".$table."(`".$field."`)";

        return $this->sql_exec($index_sql);
    }

    private function create_table($table, $field, $time) {
        $tablename = $table .'_'. date('Ymd', $time);

        /*if ($this->table_ifexists($tablename)) {
            return;
        }*/

        $sql = "CREATE TABLE `".$tablename."` (
          `id` INTEGER PRIMARY KEY AUTOINCREMENT,
          `" . $field . "` varchar(128),
          `num` int
        )";

        $this->sql_exec($sql);

        $index_sql = "CREATE INDEX IF NOT EXISTS `report".$field."` ON ".$tablename."(`".$field."`)";

        return $this->sql_exec($index_sql);
    }

    private function mysql_data_query($table, $type) {
        if (empty(MysqlDb::if_table_exists($table))) {
            return false;
        }

        switch ($type){
            case 'web_access':
                return [
                    'username' => MysqlDb::report_cache_query($table, 'username'),
                    'host' => MysqlDb::report_cache_query($table, 'host'),
                    'category' => MysqlDb::report_cache_query($table, 'category'),
                ];
                break;
            case 'ips':
                return MysqlDb::report_cache_query($table, 'eventname');
                break;
            case 'av':
                return MysqlDb::report_cache_query($table, 'virusname');
                break;
            default:
                // $data = '';
                break;
        }
    }

    private function cache_data_add($data, $table, $field) {
        $str='';
        foreach ($data as $key => $value) {
            $str.='("'.$value[0].'","'.$value[1].'"),';

            if (($key+1) % 500 === 0 || ($key + 1) === count($data) ) {
                $str = substr($str, 0, strlen($str)-1);
                $sql = "INSERT INTO " . $table."(num,".$field.") VALUES" . $str;
                $this->sql_exec($sql);
                $str = '';
            }
        }
    }

    function get_cahce_data($module, $start, $end) {
        $start = strtotime($start);
        $end = strtotime($end);
        switch ($module) {
            case 'web_category':
                $key = 'category';
                return $this->sqlite_arrage($module, $key, $start, $end);
                break;
            case 'web_host':
                $key = 'host';
                return $this->sqlite_arrage($module, $key, $start, $end);
                break;
            case 'web_username':
                $key = 'username';
                return $this->sqlite_arrage($module, $key, $start, $end);
                break;
            case 'ips':
                $key = 'eventname';
                return $this->sqlite_arrage($module, $key, $start, $end);
                break;
            case 'av':
                $key = 'virusname';
                return $this->sqlite_arrage($module, $key, $start, $end);
                break;
            default:
                break;
        }
    }

    function sqlite_arrage($prefix,$field, $start, $end) {

        $sql='';
        $last_cache='';
        //查询最后一个表的时间节点
        for($i = $end; $i >= $start; $i-=86400) {
            if (time()< $i) {
                continue;
            }
            $table = $prefix.'_'.date('Ymd', $i);

            if (!$this->table_ifexists($table)) {
                $last_cache = $i;
                break;
            }
        }

        if (!empty($last_cache)) {
            //增加缓存逻辑
            $this->run();
        }



        for($i = $start; $i <= $end; $i+=86400) {
            if ($i > time()) {
                break;
            }

            $table = $prefix.'_'.date('Ymd', $i);
            if ($this->table_ifexists($table)) {
                if (empty($sql)){
                    $sql = 'select '.$field.',num from '.$table;
                } else {
                    $sql .= ' union all select '.$field.',num from '.$table;
                }
            }
        }

        //数据整理
        $table = 'cache_'.$field;

        if ($this->table_ifexists($table)) {
            $this->clean_table($table);
        }

        $this->create_cache_table($table, $field);
        $prefix = 'INSERT INTO '.$table.' ('.$field.',num) ';

        $tmp_sql = $prefix . $sql;

        $this->sql_exec($tmp_sql);

        $query_sql = 'SELECT '.$field.',SUM(num) AS num FROM '.$table.' GROUP BY '.$field.' ORDER BY num DESC LIMIT 10';
        return $this->sql_query($query_sql);
    }
}