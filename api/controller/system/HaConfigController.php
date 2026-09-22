<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-config 获取HA配置
 * @apiName 获取HA配置
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {Number} workmode  工作模式 0：禁用 1：主备模式 2：主主模式
 * @apiSuccess {String} hb_primary_self 本地首选通信地址
 * @apiSuccess {String} hb_primary_peer 对端首选通信地址
 * @apiSuccess {String} hb_second_self 本地备选通信地址
 * @apiSuccess {String} hb_second_peer 对端备选通信地址
 * @apiSuccess {Number} unit_id  单元ID 1或者2
 * @apiSuccess {Number} enable_grob  抢占模式 0：禁用 1：抢占主 2：抢占备
 * @apiSuccess {Number} interval  心跳发送间隔1-3秒
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"workmode": "0",
 *			"hb_primary_self": "1.1.1.1",
 *			"hb_primary_peer": "1.1.1.2",
 *			"hb_second_self": "1.1.1.3",
 *			"hb_second_peer": "1.1.1.4",
 *			"unit_id": "1",
 *			"enable_grob": "0",
 *			"interval": "1"
 *	}
 */

/**
 * @api {PUT} /api/ha-config 修改HA配置
 * @apiName 修改HA配置
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {Number} workmode  工作模式 0：禁用 1：主备模式 2：主主模式
 * @apiSuccess {String} hb_primary_self 本地首选通信地址
 * @apiSuccess {String} hb_primary_peer 对端首选通信地址
 * @apiSuccess {String} hb_second_self 本地备选通信地址
 * @apiSuccess {String} hb_second_peer 对端备选通信地址
 * @apiSuccess {Number} unit_id  单元ID 1或者2
 * @apiSuccess {Number} enable_grob  抢占模式 0：禁用 1：抢占主 2：抢占备
 * @apiSuccess {Number} interval  心跳发送间隔1-3秒
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"workmode": "0",
 *			"hb_primary_self": "1.1.1.1",
 *			"hb_primary_peer": "1.1.1.2",
 *			"hb_second_self": "1.1.1.3",
 *			"hb_second_peer": "1.1.1.4",
 *			"unit_id": "1",
 *			"enable_grob": "0",
 *			"interval": "1"
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
 *		"code":"110",
 *		"str":"IP地址错误"
 *	}
 *
 */


class HaConfigController extends mController {	
	public $module = 'ha_config_ha';
}
