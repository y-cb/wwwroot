<?php
namespace controller\statistics;
use controller\mController;
use database\MySQLite3Db;

/**
 * @api {GET}  /api/apt-result 获取沙箱检测结果统计
 * @apiName 获取沙箱检测结果统计
 * @apiGroup 病毒防护统计
 *
 * @apiSuccess {Number} value  对应统计结果个数
 * @apiSuccess {String} name  统计结果等级
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *  "data": [
 *  {
 *   "name":"可信",
 *   "value":1
 *  },
 *  {
 *   "name":"危险",
 *   "value":2
 *  },
 *  {
 *   "name":"未知",
 *   "value":0
 *  },
 *  {
 *   "name":"未见异常",
 *   "value":3
 *  },
 *  {
 *   "name":"检测出错",
 *   "value":0
 *  }
 * ],
 * "total": 6
 * }
 */

class AptStatResultController extends mController {
	function get(){
		$db = new MySQLite3Db('/mnt/boot/apt.db', '/tmp/apt_tmp.db');
		$table_name = 'apt_result';
		
		$total = $db->get_SQLite3_data_count($table_name, '');
		$datasets=array();
		$security = 0;
		$low = 0;
		$medium = 0;
		$high = 0;
		$sql = 'select result, count(*) from '.$table_name.' group by result;';
		$res = $db->query($sql);
		
		while ($line = $res->fetchArray()) {
			if ($line[0] == 0) {
				$security = $line[1];
			} else if ($line[0] == 1) {
				$low = $line[1];
			} else if ($line[0] == 2) {
				$medium = $line[1];
			}else if($line[0] == 3) {
				$high = $line[1];
			}
		}
		header('Content-type: application/json');
		$datasets[0]=array('name'=>t('apt.level0'),'value'=> $security);
		$datasets[1]=array('name'=>t('apt.level1'),'value'=> $low);
		$datasets[2]=array('name'=>t('apt.level2'),'value'=> $medium);
		$datasets[3]=array('name'=>t('apt.level3'),'value'=> $high);
		$arr = array(
			'total'=>$total,
			'data'=>$datasets
		);
		
		echo json_encode($arr);
		
	}
}
?>