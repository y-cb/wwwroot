<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/sslvpn-config 查询sslvpn配置信息
 * @apiName 查询sslvpn配置信息
 * @apiGroup SSL VPN
 *
 *
 * @apiSuccess {Number} enable  使能/去使能sslvpn功能开关，1：启用，0：禁用，不可为空
 * @apiSuccess {Number} duplicate_cn  使能/去使能sslvpn多点登录功能，1：启用，0：禁用
 * @apiSuccess {String} dns1  dns1，例如：192.168.0.100
 * @apiSuccess {String} dns2  dns2，例如：192.168.0.100
 * @apiSuccess {String} wins1  wins1，例如：192.168.0.100
 * @apiSuccess {String} wins2  wins2，例如：192.168.0.100
 * @apiSuccess {String} address_pool  地址池，例如：192.168.0.0/24
 * @apiSuccess {String} gw  隧道地址，例如：192.168.0.100/24
 * @apiSuccess {Array} route_items  推送至客户端的路由
 * @apiSuccess {String} intranet_route  推送至客户端的路由，例如：192.168.0.100/24
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"enable": "1",
 *			"duplicate_cn": "1",
 *			"dns1": "1.1.1.1",
 *			"dns2": "2.2.2.2",
 *			"wins1": "3.3.3.3",
 *			"wins2": "4.4.4.4",
 *			"address_pool": "10.0.0.0/24",
 *			"gw": "10.0.0.1/24",
 *			"route_items": "{u'group': [{u'intranet_route': u'20.0.0.0/24'}, {u'intranet_route': u'30.0.0.0/24'}]}"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/sslvpn-config 修改sslvpn配置信息
 * @apiName 修改sslvpn配置信息
 * @apiGroup SSL VPN
 *
 *
 * @apiParam {Number} enable  使能/去使能sslvpn功能开关，1：启用，0：禁用
 * @apiParam {Number} duplicate_cn  使能/去使能sslvpn多点登录功能，1：启用，0：禁用
 * @apiParam {String} dns1  dns1，例如：192.168.0.100
 * @apiParam {String} dns2  dns2，例如：192.168.0.100
 * @apiParam {String} wins1  wins1，例如：192.168.0.100
 * @apiParam {String} wins2  wins2，例如：192.168.0.100
 * @apiParam {String} address_pool  地址池，例如：192.168.0.0/24
 * @apiParam {String} gw  隧道地址，例如：192.168.0.100/24
 * @apiParam {Array} route_items  推送至客户端的路由
 * @apiParam {String} intranet_route  推送至客户端的路由，例如：192.168.0.100/24
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
 *		"duplicate_cn": "1",
 *		"dns1": "1.1.1.1",
 *		"dns2": "2.2.2.2",
 *		"wins1": "3.3.3.3",
 *		"wins2": "4.4.4.4",
 *		"address_pool": "10.0.0.0/24",
 *		"gw": "10.0.0.1/24",
 *		"route_items[0][intranet_route]": "111.0.0.0/24",
 *		"route_items[1][intranet_route]": "222.0.0.0/24"
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


class SslvpnConfigController extends mController{
	public $module = 'sslvpn_config';
}

?>
