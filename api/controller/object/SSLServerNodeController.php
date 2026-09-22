<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-server-node 显示所有服务器节点
 * @apiName 显示所有服务器节点
 * @apiGroup SSL卸载
 *
 *
 * @apiSuccess {Number} node_type ip类型
 * @apiSuccess {String} type 服务类型，默认为2
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"node_type": "1",
 *		"type": "2",
 *      }
 *      
 *      
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 3, 
		"data": [
		{
			"status": "5", 
			"ip": "172.17.150.130", 
			"ref": "1", 
			"type": "0", 
			"name": ""
		}, 
		{
			"status": "5", 
			"ip": "172.16.0.38", 
			"ref": "1", 
			"type": "0", 
			"name": ""
		}, 
		{
			"status": "5", 
			"ip": "172.16.0.39", 
			"ref": "0", 
			"type": "0", 
			"name": ""
		}
		]
 *	}
 */

/**
 * @api {POST}  /api/ssl-server-node 添加服务节点
 * @apiName 添加服务节点
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} hm_type 默认值为0
 * @apiParam {Number} least_pass_num 默认值为0
 * @apiParam {Number} ratio 默认值为1
 * @apiParam {Number} connection_limit 默认值为0
 * @apiParam {Number} node_type 节点ip类型
 * @apiParam {Number} type 服务类型 默认为1
 * @apiParam {String} name 节点别名
 * @apiParam {String} ip ip地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"hm_type": "0",
 *		"least_pass_num": "0",
 *		"ratio": "1",
 *		"connection_limit": "0",
 *		"node_type": "1",
 *		"type": "0",
 *		"ip": "2.2.2.2",
 *		"name": "test-node"
 *	}
 *
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/ssl-server-node 修改服务节点
 * @apiName 修改服务节点
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} hm_type 默认值为0
 * @apiParam {Number} least_pass_num 默认值为0
 * @apiParam {Number} ratio 默认值为1
 * @apiParam {Number} connection_limit 默认值为0
 * @apiParam {Number} node_type 节点ip类型
 * @apiParam {Number} type 服务类型 默认为1
 * @apiParam {Number} status 节点状态
 * @apiParam {String} name 节点别名
 * @apiParam {String} ip ip地址
 * @apiParam {Number} bandwidth_threshold 默认值65535
 * @apiParam {Number} low_bandwidth_threshold 默认值255
 * @apiParam {Number} downlink_bandwidth 默认值255
 * @apiParam {Number} downlink_bandwidth_threshold 默认值65535
 * @apiParam {Number} downlink_low_bandwidth_threshold 默认值255
 * @apiParam {Number} state 节点使能
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"hm_type": "0",
 *		"least_pass_num": "0",
 *		"ratio": "1",
 *		"connection_limit": "0",
 *		"node_type": "1",
 *		"type": "0",
 *		"status": "6",
 *		"ip": "2.2.2.2",
 *		"name": "test-node",
 *		"low_bandwidth_threshold": "65535",
 *		"low_bandwidth_threshold": "255",
 *		"downlink_bandwidth": "255",
 *		"downlink_bandwidth_threshold": "65535",
 *		"downlink_low_bandwidth_threshold": "255",
 *		"state": "1"
 *	}
 *
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ssl-server-node 删除服务节点
 * @apiName 删除服务节点
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {String} name 节点别名
 * @apiParam {String} ip 节点ip
 * @apiParam {Number} type 类型
 * @apiParam {Number} status 节点状态
 * @apiParam {Number} ref 节点引用计数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test-node",
 *		"ip": "2.2.2.2",
 *		"type": "0",
 *		"status": "6",
 *		"ref": "0",
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
 *		"str":"对应的错误提示信息"
 *	}
 *
 */


class SSLServerNodeController extends mController {	
	public $module = 'node';
}
