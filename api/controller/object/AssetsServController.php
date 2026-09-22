<?php
namespace controller\object;
use controller\mController;
use database\AssetsDb;
use lib\Json2Csv;


class AssetsServController extends mController{	
	/*function get(){
		$ip = str_replace('.','_',trim($_GET['ip']));
		$ip = str_replace(':','_',trim($ip));
		$table = 'service_'.$ip;
		$col_a = array();

		$page_num = $_GET['page'];
		$page_num = $page_num == 0? 1 : $page_num;
		$page_count = $_GET['pageSize'];
		$db = new AssetsDb();
		$items = $db->queryForList($table, $col_a, $page_num, $page_count);
		$total = $db->getCount($table, $col_a);
		$group = array();
		$group['data'] = $items;
		$group['total']  = (int)$total;
		echo json_encode($group);
	}*/
	function get(){
		$ip = trim($_GET['ip']);
		$table = 'assets';
		$col_a = array();
		$col_a['ip'] = $ip;

		$page_num = $_GET['page'];
		$page_num = $page_num == 0? 1 : $page_num;
		$page_count = $_GET['pageSize'];
		$db = new AssetsDb();
		$items = $db->queryForList($table, $col_a, 1, $page_count);
		$service_str = $items[0]['service'];
		$service = explode(";", $service_str);
		$service = array_filter($service);//去除空内容
		$start = ($page_num-1)*$page_count;
		$service_items = array_slice($service,$start,$page_count);
		//var_dump($service,123);
		$total = count($service);
		$group = array();
		$group['data'] = $service_items;
		$group['total']  = (int)$total;
		echo json_encode($group);
	}
}