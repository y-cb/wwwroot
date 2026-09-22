<?php
namespace controller\login;
use lib\LoginHandler;

/**
 * @api {GET} /api/logout  注销
 * @apiName 注销
 * @apiGroup 登录认证
 */

class LogoutController{
	function get(){
		LoginHandler::logout();
	}
}
