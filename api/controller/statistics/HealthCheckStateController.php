<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;


class HealthCheckStateController extends mController{	
	// public $module = 'healthcheck_state';
	public function get() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new StatisticDb();
		$db->path = '/tmp/hm_statistics.db';

		if ($param['name']){
			$table_name = '_state_'.md5($param['name'].'_'.$param['inf']);
		}

		if ($table_name){
			$where = array(
				'LIMIT' => 1,
				'ORDER' => 'time DESC',				
			);

			$data = $db-> org_select($table_name, 'state', $where);
		}
		if (empty($data)) {
			$data = array('1');
		}

		$stateArr['data'][] = array('state'=> $data[0]);
		echo json_encode($stateArr);
		return;
	}
}
