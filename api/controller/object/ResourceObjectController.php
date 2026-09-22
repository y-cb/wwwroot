<?php
namespace controller\object;
use controller\mController;
use database\ObjectDb;


class ResourceObjectController extends mController{	

	public function post() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new ObjectDb();
		$db->path = '/tmp/obj_show.db';
		$table_name = 'uresobj';
		
		if($param['name']){
			$where = array(
				'LIMIT' => 1000,
				'name[~]' => $param['name']			
			);
		}else{
			$where = array(
				'LIMIT' => 1000			
			);
		}

		$tmp_data=array();
		$compare_data = array();
		$sql_data = $db-> org_select($table_name, ['name'], $where);
		$sql_data_len = count($sql_data);
		foreach($sql_data as $key=>$value){
			$tmp_data[$key]['name'] = $value['name'];
			$compare_data[] = $value['name'];
		}
		if($param['isTransfer']){//解决穿梭框超过100个之后数据显示问题
			if($param['name_arr']){
				$name_arr_len = count($param['name']);
				$name_arr = $param['name_arr'];
				if($name_arr['resource_obj']){
					$name_arr[0]['resource_obj'] = $name_arr['resource_obj'];
				}
				foreach($name_arr as $key=>$value){
					if(!in_array($value['resource_obj'], $compare_data)){//当穿梭框选中数据不在前100个数据中
						$compare_where = array('name'=>$value['resource_obj']);
						$sql_compare_data = $db-> org_select($table_name, ['name'], $compare_where);
						if($sql_compare_data){
							$new_arr['name'] = $sql_compare_data[0]['name'];
							array_push($tmp_data,$new_arr);
						}
						/*if($sql_data_len<100){
							array_push($tmp_data,$new_arr);
						}else{
							$tmp_data[$sql_data_len-1-$key]['name'] = $new_arr['name'];//选中数据在100个之后，则替换前100个中的对应下标100-key数据
						}*/

					}
				}
			}
		}
		$data['data'] = $tmp_data;
		//$stateArr['data'][] = array('state'=> $data[0]);
		echo json_encode($data);
		return;
	}
}
