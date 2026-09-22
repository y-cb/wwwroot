<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/dns-resolution 获取所有dns解析结果
 * @apiName 获取所有dns解析结果
 * @apiGroup 应用策略
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *      }
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"total": 5, 
 *		"data": [
 *		{"ip": "124.200.112.1", "type": "0", "domain_name": "www.jd.com"}, 
 *		{"ip": "119.75.216.20", "type": "0", "domain_name": "www.baidu.com"}, 
 *		{"ip": "119.75.213.61", "type": "0", "domain_name": "www.baidu.com"}, 
 *		{"ip": "14.215.177.38", "type": "0", "domain_name": "www.baidu.com"}, 
 *		{"ip": "14.215.177.39", "type": "0", "domain_name": "www.baidu.com"}
 *		]
 *	}
 */



/**
 * @api {GET}  /api/dns-resolution 获取指定dns解析结果
 * @apiName 获取指定dns解析结果
 * @apiGroup 应用策略
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"domain_name": "www.baidu.com",
 *		"op": "detail_o"
 *      }
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"total": 4, 
 *		"data": [
 *		{"ip": "119.75.216.20", "type": "0", "domain_name": "www.baidu.com"}, 
 *		{"ip": "119.75.213.61", "type": "0", "domain_name": "www.baidu.com"}, 
 *		{"ip": "14.215.177.38", "type": "0", "domain_name": "www.baidu.com"}, 
 *		{"ip": "14.215.177.39", "type": "0", "domain_name": "www.baidu.com"}
 *		]
 *	}
 */

class DnsResolutionController extends mController {	
	public $module = 'https_proxy_dns_lookup_result';
	function get(){
		$param = get_inputs();
		$data = array();
		if(isset($param['domain_name'])){
			//header('Content-type: application/json');
			$rspString = getResponse($this->module, "showone" ,$param);
		}else{
			$rspString = getResponse($this->module, "showall" ,$param);	
		}
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
