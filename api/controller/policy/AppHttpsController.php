<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/app-https 获取https审计的配置
 * @apiName 获取https审计的配置
 * @apiGroup 应用策略
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *      }
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
		{
			"item":,
			{"group": [
				{
					"mask": "32", 
					"host": "1.1.1.1", 
					"type": "1"
				}, 
				{
					"type": "2", 
					"domain_name": "www.jd.com"
				}
				]
			}, 
			"enable": "1", 
			"server_name": "8.8.8.8"
		}
		]
 *	}
 */


/**
 * @api {PUT}  /api/app-https 修改https审计的配置
 * @apiName 修改https审计的配置
 * @apiGroup 应用策略 
 *
 *
 * @apiParam {String} server_name dns域名服务器ip地址
 * @apiParam {Number} enable https服务是否使能
 * @apiParam {String} item[type]  类型：1代表IP 2代表域名 3代表IP域名对
 * @apiParam {String} item[host]  IP地址
 * @apiParam {String} item[domain_name]  域名
 * @apiParam {String} item[mask]  掩码 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"server_name": "8.8.8.8",
 *		"enable": "0",
 *		"item": [{"id":0, "type":"1", "host":"1.1.1.1", "mask":32}, {"id":1, "type":"2", "domain_name":"www.jd.com"}]
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */



class AppHttpsController extends mController {	
	public $module = 'https_setting';
}
