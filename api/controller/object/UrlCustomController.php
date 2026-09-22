<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/url-userdefined 获取自定义URL分类
 * @apiName 获取自定义URL分类
 * @apiGroup URL
 *
 *
 * @apiSuccess {String} category_name 名称
 * @apiSuccess {String} category_description 描述
 * @apiSuccess {Number} ref 引用计数
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"category_name": "URL",
 *			"category_description": "自定义",
 *			"ref": "0"
 *		},
 *		{
 *			"category_name": "自定义URL",
 *			"category_description": "自定义URL描述",
 *			"ref": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 *
 *
 * @apiParam {String} category_name 名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"category_name": "URL"
 *	}
 *
 * @apiSuccess {String} category_name 名称
 * @apiSuccess {String} category_description 描述
 * @apiSuccess {String} url_content URL详细信息
 * @apiSuccess {Number} ref 引用计数
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"category_name": "URL",
 *			"category_description": "自定义",
 *			"url_content": "www.baidu.com www.sina.com.cn www.qq.com",
 *			"ref": "0"
 *		}
 *	}
 */

/**
 * @api {POST}  /api/url-userdefined 添加自定义URL分类
 * @apiName 添加自定义URL分类
 * @apiGroup URL
 *
 *
 * @apiParam {String} category_name 名称
 * @apiParam {String} category_description 描述
 * @apiParam {String} url_content URL详细信息
 * @apiParam {Number} ref 引用计数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"category_name": "URL",
 *		"category_description": "自定义",
 *		"url_content": "www.baidu.com www.sina.com.cn www.qq.com",
 *		"ref": "0"
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
 * @api {PUT}  /api/url-userdefined 修改自定义URL分类
 * @apiName 修改自定义URL分类
 * @apiGroup URL
 *
 *
 * @apiParam {String} category_name 名称
 * @apiParam {String} category_description 描述
 * @apiParam {String} url_content URL详细信息
 * @apiParam {Number} ref 引用计数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"category_name": "URL",
 *		"category_description": "自定义",
 *		"url_content": "www.baidu.com www.sina.com.cn",
 *		"ref": "0"
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
 * @api {DELETE}  /api/url-userdefined 删除自定义URL分类
 * @apiName 删除自定义URL分类
 * @apiGroup URL
 *
 * @apiParam {String} category_name 名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"category_name": "URL"
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


class UrlCustomController extends mController {	
	public $module = 'xml_custom_url';
}
