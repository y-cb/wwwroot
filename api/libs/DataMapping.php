<?php
namespace lib;
use lib\LocalUtil;
use lib\ArrayMap;
use lib\ArrayList;

/**
 * 处理数据的映射转换
 */
class DataMapping {
	private static $mapping = null;

	const FLAG_TO_ENGINE = 0;
	const FLAG_FROM_ENGINE = 1;
	const FLAG_FROM_PAGE = 2;

	/**
	 * $datapath 与被转换数据对应的信息路径
	 * $data 要转换的数据
	 * $forshow 有以下值：
	 * 		FLAG_TO_ENGINE 表示向引擎提交数据时的转换
	 * 		FLAG_FROM_ENGINE 表示接收引擎数据时的转换
	 * 		FLAG_FROM_PAGE 表示接收界面数据时的转换
	 */
	static function convert($datapath, $data, $forshow) {
		if (!($data instanceof ArrayMap 
				|| $data instanceof ArrayList)) {
			return true;
		}
		
		/*if (is_null(self::$mapping)) {
			require(dirname(__FILE__) . '/mapping_def.php');
		}*/
		
		$key = self::genKey($datapath);
		$arr = self::$mapping[$key];
		if (is_null($arr))
			return true;
		
		$funname = $arr[0];
		$fundef = $arr[1];
		require_once($fundef);
		
		return $funname($data, $forshow);
	}
	
	static function getResource($resid) {
		return LocalUtil::getResource($resid, dirname(__FILE__) . '/DataMapping');
	}
	
	static function htmlEntitiesConvert($data, $encode, $charset = "utf-8") {
		if ($data instanceof ArrayMap 
				|| $data instanceof ArrayList 
				|| is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = self::htmlEntitiesConvert($v, $encode);
			}
		} else if (is_string($data)) {
			$data = $encode ? htmlentities($data, ENT_QUOTES, $charset) : html_entity_decode($data, ENT_QUOTES, $charset);
		}
		return $data;
	}
	
	private static function genKey($datapath) {
		$arr = explode('/', $datapath);
		$ret = '';
		$cat = '';
		for ($i = 0; $i < count($arr); $i++) {
			$ret .= $cat;
			$cat = '/';
			if (0 == ($i % 2)) {
				$ret .= $arr[$i];
			} else {
				$ret .= '*';
			}
		}
		
		return $ret;
	}
}

?>
