<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/flow-stat-policy 获取基于转发策略流量统计
 * @apiName 获取基于转发策略流量统计
 * @apiGroup 会话信息监控
 *
 * @apiParam {Number} protocol 地址类型，2代表所有，0代表ipv4，1代表ipv6
 * @apiParam {String} sip 源IP地址对象
 * @apiParam {String} dip 目的IP地址对象
 * @apiParam {String} sev 服务
 * @apiParam {Number} page 分页
 * @apiParam {Number} pageSize 单页面条目数量
 *
 *
 * @apiParamExample {json} Request-Example:
 *
 *	{
 *		"protocol": "1",
 *		"sip": "any",
 *		"dip": "any",
 *		"sev": "any",
 *		"page":"1",
 *		"pageSize","10"
 *	}
 *
 * @apiSuccess {Number} protocol 地址类型
 * @apiSuccess {String} sip 源IP地址对象
 * @apiSuccess {String} dip 目的IP地址对象
 * @apiSuccess {String} sev 服务
 * @apiSuccess {Number} secflow 总字节数
 * @apiSuccess {Number} flow 流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"protocol": "1",
 *			"sip": "any",
 *			"dip": "any",
 *			"sev": "any",
 *			"secflow": "100",
 *			"flow": "10"
 *		},
 *		{
 *			"protocol": "1",
 *			"sip": "测试网段",
 *			"dip": "any",
 *			"sev": "any",
 *			"secflow": "720",
 *			"flow": "10"
 *		}
 *	],
 *	"total": 2
 *	}
 */

class FlowStatPolicyController extends mController{
	public $module = 'flow_stat_policy';
}

