<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET} /api/dns-server 获取DNS服务器监听IP地址
 * @apiName 获取DNS服务器监听IP地址
 * @apiGroup DNS
 *
 *
 * @apiSuccess {String} addr  DNS服务器，ipv4地址
 * @apiSuccess {String} addr6  DNS服务器，ipv6地址
 * @apiSuccess {Number} type  地址类型 0：ipv4  1：ipv6
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"addr": "172.16.0.123",
 *			"type": "0"
 *		},
 *		{
 *			"addr6": "2001::2",
 *			"type": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST} /api/dns-server 添加DNS服务器监听IP地址
 * @apiName 添加DNS服务器监听IP地址
 * @apiGroup DNS
 *
 * @apiParam {String} dns_forwarder  DNS转发服务器地址
 * @apiParam {Array} addrs  DNS服务器地址数组
 * @apiParam {String} addr  DNS服务器ipv4地址
 * @apiParam {String} addr6  DNS服务器ipv6地址
 * @apiParam {Number} type  地址类型 0：ipv4  1：ipv6
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"dns_forwarder": "1.1.1.2",
 *		"data": [
 *		{
 *			"addr": "172.16.0.123",
 *			"type": "0"
 *		},
 *		{
 *			"addr6": "2001::2",
 *			"type": "1"
 *		}
 *	],
 *	"total": 2
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
 *		"code":"-1",
 *		"str":""
 *	}
 *
 */


class DnsServerController extends mController{
	public $module = 'listener';
}

?>
