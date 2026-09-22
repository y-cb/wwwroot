<?php
namespace controller\system;
use controller\mController;

class HostEditController extends mController{
	public $host_path = '/etc/hosts';
	public $file_path = '/mnt/boot/hosts';
	public $log_path = '/tmp/host.log';
	
	function post() {
		$arr = get_inputs();

		$ip = $arr['ip'];
		$domain = $arr['domain'];

		if (!$ip || !$domain) {
			$ret = array('code' => '0','msg' => 'invalidate field');
			echo json_encode($ret);
			exit;
		}
		//在保存默认配置基础上，添加配置名单
		$data = "127.0.0.1 localhost.localdomain localhost \n";
		$data .= $ip . '  ' . $domain ."\n";

		file_put_contents($this->host_path, $data);
		file_put_contents($this->file_path, $data);

		/*$file_path = '/mnt/boot/hosts';
		$str_copy = 'echo -e "127.0.0.1 localhost.localdomain localhost \n"'.$ip . '  ' . $domain . '>/mnt/boot/hosts';
		exec($str_copy);
		exec('sync');*/

		$str = '时间：' . date('Y-m-d H:i:s') . ' 用户：' . $_SESSION[CONNECTION.USERNAME] . ' 添加配置： ip：' . $ip . ',domain：' . $domain . "\n";
		
		/*if (!file_exists($log_path)) {
			
		} else {
			$str = "echo -e \"时间：" . date('Y-m-d H:i:s') . ' 用户：' . $_SESSION[CONNECTION.USERNAME] . ' 添加配置： ip：' . $ip . ',domain：' . $domain . "\n\">>/mnt/boot/host.log";			
		}*/
		file_put_contents($this->log_path, $str, FILE_APPEND);
		if (file_exists($this->file_path)) {
			$ret = array('code'=>'1','msg'=>'success');
		}  else {
			$ret = array('code'=>'0','msg'=>'config failed');
		}
		echo json_encode($ret);	
	}
}

?>
