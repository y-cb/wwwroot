<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/blacklist 获取黑名单
 * @apiName 获取黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} ip 源ip
 * @apiSuccess {Number} age 生命周期
 * @apiSuccess {String} leftTime 剩余生效时间
 * @apiSuccess {String} effectTime 生效截止时间
 * @apiSuccess {String} reason 添加原因（范围：0-7，0，代表手动，其他自动）
 * @apiSuccess {Number} state 状态
 * @apiSuccess {Number} enable 状态(0表示不启用，1表示启用)
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 * 			"ip": "10.1.1.1",
 * 			"age": "300",
 * 			"leftTime": "61",
 * 		 	"effectTime": "2000-05-11 11:27:02",
 * 			"reason": "0",
 * 	 		"state": "1"
 *		}，
 *		{
 * 			"ip": "10.1.1.2",
 * 			"age": "600",
 * 			"leftTime": "61",
 * 		 	"effectTime": "2000-05-11 11:27:02",
 * 			"reason": "0",
 * 	 		"state": "1"
 *		}
 *	],
 *	}
 */


/**
 * @api {POST}  /api/blacklist 添加黑名单
 * @apiName 添加黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} ip 源ip 
 * @apiParam {String} age 生命周期
 * @apiParam {Number} enable 状态(0表示不启用，1表示启用)
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"ip": "1.1.1.1",
 *			"age": "300",
 *			"enable": "1"
 *	}
 *
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
 * @api {PUT}  /api/blacklist 修改黑名单
 * @apiName 修改黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} old_ip 修改前ip
 * @apiParam {Number} ip 修改后ip
 * @apiParam {Number} age 生命周期
 * @apiParam {Number} enable 状态(0表示不启用，1表示启用)
 * @apiParam {Number} reason 添加原因（范围：0-7，页面下发只允许0，代表手动）
 * @apiParamExample {json} Request-Example:
 *	{
 *			"old_ip": "20.1.1.1",
 *			"ip": "20.1.2.15",
 *			"age": "600"
 *			"enable": "1"
 *			"reason": "0"
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
 * @api {DELETE}  /api/blacklist 删除黑名单
 * @apiName 删除黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} ip 源ip
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"ip": "20.1.2.15"
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


class BlacklistController extends mController{
	public $module = 'sec_ad_blacklist';
}

?>
