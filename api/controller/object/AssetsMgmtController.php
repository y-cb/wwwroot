<?php
namespace controller\object;
use controller\mController;
use database\AssetsDb;
use lib\Json2Csv;


class AssetsMgmtController extends mController{	
	public $module = 'assets_mgmt';
	function get(){

		$table = 'assets';
		$col_a = array();
		$ip = trim($_GET['ip']);
		$user_name = $_GET['user_name'];
		$desc = $_GET['desc'];
		$party = $_GET['party'];
		$importance = $_GET['importance'];
		$os = $_GET['os'];
		$service = $_GET['service'];
		$source = $_GET['source'];
		$state = $_GET['state'];

		$page_num = $_GET['page'];
		$page_num = $page_num == 0? 1 : $page_num;
		$page_count = $_GET['pageSize'];
		$db = new AssetsDb();

		if($ip!=null){
			$col_a['ip'] = $ip;
		}
		if($desc!=null){
			$col_a['desc'] = $desc;
		}
		if($user_name!=null){
			$col_a['name'] = $user_name;
		}
		if($party!=null){
			$col_a['part'] = $party;
		}
		if($importance!=null && $importance!=' '){
			$col_a['importance'] = $importance;
		}
		if($os!=null&& $os!=' '){
			$col_a['os'] = $os;
		}
		if($service!=null){
			$col_a['service'] = $service;
		}
		if($source!=null){
			$col_a['source'] = $source;
		}
		if($state!=null&&$state!=' '){
			$col_a['state'] = $state;
		}

		$items = $db->queryForList($table, $col_a, $page_num, $page_count);
		$total = $db->getCount($table, $col_a);
		$group = array();
		$group['data'] = $items;
		$group['total']  = (int)$total;
		if(!isset($_GET['download'])){
			echo json_encode($group);
		}else{
			$data_list=$db->get_list(10000,$table,$col_a);
			$data_json = json_encode($data_list);
			$data_res = Json2Csv::json_csv($data_json);
			$callEndTime =date('YmdHis',time());
			$contTypeArr = array(
				'TXT' => 'Content-type: application/txt;',
				'CSV' => 'Content-type:application/vnd.ms-excel;',
				'XML' => 'Content-Type: text/xml;'
			);
			$file_name = 'assets_'.$callEndTime.'.csv';

			unlink($syslog_tmpfile);
			unlink($auditlog_tmpfile);
			Header($contTypeArr['CSV'].' charset=utf-8');
			Header('Content-Disposition: attachment;filename="'.$file_name.'"');
			Header('Cache-Control: max-age=0'); 
			echo $data_res;
		}
		

	}
}