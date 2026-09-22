<?php
namespace message;

define("UTM_CMD_HEAD_SIZE", 128);
define('UTM_CMD_HEAD_SID_SIZE', 32);
define("UCT_UNKNOWN",	0x00000000);           //未知数据

class UtmCmdHead {
	public		$byteorder;					//int 字节序。0：little-endian；非0：big-endian
	public		$length;					//int 本数据包大小。包括本包头和全部数据
	public		$product;					//int 产品标识。1；UTM；其它：未定义
    public		$version;					//int 版本。目前暂定为3
	public		$type;						//int 本数据包的类型
	public		$sessionid;					//客户端session信息,32字节字符串
	private		$reserved;					//int[19] 保留字节
	
	function __construct() {
		$this->byteorder = 1;
		$this->length = 0;
		$this->product = 1;
		$this->version = 3;
		$this->type = UCT_UNKNOWN;
		$this->sessionid = '';
		$this->reserved = NULL;
	}
	
	/**
	 * 返回对象当前状态对应的字节流长度
	 */
	function getbytelength() {
		return UTM_CMD_HEAD_SIZE;
	}
	
	/**
	 * 转换成字节流
	 * $littleendian表示是否按little-endian字节序转换
	 * 返回字节流
	 */
	function tobytes($littleendian) {
		//五个32位整数 + UTM_CMD_HEAD_SID_SIZE长度的字符串，并用NULL填充到UTM_CMD_HEAD_SIZE长度
		$fmt = $littleendian ? "V5" : "N5";
		$fmt .= "a".UTM_CMD_HEAD_SID_SIZE;
		$fmt .= "@".UTM_CMD_HEAD_SIZE;

		$bytes = pack($fmt, $this->byteorder, 
				$this->length, 
				$this->product, 
				$this->version, 
				$this->type, 
				$this->sessionid);
		
		return $bytes;
	}
	
	/**
	 * 从字节流中读取状态信息
	 * $bytes 字节流
	 * $start 从字节流的哪个位置开始读
	 * $littleendian 是否按little-endian字节序读取
	 * 成功则返回从字节流中读取的长度，否则返回false
	 */
	function frombytes(&$bytes, $start, $littleendian) {
		if (strlen($bytes) < (UTM_CMD_HEAD_SIZE + $start))
			return false;

		$fmt = "@".$start."/";
		$fmt .= $littleendian ? "V5value/" : "N5value/";
		$fmt .= "a".UTM_CMD_HEAD_SID_SIZE."sid/";
		$fmt .= "@".(UTM_CMD_HEAD_SIZE + $start);
		
		$arr = unpack($fmt, $bytes);
		if (false == $arr || 6 != count($arr))
			return false;
		
		$this->byteorder = $arr['value1'];
		$this->length = $arr['value2'];
		$this->product = $arr['value3'];
		$this->version = $arr['value4'];
		$this->type = $arr['value5'];
		$this->sessionid = $arr['sid'];
		
		return UTM_CMD_HEAD_SIZE;
	}
}
