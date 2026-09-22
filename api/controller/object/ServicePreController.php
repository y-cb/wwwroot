<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/service-predefined 获取预定义服务对象
 * @apiName service-predefined
 * @apiGroup 服务对象
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {Number} ref 引用计数
 * @apiSuccess {Array} item 内容(协议/源端口-目的端口)
 * @apiSuccess {String} sev_str 协议/源端口-目的端口
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "ike",
 *			"ref": "0",
 *			"item": [
 *				{
 *					"sev_str": "UDP/1-65535:500"
 * 				},
 *				{
 *					"sev_str": "UDP/1-65535:4500"
 *				}
 *			]
 *		},
 *		{
 *			"name": "imap",
 *			"ref": "0",
 *			"item": [
 *				{
 *					"sev_str": "TCP/1-65535:143"
 * 				}
 *			]
 *		}
 *	],
 *	"total": 2
 *	}
 */

class ServicePreController extends mController {	
	public $module = 'sys_sev_table';
}
