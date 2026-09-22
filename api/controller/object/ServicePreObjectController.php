<?php
namespace controller\object;
use controller\mController;
use database\ObjectDb;


class ServicePreObjectController extends mController{	

	public function get() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new ObjectDb();
		$db->path = '/tmp/obj_show.db';
		$table_name = 'prepservice';
		
		if($param['name']){
			$where = array(
				'LIMIT' => 100,
				'name[~]' => $param['name']			
			);
		}else{
			$where = array(
				'LIMIT' => 100			
			);
		}

		$tmp_data=array();
		$sql_data = $db-> org_select($table_name, ['name'], $where);
		foreach($sql_data as $key=>$value){
			$tmp_data[$key]['name'] = $value['name'];
		}
		$data['data'] = $tmp_data;
		//$stateArr['data'][] = array('state'=> $data[0]);
		echo json_encode($data);
		return;
	}
}
