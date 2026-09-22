<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/loopback-ipv4 获取ipv4环回接口ip地址
 * @apiName  获取ipv4环回接口ip地址
 * @apiGroup 网络接口
 *
 *
 * @apiParam {Number} get_type  获取环回接口类型
 * @apiSuccess {String} selfip  环回接口的接口ip地址信息 
 * @apiSuccess {String} mask  环回接口ip地址掩码信息
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
 *			"selfip": "9.9.9.9",
 *			"mask": "255.255.255.0",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0"
 *		},
 *		{
 *			"selfip": "10.10.10.10",
 *			"mask": "255.255.255.0",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/loopback-ipv4 增加ipv4环回接口ip地址
 * @apiName  增加ipv4环回接口ip地址
 * @apiGroup 网络接口
 *
 *
 * @apiSuccess {String} selfip  环回接口的接口ip地址信息 
 * @apiSuccess {String} mask  环回接口ip地址掩码信息
 * @apiSuccess {String} vlan_name  环回接口名称lo
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "10.10.10.10",
 *		"mask": "255.255.255.0",
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
 *
 */

/**
 * @api {PUT}  /api/loopback-ipv4 修改ipv4环回接口ip地址
 * @apiName  修改ipv4环回接口ip地址
 * @apiGroup 网络接口
 *
 *
 * @apiSuccess {String} selfip  环回接口的接口ip地址信息 
 * @apiSuccess {String} mask  环回接口ip地址掩码信息
 * @apiSuccess {String} vlan_name  环回接口名称lo
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "10.10.10.10",
 *		"mask": "255.255.255.0",
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
 * @api {DELETE}  /api/loopback-ipv4 ipv4环回接口配置ip地址删除
 * @apiName  ipv4环回接口ip地址配置
 * @apiGroup 网络接口
 *
 * @apiSuccess {String} selfip  环回接口的接口ip地址信息 
 * @apiSuccess {String} mask  环回接口ip地址掩码信息
 * @apiSuccess {String} vlan_name  环回接口名称lo
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "10.10.10.10",
 *		"mask": "255.255.255.0",
 *		"vlan_name": "lo"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 */


class LoopbackIPv4Controller extends mController{
	public $module = 'tb_selfip';
}

?>
