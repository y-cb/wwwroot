<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/dhcp-service 获取DHCP服务开启情况
 * @apiName 获取DHCP服务开启情况
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} ifname  DHCP服务开启的接口名称
 * @apiSuccess {Number} type  DHCP服务类型  1：中继  2:服务器
 * @apiSuccess {String} relay_ip  如类型为中继 则此字段为对应服务器地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ifname": "ge0/1",
 *			"type": "2",
 *			"relay_ip": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/dhcp-service 修改DHCP服务开启情况
 * @apiName 修改DHCP服务开启情况
 * @apiGroup DHCP
 *
 *
 * @apiParam {String} ifname  DHCP服务开启的接口名称
 * @apiParam {Number} type  DHCP服务类型, 1：中继, 2:服务器
 * @apiParam {String} relay_ip  如类型为中继,则此字段为对应服务器地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ifname": "ge0/1",
 *		"type": "1",
 *		"relay_ip": "10.0.0.10"
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
 *		"code":"129",
 *		"str":""
 *	}
 *
 */


class DhcpServiceController extends mController{
	public $module = 'dhcp_service';
}

?>
