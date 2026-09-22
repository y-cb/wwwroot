<?php
namespace message;
use message\SocketException;
use message\EngineWrapper;
use lib\DataMapping;
use lib\Util;
use lib\ArrayMap;
use lib\ArrayList;
use lib\LoginHandler;
/**
 * 配置信息模型
 */
class MainModel {
	/**
	 * 给url附加主键值参数
	 * $url 要附加参数url
	 * $module 模块名
	 * $data 与模块名对应的一条配置信息
	 */
	static function appendPrimaryValue($url, $module, $data) {
		$value = self::getPrimaryValue($module, $data);
		if (isset($value)) {
			$url = add_param($url, PRIMARY_VALUE_KEY . '=' . rawurlencode($value));
		}
		
		return $url;
	}
	
	/**
	 * 返回模块的主索引，对应show_i动作
	 * 供页面显示使用，所以做了HTMLEncoding处理
	 */
	static function getDataIndex($module, $filter = NULL) {
		$data = NULL;
		if (isset($filter)) {
			$data = new ArrayList();
			$data[] = $filter;
		}
		$data = self::communicate($module, OT_SHOW_I, $data);
		return DataMapping::htmlEntitiesConvert($data, true);
	}

	/**
	 * 获取映射转换之后的配置信息
	 * 供页面显示使用，所以做了HTMLEncoding处理
	 */
	static function getConvertedData($module, $filter = NULL) {
		$data = self::getConvertedDataWithoutHtmlEntConvert($module, $filter);
		return DataMapping::htmlEntitiesConvert($data, true);
	}

	/**
	 * 获取映射转换之后的配置信息
	 * 不做HTMLEncoding处理
	 */
	static function getConvertedDataWithoutHtmlEntConvert($module, $filter = NULL) {
		$data = self::fetchData($module, $filter);
		DataMapping::convert($module, $data, DataMapping::FLAG_FROM_ENGINE);
		
		return $data;
	}
	
	/**
	 * 供TempModel根据主键获取信息使用
	 */
	static function getConvertedData_O($module, $pri) {
		$key = self::getPrimaryKey($module);
		$filter = self::decodePrimaryValue($key, $pri);
		$filter = DataMapping::htmlEntitiesConvert($filter, false);
		
		$r = self::fetchData_O($module, $filter);
		if (isset($r)) {
			DataMapping::convert($module, $r, DataMapping::FLAG_FROM_ENGINE);

			if ('/' != DIRECTORY_SEPARATOR) {
				$n = NULL;
				foreach ($r as $v) {
					if (self::primaryEqual($v, $key, $filter)) {
						$n = $v;
						break;
					}
				}
				$r = $n;
			} else {
				$r = $r[0];
			}
		}

		return $r;
	}
	
	/**
	 * 更新配置信息
	 * $module 功能模块名
	 * $optype 更新方式
	 * $data 数据
	 */
	static function updateData($module, $optype, $data) {
		DataMapping::convert($module, $data, DataMapping::FLAG_TO_ENGINE);
		
		if (true) {
			$t = new ArrayMap();
			$t[$module] = $data;
			$_SESSION[SUBMITED_DATA] = serialize($t);
		}
		
		return self::communicate($module, $optype, $data);
	}
	
	/**
	 * 执行版本升级，包括软件、ips库、av库
	 * $updatetype 升级类型，指示进行什么的升级
	 * $updatefile 升级包文件
	 */
	static function updateVersion($updatetype, $updatefile) {
		$res = array(DEFAULT_ERROR, null);
		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$res = $engine->process_update($updatetype, $updatefile);
			} catch (SocketException $e) {
			}
		}
		
		$res_data=self::dealError("update", $updatetype, $res);
		
		return $res_data;
	}
	
	/**
	 * 更新配置，包括系统配置,ips配置,av配置等
	 * $configtype 配置类型
	 * $configfile 配置文件
	 */
	static function updateConfig($configtype, $configfile) {
		$res = array(DEFAULT_ERROR, null);
		
		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$res = $engine->process_config($configtype, $configfile);
			} catch (SocketException $e) {
			}
		}
		
		$res_data=self::dealError("restore config", $configtype, $res);
		return $res_data;
	}
	
	/**
	 * 获取配置，包括系统配置,ips配置,av配置等
	 * $configtype 配置类型
	 */
	static function fetchConfig($configtype) {
		$res = array(DEFAULT_ERROR, null);

		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$res = $engine->process_config($configtype);
			} catch (SocketException $e) {
			}
		}	
		self::dealError("export config", $configtype, $res);
		
		$data = null;
		if (is_string($res[1])) {
			$data = $res[1];
		}
		
		return $data;
	}
	
	/**
	 * 返回配置信息的主键值
	 * $module 模块名
	 * $data 与模块名对应的一条配置信息
	 */
	static function getPrimaryValue($module, $data) {
		$key = self::getPrimaryKey($module);

		$value = self::encodePrimaryValue($key, $data);
		if (strlen($value)) {
			return $value;
		}
		
		return null;
	}
	
	/**
	 * 从引擎获取模块的配置信息
	 * $module 模块名
	 * $filter 过滤使用的条件，类型为arraymap，
	 * 		如果是null则不进行过滤
	 */
	private static function fetchData($module, $filter) {
		$data = NULL;
		if (isset($filter)) {
			$data = new ArrayList();
			$data[] = $filter;

			if (true) {
				$t = new ArrayMap();
				$t[$module] = $data;
				$_SESSION[SUBMITED_DATA] = serialize($t);
			}
		}
		
		return self::communicate($module, OT_SHOW, $data);
	}
	
	/**
	 * 从引擎获取一条配置信息
	 * 参数$module 指定哪个模块
	 * 参数$key 指定配置信息的主键
	 */
	private static function fetchData_O($module, $filter) {
		$data = new ArrayList();
		$data[] = $filter;
		
		return self::communicate($module, OT_SHOW_O, $data);
	}
	
	/**
	 * 与引擎通讯的集中入口
	 */
	private static function communicate($module, $type, $data) {
		self::checkRight($module, $type, $data);
		$res = array(DEFAULT_ERROR, null);
		
		$engine = EngineWrapper::instance();
		if (isset($engine)) {
			try {
				$res = $engine->process_request($module, $type, $data);
			} catch (SocketException $e) {
			}
		}
		
		self::dealError($module, $type, $res);
		
		$data = null;
		if ($res[1] instanceof ArrayMap) {
			$data = $res[1][$module];
		}
		
		return $data;
	}

	/**
	 * 审计管理员特殊处理
	 */
	private static function checkRight($module, $type, $data) {
		$page_display = new ArrayMap();
		$page_display = Util::getPageDisplay();
		if('audit' == $page_display['name']) {
			$res = array(264, null);
			$audit_right = getRights(2);
			if (!in_array($module, $audit_right)) {
				self::dealError($module, $type, $res);
			}
		}
	}
	
	/**
	 * 进行错误处理
	 */
	private static function dealError($module, $optype, $res) {
		$code = $res[0];
		if (0 == $code){
			$res_data['code']=0;
			$res_data['str']="ok";
			return $res_data;
		}

		if (30000 == $code) {
			LoginHandler::logout(false);
			return;
		}
		
		$emb = $_SESSION[ERROR_MSG_BUNDLE_KEY];
		if (isset($emb)) {
			$emb = unserialize($emb);
		} else {
			$emb = array();
		}
		$res_data['code'] = $res[1]['return_code'][0]["code"];
		$res_data['str'] = $res[1]["return_code"][0]["str"];
		$emb[$code] = $res[1]["return_code"][0]["str"];
		$_SESSION[ERROR_MSG_BUNDLE_KEY] = serialize($emb);
		return $res_data;
		
		//如果是保存配置的时候出错，跳到处理页面
		/*if ('save_config' == $module) {
			//$url = $_GET["dest"] . '&res=' . $code;
			$_SESSION['sc_error_code'] = $code;
			$url = $_GET["dest"];
		} else {
			$url = '/common/msg.php?code=' . $code;
		}
		redirect(server_url($url));*/
	}
	
	private static $primaryKeys = null;
	private static function initPrimaryKeys() {
		require_once(dirname(__FILE__) . '/primary_def.php');
	}
	
	/**
	 * 返回模块的主键名
	 * $module 模块名
	 */
	static function getPrimaryKey($module) {
		if (is_null(self::$primaryKeys)) {
			self::initPrimaryKeys();
		}
		return self::$primaryKeys[$module];
	}
	
	private static function primaryEqual($item, $key, $filter) {
		$arr = explode(',', $key);
		foreach ($arr as $k) {
			if ($item[$k] != $filter[$k]) {
				return false;
			}
		}
		return true;
	}
	
	private static function encodePrimaryValue($key, $data) {
		$value = '';
		if (isset($key)) {
			$cat = '';
			$arr1 = explode(',', $key);
			foreach ($arr1 as $k) {
				$value .= $cat;
				$cat = ',';
				$value .= self::encode('/', '@', self::encode(',', '#', $data[$k]));
			}
		}
		return $value;
	}
	static function decodePrimaryValue($key, $value) {
		if (!self::matchPrimary($key, $value)) {
			throw new UnexpectedValueException('primary key "'.$key.'" not match value '.$value.'.');
		}

		$data = new ArrayMap();
		$arr1 = explode(',', $key);
		$arr2 = explode(',', $value);
		foreach ($arr1 as $idx => $k) {
			$data[$k] = self::decode('#', ',', self::decode('@', '/', $arr2[$idx]));
		}
		return $data;
	}
	private static function matchPrimary($key, $value) {
		if (isset($key, $value)) {
			$arr1 = explode(',', $key);
			$arr2 = explode(',', $value);
			return count($arr1) == count($arr2);
		}
		return false;
	}
	/**
	 * 把$value中的$search替换成$replace，规则为
	 * - -> -;
	 * $search -> -$replace
	 */
	private static function encode($search, $replace, $value) {
		$esc1 = '-';
		$esc2 = '-;';
		$value = str_replace($esc1, $esc2, $value);
		$value = str_replace($search, $esc1.$replace, $value);
		return $value;
	}
	private static function decode($search, $replace, $value) {
		$esc1 = '-';
		$esc2 = '-;';
		$value = str_replace($esc1.$search, $replace, $value);
		$value = str_replace($esc2, $esc1, $value);
		return $value;
	}
}
?>
