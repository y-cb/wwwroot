<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {POST}  /api/app-rule 添加应用控制策略规则
 * @apiName app-rule
 * @apiGroup 应用策略
 *
 *
 * @apiParam {Number} policy_id 策略id
 * @apiParam {Number} id 规则id
 * @apiParam {String} app 应用审计
 * @apiParam {String} app_action 应用审计相关行为
 * @apiParam {String} app_show 应用审计相关行为
 * @apiParam {String} app_action_show 应用审计相关行为
 * @apiParam {String} content 应用审计相关内容
 * @apiParam {String} content_show 应用审计相关内容
 * @apiParam {String} keyword 关键字
 * @apiParam {String} tr 生效时间
 * @apiParam {Number} enable 使能状态
 * @apiParam {Number} action 处理动作，0允许，1拒绝
 * @apiParam {Number} level 日志级别，-1不记录，0紧急，1告警，2严重，3错误，4警告，5通知，6信息
 * @apiParam {Number} match 匹配次数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"policy_id": "1",
 *		"id": "2",
 *		"app": "any",
 *		"app_action": "any",
 *		"content": "any",
 *		"keyword": "any",
 *		"tr": "always",
 *		"enable": "1",
 *		"action": "0",
 *		"level": "1",
 *		"match": "0",
 *		"app_show": "",
 *		"content_show": "any",
 *		"app_action_show": "any"
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

class AppRuleController extends mController {	
	public $module = 'app_rule';
}