<?php
namespace controller\statistics;
use controller\mController;
use database\AppflowDb;
/**
 * @api {GET}  /api/app-monitor 获取应用统计详细信息
 * @apiName app-monitor
 * @apiGroup 应用分类流量统计
 *
 *
 * @apiParam {Number} range 1代表最近1小时，2代表最近1天，3代表最近1周
 * @apiParam {String} direct “up”代表上行，“down”代表下行，“total”代表双向，“all”代表前三种
 * @apiParam {Number} category 分类，固定为1,携带此参数代表为应用分类详细信息
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"range": "1",
 *		"direct": "all",
 *	}
 *
 * @apiSuccess {Number} all_total_bytes 流量总数
 * @apiSuccess {Array} items 应用统计数组
 * @apiSuccess {String} name 应用名称
 * @apiSuccess {String} name_cn 应用名称对应中文
 * @apiSuccess {String} up_bytes 上行流量
 * @apiSuccess {String} down_bytes 下行流量
 * @apiSuccess {String} total_bytes 总流量
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"all_total_bytes"："8066217",
 *			"items": [
 *			{
 *			    "name": "http",
 *			    "name_cn": "HTTP-网页浏览",
 *			    "up_bytes": "743538",
 *			    "down_bytes": "6611716",
 *			    "total_bytes": "7355254"
 *			},
 *			{
 *			    "name": "dns",
 *			    "name_cn": "DNS",
 *			    "up_bytes": "34537",
 *			    "down_bytes": "44674",
 *			    "total_bytes": "79211"
 *			},
 *			{
 *			    "name": "tcp",
 *			    "name_cn": "TCP",
 *			    "up_bytes": "12394",
 *			    "down_bytes": "5320",
 *			    "total_bytes": "17714"
 *			}
 *		]
 *		}
 *	}
 */


class AppMonitorController extends mController {	
	// public $module = 'monitor_apps';

	function get($param=array()){
		$is_return = false;
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

		$data = $this->get_db_config($num);
		$db = new AppflowDb();
		$db->dbname = '/tmp/result.db';
		/*if(file_exists('/mnt1/mysql/')) {
			$path = '/mnt1/flow_statistic/'.$data['file_path'].'/';
		} else {
			$path = '/var/mem_db/flow_statistic/'.$data['file_path'].'/';
		}*/
		$path='/tmp/flow_statistic/'.$data['file_path'].'/';

		// if ($db->sql_exists($db_name) == false) {
		$db -> stat_route($data['data'], $path, $param);
		// $db->app_sort_query($data['data'],$path,$db_name);
		$data = $db -> app_info_sort($param);
/*		} else {
			$data = $db->app_info_sort($db_name);
		}*/
		if ($is_return) {
			return $data;
		} else {
			echo json_encode($data);
		}
		

	}

	function get_db_config($num) {
		$data = array();
		$date = time();
		if ($num == 60) {
			$per = 60;
			$pre = 'min1_';
			$file_path = 'min1';
		} else if ($num == 144) {
			$per = 60 * 10;
			$pre = 'min10_';
			$file_path = 'min10';
		} else if ($num == 168) {
			$per= 60 * 60;
			$pre = 'hour1_';
			$file_path = 'hour1';
		}
		for($i=1;$i<=$num;$i++){
			$tmp = $date - $i * $per;
			if ($num == 168) {
				$data[] = date('Ymd_H',$tmp).'0000.db';
			} else if ($num == 144) {
				$tmp = floor($tmp/$per) * $per;
				$data[] = date('Ymd_Hi',$tmp).'00.db';
			} else {
				$data[] = date('Ymd_Hi',$tmp).'00.db';
			}
		}
		$data['data'] = array_reverse($data);
		$data['pre'] = $pre;
		$data['file_path'] = $file_path;
		return $data;
	}

}
