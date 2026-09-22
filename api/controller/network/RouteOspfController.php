<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-ospf 获取ospf配置
 * @apiName 获取ospf配置
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} vrf_name  ospf所属vrf名称
 * @apiSuccess {String} router_id  路由器ID
 * @apiSuccess {Number} gen_default_route  缺省路由发布方式  0/不发布 1/发布 2/强制发布
 * @apiSuccess {Number} c_rtag  是否发布直连路由
 * @apiSuccess {Number} c_metric  发布直连路由权重
 * @apiSuccess {Number} s_rtag  是否发布静态路由
 * @apiSuccess {Number} s_metric  发布静态路由权重
 * @apiSuccess {Number} r_rtag  是否发布RIP路由
 * @apiSuccess {Number} r_metric  发布RIP路由权重
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [

 *		{
 *			"vrf_name": "vrf0",
 *			"router_id": "1.1.1.1",
 *			"gen_default_route": "1",
 *			"c_rtag": "0",
 *			"c_metric": "0",
 *			"s_rtag": "1",
 *			"s_metric": "10",
 *			"r_rtag": "0",
 *			"r_metric": "0"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/route-ospf 修改ospf配置
 * @apiName 修改ospf配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf所属vrf名称
 * @apiParam {String} router_id  路由器ID
 * @apiParam {Number} gen_default_route  缺省路由发布方式, 0/不发布 1/发布 2/强制发布
 * @apiParam {Number} c_rtag  是否发布直连路由
 * @apiParam {Number} c_metric  发布直连路由权重
 * @apiParam {Number} s_rtag  是否发布静态路由
 * @apiParam {Number} s_metric  发布静态路由权重
 * @apiParam {Number} r_rtag  是否发布RIP路由
 * @apiParam {Number} r_metric  发布RIP路由权重
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"router_id": "1.1.1.1",
 *		"gen_default_route": "1",
 *		"c_rtag": "0",
 *		"c_metric": "0",
 *		"s_rtag": "1",
 *		"s_metric": "10",
 *		"r_rtag": "0",
 *		"r_metric": "0"
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
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


class RouteOspfController extends mController{
	public $module = 'ospf';
}

?>
