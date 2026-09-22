<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET} /api/loopback-ipv6 获取ipv6环回接口ip地址
 * @apiName  获取ipv6环回接口ip地址配置
 * @apiGroup 接口配置
 *
 *
 * @apiParam {Number} get_type  获取环回接口类型,目前只支持类型1
 * @apiSuccess {String} selfip  环回接口的接口ipv6地址信息 格式为xxxx::xxx::XXX/XXX
 * @apiSuccess {String} vlan_name  环回接口名称lo
 * @apiSuccess {Number} is_floating_ip， 是否为浮动ip地址 后台保留字段，暂不使用
 * @apiSuccess {Number} unit_id  单元id， 后台保留字段，暂不使用
 * 
 * @apiParamExample {json} Request-Example:
 *	{
 *		"get_type": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"selfip": "3000:506::111/100",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0"
 *		},
 *		{
 *			"selfip": "3000:600::111/100",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST} /api/loopback-ipv6 新增ipv6环回接口ip地址
 * @apiName  获取ipv6环回接口ip地址配置
 * @apiGroup 接口配置
 *
 * @apiSuccess {String} selfip  环回接口的接口ipv6地址信息 格式为xxxx::xxx::XXX/XXX
 * @apiSuccess {String} vlan_name  环回接口名称lo
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "4000:506::111/64",
 *		"vlan_name": "lo"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"35"
 *	}
 */

/**
 * @api {PUT} /api/loopback-ipv6 修改ipv6环回接口ip地址
 * @apiName  获取ipv6环回接口ip地址配置
 * @apiGroup 接口配置
 *
 * @apiSuccess {String} selfip  环回接口的接口ipv6地址信息 格式为xxxx::xxx::XXX/XXX
 * @apiSuccess {String} vlan_name  环回接口名称lo
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "4000:506::111/64",
 *		"vlan_name": "lo"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"173"
 *	}
 *
 */

/**
 * @api {PUT} /api/loopback-ipv6 删除ipv6环回接口ip地址
 * @apiName  获取ipv6环回接口ip地址配置
 * @apiGroup 接口配置
 *
 * @apiSuccess {String} selfip  环回接口的接口ipv6地址信息 格式为xxxx::xxx::XXX/XXX
 * @apiSuccess {String} vlan_name  环回接口名称lo
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "4000:506::111/64",
 *		"vlan_name": "lo"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 */


class LoopbackIPv6Controller extends mController{
	public $module = 'tb_selfip_ipv6';
}
