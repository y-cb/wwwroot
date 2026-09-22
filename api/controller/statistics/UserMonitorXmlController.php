<?php
namespace controller\statistics;
use controller\mController;
use database\AppflowDb;

/**
 * @api {GET}  /api/user-monitor 获取所有用户流量统计
 * @apiName 获取所有用户流量统计
 * @apiGroup 用户流量统计
 *
 *
 * @apiSuccess {Number} page 当前页
 * @apiSuccess {Number} count 每页数量
 * @apiSuccess {Number} range 范围
 * @apiSuccess {String} direct 流量方向
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"page": 1,
		"count":20,
		"range":1,
		"direct":all
 *	}
 *
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
			{
				"items": {"group": [{"total_bytes": "376128", "down_bytes": "0", "name": "172.17.0.254", "up_bytes": "376128"}, {"total_bytes": "251136", "down_bytes": "0", "name": "172.17.0.253", "up_bytes": "251136"}, {"total_bytes": "1190", "down_bytes": "0", "name": "172.17.60.199", "up_bytes": "1190"}, {"total_bytes": "1180", "down_bytes": "0", "name": "172.17.150.111", "up_bytes": "1180"}, {"total_bytes": "984", "down_bytes": "0", "name": "172.17.200.25", "up_bytes": "984"}, {"total_bytes": "799", "down_bytes": "0", "name": "172.17.200.70", "up_bytes": "799"}, {"total_bytes": "672", "down_bytes": "0", "name": "172.17.200.137", "up_bytes": "672"}, {"total_bytes": "656", "down_bytes": "0", "name": "172.17.200.81", "up_bytes": "656"}, {"total_bytes": "656", "down_bytes": "0", "name": "172.17.200.126", "up_bytes": "656"}, {"total_bytes": "468", "down_bytes": "0", "name": "172.17.70.12", "up_bytes": "468"}, {"total_bytes": "468", "down_bytes": "0", "name": "172.17.50.100", "up_bytes": "468"}, {"total_bytes": "336", "down_bytes": "0", "name": "172.17.200.142", "up_bytes": "336"}, {"total_bytes": "328", "down_bytes": "0", "name": "172.17.200.208", "up_bytes": "328"}, {"total_bytes": "328", "down_bytes": "0", "name": "172.17.200.127", "up_bytes": "328"}, {"total_bytes": "328", "down_bytes": "0", "name": "172.17.200.104", "up_bytes": "328"}]}, 
				"all_total_bytes": "1144040"
			}
			]
 *	}
 */


class UserMonitorXmlController extends mController {	
	public $module = 'monitor_users';
}
