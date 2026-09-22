<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET} /api/device-status 获取设备基本信息
 * @apiName 获取设备基本信息
 * @apiGroup 基本信息
 *
 *
 * @apiSuccess {String} attack 今日安全事件数量
 * @apiSuccess {String} cpu CPU利用率
 * @apiSuccess {String} has_harddisk 硬盘利用率
 * @apiSuccess {String} memory  内存利用率
 * @apiSuccess {String} online_users  在线用户数量
 * @apiSuccess {String} total_connection  连接数
 * @apiSuccess {String} unilization_ratio  CF卡利用率
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"attack": "0", 
 *			"cpu": "0.10", 
 *			"has_harddisk": "1", 
 *			"memory": "34", 
 *			"online_users": "75", 
 *			"total_connection": "31", 
 *			"unilization_ratio": "1", 
 *	}
 */

class DeviceStatusController extends mController{	
	function get() {
		$map1 = array();
		$map2 = array();
		$map1['period']=0;
		$map1['type']=1;
		$map2['period']=0;
		$map2['type']=2;
		//CPU利用率
		$cpuUsage = getResponse('cpu_usage_stat',"show",$map1);
		//内存利用率
		$memoryUsage = getResponse('mem_usage_stat',"show",$map2);
		$cpuArrCount=count($cpuUsage['cpu_usage_stat']['group']['data']['group']);
		$memoryArrCount=count($memoryUsage['mem_usage_stat']['group']['data']['group']);
		//磁盘使用率截取
		$diskusage = getResponse('hostinfo',"show");
		$str = $diskusage['hostinfo']['group']['harddisk_stat'];
		$arr = explode('/',$str);
		$used = $arr[1];
		$has_harddisk = $diskusage['hostinfo']['group']['has_harddisk'];
		//连接数
		$connection = getResponse('device_perf',"show",$map1);
		$connectionCount = count($connection['device_perf']['group']['data']['group']);
		// $vpn_ipsec = MainModel::getConvertedData('vpn_ipsecsa',$map);
		// 
		$online_users = getResponse('auth_user_param',"show");
		$attack = getResponse('ips_log',"show_i");
		if (!empty($cpuUsage) && !empty($memoryUsage) && !empty($diskusage) && !empty($connection) && !empty($attack)) {
			$result=array('cpu'=>$cpuUsage['cpu_usage_stat']['group']['data']['group'][$cpuArrCount-1]['usage'],'memory'=>$memoryUsage['mem_usage_stat']['group']['data']['group'][$memoryArrCount-1]['usage'],'unilization_ratio'=>$used,'total_connection'=>$connection['device_perf']['group']['data']['group'][$connectionCount-1]['device'],'attack'=>$attack['ips_log']['group']['today_attack_num'],'online_users'=>$online_users['auth_user_param']['group']['recogs_num'],'has_harddisk'=>$has_harddisk);		
		}
		echo json_encode($result);		
	}
}