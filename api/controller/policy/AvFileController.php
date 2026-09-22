<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/av-filetype 获取病毒防护文件类型配置
 * @apiName 获取病毒防护文件类型配置
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} pattern 文件类型，不可为空，文件类型的扩展名，取值范围不固定
 * @apiSuccess {Number} enable 是否使能，不可为空， 1:启用 0:不启用
 * @apiSuccess {Number} is_static 是否可删除，不可为空， 1:默认项 不能删除;0:用户自定义项 可以删除
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"scan_all": "0"
 *		}
 *	}
 */

/**
 * @api {POST}  /api/av-filetype 添加病毒防护文件类型配置
 * @apiName 添加病毒防护文件类型配置
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} pattern 文件类型，不可为空，文件类型扩展名，取值范围不固定
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"pattern": "*.sdk"
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
 * @api {PUT}  /api/av-filetype 修改病毒防护文件类型配置
 * @apiName 修改病毒防护文件类型配置
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} pattern 文件类型，不可为空，文件类型扩展名，取值范围不固定
 * @apiParam {String} enable  是否启用，不可为空，1代表启用，0代表禁用
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"pattern": "*.pif",
 *		"pattern": "*.xlsx",
 *		"pattern": "*.xl",
 *		"pattern": "*.scr",
 *		"pattern": "*.cpl"
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
 * @api {DELETE}  /api/av-filetype 删除病毒防护文件类型配置
 * @apiName 删除病毒防护文件类型配置
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} pattern 文件型，不可为空，文件类型扩展名，取值范围不固定
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"pattern": "*.sdk"
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


class AvFileController extends mController {	
	public $module = 'check_list';
}
