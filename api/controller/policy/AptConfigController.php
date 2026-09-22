<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/apt-config 获取沙箱配置
 * @apiName apt-config
 * @apiGroup 防护策略
 *
 *
 * @apiSuccess {String} enable 启用
 * @apiSuccess {String} server1 服务器(主) 
 * @apiSuccess {String} server2 服务器(备)
 * @apiSuccess {String} port1 端口(主) 
 * @apiSuccess {String} port2 端口(备) 
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"server1": "11.1.1.1",
 *			"port1": "23" ,
 *			"server2": "22.2.1.1",
 *			"port2": "45",
 *			"enable": "1" 
 *		}
 *	}
 */

/**
 * @api {PUT}  /api/apt-config 修改沙箱配置
 * @apiName apt-config
 * @apiGroup 防护策略
 *
 *
 * @apiParam {String} enable 启用
 * @apiParam {String} server1 服务器(主) 
 * @apiParam {String} server2 服务器(备)
 * @apiParam {String} port1 端口(主) 
 * @apiParam {String} port2 端口(备) 
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
 *		"server1": "11.1.23.9",
 *		"port1": "500",
 *		"server2": "22.28.0.120" ,
 *		"port2": "1001"
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


class AptConfigController extends mController {	
	public $module = 'anti_apt';
}
