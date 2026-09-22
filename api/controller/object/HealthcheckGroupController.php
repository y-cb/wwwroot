<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/health-check-group 获取健康检查组
 * @apiName 获取健康检查组
 * @apiGroup 健康检查
 *
 * @apiParam {Number} iptype 协议类型，固定值为0
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"iptype": "0"
 *	}
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {Number} ref 引用
 * @apiSuccess {Number} iptype 协议类型
 * @apiSuccess {Number} least_pass_num 至少通过的健康检查方法数
 * @apiSuccess {Array} item 健康检查数组
 * @apiSuccess {String} template_name 成员
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "1",
 *			"ref": "0",
 *			"iptype": "0",
 *			"least_pass_num": "1",
 *			"item": [
 *			{
 *	 			"template_name": "asd"
 *			}, 
 *			{
 *	 			"template_name": "1234"
 *			}
 *			]
 *		},
 *		{
 *			"name": "5",
 *			"ref": "0",
 *			"iptype": "1",
 *			"least_pass_num": "1",
 *			"item":,
 *			{
 *	 			"template_name": ""
 *			}
 *		} 
 *	],
 *	}
 *
 * @apiParam {String} name 名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "1"
 *	}
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {Number} ref 引用
 * @apiSuccess {Number} iptype 协议类型：0代表IPv4，1代表IPv6
 * @apiSuccess {Number} least_pass_num 通过的健康检查方法数，0代表所有，1代表至少
 * @apiSuccess {Array} item 健康检查数组
 * @apiSuccess {String} template_name 成员
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"name": "1",
 *			"ref": "0",
 *			"iptype": "0",
 *			"least_pass_num": "1",
 *			"item": [
 *			{
 *	 			"template_name": "asd"
 *			}, 
 *			{
 *	 			"template_name": "1234"
 *			}
 *			],
 *		}
 *	}
 */

/**
 * @api {POST} /api/health-check-group 添加健康检查组
 * @apiName 添加健康检查组
 * @apiGroup 健康检查
 *
 *
 * @apiParam {String} name 名称
 * @apiParam {Number} iptype 协议类型：0代表ipv4，1代表ipv6
 * @apiParam {Number} least_pass_num 通过的健康检查方法数，0代表所有，1代表至少
 * @apiParam {String} template_name 成员
 *
 * @apiParamExample {json} Request-Example:
 *	{
 * 		"name": "admin",
 *		"iptype": "0",
 *		"least_pass_num": "1",
 *		"item": [
 *		{
 * 			"template_name": "asd"
 *		}, 
 *		{
 *			"template_name": "1234"	 
 *		}
 *		]
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code": "0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code": "非0",
 *		"str": ""
 *	}
 *
 */

/**
 * @api {PUT} /api/health-check-group 修改健康检查组
 * @apiName 修改健康检查组
 * @apiGroup 健康检查
 *
 *
 * @apiParam {String} template_name 成员
 * @apiParam {String} name 名称
 * @apiParam {Number} ref 引用
 * @apiParam {Number} iptype 协议类型：0代表ipv4，1代表ipv6
 * @apiParam {Number} least_pass_num 通过的健康检查方法数，0代表所有，1代表至少
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "admin",
 *		"ref": "0",
 *		"iptype": "0",
 *		"least_pass_num": "1",
 *		"item": [
 *		{
 *	 		"template_name": "asd"
 *		}, 
 *		{
 *	 		"template_name": "1234"
 *		}
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
 * @api {DELETE} /api/health-check-group 删除健康检查组
 * @apiName 删除健康检查组
 * @apiGroup 健康检查
 *
 *
 * @apiParam {String} name 名称
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "admin"
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


class HealthcheckGroupController extends mController {	
	public $module = 'healthcheck_group';
}