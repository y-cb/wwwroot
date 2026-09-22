<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET} /api/ndp-bind  获取NDP表中静态IPMAC地址绑定表项
 * @apiName  获取ARP表中静态IPMAC地址绑定
 * @apiGroup ARP
 *
 *
 * @apiSuccess {Number} unique 	静态IPMAC地址绑定表项是否唯一，唯一为 1 ，不唯一为 0 
 * @apiSuccess {Number} ip  IP地址
 * @apiSuccess {String} mac  MAC地址
 * @apiSuccess {String} name  IPMAC地址绑定策略的描述（默认为空）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{"ip": "1.1.1.5", 
 *		 "mac": "aa:cc:cc:cc:cc:cb", 
 *		 "unique": "1", 
 *		 "name": "aaa"
 *		},
 *		{"ip": "1.1.1.6", 
 *		 "mac": "aa:cc:cc:cc:cc:cc", 
 *		 "unique": "1", 
 *		 "name": "AAAAA"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST} /api/ndp-bind  添加静态IPMAC地址绑定表项
 * @apiName  添加静态IPMAC地址绑定表项
 * @apiGroup  ARP
 *
 *
 * @apiSuccess {Number} ip  IP地址
 * @apiSuccess {String} mac  MAC地址
 * @apiSuccess {String} name  IPMAC地址绑定策略的描述（默认为空）
 * @apiSuccess {Number} unique 	静态IPMAC地址绑定表项是否唯一，唯一为 1 ，不唯一为 0 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ip": "1.1.1.6", 
 *		"mac": "aa:cc:cc:cc:cc:cc", 
 *		"unique": "1", 
 *		"name": "AAAAA"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"126",
 *		"str":"IP\u5730\u5740\u5df2\u88ab\u9759\u6001arp\u4f7f\u7528"
 *	}
 *
 */

/**
 * @api {PUT} /api/ndp-bind 修改静态IPMAC地址绑定表项
 * @apiName 修改静态IPMAC地址绑定表项
 * @apiGroup ARP
 *
 *
 * @apiSuccess {Number} ip  IP地址
 * @apiSuccess {String} mac  MAC地址
 * @apiSuccess {String} name  IPMAC地址绑定策略的描述（默认为空）
 * @apiSuccess {Number} unique 	静态IPMAC地址绑定表项是否唯一，唯一为 1 ，不唯一为 0 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ip": "1.1.1.6", 
 *		"old_ip": "1.1.1.6", 
 *		"mac": "aa:cc:cc:cc:cc:ca", 
 *		"old_mac": "aa:cc:cc:cc:cc:cc",
 *		"unique": "1", 
 *		"name": "AAAAA"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"291",
 *		"str":"MAC\u5730\u5740\u5df2\u7ecf\u88ab\u9759\u6001arp\u4f7f\u7528"
 *	}
 *
 */

/**
 * @api {DELETE} /api/ndp-bind 删除静态IPMAC地址绑定表项
 * @apiName 删除静态IPMAC地址绑定表项
 * @apiGroup ARP
 *
 *
 * @apiSuccess {Number} ip  IP地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ip": "1.1.1.6", 
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"294",
 *		"str":"\u8d44\u6e90\u4e0d\u5b58\u5728"
 *	}
 *
 */


class NDPBindController extends mController{
	public $module = 'ipv6_mac_bind';
}

?>
