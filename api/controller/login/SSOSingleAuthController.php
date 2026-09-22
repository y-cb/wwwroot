<?php
namespace controller\login;

Class SSOSingleAuthController {
//    public $module = 'cloud_platform_login';
    private $secret = '73756e7961696e666f73736c76706e32';
    private $field = array('dest', 'port', 'timestamp', 'role', 'token');
    private $role = array('sysadmin'=> 'admin', 'secadmin'=> 'useradmin', 'auditor'=> 'audit');
    private $error = array('-1'=> 'Parameter error', '-2'=> 'Timestamp error', '-3'=> 'Token match error');

    public function get() {

        $param = get_inputs();

        if (!$this->isFieldEmpty($param)) {
            echo json_encode(array('code'=>'-1', 'str'=>$this->error['-1']));
            return;
        }
        if (!$this->isTimeout($param['timestamp'])) {
            echo json_encode(array('code'=>'-1', 'str'=>$this->error['-2']));
            return;
        }

        $str = sprintf("dest=%s&port=%d&timestamp=%d&role=%s&secret=%s", $param['dest'], $param['port'], $param['timestamp'], $param['role'], $this->secret);
        $token = hash("sha256", $str);

        if ($token !== $param['token']) {
            echo json_encode(array('code'=>'-3', 'str'=>$this->error['-3']));
            return;
        } else {
            $_SESSION[LOGINSTATE] = 'set';
            $_SESSION[CONNECTION.USERNAME] = $this->role[$param['role']];


            getResponse('language_cfg',"mod",array('language'=> 1));
            setcookie('PHPSESSID', session_id(), time()+3600, "/");
            setcookie("username", $this->role[$param['role']], time()+3600,"/");
            setcookie("token", SSO_TOKEN, time()+3600,"/");
            header("location: /#/sso");
        }
    }

    private function isFieldEmpty($data) {

        if (empty($data)) {
            return false;
        }

        foreach ($field as $value) {
            if (!$data[$value]) {
                return false;
                break;
            }
        }

        return true;
    }

    private function isTimeout($time) {
        $now = time();
        $time_diff = $now - $time;

        if ($time_diff > 300 || $time_diff < -300) {
            return false;
        }

        return true;
    }
}
