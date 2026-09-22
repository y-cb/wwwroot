<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ospf-interface 查询ospf发布接口配置
 * @apiName 查询ospf发布接口配置
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} vrf_name  ospf发布接口所属vrf名称
 * @apiSuccess {String} ifname  接口名称
 * @apiSuccess {Number} priority  优先级  0-255
 * @apiSuccess {Number} cost  默认0  1-65535
 * @apiSuccess {Number} network_type  网络类型  点到点/广播 0/1
 * @apiSuccess {Number} retransmit_interval  重传间隔  default 5 <3-65535>
 * @apiSuccess {Number} transmit_delay  default 1; <1-65535>
 * @apiSuccess {Number} hello_interval  default 10; <1-65535>
 * @apiSuccess {Number} dead_interval  default 40; <1-65535>
 * @apiSuccess {Number} auth_type  0-none  1-text  2-MD5
 * @apiSuccess {Number} area_auth_type  0-none  1-text  2-MD5
 * @apiSuccess {String} auth_key  认证key值
 * @apiSuccess {Array} md5_auth  MD5 key chain
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"ifname": "ge0/1",
 *			"priority": "1",
 *			"cost": "0",
 *			"network_type": "1",
 *			"retransmit_interval": "5",
 *			"transmit_delay": "1",
 *			"hello_interval": "10",
 *			"dead_interval": "40",
 *			"auth_type": "1",
 *			"area_auth_type": "1",
 *			"auth_key": "abcde",
 *			"md5_auth": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/ospf-interface 新增ospf发布接口配置
 * @apiName 新增ospf发布接口配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf发布接口所属vrf名称
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} priority  优先级, 0-255
 * @apiParam {Number} cost  默认0, 1-65535
 * @apiParam {Number} network_type  网络类型, 点到点/广播 0/1
 * @apiParam {Number} retransmit_interval  重传间隔, default 5 <3-65535>
 * @apiParam {Number} transmit_delay  default 1; <1-65535>
 * @apiParam {Number} hello_interval  default 10; <1-65535>
 * @apiParam {Number} dead_interval  default 40; <1-65535>
 * @apiParam {Number} auth_type  0-none, 1-text, 2-MD5
 * @apiParam {Number} area_auth_type  0-none, 1-text, 2-MD5
 * @apiParam {String} auth_key  认证key值
 * @apiParam {Array} md5_auth  MD5 key chain
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"ifname": "ge0/1",
 *		"priority": "1",
 *		"cost": "0",
 *		"network_type": "1",
 *		"retransmit_interval": "5",
 *		"transmit_delay": "1",
 *		"hello_interval": "10",
 *		"dead_interval": "40",
 *		"auth_type": "1",
 *		"area_auth_type": "1",
 *		"auth_key": "abcde",
 *		"md5_auth": ""
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
 *		"code":"100",
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/ospf-interface 修改ospf发布接口配置
 * @apiName 修改ospf发布接口配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf发布接口所属vrf名称
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} priority  优先级, 0-255
 * @apiParam {Number} cost  默认0, 1-65535
 * @apiParam {Number} network_type  网络类型, 点到点/广播 0/1
 * @apiParam {Number} retransmit_interval  重传间隔, default 5 <3-65535>
 * @apiParam {Number} transmit_delay  default 1; <1-65535>
 * @apiParam {Number} hello_interval  default 10; <1-65535>
 * @apiParam {Number} dead_interval  default 40; <1-65535>
 * @apiParam {Number} auth_type  0-none, 1-text, 2-MD5
 * @apiParam {Number} area_auth_type  0-none, 1-text, 2-MD5
 * @apiParam {String} auth_key  认证key值
 * @apiParam {Array} md5_auth  MD5 key chain
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"ifname": "ge0/1",
 *		"priority": "1",
 *		"cost": "0",
 *		"network_type": "1",
 *		"retransmit_interval": "5",
 *		"transmit_delay": "1",
 *		"hello_interval": "10",
 *		"dead_interval": "40",
 *		"auth_type": "1",
 *		"area_auth_type": "1",
 *		"auth_key": "abcde",
 *		"md5_auth": ""
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
 *		"code":"100",
 *		"str":"0"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/ospf-interface 删除ospf发布接口配置
 * @apiName 删除ospf发布接口配置
 * @apiGroup IPv4路由
 *
 *
 * @apiParam {String} vrf_name  ospf发布接口所属vrf名称
 * @apiParam {String} ifname  接口名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vrf_name": "vrf0",
 *		"ifname": "ge0/0"
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
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


class OspfInterfaceController extends mController{
	public $module = 'ospf_interface';
}

?>
