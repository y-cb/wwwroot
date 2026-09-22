<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/selfip 查询环回接口信息
 * @apiName 查询环回接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} selfip  接口地址
 * @apiSuccess {String} mask  掩码
 * @apiSuccess {String} vlan_name  环回接口名称
 * @apiSuccess {Number} is_floating_ip  是否浮动地址
 * @apiSuccess {Number} get_type  类型
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"selfip": "2.2.2.2",
 *			"mask": "255.255.255.0",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0",
 *			"get_type": "",
 *			"count": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/selfip 新增环回接口信息
 * @apiName 新增环回接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiParam {String} selfip  接口地址
 * @apiParam {String} mask  掩码
 * @apiParam {String} vlan_name  环回接口名称
 * @apiParam {Number} is_floating_ip  是否浮动地址
 * @apiParam {Number} get_type  类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"selfip": "2.2.2.2",
 *			"mask": "255.255.255.0",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0",
 *			"get_type": "",
 *			"count": ""
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/selfip 修改环回接口信息
 * @apiName 修改环回接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiParam {String} selfip  接口地址
 * @apiParam {String} mask  掩码
 * @apiParam {String} vlan_name  环回接口名称
 * @apiParam {Number} is_floating_ip  是否浮动地址
 * @apiParam {Number} get_type  类型
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"selfip": "2.2.2.2",
 *			"mask": "255.255.255.0",
 *			"vlan_name": "lo",
 *			"is_floating_ip": "0",
 *			"unit_id": "0",
 *			"get_type": "",
 *			"count": ""
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/selfip 删除环回接口信息
 * @apiName 删除环回接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiParam {String} selfip  接口地址
 * @apiParam {String} mask  掩码
 * @apiParam {String} vlan_name  环回接口名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"selfip": "2.2.2.2",
 *		"mask": "255.255.255.0",
 *		"vlan_name": "lo"
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */


class SelfIpController extends mController{
	public $module = 'tb_selfip';
}

?>
