<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/ips-dip 获取入侵防护统计TOP10攻击目的IP
 * @apiName 获取入侵防护统计TOP10攻击目的IP
 * @apiGroup 入侵防护统计
 *
 *
 * @apiSuccess {String} name 攻击目的IP名称，不可为空，ip地址取值不固定
 * @apiSuccess {Number} count 攻击次数，不可为空，整型值
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "1.2.3.4",
 *			"count": "10"
 *		},
 *		{
 *			"name": "2.3.4.5",
 *			"count": "8"
 *		}
 *	],
 *	"total": 2
 *	}
 */

use database\MysqlDb;

class IpsStatDipController extends mController {	
	function get(){
		if(file_exists('/mnt1/mysql/')) {
			$cur = time();
			$day = strftime("%Y%m%d", $cur);
			$table_name = 'ips_'. $day;
			//$table_name = 'ips_20171220';
			$data = MysqlDb::org_select($table_name, [ 'dstip', '[SUM](cnt)'],  ["LIMIT" => 10,  "GROUP" => "dstip", "ORDER" => "cnt DESC"]);
		}else{
			$module = 'sys_top_attack_monitor';
			$param['top_n'] = 9;
			$param['type'] = 2;
			$rspString = getResponse($module, "show" ,$param);
			$ret = getAssign($rspString, $module, false, true);
			if (!empty($ret)){
				for($i=0;$i<count($ret['group']);$i++){
					$ret['group'][$i]['dstip'] = $ret['group'][$i]['name'];
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
