<?php
namespace controller\system;
use controller\mController;
use message\MainModel;

define(RAM_PATH, '/tmp/');
define(CFCARD_PATH, '/mnt/');

class UpdateFirmareController extends mController{
    private $error = ['update.space_not_enough', 'update.file_download_wrong', 'update.ip_unreachable'];
	public $module = 'update_firmware';
    public $cf_check_module = 'update_version';

    function post() {
        $param = get_inputs();
        set_upload_file(UPLOAD_FILE, strtotime('+ 10 minutes'));

        $ret = $this->system_update($param);

        header('Content-type: application/json');
        if (!empty($ret)) {
            echo json_encode($ret);
        }

        exit;
    }

    private function system_update($data) {
        switch ($data['type']) {
            case 'ftp':
                return $this->ftp_update($data);
                break;
            case 'tftp':
                return $this->tftp_update($data);
                break;
            case 'usb':
                return $this->usb_update($data);
                break;
        }
    }


    private function usb_update($data) {
        $rspString = getResponse($this->module, "add" ,$data);
        $ret = getAssign($rspString, $this->module);

        return $ret;
    }

    private function ftp_update($data) {
        $check_ret = $this->check_system_space();
        if (is_array($check_ret)) {
            return $check_ret;
        }

        if (!$this->check_ip_isreach($data['server'])){
            return ['code'=> 503, 'str'=> t($this->error[2])];
        }

        $version_path = $check_ret . substr($data['version'], strrpos($data['version'], '/')+1, strlen($data['version']));

        $cmd_str = sprintf("ftpget -u %s -p %s %s %s %s", $data['user'], $data['password'], $data['server'], $version_path, $data['version']);
        exec($cmd_str, $output, $ret_val);

        if ($ret_val === 1 || !file_exists($version_path) || sizeof($version_path) === 0) {
            return ['code'=> 502, 'str'=> t($this->error[1])];
        }

        $res = MainModel::updateVersion('MAIN', $version_path);

        if ($res['code']!==0 && $res['str']!== 'ok') {
            return $res;
        }
        return [];
    }

    private function check_system_space() {
        system("echo 3 > /proc/sys/vm/drop_caches");

        $f = fopen("/proc/meminfo", "r");

        if ($f) {
            while (!feof($f)) {
                if (!empty(sscanf(fgets($f), "%255s %lu %s",$name, $free_num, $tmp))){
                    if (strncmp("MemFree", $name, 7) === 0) {
                        if ($free_num/1024 > 400 ) {
                            return RAM_PATH;
                            break;
                        }
                    }
                }
            }
            fclose($f);
        }

        $rspString = getResponse($this->cf_check_module, "add" ,'');
        $cfcard_ret = getAssign($rspString, $this->cf_check_module);

        if (empty($cfcard_ret)) {
            return CFCARD_PATH;
        }

        return ['code'=> 501, 'str'=> t($this->error[0])];
    }

    private function check_ip_isreach($ip) {
        if (!$ip) {
            return false;
        }

        $shell = "ping -c 3 -W 1 {$ip}";
        exec($shell, $output);
        
        if (count($output) != 8) {
            return false;
        }
        return true;
    }

}
