<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/syslog-server 获取日志服务器配置
 * @apiName syslog-server
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {Number} syslog_csv 日志服务器启用状态
 * @apiSuccess {String} syslog_location 服务器1地址
 * @apiSuccess {Number} syslog_port 服务器1端口
 * @apiSuccess {String} syslog_sec_location 服务器2地址
 * @apiSuccess {Number} syslog_sec_port 服务器2端口
 * @apiSuccess {String} syslog_thi_location 服务器3地址
 * @apiSuccess {Number} syslog_thi_port 服务器3端口
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"syslog_csv": "1"，,
 *			"syslog_location": "172.16.0.91",
 *			"syslog_port": "514",
 *			"syslog_sec_location": "172.16.0.92",
 *			"syslog_sec_port": "514",
 *			"syslog_thi_location": "172.16.0.93",
 *			"syslog_thi_port": "514"
 *		}
 *	}
 */

/**
 * @api {POST}  /api/syslog-server 添加日志服务器配置
 * @apiName syslog-server
 * @apiGroup 日志设定
 *
 *
 * @apiParam {Number} syslog_csv 日志服务器启用状态
 * @apiParam {String} syslog_location 服务器1地址
 * @apiParam {Number} syslog_port 服务器1端口
 * @apiParam {String} syslog_sec_location 服务器2地址
 * @apiParam {Number} syslog_sec_port 服务器2端口
 * @apiParam {String} syslog_thi_location 服务器3地址
 * @apiParam {Number} syslog_thi_port 服务器3端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"syslog_csv": "1",
 *		"syslog_location": "172.16.0.91",
 *		"syslog_port": "514",
 *		"syslog_sec_location": "172.16.0.92",
 *		"syslog_sec_port": "514",
 *		"syslog_thi_location": "172.16.0.93",
 *		"syslog_thi_port": "514"
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

/**
 * @api {PUT}  /api/syslog-server 修改日志服务器配置
 * @apiName syslog-server
 * @apiGroup 日志设定
 *
 *
 * @apiParam {Number} syslog_csv 日志服务器启用状态
 * @apiParam {String} syslog_location 服务器1地址
 * @apiParam {Number} syslog_port 服务器1端口
 * @apiParam {String} syslog_sec_location 服务器2地址
 * @apiParam {Number} syslog_sec_port 服务器2端口
 * @apiParam {String} syslog_thi_location 服务器3址
 * @apiParam {Number} syslog_thi_port 服务器3端口
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"syslog_csv": "1",
 *		"syslog_location": "172.16.0.91",
 *		"syslog_port": "514",
 *		"syslog_sec_location": "172.16.0.92",
 *		"syslog_sec_port": "514",
 *		"syslog_thi_location": "172.16.0.93",
 *		"syslog_thi_port": "514"
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

class SyslogServerController extends mController{	
	public $module = 'syslog';
}

