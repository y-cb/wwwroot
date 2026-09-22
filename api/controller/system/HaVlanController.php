<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-vlan 获取故障监控
 * @apiName 获取故障监控
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  接口名称
 * @apiSuccess {Number} timeout  超时时间  0-3600秒
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "ge0/3",
 *			"timeout": "0"
 *		},
 *		{
 *			"name": "ge0/4",
 *			"timeout": "100"
 *		}
 *	],
 *	"total": 2
 *	}
 */

 /**
 * @api {GET} /api/ha-vlan 获取单个故障监控
 * @apiName 获取单个故障监控
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  接口名称
 * @apiSuccess {Number} timeout  超时时间  0-3600秒
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ge0/3",
 *		"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"name": "ge0/3",
 *			"timeout": "0"
 *	}
 */
 
/**
 * @api {POST} /api/ha-vlan 添加修改故障监控
 * @apiName 添加修改故障监控
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  接口名称
 * @apiSuccess {Number} timeout  超时时间  0-3600秒
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ge0/2",
 *		"timeout": "100"
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
 *		"str":"XXX"
 *	}
 *
 */

/**
 * @api {DELETE} /api/ha-vlan 删除故障监控
 * @apiName 删除故障监控
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  接口名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ge0/2"
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
 *		"str":"XXX"
 *	}
 *
 */

class HaVlanController extends mController{	
	public $module = 'ha_vlan';
}

