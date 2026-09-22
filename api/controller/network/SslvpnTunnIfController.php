<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/sslvpn-tunn-if 查询sslvpn接口配置
 * @apiName 查询sslvpn接口配置
 * @apiGroup SSL VPN
 *
 *
 * @apiSuccess {String} tunn_ifname  用户名
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} https  接口访问控制，能否以 https 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} telnet  接口访问控制，能否以 telnet 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} ping  接口访问控制，接口能否被ping通，1：启用，0：禁用
 * @apiSuccess {Number} ssh  接口访问控制，能否以 ssh 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} webauth  接口访问控制，控制接口能否被 webauth 的方式访问，1：启用，0：禁用
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"tunn_ifname": "tunl1023",
 *			"http": "1",
 *			"https": "1",
 *			"ping": "1",
 *			"telnet": "0",
 *			"ssh": "0",
 *			"sslvpn": "0",
 *			"bgp": "0",
 *			"ospf": "0",
 *			"rip": "0",
 *			"dns": "0",
 *			"webauth": "0"
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/sslvpn-tunn-if 修改sslvpn接口配置
 * @apiName 根据传入的参数修改sslvpn接口配置
 * @apiGroup SSl VPN
 *
 *
 * @apiSuccess {String} tunn_ifname  用户名
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} https  接口访问控制，能否以 https 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} telnet  接口访问控制，能否以 telnet 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} ping  接口访问控制，接口能否被ping通，1：启用，0：禁用
 * @apiSuccess {Number} ssh  接口访问控制，能否以 ssh 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问，1：启用，0：禁用
 * @apiSuccess {Number} webauth  接口访问控制，控制接口能否被 webauth 的方式访问，1：启用，0：禁用
 *
 * @apiParamExample {json} Request-Example:
 
 *{
 *			"tunn_ifname": "tunl1023",
 *			"http": "1",
 *			"https": "1",
 *			"ping": "1",
 *			"telnet": "0",
 *			"ssh": "0",
 *			"sslvpn": "0",
 *			"bgp": "0",
 *			"ospf": "0",
 *			"rip": "0",
 *			"dns": "0",
 *			"webauth": "0"
 *}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
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



class SslvpnTunnIfController extends mController{
	public $module = 'sslvpn_tunn_if';
}

?>
