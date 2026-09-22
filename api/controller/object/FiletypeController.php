<?php
namespace controller\object;
use controller\mController;

/**
 * @api {POST}  /api/filetype 添加文件类型组
 * @apiName 添加文件类型组
 * @apiGroup 文件类型
 *
 *
 * @apiParam {String} name 文件类型组名称
 * @apiParam {String} description 文件类型组描述
 * @apiParam {Array} file_type 具体文件类型："id":类型索引  "name":文件类型名称,
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"name":"alan_file_type",
		"description":"Justatest",
		"file_type":[{"id":0, "name":"exe"}]
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
 * @api {PUT}  /api/filetype 修改文件类型组
 * @apiName 修改文件类型组
 * @apiGroup 文件类型
 *
 *
 * @apiParam {String} name 文件类型组名称
 * @apiParam {String} description 文件类型组描述
 * @apiParam {Array} file_type 具体文件类型："id":类型索引  "name":文件类型名称,
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"name":"alan_file_type",
		"description":"Justatest",
		"file_type":[{"id":0, "name":"exe"}, {"id":1, "name":"txt"}]
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
 * @api {GET}  /api/filetype 获取所有文件类型组信息
 * @apiName 获取所有文件类型组信息
 * @apiGroup 文件类型 
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
			{"file_type": {"group": [{"name": "exe"}, {"name": "txt"}]}, "ref": "0", "name": "alan_file_type", "description": "Justatest"}
			]
 *	}
 */

/**
 * @api {GET}  /api/filetype 获取单个文件类型组信息
 * @apiName 获取单个文件类型组信息
 * @apiGroup 文件类型 
 *
 *
 * @apiParam {String} name 文件类型组名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name":"alan_file_type",
 *		"op":"detail_o"
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"file_type": "{\"group\":[{\"name\":\"exe\"},{\"name\":\"txt\"}]}", 
		"ref": "0", 
		"name": "alan_file_type", 
		"description": "Justatest"
 *	}
 */

/**
 * @api {DELETE}  /api/filetype 删除文件类型组对象
 * @apiName 删除文件类型组对象
 * @apiGroup 文件类型
 *
 *
 * @apiParam {String} name 文件类型组名称
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"name":"alan_file_type"
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


class FiletypeController extends mController{	
	public $module = 'file_type_group';
}

