<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-sessionsync 获取HA连接同步配置
 * @apiName 获取HA连接同步配置
 * @apiGroup 高可靠性
 *
 *
 * @apiParam {String} session_primary_self  本地首选通信地址
 * @apiParam {String} session_primary_peer  对端首选通信地址
 * @apiParam {String} session_second_self  本地备选通信地址
 * @apiParam {String} session_second_peer  对端备选通信地址
 * @apiParam {Number} conn_mirror_enable  连接同步开关0：关闭 1：开启
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"session_primary_self": "1.1.1.1",
 *		"session_primary_peer": "1.1.1.2",
 *		"session_second_self": "1.1.1.3",
 *		"session_second_peer": "1.1.1.4",
 *		"conn_mirror_enable": "1"
 *	}
 */


/**
 * @api {PUT} /api/ha-sessionsync 修改HA连接同步配置
 * @apiName 修改HA连接同步配置
 * @apiGroup 高可靠性
 *
 *
 * @apiParam {String} session_primary_self  本地首选通信地址
 * @apiParam {String} session_primary_peer  对端首选通信地址
 * @apiParam {String} session_second_self  本地备选通信地址
 * @apiParam {String} session_second_peer  对端备选通信地址
 * @apiParam {Number} conn_mirror_enable  连接同步开关0：关闭 1：开启
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"session_primary_self": "1.1.1.1",
 *		"session_primary_peer": "1.1.1.2",
 *		"session_second_self": "1.1.1.3",
 *		"session_second_peer": "1.1.1.4",
 *		"conn_mirror_enable": "1"
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


class HaSessionSynController extends mController {	
	public $module = 'ha_session_syn';
}
