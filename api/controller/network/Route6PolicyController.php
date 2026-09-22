<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route6-policy 查询IPv6策略路由
 * @apiName 查询IPv6策略路由
 * @apiGroup IPv6路由
 *
 *
 * @apiParam {Number} page 查询页面数
 * @apiParam {Number} pageSize 查询页面大小
 * @apiParamExample {json} Request-Example:
 *	{
 *		"page": "1"
 *		"page": "10"
 *	}
 * @apiSuccess {Number} id  路由id
 * @apiSuccess {Number} dst_id  策略优先级排序  结合move设置
 * @apiSuccess {Number} enable  启用状态
 * @apiSuccess {String} src_zone  入接口
 * @apiSuccess {String} src_addr  源地址
 * @apiSuccess {String} dst_addr  目的地址
 * @apiSuccess {String} users  用户
 * @apiSuccess {String} service  服务
 * @apiSuccess {String} apps  应用
 * @apiSuccess {String} schedule  时间
 * @apiSuccess {String} move  策略路由优先级排序
 * @apiSuccess {String} action  unicast
 * @apiSuccess {String} mp_alg  多路径选择  根据源IP或者根据连接
 * @apiSuccess {String} vrf_name  策略路由所属VRF名称
 * @apiSuccess {Array} nexthop_items  下一跳信息
 * @apiSuccess {String} nexthop_items[Array][gw] 网关IP<172.23.0.1>
 * @apiSuccess {String} nexthop_items[Array][oifname] 出接口<接口名>
 * @apiSuccess {Number} nexthop_items[Array][hits] 命中次数
 * @apiSuccess {String} nexthop_items[Array][status] 状态
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"enable": "1",
 *			"src_zone": "tunl230",
 *			"src_addr": "any",
 *			"dst_addr": "any",
 *			"users": "any",
 *			"service": "any",
 *			"apps": "any",
 *			"apps_show": "any",
 *			"schedule": "always",
 *			"action": "unicast",
 *			"mp_alg": "per-source-address",
 *			"vrf_name": "vsys0"
 *			"nexthop_items": {
 *				"group": {
 *					"oifname": "ge0\/0",
 *					"gw": "2000::2",
 *					"type": "gateway",
 *					"status": "inactive",
 *					"hits": "0"
 *				}
 *			}
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/route-policy 新建策略路由
 * @apiName 新建IPv6策略路由
 * @apiGroup IPv6路由
 *
 * @apiParam {String} mp_alg  多路径选择, 根据源IP<per-source-address>或者根据连接<per-ip-connection>
 * @apiParam {Number} enable  启用状态<0禁用/1启用>
 * @apiParam {String} src_zone  入接口
 * @apiParam {String} src_addr  源地址<地址对象>
 * @apiParam {String} dst_addr  目的地址<地址对象>
 * @apiParam {String} users  用户<用户/用户组>
 * @apiParam {String} service  服务<服务对象>
 * @apiParam {String} apps  应用<应用对象>
 * @apiParam {String} schedule  时间<时间对象>
 * @apiParam {String} gw  网关
 * @apiParam {String} oifname 出接口
 *
 * @apiParamExample {json} Request-Example:
 *		{
 *		"src_zone": "tunl230",
 *		"src_addr": "any",
 *		"dst_addr": "any",
 *		"users": "any",
 *		"service": "any",
 *		"apps": "any",
 *		"schedule": "always",
 *		"mp_alg": "per-source-address",
 *		"gw": "2000::1"
 *		"oifname": "ge0\/0"
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
 * @api {PUT}  /api/route-policy 修改IPv6策略路由
 * @apiName 修改IPv6策略路由
 * @apiGroup IPv6路由
 *
 *
 * @apiParam {Number} id  路由id
 * @apiParam {String} mp_alg  多路径选择,根据连接<per-ip-connection>
 * @apiParam {Number} enable  启用状态<0禁用/1启用>
 * @apiParam {String} src_zone  入接口
 * @apiParam {String} src_addr  源地址<地址对象>
 * @apiParam {String} dst_addr  目的地址<地址对象>
 * @apiParam {String} users  用户<用户/用户组>
 * @apiParam {String} service  服务<服务对象>
 * @apiParam {String} apps  应用<应用对象>
 * @apiParam {String} schedule  时间<时间对象>
 * @apiSuccess {String} action 动作
 * @apiParam {String} gw  网关
 * @apiParam {String} oifname 出接口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "1",
 *		"enable": "1",
 *		"src_zone": "tunl230",
 *		"src_addr": "any",
 *		"dst_addr": "any",
 *		"users": "any",
 *		"service": "any",
 *		"apps": "any",
 *		"schedule": "always",
 *		"action": "unicast",
 *		"mp_alg": "per-source-address",
 *		"gw": "2000::1"
 *		"oifname": "ge0\/0"
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
 * @api {DELETE}  /api/route-policy 删除IPv6策略路由
 * @apiName 删除IPv6策略路由
 * @apiGroup IPv6路由
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
 *		"code":"错误信息",
 *		"str":""
 *	}
 *
 */


class Route6PolicyController extends mController{
	public $module = 'route6_policy';
}

?>
