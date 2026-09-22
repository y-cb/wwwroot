<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/unused-interface 获取未被本模块使用的接口
 * @apiName 接口联动功能，获取可以被本模块使用的接口，
 * @apiGroup 接口列表获取
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "ge0/0"
 *		},
 *		{
 *			"name": "ge0/1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {PUT}  /api/unused-interface 不支持PUT
 * @apiName 不支持PUT
 * @apiGroup 接口列表获取
 *
 *
 */



class UnusedInfController extends mController {	
	public $module = 'if_member_unused';
}
