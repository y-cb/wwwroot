<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/sslvpn-monitor 查询sslvpn监控信息
 * @apiName 查询sslvpn监控信息
 * @apiGroup SSL VPN
 *
 *
 * @apiSuccess {String} name  用户名
 * @apiSuccess {String} ip  接入IP
 * @apiSuccess {Number} online_time  在线时长
 * @apiSuccess {String} vip  虚拟IP
 * @apiSuccess {Number} up_bytes  发送字节数
 * @apiSuccess {Number} down_bytes  接收字节数
 * @apiSuccess {String} terminaltype  终端类型
 * @apiSuccess {String} terminalid  硬件特征码
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"ip": "172.16.0.135",
 *			"online_time": "",
 *			"vip": "10.0.0.1",
 *			"up_bytes": "1 kb",
 *			"down_bytes": "2 kb"
 *			"terminaltype": "Windows64"
 *			"terminalid": "b91510b31ce8fba5da2fa44f84e99e8f"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {DELETE}  /api/sslvpn-monitor 删除sslvpn监控信息
 * @apiName 删除sslvpn监控信息
 * @apiGroup SSL VPN
 *
 *
 * @apiParam {String} name  用户名，（1-63）字符，支持中英文大小写、数字以及@。._-|()[]字符
 * @apiParam {String} ip  接入IP，例如192.168.0.100
 * @apiParam {String} vip  虚拟IP，例如192.168.0.100
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test",
 *		"ip": "172.16.0.135",
 *		"vip": "10.0.0.10"
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
 *		"code":"1",
 *		"str":""
 *	}
 *
 */


class SslvpnMonitorController extends mController{
	public $module = 'sslvpn_monitor';
}

?>
