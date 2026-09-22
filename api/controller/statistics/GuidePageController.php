<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {get}  /api/guide-page 获取向导配置项
 * @apiName 获取向导配置项
 * @apiGroup 首页
 *
 *
 * @apiSuccess {Number} sys_basic_info 基本信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} traffic_info 实时流量信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} sys_info 系统信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} license_info 授权信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} user_info 用户流量排名显示，0表示不启用，1表示启用
 * @apiSuccess {Number} admin_info 在线管理员显示，0表示不启用，1表示启用
 * @apiSuccess {Number} app_info 应用流量排行显示，0表示不启用，1表示启用
 * @apiSuccess {Number} syslog_info 系统日志显示，0表示不启用，1表示启用
 * @apiSuccess {Number} appcate_info 应用分类显示，0表示不启用，1表示启用
 * @apiSuccess {Number} seclog_info 安全日志显示，0表示不启用，1表示启用
 * @apiSuccess {Number} ips_info 攻击事件统计显示，0表示不启用，1表示启用
 * @apiSuccess {Number} av_info 病毒事件统计显示，0表示不启用，1表示启用
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "sys_basic_info": "1",
            "traffic_info": "1",
            "sys_info": "1",
            "license_info": "1",
            "user_info": "1",
            "admin_info": "1",
            "app_info": "1",
            "appcate_info": "1",
            "syslog_info": "1",
            "seclog_info": "0",
			"ips_info": "0",
            "av_info": "0",
        }
    ],
    }
 */

/**
 * @api {PUT}  /api/dashboard 修改首页显示配置项
 * @apiName 修改首页显示配置项
 * @apiGroup 首页
 *
 *
 * @apiParam {Number} sys_basic_info 基本信息显示，0表示不启用，1表示启用
 * @apiParam {Number} traffic_info 实时流量信息显示，0表示不启用，1表示启用
 * @apiParam {Number} sys_info 系统信息显示，0表示不启用，1表示启用
 * @apiParam {Number} license_info 授权信息显示，0表示不启用，1表示启用
 * @apiParam {Number} user_info 用户流量排名显示，0表示不启用，1表示启用
 * @apiParam {Number} admin_info 在线管理员显示，0表示不启用，1表示启用
 * @apiParam {Number} app_info 应用流量排行显示，0表示不启用，1表示启用
 * @apiParam {Number} syslog_info 系统日志显示，0表示不启用，1表示启用
 * @apiParam {Number} appcate_info 应用分类显示，0表示不启用，1表示启用
 * @apiParam {Number} seclog_info 安全日志显示，0表示不启用，1表示启用
 * @apiParam {Number} ips_info 攻击事件统计显示，0表示不启用，1表示启用
 * @apiParam {Number} av_info 病毒事件统计显示，0表示不启用，1表示启用
 *
 */

class GuidePageController extends mController {	
	public $module = 'nav_page';
}
