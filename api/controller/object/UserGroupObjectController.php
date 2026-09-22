<?php
namespace controller\object;
use controller\mController;
use database\ObjectDb;


class UserGroupObjectController extends mController{	

	public function post() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new ObjectDb();
		$db->path = '/tmp/obj_show.db';
		$table_name = 'usergroup';
		
		if($param['name']){
			if($param['lang']=='cn'){
				$where = array(
					'LIMIT' => 1000,
					'show_name[~]' => $param['name']			
				);

			}else{
				$where = array(
					'LIMIT' => 1000,
					'name[~]' => $param['name']			
				);
			}
			
		}else{
			$where = array(
				'LIMIT' => 1000			
			);
		}

		$tmp_data=array();
		$compare_data = array();
		$sql_data = $db-> org_select($table_name, ['name','predefined','show_name'], $where);
		if($param['lang']=='cn'){
			foreach($sql_data as $key=>$value){
				$tmp_data[$key]['name'] = $value['name'];
				$tmp_data[$key]['predefined'] = $value['predefined'];
				$tmp_data[$key]['show_name'] = $value['show_name'];
				$compare_data[] = $value['show_name'];
			}
		}else{
			foreach($sql_data as $key=>$value){
				$tmp_data[$key]['name'] = $value['name'];
				$tmp_data[$key]['predefined'] = $value['predefined'];
				$tmp_data[$key]['show_name'] = $value['name'];
				$compare_data[] = $value['name'];
			}
		}
		if($param['isTransfer']){//解决穿梭框超过100个之后数据显示问题
			if($param['name_arr']){
				$name_arr_len = count($param['name_arr']);
				$name_arr = $param['name_arr'];
				if($name_arr['name']){
					$name_arr[0]['name'] = $name_arr['name'];
					$name_arr[0]['show_name'] = $name_arr['show_name'];
				}
				$tmp_name_arr = array();
				foreach($name_arr as $key=>$value){
					$tmp_name_arr[] = $value['name'];
					if($param['lang']=='cn'){
						$compare_where = array('show_name'=>$value['show_name']);
						if(!in_array($value['show_name'], $compare_data)){
							$sql_compare_data = $db-> org_select($table_name, ['name','predefined','show_name'], $compare_where);
							if($sql_compare_data){
								$new_arr['name'] = $sql_compare_data[0]['name'];
								$new_arr['predefined'] = $sql_compare_data[0]['predefined'];
								$new_arr['show_name']= $sql_compare_data[0]['show_name'];
								array_push($tmp_data,$new_arr);
							}
							//if($sql_data_len<100){
								
							//}else{
							//	$tmp_data[$sql_data_len-1-$key] = $new_arr;
							//}
						}
					}else{
						$compare_where = array('show_name'=>$value['name']);
						if(!in_array($value['show_name'], $compare_data)){
							$sql_compare_data = $db-> org_select($table_name, ['name','predefined','show_name'], $compare_where);
							if($sql_compare_data){
								$new_arr['name'] = $sql_compare_data[0]['name'];
								$new_arr['predefined'] = $sql_compare_data[0]['predefined'];
								$new_arr['show_name']= $sql_compare_data[0]['name'];
								array_push($tmp_data,$new_arr);
							}
							
							//if($sql_data_len<100){
								
							//}else{
							//	$tmp_data[$sql_data_len-1-$key] = $new_arr;
							//}
						}
					}
					
					
				}
				/*$tmp_data_count = count($tmp_data);//左右穿梭框总数据
				if($tmp_data_count>1000){//确保前端请求返回数据不超过1000个
					$tmp_all_data = array();
					for($i=$tmp_data_count-1;$i>=0;$i--){
						if($tmp_data_count<=1000){
							break;
						}
						if(!in_array($tmp_data[$i]['name'],$tmp_name_arr) && $tmp_data_count>1000){
							unset($tmp_data[$i]);//未改变数组的原有索引
							$tmp_data_count--;
						}
					}
					$tmp_data = array_values($tmp_data);//重排索引（让索引从0开始，并且连续）
				}*/
			}
		}
		$data['data'] = $tmp_data;
		//$stateArr['data'][] = array('state'=> $data[0]);
		echo json_encode($data);
		return;
	}
}
