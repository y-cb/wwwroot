<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ipsec-ike 获取ipsec一阶段配置信息
 * @apiName 获取ipsec一阶段配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} name  一阶段名称
 * @apiSuccess {Number} peer  对端网关类型 0-静态 1-动态 2-DNS
 * @apiSuccess {String} address  如果peer类型为静态 则此字段为对端网关IP地址
 * @apiSuccess {String} domain  无意义
 * @apiSuccess {Number} auth_method  一阶段认证方式  1-预共享秘钥 2-证书认证
 * @apiSuccess {Number} ikev2  一阶段版本类型  0-ikev1 1-ikev2
 * @apiSuccess {String} pre_key  预共享秘钥
 * @apiSuccess {String} local_cert  证书名称
 * @apiSuccess {String} ca_cert  一阶段根证书
 * @apiSuccess {Number} mode  一阶段模式  0-主模式 1-野蛮模式  此模式配置只针对ikev1有效
 * @apiSuccess {Number} dh_group  DH组  1/2/5
 * @apiSuccess {Number} lifetime  一阶段SA生命周期 120-86400
 * @apiSuccess {Number} nat_keepalive  NAT穿越连接频率  10-900 秒
 * @apiSuccess {String} local_addr  本地ID  IP地址
 * @apiSuccess {String} local_id_fqdn  本地ID  FQDN
 * @apiSuccess {String} local_id_user_fqdn  本地ID  USER-FQDN
 * @apiSuccess {String} peer_id_fqdn  对端ID  FQDN
 * @apiSuccess {String} peer_id_user_fqdn  对端ID  USER-FQDN
 * @apiSuccess {String} vrf_name  一阶段所属VRF名称
 * @apiSuccess {String} match_ip  匹配地址  只有匹配此地址的对端才能建立一阶段连接
 * @apiSuccess {Number} peer_id_wildcard  对端ID  配置通配符
 * @apiSuccess {Number} dpd_enable  对等体状态探测
 * @apiSuccess {Number} dpd_timeout  DPD超时时间
 * @apiSuccess {Number} dpd_interval  DPD发送间隔
 * @apiSuccess {Number} xauth_enable  扩展认证
 * @apiSuccess {Number} modecfg_enable  模式配置
 * @apiSuccess {String} modecfg_ippool_startip  模式配置地址池 开始IP
 * @apiSuccess {String} modecfg_ippool_endip  模式配置地址池 结束IP
 * @apiSuccess {Number} modecfg_ippool_mask  模式配置地址池 掩码
 * @apiSuccess {String} modecfg_ippool_addrobj  模式配置地址池 地址池对象
 * @apiSuccess {String} modecfg_subnet  模式配置地址池 子网
 * @apiSuccess {String} modecfg_dns  拨号用户DNS
 * @apiSuccess {String} modecfg_wins  拨号用户WINS
 * @apiSuccess {Array} ike  ikev2使用  包括加密算法、认证算法、DH组
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "phase1",
 *			"op": "detail",
 *			"peer": "0",
 *			"address": "192.168.0.199",
 *			"domain": "0",
 *			"auth_method": "1",
 *			"ikev2": "1",
 *			"pre_key": "123456",
 *			"local_cert": "",
 *			"ca_cert": "",
 *			"mode": "0",
 *			"dh_group": "2",
 *			"lifetime": "5000",
 *			"nat_keepalive": "10",
 *			"local_addr": "",
 *			"local_id_fqdn": "",
 *			"local_id_user_fqdn": "",
 *			"peer_id_fqdn": "",
 *			"peer_id_user_fqdn": "",
 *			"vrf_name": "vrf0",
 *			"match_ip": "",
 *			"peer_id_wildcard": "",
 *			"dpd_enable": "0",
 *			"dpd_timeout": "",
 *			"dpd_interval": "",
 *			"xauth_enable": "",
 *			"usergroup": "",
 *			"modecfg_enable": "",
 *			"modecfg_ippool_startip": "",
 *			"modecfg_ippool_endip": "",
 *			"modecfg_ippool_mask": "",
 *			"modecfg_ippool_addrobj": "",
 *			"modecfg_subnet": "",
 *			"modecfg_dns": "",
 *			"modecfg_wins": "",
 *			"ike": "",
 *			"sa_id": ""
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/ipsec-ike 添加ipsec一阶段配置信息
 * @apiName 添加ipsec一阶段配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} name  一阶段名称
 * @apiParam {Number} peer  对端网关类型,0-静态 1-动态 2-DNS
 * @apiParam {String} address  如果peer类型为静态,则此字段为对端网关IP地址
 * @apiParam {String} domain  无意义
 * @apiParam {Number} auth_method  一阶段认证方式, 1-预共享秘钥 2-证书认证
 * @apiParam {Number} ikev2  一阶段版本类型, 0-ikev1 1-ikev2
 * @apiParam {String} pre_key  预共享秘钥
 * @apiParam {String} local_cert  证书名称
 * @apiParam {String} ca_cert  一阶段根证书
 * @apiParam {Number} mode  一阶段模式, 0-主模式 1-野蛮模式, 此模式配置只针对ikev1有效
 * @apiParam {Number} dh_group  DH组, 1/2/5
 * @apiParam {Number} lifetime  一阶段SA生命周期,120-86400
 * @apiParam {Number} nat_keepalive  NAT穿越连接频率, 10-900 秒
 * @apiParam {String} local_addr  本地ID, IP地址
 * @apiParam {String} local_id_fqdn  本地ID, FQDN
 * @apiParam {String} local_id_user_fqdn  本地ID, USER-FQDN
 * @apiParam {String} peer_id_fqdn  对端ID, FQDN
 * @apiParam {String} peer_id_user_fqdn  对端ID, USER-FQDN
 * @apiParam {String} vrf_name  一阶段所属VRF名称
 * @apiParam {String} match_ip  匹配地址, 只有匹配此地址的对端才能建立一阶段连接
 * @apiParam {Number} peer_id_wildcard  对端ID, 配置通配符
 * @apiParam {Number} dpd_enable  对等体状态探测
 * @apiParam {Number} dpd_timeout  DPD超时时间
 * @apiParam {Number} dpd_interval  DPD发送间隔
 * @apiParam {Number} xauth_enable  扩展认证
 * @apiParam {String} usergroup  无意义
 * @apiParam {Number} modecfg_enable  模式配置
 * @apiParam {String} modecfg_ippool_startip  模式配置地址池,开始IP
 * @apiParam {String} modecfg_ippool_endip  模式配置地址池,结束IP
 * @apiParam {Number} modecfg_ippool_mask  模式配置地址池,掩码
 * @apiParam {String} modecfg_ippool_addrobj  模式配置地址池,地址池对象
 * @apiParam {String} modecfg_subnet  模式配置地址池,子网
 * @apiParam {String} modecfg_dns  拨号用户DNS
 * @apiParam {String} modecfg_wins  拨号用户WINS
 * @apiParam {Array} ike  ikev2使用, 包括加密算法、认证算法、DH组

 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "phase1",
 *		"peer": "0",
 *		"address": "192.168.0.200",
 *		"domain": "0",
 *		"auth_method": "1",
 *		"ikev2": "1",
 *		"pre_key": "234567",
 *		"local_cert": "",
 *		"ca_cert": "",
 *		"mode": "0",
 *		"dh_group": "5",
 *		"lifetime": "86400",
 *		"nat_keepalive": "10",
 *		"local_addr": "",
 *		"local_id_fqdn": "",
 *		"local_id_user_fqdn": "",
 *		"peer_id_fqdn": "",
 *		"peer_id_user_fqdn": "",
 *		"vrf_name": "vrf0",
 *		"match_ip": "",
 *		"peer_id_wildcard": "",
 *		"dpd_enable": "0",
 *		"dpd_timeout": "",
 *		"dpd_interval": "",
 *		"xauth_enable": "",
 *		"usergroup": "",
 *		"modecfg_enable": "",
 *		"modecfg_ippool_startip": "",
 *		"modecfg_ippool_endip": "",
 *		"modecfg_ippool_mask": "",
 *		"modecfg_ippool_addrobj": "",
 *		"modecfg_subnet": "",
 *		"modecfg_dns": "",
 *		"modecfg_wins": "",
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
 * @api {PUT}  /api/ipsec-ike 修改ipsec一阶段配置信息
 * @apiName 修改ipsec一阶段配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} name  一阶段名称
 * @apiParam {Number} peer  对端网关类型,0-静态 1-动态 2-DNS
 * @apiParam {String} address  如果peer类型为静态,则此字段为对端网关IP地址
 * @apiParam {String} domain  无意义
 * @apiParam {Number} auth_method  一阶段认证方式, 1-预共享秘钥 2-证书认证
 * @apiParam {Number} ikev2  一阶段版本类型, 0-ikev1 1-ikev2
 * @apiParam {String} pre_key  预共享秘钥
 * @apiParam {String} local_cert  证书名称
 * @apiParam {String} ca_cert  一阶段根证书
 * @apiParam {Number} mode  一阶段模式, 0-主模式 1-野蛮模式, 此模式配置只针对ikev1有效
 * @apiParam {Number} dh_group  DH组, 1/2/5
 * @apiParam {Number} lifetime  一阶段SA生命周期,120-86400
 * @apiParam {Number} nat_keepalive  NAT穿越连接频率, 10-900 秒
 * @apiParam {String} local_addr  本地ID, IP地址
 * @apiParam {String} local_id_fqdn  本地ID, FQDN
 * @apiParam {String} local_id_user_fqdn  本地ID, USER-FQDN
 * @apiParam {String} peer_id_fqdn  对端ID, FQDN
 * @apiParam {String} peer_id_user_fqdn  对端ID, USER-FQDN
 * @apiParam {String} vrf_name  一阶段所属VRF名称
 * @apiParam {String} match_ip  匹配地址, 只有匹配此地址的对端才能建立一阶段连接
 * @apiParam {Number} peer_id_wildcard  对端ID, 配置通配符
 * @apiParam {Number} dpd_enable  对等体状态探测
 * @apiParam {Number} dpd_timeout  DPD超时时间
 * @apiParam {Number} dpd_interval  DPD发送间隔
 * @apiParam {Number} xauth_enable  扩展认证
 * @apiParam {String} usergroup  无意义
 * @apiParam {Number} modecfg_enable  模式配置
 * @apiParam {String} modecfg_ippool_startip  模式配置地址池,开始IP
 * @apiParam {String} modecfg_ippool_endip  模式配置地址池,结束IP
 * @apiParam {Number} modecfg_ippool_mask  模式配置地址池,掩码
 * @apiParam {String} modecfg_ippool_addrobj  模式配置地址池,地址池对象
 * @apiParam {String} modecfg_subnet  模式配置地址池,子网
 * @apiParam {String} modecfg_dns  拨号用户DNS
 * @apiParam {String} modecfg_wins  拨号用户WINS
 * @apiParam {Array} ike  ikev2使用, 包括加密算法、认证算法、DH组
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "phase1",
 *		"peer": "0",
 *		"address": "192.168.0.200",
 *		"domain": "0",
 *		"auth_method": "1",
 *		"ikev2": "1",
 *		"pre_key": "555555",
 *		"local_cert": "",
 *		"ca_cert": "",
 *		"mode": "0",
 *		"dh_group": "5",
 *		"lifetime": "86400",
 *		"nat_keepalive": "10",
 *		"local_addr": "",
 *		"local_id_fqdn": "",
 *		"local_id_user_fqdn": "",
 *		"peer_id_fqdn": "",
 *		"peer_id_user_fqdn": "",
 *		"vrf_name": "vrf0",
 *		"match_ip": "",
 *		"peer_id_wildcard": "",
 *		"dpd_enable": "0",
 *		"dpd_timeout": "",
 *		"dpd_interval": "",
 *		"xauth_enable": "",
 *		"usergroup": "",
 *		"modecfg_enable": "",
 *		"modecfg_ippool_startip": "",
 *		"modecfg_ippool_endip": "",
 *		"modecfg_ippool_mask": "",
 *		"modecfg_ippool_addrobj": "",
 *		"modecfg_subnet": "",
 *		"modecfg_dns": "",
 *		"modecfg_wins": "",
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
 * @api {DELETE}  /api/ipsec-ike 删除ipsec一阶段配置信息
 * @apiName 删除ipsec一阶段配置信息
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {String} name  一阶段名称
 * @apiParam {Number} ikev2  一阶段版本类型, 0-ikev1 1-ikev2
 * @apiParam {String} vrf_name  一阶段所属VRF名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "phase1",
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
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


class IpsecIKEController extends mController{
	public $module = 'vpn_ike';
}

?>
