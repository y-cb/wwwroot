<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/cloud-agent-frp 获取云平台FRP配置信息
 * @apiName 获取云平台FRP配置信息
 * @apiGroup 云平台
 *
 *
 * @apiSuccess {Number} ssh_port  远端SSH端口
 * @apiSuccess {Number} http_port  远端HTTP端口
 * @apiSuccess {Number} https_port  远端HTTPS端口
 * 
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ssh_port": "6022",
 *			"http_port": "6080",
 *			"https_port": "60443"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/cloud-agent-frp 修改云平台FRP配置信息
 * @apiName 修改云平台FRP配置信息
 * @apiGroup 云平台
 *
 *
 * @apiSuccess {Number} ssh_port  远端SSH端口
 * @apiSuccess {String} ssh_open  是否开启SSH，on/off
 * @apiSuccess {Number} http_port  远端HTTP端口
 * @apiSuccess {String} http_open  是否开启HTTP，on/off
 * @apiSuccess {Number} https_port  远端HTTPS端口
 * @apiSuccess {String} https_open  是否开启HTTPS，on/off
 * @apiSuccess {String} custom_domains  域名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ssh": "0",
 *		"ssh_open": "off",
 *		"http": "6080",
 *		"http_open": "on",
 *		"https": "60443"
 *		"https_open": "on",
 *		"custom_domains": "test.com",
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */

class CloudAgentFrpController extends mController {	
	public $module = 'cloud_agent_frp';
}