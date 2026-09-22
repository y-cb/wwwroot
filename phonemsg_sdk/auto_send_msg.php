<?php
require_once(dirname(__FILE__).'/AliSms.php');
$instance = new AliSms();
 
$number = $_SERVER['argv'][1];
$time = $_SERVER['argv'][2];
$code = $_SERVER['argv'][3];

if (!$number) {
	return false;
}
if (!$code) {
	return false;
}

/*$number=18904490690;
$code=20;
$time=30;*/
$content= array('log'=>$code,'minute'=>$time);
set_time_limit(0);
header('Content-Type: text/plain; charset=utf-8');

$response = AliSms::sendSms($number,'','',$content);

if ($response->Message == 'OK'){
	return true;
} else {
	return false;
}