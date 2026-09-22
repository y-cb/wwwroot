<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/rip-interface 查询rip发布接口信息
 * @apiName 查询rip发布接口信息
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} ifname  接口名称
 * @apiSuccess {Number} sversion  发送版本号
 * @apiSuccess {Number} rversion  接收版本号
 * @apiSuccess {String} auth_type  认证类型  {none  text  md5}
 * @apiSuccess {String} auth_string  最长16字节
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ifname": "ge0/0",
 *			"sversion": "1",
 *			"rversion": "1",
 *			"auth_type": "md5",
 *			"auth_string": "123456"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/rip-interface 新增rip发布接口信息
 * @apiName 新增rip发布接口信息
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} sversion  发送版本号
 * @apiParam {Number} rversion  接收版本号
 * @apiParam {String} auth_type  认证类型, {none, text, md5}
 * @apiParam {String} auth_string  最长16字节
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifname": "ge0/0",
 *		"sversion": "2",
 *		"rversion": "2",
 *		"auth_type": "test",
 *		"auth_string": "654321"
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
 * @api {DELETE}  /api/rip-interface 删除rip发布接口信息
 * @apiName 删除rip发布接口信息
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} ifname  XXX 此处替换为对ifname,的中文注释
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifname": "ge0/0"
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


class RipInterfaceController extends mController{
	public $module = 'rip_interface';
}

?>
