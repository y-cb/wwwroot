<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/dhcp-ipbind 获取DHCP的IP-MAC绑定信息
 * @apiName 获取DHCP的IP-MAC绑定信息
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} vrf_name  IP-MAC绑定所属VRF名称
 * @apiSuccess {String} bind_name  IP-MAC绑定名称
 * @apiSuccess {String} ipaddr  IP地址
 * @apiSuccess {String} macaddr  MAC地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"bind_name": "bind1",
 *			"ipaddr": "1.1.1.1",
 *			"macaddr": "00:db:df:ed:fc:9b"
 *		},
 *		{
 *			"vrf_name": "vrf0",
 *			"bind_name": "bind2",
 *			"ipaddr": "2.2.2.2",
 *			"macaddr": "00:db:df:ed:fc:0b"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/dhcp-ipbind 新建DHCP的IP-MAC绑定信息
 * @apiName 新建DHCP的IP-MAC绑定信息
 * @apiGroup DHCP
 *
 *
 * @apiParam {String} vrf_name  IP-MAC绑定所属VRF名称
 * @apiParam {String} bind_name  IP-MAC绑定名称
 * @apiParam {String} ipaddr  IP地址
 * @apiParam {String} macaddr  MAC地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"bind_name": "bind1",
 *		"ipaddr": "1.1.1.1",
 *		"macaddr": "00:db:df:ed:fc:9b"
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
 *		"code":"47",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/dhcp-ipbind 删除DHCP的IP-MAC绑定信息
 * @apiName 删除DHCP的IP-MAC绑定信息
 * @apiGroup DHCP
 *
 *
 * @apiParam {String} vrf_name  IP-MAC绑定所属VRF名称
 * @apiParam {String} bind_name  IP-MAC绑定名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"bind_name": "test"
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
 *		"code":"47",
 *		"str":""
 *	}
 *
 */


class DhcpIpbindController extends mController{
	public $module = 'dhcp_ipbind';
}

?>
