<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ospf-network 查询ospf发布网络配置信息
 * @apiName 查询ospf发布网络配置信息
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} vrf_name  ospf发布网络所属vrf名称
 * @apiSuccess {String} network  ospf发布网络
 * @apiSuccess {String} area_id  区域id
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"network": "100.0.0.0/24",
 *			"area_id": "0.0.0.23"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/ospf-network 新增ospf发布网络配置信息
 * @apiName 新增ospf发布网络配置信息
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf发布网络所属vrf名称
 * @apiParam {String} network  ospf发布网络
 * @apiParam {String} area_id  区域id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"network": "00.0.0.0/24",
 *		"area_id": "0.0.0.23"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"100",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/ospf-network 修改ospf发布网络配置信息
 * @apiName 修改ospf发布网络配置信息
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf发布网络所属vrf名称
 * @apiParam {String} network  ospf发布网络
 * @apiParam {String} area_id  区域id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"network": "00.0.0.0/24",
 *		"area_id": "0.0.0.23"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"100",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ospf-network 删除ospf发布网络配置信息
 * @apiName 删除ospf发布网络配置信息
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf发布网络所属vrf名称
 * @apiParam {String} network  ospf发布网络
 * @apiParam {String} area_id  区域id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"network": "00.0.0.0/24",
 *		"area_id": "0.0.0.23"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


class OspfNetworkController extends mController{
	public $module = 'ospf_network';

	function get() {
		$param = get_inputs();
		$rspString = getResponse($this->module, "show" ,$param);
		$ret = getAssign($rspString, $this->module,1);
		header('Content-type: application/json');
		if (empty($ret)) {
			echo json_encode(array());
		} else {
			if ($param['pageSize'] && $param['lang']) {
				$list = array();
				if (count($ret) == count($ret, 1)) {
					$list['data'][] = $ret;
				} else {
					$list['data'] = $ret;
				}
				$list['total'] = count($ret);
				echo json_encode($list);
			} else {
				$list = array();
				$list['data'][0]['id'] = 1;
				foreach ($ret as $key=>$value) {
					$list['data'][0]['network-areas']['group'][$key]['ospf_network'] = $value['network'];
					$list['data'][0]['network-areas']['group'][$key]['ospf_area_id'] = $value['area_id'];
				}
				$list['total'] = count($list['data']);
				echo json_encode($list);
			}
			
		}
	}

	function post() {
		$param = get_inputs();
		if (isset($param['id'])) {
			if ($param['id'] == 1) {
				if (!empty($param['item'])) {
					$ret_array = array();
					foreach ($param['item'] as $value) {
						$list = array();
						$list['network'] = $value['ospf_network'];
						$list['area_id'] = $value['ospf_area_id'];
						$rspString = getResponse($this->module, "add" ,$list);
						$ret = getAssign($rspString, $this->module);
						if (!empty($ret)) {
							$ret_array['str'] .= $ret['str'].' ';
						}
					}

					$ospf = array();
					$ospf['gen_default_route'] = 0;
					$ospf['c_rtag'] = 1;
					$ospf['c_metric'] = 10;
					$ospf['r_rtag'] = 1;
					$ospf['r_metric'] = 10;
					$ospf['s_rtag'] = 1;
					$ospf['s_metric'] = 10;

					$rspString = getResponse('ospf', "add" ,$ospf);
					$ret = getAssign($rspString, 'ospf');

					if (!empty($ret_array)) {
						$ret_array['code'] = -1;
					}
				}
			} else {
				$ret_array = array('code'=> -1, 'str' => 'Configuration error');
			}
			if (!empty($ret_array)){
				header('Content-type: application/json');
				echo json_encode($ret_array);
			}
		} else {
			$rspString = getResponse($this->module, "add" ,$param);
			$ret = getAssign($rspString, $this->module);

			header('Content-type: application/json');
			if (!empty($ret)) {
				echo json_encode($ret);
			}
		}
	}

	function delete() {
		$param = get_inputs();
		if (isset($param['id'])&&$param['id'] == 1){
			$rspString = getResponse($this->module, "show");
			$ret = getAssign($rspString, $this->module,1);

			foreach ($ret as $value) {
				$rspString = getResponse($this->module, "del" ,$value);
				$ret = getAssign($rspString, $this->module);
				if (!empty($ret)) {
					echo json_encode($ret);
				}
			}
		} else {
			$rspString = getResponse($this->module, "del" ,$param);
			$ret = getAssign($rspString, $this->module);
			header('Content-type: application/json');
			if (!empty($ret)) {
				echo json_encode($ret);
			}				
		}

	}
}

?>
