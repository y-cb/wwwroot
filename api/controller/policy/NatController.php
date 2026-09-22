<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nat 获取静态NAT地址策略
 * @apiName 获取静态NAT地址策略
 * @apiGroup NAT策略
 *
 *
 * @apiParam {Number} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiParam {String} log 日志，1表示开启日志，0表示未开启日志
 * @apiParam {String} rule_id 策略ID
 * @apiParam {String} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiParam {String} auto_mapped  默认“0”
 * @apiParam {String} protocol 协议类型
 * @apiParam {String} static_outside_addr 外部地址
 * @apiParam {String} static_inside_addr 内部地址
 * @apiParam {String} static_ifname 外部接口
 * @apiParam {String} unit_id   单元ID
 * @apiParam {Number} desc 描述信息
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"type": "1",
 *		},
 *	"total": 1
 *	}
 */

/**
 * @api {POST} /api/nat 添加静态NAT地址策略
 * @apiName 添加静态NAT地址策略
 * @apiGroup NAT策略
 *
 * @apiParam {Number} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiParam {String} log 日志，1表示开启日志，0表示未开启日志
 * @apiParam {String} auto_mapped 默认“0”
 * @apiParam {String} rule_id 策略ID
 * @apiParam {String} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiParam {String} protocol 协议类型
 * @apiParam {String} static_outside_addr 外部地址
 * @apiParam {String} static_inside_addr 内部地址
 * @apiParam {String} static_ifname 外部接口
 * @apiParam {String} unit_id 单元ID
 * @apiParam {Number} desc 描述信息
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"log": "1",
 *			"rule_id": "1",
 *			"dst_port_valid": "0",
 *		    "auto_mapped": "0",
 *			"type": "1",
 *			"protocol": "1",
 *			"static_outside_addr": "3.3.3.3",
 *			"static_inside_addr": "4.4.4.4",
 *			"static_ifname": "ge0/4",
 *			"unit_id": "1",
 *			"desc": "static_nat"
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
 * @api {PUT} /api/nat 修改静态NAT地址策略
 * @apiName 修改静态NAT地址策略
 * @apiGroup NAT策略
 *
 *
 * @apiParam {Number} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiParam {String} log 日志，1表示开启日志，0表示未开启日志
 * @apiParam {String} auto_mapped 默认“0”
 * @apiParam {String} rule_id 策略ID
 * @apiParam {String} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiParam {String} protocol 协议类型
 * @apiParam {String} static_outside_addr 外部地址
 * @apiParam {String} static_inside_addr 内部地址
 * @apiParam {String} static_ifname 外部接口
 * @apiParam {String} unit_id 单元ID
 * @apiParam {Number} desc 描述信息
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"log": "1",
 *			"rule_id": "1",
 *			"dst_port_valid": "0",
 *		    "auto_mapped": "0",
 *			"type": "1",
 *			"protocol": "1",
 *			"static_outside_addr": "3.3.3.3",
 *			"static_inside_addr": "5.5.5.5",
 *			"static_ifname": "ge0/4",
 *			"unit_id": "1",
 *			"desc": "static_nat"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success"
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
 * @api {DELETE} /api/nat 删除静态NAT地址策略
 * @apiName 删除静态NAT地址策略
 * @apiGroup NAT策略
 *
 *
 * @apiParam {Number} type 1表示静态NAT；2表示源NAT；4表示目的NAT
 * @apiParam {String} log 日志，1表示开启日志，0表示未开启日志
 * @apiParam {String} auto_mapped 默认 ”0“
 * @apiParam {String} rule_id 策略ID
 * @apiParam {String} dst_port_valid 转换后端口是否开启标志位，0表示未开启，1表示开启
 * @apiParam {String} protocol 协议类型
 * @apiParam {String} static_outside_addr 外部地址
 * @apiParam {String} static_inside_addr 内部地址
 * @apiParam {String} static_ifname 外部接口
 * @apiParam {String} unit_id 单元ID
 * @apiParam {Number} desc 描述信息
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"log": "1",
 *		"rule_id": "1",
 *		"dst_port_valid": "0",
 *		"auto_mapped": "0",
 *		"type": "1",
 *		"protocol": "1",
 *		"static_outside_addr": "3.3.3.3",
 *		"static_inside_addr": "4.4.4.4",
 *		"static_ifname": "ge0/4",
 *		"unit_id": "1",
 *		"desc": "static_nat"
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

class NatController extends mController{
	public $module = 'nat_rule_table';
}

