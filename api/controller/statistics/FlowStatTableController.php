<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/flow-stat-table 获取基于IP/端口流量统计
 * @apiName 获取基于IP/端口流量统计
 * @apiGroup 会话信息监控
 *
 * @apiParam {Number} stat_type 统计类型，0代表主机统计，代表目的端口统计
 * @apiParam {Number} iptype 地址类型，2代表所有，0代表ipv4，1代表ipv6
 * @apiParam {String} ip_addr IP地址
 * @apiParam {Number} page 分页
 * @apiParam {Number} pageSize 每页显示数量
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"stat_type": "0",
 *		"iptype": "0",
 *		"ip_addr": "",
 *		"page":"1",
 *		"pageSize":"10"
 *
 *	}
 *
 * @apiSuccess {Number} stat_type 统计类型
 * @apiSuccess {Number} iptype 地址类型
 * @apiSuccess {String} ip_addr IP地址
 * @apiSuccess {Number} tcp_in TCP入
 * @apiSuccess {Number} tcp_out TCP出
 * @apiSuccess {Number} udp_in UDP入
 * @apiSuccess {Number} udp_out UDP出
 * @apiSuccess {Number} others_in 其他入
 * @apiSuccess {Number} others_out 其他出
 * @apiSuccess {Number} total 总流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"stat_type": "0",
 *			"iptype": "0",
 *			"ip_addr": "172.16.0.123",
 *			"tcp_in": "3340365.22",
 *			"tcp_out": "477358.69",
 *			"udp_in": "0.46",
 *			"udp_out": "0.96",
 *			"others_in": "0.00",
 *			"others_out": "1707.54",
 *			"total": "3819432.87"
 *		},
 *		{
 *			"stat_type": "0",
 *			"iptype": "0",
 *			"ip_addr": "172.19.0.122",
 *			"tcp_in": "3058572.4",
 *			"tcp_out": "66409.07",
 *			"udp_in": "0.00",
 *			"udp_out": "0.00",
 *			"others_in": "0.00",
 *			"others_out": "0.00",
 *			"total": "3124981.50"
 *		}
 *	],
 *	"total": 2
 *	}
 *
 * @apiParam {Number} stat_type 统计类型，0代表主机统计，代表目的端口统计
 * @apiSuccess {Number} iptype 地址类型
 * @apiSuccess {String} ip_addr IP地址
 * @apiSuccess {Number} port_min 端口最小值
 * @apiSuccess {Number} port_max 端口最大值
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *
 *		"stat_type": "1",
 *		"iptype": "2",
 *		"ip_addr": "",
 *		"port_min": "10",
 *		"port_max": "65535",
 *		"page":"1",
 *		"pageSize":"10"
 *	}
 *
 * @apiSuccess {Number} stat_type 统计类型
 * @apiSuccess {Number} port 端口
 * @apiSuccess {Number} tcp_in TCP入
 * @apiSuccess {Number} tcp_out TCP出
 * @apiSuccess {Number} udp_in UDP入
 * @apiSuccess {Number} udp_out UDP出
 * @apiSuccess {Number} others_in 其他入
 * @apiSuccess {Number} others_out 其他出
 * @apiSuccess {Number} total 总流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"stat_type": "1",
 *			"port": "80",
 *			"tcp_in": "3477899.40",
 *			"tcp_out": "94695.47",
 *			"udp_in": "0.04",
 *			"udp_out": "0.05",
 *			"others_in": "0.00",
 *			"others_out": "0.00",
 *			"total": "3572594.96"
 *		},
 *		{
 *			"stat_type": "1",
 *			"port": "445",
 *			"tcp_in": "1291823.39",
 *			"tcp_out": "782492.88",
 *			"udp_in": "0.00",
 *			"udp_out": "0.00",
 *			"others_in": "0.00",
 *			"others_out": "0.00",
 *			"total": "2074316.2"
 *		}
 *	],
 *	"total": 2
 *	}
 */

class FlowStatTableController extends mController{
	public $module = 'flow_stat_table';
}
