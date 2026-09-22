<?php
namespace controller\network;
use controller\mController;

Class BridgeController extends mController {
	public $module = 'tb_vlan';
	
	function get() {
		$param = get_inputs();
		$param['count'] = $param['pageSize'];
		$rspString = getResponse($this->module, "show" ,$param);
		$ret = getAssign($rspString, $this->module,1);
		if (empty($ret)) {
			echo json_encode(array('data'=>array(),'total'=>0));
		} else {
			$list = array();
			//将vlan接口返回的数据整合为5.0bridge接口返回样式
			foreach ($ret as $key => $value) {
				$tmp = array();
				$json = array();
				$tmp['bridge_id'] = $value['vlan_tag'];
				
				if ($value['tb_interface_ip']) {
					$json = json_decode($value['tb_interface_ip'], true);
					if (!empty($json)) {
						foreach ($json['group'] as $k => $v) {
							if (is_array($v)) {
								$tmp['ipaddr_items']['group'][$k]['address'] = $v['tb_ip'];
							} else {
								if ($k === 'tb_ip') {
									$tmp['ipaddr_items']['group'][]['address'] = $v;
									break;
								}
							}
						}
					}					
				}

				if ($value['untagged_if_list']) {
					$json = json_decode($value['tb_interface_ip'], true);
					if (!empty($json)) {
						foreach ($json as $k=>$v) {
							if (is_array($v)) {
								$tmp['inf_list']['group'][$k]['infname'] = $v['ifname'];
							} else {
								if ($k === 'ifname') {
									$tmp['inf_list']['group'][]['infname'] = $v;
									break;
								}
							}
						}
					}
				}
				$list['data'][] = $tmp;
			}
			$list['total'] = (int)count($list['data']);
			header('Content-type: application/json');
			echo json_encode($list);
		}
	}

	function post() {
		//因3.0版本会默认添加一个vlan101的策略，暂时没办法处理，故在api中进行数据删除
		getResponse($this->module, "del", array('vlan_name'=>'vlan101','vlan_tag'=>101));

		$tmp_param = get_inputs();
		$param = array();
		//将bridge下发数据整合发到vlan接口中
		$param['vlan_name'] = 'vlan_' . $tmp_param['bridge_id'];
		$param['vlan_tag'] = $tmp_param['bridge_id'];
		$param['tb_interface_ip'] = array();
		$ip_param = array(
			'tb_ip_version' => '4',
			'is_floating_ip' => '0',
			'unit_id' => ''
		);

		if (!empty($tmp_param['ipaddr_items'])){
			for ($i = 0; $i < count($tmp_param['ipaddr_items']); $i++) {
				$ip_param['tb_ip'] = $tmp_param['ipaddr_items'][$i]['address'];
				$param['tb_interface_ip'][$i] = $ip_param;
			}
		}

		if (!empty($tmp_param['inf_list'])){
			for ($i = 0; $i < count($tmp_param['inf_list']); $i++) {
				$param['untagged_if_list'][$i]['ifname'] = $tmp_param['inf_list'][$i]['infname'];
			}
		}	

		$param['mtu'] = 1500;
		$param['stp_bridge_priority'] = 32768;
		$param['stp_hello_time'] = 2;
		$param['stp_max_age'] = 20;
		$param['port_forward_delay'] = 15;
		$param['external'] = 0;
		$param['shut'] = 0;
		$param['vid_transparent'] = 0;
		$param['stp_enable'] = 1;
		$param['http'] = 1;
		$param['https'] = 1;
		$param['ping'] = 1;
		$param['telnet'] = 1;
		$param['ssh'] = 1;
		$param['sslvpn'] = 1;
		$param['bgp'] = 1;
		$param['ospf'] = 1;
		$param['rip'] = 1;
		$param['dns'] = 1;
		$param['webauth'] = 1;
		$param['address_type'] = 1;

		$rspString = getResponse($this->module, "add" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
			exit;
		}
		$dhcp_param = array(
			'ifname' => $param['vlan_name'],
			'type' => 2,
			'ifvsysid' => 0,
			'vsysid_same' => '1',
		);
		$rspString = getResponse('dhcp_service', "mod" ,$dhcp_param);
		$ret = getAssign($rspString, $this->module);

		if (!empty($ret)){
			echo json_encode($ret);
		}
	}

	function put() {
		$param = get_inputs();
		$res_param = array();
		$res_param['vlan_name'] = 'vlan_' . $param['bridge_id'];
		$res_param['vlan_tag'] = $param['bridge_id'];

		$rspString = getResponse($this->module, "show_o", $res_param);
		$list = getAssign($rspString, $this->module,1);

		if($list['code']&&$list['str']) {
			echo json_encode($list);
			exit;
		}
		
		//整合可修改数据，其他不变
		$inf_array = array();
		$ip_array = array();

		$ip_param = array(
			'tb_ip_version' => '4',
			'is_floating_ip' => '0',
			'unit_id' => ''
		);

		if (!empty($param['ipaddr_items'])){
			for ($i = 0; $i < count($param['ipaddr_items']); $i++) {
				$ip_param['tb_ip'] = $param['ipaddr_items'][$i]['address'];
				$inf_array[$i] = $ip_param;
			}
		}

		if (!empty($param['inf_list'])){
			for ($i = 0; $i < count($param['inf_list']); $i++) {
				$ip_array[$i]['ifname'] = $param['inf_list'][$i]['infname'];
			}
		}

		$list['tb_interface_ip'] = $inf_array;
		$list['untagged_if_list'] = $ip_array;

		$rspString = getResponse($this->module, "mod" ,$list);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}

	function delete() {
		$tmp_param = get_inputs();
		$param = array();

		if (!empty($tmp_param)) {
			$param['vlan_tag'] = $tmp_param['bridge_id'];
		}

		$rspString = getResponse($this->module, "del" ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}