<?php
namespace message;
use message\UnixImpl;
use message\WinImpl;

abstract class EngineImpl {
	abstract function init($ip, $port);
	abstract function transfer($send, $length);
	static function getInstance() {
		return ('/' == DIRECTORY_SEPARATOR) ? new UnixImpl() : new WinImpl();
	}
}
