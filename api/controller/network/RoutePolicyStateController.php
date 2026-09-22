<?php
namespace controller\network;
use controller\mController;


/**
 * @api {PUT}  /api/route-policy-state 清除策略路由命中数
 * @apiName 清除策略路由命中数
 * @apiGroup IPv4路由，IPv6路由
 *
 *
 * @apiParam {String} id  目标策略路由
 * @apiParam {Number} type  策略路由类型，0表示IPv4路由，1表示IPv4 ISP路由，2表示IPv6路由
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"id": "1",
 *			"type": "0",
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


class RoutePolicyStateController extends mController{
	public $module = 'fplcy_stats';
}

?>
