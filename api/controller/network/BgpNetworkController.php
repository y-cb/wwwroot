<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/bgp-network 获取BGP发布网络信息
 * @apiName 获取BGP发布网络信息
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} network  BGP发布的网络 对于GET操作可不填写
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"network": "20.0.0.0/24"
 *		},
 *		{
 *			"network": "30.0.0.0/24"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/bgp-network 新增BGP发布网络
 * @apiName 新增BGP发布网络
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} network  需要创建的BGP发布网络
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"network": "20.0.0.0/24"
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
 *		"code":"193",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/bgp-network 删除BGP发布网络
 * @apiName 删除BGP发布网络
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} network  需要删除的BGP发布网络
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"network": "20.0.0.0/24"
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
 *		"code":"491",
 *		"str":""
 *	}
 *
 */


class BgpNetworkController extends mController{
	public $module = 'bgp_network';
}

?>
