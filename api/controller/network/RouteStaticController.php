<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-static 查询ipv4静态路由信息
 * @apiName 查询ipv4静态路由信息
 * @apiGroup IPv4路由
 *
 * @apiSuccess {Number} flag  启用，0：禁用，1：启用
 * @apiSuccess {String} dst_ip  目的IP
 * @apiSuccess {Number} nh_type  出接口/下一跳，0：下一跳，1：出接口
 * @apiSuccess {String} nh_ip  下一跳
 * @apiSuccess {String} oif  出接口，可选隧道接口、GRE接口
 * @apiSuccess {String} monitor_name  健康检查对象
 * @apiSuccess {Number} distance  距离，范围：1-255
 * @apiSuccess {Number} weigh  权重，范围：1-100
 * @apiSuccess {String} vrf_name  ipv4静态路由所属vrf名称，4.1版本已经不用
 * @apiSuccess {String} monitor_name  健康检查，范围（1-63）支持中英文大小写、数字以及@。._-|()[]字符
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"dst_ip": "0.0.0.0/0",
 *			"nh_type": "0",
 *			"nh_ip": "172.16.0.1",
 *			"oif": "",
 *			"monitor_name": "",
 *			"distance": "1",
 *			"weigh": "2",
 *			"vrf_name": "vrf0"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/route-static 新建ipv4静态路由信息
 * @apiName 新建ipv4静态路由信息
 * @apiGroup IPv4路由
 *
 * @apiParam {Number} flag  启用，0：禁用，1：启用
 * @apiParam {String} dst_ip  目的IP
 * @apiParam {Number} nh_type  出接口/下一跳，0：下一跳，1：出接口
 * @apiParam {String} nh_ip  下一跳
 * @apiParam {String} oif  出接口，可选隧道接口、GRE接口
 * @apiParam {String} monitor_name  健康检查对象
 * @apiParam {Number} distance  距离，范围：1-255
 * @apiParam {Number} weigh  权重，范围：1-100
 * @apiParam {String} vrf_name  ipv4静态路由所属vrf名称，4.1版本已经不用
 * @apiParam {String} monitor_name  健康检查，范围（1-63）支持中英文大小写、数字以及@。._-|()[]字符
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_ip": "0.0.0.0/0",
 *			"nh_type": "0",
 *			"nh_ip": "172.16.0.1",
 *			"oif": "",
 *			"monitor_name": "",
 *			"distance": "1",
 *			"weigh": "2",
 *			"vrf_name": "vrf0"
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
 * @api {PUT}  /api/route-static 修改ipv4静态路由信息
 * @apiName 修改ipv4静态路由信息
 * @apiGroup IPv4路由
 *
 * @apiParam {Number} flag  启用，0：禁用，1：启用
 * @apiParam {String} dst_ip  目的IP
 * @apiParam {Number} nh_type  出接口/下一跳，0：下一跳，1：出接口
 * @apiParam {String} nh_ip  下一跳
 * @apiParam {String} oif  出接口，可选隧道接口、GRE接口
 * @apiParam {String} monitor_name  健康检查对象
 * @apiParam {Number} distance  距离，范围：1-255
 * @apiParam {Number} weigh  权重，范围：1-100
 * @apiParam {String} vrf_name  ipv4静态路由所属vrf名称，4.1版本已经不用
 * @apiParam {String} monitor_name  健康检查，范围（1-63）支持中英文大小写、数字以及@。._-|()[]字符
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_ip": "0.0.0.0/0",
 *			"nh_type": "0",
 *			"nh_ip": "172.16.0.1",
 *			"oif": "",
 *			"monitor_name": "",
 *			"distance": "1",
 *			"weigh": "2",
 *			"vrf_name": "vrf0"
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
 * @api {DELETE}  /api/route-static 删除ipv4静态路由信息
 * @apiName 删除ipv4静态路由信息
 * @apiGroup IPv4路由
 *
 * @apiParam {Number} flag  启用，0：禁用，1：启用
 * @apiParam {String} dst_ip  目的IP
 * @apiParam {Number} nh_type  出接口/下一跳
 * @apiParam {String} nh_ip  下一跳
 * @apiParam {String} oif  出接口
 * @apiParam {Number} distance  距离，范围：1-255
 * @apiParam {Number} weigh  权重，范围：1-100
 * @apiParam {String} vrf_name  ipv4静态路由所属vrf名称，4.1版本已经不用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_ip": "0.0.0.0/0",
 *			"nh_type": "0",
 *			"nh_ip": "172.16.0.1",
 *			"oif": "",
 *			"vrf_name": "vrf0"
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


class RouteStaticController extends mController{
	public $module = 'static_route';
}

?>
