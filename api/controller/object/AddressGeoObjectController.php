<?php
namespace controller\object;
use controller\mController;
use database\ObjectDb;


class AddressGeoObjectController extends mController{	

	public function post() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new ObjectDb();
		$db->path = '/tmp/obj_show.db';
		$table_name = 'addrgeo';
		
		if($param['name']){
			if($param['lang']=='cn'){
				$where = array(
					'LIMIT' => 300,
					'show_name[~]' => $param['name']			
				);

			}else{
				$where = array(
					'LIMIT' => 300,
					'showname_en[~]' => $param['name']			
				);
			}
			
		}else{
			$where = array(
				'LIMIT' => 300			
			);
		}

		$tmp_data=array();
		$compare_data = array();
		$sql_data = $db-> org_select($table_name, ['name','def','show_name','showname_en'], $where);
		$sql_data_len = count($sql_data);
		if($param['lang']=='cn'){
			foreach($sql_data as $key=>$value){
				$tmp_data[$key]['name'] = $value['name'];
				$tmp_data[$key]['def'] = $value['def'];
				$tmp_data[$key]['show_name'] = $value['show_name'];
				$compare_data[] = $value['show_name'];
			}
		}else{
			foreach($sql_data as $key=>$value){
				$tmp_data[$key]['name'] = $value['name'];
				$tmp_data[$key]['def'] = $value['def'];
				$tmp_data[$key]['show_name'] = $value['showname_en'];
				$compare_data[] = $value['showname_en'];
			}
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
					if($param['lang']=='cn'){
						$compare_where = array('show_name'=>$value['addr_name_cn']);
						if(!in_array($value['addr_name_cn'], $compare_data)){
							$sql_compare_data = $db-> org_select($table_name, ['name','def','show_name','showname_en'], $compare_where);
							if($sql_compare_data){
								$new_arr['name'] = $sql_compare_data[0]['name'];
								$new_arr['def'] = $sql_compare_data[0]['def'];
								$new_arr['show_name']= $sql_compare_data[0]['show_name'];
								array_push($tmp_data,$new_arr);
							}
							//if($sql_data_len<100){
								
							//}else{
							//	$tmp_data[$sql_data_len-1-$key] = $new_arr;
							//}
						}
					}else{
						$compare_where = array('showname_en'=>$value['addr_name']);
						if(!in_array($value['addr_name_cn'], $compare_data)){
							$sql_compare_data = $db-> org_select($table_name, ['name','def','show_name','showname_en'], $compare_where);
							if($sql_compare_data){
								$new_arr['name'] = $sql_compare_data[0]['name'];
								$new_arr['def'] = $sql_compare_data[0]['def'];
								$new_arr['show_name']= $sql_compare_data[0]['showname_en'];
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
		}
		
		$data['data'] = $tmp_data;
		//$stateArr['data'][] = array('state'=> $data[0]);
		echo json_encode($data);
		return;
	}
}
