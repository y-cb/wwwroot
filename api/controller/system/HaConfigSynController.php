<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-configsync 获取配置同步配置参数
 * @apiName 获取配置同步配置参数
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {Number} detect_enable  实时监测同步状态 0：关闭 1：启用
 * @apiSuccess {Number} web_sync  配置自动同步 0：关闭 1：启用
 * @apiSuccess {String} syn_peer  对端地址
 * @apiSuccess {String} syn_local  本地地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"detect_enable": "0",
 *			"web_sync": "0",
 *			"syn_peer": "1.1.1.1",
 *			"syn_local": "1.1.1.2"
 *	}
 */

/**
 * @api {PUT} /api/ha-configsync 修改配置同步配置参数
 * @apiName 修改配置同步配置参数
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {Number} detect_enable  实时监测同步状态 0：关闭 1：启用
 * @apiSuccess {Number} web_sync  配置自动同步 0：关闭 1：启用
 * @apiSuccess {String} syn_peer  对端地址
 * @apiSuccess {String} syn_local  本地地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"detect_enable": "0",
 *			"web_sync": "0",
 *			"syn_peer": "1.1.1.1",
 *			"syn_local": "1.1.1.2"
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


class HaConfigSynController extends mController {	
	public $module = 'ha_config_syn';
}
