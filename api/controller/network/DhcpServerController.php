<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/dhcp-server 查询DHCP服务器的相关配置
 * @apiName 查询DHCP服务器的相关配置
 * @apiGroup DHCP
 *
 *
 * @apiSuccess {String} vrf_name  DHCP服务器所属VRF名称
 * @apiSuccess {String} server_name  DHCP服务器名称
 * @apiSuccess {String} subnet  DHCP服务器子网
 * @apiSuccess {String} ip_gw  DHCP服务器默认网关地址
 * @apiSuccess {String} ip_start  DHCP服务器可分配开始地址
 * @apiSuccess {String} ip_end  DHCP服务器可分配结束地址
 * @apiSuccess {Number} infinite  无限期地址租期
 * @apiSuccess {Number} time_d_lease  地址租期天数
 * @apiSuccess {Number} time_h_lease  地址租期小时数
 * @apiSuccess {Number} time_m_lease  地址租期分钟数
 * @apiSuccess {String} ip_dns1  DNS服务器地址1
 * @apiSuccess {String} ip_dns2  DNS服务器地址2
 * @apiSuccess {String} ip_wins1  WINS服务器地址1
 * @apiSuccess {String} ip_wins2  WINS服务器地址2
 * @apiSuccess {String} domain_name  所属域名
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"server_name": "dhcpserver",
 *			"subnet": "10.0.0.0/24",
 *			"ip_gw": "10.0.0.1",
 *			"ip_start": "10.0.0.2",
 *			"ip_end": "10.0.0.10",
 *			"infinite": "1",
 *			"time_d_lease": "",
 *			"time_h_lease": "",
 *			"time_m_lease": "",
 *			"ip_dns1": "",
 *			"ip_dns2": "",
 *			"ip_wins1": "",
 *			"ip_wins2": "",
 *			"domain_name": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/dhcp-server 新增DHCP服务器
 * @apiName 新增DHCP服务器
 * @apiGroup DHCP
 *
 *
 * @apiParam {String} vrf_name  DHCP服务器所属VRF名称
 * @apiParam {String} server_name  DHCP服务器名称
 * @apiParam {String} subnet  DHCP服务器子网
 * @apiParam {String} ip_gw  DHCP服务器默认网关地址
 * @apiParam {String} ip_start  DHCP服务器可分配开始地址
 * @apiParam {String} ip_end  DHCP服务器可分配结束地址
 * @apiParam {Number} infinite  无限期地址租期
 * @apiParam {Number} time_d_lease  地址租期天数
 * @apiParam {Number} time_h_lease  地址租期小时数
 * @apiParam {Number} time_m_lease  地址租期分钟数
 * @apiParam {String} ip_dns1  DNS服务器地址1
 * @apiParam {String} ip_dns2  DNS服务器地址2
 * @apiParam {String} ip_wins1  WINS服务器地址1
 * @apiParam {String} ip_wins2  WINS服务器地址2
 * @apiParam {String} domain_name  所属域名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"server_name": "server",
 *		"subnet": "10.0.0.0/24",
 *		"ip_gw": "10.0.0.1",
 *		"ip_start": "10.0.0.2",
 *		"ip_end": "10.0.0.20",
 *		"infinite": "1",
 *		"time_d_lease": "0",
 *		"time_h_lease": "0",
 *		"time_m_lease": "0",
 *		"ip_dns1": "",
 *		"ip_dns2": "",
 *		"ip_wins1": "",
 *		"ip_wins2": "",
 *		"domain_name": ""
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
 *		"code":"120",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/dhcp-server 修改DHCP服务器
 * @apiName 修改DHCP服务器
 * @apiGroup DHCP
 *
 *
 * @apiParam {String} vrf_name  DHCP服务器所属VRF名称
 * @apiParam {String} server_name  DHCP服务器名称
 * @apiParam {String} subnet  DHCP服务器子网
 * @apiParam {String} ip_gw  DHCP服务器默认网关地址
 * @apiParam {String} ip_start  DHCP服务器可分配开始地址
 * @apiParam {String} ip_end  DHCP服务器可分配结束地址
 * @apiParam {Number} infinite  无限期地址租期
 * @apiParam {Number} time_d_lease  地址租期天数
 * @apiParam {Number} time_h_lease  地址租期小时数
 * @apiParam {Number} time_m_lease  地址租期分钟数
 * @apiParam {String} ip_dns1  DNS服务器地址1
 * @apiParam {String} ip_dns2  DNS服务器地址2
 * @apiParam {String} ip_wins1  WINS服务器地址1
 * @apiParam {String} ip_wins2  WINS服务器地址2
 * @apiParam {String} domain_name  所属域名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"server_name": "server",
 *		"subnet": "10.0.0.0/24",
 *		"ip_gw": "10.0.0.1",
 *		"ip_start": "10.0.0.2",
 *		"ip_end": "10.0.0.20",
 *		"infinite": "1",
 *		"time_d_lease": "0",
 *		"time_h_lease": "0",
 *		"time_m_lease": "0",
 *		"ip_dns1": "",
 *		"ip_dns2": "",
 *		"ip_wins1": "",
 *		"ip_wins2": "",
 *		"domain_name": ""
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
 *		"code":"120",
 *		"str":""
 *	}
 *
 */

/**
 * @api {DELETE}  /api/dhcp-server 删除DHCP服务器
 * @apiName 删除DHCP服务器
 * @apiGroup DHCP
 *
 *
 * @apiParam {String} vrf_name  DHCP服务器所属VRF名称
 * @apiParam {String} server_name  DHCP服务器名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"server_name": "test"
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
 *		"code":"120",
 *		"str":""
 *	}
 *
 */


class DhcpServerController extends mController{
	public $module = 'dhcp_server';
}

?>
