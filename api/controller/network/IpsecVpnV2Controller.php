<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ipsec-vpn-v2 获取ipsec二阶段IKE-v2版本配置信息
 * @apiName 获取ipsec二阶段IKE-v2版本配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} name  ipsec二阶段名称
 * @apiSuccess {Number} ikev2  ike版本  0-ikev1 1-ikev2
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name":"s2",
 *			"ikev2":"1"
 *		},
 *		{
 *			"name":"4433dd",
 *			"ikev2":"1"
 *		}
 *	],
 *	"total": 2
 *	}
 */




class IpsecVpnV2Controller extends mController{
	public $module = 'vpn_ipsec';
	function get(){
		$data = array();
		$param['ikev2']=1;
		$rspString = getResponse($this->module, "show" ,$param);
	 	$ret = getAssign($rspString, $this->module, false, true);
	 	if($ret){
	 		$data['data'] = $ret['group'];
	 		if (isset($ret['page'])) {
	            $data['total'] = (int)$ret['page']['total'];
	        } else {
	            $data['total'] = (int)count($data['data']);
	        }
	 	}
	 	echo json_encode($data);
	 }

}

?>
