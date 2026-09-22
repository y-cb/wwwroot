<?php
namespace controller\system;
use lib\LoginHandler;

/**
 * @api {GET} /api/logout  注销
 * @apiName 注销
 * @apiGroup 登录认证
 */

class AnHengLogoutController{
	function get(){
		$param = get_inputs();

		if (empty($_SESSION[CONNECTION.USERNAME])) {
			$ret = array('code'=>'0','msg'=>'not login');
			echo json_encode($ret);
			exit;
		}
		if (!$param['userId'] || $_SESSION[CONNECTION.USERNAME] !== $param['userId']) {
			$ret = array('code'=>'0','msg'=>'invalidate field');
			echo json_encode($ret);
			exit;
		}

		LoginHandler::logout();
		$ret = array('code'=>'1','msg'=>'success');
		echo json_encode($ret);	
	}
}
