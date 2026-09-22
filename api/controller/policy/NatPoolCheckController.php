<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nat-pool 获取NAT地址池列表
 * @apiName 获取NAT地址池列表
 * @apiGroup NAT策略
 *
 *
 * @apiSuccess {String} name NAT地址池名称
 * @apiSuccess {String} desc 描述
 * @apiSuccess {Number} rotary 算法选择，0:源目的地址哈希 1:轮询 2：源地址保持
 * @apiSuccess {Number} ref 引用计数
 * @apiSuccess {Number} protocol 协议类型
 * @apiSuccess {Array} item 配置的IP地址集合
 * @apiSuccess {String} min_ip ipv4起始地址
 * @apiSuccess {String} max_ip ipv4结束地址
 * @apiSuccess {String} min_ip6 ipv6起始地址
 * @apiSuccess {String} max_ip6 ipv6结束地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "aaa",
 *			"desc": "nat-pool-aaa",
 *			"rotary": "2",
 *			"ref": "0",
 *			"protocol": "1",
 *			"item": "",
 *			"min_ip": "2.2.2.2",
 *			"max_ip": "2.2.2.2",
 *			"min_ip6": "2000::2",
 *			"max_ip6": "2000::2"
 *		},
 *	],
 *	"total": 1
 *	}
 */

/** 
 * @api {POST} /api/nat-pool 添加NAT地址池
 * @apiName 添加NAT地址池
 * @apiGroup NAT策略
 *
 *
 * @apiParam {String} name  NAT地址池名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} rotary 算法选择，0:源目的地址哈希 1:轮询 2：源地址保持
 * @apiParam {Number} ref 引用计数
 * @apiParam {Number} protocol 协议类型
 * @apiParam {Array} item 配置的IP地址集合
 * @apiParam {String} min_ip ipv4起始地址
 * @apiParam {String} max_ip ipv4结束地址
 * @apiParam {String} min_ip6 ipv6起始地址
 * @apiParam {String} max_ip6 ipv6结束地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaa",
 *		"desc": "nat-pool-aaa",
 *		"rotary": "2",
 *		"ref": "0",
 *		"protocol": "1",
 *		"item": "",
 *		"min_ip": "2.2.2.6",
 *		"max_ip": "2.2.2.7",
 *		"min_ip6": "2000::6",
 *		"max_ip6": "2000::7"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {PUT} /api/nat-pool 修改NAT地址池
 * @apiName 修改NAT地址池
 * @apiGroup NAT策略
 *
 * @apiParam {String} name NAT地址池名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} rotary 算法选择，0:源目的地址哈希 1:轮询 2：源地址保持
 * @apiParam {Number} ref 引用计数
 * @apiParam {Number} protocol 协议类型
 * @apiParam {Array} item  配置的IP地址集合
 * @apiParam {String} min_ip ipv4起始地址
 * @apiParam {String} max_ip ipv4结束地址
 * @apiParam {String} min_ip6 ipv6起始地址
 * @apiParam {String} max_ip6 ipv6结束地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaa",
 *		"desc": "nat-pool-aaa",
 *		"rotary": "2",
 *		"ref": "0",
 *		"protocol": "1",
 *		"item": "",
 *		"min_ip": "3.3.3.3",
 *		"max_ip": "3.3.3.3",
 *		"min_ip6": "2000::8",
 *		"max_ip6": "2000::8"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {DELETE} /api/nat-pool 删除NAT地址池
 * @apiName 删除NAT地址池
 * @apiGroup NAT策略
 *
 *
 * @apiParam {String} name NAT地址池名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} rotary 算法选择，0:源目的地址哈希 1:轮询 2：源地址保持
 * @apiParam {Number} ref 引用计数
 * @apiParam {Number} protocol 协议类型
 * @apiParam {Array} item 配置的IP地址集合
 * @apiParam {String} min_ip ipv4起始地址
 * @apiParam {String} max_ip ipv结束地址
 * @apiParam {String} min_ip6 ipv6起始地址
 * @apiParam {String} max_ip6 ipv6结束地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaa",
 *		"desc": "nat-pool-aaa",
 *		"rotary": "2",
 *		"ref": "0",
 *		"protocol": "1",
 *		"item": "",
 *		"min_ip": "2.2.2.6",
 *		"max_ip": "2.2.2.7",
 *		"min_ip6": "2000::6",
 *		"max_ip6": "2000::7"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */



class NatPoolCheckController extends mController{
	public $module = 'nat_pool_check_table';
}

