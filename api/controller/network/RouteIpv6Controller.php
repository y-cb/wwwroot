<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-ipv6 查询ipv6路由表
 * @apiName 查询ipv6路由表
 * @apiGroup IPv6路由
 *
 *
 * @apiSuccess {Number} type  路由类型
 * @apiSuccess {String} oif  出接口
 * @apiSuccess {Number} distance  距离
 * @apiSuccess {Number} weigh  权重
 * @apiSuccess {String} time  持续时间
 * @apiSuccess {Number} status  状态
 * @apiSuccess {String} dst_ipv6  目的地址
 * @apiSuccess {String} nh_ipv6  下一跳
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *
 *		{
 *			"type": "1",
 *			"oif": "ge0/3",
 *			"distance": "0",
 *			"weigh": "0",
 *			"time": "3d20h03m",
 *			"status": "1",
 *			"dst_ipv6": "6001::/64",
 *			"nh_ipv6": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */


class RouteIpv6Controller extends mController{
	public $module = 'rib6_table';
}

?>
