<?php
namespace controller\network;
use controller\mController;

class LteStaticController extends mController{
	public $module = 'net_lte_static';

	function get() {
		$data = array();
		$param = get_inputs();

		$rspString = getResponse($this->module, "show" ,$param);
	    $ret = getAssign($rspString, $this->module, false, true);

	    $rspString_inf = getResponse('net_lte_status', 'show', $param);
	    $ret_inf = getAssign($rspString_inf, 'net_lte_status', false, true);

	    $ret['group'][0]['tb_interface_ip'] = $ret_inf['group'][0]['tb_interface_ip'];
	    $data['data'] = $ret['group'];
	    $data['total'] = count($data['data']);

	    echo json_encode($data);
	}
}

?>
