<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/update-log 获取固件版本升级历史记录
 * @apiName update-log
 * @apiGroup 系统设置
 *
 *
 * @apiSuccess {String} version 固件版本版本名称
 * @apiSuccess {String} up_time 固件版本升级时间
 * @apiSuccess {Number} flag 升级类型：固定为4，代表软件升级
 * @apiSuccess {Number} result 升级结果：成功或失败
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"version": "ASG-V3.0_DEV-20180504.bin",
 *			"up_time": "May  7 10:33:22",
 *			"flag": "4",
 *			"result": "成功"
 *		},
 *		{
 *			"version": "ASG-V1.1-R2.2SP-20180424.bin",
 *			"up_time": "Apr 24 12:02:49",
 *			"flag": "4",
 *			"result": "成功"
 *		}
 *	],
 *	"total": 2
 *	}
 */

class UpdateLogController extends mController{	
	public $module = 'ips_version';
}

