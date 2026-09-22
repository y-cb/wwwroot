<?php
namespace controller\object;
use controller\mController;
use database\ObjectDb;


class AddressObjectController extends mController{	

	public function post() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new ObjectDb();
		$db->path = '/tmp/obj_show.db';
		$table_name = 'addrobj';
		
		if($param['name']){
			$where = array(
				'LIMIT' => 1008,
				'name[~]' => $param['name']			
			);
		}else{
			$where = array(
				'LIMIT' => 1008			
			);
		}

		$tmp_data=array();
		$compare_data = array();
		$sql_data = $db-> org_select($table_name, ['name','def'], $where);
		$sql_data_len = count($sql_data);
		foreach($sql_data as $key=>$value){
			$tmp_data[$key]['name'] = $value['name'];
			$tmp_data[$key]['def'] = $value['def'];
			$compare_data[] = $value['name'];
		}
		if($param['isTransfer']){//解决穿梭框超过100个之后数据显示问题
			if($param['name_arr']){
				$name_arr_len = count($param['name_arr']);
				$name_arr = $param['name_arr'];
				if($name_arr['addr_name']){
					$name_arr[0]['addr_name'] = $name_arr['addr_name'];
					$name_arr[0]['addr_name_cn'] = $name_arr['addr_name_cn'];
				}
				foreach($name_arr as $key=>$value){
					if(!in_array($value['addr_name'], $compare_data)){
						$compare_where = array('name'=>$value['addr_name']);
						$sql_compare_data = $db-> org_select($table_name, ['name','def'], $compare_where);
						if($sql_compare_data){
							$new_arr['name'] = $sql_compare_data[0]['name'];
							$new_arr['def'] = $sql_compare_data[0]['def'];
							array_push($tmp_data,$new_arr);
						}
						//if($sql_data_len<100){
							
						//}else{
						//	$tmp_data[$sql_data_len-1-$key] = $new_arr;
						//}

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
