<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/url-category 获取预定义URL分类
 * @apiName 获取预定义URL分类
 * @apiGroup URL
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} show_name 中文名称
 * @apiSuccess {String} description 描述
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "entertainment",
 *			"show_name": "娱乐",
 *			"description": "提供综合性娱乐、影视的网站。"
 *		},
 *		{
 *			"name": "game",
 *			"show_name": "游戏",
 *			"description": "提供各种电子游戏的网站。"
 *		}
 *	],
 *	"total": 2
 *	}
 */

class UrlCategoryController extends mController {	
	public $module = 'xml_url_category';
}
