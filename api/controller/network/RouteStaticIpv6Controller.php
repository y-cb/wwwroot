<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route6-static 查询ipv6静态路由
 * @apiName 查询ipv6静态路由
 * @apiGroup IPv6静态路由
 *
 *
 * @apiSuccess {String} dst_ip  目的地址
 * @apiSuccess {Number} nh_type  出接口/下一跳地址，0：下一跳地址，1：出接口，2：下一跳地址和出接口
 * @apiSuccess {String} nh_ip  下一跳地址
 * @apiSuccess {String} oif  出接口，可选隧道接口、GRE接口
 * @apiSuccess {Number} distance  距离，范围：1-255
 * @apiSuccess {Number} weigh  权重，范围：1-100
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"dst_ip": "5001::/64",
 *			"nh_type": "1",
 *			"nh_ip": "",
 *			"oif": "ge0/0",
 *			"distance": "1",
 *			"weigh": "1"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/route6-static 添加ipv6静态路由
 * @apiName 添加ipv6静态路由
 * @apiGroup IPv6静态路由
 *
 *
 * @apiParam {String} dst_ip  目的地址
 * @apiParam {Number} nh_type  出接口/下一跳地址，0：下一跳地址，1：出接口，2：下一跳地址和出接口
 * @apiParam {String} nh_ip  下一跳地址
 * @apiParam {String} oif  出接口，可选隧道接口、GRE接口
 * @apiParam {Number} distance  距离，范围：1-255
 * @apiParam {Number} weigh  权重，范围：1-100
 *
 * @apiSuccessExample {json} Request-Example:
 *	{
 *		"dst_ip": "5001::/64",
 *		"nh_type": "1",
 *		"nh_ip": "",
 *		"oif": "ge0/0",
 *		"distance": "1",
 *		"weigh": "1"
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
 * @api {DELETE}  /api/route6-static 删除ipv6静态路由
 * @apiName 删除ipv6静态路由
 * @apiGroup IPv6静态路由
 *
 *
 * @apiParam {String} dst_ip  目的地址
 * @apiParam {Number} nh_type  出接口/下一跳地址，0：下一跳地址，1：出接口，2：下一跳地址和出接口
 * @apiParam {String} nh_ip  下一跳地址
 * @apiParam {String} oif  出接口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_ip": "5001::/64",
 *			"nh_type": "1",
 *			"nh_ip": "",
 *			"oif": "ge0/0"
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


class RouteStaticIpv6Controller extends mController{
	public $module = 'static_route6';
}

?>
