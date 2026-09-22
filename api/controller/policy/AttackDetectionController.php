<?php
namespace controller\policy;
use controller\mController;
 
/**
 * @api {POST}  /api/attack-detection 添加防暴力破解策略规则
 * @apiName 添加防暴力破解策略规则
 * @apiGroup 防暴力破解
 *
 *
 * @apiParam {Number} policy_id 策略id
 * @apiParam {Number} id 规则id
 * @apiParam {Number} enable 使能状态
 * @apiParam {String} category_name 分类名称
 * @apiParam {String} keyword 关键字对象
 * @apiParam {String} file_type 文件类型对象
 * @apiParam {Number} action 处理动作，0代表允许，1代表拒绝
 * @apiParam {Number} log_level 日志级别
 * @apiParam {String} time_range 时间对象
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"policy_id": "1",
 *		"id": "1",
 *		"enable": "1",
 *		"category_name": "any",
 *		"keyword": "any",
 *		"file_type": "any",
 *		"action": "0",
 *		"log_level": "1",
 *		"time_range": "always"
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

class AttackDetectionController extends mController {	
	public $module = 'attack_detection';
}