<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/syslog-threshold 获取日志存储阈值
 * @apiName syslog-threshold
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} value 阈值
 * @apiSuccess {String} name 名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"value": "80"，,
 *			"name": "ecd_disk_usage",
 *		}
 *	}
 */


/**
 * @api {PUT}  /api/syslog-threshold 修改日志存储阈值
 * @apiName syslog-threshold
 * @apiGroup 日志设定
 *
 *
 * @apiParam {Number} value 阈值
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"value": "90"，,
 *		"name": "ecd_disk_usage",
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

class SyslogThresholdController extends mController{	
	public $module = 'ecd_item';
}

