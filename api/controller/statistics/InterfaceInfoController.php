<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/interface-info 获取物理接口信息
 * @apiName 根据传入的接口名称获取对应的信息，如果无参数传入，获取所有的接口信息
 * @apiGroup 接口信息
 *
 *
 * @apiSuccess {String} name  物理接口名称
 * @apiSuccess {String} real_name  接口实际名称
 * @apiSuccess {Number} status  接口当前状态：1，up；0，dowm
 * @apiSuccess {Number} speed  接口速率
 * @apiSuccess {String} ip_address  接口ip地址
 * @apiSuccess {Number} half  接口双工状态
 * @apiSuccess {Number} rx_pkt  接口每秒收到的包数
 * @apiSuccess {Number} rx_pkt_total  接口收到的总包数
 * @apiSuccess {Number} send_pkt  接口每秒发送的包数
 * @apiSuccess {Number} send_pkt_total  接口发送的总包数
 * @apiSuccess {Number} rx_byte  接口收到的字节数
 * @apiSuccess {Number} rx_byte_total  接口收到的总字节数
 * @apiSuccess {Number} send_byte  接口发送的字节数
 * @apiSuccess {Number} send_byte_total  接口发送的总字节数
 * @apiSuccess {String} hw_addr  接口的MAC地址
 * @apiSuccess {Number} bw_usage  带宽使用率
 * @apiSuccess {Number} negotiate  接口自动协商状态
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "ge0/0",
 *			"real_name": "ge0/0",
 *			"status": "0",
 *			"speed": "1000",
 *			"ip_address": "172.16.0.126/16",
 *			"half": "FULL",
 *			"rx_pkt": "2",
 *			"send_pkt": "0",
 *			"rx_byte": "1.272",
 *			"send_byte": "0.000",
 *			"hw_addr": "44-8a-5b-38-7e-77",
 *			"bw_usage": "0"
 *		},
 *		{
 *			"name": "XXX",
 *			"real_name": "XXX",
 *			"status": "XXX",
 *			"speed": "XXX",
 *			"ip_address": "XXX",
 *			"duplex": "XXX",
 *			"rx_pkt": "XXX",
 *			"send_pkt": "XXX",
 *			"rx_byte": "XXX",
 *			"send_byte": "XXX",
 *			"hw_addr": "XXX",
 *			"bw_usage": "XXX"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/interface_infomation 修改接口信息，不支持。该模块只支持GET
 * @apiName 修改接口信息
 * @apiGroup 接口信息
 *
 *
 *
 */



class InterfaceInfoController extends mController{
	public $module = 'interface_infomation';

	/**
	 * 兼容矩阵5.0物理接口修改下发数据，蛋疼
	 */
	function put() {
		$tmp_param = get_inputs();
		$param = array(
			'http' => '1',
			'https' => '1',
			'ping' => '1',
			'telnet' => '1',
			'ssh' => '1',
			'sslvpn' => '1',
			'bgp' => '1',
			'ospf' => '1',
			'rip' => '1',
			'dns' => '1',
			'webauth' => '1',
			'name' => $tmp_param['name'],
			'address_type' => $tmp_param['address_type'],
		);
		$param['shut'] = $tmp_param['admin_status']? $tmp_param['admin_status']:'0';
		switch ($param['address_type']) {
			case '1':
				$inf_cfg = array(
					'unit_id' => '0',
					'tb_ip_version' => '4',
					'is_floating_ip' => '0'
				);
				if (!empty($tmp_param['ipaddr_items'][0]['address'])){
					$param = self::getInfList($tmp_param['ipaddr_items'][0]['address'], $inf_cfg, $param);
				}
				if (!empty($tmp_param['ipaddr_items'][1]['address'])) {
					$inf_cfg['tb_ip_version'] = '6';
					$param = self::getInfList($tmp_param['ipaddr_items'][1]['address'], $inf_cfg, $param);
				}
				break;
			case '2':
				break;
			case '3':
				$param['pppoe_user'] = isset($tmp_param['pppoe_user'])? $tmp_param['pppoe_user']: '';
				$param['pppoe_passwd'] = isset($tmp_param['pppoe_passwd'])? $tmp_param['pppoe_passwd']: '';
				$param['pppoe_default_gate'] = isset($tmp_param['pppoe_default_gate'])? $tmp_param['pppoe_default_gate']: '0';	
				break;	
		}

		$rspString = getResponse('interface_sub', "mod" ,$param);
		$ret = getAssign($rspString, 'interface_sub');
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}

	}

	protected function getInfList($data, $info, $list) {
		foreach ($data as $value) {
			$info['tb_ip'] = $value['tb_ip'];
			$list['tb_interface_ip'][] = $info;
		}
		return $list;
	}
}

