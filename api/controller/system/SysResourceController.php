<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/sys-resource 获取信息监控配置
 * @apiName 获取信息监控配置
 * @apiGroup 系统维护
 *
 * @apiSuccess {Number} cpu_usage_num                      CPU使用率告警阈值
 * @apiSuccess {Number} cpu_usage_memory_enable            CPU使用率告警本地日志开关
 * @apiSuccess {Number} cpu_usage_syslog_enable            CPU使用率告警Syslog日志开关
 * @apiSuccess {Number} cpu_usage_email_enable             CPU使用率告警Email告警开关
 * @apiSuccess {Number} mem_usage_num          内存占用率告警阈值
 * @apiSuccess {Number} mem_usage_memory_enable 内存占用率告警本地日志开关
 * @apiSuccess {Number} mem_usage_syslog_enable 内存占用率告警Syslog日志开关
 * @apiSuccess {Number} mem_usage_email_enable  内存占用率告警Email告警开关
 * @apiSuccess {Number} net_usage_num      保留字段，暂不使用 
 * @apiSuccess {Number} net_usage_memory_enable 保留字段，暂不使用
 * @apiSuccess {Number} net_usage_syslog_enable 保留字段，暂不使用
 * @apiSuccess {Number} net_usage_email_enable  保留字段，暂不使用
 * @apiSuccess {Number} net_interupt_memory_enable 保留字段，暂不使用
 * @apiSuccess {Number} net_interupt_syslog_enable 保留字段，暂不使用
 * @apiSuccess {Number} net_interupt_email_enable 保留字段，暂不使用
 * @apiSuccess {Number} interface_stat_memory_enable 保留字段，暂不使用
 * @apiSuccess {Number} interface_stat_syslog_enable 保留字段，暂不使用
 * @apiSuccess {Number} interface_stat_email_enable 保留字段，暂不使用
 * @apiSuccess {Number} inf_flow_memory_enable 保留字段，暂不使用
 * @apiSuccess {Number} inf_flow_syslog_enable 保留字段，暂不使用
 * @apiSuccess {Number} inf_flow_email_enable 保留字段，暂不使用
 * @apiSuccess {Number} inf_name_num 保留字段，暂不使用
 * @apiSuccess {String} inf_name 保留字段，暂不使用
 * @apiSuccess {String} monitor_templet 保留字段，暂不使用
 * @apiSuccess {Number} mon_flow_num   流量大小告警阈值 
 * @apiSuccess {Number} flow_memory_enable 流量超限本地日志开关
 * @apiSuccess {Number} flow_syslog_enable  流量超限Syslog日志开关
 * @apiSuccess {Number} flow_email_enable   流量超限Email开关
 * @apiSuccess {Number} mon_session_num     连接数告警阈值
 * @apiSuccess {Number} session_memory_enable  连接超限告警本地日志开关
 * @apiSuccess {Number} session_syslog_enable  连接超限告警Syslog日志开关
 * @apiSuccess {Number} session_email_enable   连接超限Email报警开关
 * @apiSuccess {Number} mon_packet_len         报文超长阈值
 * @apiSuccess {Number} packet_memory_enable   报文长度超限本地日志告警开关
 * @apiSuccess {Number} packet_syslog_enable   报文长度超限Syslog日志开关
 * @apiSuccess {Number} packet_email_enable    报文长度超限Email告警开关
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"net_interupt_email_enable": "0",
 *			"net_usage_memory_enable": "0",
 *			"packet_email_enable": "0",
 *			"packet_memory_enable": "0",
 *			"session_syslog_enable": "0",
 *			"mem_usage_memory_enable": "0",
 *			"net_usage_email_enable": "0",
 *			"inf_name_num": "10240",
 *			"mon_packet_len": "0",
 *			"net_interupt_memory_enable": "0",
 *          "mem_usage_syslog_enable": "0",
 *          "mem_usage_num": "90",
 *          "net_usage_num": "10000",
 *          "inf_flow_syslog_enable": "0",
 *          "monitor_templet": "",
 *			"cpu_usage_num": "90",
 *			"inf_flow_email_enable": "0",
 *			"net_interupt_syslog_enable": "0",
 *			"session_email_enable": "0",
 *			"inf_flow_memory_enable": "0",
 *			"cpu_usage_syslog_enable": "0",
 *			"cpu_usage_memory_enable": "0",
 *			"net_usage_syslog_enable": "0",
 *			"session_memory_enable": "0",
 *			"mon_session_num": "0",
 *			"mem_usage_email_enable": "0",
 *			"flow_email_enable": "0",
 *			"mon_flow_num": "0",
 *			"packet_syslog_enable": "0",
 *			"flow_memory_enable": "0",
 *			"flow_syslog_enable": "0"
 *		}
 *	]
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/sys-resource 修改信息监控配置
 * @apiName 修改信息监控配置
 * @apiGroup 系统维护
 *
 * @apiSuccess {Number} cpu_usage_num                      CPU使用率告警阈值
 * @apiSuccess {Number} cpu_usage_memory_enable            CPU使用率告警本地日志开关
 * @apiSuccess {Number} cpu_usage_syslog_enable            CPU使用率告警Syslog日志开关
 * @apiSuccess {Number} cpu_usage_email_enable             CPU使用率告警Email告警开关
 * @apiSuccess {Number} mem_usage_num          内存占用率告警阈值
 * @apiSuccess {Number} mem_usage_memory_enable 内存占用率告警本地日志开关
 * @apiSuccess {Number} mem_usage_syslog_enable 内存占用率告警Syslog日志开关
 * @apiSuccess {Number} mem_usage_email_enable  内存占用率告警Email告警开关
 * @apiSuccess {Number} mon_flow_num   流量大小告警阈值 
 * @apiSuccess {Number} flow_memory_enable 流量超限本地日志开关
 * @apiSuccess {Number} flow_syslog_enable  流量超限Syslog日志开关
 * @apiSuccess {Number} flow_email_enable   流量超限Email开关
 * @apiSuccess {Number} mon_session_num     连接数告警阈值
 * @apiSuccess {Number} session_memory_enable  连接超限告警本地日志开关
 * @apiSuccess {Number} session_syslog_enable  连接超限告警Syslog日志开关
 * @apiSuccess {Number} session_email_enable   连接超限Email报警开关
 * @apiSuccess {Number} mon_packet_len         报文超长阈值
 * @apiSuccess {Number} packet_memory_enable   报文长度超限本地日志告警开关
 * @apiSuccess {Number} packet_syslog_enable   报文长度超限Syslog日志开关
 * @apiSuccess {Number} packet_email_enable    报文长度超限Email告警开关
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"data": [
 *		{
 *			"net_usage_memory_enable": "0",
 *			"packet_email_enable": "0",
 *			"packet_memory_enable": "0",
 *			"session_syslog_enable": "0",
 *			"mem_usage_memory_enable": "0",
 *			"net_usage_email_enable": "0",
 *			"mon_packet_len": "100",
 *          "mem_usage_syslog_enable": "0",
 *          "mem_usage_num": "90",
 *			"cpu_usage_num": "90",
 *			"session_email_enable": "0",
 *			"cpu_usage_syslog_enable": "0",
 *			"cpu_usage_memory_enable": "0",
 *			"session_memory_enable": "0",
 *			"mon_session_num": "0",
 *			"mem_usage_email_enable": "0",
 *			"flow_email_enable": "0",
 *			"mon_flow_num": "0",
 *			"packet_syslog_enable": "0",
 *			"flow_memory_enable": "0",
 *			"flow_syslog_enable": "0"
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
 *		"code":"234"
 *	}
 *
 */


class SysResourceController extends mController{	
	public $module = 'sys_resource';
}

