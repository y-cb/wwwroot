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
 * @apiSuccess {Number} range 范围
 * @apiSuccess {String} direct 流量方向
 * @apiSuccess {String} user_name 用户名
 * @apiSuccess {Number} is_user 是否为用户
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
		"range":1,
		"direct":"all",
		"user_name":"172.16.0.211",
		"is_user":0,
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"0": {
		    "name": "udp",
		    "name_cn": "UDP",
		    "up_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,",
		    "down_bytes": "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,",
		    "total_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,"
		},
		"group": [
		{
		    "name": "udp",
		    "name_cn": "UDP",
		    "up_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,",
		    "down_bytes": "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,",
		    "total_bytes": "0,63,0,63,32,94,32,32,0,32,63,62,63,0,0,32,32,63,32,32,63,0,32,62,32,32,32,0,0,0,63,94,63,32,0,31,32,63,32,32,32,0,0,0,32,32,32,62,0,0,0,32,32,0,32,0,0,0,32,62,"
		}
		]
 *	}
 *
 *
 */


class UserNameMonitorTrendController extends mController {	
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
