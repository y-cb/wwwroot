<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-trunk 获取链路聚合监控配置
 * @apiName 获取链路聚合监控配置
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  链路聚合名称
 * @apiSuccess {Number} mem  链路聚合成员数
 * @apiSuccess {Number} act  链路聚合可用成员数
 * @apiSuccess {Number} thresh  最小可用成员数1-100
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"mem": "2",
 *			"act": "1",
 *			"thresh": "1"
 *		},
 *		{
 *			"name": "trunk",
 *			"mem": "1",
 *			"act": "0",
 *			"thresh": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

 /**
 * @api {GET} /api/ha-trunk 获取单条链路聚合监控配置
 * @apiName 获取单条链路聚合监控配置
 * @apiGroup 高可靠性
 *
 *
 * @apiParam {String} name  要获取链路聚合的名称
 * @apiParam {String} op    操作
 * 
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"name": "test",
 *			"mem": "2",
 *			"act": "1",
 *			"thresh": "1"
 *	}
 *
 */
 
/**
 * @api {POST} /api/ha-trunk 添加链路聚合监控配置
 * @apiName 添加链路聚合监控配置
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} name  链路聚合名称
 * @apiSuccess {Number} thresh  最小可用成员数1-100
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"thresh": "0"
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
 * @api {DELETE} /api/ha-trunk 删除链路聚合配置
 * @apiName 删除链路聚合配置
 * @apiGroup 高可靠性
 *
 *
 * @apiParam {String} name  要删除的链路聚合名称
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
 *		"code":"非0",
 *		"str":"XXX"
 *	}
 *
 */


class HaTrunkController extends mController{	
	public $module = 'ha_trunk';
}

