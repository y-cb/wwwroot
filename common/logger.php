<?php

class Logger {
	static function log($msg) {
		$logfile = dirname(__FILE__) . "/php.log";
		clearstatcache();
		@ $size = filesize($logfile);
		if ($size > 512 * 1024) {
			unlink($logfile);
		}
		file_put_contents($logfile, $msg . "\n", FILE_APPEND);
	}
}

?>