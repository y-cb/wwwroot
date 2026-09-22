<?php
namespace message;
use message\UtmCmdBody;
use message\UtmCmdHead;
use message\UtmEchoBody;

define("UCT_UNKNOWN",	0x00000000);           //未知数据
define("UCT_CMD",		0x00000001);           //命令
define("UCT_CMD_ECHO",	0x00000002);           //回应命令
define("UCT_UPDATE",	0x00000003);		   //升级命令
define("UCT_CONFIG",	0x00000004);



class UtmEchoCmd {
	private		$header;			//utm_cmd_head
	public		$body;				//utm_echo_body

    function __construct() {
    	$this->header = new UtmCmdHead();
    	$this->header->type = UCT_CMD_ECHO;
    	$this->body = new UtmEchoBody();
    }
    
	function tobytes() {
		$littleendian = (0 == $this->header->byteorder) ? true : false;

		$length = $this->header->getbytelength() + $this->body->getbytelength();
		$this->header->length = $length;
		
		return $this->header->tobytes($littleendian) . 
			$this->body->tobytes($littleendian);
	}
	
	function frombytes(&$bytes) {
		$littleendian = (0 == self::peekendian($bytes)) ? true : false;
	
		$datalength = self::peeklength($bytes, $littleendian);
		$h = new UtmCmdHead();
		$len = 0;
		$r = $h->frombytes($bytes, $len, $littleendian);

		if (false === $r)
			return false;
		
		if (UCT_CMD_ECHO != $h->type && UCT_CONFIG != $h->type)
			return false;
		
		$len += $r;
		$b = new UtmEchoBody();
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

	private static function peekendian(&$bytes) {
		$arr = unpack("V", $bytes);
		return $arr[1];
	}

	private static function peeklength(&$bytes, $littleendian) {
		$fmt = $littleendian ? "@4/Vlength" : "@4/Nlength";
		$arr = unpack($fmt, $bytes);
		return $arr['length'];
	}
}
