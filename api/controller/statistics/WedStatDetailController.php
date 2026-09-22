<?php
namespace controller\statistics;
use controller\mController;
use database\MysqlDb;

class WedStatDetailController extends mController {

    private $is_cli;
    private $cache_file = '/web_stat_cache.json';
    private $cache_path = '/tmp';

    public function __construct() {

        if(!file_exists('/mnt1/mysql/')) {
            return;
        }

        $this->is_cli = ($_GET['cli']) ? true : false;

        if(!$this->is_cli) {
            parent::__construct();
        }
    }

    public function get() {

        if($this->is_cli) {
            $this->cli();
        }else {
            $cache = file_get_contents($this->cache_path.$this->cache_file);
            $cache = json_decode($cache, true);
            $cache['stat_detail'] = is_array($cache['stat_detail']) && !empty($cache['stat_detail']) ? $cache['stat_detail'] : [];
            echo json_encode($cache['stat_detail']);
        }
        exit;
    }

    private function cli() {

        if(!file_exists($this->cache_path)) {
            mkdir($this->cache_path, 755, true);
        }

        $cur = time();
        $day = strftime("%Y%m%d", $cur);
        $table_name = 'web_access_'. $day;

        $where["GROUP"] = 'category';
        $where["ORDER"] = 'cnt DESC';
        $where["LIMIT"] = [0, 9];
        $count  = MysqlDb::if_column_exists($table_name,'count');
        if ($count > 0) {
            $cates = MysqlDb::org_select($table_name, ['category', '[SUMC](cnt)'],  $where);
            $total = MysqlDb::org_select($table_name, ['[SUMC](cnt)', '[HOUR](hour)'], ["GROUP" => "hour"]);
        } else {
            $cates = MysqlDb::org_select($table_name, ['category', '[COUNT](cnt)'],  $where);
            $total = MysqlDb::org_select($table_name, ['[COUNT](cnt)', '[HOUR](hour)'], ["GROUP" => "hour"]);
        }
     
        $total_max = 0;

        foreach($cates as $cate) {
            unset($where);
            unset($counter);
            unset($tmp);
            unset($item);

            $where["GROUP"] = "hour";
            $where["category"] = $cate["category"];
            $where["ORDER"] = 'hour DESC';
            //$data = $database->select($table_name, ['[COUNT](cnt)', '[HOUR](hour)'], $where);
            if ($count > 0) {
                $data = MysqlDb::org_select($table_name, ['[SUMC](cnt)', '[HOUR](hour)'], $where);
            } else {
                $data = MysqlDb::org_select($table_name, ['[COUNT](cnt)', '[HOUR](hour)'], $where);
            }
          
            if (sizeof($data) > 0) {
                $max = $data[0]['hour'];
                if($max>$total_max){
                    $total_max = $max;
                }
            } else {
                $max = 0;
                $total_max = $max;
            }

            for ($i = 0; $i <= $total_max; $i++) {
                $num = 0;

                for ($j = 0; $j <= $total_max; $j++) {
                    if (isset($data[$j]['hour']) && $data[$j]['hour'] == $i) {
                        $num = (int) $data[$j]['cnt'];
                    }
                }
                $counter[] = $num;
            }

            $tmp['category'] = $cate["category"];
            $tmp['pointInterval'] = 60 * 60 * 1000;
            $date = localtime($cur, true);
            $tmp['pointStart'] = ($cur - ($cur % (24 * 3600))) * 1000;
            $tmp['data'] = $counter;
            $retdata[] = $tmp;
        }
        unset($tmp);
        unset($counter);

        /* 计算其它剩余分类的值 */
        for ($i = 0; $i <= $total_max; $i++) {
            $num = 0;
            for ($k = 0; $k < sizeof($total); $k++) {
                if ($total[$k]['hour'] ==  $i) {
                    $num = $total[$k]['cnt'];
                    break;
                }
            }

            for ($j = 0; $j < sizeof($retdata); $j++) {
                $num = $num - $retdata[$j]['data'][$i];
            }

            if ($num < 0) {
                /* should not go here */
                echo 'error';
                $num = 0;
            }
            $counter[] = (int)$num;
        }

        $tmp['category'] = "_others";
        $tmp['pointInterval'] = 60 * 60 * 1000;
        $date = localtime($cur, true);
        $tmp['pointStart'] = ($cur - ($cur % (24 * 3600))) * 1000;
        $tmp['data'] = $counter;
        $retdata[] = $tmp;

        $cache = file_get_contents($this->cache_path.$this->cache_file);
        $cache = json_decode($cache, true);
        $cache['stat_detail'] = $retdata;
        $cache['timestamp'] = time();
        file_put_contents($this->cache_path.$this->cache_file, json_encode($cache));
        echo 'Generate Done! '.date('Y-m-d H:i:s')."\n";
    }
}
