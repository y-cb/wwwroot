<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/user-monitor-trend 概况页面获取用户流量统计
 * @apiName 概况页面获取用户流量统计
 * @apiGroup 用户流量统计
 *
 *
 * @apiSuccess {Number} range 范围
 * @apiSuccess {String} direct 流量方向
 * @apiSuccess {String} user_name 用户名
 * @apiSuccess {Number} is_user 是否为用户
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"range":1,
		"direct":"all",
		"user_name":"172.16.0.211",
		"is_user":0,
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
    "0": {
    "name": "udp",
        "name_cn": "UDP",
        "up_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,",
        "down_bytes": "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,",
        "total_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,"
    },
    "group": [
        {
            "name": "udp",
            "name_cn": "UDP",
            "up_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,",
            "down_bytes": "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,",
            "total_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,"
        }
    ]
 *	}
 *
 * @apiSuccess {String} cycle_period 等待间隔
 * @apiSuccess {String} retry 是否重试 1 重试  0 不重试
 * @apiErrorExample {json} Error-Response:
 *          HTTP/1.1 200 OK
 *            {
 *                    "total":1,
 *                     "data":[
 *                              {
 *                               "cycle_period":"2",
 *                                "retry":"1"
 *                                 }
 *                          ]
 *                   }
 *              
 */


class UserMonitorTrendController extends mController {	
	public $module = 'mon_user_stat';
}
