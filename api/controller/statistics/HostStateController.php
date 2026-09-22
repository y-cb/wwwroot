<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

class HostStateController extends mController{	
	function get() {
		$result = array();
		//CPU、内存、连接数
		$db = new StatisticDb();
		$sql = 'select cpu_usage,memory_usage,connect from health_info_usage order by "time" desc limit 1';
		if ($db) {
			$data = $db->org_query($sql);
		}
		$sqlFlow = 'select bits_in,bits_out,(bits_in + bits_out) as bits_total from host_flow_usage order by "time" desc limit 1';
		if ($db) {
			$flowData = $db->org_query($sqlFlow);
		}
		//磁盘使用率截取
		/*$diskusage = getResponse('hostinfo',"show");
		$str = $diskusage['hostinfo']['group']['harddisk_stat'];
		$arr = explode('/',$str);
		$used = $arr[1];
		$has_harddisk = $diskusage['hostinfo']['group']['has_harddisk'];*/
		//ips攻击
		// $attack = getResponse('ips_log',"show_i");
		if (!empty($data) && !empty($flowData)) {
			$result=array('cpuUsage'=>$data['cpu_usage'],'memoryUsage'=>$data['memory_usage'],'connectNum'=>$data['connect'],'flowIn'=>$flowData['bits_in'],'flowOut'=>$flowData['bits_out'],'flowTotal'=>$flowData['bits_total']);		
		}
		echo json_encode($result);		
	}
}