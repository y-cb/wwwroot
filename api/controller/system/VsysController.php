<?php
namespace controller\system;

class VsysController{	
	public $module = 'vsys_switch_ui';
	function get() {
		$rspString = getResponse($this->module, "show" ,$param);
		$ret = getAssign($rspString, $this->module);

		$param['vsys_name'] = $ret['vsysid'];
		$param['server_vsys'] = $_SERVER[VSYSID];
		$param['user_name'] = $_SESSION[CONNECTION.USERNAME];
		echo json_encode($param);
	}
	function put() {
		$param = get_inputs();

		$rspString = getResponse($this->module, "mod" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

