<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/cloud-agent-flow 获取云平台流量统计信息
 * @apiName 获取云平台流量统计信息信息
 * @apiGroup 云平台
 *
 *
 * @apiSuccess {Number} enable  是否开启流量统计信息信息，1表示开启，0表示关闭
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"enable": "1",
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/cloud-agent-flow 修改云平台流量统计信息
 * @apiName 修改云平台流量统计信息
 * @apiGroup 云平台
 *
 *
 * @apiParam {Number} enable  云平台流量统计启用状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */


class CloudAgentFlowController extends mController {	
	public $module = 'flow_acct';
}