<?php
namespace controller\system;
use controller\mController;

class OemInfoController extends mController{	
	function get() {
		$oemInfo = isset($_ENV[CONFIG_POWER])? true: false;
		$data['data'] = array('oem_info'=> $oemInfo);

		echo json_encode($data);
	}
}

