<?php
namespace controller\object;
use controller\mController;

class SMSAuthController extends mController {
	public $module = 'auth_sms_profile';
	private $config_file_path = '/mnt/boot/ali_msg.json';
	function get() {

		$data = array(
			'access_key'=> '',
			'access_secret'=> '',
			'sign_name'=> '',
			'template_code'=> ''
		);

		if (file_exists($this->config_file_path)) {
			$data = file_get_contents($this->config_file_path);
			$data = json_decode($data, true);
		}
		if (isset($data['sign_name'])) {
			$data['sign_name'] = htmlspecialchars_decode($data['sign_name']);
		}
        
		if ($data) {
			echo json_encode($data);
		}
		return;
	}
    function post(){
        $param = get_inputs();
        $rspString = getResponse($this->module, "add" ,$param);
        $ret = getAssign($rspString, $this->module);
        $sms_param = array("sync_module"=>11,"sync_type"=>3,"sync_name"=>"");
        $sms_rspString = getResponse('ha_sync_module','mod',$sms_param);
        header('Content-type: application/json');
        if (!empty($ret)) {
            echo json_encode($ret);
        }

    }
    /*function post() {
        
        $param = get_inputs();
        $access_key = strlen($param['access_key']);
        $access_secret = strlen($param['access_secret']);
        $sign_name = strlen($param['sign_name']);
        $template_code = strlen($param['template_code']);
        
        $data = [];
        if ($param['msg_plat'] != '1') {
            $data['code'] = -1;
            $data['str'] = t('sms_auth.sms_platform');
            echo json_encode($data);
            return;
        }
        if ($access_key < 1 || $access_key > 31) {
            $data['code'] = -1;
            $data['str'] = t('sms_auth.key_length_error');
            echo json_encode($data);
            return;
        }
        if ($access_secret < 1 || $access_secret > 31) {
            $data['code'] = -1;
            $data['str'] = t('sms_auth.secret_length_error');
            echo json_encode($data);
            return;
        }
        if ($sign_name < 1 || $sign_name > 31) {
            $data['code'] = -1;
            $data['str'] = t('sms_auth.name_length_error');
            echo json_encode($data);
            return;
        }
        if ($template_code < 1 || $template_code > 31) {
            $data['code'] = -1;
            $data['str'] = t('sms_auth.code_length_error');
            echo json_encode($data);
            return;
        }
        if (!empty($param)) {
            @file_put_contents($this->config_file_path, json_encode($param));
        }
        return;
        
    }*/
}
