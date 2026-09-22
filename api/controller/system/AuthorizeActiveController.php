<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/authorize-active 获取授权的激活状态
 * @apiName 获取当前设备的授权激活状态，不需传入参数
 * @apiGroup 系统维护
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"active_status": "Active"
 *		},
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/authorize-active 修改授权激活状态
 * @apiName 修改授权激活状态，页面不传入参数，默认为激活操作
 * @apiGroup 系统维护
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
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
 *		"code":"366" 	//授权不存在
 *	}
 *
 */



class AuthorizeActiveController extends mController {	
	public $module = 'license_active';
}
