<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/user-group 获取所有用户对象组信息
 * @apiName 获取所有用户对象组信息
 * @apiGroup 用户对象
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 4, 
		"data": [
				{
					"predefined": "1", 
					"description": "", 
					"show_name": "\u533f\u540d\u7528\u6237\u7ec4", 
					"ref_num": "0", 
					"user_items": "", 
					"readonly": "1", 
					"children_num": "0", 
					"id": "1001", 
					"name": "anonymous"
				}, 
				{
					"predefined": "1", 
					"description": "", 
					"show_name": "\u8fdc\u7a0b\u7528\u6237\u7ec4", 
					"ref_num": "0", 
					"user_items": "", 
					"readonly": "1", 
					"children_num": "0", 
					"id": "1005", 
					"name": "remote"
				}, 
				{
					"predefined": "1", 
					"description": "", 
					"show_name": "Portal\u7528\u6237\u7ec4", 
					"ref_num": "0", 
					"user_items": "", 
					"readonly": "1", 
					"children_num": "0", 
					"id": "1006", 
					"name": "portal-server"
				}, 
				{
					"predefined": "0", 
					"description": "Justatest", 
					"show_name": "alan_user_grp", 
					"ref_num": "0", 
					"user_items": {
							"group": [
									{
										"predefined": "0", 
										"name": "local_user_obj", 
										"show_name": "local_user_obj", 
										"readonly": "0", 
										"type": "items", 
										"id": "2006"
									}, 
									{
										"predefined": "0", 
										"name": "new_local_user_obj", 
										"show_name": "new_local_user_obj", 
										"readonly": "0", 
										"type": "items", 
										"id": "2010"
									}
								]
							}, 
					"readonly": "0", 
					"children_num": "2", 
					"id": "2014", 
					"name": "alan_user_grp"
				}
			]

 *	}
 */

/**
 * @api {GET}  /api/user-group 获取单个用户对象组信息
 * @apiName 获取单个用户对象组信息
 * @apiGroup 用户对象
 *
 *
 * @apiSuccess {String} name 用户对象组名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_grp",
 *		"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"predefined": "0", 
		"description": "Justatest", 
		"show_name": "alan_user_grp", 
		"ref_num": "0", 
		"user_items": "{\"group\":[{\"id\":\"2006\",\"name\":\"local_user_obj\",\"show_name\":\"local_user_obj\",\"type\":\"items\",\"predefined\":\"0\",\"readonly\":\"0\"},{\"id\":\"2010\",\"name\":\"new_local_user_obj\",\"show_name\":\"new_local_user_obj\",\"type\":\"items\",\"predefined\":\"0\",\"readonly\":\"0\"}]}", 
		"readonly": "0", 
		"children_num": "2", 
		"id": "2014", 
		"name": "alan_user_grp",

 *	}
 */

/**
 * @api {POST}  /api/user-group 添加用户组信息
 * @apiName 添加用户组信息
 * @apiGroup 用户对象
 *
 *
 * @apiParam {String} name 用户组对象名称
 * @apiParam {String} description 用户组对象描述
 * @apiParam {Array} user_items 用户组对象引用的用户对象和用户组对象:"id":序号"name":用户对象名称或者用户组对象名称"type":标识是用户对象还是用户组对象,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_grp",
 *		"description": "Justatest",
 *		"user_items": [{"id":0, "name":"local_user_obj", "type":"items"}]
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
 *		"str":"对应的错误信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/user-group 修改用户组信息
 * @apiName 修改用户组信息
 * @apiGroup 用户对象
 *
 *
 * @apiParam {String} name 用户组对象名称
 * @apiParam {String} description 用户组对象描述
 * @apiParam {Array} user_items 用户组对象引用的用户对象和用户组对象:"id":序号"name":用户对象名称或者用户组对象名称"type":标识是用户对象还是用户组对象,
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_grp",
 *		"description": "Justatest",
 *		"user_items": [{"id":0, "name":"local_user_obj", "type":"items"}, {"id":1, "name":"new_local_user_obj", "type":"items"}]
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
 *		"str":"对应的错误信息"
 *	}
 *
 */


/**
 * @api {DELETE}  /api/user-group 删除用户组信息
 * @apiName 删除用户组信息
 * @apiGroup 用户对象
 *
 *
 * @apiParam {String} name 用户对象组名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "alan_user_grp"
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
 *		"str":"对应的错误提示"
 *	}
 *
 */


class UserGroupController extends mController {	
	public $module = 'auth_user_grp';
}
