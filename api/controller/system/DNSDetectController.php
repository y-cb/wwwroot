<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/dns-detect DNS域名检测
 * @apiName DNS域名检测
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {String} dns_name  探测域名
 * @apiSuccess {String} first_dns  主DNS
 * @apiSuccess {String} second_dns  备DNS
 *
 * @apiSuccessExample {json} Request-Example:
 *	HTTP/1.1 200 OK
 *	{
 *			"dns_name": "www.baidu.com",
 *			"first_dns": "8.8.8.8",
 *			"second_dns": "114.114.114.114"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"dns_name": "www.baidu.com",
 *			"ip": "119.75.213.61,119.75.216.20"
 *	}
 */


class DNSDetectController extends mController{	
	public $module = 'detect';
}

