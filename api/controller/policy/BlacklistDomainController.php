<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/blacklist-domain 获取域名黑名单
 * @apiName 获取域名黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} doamin 域名
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
 * 			"doamin": "www.xxx.com",
 * 			"age": "300",
 * 			"leftTime": "61",
 * 		 	"effectTime": "2000-05-11 11:27:02",
 * 			"reason": "0",
 * 	 		"state": "1"
 *		}，
 *		{
 * 			"doamin": "www.yyy.com",
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
 * @api {POST}  /api/blacklist-domain 添加域名黑名单
 * @apiName 添加域名黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} doamin 域名
 * @apiParam {String} age 生命周期
 * @apiParam {Number} enable 状态(0表示不启用，1表示启用)
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"doamin": "www.xxx.com",
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
 * @api {PUT}  /api/blacklist-domain 修改域名黑名单
 * @apiName 修改域名黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} old_domian 修改前域名
 * @apiParam {Number} doamin 修改后域名
 * @apiParam {Number} age 生命周期
 * @apiParam {Number} enable 状态(0表示不启用，1表示启用)
 * @apiParam {Number} reason 添加原因（范围：0-7，页面下发只允许0，代表手动）
 * @apiParamExample {json} Request-Example:
 *	{
 *			"old_doamin": "www.xxx.com",
 *			"doamin": "www.zzz.com",
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
 * @api {DELETE}  /api/blacklist-domain 删除域名黑名单
 * @apiName 删除域名黑名单
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} domain 域名
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"domain": "www.xxx.com"
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

class BlacklistDomainController extends mController{
	public $module = 'dns_domain_blist_cfg';
}

?>
