<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/dnat 获取目的NAT策略
 * @apiName 获取目的NAT策略
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} dst_src_addr_obj DNAT策略源地址对象名称
 * @apiSuccess {String} dst_dst_addr_obj DNAT策略目标地址对象名称
 * @apiSuccess {String} dst_serv 服务的协议类型
 * @apiSuccess {String} dst_ifname 入接口名称
 * @apiSuccess {String} dst_pool 转换后目的地址池名称
 * @apiSuccess {Number} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiSuccess {Number} dst_mapped_port 转换后端口
 * @apiSuccess {Number} auto_mapped 默认“0”
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id  单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"dst_src_addr_obj": "source",
 *			"dst_dst_addr_obj": "dest",
 *			"dst_serv": "ah",
 *			"dst_ifname": "ge0/3",
 *			"dst_pool": "rule",
 *			"dst_port_valid": "1",
 *			"dst_mapped_port": "24",
 *			"auto_mapped": "0",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "dnat",
 *			"unit_id": "1",
 *			"protocol": "1"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST} /api/dnat 添加目的NAT策略
 * @apiName 添加目的NAT策略
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {String} dst_src_addr_obj DNAT策略源地址对象名称
 * @apiSuccess {String} dst_dst_addr_obj DNAT策略目标地址对象名称
 * @apiSuccess {String} dst_serv 服务的协议类型
 * @apiSuccess {String} dst_ifname 入接口名称
 * @apiSuccess {String} dst_pool 转换后目的地址池名称释
 * @apiSuccess {Number} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiSuccess {Number} dst_mapped_port 转换后端口
 * @apiSuccess {Number} auto_mapped 默认“0”
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
* @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"dst_src_addr_obj": "source",
 *			"dst_dst_addr_obj": "dest",
 *			"dst_serv": "ah",
 *			"dst_ifname": "ge0/4",
 *			"dst_pool": "rule",
 *			"dst_port_valid": "1",
 *			"dst_mapped_port": "245",
 *			"auto_mapped": "0",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "dnat",
 *			"unit_id": "1",
 *			"protocol": "1"
 *		}
 *	],
 *	"total": 1
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {PUT} /api/dnat 修改目的NAT策略
 * @apiName 修改目的NAT策略
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} dst_src_addr_obj DNAT策略源地址对象名称
 * @apiSuccess {String} dst_dst_addr_obj DNAT策略目标地址对象名称
 * @apiSuccess {String} dst_serv 服务的协议类型
 * @apiSuccess {String} dst_ifname 入接口名称
 * @apiSuccess {String} dst_pool 转换后目的地址池名称释
 * @apiSuccess {Number} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiSuccess {Number} dst_mapped_port 转换后端口
 * @apiSuccess {Number} auto_mapped 默认“0”
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_src_addr_obj": "source",
 *			"dst_dst_addr_obj": "dest",
 *			"dst_serv": "ah",
 *			"dst_ifname": "ge0/4",
 *			"dst_pool": "rule",
 *			"dst_port_valid": "1",
 *			"dst_mapped_port": "245",
 *			"auto_mapped": "0",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "dnat",
 *			"unit_id": "1",
 *			"protocol": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {DELETE} /api/dnat 删除DNAT策略
 * @apiName 删除DNAT策略
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {String} dst_src_addr_obj DNAT策略源地址对象名称
 * @apiSuccess {String} dst_dst_addr_obj DNAT策略目标地址对象名称
 * @apiSuccess {String} dst_serv 服务的协议类型
 * @apiSuccess {String} dst_ifname 入接口名称
 * @apiSuccess {String} dst_pool 转换后目的地址池名称释
 * @apiSuccess {Number} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiSuccess {Number} dst_mapped_port 转换后端口
 * @apiSuccess {Number} auto_mapped 默认“0”
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id  单元ID
 * @apiSuccess {Number} protocol 协议类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_src_addr_obj": "source",
 *			"dst_dst_addr_obj": "dest",
 *			"dst_serv": "ah",
 *			"dst_ifname": "ge0/4",
 *			"dst_pool": "rule",
 *			"dst_port_valid": "1",
 *			"dst_mapped_port": "245",
 *			"auto_mapped": "0",
 *			"log": "1",
 *			"rule_id": "1",
 *			"desc": "dnat",
 *			"unit_id": "1",
 *			"protocol": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */



class DstNatFastCfgController extends mController{
	public $module = 'nat_rule_table';

	/*function get(){
		$param = get_inputs();
		$rspString = getResponse( $this->module, "show" , $param);
		$data = getAssign($rspString, $this->module);
		if ($data['dst_src_addr_obj']) {
			$data[data][group] = $data;
		} else {
			$data[data] = $data;
		}
		echo json_encode($data);
	}*/

	function post(){
		$param = get_inputs();
		$param['src_addr'] = '0';
		$param['type'] = 4;
		$param['protocol'] = 1;
		$param['auto_mapped'] = 0;
		$param['dst_addr'] = '1';
		$param['new_server'] = '1';
		$param['new_pool'] = 0;

		if(empty($param['dst_port_valid']))$param['dst_port_valid'] = 0;
		//新建nat地址池
		$param2['name'] = $param['dst_pool'];
		$is_exist = getResponse('nat_pool_table','show_o',$param2);
		$ret_exist = getAssign($is_exist,'nat_pool_table');
		
		if (empty($ret_exist)) {
			$param['new_pool'] = 1;
/*			$param1['rotary'] = '2';
			$param1['name'] = $param['dst_pool'];
			$param1['desc'] = '';
			$param1['protocol'] = '1';
			$tmp['min_ip'] = $param['dst_pool'];
			$tmp['max_ip'] = $param['dst_pool'];
			$param1['item'][] = $tmp;

			$rep = getResponse('nat_pool_table','add',$param1);
			$ret_net_pool = getAssign($rep,'nat_pool_table');
			if ($ret_net_pool[code]){
				echo json_encode($ret_net_pool);
				exit;
			}*/

		}	
	/*
	  Parse post param
	  handle by programer
	*/
		$param['log'] = $param['log']?$param['log']:0;
		$param['trans_type'] = $param['trans_type']?$param['trans_type']:0;
	/*Get model, send msg to system*/	
		$rspString = getResponse('nat_rule_table_fast', "add", $param, $post_submit_action  );
		$ret_param_net_dnat = getAssign($rspString,'nat_rule_table_fast');

	/*model locator*/
		if($ret_param_net_dnat[code]){
			echo json_encode($ret_param_net_dnat);
			exit;
		}
	}
}