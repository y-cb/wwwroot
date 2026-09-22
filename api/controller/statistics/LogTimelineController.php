<?php
namespace controller\statistics;
use controller\mController;
use database\MysqlDb;

class LogTimelineController extends mController {	
	function get(){
		$cur = time();
		$day = strftime("%Y%m%d", $cur);
		$im_table_name = 'instant_message_'. $day;
		$search_table_name = 'search_engine_'. $day;
		$social_table_name = 'social_network_'. $day;
		$email_table_name = 'email_'. $day;
		$file_table_name = 'file_transfer_'. $day;
		$shopping_table_name = 'online_shopping_'. $day;
		$other_table_name = 'app_others_'. $day;
		$table_data=[$im_table_name,$search_table_name,$social_table_name,$email_table_name,$file_table_name,$shopping_table_name,$other_table_name];
		$user = $_GET['user'];

		$database = new MysqlDb();
		$data=[];
		foreach ($table_data as $key => $value) {
			$database_data = $database->org_select($value,'*' ,  ["LIMIT" => 1,  "username" => $user, "ORDER" => "create_at DESC"]);
			if($database_data){
				$data[] = $database_data;
			}
		}
		usort($data,function($oba,$obb){
            if( strtotime($oba[0]['create_at'])<strtotime($obb[0]['create_at']) ){
            	return -1;
            }else{
            	return 1;
            }
        });
		echo json_encode($data);
		return;
	}

	
}
