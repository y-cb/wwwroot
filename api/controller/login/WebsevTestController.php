<?php
namespace controller\login;

class WebsevTestController {
	public $dir_file = '/tmp/webtest';
	function get(){
		file_put_contents($this->dir_file,date("Y-m-d H:i:s"));
	}
	
}
