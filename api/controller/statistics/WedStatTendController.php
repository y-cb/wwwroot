<?php
namespace controller\statistics;
use controller\mController;
use database\MysqlDb;

class WedStatTendController extends mController {	
	function get(){
		$cur = time();
		$day = strftime("%Y%m%d", $cur);
		$user = $_GET['user'];
		$host = $_GET['host'];
		$cate = $_GET['cate'];
		
		$date = localtime($cur, true);
		$table_name = 'web_access_'. $day;

		if (isset($user)) {
			$where['username'] = $user;
		}
		if (isset($host)) {
			$where['host'] = $host;
		}
		/*if (isset($cate)) {
			$where['category'] = $cate;
		}*/
		//计算其他分类数量
		if (isset($cate) && ($cate==='其他分类' || $cate==='Other Category')) {
			$data = MysqlDb::org_select($table_name, [ 'category','[COUNT](cnt)'],  ["LIMIT" => 9,  "GROUP" => "category", "ORDER" => "cnt DESC"]);
			foreach ($data as  $value) {
				$arr[] = $value['category'];
			}

			$where['category[!]'] = $arr;
		} elseif (isset($cate)) {
			$where['category'] = $cate;
		}

		$start = date("Y-m-d",time());
		$end = date("Y-m-d H:i:s",time());
		$start .= " 00:00:00";
		$where['AND'] = array_merge($where, ["create_at[<>]" => [$start, $end]]);
		$where["GROUP"] = "hour";
		$where["ORDER"] = "hour DESC";

		$data = MysqlDb::org_select($table_name, ['[COUNT](cnt)', '[HOUR](hour)'], $where);
		if (sizeof($data) > 0) {
			$max = $data[0]['hour'];
		} else {
			$max = 0;
		}

		$ret['pointInterval'] = 60 * 60 * 1000;
		$ret['pointStart'] = ($cur - ($cur % (24 * 3600))) * 1000;

		for ($i = 0; $i <= $max; $i++) {
			$num = 0;
			$ret['data'][$i]['hour'] = (int)$i;

			for ($j = 0; $j < sizeof($data); $j++) {
				if ($data[$j]['hour'] == $i) {
					$num = (int) $data[$j]['cnt'];
				}
			}
			$ret['data'][$i]['cnt'] = $num;
		}

		echo json_encode($ret);
		return;
	}
}
