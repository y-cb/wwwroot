<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/av-whitelist 获取病毒白名单
 * @apiName av-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiSuccess {String} file_md5 文件MD5值
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"file_md5": "486ff5a75b29a8e64f2053538419b955",
 *		},
 *		{
 *			"file_md5": "486ff5a75b29a8e64f2053538419b950",
 *		}
 *	],
 *	}
 *
 */

/**
 * @api {POST}  /api/av-whitelist 新建病毒白名单
 * @apiName av-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiParam {String} file_md5 文件MD5值
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"file_md5": "486ff5a75b29a8e64f2053538419b950",
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
 * @api {PUT}  /api/av-whitelist 修改病毒白名单
 * @apiName av-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiParam {String} file_md5 文件MD5值
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"file_md5": "486ff5a75b29a8e64f2053538419b955",
 *		"file_md5_old": "486ff5a75b29a8e64f2053538419b950",
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
 * @api {DELETE}  /api/av-whitelist 病毒白名单
 * @apiName av-whitelist
 * @apiGroup 应用策略
 *
 *
 * @apiParam {String} file_md5 文件MD5值
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"file_md5": "486ff5a75b29a8e64f2053538419b955",
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


class AvWhitelistController extends mController {	
	public $module = 'av_whitelist';
}
