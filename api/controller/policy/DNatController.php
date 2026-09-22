<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nat 获取目的NAT策略
 * @apiName 获取目的NAT策略
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
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
 *			"type": "4",
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST} /api/nat 添加目的NAT策略
 * @apiName 添加目的NAT策略
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiSuccess {String} dst_src_addr_obj DNAT策略源地址对象名称
 * @apiSuccess {String} dst_dst_addr_obj DNAT策略目标地址对象名称
 * @apiSuccess {String} dst_serv 服务的协议类型
 * @apiSuccess {String} dst_ifname 入接口名称
 * @apiSuccess {String} dst_pool 转换后目的地址池名称
 * @apiSuccess {Number} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiSuccess {Number} dst_mapped_port 转换后端口,未开启时默认传空
 * @apiSuccess {Number} auto_mapped 默认“0”
 * @apiSuccess {Number} type 默认“4”
 * @apiSuccess {Number} log 日志开关，0：禁用  1:启用
 * @apiSuccess {Number} rule_id 策略ID
 * @apiSuccess {String} desc 描述，添加对策略的描述信息
 * @apiSuccess {Number} unit_id 单元ID，默认传1
 * @apiSuccess {Number} protocol 协议类型,1表示ipv4，目前只支持ipv4
 *
* @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"type": "4",
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
 * @api {PUT} /api/nat 修改目的NAT策略
 * @apiName 修改目的NAT策略
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
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
 *			"type": "4",
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
 * @api {DELETE} /api/nat 删除DNAT策略
 * @apiName 删除DNAT策略
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} type 1表示静态NAT；2表示源NAT；4表示目的NAT
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
 
 *			"type": "4",
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



class DNatController extends mController{
	public $module = 'nat_rule_table';
}

