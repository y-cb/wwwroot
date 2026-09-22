<?php
namespace message;

define("UET_UNUSE",			0x00000000);           //未知数据
define("UET_ERRNO",			0x00000001);           //命令
define("UET_WITHDATA",		0x00000002);           //回应命令
define("UTM_ECHO_BODY_SIZE_MIN", 4 + 4 + 4 + 4 * 20);

class UtmEchoBody {
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
