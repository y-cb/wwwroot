<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-pool-member 获取服务池成员列表
 * @apiName 获取服务池成员列表
 * @apiGroup SSL卸载
 *
 *
 * @apiSuccess {String} pool_name 服务池名字
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 2, 
		"data": [
			{
				"status": "10", 
				"pool_name": "https_2_http", 
				"ratio": "1", 
				"ip": "172.17.150.130", 
				"connection_limit": "0", 
				"connection_rate_limit": "0", 
				"priority_group": "0", 
				"type": "0", 
				"port": "80", 
				"parent_node_name": ""
			}, 
			{
				"status": "10", 
				"pool_name": "https_2_http", 
				"ratio": "65535", 
				"ip": "172.16.0.38", 
				"connection_limit": "4294967295", 
				"connection_rate_limit": "4294967295", 
				"priority_group": "255", 
				"type": "0", 
				"port": "443", 
				"parent_node_name": ""
			}
		]
 *	}
 */

/**
 * @api {POST}  /api/ssl-pool-member 添加服务池成员
 * @apiName 添加服务池成员
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} type 成员ip类型
 * @apiParam {String} pool_name 服务池名称
 * @apiParam {String} ip 成员ip地址
 * @apiParam {Number} port 成员port
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type": "0",
 *		"pool_name": "https_2_http",
 *		"ip": "21.2.2.2",
 *		"port": "60"
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
 *		"str":"对应错误的提示信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/ssl-pool-member 修改服务池成员
 * @apiName 修改服务池成员
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} type 成员ip类型
 * @apiParam {String} pool_name 服务池名称
 * @apiParam {String} ip 成员ip地址
 * @apiParam {Number} port 成员port
 * @apiParam {Number} status 成员状态
 * @apiParam {Number} ratio 默认值65535
 * @apiParam {Number} connection_limit 默认值4294967295
 * @apiParam {Number} connection_rate_limit 默认值4294967295
 * @apiParam {Number} priority_group 默认值255
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type": "0",
 *		"pool_name": "https_2_http",
 *		"ip": "21.2.2.2",
 *		"port": "60",
 *		"status": "5",
 *		"ratio": "65535",
 *		"connection_limit": "4294967295",
 *		"connection_rate_limit": "4294967295",
 *		"priority_group": "255"
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
 *		"str":"对应错误的提示信息"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ssl-pool-member 删除服务池成员
 * @apiName 删除服务池成员
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} type 成员ip类型
 * @apiParam {String} pool_name 服务池名称
 * @apiParam {String} ip 成员ip地址
 * @apiParam {Number} port 成员port
 * @apiParam {Number} status 成员状态
 * @apiParam {Number} ratio 默认值65535
 * @apiParam {Number} connection_limit 默认值4294967295
 * @apiParam {Number} connection_rate_limit 默认值4294967295
 * @apiParam {Number} priority_group 默认值255
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type": "0",
 *		"pool_name": "https_2_http",
 *		"ip": "21.2.2.2",
 *		"port": "60",
 *		"status": "13",
 *		"ratio": "65535",
 *		"connection_limit": "4294967295",
 *		"connection_rate_limit": "4294967295",
 *		"priority_group": "255"
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
 *		"str":"对应错误的提示信息"
 *	}
 *
 */


class SSLPoolMemberController extends mController {	
	public $module = 'member';
}
