<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/session-proto 查询协议管理配置信息
 * @apiName 查询协议管理配置信息
 * @apiGroup 协议管理
 *
 *
 * @apiSuccess {String} name  名称
 * @apiSuccess {String} desc  描述
 * @apiSuccess {Number} proto  协议
 * @apiSuccess {Number} port  端口
 * @apiSuccess {Number} timeout  超时时间
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"desc": "test",
 *			"proto": "6",
 *			"port": "2222",
 *			"timeout": "2323"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/session-proto 新增协议管理配置信息
 * @apiName 新增协议管理配置信息
 * @apiGroup 协议管理
 *
 *
 * @apiParam {String} name  名称
 * @apiParam {String} desc  描述
 * @apiParam {Number} proto  协议
 * @apiParam {Number} port  端口
 * @apiParam {Number} timeout  超时时间
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "test",
 *		"proto": "6",
 *		"port": "2323",
 *		"timeout": "2323"
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
 * @api {PUT}  /api/session-proto 修改协议管理配置信息
 * @apiName 修改协议管理配置信息
 * @apiGroup 协议管理
 *
 *
 * @apiParam {String} name  名称
 * @apiParam {String} desc  描述
 * @apiParam {Number} proto  协议
 * @apiParam {Number} port  端口
 * @apiParam {Number} timeout  超时时间
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"desc": "test",
 *		"proto": "6",
 *		"port": "2323",
 *		"timeout": "2323"
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
 * @api {DELETE}  /api/session-proto 删除协议管理配置信息
 * @apiName 删除协议管理配置信息
 * @apiGroup 协议管理
 *
 *
 * @apiParam {String} name  名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test"
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

class SessionProtoController extends mController{
	public $module = 'proto_manage_table';
}

