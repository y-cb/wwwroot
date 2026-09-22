<?php
namespace controller\login;
use lib\SSO;
/**
 * Created by PhpStorm.
 * User: wangminghao
 * Date: 2022/6/14
 * Time: 5:22 PM
 */

Class SSOResetPwdController {
    private $error = ['501'=> 'timestamp range wrong', '502'=> 'field wrong', '503'=> 'timestamp format wrong'];
    private $module = 'change_admin_passwd';

    function put() {
        $param = get_inputs();
        $sso = new SSO();
        $key = $sso->get_pem_key();

        $decryptstr = sso_aes_decrypt($param['data'], $key, '', 'AES-256-ECB');

        $param_array  = explode('&', $decryptstr);

        $username = base64_decode($param_array[0]);
        $old_pwd = base64_decode($param_array[1]);
        $new_pwd = base64_decode($param_array[2]);
        $time = base64_decode($param_array[3]);

        preg_match("/[0-9]*/", $time, $preg_time);

        if ($preg_time[0] !== $time) {
            $msg = ['code'=> '503', 'str'=> $this->error['503']];
            echo json_encode($msg);
            return;
        }


        $time = abs(intval($time) - time());


        if (count($param_array) != 4) {
            $msg = ['code'=> '502', 'str'=> $this->error['502']];
            echo json_encode($msg);
            return;
        }

        if ($time > 60) {
            $msg = ['code' => '501', 'str'=> $this->error['501']];
            echo json_encode($msg);
            return;
        }

        $data = [
            'username'=> $username,
            'old_password' => $old_pwd,
            'new_password' => $new_pwd,
            'nocheck' => 1,
            'ip_addr' => $_SERVER['REMOTE_ADDR']
        ];
        $rspString = getResponse($this->module, 'mod', $data);
        $ret = getAssign($rspString, $this->module);
        if($ret['code']){
            echo json_encode($ret);
        }
        unset($sso);
    }
}