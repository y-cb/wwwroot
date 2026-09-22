<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ 获取应用控制策略
 * @apiName app-policy
 * @apiGroup 获取应用策略
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
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
 *	}
 *
 * @apiSuccess {Number} id 策略id
 * @apiSuccess {Number} enable 策略使能状态
 * @apiSuccess {String} user 用户
 * @apiSuccess {String} addr 地址
 * @apiParam {Number} policy_id 策略id
 * @apiParam {Number} id 规则id
 * @apiParam {Number} enable 规则使能状态
 * @apiParam {Number} match 无意义，固定为0
 * @apiParam {Number} action 处理动作，0允许，1拒绝
 * @apiParam {String} app 应用审计
 * @apiParam {String} app_show 应用审计
 * @apiParam {String} content 行为内容
 * @apiParam {String} content_show 行为内容
 * @apiParam {String} app_action 应用审计相关行为
 * @apiParam {String} app_action_show 应用审计相关行为
 * @apiParam {String} keyword 关键字
 * @apiParam {String} tr 规则生效时间
 * @apiParam {Number} level 日志级别，-1不记录，0紧急，1告警，2严重，3错误，4警告，5通知，6信息
 * @apiParam {Number} match_count 匹配次数
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
 *				"policy_id":"0",
 *				"id":"1",
 *				"enable":"1",
 *				"match":"0",
 *				"action":"0",
 *				"app":"any",
 *				"app_show":"any",
 *				"content":"any",
 *				"content_show":"any",
 *				"app_action":"any",
 *				"app_action_show":"any",
 *				"keyword":"any",
 *				"tr":"always",
 *				"level":"-1",
 *				"match_count":"984"
 *			},
 *			{
 *				"policy_id":"0",
 *				"id":"1",
 *				"enable":"1",
 *				"match":"0",
 *				"action":"0",
 *				"app":"instant-messaging",
 *				"app_show":"即时通讯",
 *				"content":"any",
 *				"content_show":"any",
 *				"app_action":"any",
 *				"app_action_show":"any",
 *				"keyword":"any",
 *				"tr":"always",
 *				"level":"-1",
 *				"match_count":"0"
 *			}
 *			]
 *		}
 *	],
 *	}
 */

/**
 * @api {POST}  /api/app-policy 添加应用控制策略
 * @apiName app-policy
 * @apiGroup 添加应用策略
 *
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
 * @api {PUT}  /api/app-policy 修改应用控制策略
 * @apiName app-policy
 * @apiGroup 修改应用策略
 *
 *
 * @apiParam {Number} id 策略id
 * @apiParam {Number} enable 策略使能状态
 * @apiParam {String} user 用户
 * @apiParam {String} addr 地址
 * @apiParam {Number} move_type 目标位置，1代表策略最前 3代表策略ID之前 4代表策略ID之后 2代表策略最后
 * @apiParam {Number} refer_id 目标位置策略ID	
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"enable": "1",
 *		"user": "anonymous",
 *		"addr": "any"
 *	}
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
 * @api {DELETE}  /api/app-policy 删除应用控制策略
 * @apiName app-policy
 * @apiGroup 删除应用策略
 *
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


class AppPolicyController extends mController {	
	public $module = 'app_policy';
}