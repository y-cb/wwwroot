<?php
namespace controller\object;
use controller\mController;
use database\ObjectDb;


class ServiceObjectController extends mController{	

	public function post() {
		$param = get_inputs();
		//可自定义定义数据库文件位置
		$db = new ObjectDb();
		$db->path = '/tmp/obj_show.db';
		$table_name = 'defiservice';
		
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
				$name_arr_len = count($param['name_arr']);
				$name_arr = $param['name_arr'];
				if($name_arr['sev_name']){
					$name_arr[0]['sev_name'] = $name_arr['sev_name'];
				}
				$tmp_name_arr = array();
				foreach($name_arr as $key=>$value){
					$tmp_name_arr[] = $value['sev_name'];
					if(!in_array($value['sev_name'], $compare_data)){
						$compare_where = array('name'=>$value['sev_name']);
						$sql_compare_data = $db-> org_select($table_name, ['name'], $compare_where);
						if($sql_compare_data){
							$new_arr['name'] = $sql_compare_data[0]['name'];
							array_push($tmp_data,$new_arr);
						}
						/*if($sql_data_len<100){
							array_push($tmp_data,$new_arr);
						}else{
							$tmp_data[$sql_data_len-1-$key] = $new_arr;
						}*/

					}
				}
				$tmp_data_count = count($tmp_data);//左右穿梭框总数据
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
				}
			}
		}
		$data['data'] = $tmp_data;
		//$stateArr['data'][] = array('state'=> $data[0]);
		echo json_encode($data);
		return;
	}
}
