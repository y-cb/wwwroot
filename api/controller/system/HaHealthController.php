<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-healthcheck 获取健康检查监控配置
 * @apiName 获取健康检查监控配置
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  健康检查模板
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"name": "test"
 *	}
 */

/**
 * @api {POST} /api/ha-healthcheck 修改健康检查模板
 * @apiName 修改健康检查模板
 * @apiGroup 高可靠性
 *
 *
 * @apiParam {String} name  健康检查模板
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test"
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
 *		"str":"XXX"
 *	}
 *
 */


class HaHealthController extends mController{	
	public $module = 'ha_healthcheck';
}

