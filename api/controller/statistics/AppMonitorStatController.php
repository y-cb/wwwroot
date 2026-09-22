<?php
namespace controller\statistics;
use controller\mController;
/**
 * @api {GET}  /api/app-monitor-stat 获取应用统计实时详细信息
 * @apiName 获取应用统计实时详细信息
 * @apiGroup 应用流量排行
 *
 *
 * @apiParam {Number} category 1代表应用分类流量
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"category": "",
 *	}
 *
 * @apiSuccess {Number} app_id 应用id
 * @apiSuccess {String} app_name_en 应用英文名称
 * @apiSuccess {Array} user_items 用户统计数组
 * @apiSuccess {String} app_name 应用名称对应中文
 * @apiSuccess {String} bytes_in 上行流量
 * @apiSuccess {String} bytes_out 下行流量
 * @apiSuccess {String} bytes_total 总流量
 * @apiSuccess {String} app_percent 应用百分比
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"all_total_bytes"："8066217",
 *			"app_id": "0",
 *			"app_name_en": "network-protocol",
 *			"app_name": "网络协议",
 *			"app_percent": "0.26",
 *			"bytes_in": "235.77",
            "bytes_total": "1036.98",
 *          "bytes_out": "801.21"
 *			"items": [
 *			{
 *              "user_name": "172.16.0.91",
 *              "user_group": "anonymous",
 *              "bytes_in": "235.77",
 *              "bytes_out": "801.21",
 *              "bytes_total": "1036.98"
 *          }
 *		]
 *		}
 *	}
 *
 *
 * @apiSuccess {String} cycle_period 等待间隔
 * @apiSuccess {String} retry 是否重试 1 重试  0 不重试
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"total":1,
 *		"data":[
 *                      {
 *                      "cycle_period":"2",
 *                      "retry":"1"
 *                      }
 *		]
 *	}
 *	
 */


class AppMonitorStatController extends mController {	
	public $module = 'mon_app_stat';

}
