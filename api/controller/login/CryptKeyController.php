<?php
namespace controller\login;

class CryptKeyController {
	function get(){ 
		if($_SERVER['REQUEST_METHOD']!='POST'){
			session_start();
			$_SESSION[RANDOMKEY] = self::randomkeys(16);
			$randomkey = $_SESSION[RANDOMKEY];
		}
		echo json_encode(array('data'=>array('randomkey' => $randomkey)));
	}
	function randomkeys($length){   
	   $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';  
	    for($i=0;$i<$length;$i++)   
	    {   
	        $key .= $pattern{mt_rand(0,35)};
	    }   
	    return $key;   
	}
}
