<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/ips-rule 获取入侵防护策略
 * @apiName ips-rule
 * @apiGroup 获取防护策略
 *
 *
 * @apiSuccess {String} name 策略名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiSuccess {String} desc 策略描述，可为空，0-127，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiSuccess {String} src_zone 入接口，已不使用
 * @apiSuccess {String} dst_zone 出接口，已不使用
 * @apiSuccess {String} src 源地址，已不使用
 * @apiSuccess {String} dst 目的地址，已不使用
 * @apiSuccess {String} set 事件集名称，不可为空，必须是存在的事件集名称
 * @apiSuccess {Number} id 策略ID，不可为空，整形值范围1-2147483647
 * @apiSuccess {Number} enable 启用标志，不可为空，0或者1,0表示关闭，1表示启用
 * @apiSuccess {Number} log 记录日志标志，不可为空，0或者1,0表示关闭，1表示启用
 * @apiSuccess {Number} refcnt 引用计数，不可为空，不能设置只能获取
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"desc": "ips-plcy-desc",
 *			"set": "All",
 *			"refcnt": "0",
 *			"id": "1",
 *			"enable": "1",
 *			"log": "1"
 *		},
 *		{
 *			"name": "test1",
 *			"desc": "ips-plcy-desc",
 *			"set": "All",
 *			"refcnt": "0",
 *			"id": "2",
 *			"enable": "1",
 *			"log": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/ips-rule 添加入侵防护策略
 * @apiName ips-rule
 * @apiGroup 添加防护策略
 *
 *
 * @apiParam {String} name 策略名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} desc 策略描述可为空，0-127，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} src_zone 入接口，已不使用
 * @apiParam {String} dst_zone 出接口，已不使用
 * @apiParam {String} src 源地址，已不使用
 * @apiParam {String} dst 目的地址，已不使用
 * @apiParam {String} set 事件集，不可为空，必须是存在的事件集名称
 * @apiParam {Number} id 策略ID，不可为空，0
 * @apiParam {Number} refer_id 移动参考目标策略id，已不使用
 * @apiParam {Number} enable 启用状态，已不使用
 * @apiParam {Number} log 是否记录日志，不可为空，0或者1,0表示关闭，1表示启用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "ips-plcy-desc",
 *		"set": "All",
 *		"id": "0",
 *		"log": "1"
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
 * @api {PUT}  /api/ips-rule 修改入侵防护策略
 * @apiName ips-rule
 * @apiGroup 修改防护策略
 *
 *
 * @apiParam {String} name 策略名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} desc 策略描述，可为空，0-127，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} src_zone 入接口，已不使用
 * @apiParam {String} dst_zone 出接口，已不使用
 * @apiParam {String} src 源地址，已不使用
 * @apiParam {String} dst 目的地址，已不使用
 * @apiParam {String} set 事件集，不可为空，必须是存在的事件集名称
 * @apiParam {Number} id 策略ID，不可为空，整形值范围1-2147483647
 * @apiParam {Number} refer_id 引用计数，固定为0，已不使用
 * @apiParam {Number} enable 启用状态，不可为空，0或者1,0表示关闭，1表示启用
 * @apiParam {Number} log 是否记录日志，不可为空，0或者1,0表示关闭，1表示启用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "ips-plcy-desc",
 *		"set": "Common",
 *		"id": "1",
 *		"enable": "1",
 *		"log": "1"
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
 * @api {DELETE}  /api/ips-rule 删除入侵防护策略
 * @apiName ips-rule
 * @apiGroup 删除防护策略
 *
 *
 * @apiParam {Number} id 策略id，不可为空，整形值范围1-2147483647
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


class IpsRuleController extends mController{
	public $module = 'ips_rule';
}

?>
