<?php

require_once(dirname(__FILE__) . '/../common/logger.php');

/**
 * 查看字节序，调用者需要保证参数有效，字节序信息保存在$bytes的前四个字节中
 */
function peekendian(&$bytes) {
	$arr = unpack("V", $bytes);
	return $arr[1];
}

/**
 * 查看报文长度，调用者需要保证参数有效，报文长度保存在$bytes的5-8字节中
 */
function peeklength(&$bytes, $littleendian) {
	$fmt = $littleendian ? "@4/Vlength" : "@4/Nlength";
	$arr = unpack($fmt, $bytes);
	return $arr['length'];
}

/**
 * 发送命令并返回回应报文
 * 成功返回回应报文字节流(string)，失败则返回NULL
 */
function transferpacket($socket, $packet, $length) {
	do {
		$send = socket_send($socket, $packet, $length, 0);
		if (false == $send) {
			Logger::log("transferpacket: send fail! current length - " . $length);
			return NULL;
		}

		$length -= $send;
		if ($length) {
			$packet = substr($packet, $send, $length);
		}
	} while ($length > 0);

	$echo = '';
	$bufsize = 250 * 1024;
	$buf = str_repeat("\0", $bufsize);
	
	$length = 8;
	$lengthadjust = false;
	while ($length > 0) {
		$recv = socket_recv($socket, $buf, $bufsize, 0);
		if (false == $recv) {
			Logger::log("transferpacket: recv fail!");
			return NULL;
		}

		$echo .= substr($buf, 0, $recv);
		$length -= $recv;
		
		if (!$lengthadjust && strlen($echo) >= 8) {
			$byteorder = peekendian($echo);
			$length = peeklength($echo, (0 == $byteorder));
			$lengthadjust = true;
			$length -= strlen($echo);
		}
	}
	
	return $echo;
}

?>
