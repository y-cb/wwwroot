<?php
namespace controller\syslog;
use controller\mController;

class WebStatCliController extends mController {

    private $op; // op: 1-CLI执行计算 2-web执行计算 3-检查数据是否存在
    private $cache_file = '/web_stat_cache.json';
    private $cache_path = '/tmp';

    public function __construct() {

        if (!file_exists('/mnt1/mysql/')) {
            return;
        }

        $this->op = $_GET['op'] ? intval($_GET['op']) : 2;

        if($this->op == 2) {
            parent::__construct();
        }

        if(is_dir('/mnt1/web_stat_cache')) {
            exec('rm -rf /mnt1/web_stat_cache');
        }
    }

    public function get() {
        //CLI执行计算、web执行计算
        if($this->op == 1 || $this->op == 2) {

            $start_time = time();
            exec('wget -q http://localhost/api/web-host?cli=1 >/dev/null');
            exec('wget -q http://localhost/api/web-user?cli=1 >/dev/null');
            exec('wget -q http://localhost/api/web-category?cli=1 >/dev/null');
            exec('wget -q http://localhost/api/web-detail?cli=1 >/dev/null');
            $end_time = time();

            switch ($this->op) {
                case 1: {
                    echo ' runtime:' . ($end_time - $start_time) . "s\n"; break;
                }
                case 2: {
                    echo json_encode(['runtime' => ($end_time - $start_time)]); break;
                }
            }
            exit;
        }

        //检查数据是否存在
        if($this->op == 3) {

            $has_cache = 1;

            $cache = file_get_contents($this->cache_path.$this->cache_file);
            $cache = json_decode($cache, true);
            $cache_data = date('Y-m-d', $cache['timestamp']);
            if(
                empty($cache) || !is_array($cache) ||
                empty($cache['stat_user']) || empty($cache['stat_host']) ||
                empty($cache['stat_detail']) || empty($cache['stat_category']) ||
                empty($cache['timestamp']) || ($cache_data != date('Y-m-d'))
            ) {
                $has_cache = 0;
            }

            echo json_encode(['has_cache' => $has_cache]);
            exit;
        }
    }
}
