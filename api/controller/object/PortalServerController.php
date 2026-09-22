<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/portal-server 获取Portal认证参数
 * @apiName 获取Portal认证参数
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} radius_server  portal radius认证服务器对象名
 * @apiSuccess {String} portal_server  portal服务器名称
 * @apiSuccess {Number} kick_interval  portal认证超时时间 1-144000分钟
 * @apiSuccess {String} portal_url  portal认证页面url （0-255个字符）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"radius_server": "test",
 *			"portal_server": "1.1.1.1",
 *			"kick_interval": "15",
 *			"portal_url": "htttp%3A%2F%2Fwww.baidu.com"
 *	}
 */

/**
 * @api {PUT} /api/portal-server 修改Portal认证参数
 * @apiName 修改Portal认证参数
 * @apiGroup 认证服务器
 *
 *
 * @apiSuccess {String} radius_server  portal radius认证服务器对象名
 * @apiSuccess {String} portal_server  portal服务器名称
 * @apiSuccess {Number} kick_interval  portal认证超时时间 1-144000分钟
 * @apiSuccess {String} portal_url  portal认证页面url （0-255个字符）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"radius_server": "test",
 *			"portal_server": "1.1.1.1",
 *			"kick_interval": "15",
 *			"portal_url": "htttp%3A%2F%2Fwww.baidu.com"
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


class PortalServerController extends mController{	
	public $module = 'auth_cmcc_profile';
}

