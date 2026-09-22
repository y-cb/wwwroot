<?php
namespace controller\system;
use controller\mController;
use lib\WriteLog;

class ReportFTPController extends mController{
    public $path = '/mnt/boot/ftp.json';
    private $debug_file_path = '/tmp/.shell_output';
    public $list = array('ftp_server'=> '', 'ftp_port'=> '', 'ftp_user'=> '', 'ftp_passwd'=> '');
    function get() {
        $param = get_inputs();
        $data = array();

        if (file_exists($this->path)) {
            $json = file_get_contents($this->path);
            if ($json) {
                $data['data'] = json_decode($json, true);
            }
        }  else {
            $data['data'] = $this->list;
        }

        header('Content-type: application/json');
        echo json_encode($data);
    }

    function post () {
        $param = get_inputs();

        if ($this->ftp_exists($param['ftp_server'], $param['ftp_port'])) {
            $param['output_path'] = $this->debug_file_path;
            $ret = $this->ftp_test($param);
        } else {
            $ret = array('code' => '-1', 'str'=> t('report.ftp_connect_unreached_error'));
        }

        if (!empty($ret)) {
            echo json_encode($ret);
        }

        return;
    }

    function put () {
        $param = get_inputs();

        $ret = @file_put_contents($this->path, json_encode($param));
        $params = array("sync_module"=>"9","sync_type"=>"3","sync_name"=>"");
        $rspString = getResponse('ha_sync_module', "mod" ,$params);

        $msg = 'SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="ftp report edit" ManageStyle=web Content="operation success"';
        WriteLog::ConfigWrite($msg);

        header('Content-type: application/json');
        if (!empty($ret)) {
            echo json_encode($ret);
        }
    }

    private function ftp_test($info) {
        if (file_exists($info['output_path'])) {
            unlink($info['output_path']);
        }
        //编写lftp shell命令
        $shell = "/bin/bash /usr/local/wwwroot/common/lftp_bash.sh login_check ".$info['ftp_user']." ".$info['ftp_passwd']." ".$info['ftp_server']." ".$info['ftp_port']." ".$info['output_path'];
        $ret = shell_exec($shell);

        if (file_exists($info['output_path'])) {
            $msg = '';
        } else {
            $msg = array('code'=> '1', 'str'=> t('report.ftp_connect_user_error'));
        }

        return $msg;
    }

    private function ftp_exists($host, $port, $timeout = 30) {
        return ftp_connect($host, $port, $timeout)? true: false;
    }
}

