<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/host-info 获得设备系统信息
 * @apiName 获取设备系统信息
 * @apiGroup 基本信息
 *
 *
 * @apiSuccess {String} hostname  设备的host名
 * @apiSuccess {String} uptime  设备的运行时间
 * @apiSuccess {String} harddisk_stat  硬盘使用率
 * @apiSuccess {String} has_harddisk  是否有硬盘
 * @apiSuccess {String} max_session  最大连接数
 * @apiSuccess {String} login_user 登录用户名
 * @apiSuccess {String} serial_no 序列号
 * @apiSuccess {String} ips_version 入侵防御特征库时间
 * @apiSuccess {String} max_tunnel  最大隧道数
 * @apiSuccess {String} fw_version  版本号
 * @apiSuccess {String} running_mode  运行模式
 * @apiSuccess {String} sys_time  设备时间
 * @apiSuccess {String} malurl_version  malurl库时间
 * @apiSuccess {String} url_version  url分类特性库
 * @apiSuccess {String} app_version  应用特征库
 * @apiSuccess {String} av_version  病毒防护特征库
 * @apiSuccess {String} produce_date  编译时间
 * @apiSuccess {String} product_name  设备型号
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"uptime": "8 minutes", 
 *			"hostname": "host", 
 *			"harddisk_stat": "0.0/0.0/0.0", 
 *			"has_harddisk": "0", 
 *			"max_session": "750000", 
 *			"login_user": "admin", 
 *			"serial_no": "5000T-0F1CD-20009-5F389-7I76J", 
 *			"ips_version": "20170209", 
 *			"max_tunnel": "1000", 
 *			"fw_version": "ASG V3.0 DEV 20180510", 
 *			"running_mode": "", 
 *			"sys_time": "Mon Dec 31 20:50:43 2029\n", 
 *			"malurl_version": "20180201", 
 *			"url_version": "20150910", 
 *			"app_version": "20170209", 
 *			"produce_date": "May 10 2018 10:10:07", 
 *			"product_name": "PatrolFlow-AFW-2100", 
 *			"av_version": "20170223"}
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/host-info 修改设备的host名
 * @apiName 根据传入的参数修改设备host名
 * @apiGroup 基本信息
 *
 *
 * @apiParam {String} hostname  设备的host名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"hostname": "HOSTX"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *	}
 *
 */


class HostInfoController extends mController {	
	public $module = 'hostinfo';
}
