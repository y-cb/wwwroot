<?php
namespace controller\login;

class SSOController {
	public $file_path = '/mnt/boot/sso_key.json';
	function get() {
		//获取token字段
		$token = session_id();
		session_start();
		// $_session["IS_SUPER"] = 1;
		//验证是否为矩阵发送的请求
		$host = $_SERVER['REMOTE_ADDR'];
		$header = getallheaders();
		$type = $header['Type'];
		$auth = $header['Authorization'];



		if (($host === '127.0.0.1' && $auth === '0')||($auth === '0' && $type === 'CloudEmpower')) {
			file_put_contents($this->file_path,json_encode($token));
			$msg = array('code'=>'0','token'=>$token);
		} else {
			$msg = array('code'=>'-1','str'=>'invalid field');
		}
		echo json_encode($msg);
		exit(0);
	}
}