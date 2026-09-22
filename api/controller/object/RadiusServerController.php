<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/radius-server 获取radius认证服务器对象
 * @apiName 获取radius认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} name  radius认证服务器对象名称
 * @apiSuccess {String} server_ip  radius服务器地址
 * @apiSuccess {String} server_secret  radius服务器密码
 * @apiSuccess {Number} authen_port  radius认证服务器端口
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"server_ip": "1.1.1.1",
 *			"server_secret": "111111",
 *			"authen_port": "1812"
 *		},
 *		{
 *			"name": "aaa",
 *			"server_ip": "2.2.2.2",
 *			"server_secret": "dddddd",
 *			"authen_port": "1812"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST} /api/radius-server 添加radius认证服务器对象
 * @apiName 添加radius认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} name  radius认证服务器对象名称
 * @apiSuccess {String} server_ip  radius服务器地址
 * @apiSuccess {String} server_secret  radius服务器密码
 * @apiSuccess {Number} authen_port  radius认证服务器端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "sunya",
 *			"server_ip": "3.3.3.3",
 *			"server_secret": "3333333333",
 *			"authen_port": "1812"
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
 * @api {PUT} /api/radius-server 修改radius认证服务器对象
 * @apiName 修改radius认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} name  radius认证服务器对象名称
 * @apiSuccess {String} server_ip  radius服务器地址
 * @apiSuccess {String} server_secret  radius服务器密码
 * @apiSuccess {Number} authen_port  radius认证服务器端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "sunya",
 *			"server_ip": "4.4.4.4",
 *			"server_secret": "444444",
 *			"authen_port": "1812"
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
 * @api {DELETE} /api/radius-server 删除radius认证服务器对象
 * @apiName 删除radius认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiParam {String} name  radius认证服务器对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sunya"
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


class RadiusServerController extends mController {	
	public $module = 'radius_server';
}