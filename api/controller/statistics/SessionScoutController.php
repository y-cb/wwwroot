<?php
namespace controller\statistics;
use controller\mController;

/**
 * @apiName 获取会话监控
 * @api {GET} /api/session-scout 获取会话监控
 * @apiGroup 会话信息监控
 *
 *
 * @apiSuccess {Number} lb_type 
 * @apiSuccess {String} iptype 0:ipv4 1:ipv4
 * @apiSuccess {String} name	名称
 * @apiSuccess {Number} scout_proto  0 ALL, 1 TCP, 2 UDP, 3 ICMP, 4 other
 * @apiSuccess {Number} scout_state  0 all, 1 complete, 2 halfopen
 * @apiSuccess {String} scout_sip	源ip
 * @apiSuccess {String} scout_dip	目的IP
 * @apiSuccess {String} scout_sip6	源IP
 * @apiSuccess {String} scout_dip6	目的IP
 * @apiSuccess {Number} scout_dport	目的端口
 * @apiSuccess {Number} icmp_code icmp ID
 * @apiSuccess {Number} icmp_type icmp类型
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		  {
 *	          "protocol": "89",
 *	          "protocol_type": "89",
 *           "dst_port": "-",
 *           "src_port": "-",
 *           "dst_ip": "224.0.0.5",
 *           "src_ip": "5.5.5.1",
 *           "l3proto": "0",
 *           "timeout": "00:00:27",
 *           "exist": "04:44:21",
 *           "name": "-",
 *           "member": "-",
 *           "state": "1",
 *           "flow": "106.25",
 *           "page": "1",
 *           "count": [
 *               "16",
 *               "16"
 *           ]
 *      },
 *		
 *	"total": 1
 *	}
 */

 /**
 * @api {DELETE} /api/session-scout 删除会话监控
 * @apiName 删除会话监控
 * @apiGroup 会话信息监控
 *
 * @apiSuccess {Number} protocol 协议号，6表示tcp，17表示udp
 * @apiSuccess {String} src_ip 源ip
 * @apiSuccess {String} src_port 源端口
 * @apiSuccess {String} dst_ip 目的IP
 * @apiSuccess {String} dst_port 目的端口
 * @apiSuccess {String} l3proto 三层协议
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"protocol": "17",
 *		"src_ip": "172.17.80.11",
 *		"src_port": "7096",
 *		"dst_ip": "239.255.255.250",
 *		"dst_port": "1900",
 *		"l3proto": "0"
 *	}
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error！"
 *	}
 */
 
class SessionScoutController extends mController{
	public $module = 'session_scout';
}
