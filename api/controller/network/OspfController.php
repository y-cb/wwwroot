<?php
namespace controller\network;
use controller\mController;

class OspfController extends mController{
	public $module = 'ospf';

	function get() {
		$param = get_inputs();

		$rspString = getResponse($this->module, "show" ,$param);
		$ret = getAssign($rspString, $this->module);
		if (!empty($ret)) {
			$info = array();
			$info['router-id'] = $ret['router_id'];
			$info['vrf_name'] = '';
			$info['id'] = 0;

			$data['data'][] = $info;
			$data['total'] = count($data['data']);			
		} else {
			$data = array();
		}

		echo json_encode($data);

	}

	function post() {
		$tmp = get_inputs();
		if ($tmp['id'] == 0) {
			$param = array();
			$param['router_id'] = $tmp['router-id'];
			$param['gen_default_route'] = 0;
			$param['c_rtag'] = 1;
			$param['c_metric'] = 10;
			$param['r_rtag'] = 1;
			$param['r_metric'] = 10;
			$param['s_rtag'] = 1;
			$param['s_metric'] = 10;

			$rspString = getResponse($this->module, "add" ,$param);
			$ret = getAssign($rspString, $this->module);
		} else {
			$ret = array('code'=>'-1','str'=>'Configuration error');
		}

		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

?>