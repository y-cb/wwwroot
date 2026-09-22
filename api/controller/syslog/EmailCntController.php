<?php
namespace controller\syslog;
use controller\Controller;

class EmailCntController extends Controller {

	function get(){
		$file_path = $_GET['file_path'];	
		$filename = basename($file_path); 

		/* 下面的检查是为了防止可能的攻击 */
		if (strstr($file_path, '..') != false) {
			return;
		}
		if (strstr($file_path, '\\') != false) {
			return;
		}
		if (substr_count($file_path, '/') > 1) {
			return;
		}
		if (strstr($filename, 'eml')) {
			$eml_content = file_get_contents("/mnt1/files/".$file_path);
			echo base64_encode($eml_content);
			return;
		}
		
		return;
	}	
}