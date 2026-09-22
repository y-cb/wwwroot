<?php
require_once '../common/config.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once '../common/cfgeng.inc';

$cookieInfo = ($_COOKIE['logincookie'] && isset($_COOKIE['logincookie'])) ? json_decode($_COOKIE['logincookie'],true) : array();
if(!$cookieInfo){
	header("location:/");
	return;
}
if($_POST['submit']=='webauthloginout'){
	$DEMO_DATA = 0;
	$param['logoutipaddr'] = $cookieInfo['loginipaddr'];
	$param['secret'] = $cookieInfo['secret'];
	$param['vsysid'] = $_SERVER['VSYSID']? $_SERVER['VSYSID']: 0;
	$rspString = getResponse( "webauthlogout", "mod" , $param );
	setcookie("logincookie", "", time() - 3600, "/");
	header("location:/");
}
if($_POST['submit']=='webmsgloginout'){
	$module = 'sms_user_auth';
	$DEMO_DATA = 0;
	$param['name'] = $cookieInfo['username'];
	$param['ip'] = $cookieInfo['loginipaddr'];

	$rspString = getResponse( $module, "del" , $param );
	setcookie("logincookie", "", time() - 3600, "/");
	header("location:/?type=sms-webauth");
}
if($_POST['submit']=='freewebauthloginout'){
	$module = 'free_user_auth';
	$DEMO_DATA = 0;
	$param['name'] = $cookieInfo['username'];
	$param['ip'] = $cookieInfo['loginipaddr'];

	$rspString = getResponse( $module, "del" , $param );
	setcookie("logincookie", "", time() - 3600, "/");
	header("location:/?type=free-webauth");
}