<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/ldap-server 获取ldap认证服务器对象
 * @apiName 获取ldap认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} name  认证服务器名称
 * @apiSuccess {String} server_ip  认证服务器地址
 * @apiSuccess {String} uid  登录名属性
 * @apiSuccess {String} dn   区域名
 * @apiSuccess {String} user  ldap管理员
 * @apiSuccess {String} password  ldap管理员密码
 * @apiSuccess {String} ref  引用计数
 * @apiSuccess {Number} port  默认389 1-65535
 * @apiSuccess {Number} bind_type  255
 * @apiSuccess {Number} secure_connect  0
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "aaa",
 *			"server_ip": "1.1.1.1",
 *			"uid": "sAMAccountName",
 *			"user": "admin",
 *			"password": "aaaaaa",
 *			"port": "389",
 *			"bind_type": "255",
 *			"secure_connect": "0",
 *			"ref": "0"
 *		},
 *		{
 *			"name": "sunya",
 *			"server_ip": "1.1.1.1",
 *			"uid": "sAMAccountName",
 *			"user": "admin",
 *			"password": "aaaaaa",
 *			"port": "389",
 *			"bind_type": "255",
 *			"secure_connect": "0",
 *			"ref": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

 /**
 * @api {GET} /api/ldap-server 获取单个ldap认证服务器对象
 * @apiName 获取单个ldap认证服务器对象
 * @apiGroup 认证服务器
 *
 * @apiSuccess {String} name  认证服务器名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sunya",
 *		"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"name": "sunya",
 *			"server_ip": "1.1.1.1",
 *			"uid": "sAMAccountName",
 *			"user": "admin",
 *			"password": "aaaaaa",
 *			"port": "389",
 *			"bind_type": "255",
 *			"secure_connect": "0",
 *			"protocol: ": "1",
 *			"dn: ": "test"
 *	}
 */
 
/**
 * @api {POST} /api/ldap-server 添加ldap认证服务器对象
 * @apiName 添加ldap认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} name  认证服务器名称
 * @apiSuccess {String} server_ip  认证服务器地址
 * @apiSuccess {String} uid  登录名属性
 * @apiSuccess {String} dn   区域名
 * @apiSuccess {String} user  ldap管理员
 * @apiSuccess {String} password  ldap管理员密码
 * @apiSuccess {String} ref  引用计数
 * @apiSuccess {Number} port  默认389 1-65535
 * @apiSuccess {Number} bind_type  255
 * @apiSuccess {Number} secure_connect  0
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"server_ip": "1.1.1.1",
 *		"uid": "sAMAccountN",
 *		"dn": "test",
 *		"user": "admin",
 *		"password": "addsws",
 *		"port": "389",
 *		"secure_connect": "0"
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
 *		"str":"XXX"
 *	}
 *
 */

/**
 * @api {PUT} /api/ldap-server 修改ldap认证服务器对象
 * @apiName 修改ldap认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} name  认证服务器名称
 * @apiSuccess {String} server_ip  认证服务器地址
 * @apiSuccess {String} uid  登录名属性
 * @apiSuccess {String} dn   区域名
 * @apiSuccess {String} user  ldap管理员
 * @apiSuccess {String} password  ldap管理员密码
 * @apiSuccess {String} ref  引用计数
 * @apiSuccess {Number} port  默认389 1-65535
 * @apiSuccess {Number} bind_type  255
 * @apiSuccess {Number} secure_connect  0
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"server_ip": "1.1.1.1",
 *		"uid": "sAMAccountN",
 *		"dn": "test",
 *		"user": "admin",
 *		"password": "addsws",
 *		"port": "3891",
 *		"secure_connect": "0"
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
 *		"str":"XXX"
 *	}
 *
 */

/**
 * @api {DELETE} /api/ldap-server 删除ldap认证服务器对象
 * @apiName 删除ldap认证服务器对象
 * @apiGroup 认证服务器
 *
 *
 * @apiParam {String} name  要删除ldap认证服务器对象的名字
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
 *		"code":"非0",
 *		"str":"XXX"
 *	}
 *
 */


class LdapServerController extends mController {	
	public $module = 'ldap_server_data';
}
