<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interfaces 获取接口信息
 * @apiName 根据传入的接口名称获取接口信息，不传入则显示所有需要的接口
 * @apiGroup 接口配置
 *
 * @apiSuccess {Number} type  接口类型，已不使用
 * @apiSuccess {String} name  接口名称，范围（1-63）
 * @apiSuccess {String} real_name  接口实际名称（一般和name一样）
 * @apiSuccess {String} alias_name  接口别名，范围（1-63）
 * @apiSuccess {Number} vlan_id  子接口属于哪个vlan的标识（未使用）
 * @apiSuccess {String} vlan_phy_if  标识子接口的主接口名称（未使用）
 * @apiSuccess {String} vsys_name  vsys名称，标识属于哪个vsys（暂未使用）
 * @apiSuccess {String} desc  接口描述（未使用）
 * @apiSuccess {Number} address_type  接口IP地址类型：0，未配置；1：静态IP；2：dhcp；3：pppoe
 * @apiSuccess {String} ipaddr  接口地址，不使用
 * @apiSuccess {Number} dhcp_distance  dhcp优先级， 范围（1-255）
 * @apiSuccess {Number} dhcp_default_gate  1：更新网关；0：默认网关
 * @apiSuccess {Number} dhcp_dns  1，更新DNS；0：默认dns
 * @apiSuccess {String} pppoe_user  pppoe用户名， 范围（1-63）
 * @apiSuccess {String} pppoe_passwd  pppoe密码， 范围（6-31）
 * @apiSuccess {Number} pppoe_distance  pppoe管理距离， 范围（1-255）
 * @apiSuccess {Number} pppoe_weight  pppoe权重， 范围（1-100）
 * @apiSuccess {String} pppoe_specify_ip  pppoe指定ip地址
 * @apiSuccess {Number} pppoe_default_gate  从服务器中重新获取网关（1，开启；0，关闭）
 * @apiSuccess {Number} pppoe_dns  改变内部DNS（1，改变；0，不改变）
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} https  接口访问控制，能否以 https 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} telnet  接口访问控制，能否以 telnet 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ping  接口访问控制，接口能否被ping通（1，开启；0，关闭）
 * @apiSuccess {Number} ssh  接口访问控制，能否以 ssh 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} tctrl  接口访问控制（1，开启；0，关闭），不使用
 * @apiSuccess {Number} l2tp  不使用
 * @apiSuccess {Number} sslvpn  接口访问控制（1，开启；0，关闭）（1，开启；0，关闭）
 * @apiSuccess {Number} linkage  接口访问控制（1，开启；0，关闭）
 * @apiSuccess {Number} bind_if_enable  不使用
 * @apiSuccess {Number} bind_type  不使用
 * @apiSuccess {String} if_name  不使用
 * @apiSuccess {String} monitor_addr  monitor_addr
 * @apiSuccess {Number} negotiate  物理接口自协商状态（1，关闭；0，开启）
 * @apiSuccess {Number} half  物理接口双工状态（1，全双工；0，半双工）
 * @apiSuccess {Number} speed  物理接口速率，范围（10， 100， 1000）
 * @apiSuccess {Number} mtu  mtu， 范围（1280-1500）
 * @apiSuccess {Number} if_bandwidth  不使用
 * @apiSuccess {String} haipaddr  不使用
 * @apiSuccess {Number} shut  接口up/down管理状态（1， 关闭； 0， 开启）
 * @apiSuccess {Number} max_speed  接口能支持的最大速率，不使用
 * @apiSuccess {Number} webauth  接口访问控制，能否以 webauth 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} cen_monitor  接口访问控制，能否以 cen_monitor 的形式访问，不使用
 * @apiSuccess {Number} mgmt_flag  标注是否mgt接口，不使用
 * @apiSuccess {Number} external  接口内外网口状态（1，外网口；0，内网口）
 * @apiSuccess {Number} get_type  想要获取的接口类型，不使用
 * @apiSuccess {Array} sec_ip  辅助ip，不使用
 * @apiSuccess {Array} tb_interface_ip  接口ip地址，可能有多个
 * @apiSuccess {Array} hw_addr  接口MAC地址
 * @apiSuccess {Array} vlan_count  接口被vlan引用的次数
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "mgt",
 *			"real_name": "mgt",
 *			"alias_name": "mgt",
 *			"address_type": "1",
 *			"http": "1",
 *			"https": "1",
 *			"telnet": "1",
 *			"ping": "1",
 *			"ssh": "1",
 *			"bgp": "1",
 *			"ospf": "1",
 *			"rip": "1",
 *			"dns": "1",
 *			"tctrl": "1",
 
 *			"sslvpn": "1",
 *			"linkage": "1",




 *			"negotiate": "0",
 *			"half": "FULL",
 *			"speed": "XXX",
 *			"mtu": "1500",
 *			"shut": "0",
 *			"webauth": "1",
 *			"external": "0",
 *			"tb_interface_ip": "{"group": [{"is_floating_ip": "0", "tb_ip_version": "4", "unit_id": "0", "tb_ip": "172.16.0.158/16"}, {"is_floating_ip": "0", "tb_ip_version": "6", "unit_id": "0", "tb_ip": "3ffe:506::2/64"}]}"
 *		},
 *		{
 *			"name": "ge0/2",
 *			"real_name": "ge0/2",
 *			"alias_name": "ge0/2",
 *			"address_type": "3",
 *			"pppoe_user": "admin",
 *			"pppoe_passwd": "admin",
 *			"pppoe_distance": "2",
 *			"pppoe_weight": "1",
 *			"pppoe_specify_ip": "",
 *			"pppoe_default_gate": "1",
 *			"pppoe_dns": "1",
 *			"http": "",
 *			"https": "",
 *			"telnet": "",
 *			"ping": "",
 *			"ssh": "",
 *			"bgp": "",
 *			"ospf": "",
 *			"rip": "",
 *			"dns": "",
 *			"tctrl": "",
 *			"sslvpn": "",
 *			"linkage": "",
 *			"negotiate": "0",
 *			"half": "UNKNOWN",
 *			"speed": "UNKNOWN",
 *			"mtu": "1500",
 *			"shut": "0",
 *			"webauth": "",
 *			"external": "1",
 *			"tb_interface_ip": ""
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/interfaces 物理接口不支持新建
 * @apiName XXX 此处替换为对Post方法的解释
 * @apiGroup 接口配置
 */


/**
 * @api {PUT}  /api/interfaces 接口配置修改
 * @apiName 根据传入的接口参数，修改接口配置
 * @apiGroup 接口配置
 *
 * @apiSuccess {Number} type  接口类型，已不使用
 * @apiSuccess {String} name  接口名称，范围（1-63）
 * @apiSuccess {String} real_name  接口实际名称（一般和name一样）
 * @apiSuccess {String} alias_name  接口别名，范围（1-63）
 * @apiSuccess {Number} vlan_id  子接口属于哪个vlan的标识（未使用）
 * @apiSuccess {String} vlan_phy_if  标识子接口的主接口名称（未使用）
 * @apiSuccess {String} vsys_name  vsys名称，标识属于哪个vsys（暂未使用）
 * @apiSuccess {String} desc  接口描述（未使用）
 * @apiSuccess {Number} address_type  接口IP地址类型：0，未配置；1：静态IP；2：dhcp；3：pppoe
 * @apiSuccess {String} ipaddr  接口地址，不使用
 * @apiSuccess {Number} dhcp_distance  dhcp优先级， 范围（1-255）
 * @apiSuccess {Number} dhcp_default_gate  1：更新网关；0：默认网关
 * @apiSuccess {Number} dhcp_dns  1，更新DNS；0：默认dns
 * @apiSuccess {String} pppoe_user  pppoe用户名， 范围（1-63）
 * @apiSuccess {String} pppoe_passwd  pppoe密码， 范围（6-31）
 * @apiSuccess {Number} pppoe_distance  pppoe管理距离， 范围（1-255）
 * @apiSuccess {Number} pppoe_weight  pppoe权重， 范围（1-100）
 * @apiSuccess {String} pppoe_specify_ip  pppoe指定ip地址
 * @apiSuccess {Number} pppoe_default_gate  从服务器中重新获取网关（1，开启；0，关闭）
 * @apiSuccess {Number} pppoe_dns  改变内部DNS（1，改变；0，不改变）
 * @apiSuccess {Number} http  接口访问控制，能否以 http 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} https  接口访问控制，能否以 https 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} telnet  接口访问控制，能否以 telnet 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ping  接口访问控制，接口能否被ping通（1，开启；0，关闭）
 * @apiSuccess {Number} ssh  接口访问控制，能否以 ssh 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} bgp  接口访问控制，能否以 bgp 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} ospf  接口访问控制，能否以 ospf 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} rip  接口访问控制，能否以 rip 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} dns  接口访问控制，能否以 dns 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} tctrl  接口访问控制（1，开启；0，关闭），不使用
 * @apiSuccess {Number} l2tp  不使用
 * @apiSuccess {Number} sslvpn  接口访问控制（1，开启；0，关闭）（1，开启；0，关闭）
 * @apiSuccess {Number} linkage  接口访问控制（1，开启；0，关闭）
 * @apiSuccess {Number} bind_if_enable  不使用
 * @apiSuccess {Number} bind_type  不使用
 * @apiSuccess {String} if_name  不使用
 * @apiSuccess {String} monitor_addr  monitor_addr
 * @apiSuccess {Number} negotiate  物理接口自协商状态（1，关闭；0，开启）
 * @apiSuccess {Number} half  物理接口双工状态（1，全双工；0，半双工）
 * @apiSuccess {Number} speed  物理接口速率，范围（10， 100， 1000）
 * @apiSuccess {Number} mtu  mtu， 范围（1280-1500）
 * @apiSuccess {Number} if_bandwidth  不使用
 * @apiSuccess {String} haipaddr  不使用
 * @apiSuccess {Number} shut  接口up/down管理状态（1， 关闭； 0， 开启）
 * @apiSuccess {Number} max_speed  接口能支持的最大速率，不使用
 * @apiSuccess {Number} webauth  接口访问控制，能否以 webauth 的形式访问（1，开启；0，关闭）
 * @apiSuccess {Number} cen_monitor  接口访问控制，能否以 cen_monitor 的形式访问，不使用
 * @apiSuccess {Number} mgmt_flag  标注是否mgt接口，不使用
 * @apiSuccess {Number} external  接口内外网口状态（1，外网口；0，内网口）
 * @apiSuccess {Number} get_type  想要获取的接口类型，不使用
 * @apiSuccess {Array} sec_ip  辅助ip，不使用
 * @apiSuccess {Array} tb_interface_ip  接口ip地址，可能有多个
 * @apiSuccess {Array} hw_addr  接口MAC地址
 * @apiSuccess {Array} vlan_count  接口被vlan引用的次数
 *
 * @apiParamExample {json} Request-Example:
{
 *			"name": "ge0/2",
 *			"real_name": "ge0/2",
 *			"alias_name": "ge0/2",
 *			"address_type": "3",
 *			"pppoe_user": "admin",
 *			"pppoe_passwd": "admin",
 *			"pppoe_distance": "2",
 *			"pppoe_weight": "1",
 *			"pppoe_default_gate": "1",
 *			"pppoe_dns": "1",
 *			"http": "",
 *			"https": "",
 *			"telnet": "",
 *			"ping": "",
 *			"ssh": "",
 *			"bgp": "",
 *			"ospf": "",
 *			"rip": "",
 *			"dns": "",
 *			"tctrl": "",
 *			"sslvpn": "",
 *			"linkage": "",
 *			"negotiate": "0",
 *			"half": "UNKNOWN",
 *			"speed": "UNKNOWN",
 *			"mtu": "1500",
 *			"shut": "0",
 *			"webauth": "0",
 *			"external": "1",
 *			"tb_interface_ip": ""
 *		}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"10" 未找到该接口
 *	}
 *
 */

/**
 * @api {DELETE}  /api/interfaces 物理接口不支持删除操作
 * @apiName 物理接口不支持删除操作
 * @apiGroup 接口配置
 */


class InterfacePhyController extends mController{
	public $category = 'CATEG_CONFIG';
	public $module = 'interface_sub';

	function get () {
		$param = get_inputs();
		$data = array();

		$rspString = getResponse($this->module, "show" ,$param);
	    $ret = getAssign($rspString, $this->module, false, true);

	   	if(empty($ret)) {
	   		$data['data'] = array();
	   		$data['total'] = 0;
	   	} else {
	   		foreach ($ret['group'] as $key => $value) {
	   			if ($value['pppoe_user']) {
	   				$value['pppoe_user'] = hex2bin($value['pppoe_user']);
	   			}
	   			if ($value['pppoe_passwd']) {
	   				$value['pppoe_passwd'] = hex2bin($value['pppoe_passwd']);
	   			}
	   			$data['data'][] = $value;
	   		}
	   		if (isset($ret['page'])) {
	   			$data['total'] = (int)$ret['page']['total'];
	   		} else {
	   			$data['total'] = (int)count($data['data']);
	   		}
	   	}

	   	header('Content-type: application/json');
	   	echo json_encode($data);
	}

	function put () {
		$param = get_inputs();
		//SOS-8191要求pppoe密码规格不限制，此功能设计有问题，建议后期版本迭代恢复此处限制
		//如果物理接口类型为pppoe，则添加屏蔽验证逻辑
		if ($param['address_type']== '3') {
			$param['pppoe_user'] = bin2hex(htmlspecialchars_decode($param['pppoe_user']));
			$param['pppoe_passwd'] = bin2hex(htmlspecialchars_decode($param['pppoe_passwd']));
		} 

		$rspString = getResponse($this->module, "mod" ,$param);
		
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

?>
