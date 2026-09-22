<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha_ifsync 获取HA接口联动配置
 * @apiName 获取HA接口联动配置
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} group_name  接口联动名称
 * @apiSuccess {Number} group_status  接口联动状态 1:up 0:down
 * @apiSuccess {Array} ifname_items  接口组包含接口数组
 * @apiSuccess {String} ifname  接口组包含接口名字
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"group_name": "test",
 *			"group_status": "1",
 *			"ifname_items": [
 *			{
 *				"ifname":"ge0/0"
 *			}
 *			],
 *		},
 *		{
 *			"group_name": "test",
 *			"group_status": "0",
 *			"ifname_items": [
 *			{
 *				"ifname":"ge0/2",
 *				"ifname":"ge0/3"
 *			}
 *			],
 *		},
 *	],
 *	"total": 2
 *	}
 */

 /**
 * @api {PUT} /api/ha_ifsync 修改接口联动组
 * @apiName 修改接口联动组
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} group_name  接口联动名称
 * @apiSuccess {Array} ifname_items  接口组包含接口数组
 * @apiSuccess {String} ifname  接口组包含接口名字
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"group_name": "sunya",
 *			"op": "detail"
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"group_name": "sunya",
 *			"group_status": "0",
 *			"ifname_items": [
 *			{
 *				"ifname":"ge0/2",
 *				"ifname":"ge0/3"
 *			}
 *			],
 *	}
 */
 
/**
 * @api {POST} /api/ha_ifsync 添加接口联动组
 * @apiName 添加接口联动组
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} group_name  接口联动名称
 * @apiSuccess {Array} ifname_items  接口组包含接口数组
 * @apiSuccess {String} ifname  接口组包含接口名字
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"group_name": "sunya",
 *			"ifname_items": [
 *			{
 *				"ifname":"ge0/1",
 *				"ifname":"ge0/4"
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
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {PUT} /api/ha_ifsync 修改接口联动组
 * @apiName 修改接口联动组
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} group_name  接口联动名称
 * @apiSuccess {Array} ifname_items  接口组包含接口数组
 * @apiSuccess {String} ifname  接口组包含接口名字
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"group_name": "sunya",
 *			"ifname_items": [
 *			{
 *				"ifname":"ge0/1",
 *				"ifname":"ge0/4"
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
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {DELETE} /api/ha_ifsync 删除接口联动组
 * @apiName 删除接口联动组
 * @apiGroup 高可靠性
 *
 *
 * @apiParam {String} group_name  XXX 此处替换为对group_name,的中文注释
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"group_name": "sunya"
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


class HaIfSyncController extends mController {	
	public $module = 'if_sync_group';
}
