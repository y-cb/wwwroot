<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ipsec-vpn 获取ipsec二阶段配置信息
 * @apiName 获取ipsec二阶段配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} name  ipsec二阶段名称
 * @apiSuccess {String} ike_name  绑定一阶段名称
 * @apiSuccess {Number} ikev2  ike版本  0-ikev1 1-ikev2
 * @apiSuccess {Number} encap  二阶段封装方式  1-ah 2-esp
 * @apiSuccess {Number} mode  二阶段应用方式  当前只支持隧道模式
 * @apiSuccess {Number} pfs  1/2/5
 * @apiSuccess {Number} auto_connect  自动连接
 * @apiSuccess {Number} auto_conn_interval  自动连接间隔
 * @apiSuccess {Number} lifetime  二阶段秘钥生存周期  0-按秒计算 1-按字节数计算 2-两者都有
 * @apiSuccess {Number} lifetime_seconds  二阶段秘钥生存周期  秒数
 * @apiSuccess {Number} lifetime_kilobytes  二阶段秘钥生存周期  字节数
 * @apiSuccess {Array} ipsec  ikev1方案配置
 * @apiSuccess {Array} ike  ikev2方案配置
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "phase2",
 *			"ike_name": "phase1",
 *			"ikev2": "0",
 *			"encap": "2",
 *			"mode": "0",
 *			"pfs": "2",
 *			"auto_connect": "1",
 *			"auto_conn_interval": "2",
 *			"lifetime": "2",
 *			"lifetime_seconds": "86400",
 *			"lifetime_kilobytes": "11111",
 *			"ipsec": "{\"group\":{\"esp_encap\":\"3DES_MD5\",\"ah_encap\":\"NULL\"}}",
 *			"ike": ""
 *		},
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/ipsec-vpn 新建ipsec二阶段配置
 * @apiName 新建ipsec二阶段配置
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} name  ipsec二阶段名称
 * @apiParam {String} ike_name  绑定一阶段名称
 * @apiParam {Number} ikev2  ike版本, 0-ikev1 1-ikev2
 * @apiParam {Number} encap  二阶段封装方式, 1-ah 2-esp
 * @apiParam {Number} mode  二阶段应用方式, 当前只支持隧道模式
 * @apiParam {Number} pfs  1/2/5
 * @apiParam {Number} auto_connect  自动连接
 * @apiParam {Number} auto_conn_interval  自动连接间隔
 * @apiParam {Number} lifetime  二阶段秘钥生存周期, 0-按秒计算 1-按字节数计算 2-两者都有
 * @apiParam {Number} lifetime_seconds  二阶段秘钥生存周期, 秒数
 * @apiParam {Number} lifetime_kilobytes  二阶段秘钥生存周期, 字节数
 * @apiParam {Array} ipsec  ikev1方案配置
 * @apiParam {Array} ike  ikev2方案配置
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "phase2",
 *		"ike_name": "phase1",
 *		"ikev2": "1",
 *		"encap": "2",
 *		"mode": "0",
 *		"pfs": "2",
 *		"auto_connect": "1",
 *		"auto_conn_interval": "2",
 *		"lifetime": "2",
 *		"lifetime_seconds": "86400",
 *		"lifetime_kilobytes": "11111",
 *		"ike[0][encrypt]": "3DES",
 *		"ike[0][hash]": "MD5",
 *		"ike[0][group]": "5"
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
 * @api {PUT}  /api/ipsec-vpn 修改ipsec二阶段配置
 * @apiName 修改ipsec二阶段配置
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} name  ipsec二阶段名称
 * @apiParam {String} ike_name  绑定一阶段名称
 * @apiParam {Number} ikev2  ike版本, 0-ikev1 1-ikev2
 * @apiParam {Number} encap  二阶段封装方式, 1-ah 2-esp
 * @apiParam {Number} mode  二阶段应用方式, 当前只支持隧道模式
 * @apiParam {Number} pfs  1/2/5
 * @apiParam {Number} auto_connect  自动连接
 * @apiParam {Number} auto_conn_interval  自动连接间隔
 * @apiParam {Number} lifetime  二阶段秘钥生存周期, 0-按秒计算 1-按字节数计算 2-两者都有
 * @apiParam {Number} lifetime_seconds  二阶段秘钥生存周期, 秒数
 * @apiParam {Number} lifetime_kilobytes  二阶段秘钥生存周期, 字节数
 * @apiParam {Array} ipsec  ikev1方案配置
 * @apiParam {Array} ike  ikev2方案配置
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "phase2",
 *		"ike_name": "phase1",
 *		"ikev2": "0",
 *		"encap": "2",
 *		"mode": "0",
 *		"pfs": "2",
 *		"auto_connect": "1",
 *		"auto_conn_interval": "2",
 *		"lifetime": "2",
 *		"lifetime_seconds": "86400",
 *		"lifetime_kilobytes": "11111",
 *		"ike[0][encrypt]": "3DES",
 *		"ike[0][hash]": "MD5",
 *		"ike[0][group]": "5"
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
 * @api {DELETE}  /api/ipsec-vpn 删除ipsec二阶段配置
 * @apiName 删除ipsec二阶段配置
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} name  ipsec二阶段名称
 * @apiParam {String} vrf_name  ipsec二阶段所属vrf名称
 * @apiParam {Number} ikev2  ike版本, 0-ikev1 1-ikev2
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "phase2",
 *		"ikev2": "0",
 *		"vrf_name": "vrf0"
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
 *		"code":"-1",
 *		"str":"Tunnel is inuse!"
 *	}
 *
 */



class IpsecVpnController extends mController{
	public $module = 'vpn_ipsec';
}

?>
