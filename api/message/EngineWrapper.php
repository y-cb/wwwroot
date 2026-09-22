<?php
namespace message;
use message\EngineImpl;
use message\UtmCmd;
use message\UtmEchoCmd;
use message\SocketException;
use lib\ArrayMap;
use lib\ArrayList;
use lib\DataCodec;
use message\Conn;
use lib\Util;

define("UCT_UNKNOWN",	0x00000000);           //未知数据
define("UCT_CMD",		0x00000001);           //命令
define("UCT_CMD_ECHO",	0x00000002);           //回应命令
define("UCT_UPDATE",	0x00000003);		   //升级命令
define("UCT_CONFIG",	0x00000004);	
define('OT_SHOW_I', 'show_i');

class EngineWrapper {
	private static $solo = NULL;
	
	/**
	 * 如果实例未创建，则创建实例并使用$ip和$port来初始化
	 * $ip	引擎Ip
	 * $port 引擎端口
	 */
	static function instance($ip = NULL, $port = NULL) {
		if (is_null(self::$solo)) {
			$impl = EngineImpl::getInstance();
			if (!$impl->init($ip, $port)) {
				unset($impl);
				return NULL;
			}
			
			$t = new EngineWrapper();
			$t->impl = $impl;
			self::$solo = $t;
		}
		
		return self::$solo;
	}
	/**
	 * 释放实例
	 */
	static function release() {
		unset(self::$solo);
	}
	
	private $impl = NULL;
	function __construct() {
	}
	function __destruct() {
		unset($this->impl);
	}

	/**
	 * 处理请求
	 * $modulename 功能模块名
	 * $optype 操作类型
	 * $data 附加数据
	 * 返回状态码或回应的数据结构体
	 * throw SocketException 
	 */
	function process_request($modulename, $optype, $data = array()) {
		//convert to xml
		$whole = new ArrayMap();
		$whole[$modulename] = $data;
		$xml = DataCodec::todom($whole, $optype);
		return $this->process_data(UCT_CMD, $modulename, $xml);
	}
	
	function fetech_objects($modulename, $filter) {
		$request = new ArrayMap();
		$data = null;
		if (isset($filter)) {
			$data = new ArrayList();
			$data[] = $filter;
		}
		$request[$modulename] = $data;
		
		$xml = DataCodec::todom($request, OT_SHOW_I);
		
		return $this->process_data(UCT_CMD, $modulename, $xml);
	}
	
	function process_update($updatetype, $updatefile) {
		// 直接把文件名传给GUISH
		return $this->process_data(UCT_UPDATE, $updatetype, $updatefile);
	}
	
	function process_config($configtype, $configfile = NULL) {
		$data = '';
		// 如果是配置导出，则不需要转换成dom
		$need_dom = isset($configfile);
		if (isset($configfile)) {
			$data = file_get_contents($configfile);
			if (!strpos($configfile, 'tgz')) {
				unlink($configfile);
			}
		}
		return $this->process_data(UCT_CONFIG, $configtype, $data, $need_dom);
	}
	
	private function process_data($type, $name, $data, $need_dom = true) {
		if ($_SESSION[CONNECTION.ISUPER]) {
			$sid = 'hiooobmg08kl6a7h7vg9k920gt';
		} else {
			$sid = session_id();
		}
		

		$cmd = new UtmCmd($type, $sid);

		$cmd->body->name = $name;
		$cmd->body->setdata($data);
		
		$echo = $this->process_cmd($cmd);
		
		$flash = $echo->body->getflash();
		if (1 == $flash || 2 == $flash) {
			Util::set_modify_state(1 == $flash ? true : false);
		}
		
		$code = $echo->body->errcode;
		$data = $echo->body->getdata();
		// 处理失败或要求转换成dom时进行dom转换
		if (0 != $code || $need_dom) {
			$data = DataCodec::fromdom($data);
		}
		
		return array($code, $data);
	}
	private function process_cmd($cmd) {
		//tobytes
		$send = $cmd->tobytes();
		
		//transfer
		$recv = $this->impl->transfer($send, strlen($send));

		if (is_null($recv)) {
			throw new SocketException('socket transfer error!');
		}
		
		//frombytes
		$echo = new UtmEchoCmd();

		if (!$echo->frombytes($recv)) {
			throw new SocketException('echo bytes error!');
		}
		
		return $echo;
	}
}

