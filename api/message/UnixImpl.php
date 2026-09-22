<?php
namespace message;
use message\EngineImpl;

class UnixImpl extends EngineImpl {
	function __construct() {
	}
	function __destruct() {
		$this->domain_socket_close();
	}

	function init($ip, $port) {
		return $this->domain_socket_create();
	}
	
	function transfer($packet, $length) {
		return transferpacket($this->socket, $packet, $length);
	}
	
	private function domain_socket_create() {
		$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
		if (false == $socket)
			return false;

		$socketaddr = tempnam(DOMAIN_SOCKET_DIR, DOMAIN_SOCKET_PREFIX);
		unlink($socketaddr);
		if (!$socketaddr 
			|| !socket_bind($socket, $socketaddr) 
			|| !socket_connect($socket, DOMAIN_SOCKET_REMOTE)) {
			socket_close($socket);
			return false;
		}
		
		$this->socket = $socket;
		$this->socketaddr = $socketaddr;
		
		return true;
	}
	
	private function domain_socket_close() {
		if (isset($this->socket)) {
			socket_close($this->socket);
			unset($this->socket);
		}
		if (file_exists($this->socketaddr)) {
			unlink($this->socketaddr);
		}
	}
	private $socket = NULL;
	private $socketaddr = '';
	const MAX_MSG_SIZE = 0xA00000; //10M
}
