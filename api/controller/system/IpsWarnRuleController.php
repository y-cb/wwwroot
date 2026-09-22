<?php
namespace controller\system;
use controller\mController;

class IpsWarnRuleController extends mController{	
	public $module = 'ips_hl_warn_rule';

	function post() {
		$param = get_inputs();

		$param['syslog_enable'] = intval($param['syslog_enable']);
		$param['email_enable'] = intval($param['email_enable']);

		$rspString = getResponse($this->module, "add" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}

	function put() {
		$param = get_inputs();

		$param['syslog_enable'] = intval($param['syslog_enable']);
		$param['email_enable'] = intval($param['email_enable']);

		$rspString = getResponse($this->module, "mod" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

