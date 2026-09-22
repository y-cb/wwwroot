<?php
namespace message;
use message\UtmCmdBody;
use message\UtmCmdHead;

define("UCT_UNKNOWN",	0x00000000);           //未知数据
define("UCT_CMD",		0x00000001);           //命令
define("UCT_CMD_ECHO",	0x00000002);           //回应命令
define("UCT_UPDATE",	0x00000003);		   //升级命令
define("UCT_CONFIG",	0x00000004);	

class UtmCmd {
	private		$header;			//utm_cmd_head
    public		$body;				//utm_cmd_body
    
    function __construct($type = UCT_CMD, $sid = '') {
    	$this->header = new UtmCmdHead();
    	$this->header->type = $type;
    	$this->header->sessionid = $sid;
    	$this->body = new UtmCmdBody();
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
		
		$h = new UtmCmdHead();
		$len = 0;
		$r = $h->frombytes($bytes, $len, $littleendian);
		if (false === $r)
			return false;
			
		if (UCT_CMD != $h->type && UCT_UPDATE != $h->type && UCT_CONFIG != $h->type)
			return false;
		
		$len += $r;
		$b = new UtmCmdBody();
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
