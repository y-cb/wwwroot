<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/cloud-agent 获取云平台配置信息
 * @apiName 获取云平台配置信息
 * @apiGroup 云平台
 *
 *
 * @apiSuccess {Number} version  云平台版本
 * @apiSuccess {Number} enable  云平台启用状态
 * @apiSuccess {Number} log_state  上报日志状态
 * @apiSuccess {String} bind_code  绑定吗
 * @apiSuccess {String} cloud_domain  域
 * @apiSuccess {String} cloud_ip  云平台地址
 * @apiSuccess {Number} cloud_port  云平台端口
 * @apiSuccess {Number} alive_cycle  状态上报间隔
 * @apiSuccess {String} curr_state  状态
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"version": "2",
 *			"enable": "1",
 *			"log_state": "0",
 *			"bind_code": "aed995e7ce694c4287d9cd512e3d3229",
 *			"cloud_domain": "",
 *			"cloud_ip": "1.1.1.1",
 *			"cloud_port": "9070",
 *			"alive_cycle": "10",
 *			"curr_state": "Initialized"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/cloud-agent 修改云平台配置信息
 * @apiName 修改云平台配置信息
 * @apiGroup 云平台
 *
 *
 * @apiParam {Number} version  云平台版本
 * @apiParam {Number} enable  云平台启用状态
 * @apiParam {Number} log_state  上报日志状态
 * @apiParam {String} bind_code  绑定吗
 * @apiParam {String} cloud_domain  域
 * @apiParam {String} cloud_ip  云平台地址
 * @apiParam {Number} cloud_port  云平台端口
 * @apiParam {Number} alive_cycle  状态上报间隔
 * @apiParam {String} curr_state  状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"version": "2",
 *		"enable": "1",
 *		"log_state": "1",
 *		"bind_code": "aed995e7ce694c4287d9cd512e3d3229",
 *		"cloud_domain": "",
 *		"cloud_ip": "1.1.1.1",
 *		"cloud_port": "9070",
 *		"alive_cycle": "10",
 *		"curr_state": "Initialized"
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

/**
 * @api {PUT}  /api/cloud-agent 修改云平台配置信息
 * @apiName 修改云平台配置信息
 * @apiGroup 云平台
 *
 *
 * @apiParam {Number} version  云平台版本
 * @apiParam {Number} enable  云平台启用状态
 * @apiParam {Number} log_state  上报日志状态
 * @apiParam {String} bind_code  绑定吗
 * @apiParam {String} cloud_domain  域
 * @apiParam {String} cloud_ip  云平台地址
 * @apiParam {Number} cloud_port  云平台端口
 * @apiParam {Number} alive_cycle  状态上报间隔
 * @apiParam {String} curr_state  状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"version": "2",
 *		"enable": "1",
 *		"log_state": "1",
 *		"bind_code": "aed995e7ce694c4287d9cd512e3d3229",
 *		"cloud_domain": "",
 *		"cloud_ip": "1.1.1.1",
 *		"cloud_port": "9070",
 *		"alive_cycle": "10",
 *		"curr_state": "Initialized"
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


class CloudAgentController extends mController {	
	public $module = 'cloud_agent';
}