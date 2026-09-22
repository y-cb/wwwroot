<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

/**
 * @api {GET} /api/memory-stat 获取内存利用率
 * @apiName 获取CPU利用率
 * @apiGroup 设备健康统计
 *
 * @apiSuccess {Number} type  统计类型 （1为CPU利用率，2为内存利用率，3为连接数，4为设备流量）
 * @apiSuccess {Number} period  时间类型 （0为最近半小时，1为最近三小时，2为最近一天，3为最近一周，4为最近一月，5为一小时）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{"total": 1, "data": [{"time_interval": "30", "data": {"group": 
 *	[{"date": "2018-05-02 09:53:49", "usage": "45"}, {"date": "2018-05-02 09:54:19", "usage": "45"}, 
 *	{"date": "2018-05-02 09:54:49", "usage": "45"}, {"date": "2018-05-02 09:55:19", "usage": "45"}, 
 *	{"date": "2018-05-02 09:55:49", "usage": "45"}, {"date": "2018-05-02 09:56:19", "usage": "45"}, 
 *	{"date": "2018-05-02 09:56:49", "usage": "45"}, {"date": "2018-05-02 09:57:19", "usage": "45"}, 
 *	{"date": "2018-05-02 09:57:49", "usage": "45"}, {"date": "2018-05-02 09:58:19", "usage": "45"}, 
 *	{"date": "2018-05-02 09:58:49", "usage": "45"}, {"date": "2018-05-02 09:59:19", "usage": "45"}, 
 *	{"date": "2018-05-02 09:59:49", "usage": "45"}, {"date": "2018-05-02 10:00:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:00:49", "usage": "45"}, {"date": "2018-05-02 10:01:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:01:49", "usage": "45"}, {"date": "2018-05-02 10:02:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:02:49", "usage": "45"}, {"date": "2018-05-02 10:03:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:03:49", "usage": "45"}, {"date": "2018-05-02 10:04:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:04:49", "usage": "45"}, {"date": "2018-05-02 10:05:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:05:49", "usage": "45"}, {"date": "2018-05-02 10:06:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:06:49", "usage": "45"}, {"date": "2018-05-02 10:07:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:07:49", "usage": "45"}, {"date": "2018-05-02 10:08:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:08:49", "usage": "45"}, {"date": "2018-05-02 10:09:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:09:49", "usage": "45"}, {"date": "2018-05-02 10:10:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:10:49", "usage": "45"}, {"date": "2018-05-02 10:11:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:11:49", "usage": "45"}, {"date": "2018-05-02 10:12:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:12:49", "usage": "45"}, {"date": "2018-05-02 10:13:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:13:49", "usage": "45"}, {"date": "2018-05-02 10:14:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:14:49", "usage": "45"}, {"date": "2018-05-02 10:15:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:15:49", "usage": "45"}, {"date": "2018-05-02 10:16:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:16:49", "usage": "45"}, {"date": "2018-05-02 10:17:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:17:49", "usage": "45"}, {"date": "2018-05-02 10:18:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:18:49", "usage": "45"}, {"date": "2018-05-02 10:19:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:19:49", "usage": "45"}, {"date": "2018-05-02 10:20:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:20:49", "usage": "45"}, {"date": "2018-05-02 10:21:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:21:49", "usage": "45"}, {"date": "2018-05-02 10:22:19", "usage": "45"}, 
 *	{"date": "2018-05-02 10:22:49", "usage": "45"}, {"date": "2018-05-02 10:23:19", "usage": "45"}]}, 
 *	"period": "0"}]},
 */



class MemoryStatController extends mController{	
	public $module = 'mem_usage_stat';
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
		if($param['period']==0){
			$res = $db -> org_select($table_name,['time','memory_usage']);
		}else{
			$res = $db -> org_select($table_name,['time','memory_usage','max_memory_usage','min_memory_usage']);
		}
		
		$data= array();
		for($i=0;$i<count($res);$i++){
			$tmp_time = $res[$i]['time'];
			$tmp_usage = $res[$i]['memory_usage'];
	
			if ($param['period'] == 0 || $param['period'] == 1 || $param['period'] == 2 || $param['period'] == 5) {
				$data[$i]['date']= date('H:i', $tmp_time);
			} else {
				$data[$i]['date']= date('m-d H:i', $tmp_time);
			}
			
			$data[$i]['usage']= $tmp_usage;
			if($param['period']!=0){
				$data[$i]['max_usage']= $res[$i]['max_memory_usage'];
				$data[$i]['min_usage']= $res[$i]['min_memory_usage'];
			}
		}
		$new_data['data'][0]['data']['group']=$data;
		echo json_encode($new_data);
	}
}