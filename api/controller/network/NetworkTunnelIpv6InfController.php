<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/tunnel-ipv6-inf 查询ipv6隧道接口
 * @apiName 查询ipv6隧道接口
 * @apiGroup IPv6隧道接口
 *
 *
 * @apiSuccess {String} dst_ip  目的地址
 * @apiSuccess {Number} nh_type  出接口/下一跳
 * @apiSuccess {String} nh_ip  下一跳地址
 * @apiSuccess {String} oif  出接口
 * @apiSuccess {String} monitor_name  健康检查对象名称
 * @apiSuccess {Number} distance  距离
 * @apiSuccess {Number} weigh  权重
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
 *			"monitor_name": "",
 *			"distance": "1",
 *			"weigh": "1"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/tunnel-ipv6-inf 添加ipv6隧道接口
 * @apiName 添加ipv6隧道接口
 * @apiGroup IPv6隧道接口
 *
 *
 * @apiParam {String} dst_ip  目的地址
 * @apiParam {Number} nh_type  出接口/下一跳
 * @apiParam {String} nh_ip  下一跳地址
 * @apiParam {String} oif  出接口
 * @apiParam {String} monitor_name  健康检查对象名称
 * @apiParam {Number} distance  距离
 * @apiParam {Number} weigh  权重
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"dst_ip": "5001::/64",
 *			"nh_type": "1",
 *			"nh_ip": "",
 *			"oif": "ge0/0",
 *			"monitor_name": "",
 *			"distance": "1",
 *			"weigh": "1"
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
 * @api {DELETE}  /api/tunnel-ipv6-inf 删除ipv6隧道接口
 * @apiName 删除ipv6隧道接口
 * @apiGroup IPv6隧道接口
 *
 *
 * @apiParam {String} dst_ip  目的地址
 * @apiParam {Number} nh_type  出接口/下一跳
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


class NetworkTunnelIpv6InfController extends mController{
	public $module = 'ipv6_tunl_if';
}

?>
