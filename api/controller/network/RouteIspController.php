<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-isp 查询ISP路由
 * @apiName 查询ISP路由
 * @apiGroup IPv4路由
 *
 * @apiParam {Number} page 查询页面数
 * @apiParam {Number} pageSize 查询页面大小
 * @apiParamExample {json} Request-Example:
 *	{
 *		"page": "1"
 *		"page": "10"
 *	}
 *
 * @apiSuccess {Number} id  路由id(回显)
 * @apiSuccess {Number} enable  启用状态<1启用/0禁用>
 * @apiSuccess {String} dst_addr  ISP地址库
 * @apiSuccess {String} mp_alg  多路径选择，根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiSuccess {String} vrf_name  策略路由所属VRF名称（vsys0）
 * @apiSuccess {String} action 动作
 * @apiSuccess {Array} nexthop_items  下一跳信息
 * @apiSuccess {String} nexthop_items[Array][type] 网关<gateway>或出接口<out_if>
 * @apiSuccess {String} nexthop_items[Array][gw] 网关IP<172.23.0.1>
 * @apiSuccess {String} nexthop_items[Array][oifname] 出接口<接口名>
 * @apiSuccess {String} nexthop_items[Array][monitor] 健康检查<健康检查名称/健康检查组名称>
 * @apiSuccess {String} nexthop_items[Array][weight] 权重<1-255>
 * @apiSuccess {Number} nexthop_items[Array][hits] 命中次数
 * @apiSuccess {String} nexthop_items[Array][status] 状态
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *{
 *	"data": [{
 *		"vrf_name": "vsys0",
 *		"id": "1",
 *		"enable": "0",
 *		"dst_addr": "ISP_CT.dat",
 *		"action": "unicast",
 *		"mp_alg": "per-source-address",
 *		"bingo": "0",
 *		"nexthop_items": {
 *			"group": {
 *				"oifname": "ge0\/0",
 *				"gw": "172.23.0.1",
 *				"type": "gateway",
 *				"monitor": "",
 *				"weight": "1",
 *				"hits": "0",
 *				"status": "active"
 *			}
 *		}
 *	}, {
 *		"vrf_name": "vsys0",
 *		"id": "2",
 *		"enable": "0",
 *		"dst_addr": "ISP_CERNET.dat",
 *		"action": "unicast",
 *		"mp_alg": "per-source-address",
 *		"bingo": "0",
 *		"nexthop_items": {
 *			"group": {
 *				"oifname": "tunl0",
 *				"type": "out_if",
 *				"monitor": "",
 *				"weight": "3",
 *				"hits": "0",
 *				"status": "active"
 *			}
 *		}
 *	}],
 *	"total": 2
 *}
 */

/**
 * @api {POST}  /api/route-isp 新建ISP路由
 * @apiName 新建ISP路由
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} enable  启用状态<0禁用/1启用>
 * @apiParam {String} dst_addr  ISP地址库
 * @apiParam {String} mp_alg  多路径选择，根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiParam {Array} nexthop_items  下一跳信息
 * @apiParam {String} nexthop_items[Array][type] 网关<gateway>或出接口<out_if>
 * @apiParam {String} nexthop_items[Array][gw] 网关IP<172.23.0.1>
 * @apiParam {String} nexthop_items[Array][oifname] 出接口<接口名>
 * @apiParam {String} nexthop_items[Array][monitor] 健康检查<健康检查名称/健康检查组名称>
 * @apiParam {String} nexthop_items[Array][weight] 权重<1-255>
 * @apiParamExample {json} Request-Example:
 *		{
 *		"enable": "1",
 *		"dst_addr": "ISP_CERNET.dat",
 *		"mp_alg": "per-source-address",
 *	 	"nexthop_items": {
 *			"group": {
 *				"oifname": "ge0\/0",
 *				"gw": "172.23.0.1",
 *				"type": "gateway",
 *				"monitor": "",
 *				"weight": "3",
 *				}
 *			}
 *		}
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
 *		"str":"错误信息"
 *	}
 *
 */

/**
 * @api {PUT}  /api/route-isp 修改ISP路由
 * @apiName 修改ISP路由
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} id  路由id
 * @apiParam {Number} enable  启用状态<0禁用/1启用>
 * @apiParam {String} dst_addr  ISP地址库
 * @apiSuccess {String} action 动作
 * @apiParam {String} mp_alg  多路径选择，根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiParam {Array} nexthop_items  下一跳信息
 * @apiParam {String} nexthop_items[Array][type] 网关<gateway>或出接口<out_if>
 * @apiParam {String} nexthop_items[Array][gw] 网关IP<172.23.0.1>
 * @apiParam {String} nexthop_items[Array][oifname] 出接口<接口名>
 * @apiParam {String} nexthop_items[Array][monitor] 健康检查<健康检查名称/健康检查组名称>
 * @apiParam {String} nexthop_items[Array][weight] 权重<1-255>
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"enable": "1",
 *		"dst_addr": "any",
 *		"action": "unicast",
 *		"mp_alg": "per-source-address",
 *	 	"nexthop_items": {
 *			"group": {
 *				"oifname": "ge0\/0",
 *				"gw": "172.23.0.1",
 *				"type": "gateway",
 *				"monitor": "",
 *				"weight": "3",
 *				}
 *			}
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
 *		"str":"错误信息"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/route-policy 删除ISP路由
 * @apiName 删除ISP路由
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} id  路由id
 * @apiParam {String} vrf_name  策略路由所属VRF名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"vrf_name": "vsys0"
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
 *		"str":"错误信息"
 *	}
 *
 */


class RouteIspController extends mController{
	public $module = 'isp_route_policy';
}

?>
