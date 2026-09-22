<?php
namespace controller\system;
use controller\mController;

class CASEditController extends mController {
	public $cas_path = '/mnt/boot/cas.json';
	public $cas_log_path = '/tmp/cas.log';
	function post() {
		$arr = get_inputs();

		$casServer = $arr['casServerUrlPrefix'];
		$casloginurl = $arr['casServerLoginUrl'];
		$service = $arr['service'];

		if (!$casServer || !$casloginurl || !$service) {
			$ret = array('code'=>'0','msg'=>'invalidate field!');
			echo json_encode($ret);
			exit;	
		}

		/*if (!file_exists($cas_log_path)) {
			$casstr = 'echo -e 时间：' . date('Y-m-d H:i:s') . ' 用户：' . $_SESSION[CONNECTION.USERNAME] . ' 添加配置： casServerUrlPrefix：' . $casServer . ',casServerLoginUrl:' . $casloginurl . ',service:' . $service . '>/mnt/boot/cas.log';
		} else {
			$casstr = 'echo -e 时间：' . date('Y-m-d H:i:s') . ' 用户：' . $_SESSION[CONNECTION.USERNAME] . ' 添加配置： casServerUrlPrefix：' . $casServer . ',casServerLoginUrl:' . $casloginurl . ',service:' . $service . '>>/mnt/boot/cas.log';			
		}
		exec($casstr);
		exec('sync');*/
		
		$casstr = '时间：' . date('Y-m-d H:i:s') . ' 用户：' . $_SESSION[CONNECTION.USERNAME] . ' 添加配置： casServerUrlPrefix：' . $casServer . ',casServerLoginUrl:' . $casloginurl . ',service:' . $service . "\n";
		@file_put_contents($this->cas_log_path, $casstr, FILE_APPEND);
		/*$str = file_get_contents($cas_path);
		$arr = json_decode($str,true);*/
		
		$item['cas_server'] = $casServer;
		$item['cas_login'] = $casloginurl;
		$item['service'] = $service;

		$data = json_encode($item);
		file_put_contents($this->cas_path,$data);
		$ret = array('code'=>'1','msg'=>'success!');
		echo json_encode($ret);
		return;
	}
}