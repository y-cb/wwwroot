<?php
namespace message;

define("UTM_CMD_BODY_SIZE_MIN", 64 + 4 + 4 * 22);
define("UTM_CMD_BODY_NAME_LENGTH", 64);

class UtmCmdBody {
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
