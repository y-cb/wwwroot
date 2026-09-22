<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-server 获取所有服务端profile
 * @apiName 获取所有服务端profile
 * @apiGroup SSL卸载
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *      }
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 2, 
		"data": [
			{
				"ref": "1", 
				"name": "sslserver", 
				"parent": ""
			}, 
			{
				"ref": "0", 
				"name": "ssls", 
				"parent": ""
			}
		]
 *	}
 */

/**
 * @api {POST}  /api/ssl-server 添加服务端profile
 * @apiName 添加服务端profile
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {String} name 服务端profile名称
 * @apiParam {String} parent 服务端profile继承模板名
 * @apiParam {String} certificate 证书名称
 * @apiParam {String} pass_phrase 证书密码
 * @apiParam {Number} option ssl选项
 * @apiParam {Array} ssl_ciphers_list ssl加密套件 "id": 序号 "ciphers":算法字符串,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sslserver-test",
 *		"parent": "sslc",
 *		"certificate": "default",
 *		"pass_phrase": "111111",
 *		"option": "256",
 *		"ssl_ciphers_list": [{"id":0, "ciphers":"AES128-SHA"}, {"id":1, "ciphers":"AES256-SHA"}]
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
 *		"code":"非0",
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/ssl-server 修改服务端profile
 * @apiName 修改服务端profile
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {String} name 服务端profile名称
 * @apiParam {String} parent 服务端profile继承模板名
 * @apiParam {String} certificate 证书名称
 * @apiParam {String} pass_phrase 证书密码
 * @apiParam {Number} option ssl选项
 * @apiParam {Number} ref profile引用计数
 * @apiParam {Array} ssl_ciphers_list ssl加密套件 "id": 序号 "ciphers":算法字符串,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sslserver-test",
 *		"parent": "sslc",
 *		"certificate": "default",
 *		"pass_phrase": "111111",
 *		"option": "256",
 *		"ref": "0",
 *		"ssl_ciphers_list": [{"id":0, "ciphers":"AES128-SHA"}, {"id":1, "ciphers":"AES256-SHA"}, {"id":2, "":"RC4-MD5"}]
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
 *		"code":"非0",
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ssl-server 删除服务端profile
 * @apiName 删除服务端profile
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} ref profile引用计数
 * @apiParam {String} name profile名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ref": "0",
 *		"name": "sslserver-test"
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
 *		"code":"非0",
 *		"str":"对应的错误提示信息"
 *	}
 *
 */


class SSLServerController extends mController {	
	public $module = 'server_profile';
}
