<?php
namespace controller\system;
use controller\mController;

class UpdateDetectController extends mController{	
	public $module = 'update_version';

	function post() {
		$param = get_inputs();
		 
		$rspString = getResponse($this->module, "add" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		} else {
			set_upload_file(UPLOAD_FILE, strtotime('+ 10 minutes'));
		}
    }
}
