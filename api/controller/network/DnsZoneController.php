<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET} /api/dns-zone 获取DNS ZONE信息
 * @apiName 获取DNS ZONE信息
 * @apiGroup DNS
 *
 *
 * @apiSuccess {String} zone_name  DNS域名
 * @apiSuccess {String} master  主服务器域名
 * @apiSuccess {String} mail  邮箱地址
 * @apiSuccess {String} ns_name  域名服务器域名
 * @apiSuccess {String} ns_ip  域名服务器IP地址
 * @apiSuccess {String} ns_ip6  域名服务器IPV6地址
 * @apiSuccess {Number} ttl  TTL 0-214748364 秒
 * @apiSuccess {Number} expire  到期时间 1-214748364 秒
 * @apiSuccess {Number} refresh  刷新时间 1-214748364 秒
 * @apiSuccess {Number} retry  重试时间 1-214748364 秒
 * @apiSuccess {Number} negative_ttl  错误缓存时间 1-214748364 秒
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"zone_name": "aa.com",
 *			"rr_num": "3",
 *			"default_ttl": "86400"
 *		},
 *		{
 *			"zone_name": "sunya.com",
 *			"rr_num": "2",
 *			"default_ttl": "86400"
 *		}
 *	],
 *	"total": 2
 *	}
 */

 /**
 * @api {GET} /api/dns-zone 获取指定DNS ZONE信息
 * @apiName 获取指定DNS ZONE信息
 * @apiGroup DNS
 *
 *
 * @apiParam {String} op  detail
 * @apiParam {String} zone_name  DNS域名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"zone_name": "aa.com",
 *		"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"zone_name":"aa.com",
 *		"master":"www.aa.com",
 *		"mail":"test@qq.com",
 *		"ttl":"86400",
 *		"retry":"3600",
 *		"refresh":"10800",
 *		"expire":"10800",
 *		"negative_ttl":"3600"
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
 *		"code":"非0"
 *	}
 *
 */
 
/**
 * @api {POST} /api/dns-zone 添加DNS ZONE
 * @apiName 添加DNS ZONE
 * @apiGroup DNS
 *
 *
 * @apiSuccess {String} zone_name  DNS域名
 * @apiSuccess {String} master  主服务器域名
 * @apiSuccess {String} mail  邮箱地址
 * @apiSuccess {String} ns_name  域名服务器域名
 * @apiSuccess {String} ns_ip  域名服务器IP地址
 * @apiSuccess {String} ns_ip6  域名服务器IPV6地址
 * @apiSuccess {Number} ttl  TTL 0-214748364 秒
 * @apiSuccess {Number} expire  到期时间 1-214748364 秒
 * @apiSuccess {Number} refresh  刷新时间 1-214748364 秒
 * @apiSuccess {Number} retry  重试时间 1-214748364 秒
 * @apiSuccess {Number} negative_ttl  错误缓存时间 1-214748364 秒
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"zone_name": "sunya.com",
 *		"master": "www.sunya.com",
 *		"mail": "sunya@163.com",
 *		"ns_name": "ns.sunya.com",
 *		"ns_ip": "1.1.1.1",
 *		"ns_ip6": "2001::1",
 *		"ttl": "86400",
 *		"expire": "604800",
 *		"refresh": "10800",
 *		"retry": "3600",
 *		"negative_ttl": "3600"
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
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {PUT} /api/dns-zone 修改DNS域参数
 * @apiName 修改DNS域参数
 * @apiGroup DNS
 *
 *
 * @apiSuccess {String} zone_name  DNS域名
 * @apiSuccess {String} master  主服务器域名
 * @apiSuccess {String} mail  邮箱地址
 * @apiSuccess {String} ns_name  域名服务器域名
 * @apiSuccess {String} ns_ip  域名服务器IP地址
 * @apiSuccess {String} ns_ip6  域名服务器IPV6地址
 * @apiSuccess {Number} ttl  TTL 0-214748364 秒
 * @apiSuccess {Number} expire  到期时间 1-214748364 秒
 * @apiSuccess {Number} refresh  刷新时间 1-214748364 秒
 * @apiSuccess {Number} retry  重试时间 1-214748364 秒
 * @apiSuccess {Number} negative_ttl  错误缓存时间 1-214748364 秒
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"zone_name": "sunya.com",
 *		"master": "www.sunya.com",
 *		"mail": "test@163.com",
 *		"ns_name": "ns.sunya.com",
 *		"ns_ip": "1.1.1.1",
 *		"ns_ip6": "2001::1",
 *		"ttl": "86400",
 *		"expire": "604800",
 *		"refresh": "10800",
 *		"retry": "3600",
 *		"negative_ttl": "3600"
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
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {DELETE} /api/dns-zone 删除DNS域
 * @apiName 删除DNS域
 * @apiGroup DNS
 *
 *
 * @apiParam {String} zone_name  DNS域名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"zone_name": "sunya.com"
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
 *		"code":"非0"
 *	}
 *
 */


class DnsZoneController extends mController{
	public $module = 'dns_zone';
}

?>
