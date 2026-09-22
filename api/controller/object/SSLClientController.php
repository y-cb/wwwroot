<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-client 获取所有客户端profile
 * @apiName 获取所有客户端profile
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
			"no_ssl_connections": "0", 
			"frequency": "0", 
			"cache_timeout": "3600", 
			"certificate_revocation_list": "", 
			"cert_chain": "", 
			"mod_ssl": "0", 
			"certificate": "default", 
			"client_verification": "0", 
			"trusted_CA": "", 
			"renegotiation": "0", 
			"ref": "2", 
			"renegotiate_period": "0", 
			"option": "2048", 
			"parent": "", 
			"ssl_ciphers_list": {
				"group": [
					{"ciphers": "RC4-SHA"}, 
					{"ciphers": "AES128-SHA"}, 
					{"ciphers": "AES256-SHA"}, 
					{"ciphers": "DES-CBC3-SHA"}, 
					{"ciphers": "RC4-MD5"}
				]
			}, 
			"cert_traversal_depth": "0", 
			"pass_phrase": "", 
			"advertised_CA": "", 
			"name": "sslclient", 
			"alert_timeout": "60", 
			"strict_reuse": "0", 
			"renegotiate_size": "0", 
			"cache_size": "262144", 
			"unclean_shutdown": "1", 
			"renegotiate_record": "10", 
			"handshake_timeout": "60"
		}
		]
 *	}
 */

/**
 * @api {POST}  /api/ssl-client 添加客户端profile
 * @apiName 添加客户端profile
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {String} name 客户端profile名称
 * @apiParam {String} parent 客户端profile继承模板名
 * @apiParam {String} certificate 证书名称
 * @apiParam {String} pass_phrase 证书密码
 * @apiParam {Number} option ssl选项
 * @apiParam {Array} ssl_ciphers_list ssl加密套件 "id": 序号 "ciphers":算法字符串,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sslclient-test",
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
 * @api {PUT}  /api/ssl-client 修改客户端profile
 * @apiName 修改客户端profile
 * @apiGroup SSL卸载 
 *
 *
 * @apiParam {String} name 客户端profile名称
 * @apiParam {String} parent 客户端profile继承模板名
 * @apiParam {String} certificate 证书名称
 * @apiParam {String} pass_phrase 证书密码
 * @apiParam {Number} option ssl选项
 * @apiParam {Number} ref profile引用计数
 * @apiParam {Array} ssl_ciphers_list ssl加密套件 "id": 序号 "ciphers":算法字符串,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sslclient-test",
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
 * @api {DELETE}  /api/ssl-client 删除客户端profile
 * @apiName 删除客户端profile
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} ref profile引用计数
 * @apiParam {String} name profile名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ref": "0",
 *		"name": "sslclient-test"
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


class SSLClientController extends mController {	
	public $module = 'client_profile';
}
