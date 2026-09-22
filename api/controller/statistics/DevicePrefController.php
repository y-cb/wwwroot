<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

/**
 * @api {GET} /api/device-pref 获取对应接口流量
 * @apiName 获取对应接口流量
 * @apiGroup 设备健康统计
 *
 *
 * @apiSuccess {String} name  接口名称 （默认为 host）
 * @apiSuccess {Number} type  统计类型 （4为接口流量）
 * @apiSuccess {Number} period  时间类型 （0为最近半小时，1为最近三小时，2为最近一天，3为最近一周，4为最近一月，5为一小时）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{"total": 1, 
 *  "data": [{"time_interval": "1800", 
 *  "data": {"group": [
 *  {"date": "2018-04-27 13:41:45", "device_out": "0", "device_in": "0"},
 *  {"date": "2018-04-28 12:41:45", "device_out": "0", "device_in": "0"}, 
 *  {"date": "2018-04-28 13:11:45", "device_out": "0", "device_in": "0"}]}, 
 *  "type": "4", 
 *  "name": "host", 
 *  "period": "2"}]
 *  }
 */



//use lib\ArrayMap;

class DevicePrefController extends mController{	
	public $module = 'device_perf';
	function get(){
		$db = new StatisticDb();
		$param = get_inputs();
		if($param['interf']=='-1'){
			switch ($param['period']) {
				case '0':
					$table_name = 'host_flow_usage';
					break;
				case '1':
					$table_name = 'host_flow_usage_3hour';
					break;
				case '2':
					$table_name = 'host_flow_usage_1day';
					break;
				case '3':
					$table_name = 'host_flow_usage_1week';
					break;
				case '4':
					$table_name = 'host_flow_usage_1month';
					break;
				case '5':
					$table_name = 'host_flow_usage_1hour';
					break;
				default:
					$table_name = 'host_flow_usage';
					break;
			}
		}else{
			$inf_name = str_replace("/","_",$param['interf']);
			switch ($param['period']) {
				case '0':
					$table_name = $inf_name.'_flow_usage';
					break;
				case '1':
					$table_name = $inf_name.'_flow_usage_3hour';
					break;
				case '2':
					$table_name = $inf_name.'_flow_usage_1day';
					break;
				case '3':
					$table_name = $inf_name.'_flow_usage_1week';
					break;
				case '4':
					$table_name = $inf_name.'_flow_usage_1month';
					break;
				case '5':
					$table_name = $inf_name.'_flow_usage_1hour';
					break;
				default:
					$table_name = $inf_name.'_flow_usage';
					break;
			}
		}
		if($param['period']==0){
			$res = $db -> org_select($table_name,['time','bits_in','bits_out']);
		}else{
			$res = $db -> org_select($table_name,['time','bits_in','bits_out','max_bits_in','min_bits_in','max_bits_out','min_bits_out']);
		}

		$data= array();
		for($i=0;$i<count($res);$i++){
			$tmp_time = $res[$i]['time'];
			$tmp_bits_in = $res[$i]['bits_in'];
			$tmp_bits_out = $res[$i]['bits_out'];

			if ($param['period'] == 0 || $param['period'] == 1 || $param['period'] == 2 || $param['period'] == 5) {
				$data[$i]['date']= date('H:i', $tmp_time);
			} else {
				$data[$i]['date']= date('m-d H:i', $tmp_time);
			}
			
			$data[$i]['device_in']= $tmp_bits_in;
			$data[$i]['device_out']= $tmp_bits_out;
			if($param['period']!=0){
				$data[$i]['max_device_in']= $res[$i]['max_bits_in'];
				$data[$i]['min_device_in']= $res[$i]['min_bits_in'];
				$data[$i]['max_device_out']= $res[$i]['max_bits_out'];
				$data[$i]['min_device_out']= $res[$i]['min_bits_out'];
			}
		}
		$new_data['data'][0]['data']['group']=$data;
		echo json_encode($new_data);
	}
	/*function get(){
		$map = new ArrayMap();
		$map['period']=$_GET['period'];
		$map['name']=$_GET['interf'];		
		$map['type']=$_GET['type'];
		$flow = getResponse($this->module,"show",$map);	
		$data= array();
		$data = $flow['device_perf']['group'];
		echo json_encode($data);
	}*/
}