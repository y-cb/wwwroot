<?php
namespace controller\policy;
use controller\mController;

 /**
 * @api {GET}  /api/coo_def_cloud 获取云端威胁情报配置
 * @apiName coo_def_cloud
 * @apiGroup 威胁情报
 *
 *
 * @apiSuccess {String} server 云端情报URL（字符数1-256）
 * @apiSuccess {Number} enable 是否开启云端联动（0代表关闭，1代表开启）
 * @apiSuccess {Number} auto_update 定期升级（0代表关闭，10-14400代表开启且定时为XX分钟）
 * @apiSuccess {Number} update_license_day 威胁情报许可（1代表有许可，0代表无许可）
 * @apiSuccess {String} ioc_lib_version 情报版本（回显内容）
 * @apiSuccess {String} ioc_agent_lib_version 代理agent情报版本（回显内容）
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *	{
 *		"server": "https:\/\/tip.sec-inside.com",
 *		"enable": "1",
 *		"auto_update": "60",
 *		"update_license_day": "1",
 *		"ioc_lib_version": "20220222.1348",
 *		"ioc_agent_lib_version": "20220222.1348",
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
 *		"str":""
 *		"str":""
 *	}
 */
 /**
 * @api {PUT}  /api/coo_def_cloud 获取云端威胁情报配置
 * @apiName coo_def_cloud
 * @apiGroup 获取云端威胁情报配置
 * @apiParam {String} server 云端情报URL（字符数1-256）
 * @apiParam {Number} enable 是否开启云端联动（0代表关闭，1代表开启）
 * @apiParam {Number} auto_update 定期升级（0代表关闭，10-14400代表开启且定时为XX分钟）
 * @apiParam {Number} update_license_day 威胁情报许可（1代表有许可，0代表无许可）
 * @apiParam {String} ioc_lib_version 情报版本（回显内容）
 * @apiParam {String} ioc_agent_lib_version 代理agent情报版本（回显内容）
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *	{
 *		"server": "https:\/\/tip.sec-inside.com",
 *		"enable": "1",
 *		"auto_update": "60",
 *		"update_license_day": "1",
 *		"ioc_lib_version": "20220222.1348",
 *		"ioc_agent_lib_version": "20220222.1348",
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
 *		"str":""
 *	}
 *
 */
 
class CooDefCloudController extends mController{
    public $module = 'coo_def_cloud';
}

