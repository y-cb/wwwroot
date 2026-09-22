<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/service-group 获取服务组对象
 * @apiName service-group
 * @apiGroup 服务对象
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} desc 描述
 * @apiSuccess {Number} ref 引用次数
 * @apiSuccess {Number} type 类型，固定为0
 * @apiSuccess {Array} item 成员
 * @apiSuccess {String} sev_name 成员名
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "服务组",
 *			"desc": "服务组描述",
 *			"ref": "0",
 *			"type": "0",
 *			"item": [
 *				{
 *					"sev_name": "ah"
 * 				},
 *				{
 *					"sev_name": "bootpc"
 *				}	
 *			]
 *		},
 *		{
 *			"name": "服务组1",
 *			"desc": "服务组描述1",
 *			"ref": "0",
 *			"type": "0",
 *			"item": [
 *				{
 *					"sev_name": "dns"
 * 				},
 *				{
 *					"sev_name": "esp"
 *				}	
 *			]
 *		}
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/service-group 添加服务组对象
 * @apiName service-group
 * @apiGroup 服务对象
 *
 *
 * @apiParam {String} name 名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} ref 引用次数
 * @apiParam {Array} item 成员
 * @apiParam {String} sev_name 成员名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "服务组",
 *		"desc": "服务组描述",
 *		"ref": "0",
 *		"item": [
 *			{
 *				"sev_name": "ah"
 * 			},
 *			{
 *				"sev_name": "bootpc"
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
 * @api {PUT}  /api/service-group 修改服务组对象
 * @apiName service-group
 * @apiGroup 服务对象
 *
 *
 * @apiParam {String} name 名称
 * @apiParam {String} desc 描述
 * @apiParam {Number} ref 引用次数
 * @apiParam {Array} item 成员
 * @apiParam {String} sev_name 成员名
 * @apiParam {Number} type 类型，固定为0
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "服务组",
 *		"desc": "服务组描述",
 *		"ref": "0",
 *		"type": "0",
 *		"item": [
 *			{
 *				"sev_name": "ldap"
 * 			},
 *			{
 *				"sev_name": "bootpc"
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
 * @api {DELETE}  /api/service-group 删除服务组对象
 * @apiName service-group
 * @apiGroup 服务对象
 *
 *
 * @apiParam {String} name 名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "服务组"
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

class ServiceGroupController extends mController {	
	public $module = 'sev_objgrp_table';
}
