<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ssl-offload 用户认证https是否触发
 * @apiName ssl-offload
 * @apiGroup 用户策略
 *
 * @apiSuccess {String} status https是否触发
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"status": "1"
 *	}
 *
 * @apiSuccess {String} https是否触发
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": 
 *		{
 *			"status": "1",
 *		}
 *	}
 */


class SSLOffloadController extends mController {	
	public $module = 'ssl_offload';
}