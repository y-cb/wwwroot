<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-ipv4 查询ipv4路由表
 * @apiName 查询ipv4路由表
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {Number} type  路由类型
 * @apiSuccess {String} dst_ip  目的地址
 * @apiSuccess {String} nh_ip  下一跳
 * @apiSuccess {String} oif  出接口
 * @apiSuccess {Number} distance  距离
 * @apiSuccess {Number} weigh  权重
 * @apiSuccess {String} time  持续时间
 * @apiSuccess {Number} status  状态
 * @apiSuccess {String} vrf_name  路由所属VRF名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *
 *		{
 *			"type": "1",
 *			"dst_ip": "172.16.0.139/32",
 *			"nh_ip": "172.16.0.1",
 *			"oif": "ge0/1",
 *			"distance": "19",
 *			"weigh": "1",
 *			"time": "3d19h55m",
 *			"status": "1",
 *			"vrf_name": "vrf0"
 *		}
 *	],
 *	"total": 1
 *	}
 */



class RouteIpv4Controller extends mController{
	public $module = 'rib_table';
}

?>
