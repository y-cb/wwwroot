<?php
namespace controller\system;
use controller\mController;

class DiskTypeController extends mController{	
	function get(){
		if(file_exists('/mnt1/mysql/')) {
			$data['is_disk']=1;
		}else{
			$data['is_disk']=0;
		}
		echo json_encode($data);
		return;
	}
}

