<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET} /api/mirror-policy 获取镜像策略
 * @apiName 获取镜像策略
 * @apiGroup 获取防火墙策略
 *
 *
 * @apiSuccess {Number} id  策略ID
 * @apiSuccess {Number} protocol  协议类型，1表示ipv4，2表示ipv6
 * @apiSuccess {String} if_in  入接口
 * @apiSuccess {String} if_out  出接口
 * @apiSuccess {String} sip  源地址
 * @apiSuccess {String} dip  目的地址
 * @apiSuccess {String} sev  服务名称
 * @apiSuccess {String} user  用户名称
 * @apiSuccess {String} app  应用名称
 * @apiSuccess {String} tr  时间表
 * @apiSuccess {Number} mode  动作（1表示 PERMIT 2表示DENY）
 * @apiSuccess {Number} enable  策略是否启用，0表示不启用，1表示启用
 * @apiSuccess {Number} bingo  策略被命中的次数
 * @apiSuccess {Number} syslog  是否开启日志，0表示不启用，1表示启用
 * @apiSuccess {Number} log_level  日志级别（0表示紧急，1表示告警，2表示严重，3表示错误，4表示警示，5表示通知，6表示信息）
 * @apiSuccess {Number} refer_id  相关策略ID（移动策略时表示要移动到哪条策略之前|之后，插入策略时表示要插入到哪条策略之前）
 * @apiSuccess {Number} mv_opt  移动选项 （0: 移动到指定策略之前 1: 移动到指定策略之后）
 * @apiSuccess {String} desc  描述
 * @apiSuccess {String} mirror_dev  流镜像接口名称
 * @apiSuccess {Number} flowstat  流量统计功能是否启用（0: 不启用  1: 启用）
 * @apiSuccess {Number} protection_enable  安全防护功能是否启用（0: 不启用   1: 启用）  （暂时保留）
 * @apiSuccess {String} protection_module  安全防护模块									（暂时保留）
 * @apiSuccess {Number} conn_slimit  源主机连接限制（范围：0-10000000）
 * @apiSuccess {Number} conn_rate_slimit  源主机连接速率限制（范围：0-10000000）
 * @apiSuccess {Number} page  分页数
 * @apiSuccess {Number} count  策略数量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"id": "1",
 *			"protocol": "1",
 *			"vrf_name": "",
 *			"if_in": "any",
 *			"if_out": "any",
 *			"sip": "any",
 *			"dip": "any",
 *			"sev": "any",
 *			"user": "any",
 *			"app": "any",
 *			"tr": "always",
 *			"mode": "1",
 *			"enable": "1",
 *			"bingo": "0",
 *			"syslog": "1",
 *			"log_level": "6",
 *			"refer_id": "0",
 *			"mv_opt": "0",
 *			"desc": "aaaaaa",
 *			"mirror_dev": "null",
 *			"flowstat": "1",
 *			"protection_enable": "0",
 *			"protection_module": "",
 *			"qos_enable": "0",
 *			"conn_slimit": "0",
 *			"conn_rate_slimit": "0",
 *			"page": "1",
 *			"count": "2",
 *			"app_show": "any",
 *			"user_show": "\u6240\u6709\u7528\u6237"      
 *		},
 *		{
 *			"id": "2",
 *			"protocol": "1",
 *			"vrf_name": "",
 *			"if_in": "ge0/0",
 *			"if_out": "ge0/2",
 *			"sip": "any",
 *			"dip": "any",
 *			"sev": "any",
 *			"user": "any",
 *			"app": "any",
 *			"tr": "always",
 *			"mode": "1",
 *			"enable": "1",
 *			"bingo": "0",
 *			"syslog": "1",
 *			"log_level": "6",
 *			"refer_id": "0",
 *			"mv_opt": "0",
 *			"desc": "aaa",
 *			"mirror_dev": "null",
 *			"flowstat": "1",
 *			"protection_enable": "0",
 *			"protection_module": "",
 *			"qos_enable": "0",
 *			"conn_slimit": "100",
 *			"conn_rate_slimit": "100",
 *			"page": "1",
 *			"count": "2",
 *			"app_show": "any",
 *			"user_show": "\u6240\u6709\u7528\u6237"   
 *		}
 *	],
 *	"total": 2
 *	}
 */
 
/**
 * @api {POST} /api/mirror-policy 添加镜像策略
 * @apiName 添加镜像策略
 * @apiGroup 添加防火墙策略
 *
 *
 * @apiParam {Number} protocol  协议类型，1表示ipv4，2表示ipv6
 * @apiParam {String} if_in  入接口
 * @apiParam {String} if_out  出接口
 * @apiParam {String} sip  源地址
 * @apiParam {String} dip  目的地址
 * @apiParam {String} sev  服务名称
 * @apiParam {String} user  用户名称
 * @apiParam {String} app  应用名称
 * @apiParam {String} tr  时间表
 * @apiParam {Number} mode  动作（1表示 PERMIT 2表示DENY）
 * @apiParam {Number} enable  策略是否启用，0表示不启用，1表示启用
 * @apiParam {Number} syslog  是否开启日志，0表示不启用，1表示启用
 * @apiParam {Number} log_level  日志级别（0表示紧急，1表示告警，2表示严重，3表示错误，4表示警示，5表示通知，6表示信息）
 * @apiParam {String} desc  描述
 * @apiParam {String} mirror_dev  流镜像接口名称
 * @apiParam {Number} flowstat  流量日志功能是否启用（0: 不启用  1: 启用）
 * @apiParam {Number} conn_slimit  源主机连接限制（范围：0-10000000）
 * @apiParam {Number} conn_rate_slimit  源主机连接速率限制（范围：0-10000000）
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "0",
 *		"protocol": "1",
 *		"if_in": "any",
 *		"if_out": "any",
 *		"sip": "any",
 *		"dip": "any",
 *		"sev": "any",
 *		"user": "any",
 *		"app": "any",
 *		"tr": "always",
 *		"mode": "1",
 *		"enable": "1",
 *		"syslog": "1",
 *		"log_level": "6",
 *		"refer_id": "0",
 *		"desc": "vvv",
 *		"mirror_dev": "null",
 *		"flowstat": "1",
 *		"conn_slimit": "0",
 *		"conn_rate_slimit": "0"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"122",
 *		"str":"该策略已经存在"
 *	}
 *
 */

/**
 * @api {PUT} /api/mirror-policy 修改镜像策略
 * @apiName 修改镜像策略
 * @apiGroup 修改防火墙策略
 *
 *
 * @apiParam {Number} id  策略ID
 * @apiParam {Number} protocol  协议类型，1表示ipv4，2表示ipv6
 * @apiParam {String} if_in  入接口
 * @apiParam {String} if_out  出接口
 * @apiParam {String} sip  源地址
 * @apiParam {String} dip  目的地址
 * @apiParam {String} sev  服务名称
 * @apiParam {String} user  用户名称
 * @apiParam {String} app  应用名称
 * @apiParam {String} tr  时间表
 * @apiParam {Number} mode  动作（1表示 PERMIT 2表示DENY）
 * @apiParam {Number} enable  策略是否启用，0表示不启用，1表示启用
 * @apiParam {Number} syslog  是否开启日志，0表示不启用，1表示启用
 * @apiParam {Number} log_level  日志级别（0表示紧急，1表示告警，2表示严重，3表示错误，4表示警示，5表示通知，6表示信息）
 * @apiParam {Number} refer_id  相关策略ID（移动策略时表示要移动到哪条策略之前|之后，插入策略时表示要插入到哪条策略之前）
 * @apiParam {String} desc  描述
 * @apiParam {String} mirror_dev  流镜像接口名称
 * @apiParam {Number} flowstat  流量日志功能是否启用（0: 不启用  1: 启用）
 * @apiParam {Number} conn_slimit  源主机连接限制（范围：0-10000000）
 * @apiParam {Number} conn_rate_slimit  源主机连接速率限制（范围：0-10000000）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "0",
 *		"protocol": "1",
 *		"if_in": "any",
 *		"if_out": "any",
 *		"sip": "any",
 *		"dip": "any",
 *		"sev": "any",
 *		"user": "any",
 *		"app": "any",
 *		"tr": "always",
 *		"mode": "1",
 *		"enable": "1",
 *		"syslog": "1",
 *		"log_level": "6",
 *		"refer_id": "0",
 *		"desc": "vvv",
 *		"mirror_dev": "null",
 *		"flowstat": "1",
 *		"conn_slimit": "0",
 *		"conn_rate_slimit": "0"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"97",
 *		"str":"时间范围不存在"
 *	}
 *
 */

/**
 * @api {DELETE} /api/mirror-policy 删除镜像策略
 * @apiName 删除镜像策略
 * @apiGroup 删除防火墙策略
 *
 *
 * @apiParam {Number} id  策略ID
 * @apiParam {Number} protocol  协议类型，1表示ipv4，2表示ipv6
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"id": "2",
 *		"protocol": "1"	 
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"87",
 *		"str":"目标策略不存在"
 *	}
 *
 */


class MirrorPolicyController extends mController{
	public $module = 'mirror_policy_table';
}

?>
