<?php
namespace controller\system;
use controller\Controller;

/**
 * @api {GET}  /api/capture-file 获取抓包工具的抓包状态
 * @apiName 获取抓包工具当前的抓包状态
 * @apiGroup 系统维护
 *
 *
 * @apiSuccess {Number} enable  工具当前抓包状态；1，正在抓包；0，未抓包
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"enable": "1"
 *		},
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/capture-file 抓包工具开始抓包
 * @apiName 根据传入的配置，抓取对应的报文
 * @apiGroup 系统维护
 *
 *
 * @apiParam {Number} cap_way  抓包方式（1：发送端；2，接收端；3，所有）
 * @apiParam {Number} ip_type  地址类型（0：ipv4;1,ipv6;2,所有）
 * @apiParam {Number} protocol_type  要抓取的协议:0表示ANY，1表示TCP， 2表示UDP，3表示ICMP，4表示other
 * @apiParam {Number} protocol_num  协议号
 * @apiParam {String} src_ip  源IP地址
 * @apiParam {String} dst_ip  目的IP地址
 * @apiParam {String} src_port  源端口
 * @apiParam {String} dst_port  目的端口
 * @apiParam {String} icmp_type  icmp协议type字段
 * @apiParam {String} icmp_code  icmp协议code字段
 * @apiParam {Number} enable  当前抓包状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"cap_way": "1",
 *		"ip_type": "0",
 *		"protocol_type": "2",
 *		"protocol_num": "",
 *		"src_ip": "1.1.1.1",
 *		"dst_ip": "2.2.2.2",
 *		"src_port": "1",
 *		"dst_port": "2"
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


/**
 * @api {delete}  /api/capture-file 抓包动作结束验证
 * @apiName 抓包动作结束验证
 * @apiGroup 系统维护
 *
 */

class CaptureFileController extends Controller {	
	public $module = 'capture_filter';
}
