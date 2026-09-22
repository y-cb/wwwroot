<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET} /api/session-stat 获取会话统计
 * @apiName 获取会话统计
 * @apiGroup 会话信息监控
 *
 * @apiSuccess {Number} stat_type 会话统计类型，0：源IPv4统计，1：目的IPv4统计 2：目的端口统计 3：源ipv6统计，，4：目的ipv6统计
 * @apiSuccess {String} stat_condition 过滤IP地址条件
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *      {
 *           "id": "1",
 *          "stat_type_show": "0",
 *          "stat_item": "172.16.0.80",
 *          "stat_count": "3"
 *      }
 *		
 *	"total": 1
 *	}
 */

/**
 * @api {DELETE} /api/session-stat 删除会话统计
 * @apiName 删除会话统计
 * @apiGroup 会话信息监控
 *
 * @apiSuccess {Number} protocol 协议号
 * @apiSuccess {String} src_ip 源ip
 * @apiSuccess {String} name 默认 -
 * @apiSuccess {String} src_port 源端口
 * @apiSuccess {String} dst_ip 目的IP
 * @apiSuccess {String} dst_port 目的端口
 * @apiSuccess {String} l3proto 三层协议
 * @apiSuccess {Number} state 默认值
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "-",
 *		"protocol": "17",
 *		"src_ip": "172.17.80.11",
 *		"src_port": "7096",
 *		"dst_ip": "239.255.255.250",
 *		"dst_port": "1900",
 *		"state": "1"
 *	}
  * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success！"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error！"
 *	}
 */


class SessionStatController extends mController{
	public $module = 'session_stat';
}
