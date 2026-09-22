<?php
namespace lib;
use lib\ConfigLogin;

define('WEB_AUTH_PREFIX', '/auth_');

class LoginImp {
	static function getInstance() {
		$php_self = $_SERVER['PHP_SELF'];
		
		if (WEB_AUTH_PREFIX == substr($php_self, 0, strlen(WEB_AUTH_PREFIX))) {
			$t = new WebAuthLogin();
		} else {
			$t = new ConfigLogin();
		}
		return $t;
	}
}
