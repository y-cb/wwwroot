<?php
namespace controller\system;
use controller\mController;

class ReportSMTPController extends mController{	
	public $module = 'sys_report_smtp';
	function get() {
		$param = get_inputs();
		$data = array();

		$rspString = getResponse($this->module, "show" ,$param);
	    $ret = getAssign($rspString, $this->module, false, true);

	   	if(empty($ret)) {
	   		$data['data'] = array();
	   		$data['total'] = 0;
	   	} else {
	   		foreach ($ret['group'] as $key => $value) {
		   		if ($value['auth_enable'] && $value['auth_enable'] == 1) {
		   			$value['smtp_passwd'] = hex2bin($value['smtp_passwd']);
		   		}
	   			$data['data'][] = $value;
	   		}

	   		if (isset($ret['page'])) {
	   			$data['total'] = (int)$ret['page']['total'];
	   		} else {
	   			$data['total'] = (int)count($data['data']);
	   		}
	   	}

	   	header('Content-type: application/json');
	   	echo json_encode($data);
	}

	function post () {
		$param = get_inputs();

		if ($param['auth_enable']== '1') {
			$param['smtp_passwd'] = bin2hex(htmlspecialchars_decode($param['smtp_passwd']));
		}

		$rspString = getResponse($this->module, "add" ,$param);
		
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}

	function put () {
		$param = get_inputs();

		if ($param['auth_enable']== '1') {
			$param['smtp_passwd'] = bin2hex(htmlspecialchars_decode($param['smtp_passwd']));
		}

		$rspString = getResponse($this->module, "mod" ,$param);
		
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

