<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/admin-online 获取在线管理员信息
 * @apiName 获取在线管理员信息
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} username  在线管理员名称
 * @apiSuccess {String} useraddr  在线管理员登录IP
 * @apiSuccess {Number} styple  在线管理员登录方式 0：console 1：telnet 2：ssh 3：web
 * @apiSuccess {String} style  登录方式
 * @apiSuccess {String} time  登录时间
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"username": "admin",
 *			"useraddr": "127.0.0.1",
 *			"styple": "0",
 *			"style": "console",
 *			"time": "2029-12-26 00:49:51"
 *		},
 *		{
 *			"username": "admin",
 *			"useraddr": "172.16.0.123",
 *			"styple": "2",
 *			"style": "ssh",
 *			"time": "2029-12-26 00:49:51"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {DELETE} /api/admin-online 删除在线管理员
 * @apiName 删除在线管理员
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} username  在线管理员名称
 * @apiSuccess {String} useraddr  在线管理员登录IP
 * @apiSuccess {String} time  登录时间
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"username": "admin",
 *		"useraddr": "172.16.0.123",
 *		"time": "2029-12-26 19:14:13"
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


class AdminOnlineController extends mController{	
	public $module = 'who';
}

