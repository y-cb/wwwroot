<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ipsecvpn-tunnel 查询ipsec隧道配置信息
 * @apiName 查询ipsec隧道配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {Number} ikev2  ike版本
 * @apiSuccess {String} tunn_ifname  隧道接口名称
 * @apiSuccess {String} ph2_name  隧道绑定ike二阶段名称
 * @apiSuccess {String} if_address  隧道接口地址
 * @apiSuccess {Number} advertise_routes  自动下发路由
 * @apiSuccess {Array} pair_items  保护网段
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ikev2": "0",
 *			"tunn_ifname": "tunl0",
 *			"ph2_name": "abc",
 *			"if_address": "10.0.0.10/24",
 *			"advertise_routes": "1",
 *			"pair_items": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/ipsecvpn-tunnel 新增ipsec隧道
 * @apiName 新增ipsec隧道
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {Number} ikev2  ike版本
 * @apiParam {String} tunn_ifname  隧道接口名称
 * @apiParam {String} ph2_name  隧道绑定ike二阶段名称
 * @apiParam {String} if_address  隧道接口地址
 * @apiParam {Number} advertise_routes  自动下发路由
 * @apiParam {Array} pair_items  保护网段
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ikev2": "0",
 *		"tunn_ifname": "tunl100",
 *		"ph2_name": "abc",
 *		"if_address": "20.0.0.1/24",
 *		"advertise_routes": "1",
 *		"pair_items[0][src]": "10.0.0.0/24",
 *		"pair_items[0][dst]": "20.0.0.0/24"
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
 * @api {PUT}  /api/ipsecvpn-tunnel 修改ipsec隧道
 * @apiName 修改ipsec隧道
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {Number} ikev2  ike版本
 * @apiParam {String} tunn_ifname  隧道接口名称
 * @apiParam {String} ph2_name  隧道绑定ike二阶段名称
 * @apiParam {String} if_address  隧道接口地址
 * @apiParam {Number} advertise_routes  自动下发路由
 * @apiParam {Array} pair_items  保护网段
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ikev2": "0",
 *		"tunn_ifname": "tunl100",
 *		"ph2_name": "abc",
 *		"if_address": "20.0.0.1/24",
 *		"advertise_routes": "1",
 *		"pair_items[0][src]": "10.0.0.0/24",
 *		"pair_items[0][dst]": "20.0.0.0/24"
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
 * @api {DELETE}  /api/ipsecvpn-tunnel 删除ipsec隧道
 * @apiName 删除ipsec隧道
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} tunn_ifname  隧道名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"tunn_ifname": "tunl100"
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
 * @api {get}  /api/ipsecvpn-tunnel 获取IPsec-VPN隧道策略
 * @apiName 获取IPsec-VPN隧道策略
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} tunn_ifname IPsec-VPN隧道名称
 * @apiSuccess {String} if_address IPv4地址
 * @apiSuccess {String} ph2_name IPsec名称
 * @apiSuccess {Array} pair_item 项目地址，src为源地址，dst为目的地址
 * @apiSuccess {Number} advertise_routes 是否启用自动添加路由，0表示不启用，1表示启用
 * @apiSuccess {Number} total IPsec-VPN隧道策略的数量
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "tunn_ifname": "tunl0",
            "if_address": "1.1.1.1/12",
            "ph2_name": "aaa",
            "pair_item": [
            	{ "src":"1.1.3.1/12""dst":"1.1.5.1/12" },
            	{ "src":"1.1.7.1/12""dst":"1.1.8.1/12" }
            	],
            "advertise_routes": "1",
        }
    ],
    "total": 1
    }
 */

class IpsecvpnTunnelController extends mController{
	public $module = 'vpn_ipsec_tunn_if';
}

?>
