<?php
namespace controller\login;
use lib\LoginHandler;
use lib\SSO;

class SSOTokenController
{
    private $pem_path = '/etc/webserver.pem';
//    private $sso_path = '/tmp/sso_config.json';
    private $error = ['501' => 'timestamp range wrong', '502' => 'field wrong', '503' => 'timestamp format wrong'];

    function post()
    {
        $param = get_inputs();
        $sso = new SSO();
        $key = $sso->get_pem_key();

        $decryptstr = sso_aes_decrypt($param['data'], $key, '', 'AES-256-ECB');

        $param_array = explode('&', $decryptstr);

        $username = base64_decode($param_array[0]);
        $password = base64_decode($param_array[1]);
        $sip = base64_decode($param_array[2]);
        $time = base64_decode($param_array[3]);


        if ($param_array[0] !== base64_encode($username) ||
        $param_array[1] !== base64_encode($password) ||
        $param_array[2] !== base64_encode($sip) ||
        $param_array[3] !== base64_encode($time)
        ) {
            $msg = ['code' => '502', 'str' => $this->error['502']];
            echo json_encode($msg);
            return;
        }

        preg_match("/[0-9]*/", $time, $preg_time);

        if ($preg_time[0] !== $time) {
            $msg = ['code' => '503', 'str' => $this->error['503']];
            echo json_encode($msg);
            return;
        }


        $time = abs(intval($time) - time());


        if (count($param_array) != 4) {
            $msg = ['code' => '502', 'str' => $this->error['502']];
            echo json_encode($msg);
            return;
        }

        if ($time > 60) {
            $msg = ['code' => '501', 'str' => $this->error['501']];
            echo json_encode($msg);
            return;
        }

        $ret = $sso->check_sso_file($param_array);

        if ($ret !== true) {
            if ($ret['token']) {
                echo json_encode($ret);
                return;
            }
        }

        $_SESSION[CONFIG_CHECKNUM] = '####';
        $captcha = '####';
        $lang = 1;

        $sess_id = $sso->get_token_session();
        session_start();
        session_id($sess_id);

        LoginHandler::login($username, $password, $captcha, $lang, 1);

        if (LoginHandler::isLoginFail()) {
            $fail_msg = $_SESSION[LEVEL];

            if (strlen($fail_msg) <= 0) {
                $fail_msg = t('login.user_pwd_error');//用户名或者密码错误
            }

            if ($fail_msg == trim("force_change_password")) {
                $expire_msg = ($lang == 1) ? "密码已过期，请重置密码" : "Password has expired. Please reset your password";
                $ret = array('code' => '-1003', 'str' => $expire_msg, 'force_param' => $_SESSION['FORCE_PARAM']);
            } else {
                $ret = array('code' => '-1001', 'str' => $fail_msg);
            }

            echo json_encode($ret);
        } else {
            $login_info = ['username' => $username, 'password' => $password, 'srcip' => $sip];
            $info = $sso->write_sso_file($login_info);
//            $token['admin_otp_enable'] = $_SESSION['ADMIN_OPT_ENABLE'];
//            $this->get_admin_permission($param_array[0]);
            echo json_encode($info);
            exit(0);
        }
        unset($sso);
    }
}
