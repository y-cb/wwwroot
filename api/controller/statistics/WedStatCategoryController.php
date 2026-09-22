<?php
namespace controller\statistics;
use controller\mController;
use database\MysqlDb;
use lib\AuditlogSession;

class WedStatCategoryController extends mController {

    private $is_cli;
    private $cache_file = '/web_stat_cache.json';
    private $cache_path = '/tmp';

    public function __construct() {

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
            $cache['stat_category'] = is_array($cache['stat_category']) && !empty($cache['stat_category']) ? $cache['stat_category'] : [];
            echo json_encode($cache['stat_category']);
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
        //$table_name = 'web_access_20180125';
        $count  = MysqlDb::if_column_exists($table_name,'count');
        if ($count > 0) {
            $data = MysqlDb::org_select($table_name, [ 'category', '[SUMC](cnt)'],  ["LIMIT" => 9,  "GROUP" => "category", "ORDER" => "cnt DESC"]);
        } else {
            $data = MysqlDb::org_select($table_name, [ 'category', '[COUNT](cnt)'],  ["LIMIT" => 9,  "GROUP" => "category", "ORDER" => "cnt DESC"]);
        }
        $total = MysqlDb::org_max($table_name, 'id', []);
        $num = 0;
        foreach($data as $item) {
            $num += $item['cnt'];
        }

        $others = $total - $num;
        if ($others != 0 && $others > 0) {
            $other_item['category'] = '_others';
            $other_item['cnt'] = $others;
            $data[] = $other_item;
        }
        if(!$data){
            $data=[];
        }

        $cache = file_get_contents($this->cache_path.$this->cache_file);
        $cache = json_decode($cache, true);
        $cache['stat_category'] = $data;
        $cache['timestamp'] = time();
        file_put_contents($this->cache_path.$this->cache_file, json_encode($cache));
        echo 'Generate Done! '.date('Y-m-d H:i:s')."\n";
    }
}
