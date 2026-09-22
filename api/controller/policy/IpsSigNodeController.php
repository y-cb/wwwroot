<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {POST}  /api/ips-sig-node 将预定义事件集添加入侵防护事件集
 * @apiName ips-sig-node
 * @apiGroup 预定义事件集添加入侵防护事件集
 *
 *
 * @apiParam {String} mode_name 事件集名称
 * @apiParam {Number} mode 添加模式，固定为3
 * @apiParam {String} set_name 入侵防护事件集名称
 * @apiParam {Array} member 成员
 * @apiParam {Number} id 添加成员序列号，从0开始
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"set_name": "test",
 *		"mode": "3",
 *		"member": [
 *			{
 *				"id": "0",
 *				"mode_name": "BufferOverflow"
 *			},
 *			{
 *				"id": "1",
 *				"mode_name": "DoS"
 *			}
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

class IpsSigNodeController extends mController {
	public $module = 'ips_sig_node';
}

?>
