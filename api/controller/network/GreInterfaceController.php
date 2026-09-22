<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/gre-interface 获取gre接口列表，传入参数为name时，获取对应的接口具体信息
 * @apiName 获取gre接口列表
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  gre接口名称 ，范围（1-63）
 * @apiSuccess {Number} gre_num  gre接口id ，范围（0-2047）
 * @apiSuccess {String} desc  gre接口描述，不支持配置 
 * @apiSuccess {String} ipaddr  gre接口地址 
 * @apiSuccess {String} source  gre隧道源IP/源接口 
 * @apiSuccess {String} dst_ip  gre隧道目的IP 
 * @apiSuccess {Number} source_type  源类型（接口：0；ip：1） 
 * @apiSuccess {Number} dymatic  标识目的地址类型是否为dymatic（是：1，否0） 
 * @apiSuccess {String} source_if  隧道源接口名 
 * @apiSuccess {Number} tunnel_id  隧道标识，范围（1-9999）
 * @apiSuccess {Number} keep_alive  keepalive报文间隔时间，单位秒，范围（1-86400）
 * @apiSuccess {Number} ttl  生存时间值，范围（0-255）
 * @apiSuccess {Number} mtu  mtu， 范围（1280-1420）
 * @apiSuccess {Number} shut  接口管理状态(1:管理down;0:管理up)，未使用
 * @apiSuccess {Number} get_type  获取接口类型（该模块中未使用）
 * @apiSuccess {Number} count  标识接口是否被引用（该模块中未使用）
 * @apiSuccess {Number} https  接口访问限制，能否以 https 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} http  接口访问限制，能否以 http 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} telnet  接口访问限制，能否以 telnet 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} ping  接口访问限制，能否以 ping 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} ssh  接口访问限制，能否以 ssh 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} cen_monitor  接口访问限制，能否以 cen_monitor 的形式访问（该模块中未使用）
 * @apiSuccess {Number} l2tp  接口访问限制，能否以 l2tp 的形式访问（该模块中未使用）
 * @apiSuccess {Number} sslvpn  接口访问限制，能否以 sslvpn 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} webauth  接口访问限制，能否以 webauth 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} linkage  接口访问限制，能否以linkage的形式访问（该模块中未使用）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "gre0",
 *			"gre_num": "0",
 *			"ipaddr": "10.1.1.10/24",
 *			"source": "20.1.1.10",
 *			"dst_ip": "20.1.1.20",
 *			"source_type": "1",
 *			"dymatic": "0",
 *			"tunnel_id": "",
 *			"keep_alive": "",
 *			"ttl": "0",
 *			"shut": "0",
 *			"count": "0"
 *		},
 *		{
 *			"name": "gre1",
 *			"gre_num": "1",
 *			"ipaddr": "30.1.1.10/24",
 *			"dst_ip": "DYNAMIC",
 *			"source_type": "0",
 *			"dymatic": "1",
 *			"source_if": "vlan1",
 *			"tunnel_id": "111",
 *			"keep_alive": "11",
 *			"ttl": "0",
 *			"shut": "1",
 *			"count": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/gre-interface 根据传入的参数创建gre隧道接口
 * @apiName  创建gre隧道接口
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  gre接口名称 ，范围（1-63），必选
 * @apiSuccess {Number} gre_num  gre接口id ，范围（1-2047），必选
 * @apiSuccess {String} desc  gre接口描述，不支持配置 
 * @apiSuccess {String} ipaddr  gre接口地址 
 * @apiSuccess {String} source  gre隧道源IP/源接口 ，
 * @apiSuccess {String} dst_ip  gre隧道目的IP 
 * @apiSuccess {Number} source_type  源类型（接口：0；ip：1） 
 * @apiSuccess {Number} dymatic  标识目的地址类型是否为dymatic（是：1，否0） 
 * @apiSuccess {String} source_if  隧道源接口名 
 * @apiSuccess {Number} tunnel_id  隧道标识，范围（1-9999）
 * @apiSuccess {Number} keep_alive  keepalive报文间隔时间，单位秒，范围（1-86400）
 * @apiSuccess {Number} ttl  生存时间值，范围（0-255）
 * @apiSuccess {Number} mtu  mtu， 范围（1280-1420）
 * @apiSuccess {Number} shut  接口管理状态(1:管理down;0:管理up)，未使用
 * @apiSuccess {Number} get_type  获取接口类型（该模块中未使用）
 * @apiSuccess {Number} count  标识接口是否被引用（该模块中未使用）
 * @apiSuccess {Number} https  接口访问限制，能否以 https 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} http  接口访问限制，能否以 http 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} telnet  接口访问限制，能否以 telnet 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} ping  接口访问限制，能否以 ping 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} ssh  接口访问限制，能否以 ssh 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} cen_monitor  接口访问限制，能否以 cen_monitor 的形式访问（该模块中未使用）
 * @apiSuccess {Number} l2tp  接口访问限制，能否以 l2tp 的形式访问（该模块中未使用）
 * @apiSuccess {Number} sslvpn  接口访问限制，能否以 sslvpn 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} webauth  接口访问限制，能否以 webauth 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} linkage  接口访问限制，能否以linkage的形式访问（该模块中未使用）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "g3",
 *		"gre_num": "3",
 *		"ipaddr": "50.1.1.10/24",
 *		"dst_ip": "110.1.1.10",
 *		"source_type": "0",
 *		"dymatic": "0",
 *		"source_if": "tunl0",
 *		"tunnel_id": "12",
 *		"keep_alive": "20",
 *		"ttl": "5",
 *		"shut": "0"
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
 *		"code":"84" //接口已存在
 *	}
 *
 */

/**
 * @api {PUT}  /api/gre-interface 修改gre接口配置（对应mod）
 * @apiName 修改接口配置
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  gre接口名称，范围（1-63），（不可修改）
 * @apiSuccess {Number} gre_num  gre接口id  ，，范围（1-2047），（不可修改）
 * @apiSuccess {String} desc  gre接口描述，不支持配置 
 * @apiSuccess {String} ipaddr  gre接口地址 
 * @apiSuccess {String} source  gre隧道源IP/源接口 
 * @apiSuccess {String} dst_ip  gre隧道目的IP 
 * @apiSuccess {Number} source_type  源类型（接口：0；ip：1） 
 * @apiSuccess {Number} dymatic  标识目的地址类型是否为dymatic（是：1，否0） 
 * @apiSuccess {String} source_if  隧道源接口名 
 * @apiSuccess {Number} tunnel_id  隧道标识，范围（1-9999）
 * @apiSuccess {Number} keep_alive  keepalive报文间隔时间，单位秒，范围（1-86400）
 * @apiSuccess {Number} ttl  生存时间值，范围（0-255）
 * @apiSuccess {Number} mtu  mtu， 范围（1280-1420）
 * @apiSuccess {Number} shut  接口管理状态(1:管理down;0:管理up)，未使用
 * @apiSuccess {Number} get_type  获取接口类型（该模块中未使用）
 * @apiSuccess {Number} count  标识接口是否被引用（该模块中未使用）
 * @apiSuccess {Number} https  接口访问限制，能否以 https 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} http  接口访问限制，能否以 http 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} telnet  接口访问限制，能否以 telnet 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} ping  接口访问限制，能否以 ping 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} ssh  接口访问限制，能否以 ssh 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} cen_monitor  接口访问限制，能否以 cen_monitor 的形式访问（该模块中未使用）
 * @apiSuccess {Number} l2tp  接口访问限制，能否以 l2tp 的形式访问（该模块中未使用）
 * @apiSuccess {Number} sslvpn  接口访问限制，能否以 sslvpn 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} webauth  接口访问限制，能否以 webauth 的形式访问（1，启用；0，关闭）
 * @apiSuccess {Number} linkage  接口访问限制，能否以linkage的形式访问（该模块中未使用）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "g3",
 *		"gre_num": "3",
 *		"ipaddr": "40.1.1.10/24",
 *		"dst_ip": "110.1.1.10",
 *		"source_type": "0",
 *		"dymatic": "0",
 *		"source_if": "tunl0",
 *		"tunnel_id": "12",
 *		"keep_alive": "20",
 *		"ttl": "5",
 *		"shut": "0"
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
 *		"code":"35"  //接口地址与其他地址冲突
 *	}
 *
 */

/**
 * @api {DELETE}  /api/gre-interface 根据传入的接口名称和gre_num，删除对应的gre隧道接口。
 * @apiName gre接口删除
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  gre接口名称
 * @apiSuccess {Number} gre_num  gre接口id  ，范围（1-2047）（必填项）
 * @apiSuccess {String} desc  gre接口描述，不支持配置 
 * @apiSuccess {String} ipaddr  gre接口地址 
 * @apiSuccess {String} source  gre隧道源IP/源接口 
 * @apiSuccess {String} dst_ip  gre隧道目的IP 
 * @apiSuccess {Number} source_type  源类型（接口：0；ip：1） 
 * @apiSuccess {Number} dymatic  标识目的地址类型是否为dymatic（是：1，否0） 
 * @apiSuccess {String} source_if  隧道源接口名 
 * @apiSuccess {Number} tunnel_id  隧道标识
 * @apiSuccess {Number} keep_alive  keepalive报文间隔时间，单位秒
 * @apiSuccess {Number} ttl  生存时间值
 * @apiSuccess {Number} shut  接口管理状态(1:管理down;0:管理up)，未使用
 * @apiSuccess {Number} get_type  获取接口类型（该模块中未使用）
 * @apiSuccess {Number} count  标识接口是否被引用（该模块中未使用）
 * @apiSuccess {Number} https  接口访问限制，能否以 https 的形式访问（该模块中未使用）
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问（该模块中未使用）
 * @apiSuccess {Number} telnet  接口访问限制，能否以 telnet 的形式访问（该模块中未使用）
 * @apiSuccess {Number} ping  接口访问限制，能否以 ping 的形式访问（该模块中未使用）
 * @apiSuccess {Number} ssh  接口访问限制，能否以 ssh 的形式访问（该模块中未使用）
 * @apiSuccess {Number} cen_monitor  接口访问限制，能否以 cen_monitor 的形式访问（该模块中未使用）
 * @apiSuccess {Number} l2tp  接口访问限制，能否以 l2tp 的形式访问（该模块中未使用）
 * @apiSuccess {Number} sslvpn  接口访问限制，能否以 sslvpn 的形式访问（该模块中未使用）
 * @apiSuccess {Number} webauth  接口访问限制，能否以 webauth 的形式访问（该模块中未使用）
 * @apiSuccess {Number} linkage  接口访问限制，能否以linkage的形式访问（该模块中未使用）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "gre0",
 *		"gre_num": "0"
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
 *		"code":"XXX",
 *		"str":"XXX"
 *	}
 *
 */


class GreInterfaceController extends mController{
	public $module = 'gre_interface';
}

?>
