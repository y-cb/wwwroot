<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/av-rule 获取病毒防护策略
 * @apiName av-rule
 * @apiGroup 获取病毒防护策略
 *
 *
 * @apiSuccess {String} name 名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiSuccess {String} desc 描述，可为空，0-127，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiSuccess {String} if_in 入接口，已不使用
 * @apiSuccess {String} if_out 出接口，已不使用
 * @apiSuccess {String} src 源地址，已不使用
 * @apiSuccess {String} dst 目的地址，已不使用
 * @apiSuccess {Number} http 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiSuccess {Number} smtp 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiSuccess {Number} imap 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiSuccess {Number} ftp 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiSuccess {Number} pop3 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiSuccess {Number} action 行为，不可为空，0或者1,0表示通过，1表示阻断
 * @apiSuccess {Number} enable 启用标志，不可为空，0或者1,0表示关闭，1表示启用
 * @apiSuccess {Number} apt_enable 沙箱检测，不可为空，0或者1,0表示关闭，1表示启用
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "aaa",
 *			"http": "1",
 *			"smtp": "0",
 *			"imap": "0",
 *			"ftp": "0",
 *			"pop3": "0",
 *			"action": "0",
 *			"enable": "1",
 *			"apt_enable": "1"
 *			"desc": "av-policy-description"
 *		},
 *		{
 *	 		"name": "spr",
 *			"http": "1",
 *			"smtp": "0",
 *			"imap": "0",
 *			"ftp": "0",
 *			"pop3": "0",
 *			"action": "0",
 *			"enable": "1",
 *			"apt_enable": "1"
 *			"desc": "av-policy-description"
 *		}
 *	],
 *	}
 */

/**
 * @api {POST}  /api/av-rule 添加病毒防护策略
 * @apiName av-rule
 * @apiGroup 添加病毒防护策略
 *
 *
 * @apiParam {String} name 名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} desc 描述，可为空，0-127，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} if_in 入接口，已不使用
 * @apiParam {String} if_out 出接口，已不使用
 * @apiParam {String} src 源地址，已不使用
 * @apiParam {String} dst 目的地址，已不使用
 * @apiParam {Number} http 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} smtp 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} imap 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} ftp 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} pop3 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} action 行为，不可为空，0或者1,0表示通过，1表示阻断
 * @apiParam {Number} enable 启用，不可为空，0或者1,0表示关闭，1表示启用
 * @apiParam {Number} apt_enable 沙箱检测，不可为空，0或者1,0表示关闭，1表示启用
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
 *		"http": "0",
 *		"smtp": "1",
 *		"imap": "0",
 *		"apt_enable": "1",
 *		"ftp": "0",
 *		"pop3": "0",
 *		"name": "hjkll",
 *		"action": "0"
 *		"desc": "av-policy-description"
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
 * @api {PUT}  /api/av-rule 修改病毒防护策略
 * @apiName av-rule
 * @apiGroup 修改病毒防护策略
 *
 *
 * @apiParam {String} name 名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} desc 描述，可为空，0-127，只能为汉字、英文字母大小写、数字@。._-|()[]
 * @apiParam {String} if_in 入接口，已不使用
 * @apiParam {String} if_out 出接口，已不使用
 * @apiParam {String} src 源地址，已不使用
 * @apiParam {String} dst 目的地址，已不使用
 * @apiParam {Number} http 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} smtp 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} imap 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} ftp 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} pop3 协议，不可为空，0或者1,0表示关闭，1表示开启
 * @apiParam {Number} action 行为，不可为空，0或者1,0表示通过，1表示阻断
 * @apiParam {Number} enable 启用标志，不可为空，0或者1,0表示关闭，1表示启用
 * @apiParam {Number} apt_enable 沙箱检测，不可为空，0或者1,0表示关闭，1表示启用
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "hjkll",
 *		"desc": "av-policy-description",
 *		"http": "1",
 *		"smtp": "1",
 *		"imap": "0",
 *		"ftp": "0",
 *		"pop3": "1",
 *		"enable": "1",
 *		"action": "0",
 *		"apt_enable": "1"
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
 * @api {DELETE}  /api/av-rule 删除病毒防护策略
 * @apiName av-rule
 * @apiGroup 删除病毒防护策略
 *
 *
 * @apiParam {String} name 名称，不可为空，1-63，只能为汉字、英文字母大小写、数字@。._-|()[]
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "hjkll"
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


class AvRuleController extends mController{	
	public $module = 'xml_av_rule';
}
