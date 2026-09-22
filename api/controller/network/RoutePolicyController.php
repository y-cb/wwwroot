<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-policy 查询IPv4策略路由
 * @apiName 查询IPv4策略路由
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
 * @apiSuccess {String} src_zone  入接口
 * @apiSuccess {String} src_addr  源地址<地址对象>
 * @apiSuccess {String} dst_addr  目的地址<目的地址对象>
 * @apiSuccess {String} users  用户<用户/用户组>
 * @apiSuccess {String} service  服务<服务对象>
 * @apiSuccess {String} apps  应用<应用对象>
 * @apiSuccess {String} schedule  时间<时间对象>
 * @apiSuccess {String} mp_alg  多路径选择，根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiSuccess {String} vrf_name  策略路由所属VRF名称<vsys0>
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
 *		"src_zone": "ge0\/0",
 *		"src_addr": "any",
 *		"dst_addr": "any",
 *		"users": "any",
 *		"service": "any",
 *		"apps": "any",
 *		"apps_show": "any",
 *		"schedule": "always",
 *		"action": "unicast",
 *		"mp_alg": "per-ip-connection",
 *		"nexthop_items": {
 *			"group": [{
 *				"oifname": "ge0\/0",
 *				"gw": "172.23.0.1",
 *				"type": "gateway",
 *				"monitor": "",
 *				"weight": "3",
 *				"hits": "0",
 *				"status": "active"
 *			}, {
 *				"oifname": "tunl0",
 *				"type": "out_if",
 *				"monitor": "",
 *				"weight": "33",
 *				"hits": "0",
 *				"status": "active"
 *			}]
 *		}
 *	}],
 *	"total": 1
 *}
 */

/**
 * @api {POST}  /api/route-policy 新建IPv4策略路由
 * @apiName 新建IPv4策略路由
 * @apiGroup IPv4路由
 *
 * @apiParam {String} mp_alg  多路径选择, 根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiParam {Array} nexthop_items  下一跳信息
 * @apiParam {String} nexthop_items[Array][type] 网关<gateway>或出接口<out_if>
 * @apiParam {String} nexthop_items[Array][gw] 网关IP<172.23.0.1>
 * @apiParam {String} nexthop_items[Array][oifname] 出接口<接口名>
 * @apiParam {String} nexthop_items[Array][monitor] 健康检查<健康检查名称/健康检查组名称>
 * @apiParam {String} nexthop_items[Array][weight] 权重<1-255>
 * @apiParam {Number} enable  启用状态<0禁用/1启用>
 * @apiParam {String} src_zone  入接口
 * @apiParam {String} src_addr  源地址<地址对象>
 * @apiParam {String} dst_addr  目的地址<地址对象>
 * @apiParam {String} users  用户<用户/用户组>
 * @apiParam {String} service  服务<服务对象>
 * @apiParam {String} apps  应用<应用对象>
 * @apiParam {String} schedule  时间<时间对象>
 *
 * @apiParamExample {json} Request-Example:
 *		{
 *		"mp_alg": "per-source-address",
 *	 	"nexthop_items": {
 *			"group": {
 *				"oifname": "ge0\/0",
 *				"gw": "172.23.0.1",
 *				"type": "gateway",
 *				"monitor": "",
 *				"weight": "3",
 *			}
 *		}
 *		"enable": "1",
 *		"src_zone": "tunl230",
 *		"src_addr": "any",
 *		"dst_addr": "any",
 *		"users": "any",
 *		"service": "any",
 *		"apps": "any",
 *		"schedule": "always",
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
 * @api {PUT}  /api/route-policy 修改IPv4策略路由
 * @apiName 修改IPv4策略路由
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} id  策略路由id
 * @apiParam {String} mp_alg  多路径选择, 根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiParam {Array} nexthop_items  下一跳信息
 * @apiParam {String} nexthop_items[Array][type] 网关<gateway>或出接口<out_if>
 * @apiParam {String} nexthop_items[Array][gw] 网关IP<172.23.0.1>
 * @apiParam {String} nexthop_items[Array][oifname] 出接口<接口名>
 * @apiParam {String} nexthop_items[Array][monitor] 健康检查<健康检查名称/健康检查组名称>
 * @apiParam {String} nexthop_items[Array][weight] 权重<1-255>
 * @apiParam {Number} enable  启用状态<0禁用/1启用>
 * @apiParam {String} src_zone  入接口
 * @apiParam {String} src_addr  源地址<地址对象>
 * @apiParam {String} dst_addr  目的地址<地址对象>
 * @apiParam {String} users  用户<用户/用户组>
 * @apiParam {String} service  服务<服务对象>
 * @apiParam {String} apps  应用<应用对象>
 * @apiParam {String} schedule  时间<时间对象>
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"enable": "1",
 *		"src_zone": "ge0/0",
 *		"src_addr": "any",
 *		"dst_addr": "any",
 *		"users": "any",
 *		"service": "any",
 *		"apps": "any",
 *		"schedule": "always",
 *		"mp_alg": "per-source-address",
 *		"nexthop_items": {
 *			"group": [{
 *				"oifname": "ge0\/0",
 *				"gw": "172.23.0.1",
 *				"type": "gateway",
 *				"monitor": "",
 *				"weight": "3",
 *			}, {
 *				"oifname": "tunl0",
 *				"type": "out_if",
 *				"monitor": "",
 *				"weight": "33",
 *			}]
 *		}
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
 * @api {DELETE}  /api/route-policy 删除策略路由
 * @apiName 删除策略路由
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} id  路由id
 * @apiParam {String} vrf_name  策略路由所属VRF名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"vrf_name": "vrf0"
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


class RoutePolicyController extends mController{
	public $module = 'route_policy';
}

?>
