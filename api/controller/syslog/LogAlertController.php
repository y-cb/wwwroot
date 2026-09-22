<?php
namespace controller\syslog;
use controller\mController;

/**
 *
 * @api {GET}  /api/log-alt 获取今日新增攻击日志
 * @apiName log-alt
 * @apiGroup 攻击日志
 *
 * @apiSuccess {String} api_key token
 * @apiSuccess {Number} vsysid 虚系统id
 * @apiSuccess {String} lang 语言类型
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 * {
 *	"data": [
 *		{
 *			"alert_items": {
 *				"group": {
 *					"name": "IPS入侵",
 *					"count": "747",
 *					"last_log_time": "2019-08-05 19:10:19",
 *					"item_inc": "0"
 *				}
 *			},
 *			"total_inc": "0"
 *		}
 *	],
 *	"total": 1
 *}
 */

class LogAlertController extends mController{	
	public $module = 'log_alert';
}
