<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/web-policy 获取web访问策略
 * @apiName 获取web访问策略
 * @apiGroup 应用策略
 *
 *
 * @apiSuccess {Number} id 策略id
 * @apiSuccess {Number} enable 策略使能状态
 * @apiSuccess {String} user 用户
 * @apiSuccess {String} addr 地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"enable": "1",
 *			"user": "any",
 *			"addr": "any"
 *		},
 *		{
 *			"id": "2",
 *			"enable": "1",
 *			"user": "any",
 *			"addr": "any"
 *		}
 *	],
 *	"total": 2
 *	}
 *
 *
 * @apiParam {Number} id 策略id
 * @apiParam {String} op 选项
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
 *		"op": "detail"
 *	}
 *
 * @apiSuccess {Number} id 策略id
 * @apiSuccess {Number} enable 策略使能状态
 * @apiSuccess {String} user 用户
 * @apiSuccess {String} addr 地址
 * @apiSuccess {Number} policy_id 策略id
 * @apiSuccess {Number} id 规则id
 * @apiSuccess {Number} enable 使能状态
 * @apiSuccess {String} category_name 分类名称
 * @apiSuccess {String} keyword 关键字对象
 * @apiSuccess {String} file_type 文件类型对象
 * @apiSuccess {Number} action 处理动作，0代表允许，1代表拒绝
 * @apiSuccess {Number} log_level 日志级别
 * @apiSuccess {String} time_range 时间对象
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"enable": "1",
 *			"user": "any",
 *			"addr": "any",
 *			"group": [
 *			{
 *				"policy_id": "1",
 *				"id": "1",
 *				"enable": "1",
 *				"category_name": "any",
 *				"category_show_name": "所有",
 *				"keyword": "any",
 *				"file_type": "any",
 *				"action": "0",
 *				"log_level": "6",
 *				"time_range": "always"
 *			},
 *			{
 *				"policy_id": "1",
 *				"id": "2",
 *				"enable": "1",
 *				"category_name": "any",
 *				"category_show_name": "所有",
 *				"keyword": "any",
 *				"file_type": "any",
 *				"action": "0",
 *				"log_level": "4",
 *				"time_range": "always"
 *			}
 *			]
 *		}
 *	]
 *	}
 */

/**
 * @api {POST}  /api/web-policy 添加web访问策略
 * @apiName 添加web访问策略
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} id 策略id，固定为0，系统自动分配
 * @apiParam {Number} enable 策略使能状态
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "0",
 *		"enable": "1",
 *		"user": "any",
 *		"addr": "any"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "大于10000，code-10000的结果为访问策略ID",
 *	    "str": ""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"小于10000",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/web-policy 修改web访问策略
 * @apiName 修改web访问策略
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} id 策略id
 * @apiParam {Number} enable 策略使能状态
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"enable": "1",
 *		"user": "anonymous",
 *		"addr": "any"
 *	}
 *
 * @apiParam {Number} id 策略id
 * @apiParam {Number} move_type 目标位置，1代表策略最前 3代表策略ID之前 4代表策略ID之后 2代表策略最后
 * @apiParam {Number} refer_id 目标位置策略ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "2",
 *		"move_type": "4",
 *		"refer_id": "3"
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
 * @api {DELETE}  /api/web-policy 删除web访问策略
 * @apiName 删除web访问策略
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} id 策略id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
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


class WebPolicyController extends mController {	
	public $module = 'xml_web_access_policy';
}
