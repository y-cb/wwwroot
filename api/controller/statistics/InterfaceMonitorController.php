<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/interface-monitor 获取接口统计信息
 * @apiName 获取接口统计信息
 * @apiGroup 接口信息统计
 *
 *
 * @apiSuccess {String} name  接口名称
 * @apiSuccess {Number} type  接口类型
 * @apiSuccess {String} status  接口状态
 * @apiSuccess {String} tx_dropped  接口丢包数
 * @apiSuccess {String} rx_packets  接口收包数
 * @apiSuccess {String} tx_overruns  接口发包overrun丢包数
 * @apiSuccess {String} rx_bytes  接口类型
 * @apiSuccess {String} tx_errors  接口发送的错包数
 * @apiSuccess {String} rx_speed_packets  接口收包速率
 * @apiSuccess {String} rx_overruns  接口收包overrun丢包数
 * @apiSuccess {String} rx_speed_bytes  接口收包速率
 * @apiSuccess {String} collisions  冲突包数
 * @apiSuccess {String} tx_speed_bytes  发送字节速率
 * @apiSuccess {String} rx_errors  接收错包数
 * @apiSuccess {String} tx_bytes  发送字节数
 * @apiSuccess {String} rx_dropped  收包时丢弃的包数
 * @apiSuccess {String} tx_packets  接口发包数
 * @apiSuccess {String} tx_speed_packets  接口发送的包速率
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"status": "0", 
 *			"tx_dropped": "0", 
 *			"rx_packets": "0", 
 *			"tx_overruns": "0", 
 *			"name": "mgt", 
 *			"rx_bytes": "0", 
 *			"tx_errors": "0", 
 *			"rx_speed_packets": "0", 
 *			"rx_overruns": "0", 
 *			"rx_speed_bytes": "0.000", 
 *			"collisions": "0", 
 *			"tx_speed_bytes": "0.000", 
 *			"rx_errors": "0", 
 *			"tx_bytes": "0", 
 *			"rx_dropped": "0", 
 *			"tx_packets": "0", 
 *			"tx_speed_packets": "0"
 *		},
 *		{
 *			"status": "1", 
 *			"tx_dropped": "0", 
 *			"rx_packets": "12430", 
 *			"tx_overruns": "0", 
 *			"name": "ge0/0", 
 *			"rx_bytes": "1728731", 
 *			"tx_errors": "0", 
 *			"rx_speed_packets": "3", 
 *			"rx_overruns": "0", 
 *			"rx_speed_bytes": "3.500", 
 *			"collisions": "0", 
 *			"tx_speed_bytes": "1.945", 
 *			"rx_errors": "0", 
 *			"tx_bytes": "10100705", 
 *			"rx_dropped": "0", 
 *			"tx_packets": "8642", 
 *			"tx_speed_packets": "1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/interface-monitor 接口信息统计没有POST操作
 * @apiName 接口信息统计没有POST操作
 * @apiGroup 接口信息统计
 *
 *
 *
 */

/**
 * @api {PUT}  /api/interface-monitor 接口信息统计没有PUT操作
 * @apiName 接口信息统计没有PUT操作
 * @apiGroup 接口信息统计
 *
 */

/**
 * @api {DELETE}  /api/interface-monitor 清除计数
 * @apiName 根据传入的接口名称清除对应的计数，如果没有name传入，则清除所有计数
 * @apiGroup 接口信息统计
 *
 *
 * @apiParam {String} name  接口名
 * @apiParam {Number} type  类型，模块未使用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ge/1"
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
 *	}
 *
 */


class InterfaceMonitorController extends mController{
	public $module = 'interface_statistics';

	function get(){
		$data = array();
		$param = get_inputs();

		$response = getResponse($this->module, "show", $param);
		$ret = getAssign($response, $this->module);
		foreach ($ret as $key => $value) {
			if (strpos($value['name'],'ge')!== false) {
				$ret[$key]['type'] = 'physical';
			} elseif (strpos($value['name'], 'ppp')!==false) {
				$ret[$key]['type'] = '4g';
			} else {
				$ret[$key]['type'] = 'virtual';
			}
		}

		$data['data'] = $ret;
		$data['total'] = count($data['data']);

		header('Content-type: application/json');
		echo json_encode($data);
	}
}

