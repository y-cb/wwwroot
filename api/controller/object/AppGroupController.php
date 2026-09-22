<?php
namespace controller\object;
use controller\mController;

/**
 * @api {POST}  /api/app-group 添加应用组对象
 * @apiName 添加应用组对象
 * @apiGroup 应用
 *
 *
 * @apiParam {String} name 应用组对象名称
 * @apiParam {String} desc 应用组对象描述
 * @apiParam {Array} member 应用组对象引用的对象信息:"id" 序号  "name" 名称,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaaa",
 *		"desc": "bbbb",
 *		"member": [{"id":0, "name":"email"}]
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

/**
 * @api {PUT}  /api/app-group 添加应用组对象
 * @apiName 添加应用组对象
 * @apiGroup 应用
 *
 *
 * @apiParam {String} name 应用组对象名称
 * @apiParam {String} desc 应用组对象描述
 * @apiParam {Array} member 应用组对象引用的对象信息:"id" 序号  "name" 名称,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaaa",
 *		"desc": "bbbb",
 *		"member": [{"id":0, "name":"email"}, {"id":1, "name":"websites"}]
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

/**
 * @api {GET}  /api/app-group 显示所有应用组对象
 * @apiName 显示所有应用组对象
 * @apiGroup  应用
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [{"ref": "0", "name": "aaaa", "desc": "bbbb"}]
 *	}
 */


/**
 * @api {GET}  /api/app-group 显示单个应用组对象
 * @apiName 显示单个应用组对象
 * @apiGroup 应用 
 *
 *
 * @apiParam {String} name 应用组对象名称
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaaa",
 *		"op": "detail_o"
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"member": "{"group":{"name":"icq","show_name":"ICQ","parent_name":"instant-messaging","parent_show_name":"\u5373\u65f6\u901a\u8baf","risk":"0","popular":"0"}}",
		"name": "aaaa", 
		"desc": "bbbb"
 *	}
 */

/**
 * @api {DELETE}  /api/app-group 删除应用组对象
 * @apiName 删除应用组对象
 * @apiGroup 应用
 *
 *
 * @apiParam {String} name 应用组对象名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "aaaa"
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


class AppGroupController extends mController {	
	public $module = 'app_group';
}
