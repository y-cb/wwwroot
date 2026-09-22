<?php
namespace lib;
use message\EngineWrapper;
use lib\ArrayList;
use lib\ArrayMap;

define('OT_SHOW', 'show');
define('OT_DELETE', 'del');

class ConfigLogin {
	function login($usr, $pwd, $num, $lang, $logintype) {
		$level = array();
		$level[0] = false;


		if (($_SESSION[CONFIG_CHECKNUM] != $num) || (!isset($_SESSION[CONFIG_CHECKNUM]))) {
			$level[1] = "check_num_error";
			$level[0] = 0;

			return $level;

		}
	
		unset($_SESSION[CONFIG_CHECKNUM]);
		$data = new ArrayMap();
		$data['username'] = $usr;
		$data['password'] = $pwd;
		$data['language'] = $lang;
		$data['ip_addr'] = $_SERVER['REMOTE_ADDR'];
		$data['vsysid'] = $_SERVER['VSYSID'];
		$data['type'] = $logintype;
		if(isset($_SERVER['SSL_CLIENT_S_DN'])){
			$data['ssl_dn'] = $_SERVER['SSL_CLIENT_S_DN'];
		}else{
			$data['ssl_dn']="";
		}
								
		$list = new ArrayList();
		$list[] = $data;
		
		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$module = 'admin_authen_login';
				$res = $engine->process_request($module, OT_SHOW, $list);
				$level[0] = (0 == $res[0]);
				if ($level[0]) {
					$level[1] = $res[1][$module][0]['level'];
					$level['admin_user_type'] = $res[1][$module][0]['admin_user_type'];
					$level['force_change_password'] = $res[1][$module][0]['force_change_password'];
					$level['admin_otp_enable'] = $res[1][$module][0]['admin_otp_enable'];													  
				} else {
					$level[1] = $res[1]["return_code"][0]["str"];
					$level['admin_user_type'] = -1;
					$level['force_change_password']=-100;
					$level['admin_otp_enable'] =0;			   
				}
			} catch (SocketException $e) {
			}
		}
		
		return $level;
	}
	function logout() {
		$data = new ArrayMap();
		$data['username'] = $_SESSION[CONNECTION.USERNAME];
		$data['ip_addr'] = $_SERVER['REMOTE_ADDR'];
		
		$list = new ArrayList();
		$list[] = $data;
		
		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$module = 'admin_authen_logout';
				$res = $engine->process_request($module, OT_DELETE, $list);
			} catch (SocketException $e) {
			}
		}
	}
}
