<?php

if($_POST['lang']=='en'){
	// echo dirname(__FILE__); 英文lang.conf=1 中文lang.conf=2
	@$fp = fopen('/tmp/webui/lang.conf', 'w');
	@flock($fp, 2);
	@fwrite($fp, 1);
	@fclose($fp);
	echo 'en';
}else{
	// echo dirname(__FILE__);
	@$fp = fopen('/tmp/webui/lang.conf', 'w');
	@flock($fp, 2);
	@fwrite($fp, 2);
	@fclose($fp);
	echo 'zh';
}

?>