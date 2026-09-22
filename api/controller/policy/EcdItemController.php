<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ecd-item 获取情报策略使能状态
 * @apiName ecd-item
 * @apiGroup 获取情报策略使能状态
 *
 *
 * @apiSuccess {Number} ecd_sw_coo_def_ip IP信誉库开关（0关,1开）
 * @apiSuccess {Number} ecd_sw_coo_def_domain 域名开关（0关,1开）
 * @apiSuccess {Number} ecd_sw_coo_def_uri URL开关（0关,1开）
 * @apiSuccess {Number} ecd_sw_coo_def_sha256 文件hash开关（0关,1开）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *    		"ecd_sw_coo_def_ip": "0",
 *    		"ecd_sw_coo_def_domain": "1",
 *    		"ecd_sw_coo_def_uri": "0"
 *    		"ecd_sw_coo_def_sha256": "1"
 *		}
 *	}
 */

/**
 * @api {PUT}  /api/ecd-item 修改情报策略使能状态
 * @apiName ecd-item
 * @apiGroup 修改情报策略使能状态
 *
 *
 * @apiParam {Number} ecd_sw_coo_def_ip IP信誉库开关（0关,1开）
 * @apiParam {Number} ecd_sw_coo_def_domain 域名开关（0关,1开）
 * @apiSuccess {Number} ecd_sw_coo_def_uri URL开关（0关,1开）
 * @apiSuccess {Number} ecd_sw_coo_def_sha256 文件hash开关（0关,1开）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *    	"ecd_sw_coo_def_ip": "1",
 *    	"ecd_sw_coo_def_domain": "1",
 *    	"ecd_sw_coo_def_uri": "0"
 *    	"ecd_sw_coo_def_sha256": "1"
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
 *		"code":"非0",
 *		"str":""
 *	}
 *
 */

class EcdItemController extends mController {	
	public $module = 'ecd_item';
	function get(){
		$ecd_new_arr = array();		
		$ecd_names = ["ecd_sw_coo_def_ip", "ecd_sw_coo_def_domain", "ecd_sw_coo_def_uri","ecd_sw_coo_def_malware_url","ecd_sw_coo_def_sha256"];
		foreach ($ecd_names as $key => $value) {		
			$params['name'] = $value;
			$rspString = getResponse($this->module, "show", $params);
			$ret_param = getAssign($rspString,$this->module);
			$ecd_new_arr['data'][0][$value]=$ret_param["value"];
			
		}
		echo json_encode($ecd_new_arr);
	}
	function put(){
		$get_params = get_inputs();
		$ecd_new_arr = array();		
		$ecd_names = ["ecd_sw_coo_def_ip", "ecd_sw_coo_def_domain", "ecd_sw_coo_def_uri","ecd_sw_coo_def_malware_url","ecd_sw_coo_def_sha256"];

		foreach ($get_params as $key => $value) {
			if(in_array($key, $ecd_names)){
				$params['name'] = $key;
				$params['value'] = $value;
				$rspString = getResponse($this->module, "mod", $params);
				$ret_param = getAssign($rspString,$this->module);
				if($ret_param[code]){
					echo json_encode($ret_param);
				}
			}			
		}
	}
}
