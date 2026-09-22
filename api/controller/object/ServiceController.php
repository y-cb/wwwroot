<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/service 获取自定义服务对象
 * @apiName service
 * @apiGroup 服务对象
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} desc 描述
 * @apiSuccess {Number} ref 引用
 * @apiSuccess {Array} item 内容
 * @apiSuccess {String} sev_str 协议/源端口-目的端口
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"desc": "自定义服务",
 *			"ref": "0",
 *			"item": [
 *				{
 *					"sev_str": "TCP/1-65535:2-2000"
 * 				},
 *				{
 *					"sev_str": "TCP/1-65535:5-1000"
 *				}	
 *			]
 *		},
 *		{
 *			"name": "aa",
 *			"desc": "服务",
 *			"ref": "0",
 *			"item": [
 *				{
 *					"sev_str": "TCP/1-65535:2000-10000"
 * 				}
 *			]
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/service 添加自定义服务对象
 * @apiName service
 * @apiGroup 服务对象
 *
 *
 * @apiParam {String} name 名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} ref 引用次数
 * @apiParam {Array} item 内容
 * @apiParam {String} sev_str 协议/源端口-目的端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "自定义服务",
 *		"ref": "0",
 *		"item": [
 *			{
 *				"sev_str": "TCP/1-65535:2-2000"
 * 			},
 *			{
 *				"sev_str": "TCP/1-65535:5-1000"
 *			}
 *		]
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
 * @api {PUT}  /api/service 修改自定义服务对象
 * @apiName service
 * @apiGroup 服务对象
 *
 *
 * @apiParam {String} name 名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} ref 引用次数
 * @apiParam {Array} item 内容
 * @apiParam {String} sev_str 协议/源端口-目的端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "自定义服务",
 *		"ref": "0",
 *		"item": [
 *			{
 *				"sev_str": "TCP/1-65535:2-2000"
 * 			},
 *			{
 *				"sev_str": "TCP/1-65535:5-1000"
 *			},
 *			{
 *				"sev_str": "UDP/1-65535:5-1000"
 *			}
 *		]
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
 * @api {DELETE}  /api/service 删除自定义服务对象
 * @apiName service
 * @apiGroup 服务对象
 *
 *
 * @apiParam {String} name 名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aa"
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

class ServiceController extends mController {	
	public $module = 'sev_obj_table';
}
