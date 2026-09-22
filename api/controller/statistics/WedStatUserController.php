<?php
namespace controller\statistics;
use controller\mController;
use database\MysqlDb;
use lib\AuditlogSession;

class WedStatUserController extends mController {

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
            $cache['stat_user'] = is_array($cache['stat_user']) && !empty($cache['stat_user']) ? $cache['stat_user'] : [];
            echo json_encode($cache['stat_user']);
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
        $count  = MysqlDb::if_column_exists($table_name,'count');
        if ($count > 0) {
            $data = MysqlDb::org_select($table_name, [ 'username', '[SUMC](cnt)'],  ["LIMIT" => 10,  "GROUP" => "username", "ORDER" => "cnt DESC"]);
        } else {
            $data = MysqlDb::org_select($table_name, [ 'username', '[COUNT](cnt)'],  ["LIMIT" => 10,  "GROUP" => "username", "ORDER" => "cnt DESC"]);
        }
        if(!$data){
            $data=[];
        }

        $cache = file_get_contents($this->cache_path.$this->cache_file);
        $cache = json_decode($cache, true);
        $cache['stat_user'] = $data;
        $cache['timestamp'] = time();
        file_put_contents($this->cache_path.$this->cache_file, json_encode($cache));
        echo 'Generate Done! '.date('Y-m-d H:i:s')."\n";
    }
}
