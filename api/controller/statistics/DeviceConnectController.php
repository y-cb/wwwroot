<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

/**
 * @api {GET} /api/device-connect 获取设备连接数
 * @apiName 获取设备连接数
 * @apiGroup 设备健康统计
 *
 *
 * @apiSuccess {Number} type  统计类型 （3为连接数）
 * @apiSuccess {Number} period  时间类型 （0为最近半小时，1为最近三小时，2为最近一天，3为最近一周，4为最近一月，5为一小时）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{"data": 
 *  [{"data": {"group": [
 *	{"date": "2018-05-11 10:59:47", "device": "0", "min_connect": "0", "max_connect": "0"}, 
 *	{"date": "2018-05-11 16:05:08", "device": "0", "min_connect": "0", "max_connect": "0"}
 *	]}
 *	}]
 *	} 
 */

//use lib\ArrayMap;

class DeviceConnectController extends mController{	
	function get(){
		$db = new StatisticDb();
		$param = get_inputs();
		switch ($param['period']) {
			case '0':
				$table_name = 'health_info_usage';
				break;
			case '1':
				$table_name = 'health_info_usage_3hour';
				break;
			case '2':
				$table_name = 'health_info_usage_1day';
				break;
			case '3':
				$table_name = 'health_info_usage_1week';
				break;
			case '4':
				$table_name = 'health_info_usage_1month';
				break;
			case '5':
				$table_name = 'health_info_usage_1hour';
				break;
			default:
				$table_name = 'health_info_usage';
				break;
		}
		if($param['period']==0 ){
			if( $param['type']==1){
				$res = $db -> org_select($table_name,['time','connect']);
			}else{
				$res = $db -> org_select($table_name,['time','secnewconnect']);
			}
			
		}else{
			if( $param['type']==1){
				$res = $db -> org_select($table_name,['time','connect','max_connect','min_connect']);
			}else{
				$res = $db -> org_select($table_name,['time','secnewconnect','max_secnewconnect','min_secnewconnect']);
			}
			
		}
		
		$data= array();
		if($param['type']==1){
			for($i=0;$i<count($res);$i++){
				$tmp_time = $res[$i]['time'];
				$tmp_device = $res[$i]['connect'];

				if ($param['period'] == 0 || $param['period'] == 1 || $param['period'] == 2 || $param['period'] == 5) {
					$data[$i]['date']= date('H:i', $tmp_time);
				} else {
					$data[$i]['date']= date('m-d H:i', $tmp_time);
				}

				$data[$i]['device']= $tmp_device;
				if($param['period']!=0){
					$data[$i]['max_connect']= $res[$i]['max_connect'];
					$data[$i]['min_connect']= $res[$i]['min_connect'];
				}
			}
		}else{
			for($i=0;$i<count($res);$i++){
				$tmp_time = $res[$i]['time'];
				$tmp_device = $res[$i]['secnewconnect'];

				if ($param['period'] == 0 || $param['period'] == 1 || $param['period'] == 2 || $param['period'] == 5) {
					$data[$i]['date']= date('H:i', $tmp_time);
				} else {
					$data[$i]['date']= date('m-d', $tmp_time);
				}
				
				$data[$i]['device']= $tmp_device;
				if($param['period']!=0){
					$data[$i]['max_connect']= $res[$i]['max_secnewconnect'];
					$data[$i]['min_connect']= $res[$i]['min_secnewconnect'];
				}
			}
		}
		
		$new_data['data'][0]['data']['group']=$data;
		echo json_encode($new_data);
	}
}