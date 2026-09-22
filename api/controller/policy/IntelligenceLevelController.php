<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/intelligence-level 获取威胁情报风险级别的日志级别配置
 * @apiName intelligence-level
 * @apiGroup 获取威胁情报风险级别的日志级别配置
 *
 * @apiSuccess {Number} levelserious 风险级别高，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccess {Number} levelhigh 风险级别高，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccess {Number} levelmid 风险级别中，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccess {Number} levellow 风险级别低，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccess {Number} leveldoubt 风险级别可疑，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccess {Number} levelsafe 风险级别安全，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccess {Number} levelunkown 风险级别未知，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *{
 *	"levelserious": "0",
 *	"levelhigh": "1",
 *	"levelmid": "2",
 *	"levellow": "3",
 *	"leveldoubt": "4",
 *	"levelsafe": "5",
 *	"levelunknown": "6"
 *}
 *
 */
 
/**
 * @api {PUT}  /api/intelligence-level 修改威胁情报对应风险等级的日志级别配置
 * @apiName intelligence-level
 * @apiGroup 修改威胁情报对应风险等级的日志级别配置
 *
 * @apiParam {Number} levelserious 风险级别高，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParam {Number} levelhigh 风险级别高，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParam {Number} levelmid 风险级别中，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParam {Number} levellow 风险级别低，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParam {Number} leveldoubt 风险级别可疑，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParam {Number} levelsafe 风险级别安全，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParam {Number} levelunkown 风险级别未知，loglevel（0紧急，1告警，2严重，3错误，4警示，5通知，6信息）
 * @apiParamExample {json} Request-Example:
 *{
 *	"levelserious": "0",
 *	"levelhigh": "1",
 *	"levelmid": "2",
 *	"levellow": "3",
 *	"leveldoubt": "4",
 *	"levelsafe": "5",
 *	"levelunknown": "6"
 *}
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

class IntelligenceLevelController extends mController {	
	public $module = 'level_conf';
}