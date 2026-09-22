<?php 

/********************************************************************************************
 *启明星辰信息技术有限公司
 *作    者：孟永辉、安伟、李雪峰
 *版    本：UTM3.0
 *日    期：2006-8-28
 *描    述：定义UTM引擎和控制中心通信使用的数据结构
 *其　　它：1. 本文件中int类型，为32位长度。

 *修改记录：无
  1. 2007-01-19 增加了升级命令。共修改2处：
     1)在UTM_COMM_TYPE中增加UCT_UPDATE;
     2)修改utm_cmd_body->name注释。

  2. 2007-01-25 增加了配置导入导出命令。共修改2处
	1) 在UTM_COMM_TYPE中增加UCT_CONFIG,发到guish和guish发到web服务器的都是这个类型
	2) 修改utm_cmd_body->name注释。
 *********************************************************************************************/

/**
 * 注意：upack的时候必须为格式符指定名字作为结果array中的key，
 * 否则会存在转换丢失数据的现象。
 */

require_once(dirname(__FILE__) . '/socket_util.php');

 /*
 *“控制<->引擎”通讯数据包类型
 */
if (!defined("UCT_UNKNOWN")) {                                        
        define("UCT_UNKNOWN",   0x00000000);           //未知数据     
}                                                                     
if (!defined("UCT_CMD_ECHO")) {                                      
        define("UCT_CMD_ECHO", 0x00000001);           //命令         
}                                                                    
if (!defined("UCT_CMD_ECHO")) {                                      
        define("UCT_CMD_ECHO",  0x00000002);           //?.?应命令   
}                                                                    
if (!defined("UCT_UPDATE")) {                                        
        define("UCT_UPDATE",    0x00000003);               //升级命令
}                                                                        
if (!defined("UCT_CONFIG")) {                                                                                       
        define("UCT_CONFIG",    0x00000004);               //配置?.?关命令(导入,导出等),引擎?.?的也是这个标志           
} 

/*
 *结构: utm_cmd_head
 *说明: 1. 控制端和引擎端进行通信的头结构
 *     2. 数据的两个流向都用此结构
 *     3. 本结构长度为128字节，满足16字节对齐
 */
define("UTM_CMD_HEAD_SIZE", 128);
define('UTM_CMD_HEAD_SID_SIZE', 32);

class utm_cmd_head {
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

/*
 *结构：utm_cmd_body
 *说明：1. 命令信息结构。
        2. “控制->引擎”的所有命令，均使用此结构
 */
define("UTM_CMD_BODY_SIZE_MIN", 64 + 4 + 4 * 22);
define("UTM_CMD_BODY_NAME_LENGTH", 64);
class utm_cmd_body {
	public		$name;				//char[64] 第一个标签的名字，如果是命令是UCT_UPDATE，则为MAIN，IPSLIB，AVLIB之一
                                    //如果命令是UCT_CONFIG，则分别为SYSCONFIG_IN，IPSCONFIG_IN，USER_DEFINE_IN, SYSCONFIG_OUT，IPSCONFIG_OUT，USER_DEFINE_OUT。
	private		$datalength;		//int 数据长度 ,非0表示后面的缓冲区有效
    private		$reserved;			//int[22] 保留字节
    private		$data;				//char[datalength] 数据内容

	function __construct() {
		$this->name = '';
		$this->datalength = 0;
		$this->reserved = NULL;
		$this->data = '';
	}
	
	function getdata() {
		return $this->data;
	}
	
	function setdata($d) {
		$this->datalength = strlen($d);
		$this->data = $d;
	}
	
	function getbytelength() {
		return $this->datalength + UTM_CMD_BODY_SIZE_MIN;
	}
	
	function tobytes($littleendian) {
		//UTM_CMD_BODY_NAME_LENGTH长度的字符串 + 一个32位整数， 并用NULL填充
		//$this->reserved(int[22])部分 + $this->datalength长度的字符串
		$fmt = "a".UTM_CMD_BODY_NAME_LENGTH;
		$fmt .= $littleendian ? "V@" : "N@";
		$fmt .= UTM_CMD_BODY_SIZE_MIN;
		$fmt .= "a" . $this->datalength;

		$bytes = pack($fmt, $this->name, 
				$this->datalength, 
				$this->data);
		
		return $bytes;
	}
	
	function frombytes(&$bytes, $start, $littleendian) {
		if (strlen($bytes) < (UTM_CMD_BODY_SIZE_MIN + $start))
			return false;

		$fmt = "@".$start."/";
		$fmt .= "a".UTM_CMD_BODY_NAME_LENGTH."name/";
		$fmt .= $littleendian ? "V" : "N";
		$fmt .= "length/@".(UTM_CMD_BODY_SIZE_MIN + $start);
		
		$arr1 = unpack($fmt, $bytes);
		if (false == $arr1 || 2 != count($arr1))
			return false;
		
		$dl = $arr1['length'];
		
		if (strlen($bytes) < (UTM_CMD_BODY_SIZE_MIN + $start + $dl))
			return false;
		
		$fmt = "@".($start + UTM_CMD_BODY_SIZE_MIN)."/a".$dl."data";
		$arr2 = unpack($fmt, $bytes);
		if (false == $arr2 || 1 != count($arr2))
			return false;

		$this->name = $arr1['name'];
		$this->datalength = $dl;
		$this->data = $arr2['data'];
		
		return UTM_CMD_BODY_SIZE_MIN + $this->datalength;
	}
}

/*
 *“控制<-引擎”命令回应类型
 */
define("UET_UNUSE",			0x00000000);           //未知数据
define("UET_ERRNO",			0x00000001);           //命令
define("UET_WITHDATA",		0x00000002);           //回应命令

/*
 *结构：utm_echo_body
 *说明：1. 命令信息结构。
        2. “引擎->控制”的所有回应命令，均使用此结构
        3. 若回应命令没有附带数据，则datalength为0；
           否则datalength为数据长度，data为数据内容。
 */
define("UTM_ECHO_BODY_SIZE_MIN", 4 + 4 + 4 + 4 * 20);
class utm_echo_body {
	public		$echotype;						//int 命令类型
    public		$errcode;						//int 错误码
    private		$datalength;                    //int 数据长度
    public		$flash;							//char 控制保存按钮是否闪，0表示没有变化，1表示闪，2表示不闪
    private		$pad;							//char[3] 保留
    private		$reserved;						//int[19] 保留字节
    private		$data;							//char[datalength] 数据内容

	function __construct() {
		$this->echotype = UET_UNUSE;
		$this->errcode = 0;
		$this->datalength = 0;
		$this->flash = 0;
		$this->pad = NULL;
		$this->reserved = NULL;
		$this->data = '';
	}
	
	function getdata() {
		return $this->data;
	}
	
	function setdata($d) {
		$this->datalength = strlen($d);
		$this->data = $d;
	}
	
	function getflash() {
		return $this->flash;
	}
	
	function getbytelength() {
		return $this->datalength + UTM_ECHO_BODY_SIZE_MIN;
	}
	
	function tobytes($littleendian) {
		//三个32位整数并用NULL填充到UTM_ECHO_BODY_SIZE_MIN长度 +
		//$this->datalength长度的字符串
		$fmt = $littleendian ? "V3c@" : "N3c@";
		$fmt .= UTM_ECHO_BODY_SIZE_MIN;
		$fmt .= "a" . $this->datalength;

		$bytes = pack($fmt, $this->echotype, 
				$this->errcode, 
				$this->datalength, 
				$this->flash, 
				$this->data);
		
		return $bytes;
	}
	
	function frombytes(&$bytes, $start, $littleendian) {
		if (strlen($bytes) < (UTM_ECHO_BODY_SIZE_MIN + $start))
			return false;

		$fmt = "@".$start."/";
		$fmt .= $littleendian ? "V3" : "N3";
		$fmt .= "intvalue/cflash/@".(UTM_ECHO_BODY_SIZE_MIN + $start);
		
		$arr1 = unpack($fmt, $bytes);
		if (false == $arr1 || 4 != count($arr1))
			return false;
		
		$dl = $arr1['intvalue3'];
		$flash = $arr1['flash'];
		
		if (strlen($bytes) < (UTM_ECHO_BODY_SIZE_MIN + $start + $dl))
			return false;
		
		$data = substr($bytes, $start + UTM_ECHO_BODY_SIZE_MIN, $dl);
		if (false == $data || strlen($data) != $dl)
			return false;

		$this->echotype = $arr1['intvalue1'];
		$this->errcode = $arr1['intvalue2'];
		$this->datalength = $dl;
		$this->flash = $flash;
		$this->data = $data;
		
		return UTM_ECHO_BODY_SIZE_MIN + $this->datalength;
	}
}

/*
 *结构：UTM_CMD
 *说明：1. 带通信头结构的命令信息结构。
        2. “控制->引擎”的所有命令，均使用此结构
 */
class utm_cmd {
	private		$header;			//utm_cmd_head
    public		$body;				//utm_cmd_body
    
    function __construct($type = UCT_CMD, $sid = '') {
    	$this->header = new utm_cmd_head();
    	$this->header->type = $type;
    	$this->header->sessionid = $sid;
    	$this->body = new utm_cmd_body();
    }
    
	function tobytes() {
		$littleendian = (0 == $this->header->byteorder) ? true : false;

		$this->header->length = $this->header->getbytelength() + $this->body->getbytelength();
		
		return $this->header->tobytes($littleendian) . 
			$this->body->tobytes($littleendian);
	}
	
	function frombytes(&$bytes) {
		$littleendian = (0 == peekendian($bytes)) ? true : false;
		$datalength = peeklength($bytes, $littleendian);
		
		$h = new utm_cmd_head();
		$len = 0;
		$r = $h->frombytes($bytes, $len, $littleendian);
		if (false === $r)
			return false;
			
		if (UCT_CMD != $h->type && UCT_UPDATE != $h->type && UCT_CONFIG != $h->type)
			return false;
		
		$len += $r;
		$b = new utm_cmd_body();
		$r = $b->frombytes($bytes, $len, $littleendian);
		if (false === $r)
			return false;
		
		$len += $r;
		if ($len != $datalength)
			return false;
		
		$this->header = $h;
		$this->body = $b;
		
		return true;
	}
}

/*
 *结构：utm_echocmd
 *说明：1. 带通信头结构的回应命令信息结构。
        2. “引擎->控制”的所有回应命令，均使用此结构
 */
class utm_echocmd {
	private		$header;			//utm_cmd_head
	public		$body;				//utm_echo_body

    function __construct() {
    	$this->header = new utm_cmd_head();
    	$this->header->type = UCT_CMD_ECHO;
    	$this->body = new utm_echo_body();
    }
    
	function tobytes() {
		$littleendian = (0 == $this->header->byteorder) ? true : false;

		$length = $this->header->getbytelength() + $this->body->getbytelength();
		$this->header->length = $length;
		
		return $this->header->tobytes($littleendian) . 
			$this->body->tobytes($littleendian);
	}
	
	function frombytes(&$bytes) {
		$littleendian = (0 == peekendian($bytes)) ? true : false;
		$datalength = peeklength($bytes, $littleendian);
		
		$h = new utm_cmd_head();
		$len = 0;
		$r = $h->frombytes($bytes, $len, $littleendian);
		if (false === $r)
			return false;
		
		if (UCT_CMD_ECHO != $h->type && UCT_CONFIG != $h->type)
			return false;
		
		$len += $r;
		$b = new utm_echo_body();
		$r = $b->frombytes($bytes, $len, $littleendian);
		if (false === $r)
			return false;
		
		$len += $r;
		if ($len != $datalength)
			return false;
		
		$this->header = $h;
		$this->body = $b;
		
		return true;
	}
}

?>
