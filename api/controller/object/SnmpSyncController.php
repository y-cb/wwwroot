<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/auth-user 获取所有用户对象
 * @apiName 获取所有用户对象
 * @apiGroup 用户对象
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 2, 
		"data": [
			{"predefined": "1", "enable": "1", "name": "any", "bind_type": "none", "show_name": "\u6240\u6709\u7528\u6237", "ref_num": "1", "alias": "", "readonly": "1", "bind_include": "", "type": "none", "id": "1", "description": ""}, 
			{"predefined": "0", "enable": "1", "name": "alan_user_test", "passwd": "1234567", "bind_type": "none", "show_name": "alan_user_test", "ref_num": "0", "alias": "", "readonly": "0", "bind_include": "", "type": "local_db", "id": "2005", "description": ""}
			]
 *	}
 */

/**
 * @api {GET}  /api/auth-user 获取单个用户对象
 * @apiName 获取单个用户对象
 * @apiGroup 用户对象
 *
 *
 * @apiSuccess {String} name 用户对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_test",
 *		"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"predefined": "0", 
		"enable": "1", 
		"name": "alan_user_test", 
		"passwd": "1234567", 
		"bind_type": "none", 
		"show_name": "alan_user_test", 
		"ref_num": "0", 
		"alias": "", 
		"readonly": "0", 
		"bind_include": "", 
		"type": "local_db", 
		"id": "2005", 
		"description": "",

 *	}
 */

/**
 * @api {POST}  /api/auth-user 添加本地用户
 * @apiName 添加本地用户 
 * @apiGroup 用户对象
 *
 *
 * @apiParam {String} name 所有用户名
 * @apiParam {String} type 用户类型
 * @apiParam {String} passwd 密码
 * @apiParam {Number} enable 是否启用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_test",
 *		"type": "local_db",
 *		"enable": 1,
 *		"passwd": "123456"
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
 * @api {PUT}  /api/auth-user 修改本地用户
 * @apiName 修改本地用户 
 * @apiGroup 用户对象
 *
 *
 * @apiParam {String} name 所有用户名
 * @apiParam {String} type 用户类型
 * @apiParam {String} passwd 密码
 * @apiParam {Number} enable 是否启用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_test",
 *		"type": "local_db",
 *		"enable": 1 ,
 *		"passwd": "1234567"
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
 * @api {DELETE}  /api/auth-user 删除用户对象
 * @apiName 删除用户对象
 * @apiGroup 用户对象
 *
 *
 * @apiParam {String} name 用户对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_test"
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


class SnmpSyncController extends mController {	
	public $module = 'snmp_rspan_enti';
}
