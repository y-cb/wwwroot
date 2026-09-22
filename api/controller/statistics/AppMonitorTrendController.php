<?php
namespace controller\statistics;
use controller\mController;
use database\AppflowDb;
use controller\statistics;

/**
 * @api {GET}  /api/app-monitor-trend 获取应用分类流量统计
 * @apiName app-monitor-trend
 * @apiGroup 应用分类流量统计
 *
 *
 * @apiParam {Number} range 1代表最近1小时，2代表最近1天，3代表最近1周
 * @apiParam {String} direct “up”代表上行，“down”代表下行，“total”代表双向，“all”代表前三种
 * @apiParam {Number} category 分类，固定为1,携带此参数代表为应用分类统计
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"range": "1",
 *		"direct": "all",
 *		"category": "1"
 *	}
 *
 * @apiSuccess {Array} group 应用分类统计数组
 * @apiSuccess {String} name 应用分类名称
 * @apiSuccess {String} name_cn 应用分类名称对应中文
 * @apiSuccess {String} up_bytes 上行流量
 * @apiSuccess {String} down_bytes 下行流量
 * @apiSuccess {String} total_bytes 总流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 * {
 *     "0": {
 * 		"name": "http",
 * 		"name_cn": "http",
 * 		"up_bytes": "0,25457,34273,10072,81523,928,25709,11521,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"down_bytes": "0,50776,460451,4668,103972,470,40442,17245,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"total_bytes": "0,76233,494724,14740,185495,1398,66151,28766,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0"
 * 	},
 *     "1": {
 * 		"name": "http-picture",
 * 		"name_cn": "http-picture",
 * 		"up_bytes": "0,0,90317,82138,264,0,4018,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"down_bytes": "0,0,450618,114281,132,0,2386,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"total_bytes": "0,0,540935,196419,396,0,6404,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0"
 * 	},
 * 	"group": [{
 * 		"name": "http",
 * 		"name_cn": "http",
 * 		"up_bytes": "0,25457,34273,10072,81523,928,25709,11521,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"down_bytes": "0,50776,460451,4668,103972,470,40442,17245,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"total_bytes": "0,76233,494724,14740,185495,1398,66151,28766,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0"
 * 	}, {
 * 		"name": "http-picture",
 * 		"name_cn": "http-picture",
 * 		"up_bytes": "0,0,90317,82138,264,0,4018,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"down_bytes": "0,0,450618,114281,132,0,2386,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0",
 * 		"total_bytes": "0,0,540935,196419,396,0,6404,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0"
 * 	}]
 * }
 */

class AppMonitorTrendController extends mController {	
	// public $module = 'monitor_apps_trend';
	function get($param=array()){
		$is_return = false;
		$data = array();
		if (empty($param)) {
			$param = get_inputs();
		} else {
			$is_return = true;
		}
		
		if ($param['range'] == '1'){
			$num = 60;
		} else if ($param['range'] == '2') { 
			$num = 144;
		} else if ($param['range'] == '3') {
			$num = 168;
		}
		$db = new AppflowDb();
		$db->dbname = '/tmp/result.db';
		$data = AppMonitorController::get_db_config($num);
		$name = $data['file_path'];
		/*if (file_exists('/mnt1/mysql/')) {
			$path = '/mnt1/flow_statistic/'.$data['file_path'].'/';
		} else {
			$path = '/var/mem_db/flow_statistic/'.$data['file_path'].'/';
		}*/
		$path='/tmp/flow_statistic/'.$data['file_path'].'/';
		
		// if ($db->sql_exists($name) == false) {
		$db->stat_route($data['data'], $path, $param);
		// $db->app_sort_query($data['data'], $path, $name, $param);
		if ($param['user_name']) {
			$list = $db->user_name_trend_query($data['data'], $path, $param);
		} else {
			$list = $db->app_trend_query($path, $param);
		}
		
		/*} else {
			$list = $db->app_trend_query($data['data'], $name, $path);
		}*/
		$list[group] = $list;
		
		$time = $db->get_start_time($data['data']);

		if ($is_return) { 
			return $list[group];
		} else {
			echo json_encode($list)."@".$time;
		}

		

/*		$rspString = getResponse($this->module, "showone" ,$param);
		$monitor_apps_trend_arr = getAssign($rspString,$this->module,1);
		$array =  json_decode($monitor_apps_trend_arr[items],true);
		if(!$array[group][0]){
			if($array){
				$a[group][0][name_cn] = $array[group][name_cn];
				$a[group][0][up_bytes] = $array[group][up_bytes];
				$a[group][0][down_bytes] = $array[group][down_bytes];
				$a[group][0][total_bytes] = $array[group][total_bytes];
				echo json_encode($a)."@".$monitor_apps_trend_arr[start_time];
			}else{
				echo '';
			}
		}else{
			echo $monitor_apps_trend_arr[items]."@".$monitor_apps_trend_arr[start_time];
		}*/
	}
}
