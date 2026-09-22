<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/phone-warning 获取告警短信配置
 * @apiName phone-warning
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {String} phonenum 告警短信手机号配置
 * @apiSuccess {Number} interval 告警短信发送间隔配置
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"phonenum": "18601250024",
 *			"interval": "10"
 *		}
 *	}
 */

/**
 * @api {PUT}  /api/phone-warning 获取告警短信配置
 * @apiName phone-warning
 * @apiGroup 日志设定
 *
 *
 * @apiParam {String} phonenum 告警短信手机号配置
 * @apiParam {Number} interval 告警短信发送间隔配置
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"phonenum": "13439079570",
 *		"interval": "20"
 *	}
 *
 */

class PhoneWarnController extends mController{	
	public $module = 'phone_warn';
}

