<?php
namespace controller\system;
use controller\Controller;


class IpsCaptureController extends Controller {	
	function get(){
		$name = $_GET['FileName'];
		if ($name){			
			$path = '/tmp/ipspkt/'.$name;
			//if (preg_match('/^[a-zA-Z0-9_]+\.(cap|CAP|pcap)$/', $name)) {
				$file_size = filesize($path);
				$data = file_get_contents($path);
			//}
			if($_GET['check']==1){
				if(!file_exists($path)){
					echo json_encode( array('code' =>-1 ,'str'=>t('cert.not_exist')));
					return;
				}else{
					echo json_encode( array('code' =>0 ,'str'=>'success'));
					return;
				}
			}
			
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes"); 
			Header("Accept-Length:".$file_size); 
			// Header($contTypeArr[$filetype].' charset=utf-8');
			Header('Content-Disposition: attachment;filename="'.$name.'"');
			Header('Cache-Control: max-age=0'); 
			echo $data;
		} 
		return;
	}

}
