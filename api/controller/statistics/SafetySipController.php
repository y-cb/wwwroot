<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/ips-sip 获取入侵防护统计TOP10攻击源IP
 * @apiName 获取入侵防护统计TOP10攻击源IP
 * @apiGroup 入侵防护统计
 *
 *
 * @apiSuccess {String} name 攻击源IP名称
 * @apiSuccess {Number} count 攻击次数
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "1.2.3.4",
 *			"count": "10"
 *		},
 *		{
 *			"name": "2.3.4.5",
 *			"count": "8"
 *		}
 *	],
 *	"total": 2
 *	}
 */


use database\MysqlDb;

class SafetySipController extends mController {	
	function get(){
		if(file_exists('/mnt1/mysql/')) {
			$cur = time();
			$day = strftime("%Y%m%d", $cur);
			$day1 = strftime("%Y%m%d", $cur-24*60*60);
			$day2= strftime("%Y%m%d",$cur-2*24*60*60);

			$time_type = $_GET['time_type'];
			$page_num = $_GET['page'];
			$page_num = $page_num == 0? 1 : $page_num;
			$page_count = $_GET['pageSize']?$_GET['pageSize']:10;
			$start = (($page_num - 1) * $page_count);
			$start = $start < 0 ? 0 : $start;

			$ips_table_name = 'ips_'. $day;
			//$ips_table_name = 'ips_20201109';
			$ips_table_name1 = 'ips_'. $day1;
			//$ips_table_name1 = 'ips_20201110';
			$ips_table_name2 = 'ips_'. $day2;

			$av_table_name = 'av_'. $day;
			//$av_table_name = 'av_20201106';
			$av_table_name1 = 'av_'. $day1;
			//$av_table_name1 = 'av_20201111';
			$av_table_name2 = 'av_'. $day2;

			if($time_type=='1'){
				$all_tb_arr = [$ips_table_name,$av_table_name];
			}else{
				$ips_tb_arr = [$ips_table_name,$ips_table_name1,$ips_table_name2];
				$av_tb_arr = [$av_table_name,$av_table_name1,$av_table_name2];
				$all_tb_arr = array_merge($ips_tb_arr, $av_tb_arr);
			}

			
			$all_real_arr=[];

			foreach ($all_tb_arr as $key => $value) {
				$sql= "SHOW TABLES LIKE "."'%".$value."%'";
				$sql_query = MysqlDb::sql_query($sql);
				if(!empty($sql_query)){
					array_push($all_real_arr,$value);
				}
			}

			if(empty($all_real_arr)){
				$data = [];
			}else{
				if(sizeof($all_real_arr)==1){
//					$sql = "SELECT attacker,country,max(create_at) as max_created,min(create_at) as min_created,COUNT(*) AS cnt FROM ".$all_real_arr[0]." GROUP BY attacker ORDER BY cnt DESC LIMIT ".$page_count." OFFSET ".$start;
                    $sql = "SELECT attacker,country,max(create_at) as max_created,min(create_at) as min_created,COUNT(*) AS cnt FROM ".$all_real_arr[0]." GROUP BY attacker ORDER BY cnt DESC";
                }else{
					$arr_len = sizeof($all_real_arr);
					$sql_cnt="SELECT attacker,country,max(create_at) as max_created,min(create_at) as min_created,COUNT(*) AS cnt FROM (";
					foreach ($all_real_arr as $key => $value){
						if($key!=$arr_len-1){
							$sql_cnt = $sql_cnt."SELECT attacker,country,create_at FROM ".$value." UNION ALL ";
						}else{
							$sql_cnt = $sql_cnt."SELECT attacker,country,create_at FROM ".$value;
						}
					}
//					$sql = $sql_cnt." ) as alias GROUP BY attacker ORDER BY cnt DESC Limit ".$page_count." OFFSET ".$start;
                    $sql = $sql_cnt." ) as alias GROUP BY attacker ORDER BY cnt DESC";
					//$sql = $sql_cnt." ) as alias GROUP BY srcip ORDER BY cnt DESC";

				}
				$sql_data = MysqlDb::sql_query($sql);
//                $sql_list = MysqlDb::sql_query($sql1);
			}

			//$data = MysqlDb::org_select($ips_table_name, [ 'srcip', '[COUNT](cnt)'],  ["LIMIT" => 10,  "GROUP" => "srcip", "ORDER" => "cnt DESC"]);
			//$av_data = MysqlDb::org_select($av_table_name, [ 'srcip', '[COUNT](cnt)'],  ["LIMIT" => 10,  "GROUP" => "srcip", "ORDER" => "cnt DESC"]);

			//$sql = "SELECT srcip,COUNT(*) AS cnt FROM ips_20201110 GROUP BY srcip ORDER BY cnt DESC LIMIT 10";//ok
			//$sql = "SELECT 'srcip',COUNT(*) AS 'cnt' FROM ".$ips_table_name." GROUP BY 'srcip' ORDER BY 'cnt' DESC LIMIT 10";//error
			//$sql = 'SELECT "srcip",COUNT(*) AS "cnt" FROM "ips_20201110" GROUP BY "srcip" ORDER BY "cnt" DESC LIMIT 10';//ok
			//$sql = "SELECT srcip,COUNT(*) AS cnt FROM ".$ips_table_name." GROUP BY srcip ORDER BY cnt DESC LIMIT 10";//ok
			//$sql="SELECT srcip,COUNT(*) AS cnt FROM (SELECT srcip FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME=".$ips_table_name." UNION ALL SELECT srcip FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME=".$av_table_name." ) as alias GROUP BY srcip ORDER BY cnt DESC LIMIT 10";
			//$sql="SELECT srcip,max(create_at) as max_created,min(create_at) as min_created,COUNT(*) AS cnt FROM (SELECT srcip,create_at FROM ".$ips_table_name." UNION ALL SELECT srcip,create_at FROM ".$av_table_name." ) as alias GROUP BY srcip ORDER BY cnt DESC";// LIMIT 10";
			
			//$sql="SELECT COUNT(*) FROM( SELECT COUNT(*) AS cnt FROM (SELECT srcip FROM ".$ips_table_name." UNION ALL SELECT srcip FROM ".$av_table_name." ) as alias GROUP BY srcip ORDER BY cnt DESC)";

			//$sql="SELECT srcip,max(create_at) as max_created,min(create_at) as min_created,COUNT(*) AS cnt FROM (SELECT srcip,create_at FROM ".$ips_table_name." UNION ALL SELECT srcip,create_at FROM ".$av_table_name." ) as alias GROUP BY srcip ORDER BY cnt DESC Limit ".$page_count." OFFSET ".$start;

			//$sql = 'SELECT * FROM '.$table.' WHERE 1 = 1 '.$sql_daemon.$sql_time.$sql_tmp.$sql_srcip.$sql_dstip.' ORDER BY id DESC LIMIT :page_count OFFSET :start';
			//$sql="SELECT srcip,COUNT(*) AS cnt FROM (SELECT srcip FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME=".$ips_table_name." UNION ALL SELECT srcip FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME=".$av_table_name." ) as alias GROUP BY srcip ORDER BY cnt DESC LIMIT 10";
			//$data = MysqlDb::sql_query($sql);
			




		}else{
			$ips_module = 'sys_top_attack_monitor';
			$ips_param['top_n'] = 9;
			$ips_param['type'] = 1;
			$ips_rspString = getResponse($ips_module, "show" ,$ips_param);
			$ips_ret = getAssign($ips_rspString, $ips_module, false, true);
			if (!empty($ips_ret)){
				for($i=0;$i<count($ips_ret['group']);$i++){
					$ips_ret['group'][$i]['srcip'] = $ips_ret['group'][$i]['name'];
					$ips_ret['group'][$i]['cnt'] = $ips_ret['group'][$i]['count'];
				}
				$ips_data = $ips_ret['group'];				
			}



			$av_module = 'sys_top_virus_monitor';
			$av_param['top_n'] = 9;
			$av_param['type'] = 1;
			$av_rspString = getResponse($av_module, "show" ,$av_param);
			$av_ret = getAssign($av_rspString, $av_module, false, true);
			if (!empty($av_ret)){
				for($i=0;$i<count($av_ret['group']);$i++){
					$av_ret['group'][$i]['srcip'] = $ret['group'][$i]['name'];
					$av_ret['group'][$i]['cnt'] = $ret['group'][$i]['count'];
				}
				$av_data = $av_ret['group'];				
			}
		}
		//$data = array_merge($ips_data,$av_data);
		$data['data'] = $sql_data;
		$data['total'] = (int)count($sql_data);
		/*if(!$data){
			$data=[];
		}*/
		echo json_encode($data);
		return;	
	}
}
