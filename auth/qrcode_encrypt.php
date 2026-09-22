<?php
if($_SERVER[SERVER_PORT]!=8000&&$_SERVER[SERVER_PORT]!=8043){
	header('Location:/login.html');
	return;
}
require_once '../vendor/autoload.php';
require_once '../common/config.inc';
require_once '../common/common.inc';
require_once '../common/func.inc';
require_once '../common/cfgeng.inc';

use lib\QRcode;

$tmp_file_path = '/tmp/qrcode_auth.json';
$module = "qrcode_user_auth";

if($_GET['act'] == 'qrcode_generate'){
	$time = time();
	//获取参数
	if($_GET['ip'])$ip = htmlspecialchars($_GET['ip']);
	if($_GET['time'])$time += htmlspecialchars($_GET['time']);
	$protocol = (isset($_SERVER[HTTPS]) && $_SERVER[HTTPS]== 'on') ? 'https': 'http';
	$qrcode_url = $protocol . '://' . $_SERVER[SERVER_NAME] . ':'. $_SERVER[SERVER_PORT] . '/register.html?ip='.$ip.'&time='.$time;
	QRcode::png($qrcode_url, false, "L", 6);
}

if($_GET['act'] == 'qrcode_login_status'){
	$time = time();
	//获取参数
	if($_POST['ip'])$ip = htmlspecialchars($_POST['ip']);

	if (file_exists($tmp_file_path)) {
		$json = file_get_contents($tmp_file_path);
		if ($json) {
			$data = json_decode($json, true);
		}

		if ($data[$ip] && !empty($data[$ip]) && !empty($data[$ip.'_audit_ip'])) {
			$param['visit_ip'] = $ip;
			$param['visitor'] = $data[$ip];

			$rspString = getResponse($module , "showone" , $param );
			$ret = getAssign($rspString, $module);

			if($ret['result'] == '1') {
				$ret['login_time'] = (!empty($ret['login_time']))? $ret['login_time']: date("Y-m-d H:i:s");
				echo $ret['name'] . '&' . $ret['ip'] . '&' . $ret['login_time'] . '&' . $ret['online_time'];
				return;
			} else {
				unset($data[$ip]);
				unset($data[$ip.'_audit_ip']);
				@file_put_contents($tmp_file_path, json_encode($data));
				echo '0';
				return;
			}
		}
	}
	echo '0';
	return;
}

if($_GET['act'] == 'qrcode_logout'){
	$time = time();
	//获取参数
	if($_POST['ip'])$param['visit_ip'] = htmlspecialchars($_POST['ip']);
	if($_POST['name'])$param['visitor'] = htmlspecialchars($_POST['name']);

	$rspString = getResponse($module , "del" , $param );
	$ret = getAssign($rspString, $module);

	if(!$ret['code']){
		if (file_exists($tmp_file_path)){
			if ($json) {
				$data = json_decode($json, true);
			}
			unset($data[$param['visit_ip']]);
			unset($data[$param['visit_ip'].'_audit_ip']);
			@file_put_contents($tmp_file_path, json_encode($data));
		}
	} else {
		echo '0#' . $ret['err_msg'];
	}

	return;
}
