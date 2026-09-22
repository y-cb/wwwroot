<?php
namespace controller\system;
use controller\mController;


/**
 * @api {POST}  /api/feedback 添加信息反馈配置
 * @apiName feedback
 * @apiGroup 系统维护
 *
 *
 * @apiParam {String} to 收件人
 * @apiParam {String} cc 抄送
 * @apiParam {String} contactor 联系人
 * @apiParam {String} address 联系地址
 * @apiParam {String} tel 联系电话
 * @apiParam {String} subject 标题
 * @apiParam {String} description 问题描述
 * @apiParam {String} attach_cfg 设备信息提取
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"to": "19887129@qq.com",
 *		"cc": "12735@qq.com",
 *		"contactor": "接口",
 *		"address": "北京市海淀区666",
 *		"tel": "12345678902",
 *		"subject": "zxcvbn",
 *		"description": "嗯",
 *		"attach_cfg": "1"
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
 


class FeedBackController extends mController {	
	public $module = 'feedback';
}
