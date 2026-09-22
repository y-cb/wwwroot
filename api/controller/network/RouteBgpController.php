<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-bgp 查询BGP基础配置
 * @apiName 查询BGP基础配置
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {Number} local_as  本地AS  1-4294967295
 * @apiSuccess {String} route_id  路由器ID
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"local_as": "1000",
 *			"route_id": "1.1.1.1"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/route-bgp 新增BGP基础配置
 * @apiName 新增BGP基础配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} local_as  本地AS, 1-4294967295
 * @apiParam {String} route_id  路由器ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"local_as": "10000",
 *		"route_id": "1.1.1.1"
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
 * @api {PUT}  /api/route-bgp 修改BGP基础配置
 * @apiName 修改BGP基础配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} local_as  本地AS, 1-4294967295
 * @apiParam {String} route_id  路由器ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"local_as": "20000",
 *		"route_id": "1.1.1.1"
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
 * @api {DELETE}  /api/route-bgp 删除BGP基础配置
 * @apiName 删除BGP基础配置
 * @apiGroup IPv4路由
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
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


class RouteBgpController extends mController{
	public $module = 'bgp_info';
}

?>