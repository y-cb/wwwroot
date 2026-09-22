<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/route-rip 查询rip基本配置
 * @apiName 查询rip基本配置
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {Number} version  版本号
 * @apiSuccess {Number} default_metric  缺省跳数
 * @apiSuccess {Number} gen_default_route  发布缺省路由
 * @apiSuccess {Number} update  RIP定时器更新时长设置
 * @apiSuccess {Number} timeout  RIP定时器超时时长设置
 * @apiSuccess {Number} garbage  RIP定时器失效时长设置
 * @apiSuccess {Number} c_rtag  路由重发布 直连路由
 * @apiSuccess {Number} c_metric_tag  路由重发布 直连路由跳数
 * @apiSuccess {Number} c_metric  路由重发布 直连路由跳数  1-15
 * @apiSuccess {Number} s_rtag  路由重发布 静态路由
 * @apiSuccess {Number} s_metric_tag  路由重发布 静态路由跳数
 * @apiSuccess {Number} s_metric  路由重发布 静态路由跳数  1-15
 * @apiSuccess {Number} o_rtag   路由重发布 OSPF路由
 * @apiSuccess {Number} o_metric_tag  路由重发布 OSPF路由跳数
 * @apiSuccess {Number} o_metric  路由重发布 OSPF路由跳数  1-15
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"version": "2",
 *			"default_metric": "1",
 *			"gen_default_route": "0",
 *			"update": "30",
 *			"timeout": "180",
 *			"garbage": "120",
 *			"c_rtag": "0",
 *			"c_metric_tag": "0",
 *			"c_metric": "0",
 *			"s_rtag": "0",
 *			"s_metric_tag": "0",
 *			"s_metric": "0",
 *			"o_rtag": "0",
 *			"o_metric_tag": "0",
 *			"o_metric": "0"
 *		}
 *	],
 *	"total": 1
 *	}
 */


/**
 * @api {PUT}  /api/route-rip 修改rip基本配置
 * @apiName 修改rip基本配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {Number} version  版本号
 * @apiParam {Number} default_metric  缺省跳数
 * @apiParam {Number} gen_default_route  发布缺省路由
 * @apiParam {Number} update  RIP定时器更新时长设置
 * @apiParam {Number} timeout  RIP定时器超时时长设置
 * @apiParam {Number} garbage  RIP定时器失效时长设置
 * @apiParam {Number} c_rtag  路由重发布,直连路由
 * @apiParam {Number} c_metric_tag  路由重发布,直连路由跳数
 * @apiParam {Number} c_metric  路由重发布,直连路由跳数, 1-15
 * @apiParam {Number} s_rtag  路由重发布,静态路由
 * @apiParam {Number} s_metric_tag  路由重发布,静态路由跳数
 * @apiParam {Number} s_metric  路由重发布,静态路由跳数, 1-15
 * @apiParam {Number} o_rtag   路由重发布,OSPF路由
 * @apiParam {Number} o_metric_tag  路由重发布,OSPF路由跳数
 * @apiParam {Number} o_metric  路由重发布,OSPF路由跳数, 1-15
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"version": "2",
 *			"default_metric": "1",
 *			"gen_default_route": "0",
 *			"update": "30",
 *			"timeout": "180",
 *			"garbage": "120",
 *			"c_rtag": "0",
 *			"c_metric_tag": "0",
 *			"c_metric": "0",
 *			"s_rtag": "0",
 *			"s_metric_tag": "0",
 *			"s_metric": "0",
 *			"o_rtag": "0",
 *			"o_metric_tag": "0",
 *			"o_metric": "0"
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
 *		"code":"12",
 *		"str":""
 *	}
 *
 */


class RouteRipController extends mController{
	public $module = 'rip';
}

?>
