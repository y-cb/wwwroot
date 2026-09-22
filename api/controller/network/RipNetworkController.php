<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/rip-network 查询rip发布网络
 * @apiName 查询rip发布网络
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} addr  发布网络
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"addr": "10.0.0.0/24"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/rip-network 新增rip发布网络
 * @apiName 新增rip发布网络
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} addr  发布网络
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"addr": "10.0.0.0/24"
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
 * @api {DELETE}  /api/rip-network 删除rip发布网络
 * @apiName 删除rip发布网络
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} addr  发布网络
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"addr": "10.0.0.0/24"
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


class RipNetworkController extends mController{
	public $module = 'rip_network';
}

?>
