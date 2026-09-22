<?php
namespace lib;
use lib\LoginImp;
use lib\ArrayMap;
use lib\ArrayList;
use message\EngineWrapper;

define('OT_SHOW', 'show');

class LoginHandler{
	static function login($usr, $pwd, $num, $lang, $logintype=0) {
		//unset($_SESSION[LOGINSTATE]);
		unset($_SESSION[LOGIN_FAIL]);
		unset($_SESSION['language_checked']);
		$login = LoginImp::getInstance();
		// 返回包含两个元素的array，第一个表示是否为验证成功；
		// 如果是，第二个为用户级别，否则为错误信息

		$result = $login->login($usr, $pwd, $num, $lang, $logintype);

		$_SESSION[LEVEL] = $result[1];//var_dump($result);
		if (!$result[0]) {
			$_SESSION[LOGIN_FAIL] = 1;
			if ($num != '####') {
				self::fail();
			}
			return ;
		}
		
		//保存状态
		if($result['admin_user_type']!=-1){
			$_SESSION['admin_user_type'] = $result['admin_user_type'];
		}
		if ($result['force_change_password']=='1'||$result['force_change_password']=='2'||$result['force_change_password']=='3') {
			$_SESSION[LOGIN_FAIL] = 1;
			$_SESSION[LEVEL] = 'force_change_password';
			$_SESSION['FORCE_PARAM'] = $result['force_change_password'];
			return;
		}
		$_SESSION[LOGINSTATE] = 'set';
		
		$_SESSION[CONNECTION.USERNAME] = $usr;
		$_SESSION[CONNECTION.PASSWORD] = $pwd;
		$_SESSION['ADMIN_OPT_ENABLE'] = $result['admin_otp_enable'];													  

	}
	
	static function isLoginFail() {
		$fails = $_SESSION[LOGIN_FAIL];

		unset($_SESSION[LOGIN_FAIL]);
		return isset($fails) && $fails > 0;
	}

	static function fail() {
		/*
		$ret = array('code' => '-1009', 'str' => 'vcode error');
		echo json_encode($ret);
		exit(0);
		*/
	}

	static function is_verycode() {
		$data = new ArrayMap();
		// $data['username'] = $usr;
		// $data['password'] = $pwd;
		// $data['language'] = $lang;
		$data['ip_addr'] = $_SERVER['REMOTE_ADDR'];
		$data['vsysid'] = $_SERVER['VSYSID'];
		
		$list = new ArrayList();
		$list[] = $data;
		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$module = 'admin_verification';
				$res = $engine->process_request($module, OT_SHOW);
				return $res;				
			} catch (SocketException $e) {
			}
		}
	}

	static function logout($passive = true) {
		if ($passive) {
			LoginImp::getInstance()->logout();
		}

		self::delete_session();
		
		self::fail();
	}

	private static function delete_session() {
		$_SESSION = array();
		
		if (isset($_COOKIE[session_name()])) {
		    setcookie(session_name(), '', time() - 42000, '/');
		}

		$path = '/mnt/boot/sso_key.json';
		if (file_exists($path)) {
			unlink($path);
		}
		
		session_destroy();
	}

}
