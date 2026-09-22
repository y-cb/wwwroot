<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-virtul-service 获取所有虚拟服务
 * @apiName 获取所有虚拟服务
 * @apiGroup SSL卸载
 *
 *
 * @apiSuccess {Number} lb_type 虚拟服务类型 
 * @apiSuccess {Number} iptype 虚拟服务IP类型
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"lb_type": 1, 
 *		"iptype": 2
 *      }
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
		{
			"snat_pool_cross_protocol": "", 
			"protocol": "6", 
			"port_trans_enable": "1", 
			"http_pfl": "", 
			"http_fw_pfl": "", 
			"fast_http_pfl": "", 
			"qos_enable": "0", 
			"vs_type": "1", 
			"port": "443", 
			"conn_limit": "0", 
			"addr": "5.6.7.8/32", 
			"server_ssl_pfl": "", 
			"spdy_pfl": "", 
			"fast_trans_enable": "0", 
			"client_ssl_pfl": "sslclient", 
			"persist_pfl": "", 
			"http_ia": "", 
			"force_load_enable": "0", 
			"ref": "0", 
			"special_conn": "0", 
			"status": "4", 
			"enable": "0", 
			"iptype": "0", 
			"http_compress": "", 
			"ocnt_pfl": "", 
			"client_protocol_pfl": "tcp", 
			"lb_type": "1", 
			"server_protocol_pfl": "tcp", 
			"http_cache": "", 
			"rate_class": "", 
			"conn_rate_slimit": "0", 
			"vs_service_type": "0", 
			"address_trans_enable": "1", 
			"fallback_persist_pfl": "", 
			"conn_mirror_enable": "0", 
			"name": "aaa", 
			"conn_rate_limit": "0", 
			"default_pool": "https_2_http", 
			"vlan_type": "0", 
			"mirror_dev": "", 
			"snat_pool": "", 
			"path_consistency": "1", 
			"conn_slimit": "0", 
			"oneside_accelerate": "0"
		}
		]
 *	}
 */

/**
 * @api {POST}  /api/ssl-virtul-service 添加虚拟服务
 * @apiName 添加虚拟服务
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {Number} iptype vs的ip类型
 * @apiParam {Number} vlan_type 默认为0
 * @apiParam {Number} lb_type vs的负载均衡类型 默认为1
 * @apiParam {Number} vs_type vs服务类型，设置默认值1
 * @apiParam {Number} enable vs是否使能
 * @apiParam {Number} address_trans_enable vs是否开启地址转换
 * @apiParam {Number} port_trans_enable vs是否开启端口转换
 * @apiParam {String} name vs的名称
 * @apiParam {String} addr vs地址
 * @apiParam {String} client_ssl_pfl 客户端profile名称
 * @apiParam {Number} protocol 协议类型
 * @apiParam {Number} port vs端口号
 * @apiParam {Array} vlan_list 添加的接口列表:"id" 序号;"vlan_name":接口名称,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"iptype": "0",
 *		"vlan_type": "0",
 *		"lb_type": "1",
 *		"vs_type": "1",
 *		"enable": "1",
 *		"address_trans_enable": "0",
 *		"port_trans_enable": "0",
 *		"name": "vs-test",
 *		"addr": "6.6.6.6/32",
 *		"client_ssl_pfl": "sslclient",
 *		"protocol": "6",
 *		"port": "80",
 *		"vlan_list": [{"id":0, "vlan_name":"ge0/1"}]
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/ssl-virtul-service 修改虚拟服务
 * @apiName 修改虚拟服务
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {Number} iptype vs的ip类型
 * @apiParam {Number} vlan_type 默认为0
 * @apiParam {Number} lb_type vs的负载均衡类型 默认为1
 * @apiParam {Number} vs_type vs服务类型，设置默认值1
 * @apiParam {Number} enable vs是否使能
 * @apiParam {Number} address_trans_enable vs是否开启地址转换
 * @apiParam {Number} port_trans_enable vs是否开启端口转换
 * @apiParam {String} name vs的名称
 * @apiParam {String} addr vs地址
 * @apiParam {String} client_ssl_pfl 客户端profile名称
 * @apiParam {Number} protocol 协议类型
 * @apiParam {Number} port vs端口号
 * @apiParam {Array} vlan_list 添加的接口列表:"id" 序号;"vlan_name":接口名称,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"iptype": "0",
 *		"vlan_type": "0",
 *		"lb_type": "1",
 *		"vs_type": "1",
 *		"enable": "1",
 *		"address_trans_enable": "0",
 *		"port_trans_enable": "0",
 *		"name": "vs-test",
 *		"addr": "6.6.6.6/32",
 *		"client_ssl_pfl": "sslclient",
 *		"protocol": "6",
 *		"port": "80",
 *		"vlan_list": [{"id":0, "vlan_name":"ge0/1"}, {"id":1, "vlan_name":"ge0/0"}]
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ssl-virtul-service 删除虚拟服务
 * @apiName 删除虚拟服务
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {Number} iptype vs的ip类型
 * @apiParam {Number} lb_type vs的负载均衡类型 默认为1
 * @apiParam {Number} enable vs是否使能
 * @apiParam {String} name vs的名称
 * @apiParam {String} addr vs地址
 * @apiParam {Number} protocol 协议类型
 * @apiParam {Number} port vs端口号
 * @apiParam {Number} ref vs的引用计数
 * @apiParam {Number} status vs的状态
 *
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"iptype": "0",
 *		"lb_type": "1",
 *		"enable": "1",
 *		"name": "vs-test",
 *		"addr": "6.6.6.6/32",
 *		"protocol": "6",
 *		"port": "80",
 *		"ref": "0",
 *		"status": "3"
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */



class SSLVirtulServiceController extends mController {	
	public $module = 'vs_config';

	function get(){
		$data = array();
		$param = get_inputs();
		$data = array();
		
		header('Content-type: application/json');
		$rspString = getResponse($this->module, "show" ,$param);
	 	$ret = getAssign($rspString, $this->module, false, true);
	 	$tmp_total = 0;

	 	if (empty($param['name'])&&$param['is_proxy'] == 0 ) {

	 		// $ret = $ret['group'];

		 	foreach ($ret['group'] as $key => $value) {
				if ($value['name'] == 'proxy-vs') {
					unset($ret['group'][$key]);
					$tmp_total = 1;
					break;
				}	 		
		 	}	 		
	 	}

	 	$data['data'] = $ret['group'];
	 	$data['total'] = (int)$ret['page']['total'] - $tmp_total;
		echo json_encode($data);
	}
}
