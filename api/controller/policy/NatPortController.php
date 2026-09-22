<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/nat-port 获取NAT策略端口管理
 * @apiName 获取NAT策略端口管理
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} proto 协议类型 FTP/TFTP
 * @apiSuccess {Number} port 端口号
 * @apiSuccess {Number} sys 标志位，1表示不能被删除，0表示可以被删除
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"proto": "FTP",
 *			"port": "21",
 *			"sys": "1"
 *		}
 *	"total": 1
 *	}
 */

/**
 * @api {POST} /api/nat-port 添加NAT策略端口管理
 * @apiName 添加NAT策略端口管理
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} proto 协议类型 FTP/TFTP
 * @apiSuccess {Number} port 端口号
 * @apiSuccess {Number} sys 标志位，1表示不能被删除，0表示可以被删除
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		    "proto": "FTP",
 *			"port": "23",
 *			"sys": "0"
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
 * @api {DELETE} /api/nat-port 删除NAT策略端口管理
 * @apiName 删除NAT策略端口管理
 * @apiGroup NAT策略
 *
 * @apiSuccess {String} proto 协议类型 FTP/TFTP
 * @apiSuccess {Number} port 端口号
 * @apiSuccess {Number} sys 标志位，1表示不能被删除，0表示可以被删除
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		    "proto": "FTP",
 *			"port": "24",
 *			"sys": "0"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success！"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error！"
 *	}
 *
 */
class NatPortController extends mController{
	public $module = 'ip_nat_alg_port';
}
