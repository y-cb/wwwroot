<?php
require_once '../common/config.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once '../common/cfgeng.inc';

class wechat_webauth
{

    public function run() {

        switch ($_GET['api']) {

            case 'option': {

                $data = [];

                $_SESSION[CONNECTION.ISUPER] = 1;

                $rspString = getResponse('auth_wechat_profile', "showone", []);
                $wechat_cnf = getAssign($rspString, 'auth_wechat_profile');

                $rspString = getResponse('hostinfo', 'showone', []);
                $host_info = getAssign($rspString, 'hostinfo');

                exec('cat /etc/oem_id', $data['oem_id']);

                if ($wechat_cnf['cfg_enable'] == '0') {
                    $tmp = [
                        'hello_url' =>   WECHAT_REDIR_URL,
                        'appid' => WECHAT_APPID
                    ];

                    $wechat_cnf = array_merge($wechat_cnf, $tmp);
                }

                $data = [
                    'oem_id' => $data['oem_id'][0] ? : '',
                    's_ip' => $_SERVER['REMOTE_ADDR'] ? : '',
                    't_ip' => $_SERVER['SERVER_ADDR'] ? : '',
                    'sn' => $host_info['serial_no'] ? : '',
                ];
                $data = array_merge($wechat_cnf, $data);
                unset($_SESSION[CONNECTION.ISUPER]);
                echo json_encode($data);
                exit;
            }

            case 'wechat_login': {

                $module = 'auth_wechat_profile';
                $wechat_module = 'wechat_user_auth';

                $data = [];
                if (!$_GET['data']) {
                    echo "缺少主要参数data"; exit;
                }

                $json = $this->aes_decrypt($_GET['data']);

                if($json) {
                    $wechat_data = json_decode($json, true);
                }

                $data = [
                    'ip' => $_SERVER[REMOTE_ADDR]
                ];

                $_SESSION[CONNECTION.ISUPER] = 1;
                $rspString = getResponse($module, "showone");
                $wechat_cnf = getAssign($rspString, $module);
                unset($_SESSION[CONNECTION.ISUPER]);

                switch ($wechat_cnf['user_type']) {
                    case '1':
                        $data['name'] = $_SERVER[REMOTE_ADDR];
                        break;
                    case '2':
                        $data['name'] = $wechat_data['open_id'];
                        break;
                    case '3':
                        $data['name'] = $wechat_data['nickname'];
                        break;
                    default:
                        # code...
                        break;
                }

                $rspString = getResponse($wechat_module, 'add', $data);
                $ret = getAssign($rspString, $wechat_module);

                if(isset($ret['code'])) { //无响应为正常 反之异常
                    echo $ret['str']; exit;
                }

                $rspString = getResponse($wechat_module, 'showone', $data);
                $ret = getAssign($rspString, $wechat_module);
                if($ret['result']) {
                    $param = [
                        'logintime' => $ret['login_time'],
                        'loginipaddr' => $ret['ip'],
                        'username' => $ret['name'],
                        'logintype' => 'wechat-webauth'
                    ];
                    setcookie('logincookie', json_encode($param), time()+(24*3600*7) , '/');
                    header('location:/?type=wechat-webauth');
                    exit;
                }else {
                    setcookie('logincookie', '', time() - 3600 , '/');
                    header('location:http://www.sunyainfo.com');
                    exit;
                }
            }

            case 'wechat_signout': {
                $this->sign_out(true);
                break;
            }

            case 'keep_alive': {

                $name = $_POST['name'];
                $ip = $_POST['ip'];

                if(empty($name) || empty($ip)) {
                    echo json_encode(['code' => 0, 'info' => 'name or ip is null!']);
                }

                $wechat_module = 'wechat_user_auth';
                $rspString = getResponse($wechat_module, 'showone', [
                    'name' => $name,
                    'ip' => $ip,
                ]);
                $ret = getAssign($rspString, $wechat_module);

                if($ret['result']) {
                    $ret['online_time'] = (!$ret['online_time']) ? 1 : intval($ret['online_time']);
                    echo json_encode($ret);
                }else {
                    $this->sign_out(true);
                    echo json_encode(['result' => 0]);
                }
                exit;
                break;
            }

            default: {
                echo json_encode(['code' => 0, 'str' => 'api not found']); exit;
            }
        }
    }

    private function sign_out($inside = false) {

        $cookie_info = ($_COOKIE['logincookie'] && isset($_COOKIE['logincookie'])) ? json_decode($_COOKIE['logincookie'],true) : array();
        if(!$cookie_info){
            header("location:/");
        }

        $wechat_module = 'wechat_user_auth';
        $rspString = getResponse($wechat_module, 'del', [
            'ip' => $cookie_info['loginipaddr'],
            'name' => $cookie_info['username'],
        ]);
        getAssign($rspString, $wechat_module);
        setcookie('logincookie', '', time() - 3600 , '/');

        if(!$inside) {
            echo '/?type=wechat-webauth';
            exit;
        }
    }

    protected function aes_decrypt($encrypt){
        $key = 'sunyainfo';
        return openssl_decrypt($encrypt, 'AES-128-CBC', $key, 0, $key);
    }
}

(new wechat_webauth()) -> run();
