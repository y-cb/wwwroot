<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/flow-log 获取流日志策略
 * @apiName 获取流日志策略
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} id  流日志策略ID
 * @apiSuccess {Number} enable  使能开关 1：开 0：关
 * @apiSuccess {String} src_addr  源地址
 * @apiSuccess {String} ssr_alg  日志服务器选择算法，src-ip-hash：源IP hash， round-robin：轮询，broadcast：广播
 * @apiSuccess {Array} server_items  日志服务器数组
 * @apiSuccess {String} daddr  日志服务器IP
 * @apiSuccess {Number} dport  日志服务器端口
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"enable": "1",
 *			"src_addr": "any",
 *			"ssr_alg": "src-ip-hash",
 *			"server_items": [
 *			{
 *				"daddr": "1.1.1.1",
 *				"dport": "1"
 *			},
 *			{
 *				"daddr": "1.1.1.2",
 *				"dport": "2"
 *			}
 *			],
 *		},
 *		{
 *			"id": "2",
 *			"enable": "1",
 *			"src_addr": "any",
 *			"ssr_alg": "broadcast",
 *			"server_items": [
 *			{
 *				"daddr": "1.1.1.1",
 *				"dport": "1"
 *			},
 *			{
 *				"daddr": "1.1.1.2",
 *				"dport": "2"
 *			}
 *			],
 *		}
 *	],
 *	"total": 2
 *	}
 */

  /**
 * @api {GET} /api/flow-log 显示单条流日志策略
 * @apiName 显示单条流日志策略
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} id  流日志策略ID
 * @apiSuccess {Number} enable  使能开关 1：开 0：关
 * @apiSuccess {String} src_addr  源地址
 * @apiSuccess {String} ssr_alg  日志服务器选择算法，src-ip-hash：源IP hash， round-robin：轮询， broadcast：广播
 * @apiSuccess {Array} server_items  日志服务器数组
 * @apiSuccess {String} daddr  日志服务器IP
 * @apiSuccess {Number} dport  日志服务器端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"id": "1",
 *			"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"id": "1",
 *			"enable": "1",
 *			"src_addr": "any",
 *			"ssr_alg": "src-ip-hash",
 *			"server_items": [
 *			{
 *				"daddr": "1.1.1.1",
 *				"dport": "1"
 *			},
 *			{
 *				"daddr": "1.1.1.2",
 *				"dport": "2"
 *			}
 *			],
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
 * @api {POST} /api/flow-log 添加流日志策略
 * @apiName 添加流日志策略
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} id  流日志策略ID
 * @apiSuccess {Number} enable  使能开关 1：开 0：关
 * @apiSuccess {String} src_addr  源地址
 * @apiSuccess {String} ssr_alg  日志服务器选择算法，src-ip-hash：源IP hash， round-robin：轮询， broadcast：广播
 * @apiSuccess {Array} server_items  日志服务器数组
 * @apiSuccess {String} daddr  日志服务器IP
 * @apiSuccess {Number} dport  日志服务器端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"id": "1",
 *			"enable": "1",
 *			"src_addr": "any",
 *			"ssr_alg": "src-ip-hash",
 *			"server_items": [
 *			{
 *				"daddr": "1.1.1.1",
 *				"dport": "1"
 *			},
 *			{
 *				"daddr": "1.1.1.2",
 *				"dport": "2"
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
 * @api {PUT} /api/flow-log 修改流日志策略
 * @apiName 修改流日志策略
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} id  流日志策略ID
 * @apiSuccess {Number} enable  使能开关 1：开 0：关
 * @apiSuccess {String} src_addr  源地址
 * @apiSuccess {String} ssr_alg  日志服务器选择算法，src-ip-hash：源IP hash， round-robin：轮询， broadcast：广播
 * @apiSuccess {Array} server_items  日志服务器数组
 * @apiSuccess {String} daddr  日志服务器IP
 * @apiSuccess {Number} dport  日志服务器端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"id": "1",
 *			"enable": "1",
 *			"src_addr": "any",
 *			"ssr_alg": "src-ip-hash",
 *			"server_items": [
 *			{
 *				"daddr": "1.1.1.1",
 *				"dport": "23"
 *			},
 *			{
 *				"daddr": "1.1.1.2",
 *				"dport": "24"
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
 * @api {DELETE} /api/flow-log 删除流日志策略
 * @apiName 删除流日志策略
 * @apiGroup 日志设定
 *
 *
 * @apiParam {Number} id  流日志策略ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1"
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


class FlowLogController extends mController{	
	public $module = 'flog_policy';
}

