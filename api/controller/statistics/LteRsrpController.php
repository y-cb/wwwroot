<?php
namespace controller\statistics;
use controller\mController;

class LteRsrpController extends mController {	
	public $module = 'net_lte_rsrp';

	function get() {
		$data = array();
		$info = array();
		$param = get_inputs();
		$rspString = getResponse($this->module, "show" ,$param);
		$ret = getAssign($rspString, $this->module, false, true);
		$info['group'][] = array(
			'date' => date("H:i:s", time()),
			'lte_2g' => '',
			'lte_3g' => '',
			'lte_4g' => '',
			'lte_5g' => '',
			'lte_noact' => '',
			'lte_act' => $ret['group'][0]['lte_act']
		);
		switch ($ret['group'][0]['lte_act']) {
			case '0':
				$info['group'][0]['lte_2g'] = $ret['group'][0]['lte_rsrp']? trim($ret['group'][0]['lte_rsrp']): "";
				break;
			case '2':
				$info['group'][0]['lte_3g'] = $ret['group'][0]['lte_rsrp']? trim($ret['group'][0]['lte_rsrp']): "";
				break;
			case '7':
				$info['group'][0]['lte_4g'] = $ret['group'][0]['lte_rsrp']? trim($ret['group'][0]['lte_rsrp']): "";
				break;
			case '13':
				$info['group'][0]['lte_5g'] = $ret['group'][0]['lte_rsrp']? trim($ret['group'][0]['lte_rsrp']): "";	
                                break;				
			default:
				$info['group'][0]['lte_noact'] = $ret['group'][0]['lte_rsrp']? trim($ret['group'][0]['lte_rsrp']): "";
				break;
		}
		$data['data'] = $info['group'];
		
		header('Content-type: application/json');
		echo json_encode($data);
	}
}