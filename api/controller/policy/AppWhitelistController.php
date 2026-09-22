<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/app-whitelist 获取白名单
 * @apiName app-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiSuccess {String} user 用户
 * @apiSuccess {String} addr 地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"user": "anonymous",
 *			"addr": "any"
 *		},
 *		{
 *			"user": "remote",
 *			"addr": "any"
 *		}
 *	],
 *	}
 *
 */

/**
 * @api {POST}  /api/app-whitelist 白名单
 * @apiName app-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"user": "portal-server",
 *		"addr": "any"
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
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/app-whitelist 白名单
 * @apiName app-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"user": "remote",
 *		"addr": "any"
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
 *		"str":""
 *	}
 *
 */


class AppWhitelistController extends mController {	
	public $module = 'xml_app_whitelist';
}
