<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-service-pool 获取服务池列表
 * @apiName 获取服务池列表
 * @apiGroup SSL卸载
 *
 *
 * @apiSuccess {Number} pool_type 服务池类型
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"pool_type": "1",
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
		{
			"status": "4", 
			"ref": "0", 
			"name": "https_2_http", 
			"member_count": "1"
		}
		]
 *	}
 */


/**
 * @api {POST}  /api/ssl-service-pool 创建服务池
 * @apiName 创建服务池
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {Number} pool_type 服务池类型
 * @apiParam {Number} first_algorithm 池成员选择算法，默认为0
 * @apiParam {Number} priority_group_activation 低优先级组激活，默认为0
 * @apiParam {Number} sr_wait_time 温暖上线恢复时间，默认0
 * @apiParam {Number} sr_ramp_time 温暖上线温暖时间，默认0
 * @apiParam {Number} least_pass_num 有效性要求，默认0
 * @apiParam {Number} action_on_service_down 健康检查失败动作，默认为0
 * @apiParam {String} name 服务池名
 * @apiParam {Array} user_items 服务池成员列表："id":序号 "ip":ip地址 "ip6":ipv6地址 "priority_group":优先级 默认为0 "port" 端口号,
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"pool_type": "1",
 *		"first_algorithm": "0",
 *		"priority_group_activation": "0",
 *		"sr_wait_time": "0",
 *		"sr_ramp_time": "0",
 *		"least_pass_num": "0",
 *		"action_on_service_down": "0",
 *		"name": "service-pool-test",
 *		"member": [{"id":0, "ip":"172.16.0.39", "ip6":0, "port":443, "priority_group":0}]
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


/**
 * @api {DELETE}  /api/ssl-service-pool 删除服务池信息
 * @apiName 删除服务池信息
 * @apiGroup SSL卸载
 *
 *
 * @apiParam {String} name 服务池名
 * @apiParam {Number} status 服务池状态
 * @apiParam {String} member_count 服务池成员数
 * @apiParam {Number} ref 服务池被引用计数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "service-pool-test",
 *		"status": "4",
 *		"member_count": "1",
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
 *		"str":"对应错误的提示信息"
 *	}
 *
 */


class SSLServicePoolController extends mController {	
	public $module = 'pool';
}
