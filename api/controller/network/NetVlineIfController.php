<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interfaces-trunk 获取trunk接口信息
 * @apiName 获取trunk接口信息
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  接口名称（同别名）
 * @apiSuccess {Number} id  接口id
 * @apiSuccess {Number} shut  接口管理状态
 * @apiSuccess {Array} if_list  成员接口（接入该trunk的接口）
 * @apiSuccess {Number} https  接口访问控制，控制接口能否被 https 的方式访问
 * @apiSuccess {Number} http  接口访问控制，控制接口能否被 http 的方式访问
 * @apiSuccess {Number} telnet  接口访问控制，控制接口能否被 telnet 的方式访问
 * @apiSuccess {Number} ping  接口访问控制，控制接口能否被 ping
 * @apiSuccess {Number} ssh  接口访问控制，控制接口能否被 ssh 的方式访问
 * @apiSuccess {Number} bgp  接口访问控制，控制接口能否被 bqp 的方式访问
 * @apiSuccess {Number} ospf  接口访问控制，控制接口能否被 ospf 的方式访问
 * @apiSuccess {Number} rip  接口访问控制，控制接口能否被 rip 的方式访问
 * @apiSuccess {Number} dns  接口访问控制，控制接口能否被 dns 的方式访问
 * @apiSuccess {Number} tctrl  接口访问控制，控制接口能否被 tctrl 的方式访问(未使用)
 * @apiSuccess {Number} cen_monitor  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} l2tp  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} sslvpn  接口访问控制，控制接口能否被 sslvpn 的方式访问（未使用）
 * @apiSuccess {Number} webauth  接口访问控制，控制接口能否被 webauth 的方式访问
 * @apiSuccess {Number} linkage  接口访问控制，控制接口能否被 linkage 的方式访问（未使用）
 * @apiSuccess {Number} count  接口被使用标志（1：接口被引用）
 * @apiSuccess {Number} get_type  想要获取的接口类型（未使用）
 * @apiSuccess {Number} mode  是否开启LACP模式
 * @apiSuccess {Number} loadbalance  未使用）
 * @apiSuccess {Number} mtu  接口设置的mtu大小
 * @apiSuccess {Number} external  接口内/外网口属性
 * @apiSuccess {Array} sec_ip  辅助IP地址（未使用）
 * @apiSuccess {Array} tb_interface_ip  接口上配置/获取到的IP地址
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "test",
 *			"group_num": "0",
 *			"shut": "0",
 *			"if_list": "{"group": [{"ifname": "ge0/4"}, {"ifname": "ge0/3"}]}",
 *			"https": "",
 *			"http": "",
 *			"telnet": "",
 *			"ping": "",
 *			"ssh": "",
 *			"bgp": "",
 *			"ospf": "",
 *			"rip": "",
 *			"dns": "",
 *			"tctrl": "",
 *			"cen_monitor": "",
 *			"l2tp": "",
 *			"sslvpn": "",
 *			"webauth": "",
 *			"linkage": "",
 *			"count": "0",
 *			"mode": "0",
 *			"mtu": "1500",
 *			"external": "0",
 *			"tb_interface_ip": ""
 *		},
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {POST}  /api/interfaces-trunk 新建trunk接口
 * @apiName 根据传入的接口名，id和其他参数，创建并配置trunk接口
 * @apiGroup 接口配置
 *
 *
* @apiSuccess {String} name  接口名称（别名）
 * @apiSuccess {Number} id  接口id
 * @apiSuccess {Number} shut  接口管理状态
 * @apiSuccess {Array} if_list  成员接口（接入该trunk的接口）
 * @apiSuccess {Number} https  接口访问控制，控制接口能否被 https 的方式访问
 * @apiSuccess {Number} http  接口访问控制，控制接口能否被 http 的方式访问
 * @apiSuccess {Number} telnet  接口访问控制，控制接口能否被 telnet 的方式访问
 * @apiSuccess {Number} ping  接口访问控制，控制接口能否被 ping
 * @apiSuccess {Number} ssh  接口访问控制，控制接口能否被 ssh 的方式访问
 * @apiSuccess {Number} bgp  接口访问控制，控制接口能否被 bqp 的方式访问
 * @apiSuccess {Number} ospf  接口访问控制，控制接口能否被 ospf 的方式访问
 * @apiSuccess {Number} rip  接口访问控制，控制接口能否被 rip 的方式访问
 * @apiSuccess {Number} dns  接口访问控制，控制接口能否被 dns 的方式访问
 * @apiSuccess {Number} tctrl  接口访问控制，控制接口能否被 tctrl 的方式访问(未使用)
 * @apiSuccess {Number} cen_monitor  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} l2tp  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} sslvpn  接口访问控制，控制接口能否被 sslvpn 的方式访问（未使用）
 * @apiSuccess {Number} webauth  接口访问控制，控制接口能否被 webauth 的方式访问
 * @apiSuccess {Number} linkage  接口访问控制，控制接口能否被 linkage 的方式访问（未使用）
 * @apiSuccess {Number} count  接口被使用标志（1：接口被引用）
 * @apiSuccess {Number} get_type  想要获取的接口类型（未使用）
 * @apiSuccess {Number} mode  是否开启LACP模式
 * @apiSuccess {Number} loadbalance  （未使用）
 * @apiSuccess {Number} mtu  接口设置的mtu大小
 * @apiSuccess {Number} external  接口内/外网口属性
 * @apiSuccess {Array} sec_ip  辅助IP地址（未使用）
 * @apiSuccess {Array} tb_interface_ip  接口上配置/获取到的IP地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test2",
 *		"group_num": "2",
 *		"shut": "1",
 *		"if_list": "<group><ifname>ge0/2</ifname></group>",
 *		"https": "1",
 *		"http": "1",
 *		"telnet": "0",
 *		"ping": "0",
 *		"ssh": "0",
 *		"bgp": "0",
 *		"ospf": "0",
 *		"rip": "0",
 *		"dns": "0",
 *		"sslvpn": "1",
 *		"webauth": "1",
 *		"linkage": "1",
 *		"mode": "1",
 *		"mtu": "1500",
 *		"external": "1",
 *		"tb_interface_ip": ""
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
 *		"code":"441",
 *		"str":"Trunk组号与其他Trunk组冲突"
 *	}
 *
 */

/**
 * @api {PUT}  /api/interfaces-trunk 根据传入的参数修改接口配置
 * @apiName 根据传入的参数修改接口配置
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  接口名称（别名）
 * @apiSuccess {Number} id  接口id
 * @apiSuccess {Number} shut  接口管理状态
 * @apiSuccess {Array} if_list  成员接口（接入该trunk的接口）
 * @apiSuccess {Number} https  接口访问控制，控制接口能否被 https 的方式访问
 * @apiSuccess {Number} http  接口访问控制，控制接口能否被 http 的方式访问
 * @apiSuccess {Number} telnet  接口访问控制，控制接口能否被 telnet 的方式访问
 * @apiSuccess {Number} ping  接口访问控制，控制接口能否被 ping
 * @apiSuccess {Number} ssh  接口访问控制，控制接口能否被 ssh 的方式访问
 * @apiSuccess {Number} bgp  接口访问控制，控制接口能否被 bqp 的方式访问
 * @apiSuccess {Number} ospf  接口访问控制，控制接口能否被 ospf 的方式访问
 * @apiSuccess {Number} rip  接口访问控制，控制接口能否被 rip 的方式访问
 * @apiSuccess {Number} dns  接口访问控制，控制接口能否被 dns 的方式访问
 * @apiSuccess {Number} tctrl  接口访问控制，控制接口能否被 tctrl 的方式访问(未使用)
 * @apiSuccess {Number} cen_monitor  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} l2tp  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} sslvpn  接口访问控制，控制接口能否被 sslvpn 的方式访问（未使用）
 * @apiSuccess {Number} webauth  接口访问控制，控制接口能否被 webauth 的方式访问
 * @apiSuccess {Number} linkage  接口访问控制，控制接口能否被 linkage 的方式访问（未使用）
 * @apiSuccess {Number} count  接口被使用标志（1：接口被引用）
 * @apiSuccess {Number} get_type  想要获取的接口类型（未使用）
 * @apiSuccess {Number} mode  是否开启LACP模式
 * @apiSuccess {Number} loadbalance  （未使用）
 * @apiSuccess {Number} mtu  接口设置的mtu大小
 * @apiSuccess {Number} external  接口内/外网口属性
 * @apiSuccess {Array} sec_ip  辅助IP地址（未使用）
 * @apiSuccess {Array} tb_interface_ip  接口上配置/获取到的IP地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test2",
 *		"group_num": "2",
 *		"shut": "1",
 *		"if_list": "",
 *		"https": "1",
 *		"http": "1",
 *		"telnet": "0",
 *		"ping": "0",
 *		"ssh": "0",
 *		"bgp": "0",
 *		"ospf": "0",
 *		"rip": "0",
 *		"dns": "0",
 *		"sslvpn": "1",
 *		"webauth": "1",
 *		"linkage": "1",
 *		"mode": "1",
 *		"mtu": "1500",
 *		"external": "1",
 *		"tb_interface_ip": ""
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
 *		"code":"35",
 *		"str":"地址与其它接口地址冲突"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/interfaces-trunk 删除接口
 * @apiName 根据传入的参数删除对应接口
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  接口名称（别名）
 * @apiSuccess {Number} id  接口id
 * @apiSuccess {Number} shut  接口管理状态
 * @apiSuccess {Array} if_list  成员接口（接入该trunk的接口）
 * @apiSuccess {Number} https  接口访问控制，控制接口能否被 https 的方式访问
 * @apiSuccess {Number} http  接口访问控制，控制接口能否被 http 的方式访问
 * @apiSuccess {Number} telnet  接口访问控制，控制接口能否被 telnet 的方式访问
 * @apiSuccess {Number} ping  接口访问控制，控制接口能否被 ping
 * @apiSuccess {Number} ssh  接口访问控制，控制接口能否被 ssh 的方式访问
 * @apiSuccess {Number} bgp  接口访问控制，控制接口能否被 bqp 的方式访问
 * @apiSuccess {Number} ospf  接口访问控制，控制接口能否被 ospf 的方式访问
 * @apiSuccess {Number} rip  接口访问控制，控制接口能否被 rip 的方式访问
 * @apiSuccess {Number} dns  接口访问控制，控制接口能否被 dns 的方式访问
 * @apiSuccess {Number} tctrl  接口访问控制，控制接口能否被 tctrl 的方式访问(未使用)
 * @apiSuccess {Number} cen_monitor  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} l2tp  接口访问控制，控制接口能否被 cen_monitor 的方式访问（未使用）
 * @apiSuccess {Number} sslvpn  接口访问控制，控制接口能否被 sslvpn 的方式访问（未使用）
 * @apiSuccess {Number} webauth  接口访问控制，控制接口能否被 webauth 的方式访问
 * @apiSuccess {Number} linkage  接口访问控制，控制接口能否被 linkage 的方式访问（未使用）
 * @apiSuccess {Number} count  接口被使用标志（1：接口被引用）
 * @apiSuccess {Number} get_type  想要获取的接口类型（未使用）
 * @apiSuccess {Number} mode  是否开启LACP模式
 * @apiSuccess {Number} loadbalance  （未使用）
 * @apiSuccess {Number} mtu  接口设置的mtu大小
 * @apiSuccess {Number} external  接口内/外网口属性
 * @apiSuccess {Array} sec_ip  辅助IP地址（未使用）
 * @apiSuccess {Array} tb_interface_ip  接口上配置/获取到的IP地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test2",
 *		"group_num": "2"
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
 *		"code":"611",
 *		"str":"接口被vlan untagged 引用"
 *	}
 *
 */


class NetVlineIfController extends mController{
	public $module = 'net_vline_if';
}

?>
