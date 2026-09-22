<?php
namespace lib;
use middleware\SessionInit;
use resource\Constants;
use lib\Resource;

class LocalUtil {
	static function getCurrentLocal() {
		// $local = $_SESSION[LOCAL_KEY];
		$filename = '/tmp/webui/lang.conf';
		$handle = fopen ($filename, "r");
		$contents = fread ($handle, filesize ($filename));		
		fclose ($handle); 
		$local=LOCAL_DEFAULT;
		if($contents=='1'){
			$local=LOCAL_EN;
		}else{
			$local=LOCAL_CN;
		}
		// if (is_null($local)) {
		// 	$local = LOCAL_DEFAULT;
		// }
		return $local;
	}
	static function setCurrentLocal($local) {
		// $old = $_SESSION[LOCAL_KEY];
		// $_SESSION[LOCAL_KEY] = $local;
		// return $old;
		// 英文lang.conf=1 中文lang.conf=2
		
		// if($local==LOCAL_EN){			
		// 	@$fp = fopen(dirname(dirname(__FILE__)).'/ui/lang.conf', 'w');
		// 	@flock($fp, 2);
		// 	@fwrite($fp, 1);
		// 	@fclose($fp);
		// }else{
		// 	@$fp = fopen(dirname(dirname(__FILE__)).'/ui/lang.conf', 'w');
		// 	@flock($fp, 2);
		// 	@fwrite($fp, 2);
		// 	@fclose($fp);
		// }
	}
	static function getResourceFile($resfile) {
		return $resfile . '_' . self::getCurrentLocal() . '.resource';
	}
	/**
	 * $resid 资源id
	 * $resfile 中性的资源文件名，不包含本地化后缀信息或扩展名
	 * 根据当前的local信息查找对应资源文件中与$resid对应的资源
	 */
	static function getResource($resid, $resfile = null) {
		if (is_null($resfile)) {
			$arr = explode('.', $_SERVER['PHP_SELF']);
			if (count($arr) > 1) {
				array_pop($arr);
			}
			$resfile = './' . basename(implode('.', $arr));
		}
		
		$resfile = self::getResourceFile($resfile);
		
		return Resource::fromFileValue($resid, $resfile);
	}
	/**
	 * $type  1:oem
	 */
	static function getCommonResource($resid, $type=null) {
		if($type == 1) 
			return self::getResource($resid, dirname(__FILE__) . '/oem');
		else
			return self::getResource($resid, dirname(__FILE__) . '/common');
	}
	static function getURIComponentResource($resid, $resfile = null) {
		//$res = self::getResource($resid, $resfile);
		 $res = self::getResource($resid, dirname(__FILE__) . '/common');
		return rawurlencode($res);
	}
	static function get_sys_language(){
		$fp = fopen('/tmp/webui/lang.conf', 'r');
		$reg_msg = fread( $fp, filesize('/tmp/webui/lang.conf'));
		fclose($fp);
		echo $ret_msg;
		if(strstr( $reg_msg, "1" ))
			return 'en';
		else
			return 'cn';
	}	
}

?>
