<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/keyword 获取关键字对象
 * @apiName keyword
 * @apiGroup 关键字
 *
 *
 * @apiSuccess {String} id 编号
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} description 描述
 * @apiSuccess {String} ref 引用
 * @apiSuccess {String} keyword 关键字
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"name": "shi",
 *			"description": "test",
 *			"ref": "0",
 *			"keyword": [
 *			{
 *		 		"name": "baidu.com"
 *			}, 
 *			{
 *				"name": "qq.com"
 *			}
 *			]
 *		}
 *		{
 *			"id": "2",
 *			"name": "ping",
 *			"description": "qwert",
 *			"ref": "0",
 *			"keyword": [
 *			{
 *		 		"name": "sina.com"
 *			}, 
 *			{
 *				"name": "aqiy.com"
 *			}
 *			]
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/keyword 添加关键字对象
 * @apiName keyword
 * @apiGroup 关键字
 *
 *
 * @apiParam {String} id 编号
 * @apiParam {String} name 名称
 * @apiParam {String} description 描述
 * @apiParam {String} keyword 关键字
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"id": "1",
 *			"name": "shi",
 *			"description": "test",
 *			"keyword": [
 *			{
 *		 		"name": "baidu.com"
 *			}, 
 *			{
 *				"name": "qq.com"
 *			}
 *			]
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
 *		"code":"-17",
 *		"str":"Keyword name  already exist"
 *	}
 *
 */

/**
 * @api {PUT}  /api/keyword 修改关键字对象
 * @apiName keyword
 * @apiGroup 关键字
 *
 *
 * @apiParam {String} id 编号
 * @apiParam {String} name 名称
 * @apiParam {String} description 描述
 * @apiParam {String} keyword 关键字

 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"id": "1",
 *			"name": "shi",
 *			"description": "test",
 *			"keyword": [
 *			{
 *		 		"name": "www.baidu.com"
 *			}, 
 *			{
 *				"name": "qq.com"
 *			}
 *			]
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
 * @api {DELETE}  /api/keyword 删除关键字对象
 * @apiName keyword
 * @apiGroup 关键字
 *
 *
 * @apiParam {String} name 名称
 * 
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "shi"
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


class KeywordController extends mController {	
	public $module = 'obj_keywords';
}
