<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interfaces-vlan 获取vlan接口信息
 * @apiName 根据传入的参数，获取vlan接口信息，如果没有参数传入则获取所有vlan接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} vlan_name  vlan接口名称，范围（1-63）
 * @apiSuccess {Number} vlan_tag  vlan接口id，范围（1-4094）
 * @apiSuccess {Number} mtu  mtu，范围（1280-1500）
 * @apiSuccess {Number} count  XXX 此处替换为对count 的中文注释
 * @apiSuccess {Number} shut  接口管理状态（1，关闭；0，开启）
 * @apiSuccess {Number} stp_enable  是否开启stp功能（1，开启；0，关闭）
 * @apiSuccess {Number} stp_bridge_priority  桥优先级，范围（0-61440）
 * @apiSuccess {Number} stp_hello_time  hello时间，范围（2-10）
 * @apiSuccess {Number} stp_max_age  老化时间，范围（6-40）
 * @apiSuccess {Number} port_forward_delay  端口状态延时，范围（4-30）
 * @apiSuccess {Number} address_type  接口地址类型
 * @apiSuccess {Number} status  接口状态，0：接口down，1：接口up
 * @apiSuccess {Number} ifvsysid  接口所属VSYS
 * @apiSuccess {Number} vsysid_same  接口所属VSYS与当前VSYS是否相同
 * @apiSuccess {Number} ip_set_ability  接口能力
 * @apiSuccess {String} ifname  接口名称
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问
 * @apiSuccess {Number} https  接口访问控制，能否以 https 的形式访问
 * @apiSuccess {Number} ping  接口访问控制，能否以 ping 的形式访问
 * @apiSuccess {Number} telnet  接口访问控制，能否以 telnet 的形式访问
 * @apiSuccess {Number} ssh  接口访问控制，能否以 ssh 的形式访问
 * @apiSuccess {Number} sslvpn  接口访问控制，能否以 sslvpn 的形式访问
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问
 * @apiSuccess {Number} webauth  接口访问控制，能否以 webauth 的形式访问
 * @apiSuccess {Number} linkage  接口访问控制，能否以 linkage 的形式访问
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问
 * @apiSuccess {Number} tctrl  接口访问控制，能否以 tctrl 的形式访问
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问
 * @apiSuccess {Number} vid_transparent  是否开启vlan透传
 * @apiSuccess {Array} tagged_if_list  以tag模式加入vlan的接口列表
 * @apiSuccess {Array} untagged_if_list  以untag模式
 * @apiSuccess {Array} tb_interface_ip  接口ip地址，group形式
 * @apiSuccess {String} tb_ip  接口实际ip地址
 * @apiSuccess {Number} is_floating_ip  是否float型
 * @apiSuccess {Number} tb_ip_version  IP地址版本，4：IPv4地址，6：IPv6地址 
 * @apiSuccess {Number} unit_id  unit id
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vlan_name": "vlan3",
 *			"vlan_tag": "3",
 *			"mtu": "1500",
 *			"count": "0",
 *			"shut": "0",
 *			"stp_enable": "1",
 *			"stp_bridge_priority": "333",
 *			"stp_hello_time": "4",
 *			"stp_max_age": "5",
 *			"port_forward_delay": "20",
 *			"address_type": "1",
 *			"http": "1",
 *			"https": "1",
 *			"ping": "1",
 *			"telnet": "1",
 *			"ssh": "1",
 *			"sslvpn": "1",
 *			"bgp": "1",
 *			"ospf": "1",
 *			"rip": "1",
 *			"dns": "1",
 *			"tctrl": "1",
 *			"webauth": "1",
 *			"linkage": "1",
 *			"external": "1",
 *			"vid_transparent": "0",
 *			"tagged_if_list": ""group": {"ifname": "ge0/2"}",
 *			"untagged_if_list": "",
 *			"tb_interface_ip": ""group": {"is_floating_ip": "0", "tb_ip_version": "4", "unit_id": "0", "tb_ip": "20.1.1.10/24"}"
 *		},
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/interfaces-vlan 新建vlan接口
 * @apiName 根据传入的参数，新建并配置vlan接口
 * @apiGroup 接口配置
 *
 *
 * @apiParam {String} vlan_name  vlan接口名称，范围（1-63），必填项
 * @apiParam {Number} vlan_tag  vlan接口id，范围（1-4094），必填项
 * @apiParam {Number} mtu  mtu，范围（1280-1500）
 * @apiParam {Number} count  XXX 此处替换为对count 的中文注释
 * @apiParam {Number} shut  接口管理状态（1，关闭；0，开启）
 * @apiParam {Number} stp_enable  是否开启stp功能（1，开启；0，关闭）
 * @apiParam {Number} stp_bridge_priority  桥优先级，范围（0-61440）
 * @apiParam {Number} stp_hello_time  hello时间，范围（1-10）
 * @apiParam {Number} stp_max_age  老化时间，范围（6-40）
 * @apiParam {Number} port_forward_delay  端口状态延时，范围（4-30）
 * @apiParam {Number} address_type  接口地址类型，（1，静态；2，dhcp；3， pppoe），未使用
 * @apiParam {Number} status  接口状态，0：接口down，1：接口up
 * @apiParam {Number} ifvsysid  接口所属VSYS
 * @apiParam {Number} vsysid_same  接口所属VSYS与当前VSYS是否相同
 * @apiParam {Number} ip_set_ability  接口能力
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} http  接口访问控制，能否以 http 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} https  接口访问控制，能否以 https 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} ping  接口访问控制，能否以 ping 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} telnet  接口访问控制，能否以 telnet 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} ssh  接口访问控制，能否以 ssh 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} sslvpn  接口访问控制，能否以 sslvpn 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} webauth  接口访问控制，能否以 webauth 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} linkage  接口访问控制，能否以 linkage 的形式访问（1，开启；0，关闭），未使用
 * @apiParam {Number} tctrl  接口访问控制，能否以 tctrl 的形式访问（1，开启；0，关闭），未使用
 * @apiParam {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} external  接口内外网口属性（1.外网口；0，内网口），未使用
 * @apiParam {Number} vid_transparent  是否开启vlan透传（1，开启；0，关闭）
 * @apiParam {Array} tagged_if_list  以tag模式加入vlan的接口列表（物理口，trunk）
 * @apiParam {Array} untagged_if_list  以untag模式，（物理口，trunk）
 * @apiParam {Array} tb_interface_ip  接口ip地址，group形式
 * @apiParam {String} tb_ip  接口实际ip地址
 * @apiParam {Number} is_floating_ip  是否float型（1，是；0， 否）
 * @apiParam {Number} tb_ip_version  IP地址版本，4：IPv4地址，6：IPv6地址 
 * @apiParam {Number} unit_id  unit id（为空，1, 2）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		
 *			"vlan_name": "vlan3",
 *			"vlan_tag": "3",
 *			"mtu": "1500",
 *			"count": "0",
 *			"shut": "0",
 *			"stp_enable": "1",
 *			"stp_bridge_priority": "333",
 *			"stp_hello_time": "4",
 *			"stp_max_age": "5",
 *			"port_forward_delay": "20",
 *			"address_type": "1",
 *			"http": "1",
 *			"https": "1",
 *			"ping": "1",
 *			"telnet": "1",
 *			"ssh": "1",
 *			"sslvpn": "1",
 *			"bgp": "1",
 *			"ospf": "1",
 *			"rip": "1",
 *			"dns": "1",
 *			"tctrl": "1",
 *			"webauth": "1",
 *			"linkage": "1",
 *			"external": "1",
 *			"vid_transparent": "0",
 *			"tagged_if_list": ""group": {"ifname": "ge0/2"}",
 *			"untagged_if_list": "",
 *			"tb_interface_ip": ""group": {"is_floating_ip": "0", "tb_ip_version": "4", "unit_id": "0", "tb_ip": "20.1.1.10/24"}"
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
 *		"code":"631" //vlan ID已被使用
 *	}
 *
 */

/**
 * @api {PUT}  /api/interfaces-vlan 修改接口配置
 * @apiName 根据传入的参数，修改接口对应的配置
 * @apiGroup 接口配置
 *
 *
 * @apiParam {String} vlan_name  vlan接口名称，范围（1-63），不可修改
 * @apiParam {Number} vlan_tag  vlan接口id，范围（1-4094），不可修改
 * @apiParam {Number} mtu  mtu，范围（1280-1500）
 * @apiParam {Number} count  XXX 此处替换为对count 的中文注释
 * @apiParam {Number} shut  接口管理状态（1，关闭；0，开启）
 * @apiParam {Number} stp_enable  是否开启stp功能（1，开启；0，关闭）
 * @apiParam {Number} stp_bridge_priority  桥优先级，范围（0-61440）
 * @apiParam {Number} stp_hello_time  hello时间，范围（1-10）
 * @apiParam {Number} stp_max_age  老化时间，范围（6-40）
 * @apiParam {Number} port_forward_delay  端口状态延时，范围（4-30）
 * @apiParam {Number} address_type  接口地址类型，（1，静态；2，dhcp；3， pppoe）
 * @apiParam {Number} status  接口状态，0：接口down，1：接口up
 * @apiParam {Number} ifvsysid  接口所属VSYS
 * @apiParam {Number} vsysid_same  接口所属VSYS与当前VSYS是否相同
 * @apiParam {Number} ip_set_ability  接口能力
 * @apiParam {String} ifname  接口名称
 * @apiParam {Number} http  接口访问控制，能否以 http 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} https  接口访问控制，能否以 https 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} ping  接口访问控制，能否以 ping 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} telnet  接口访问控制，能否以 telnet 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} ssh  接口访问控制，能否以 ssh 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} sslvpn  接口访问控制，能否以 sslvpn 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} webauth  接口访问控制，能否以 webauth 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} linkage  接口访问控制，能否以 linkage 的形式访问（1，开启；0，关闭），未使用
 * @apiParam {Number} tctrl  接口访问控制，能否以 tctrl 的形式访问（1，开启；0，关闭），未使用
 * @apiParam {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiParam {Number} external  接口内外网口属性（1.外网口；0，内网口），未使用
 * @apiParam {Number} vid_transparent  是否开启vlan透传（1，开启；0，关闭）
 * @apiParam {Array} tagged_if_list  以tag模式加入vlan的接口列表（物理口，trunk）
 * @apiParam {Array} untagged_if_list  以untag模式（物理口，trunk）
 * @apiParam {Array} tb_interface_ip  接口ip地址，group形式
 * @apiParam {String} tb_ip  接口实际ip地址
 * @apiParam {Number} is_floating_ip  是否float型（1，是；0， 否）
 * @apiParam {Number} tb_ip_version  IP地址版本，4：IPv4地址，6：IPv6地址 
 * @apiParam {Number} unit_id  unit id（为空，1, 2）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"vlan_name": "vlan3",
 *			"vlan_tag": "3",
 *			"mtu": "1500",
 *			"count": "0",
 *			"shut": "0",
 *			"stp_enable": "1",
 *			"stp_bridge_priority": "333",
 *			"stp_hello_time": "4",
 *			"stp_max_age": "5",
 *			"port_forward_delay": "20",
 *			"address_type": "1",
 *			"http": "1",
 *			"https": "1",
 *			"ping": "1",
 *			"telnet": "1",
 *			"ssh": "1",
 *			"sslvpn": "1",
 *			"bgp": "1",
 *			"ospf": "1",
 *			"rip": "1",
 *			"dns": "1",
 *			"tctrl": "1",
 *			"webauth": "1",
 *			"linkage": "1",
 *			"external": "1",
 *			"vid_transparent": "0",
 *			"tagged_if_list": ""group": {"ifname": "ge0/2"}",
 *			"untagged_if_list": "",
 *			"tb_interface_ip": ""group": {"is_floating_ip": "0", "tb_ip_version": "4", "unit_id": "0", "tb_ip": "20.1.1.10/24"}"
 *		},
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"1"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/interfaces-vlan 删除vlan接口
 * @apiName XXX 根据传入的vlan名称和id，将对应的vlan接口删除
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} vlan_name  vlan接口名称
 * @apiSuccess {Number} vlan_tag  vlan接口id，范围（1-4094），必填项
 * @apiSuccess {Number} mtu  mtu
 * @apiSuccess {Number} count  XXX 此处替换为对count 的中文注释
 * @apiSuccess {Number} shut  接口管理状态
 * @apiSuccess {Number} stp_enable  是否开启stp功能
 * @apiSuccess {Number} stp_bridge_priority  桥优先级
 * @apiSuccess {Number} stp_hello_time  hello时间
 * @apiSuccess {Number} stp_max_age  老化时间
 * @apiSuccess {Number} port_forward_delay  端口状态延时
 * @apiSuccess {Number} address_type  接口地址类型
 * @apiSuccess {String} pppoe_user  pppoe用户名
 * @apiSuccess {String} pppoe_passwd  pppoe密码
 * @apiSuccess {Number} pppoe_distance  pppoe管理距离
 * @apiSuccess {Number} pppoe_weight  pppoe权重
 * @apiSuccess {String} pppoe_specify_ip  pppoe指定ip
 * @apiSuccess {Number} pppoe_default_gate  pppoe是否从服务器重新获得网关
 * @apiSuccess {Number} pppoe_dns  是否改变内部DNS
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问
 * @apiSuccess {Number} https  接口访问控制，能否以 https 的形式访问
 * @apiSuccess {Number} ping  接口访问控制，能否以 ping 的形式访问
 * @apiSuccess {Number} telnet  接口访问控制，能否以 telnet 的形式访问
 * @apiSuccess {Number} ssh  接口访问控制，能否以 ssh 的形式访问
 * @apiSuccess {Number} sslvpn  接口访问控制，能否以 sslvpn 的形式访问
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问
 * @apiSuccess {Number} webauth  接口访问控制，能否以 webauth 的形式访问
 * @apiSuccess {Number} linkage  接口访问控制，能否以 linkage 的形式访问
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问
 * @apiSuccess {Number} external  接口内外网口属性
 * @apiSuccess {Number} vid_transparent  是否开启vlan透传
 * @apiSuccess {Array} tagged_if_list  以tag模式加入vlan的接口列表
 * @apiSuccess {Array} untagged_if_list  以untag模式
 * @apiSuccess {Array} tb_interface_ip  接口ip地址，group形式
 * @apiSuccess {String} tb_ip  接口实际ip地址
 * @apiSuccess {Number} is_floating_ip  是否float型
 * @apiSuccess {Number} unit_id  unit id
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"vlan_name": "vlan3",
 *		"vlan_tag": "3"
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
 *		"code":"1"
 *	}
 *
 */


class InterfaceVlanController extends mController{
	public $module = 'tb_vlan';
}

?>
