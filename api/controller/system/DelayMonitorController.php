<?php
namespace controller\system;
use controller\mController;

class DelayMonitorController extends mController {	
	function post() {
		$param = get_inputs();
		$return = false;

		if ($param['turn_on'] == true) {
			if (!file_exists(UPLOAD_FILE)) {
				$return = set_upload_file(UPLOAD_FILE, strtotime('+ 10 minutes'));			
			} else {
				$return = true;
			}
		}

		if ($param['turn_off'] == true) {
			if (file_exists(UPLOAD_FILE)) {
				$return = delete_upload_file(UPLOAD_FILE);
			} else {
				$return = true;
			}
		}

		if (!$return) {
			echo json_encode(array('code' => 1, 'str' => 'operate wrong'));
		}
		return;
	}
}