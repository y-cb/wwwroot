<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/av-event 获取病毒防护统计TOP10病毒事件
 * @apiName av-event
 * @apiGroup 病毒防护统计
 *
 *
 * @apiSuccess {String} name 病毒事件名称，不可为空，病毒事件名称取值不固定
 * @apiSuccess {Number} count 攻击次数，不可为空，整型值
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "Trojan/Generic-ASSuf-135961",
 *			"count": "10"
 *		},
 *		{
 *			"name": "Trojan/Generic-ASDroid-4856866",
 *			"count": "8"
 *		}
 *	],
 *	"total": 2
 *	}
 */

use database\MysqlDb;

class AvStatEventController extends mController {	
	function get(){
		if(file_exists('/mnt1/mysql/')) {
			$cur = time();
			$day = strftime("%Y%m%d", $cur);
			$table_name = 'av_'. $day;
			//$table_name = 'ips_20170808';
			$data = MysqlDb::org_select($table_name, [ 'virusname', '[COUNT](cnt)'],  ["LIMIT" => 10,  "GROUP" => "virusname", "ORDER" => "cnt DESC"]);
		}else{
			$module = 'sys_top_virus_monitor';
			$param['top_n'] = 9;
			$param['type'] = 3;
			$rspString = getResponse($module, "show" ,$param);
			$ret = getAssign($rspString, $module, false, true);
			if (!empty($ret)) {
				for($i=0;$i<count($ret['group']);$i++){
					$ret['group'][$i]['virusname'] = $ret['group'][$i]['name'];
					$ret['group'][$i]['cnt'] = $ret['group'][$i]['count'];
				}
				$data = $ret['group'];				
			}
		}
		if(!$data){
			$data=[];
		}
		echo json_encode($data);
		return;
	}
}
