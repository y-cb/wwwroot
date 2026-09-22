<?php
namespace controller\login;

class SSOAuthController {
	public $file_path = '/mnt/boot/sso_key.json';
	function get() {
		if (file_exists($this->file_path)) {
			$data = file_get_contents($this->file_path);
			$data = json_decode($data);
		}
        //验证是否为矩阵发送的请求
        $host = $_SERVER['REMOTE_ADDR'];
        $auth = getallheaders();
        $auth = $auth['Authorization'];

		if ($data && $host === '127.0.0.1' && $auth === '0') {
			session_id($data);
			session_start();
			$msg = array('username'=>'admin','token'=>$data);
			echo json_encode($msg);
		}
	}
}