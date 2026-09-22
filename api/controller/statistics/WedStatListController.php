<?php
namespace controller\statistics;
use controller\mController;
use database\MysqlDb;

class WedStatListController extends mController {	
	function get(){
		$cur = time();
		$day = strftime("%Y%m%d", $cur);
		$table_name = 'web_access_'. $day;
		$user = $_GET['user'];
		$host = $_GET['host'];
		$cate = $_GET['cate'];
		$group = $_GET['type'];

		if (isset($_GET['pageSize'])) {
			$limit = $_GET['pageSize'];
		} else {
			$limit = 20;
		}
		if (isset($_GET['page'])) {
			$offset = ($_GET['page'] - 1) * $limit;
		} else {
			$offset = 0;
		}

		if (isset($user)) {
			$where['username'] = $user;
		}
		
		if (isset($host)) {
			$where['host'] = $host;
		}
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

		/*$start = date("Y-m-d",time());
		$end = date("Y-m-d H:i:s",time());
		$start .= " 00:00:00";
		$where['AND'] = array_merge($where, ["create_at[<>]" => [$start, $end]]);*/
	
		$total = MysqlDb::org_count($table_name, $group, $where);
		if(!$total){
			$total=0;
		}
		$where["GROUP"] = $group;
		$where["ORDER"] = 'cnt DESC';
		$where["LIMIT"] = [$offset, $limit];
		$data = MysqlDb::org_select($table_name, [$group, '[COUNT](cnt)'],  $where);
		if(!$data){
			$data=[];
		}
		$retdata['total'] = $total;
		$retdata['data'] = $data;
		echo json_encode($retdata);
		return;
	}
}
