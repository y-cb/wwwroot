<?php
namespace controller\login;
/**
 * Created by PhpStorm.
 * User: wangminghao
 * Date: 2022/5/25
 * Time: 3:34 PM
 */

class SSOAuthLoginController {
    private $err = ['503'=> 'field wrong', '504'=> 'invalid token', '505'=> 'token is timeout', '506'=> 'token not found'];

    function get() {
        $param = get_inputs();

        if (!isset($param['token'])) {
            $msg = ['code'=> '503', 'str'=> $this->err['503']];
            echo json_encode($msg);
            return;
        }

        if (!file_exists(SSO_FILE)) {
            $msg = ['code'=> '504', 'str'=> $this->err['504']];
            echo json_encode($msg);
            return;
        }

        $json = file_get_contents(SSO_FILE);

        if (!$json) {
            $msg = ['code'=> '504', 'str'=> $this->err['504']];
            echo json_encode($msg);
            return;
        }

        $data = json_decode($json, true);

        foreach ($data as $key=> $val) {
            if ($val['token'] === $param['token'] && $val['srcip'] === $_SERVER[REMOTE_ADDR]) {
                if ($val['validtime'] < time()) {
                    unset($data[$key]);
                    $msg = ['code'=> '505', 'str'=> $this->err['505']];
                    echo json_encode($msg);
                    return;
                }

                session_start();
                session_id($param['token']);
                getResponse('language_cfg',"mod",array('language'=> 1));
                LoginController::get_admin_permission($val['username']);

                $_SESSION[LOGINSTATE] = 'set';
                $_SESSION[CONNECTION.USERNAME] = $val['username'];

                setcookie('PHPSESSID', $param['token'], time()+3600, "/");
                setcookie("username", $val['username'],time()+3600,"/");
                setcookie("token", $val['token'],time()+3600,"/");
                unset($data[$key]);
                @file_put_contents(SSO_FILE, json_encode($data));
                header("Location:/#/sso");
                return;
            }

            if ($val['validtime'] < time()) {
                unset($data[$key]);
                continue;
            }
        }

        $msg = ['code'=> '506', 'str'=> $this->err['506']];
        echo json_encode($msg);
        return;
    }
}
