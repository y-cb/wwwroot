<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/dns 获取DNS配置
 * @apiName 获取DNS配置
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {String} first_dns  主DNS
 * @apiSuccess {String} second_dns  备DNS
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"first_dns": "8.8.8.8",
 *			"second_dns": "114.114.114.114"
 *	}
 */


/**
 * @api {PUT} /api/dns 修改DNS配置
 * @apiName 修改DNS配置
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {String} first_dns  主DNS
 * @apiSuccess {String} second_dns  备DNS
 *
 * @apiSuccessExample {json} Request-Example:
 *	HTTP/1.1 200 OK
 *	{
 *			"first_dns": "8.8.8.8",
 *			"second_dns": "114.114.114.114"
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
 *		"code":"非0"
 *	}
 *
 */


class DNSController extends mController {	
	public $module = 'dns';
}