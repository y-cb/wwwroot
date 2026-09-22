<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/snmp-user 获取用户的SNMP信息
 * @apiName 获取用户的SNMP信息
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {String} name  用户名
 * @apiSuccess {String} auth_mode  认证方式
 * @apiSuccess {String} auth_pwd  认证密码
 * @apiSuccess {String} pri_mode  加密方式
 * @apiSuccess {String} pri_pwd  加密密码
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *               "pri_mode": "DES",
 *		 "pri_pwd": "12345678",
 *		 "name": "admin",
 *		 "auth_pwd": "12345678",
 *		 "auth_mode": "MD5"
 *		},
 *		{
 *	         "pri_mode": "DES",
 *		 "pri_pwd": "87654321",
 *		 "name": "sunya1",
 *		 "auth_pwd": "87654321",
 *		 "auth_mode": "MD5"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/snmp-user 新建SNMP用户
 * @apiName 新建SNMP用户
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {String} name  用户名
 * @apiSuccess {String} auth_mode  认证方式
 * @apiSuccess {String} auth_pwd  认证密码
 * @apiSuccess {String} pri_mode  加密方式
 * @apiSuccess {String} pri_pwd  加密密码*

 * @apiParamExample {json} Request-Example:
 *	{
 *	  "pri_mode": "DES",
 *     	  "pri_pwd": "qazxcvbnm",
 *        "name": "li",
 *        "auth_pwd": "qazxcvbnm",
 *        "auth_mode": "MD5",
 *
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *	}
 *
 */

/**
 * @api {DELETE}  /api/snmp-user 删除用户信息
 * @apiName 删除用户信息
 * @apiGroup 系统维护
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "admin"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *	}
 *
 */


/**
 * @api {PUT}  /api/snmp-user 修改SNMP用户信息
 * @apiName 修改SNMP用户信息
 * @apiGroup 系统维护
 *
 * @apiSuccess {String} name  用户名
 * @apiSuccess {String} auth_mode  认证方式
 * @apiSuccess {String} auth_pwd  认证密码
 * @apiSuccess {String} pri_mode  加密方式
 * @apiSuccess {String} pri_pwd  加密密码*

 * @apiParamExample {json} Request-Example:
 *      {
 *        "pri_mode": "DES",
 *        "pri_pwd": "qazxcvbnm",
 *        "name": "li",
 *        "auth_pwd": "qazxcvbnm",
 *        "auth_mode": "MD5",
 *
 *      }
 *
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
 *      {
 *      }
 *
 * @apiErrorExample {json} Error-Response:
 *      HTTP/1.1 422 Not Found
 *      {
 *      }*
 */



class SNMPUserController extends mController {	
	public $module = 'usm_user';
}

