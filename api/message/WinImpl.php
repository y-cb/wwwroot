<?php
namespace message;
use message\EngineImpl;

class WinImpl extends EngineImpl {
	function __construct() {
	}
	function __destruct() {
		if (isset($this->socket)) {
			release_connection($this->socket);
		}
	}

	function init($ip, $port) {
		$s = get_connection($ip, $port);
		if (is_null($s)) {
			return false;
		}

		$this->socket = $s;
		
		return true;
	}
	
	function transfer($send, $length) {
		return transferpacket($this->socket, $send, $length);
	}
	
	private $socket = NULL;
}