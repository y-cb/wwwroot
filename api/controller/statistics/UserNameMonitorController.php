<?php
namespace controller\statistics;
use controller\mController;
use database\AppflowDb;

/**
 * @api {GET}  /api/user-monitor-trend 概况页面获取用户流量统计
 * @apiName 概况页面获取用户流量统计
 * @apiGroup 用户流量统计
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 9, 
		"data": [{"bytes_total": "1084.95", "user_id": "0", "bytes_in": "1084.95", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "1084.95", "app_name_en": "udp", "app_name": "udp", "bytes_total": "1084.95", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.0.254"}, {"bytes_total": "745.91", "user_id": "0", "bytes_in": "745.91", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "745.91", "app_name_en": "udp", "app_name": "udp", "bytes_total": "745.91", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.0.253"}, {"bytes_total": "406.86", "user_id": "0", "bytes_in": "406.86", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "406.86", "app_name_en": "udp", "app_name": "udp", "bytes_total": "406.86", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.40.88"}, {"bytes_total": "146.45", "user_id": "0", "bytes_in": "146.45", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "146.45", "app_name_en": "udp", "app_name": "udp", "bytes_total": "146.45", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.200.122"}, {"bytes_total": "91.00", "user_id": "0", "bytes_in": "91.00", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "91.00", "app_name_en": "udp", "app_name": "udp", "bytes_total": "91.00", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.80.2"}, {"bytes_total": "75.46", "user_id": "0", "bytes_in": "75.46", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "75.46", "app_name_en": "udp", "app_name": "udp", "bytes_total": "75.46", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.110.102"}, {"bytes_total": "33.55", "user_id": "0", "bytes_in": "33.55", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "33.55", "app_name_en": "udp", "app_name": "udp", "bytes_total": "33.55", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.70.11"}, {"bytes_total": "26.84", "user_id": "0", "bytes_in": "26.84", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "26.84", "app_name_en": "udp", "app_name": "udp", "bytes_total": "26.84", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.1.21"}, {"bytes_total": "9.18", "user_id": "0", "bytes_in": "9.18", "user_group": "anonymous", "app_items": {"group": {"bytes_in": "9.18", "app_name_en": "udp", "app_name": "udp", "bytes_total": "9.18", "bytes_out": "0.00"}}, "bytes_out": "0.00", "user_name": "172.17.200.205"}]
 *	}
 */


class UserNameMonitorController extends mController {	
	function get() {
		$data = array();
		$param = get_inputs();

		if ($param['range'] == '1'){
			$num = 60;
		} else if ($param['range'] == '2') { 
			$num = 144;
		} else if ($param['range'] == '3') {
			$num = 168;
		}

		$data = AppMonitorController::get_db_config($num);
		$db_name = $data['file_path'];
		$db = new AppflowDb();
		$db->dbname = '/tmp/result.db';
		if(file_exists('/mnt1/mysql/')) {
			$path = '/mnt1/flow_statistic/'.$data['file_path'].'/';
		} else {
			$path = '/var/mem_db/flow_statistic/'.$data['file_path'].'/';
		}
		$data = $db->user_name_trend_query($data['data'], $path, $param);
		echo json_encode($data);
	}
}
