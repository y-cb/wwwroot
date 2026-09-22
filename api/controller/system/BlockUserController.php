<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/block-user 获取阻断管理员信息
 * @apiName 获取阻断管理员信息
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} login_addr  登录IP
 * @apiSuccess {String} login_time  最近登录时间
 * @apiSuccess {String} login_style  登录方式
 * @apiSuccess {String} login_user  登录用户名
 * @apiSuccess {String} login_block_time  解除阻断时间
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"login_addr": "192.168.0.201",
 *			"login_time": "2029-12-26 19:41:29",
 *			"login_style": "cli",
 *			"login_user": "admin",
 *			"login_block_time": "2029-12-26 19:42:29"
 *		},
 *		{
 *			"login_addr": "192.168.0.200",
 *			"login_time": "2029-12-26 19:43:29",
 *			"login_style": "web",
 *			"login_user": "admin",
 *			"login_block_time": "2029-12-26 19:44:29"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {DELETE} /api/block-user 删除阻断用户信息
 * @apiName 删除阻断用户信息
 * @apiGroup 管理员设置
 *
 *
 * @apiParam {String} login_addr  阻断IP
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"login_addr": "192.168.0.201"
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


class BlockUserController extends mController{	
	public $module = 'admin_block_user';
}

