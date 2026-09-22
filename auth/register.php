<?php
if($_SERVER[SERVER_PORT]!=8000&&$_SERVER[SERVER_PORT]!=8043){
	header('Location:/login.html');
	return;
}
require_once '../common/config.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once '../common/cfgeng.inc';

if($_GET['act']=='register'){
	$tmp_file_path = '/tmp/qrcode_auth.json';
	if($_POST['visitor']) $param['visitor'] = formatpost($_POST['visitor']);
	if($_POST['visit_ip']) $param['visit_ip'] = formatpost($_POST['visit_ip']);
	$param['audit_ip'] = $_SERVER[REMOTE_ADDR];

	// $_SESSION[CONNECTION.ISUPER] = true;

	$module = "qrcode_user_auth";
	$rspString = getResponse($module , "show" , $param );
	$ret = getAssign($rspString, $module);
	if($ret['is_autidor'] == '1'/* && $ret['result'] == '1'*/){
		if(file_exists($tmp_file_path)) {
			$json = file_get_contents($tmp_file_path);
			if ($json) {
				$data = json_decode($json, true);
			}
		}
		$rspString_add = getResponse($module , "add" , $param );
		$ret_add = getAssign($rspString_add, $module);
		if($ret_add['code']!=0){
			echo '0#'.$ret_add['str'];
		}
		$data[$param['visit_ip']] = $param['visitor'];
		$data[$param['visit_ip'].'_audit_ip'] = $_SERVER[REMOTE_ADDR];
		@file_put_contents($tmp_file_path, json_encode($data));
		echo 'success';
	}else{
		echo '0#'.$ret['err_msg'];
	}
	return;
}
?>
