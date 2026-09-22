<?php
namespace lib;
class Resource {
	private static $res = array();
	
	//读取相应的文件,返回在文件中name的值
	public static function fromFileValue($name, $filename) {
		if (!array_key_exists($filename, Resource::$res)) {
			$lines = file($filename);
			
			Resource::$res[$filename] = array();
			$s =& Resource::$res[$filename];
			
			foreach ($lines as $content) {
				list($key, $value) = explode('=', $content, 2);
				$s[trim($key)] = str_replace('%20', ' ', trim($value));
			}
		}
		
		$f =& Resource::$res[$filename];
		$var = $f[$name];
		
		return $var;
	}
}
?>