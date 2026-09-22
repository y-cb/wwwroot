<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/debug 获取诊断状态
 * @apiName 获取当前诊断状态（开启/关闭）
 * @apiGroup 系统维护
 *
 * @apiSuccess {Number} enable  当前是否开启诊断功能
 * @apiSuccess {group} debug_print  打印的诊断信息组
 * @apiSuccess {String} debug_str  打印的具体诊断信息
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"enable": "1", 
 *			"debug_print":,
 *			{
 *				"group": [
 *				{
 *					"debug_str": "FLOW Module: Conntrack UDP: 172.16.0.21 56504 -> 239.255.255.250 1900: Packet 172.16.0.21->239.255.255.250 create new conntrack on ge0/0", 
 *					"debug_str": "FLOW Module: Conntrack UDP: 172.16.0.21 56504 -> 239.255.255.250 1900: Packet 172.16.0.21->239.255.255.250 create new conntrack on ge0/1"
 * 				}
 *				]
 *			}
 *		},
 *	],
 *	"total": 1
 *	}
 */


/**
 * @api {POST}  /api/debug 开启诊断
 * @apiName  开启诊断
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {Number} ip_type  地址类型（0：ipv4;1 ipv6）
 * @apiSuccess {Number} protocol_type  协议类型
 * @apiSuccess {Number} protocol_num  协议号
 * @apiSuccess {String} src_ip  源IP地址
 * @apiSuccess {String} dst_ip  目的IP地址
 * @apiSuccess {String} src_port  源端口
 * @apiSuccess {String} dst_port  目的端口
 * @apiSuccess {String} icmp_type  icmp协议type类型
 * @apiSuccess {String} icmp_code  icmp协议code值
 * @apiSuccess {Number} enable  当前是否开启诊断功能
 * @apiSuccess {Array} dataflow_module dataflow_module[0]表示流信息，0表示开启，dataflow_module[1]表示NAT，0表示关闭，1表示开启
 * @apiSuccess {Array} ctrlflow_module  XXX 此处替换为对ctrlflow_module 的中文注释
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ip_type": "0",
 *			"protocol_type": "0",
 *			"protocol_num": "0",
 *			"src_ip": "172.16.0.51",
 *			"dst_ip":"",
 *			"src_port": "20",
 *			"dst_port": "80",
 *			"icmp_type": "12",
 *			"icmp_code": "22",
 *			"dataflow_module": "["group id='0'": "module_id":"1";"group id='1'":"module_id:1"]"
 *		},
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/debug 删除诊断信息
 * @apiName 不需传入参数，操作执行即删除诊断信息
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {Number} offset 防病毒库的名称
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *   {
 *   "data": [
 *       {
 *       }
 *   ],
 *   }
 */
/**
 * @api {DELETE}  /api/debug 停止诊断
 * @apiName 不需要传入参数
 * @apiGroup 系统维护
 *
 *

 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *   {
 *   "data": [
 *       {
 *       }
 *   ],
 *   }
 */

class SysDebugController extends mController{
	public $module = 'track_debug';
}

?>
