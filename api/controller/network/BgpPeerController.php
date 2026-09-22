<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/bgp-peer 获取BGP对等体
 * @apiName 获取BGP对等体
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} neighbor  BGP对等体地址 GET操作可不填写
 * @apiSuccess {Number} remote_as  BGP对等体AS号 GET操作可不填写
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"neighbor": "1.1.1.1",
 *			"remote_as": "10"
 *		},
 *		{
 *			"neighbor": "2.2.2.2",
 *			"remote_as": "20"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/bgp-peer 新增BGP对等体
 * @apiName 新增BGP对等体
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} neighbor  BGP对等体地址
 * @apiParam {Number} remote_as  BGP对等体AS号
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"neighbor": "1.1.1.1",
 *		"remote_as": "10"
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
 * @api {PUT}  /api/bgp-peer 修改BGP对等体
 * @apiName 修改BGP对等体
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} neighbor  BGP对等体地址
 * @apiParam {Number} remote_as  BGP对等体AS号
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"neighbor": "1.1.1.1",
 *		"remote_as": "20"
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
 * @api {DELETE}  /api/bgp-peer 删除BGP对等体
 * @apiName 删除BGP对等体
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} neighbor  BGP对等体地址
 * @apiParam {Number} remote_as  BGP对等体AS号,delete操作可不填写
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"neighbor": "1.1.1.1",
 *		"remote_as": ""
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


class BgpPeerController extends mController{
	public $module = 'bgp_neighbors';
}

?>
