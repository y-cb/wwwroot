<?php
namespace controller\statistics;
use controller\mController;
use database\AppflowDb;
/**
 * @api {GET}  /api/app-monitor 获取应用统计详细信息
 * @apiName app-monitor
 * @apiGroup 应用分类流量统计
 *
 *
 * @apiParam {Number} range 1代表最近1小时，2代表最近1天，3代表最近1周
 * @apiParam {String} direct “up”代表上行，“down”代表下行，“total”代表双向，“all”代表前三种
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"top_n": "1",
 *		"direct": "all"
 *	}
 *
 * @apiSuccess {Number} all_total_bytes 流量总数
 * @apiSuccess {Array} items 应用统计数组
 * @apiSuccess {String} name 应用名称
 * @apiSuccess {String} name_cn 应用名称对应中文
 * @apiSuccess {String} up_bytes 上行流量
 * @apiSuccess {String} down_bytes 下行流量
 * @apiSuccess {String} total_bytes 总流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"all_total_bytes"："8066217",
 *			"items": [
 *			{
 *              "name": "http",
 *              "name_cn": "HTTP-网页浏览",
 *              "up_bytes": "743538",
 *              "down_bytes": "6611716",
 *              "total_bytes": "7355254"
 *          }, 
 *			{
 *              "name": "dns",
 *              "name_cn": "DNS",
 *              "up_bytes": "34537",
 *              "down_bytes": "44674",
 *              "total_bytes": "79211"
 *          },
 *			{
 *              "name": "tcp",
 *              "name_cn": "TCP",
 *              "up_bytes": "12394",
 *              "down_bytes": "5320",
 *              "total_bytes": "17714"
 *          }
 *		]
 *		}
 *	}
 */


class AppMonitorXmlController extends mController {	
	public $module = 'monitor_apps';
}
