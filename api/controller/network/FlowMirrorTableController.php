<?php
namespace controller\network;
use controller\mController;


/**
 * @api {POST}   /api/flow-mirror 指定端口镜像规则的名称
 * @apiName flow-mirror
 * @apiGroup 新建端口镜像规则
 *
 *
 * @apiSuccess {String} name：端口镜像的名称
 * @apiSuccess {String} src_ifname：源端口名称
 * @apiSuccess {String} dst_ifname：镜像目的端口名称（监控接口）
 * @apiSuccess {String} direction：1 入流量，2 出流量， 3 双向流量
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "",
 *		"src_ifname": "any",
 *		"dst_ifname": "any",
 *		"direction": 1,
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

class FlowMirrorTableController extends mController{
	public $module = 'flow_mirror_table';
}


?>
