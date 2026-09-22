<?php
namespace controller\login;
use lib\phpCAS;

class SSOLoginController{
	public $file_path = '/mnt/boot/sso_key.json';
	public $cas_path = '/mnt/boot/cas.json';
	public $host_path = '/mnt/boot/hosts';
	public $token_path = '/mnt/boot/token.json';
	function get() {
		//获取参数
		$token = addslashes($_GET['token']);
		$auth = base64_decode($_GET['Authorization']);
		$type = base64_decode($_GET['Type']);
		$language = addslashes($_GET['lang'])=='cn'?'1':'0';
		$proxy = addslashes($_GET['proxy']);
		/*$header = getallheaders();
		$auth = $header['Authorization'];
		$type = $header['Type'];*/
		//验证token字段是否为sso接口返回token
		$host = $_SERVER['REMOTE_ADDR'];

		if ($host === '127.0.0.1' || ($type=== 'CloudEmpower' && $auth=='0')) {
			$data = file_get_contents($this->file_path);
			$data = json_decode($data);
			if ($data === $token || $this->token_check($token)) {
				//设置超级session_id
				// $_SESSION[IS_SUPER] = 1;
				session_start();
                session_id($token);

				$param = array(
					'username' => 'admin',
					// 'password' => '',
					'language' => '1',
					'ip_addr' => $_SERVER['REMOTE_ADDR']
				);
				$res = getResponse('cloud_platform_login', 'show', $param);
				getResponse('language_cfg',"mod",array('language'=>$language));
				//$this->set_token();
				//unlink($this->file_path);

				$_SESSION[LOGINSTATE] = 'set';
				$_SESSION[CONNECTION.USERNAME] = 'admin';
				setcookie("username","admin",time()+3600,"/");
				setcookie("token",$token,time()+3600,"/");
				setcookie("PHPSESSID",$token,time()+3600,"/");
				setcookie("proxy",$proxy,time()+3600,"/");
				//header("Location:/#/sso");
				$cus_header = "Location:/?proxy=".$proxy."/#/sso";
				header($cus_header);
				return;
			} else {
				$msg = array('code'=>0,'str'=>'token is invalid');
			}
		} elseif(file_exists($this->cas_path) && file_exists($this->host_path)){
		    //CAS单点登录流程
		    $cas = '';
            self::set_host();

            $cas_str = file_get_contents($this->cas_path);
            $cas_arr = json_decode($cas_str,true);
            $s_arr = explode(':',$cas_arr['cas_server']);
            $arr = explode('/',$s_arr[2]);
            if (count($arr) != 1) {
                unset($arr[0]);
                //防止cas服务器目录为多层
                foreach($arr as $v){
                    $cas .= $v.'/';
                }
                $cas = substr($cas,0,(strlen($cas)-1));
            } else {
                $cas = 'cas-server';
            }

            $casServer = substr($s_arr[1],2,strlen($s_arr[1]));
            $port = intval($s_arr[2]);
            $login_url = $cas_arr['cas_login'].'?service='.$cas_arr['service'];

            $auth = self::cas_init($casServer, $port, $cas, $login_url, $cas_arr['service']);
            if ($auth['loginName'] && $auth['lesseeId']) {
                $_SESSION[LOGINSTATE] = 'set';
                $_SESSION[CONNECTION.USERNAME] = $auth['loginName'];
                $_SESSION[CONNECTION.PASSWORD] = $auth['loginName'];
                $info = self::login_secess();
                session_id($info['token']);
                setcookie("username", $auth['loginName'],time()+3600,"/");
                setcookie("token",session_id(),time()+3600,"/");
            	/*unlink($this->cas_path);
				unlink($this->host_path);*/
                header("Location:/#/sso");
                return;
            }

		} else {
		    $msg = array('code'=>0,'str'=>'host is wrong');
		}
		echo json_encode($msg);
		exit(0);
	}
	/*function post () {
		//获取post参数
		parse_str(file_get_contents('php://input'), $data);
		$user = LoginController::ase_decrypt($data['username']);
		$pwd = LoginController::ase_decrypt($data['password']);
		// $token = $data['token'];
		if (!$user || !$pwd){
			$msg = array('code'=>0,'str'=>'invalid filed!');
		} else {
			session_start();
			$_SESSION[CONNECTION.USERNAME] = $user;
			$_SESSION[CONFIG_CHECKNUM] = '####';

			LoginHandler::login($user, $pwd, '####', LOCAL_EN);

			if (LoginHandler::isLoginFail()) {
				$fail_msg = $_SESSION[LEVEL];
				if (strlen($fail_msg) <= 0) {
					$fail_msg = LocalUtil::getCommonResource('login_failed');
				}
				$msg = array('code' => '-1001', 'str' => $fail_msg);
			}
		}
		if (empty($msg)) {
			$data = array('username' => $user,'token'=> session_id());
			file_put_contents($this->file_path,json_encode($data));
		} else {
			echo json_encode($msg);
			exit(0);
		}
	}*/
	function delete() {
		if (file_exists($this->file_path)) {
			unlink($this->file_path);
			unset($_SESSION);
			LoginHandler::logout();
		}
		exit(0);
	}

	protected function token_check($token) {
		$token_path = '/mnt/boot/token.json';
		if(!$token || !file_exists($token_path)){return false;}
		$json = file_get_contents($token_path);
		$token_list = json_decode($json, true);
		foreach ($token_list as $value) {
			if ($token === $value['token']) {
				return true;
			}
		}
		return false;
	}
	private function set_host(){

    	if(!file_exists($this->host_path)) {
    		return;
    	}

    	$cfg_str = file_get_contents($this->host_path);
    	@file_put_contents('/etc/hosts', $cfg_str);
    	return;
    }

    private function cas_init($casServer, $port, $cas, $loginUrl, $casService) {
    	// Enable verbose error messages. Disable in production!
    	phpCAS::setVerbose(true);
    	phpCAS::client(CAS_VERSION_2_0,$casServer,$port, $cas);

    	phpCAS::setNoCasServerValidation();
    	phpCAS::setDebug('/usr/local/wwwroot/phpcas.log');

    	phpCAS::handleLogoutRequests(true, array($casServer));
    	// force CAS authentication
    	phpCAS::setServerLoginURL($loginUrl);  //......client......
    	phpCAS::SetFixedServiceURL($casService);
    	phpCAS::forceAuthentication();
    	return phpCAS::getAttributes();
    }

    private function set_token() {

    	if (file_exists($this->token_path)) {
    		$json = file_get_contents($this->token_path);
    		$data = json_decode($json, true);
    	}

    	$data[] = array('token'=> session_id());
    	@file_put_contents($this->token_path, json_encode($data));
    	return;
    }
    private static function login_secess(){
    	$token_file = '/mnt/boot/token.json';
        $rstr = '';
        $m = 32;
        $arr = array();
        $str = 'abcdefghijklmnopqrstuvwsyz0123456789';
        $max = strlen($str) - 1;
        for ($i = 1; $i <= $m; $i++) {
            $rstr .= $str[mt_rand(0, $max)];
        }

        if (file_exists($token_file)) {
            $str = file_get_contents($token_file);
            $arr = json_decode($str);
        }

        $item = array('token' => $rstr);
        $arr[] = $item;
        $json = json_encode($arr);
        file_put_contents($token_file, $json);

        return $item;
    }
}

