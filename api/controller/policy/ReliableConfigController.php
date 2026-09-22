<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/reliable-config 获取威胁情报信誉值
 * @apiName 获取威胁情报信誉值
 * @apiGroup 获取威胁情报
 *
 *
 * @apiSuccess {Number} denyenable 拒绝并记录日志开关（0关，1开）
 * @apiSuccess {Number} logenable 记录日志开关（0关，1开）
 * @apiSuccess {Number} logreliable 记录日志信誉值（1-100）
 * @apiSuccess {Number} denyreliable 拒绝并记录日志信誉值（1-100）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		[{"denyenable": "1", 
 *       "logenable": "1", 
 *       "logreliable": "60", 
 *		 "log_risklevel":"1"
 *       "denyreliable": "80"
 *		 "deny_risklevel":"4"
 *		}]
 *	"total": 1
 *	}
 */

/**
 * @api {PUT} /api/reliable-config 修改威胁情报信誉值
 * @apiName 修改威胁情报信誉值
 * @apiGroup 威胁情报
 *
 *
 * @apiSuccess {Number} logenable 记录日志开关（0关，1开）
 * @apiSuccess {Number} logreliable 记录日志信誉值（1-100）
 * @apiSuccess {Number} denyenable 拒绝并记录日志开关（0关，1开）
 * @apiSuccess {Number} denyreliable 拒绝并记录日志信誉值（1-100）
 *
 * @apiParamExample {json} Request-Example:
 *		{"denyenable": "1", 
 *       "logenable": "1", 
 *       "logreliable": "60", 
 *		 "log_risklevel":"1"
 *       "denyreliable": "80"
 *		 "deny_risklevel":"4"
 *		}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":""
 *	}
 *
 */

class ReliableConfigController extends mController {	
	public $module = 'reliable_conf';
}