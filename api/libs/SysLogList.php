<?php
namespace lib;
use database\DbUtil;
use lib\FunInc;
use lib\LocalUtil;

class SysLogList{
	function get_list($filenum,$counts_all,$table,$col_a,$page_num,$page_count,$one_sheet_items,$log_type){
		$db = new DBUtil();
		$filenum_type =$filenum;//输出类型
		set_time_limit(300);
		ignore_user_abort(true);
		$n = 1;
		//三权分立验证功能
		if (!empty($_SESSION[CONNECTION.ACCESS])) {
			$module = $table;
			$rspString = getResponse($module, "clear" ,'', '');
			$data = getAssign($rspString, $module);
			if ($data) {
				return;
			}
		}
		//导出当前页
		if ($filenum_type=="one"){

				$out_list = self::printFile($one_sheet_items,$log_type);

		  }else if($filenum_type=="all" && $counts_all <= 50000){

				if($log_type=="av"){
					$items = self::get_nodisk_items("av");
				}else if($log_type=="ips"){
					$items = self::get_nodisk_items("ips");
				}else{
					$items = $db->queryForList($table, $col_a, $n,10000);
				}

				$out_list = self::printFile($items,$log_type);

		  }else if($filenum_type=="all" && $counts_all >= 50000){

		  		if($log_type=="av"){
					$items = self::get_nodisk_items("av");
				}else if($log_type=="ips"){
					$items = self::get_nodisk_items("ips");
				}else{
					$items = $db->queryForList($table, $col_a, $n,10000);
				}
				
				$out_list = self::printFile($items,$log_type);
		}

		return $out_list;
	}
	
	 function printFile($items,$log_type){
		
		$cnt = 1;
		$list_arr = [];
		foreach($items as $k => $item) { 
			//var_dump($item);
			$cnt ++;
			if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
				ob_flush();
				flush();
				$cnt = 0;
			}
			$daemon = t('log.module'.$item['daemon']);
			$level = t('log.level'.$item['level']);
			$msg = $item['msg'];

			$src = $item['SrcIP'];
			$dst = $item['DstIP'];
			$sport = $item['SrcPort'];
			$dport = $item['DstPort'];
			$action = $item['Action'];

			$file = $item['VirusFileName'];
			$virus = $item['VirusName'];

			$event = $item['EventName'];
			$type = $item['SecurityType'];

			if($log_type=='ips'){
				
				$proto = $item['ProtocolType'];
				
				$daemon = "IPS";

				$row = array("ID"=>$item["id"],"time"=>$item["time"],"daemon"=>$daemon,"level"=>$level,"srcip"=>$src,"dstip"=>$dst,"srcport"=>$sport,"dstport"=>$dport,"protocol"=>$proto,"eventname"=>$event,"eventtype"=>$type,"action"=>$action);
			}else if($log_type=='av'){
				$daemon = "AV";	
				$proto = $item['Protocol'];
				$row = array("ID"=>$item["id"],"time"=>$item["time"],"daemon"=>$daemon,"level"=>$level,"srcip"=>$src,"dstip"=>$dst,"srcport"=>$sport,"dstport"=>$dport,"protocol"=>$proto,"avfile"=>$file,"avfilename"=>$virus,"action"=>$action);
			} else if($log_type == 'apt'){
				if ($item['result'] == 0) {
					$result = t('log.security');
				} else if ($item['result'] == 1){
					$result = t('log.low_risk');
				} else if ($item['result'] == 2) {
					$result = t('log.medium_risk');
				} else {
					$result = t('log.high_risk');
				}
				$time = date("Y-m-d H:i:s",$item["time"]);
				$row = array("ID"=>$item["ID"],"time"=>$time,"filename"=>$item['name'],"filesize"=>$item['filelen'],"srcip"=>$item['srcIp'],"dstip"=>$item['dstIp'],"filetype"=>$item['filetype'],"proto"=>$item['Proto'],"result"=>$result);
			} else {
				$row = array("ID"=>$item["ID"],"time"=>$item["time"],"daemon"=>$daemon,"level"=>$level,"msg"=>$msg);
			}

			//$daemon = mb_convert_encoding($daemon,'gbk','utf-8');
			//$level = mb_convert_encoding($level, 'gbk','utf-8');
			//$msg = mb_convert_encoding($msg, 'gbk', 'utf-8');
			//$row = $item["ID"]."\t".$item["time"]."\t".$daemon."\t".$level."\t".$msg."\t\r\n";
			
			//$row = array("ID"=>$item["ID"],"time"=>$item["time"],"daemon"=>$daemon,"level"=>$level,"msg"=>$msg);

			$list_arr[]=$row;
			
			unset($row);
		}

		return $list_arr;
	 }


	 function get_nodisk_items($log_type){
	 	if($log_type=="av"){
	 		$module_name = "av_log";
	 	}
	 	if($log_type=="ips"){
	 		$module_name = "ips_log";
	 	}
	 	$item = array();

		for ($i = 1; $i < 100; $i++) {
			$param['page'] = $i;
			$param['count'] = 20;

			$rspString = getResponse($module_name, "show" , $param, '');
			$sec_setting_list_arr = getAssign($rspString, $module_name, 0);	

			$num = count($sec_setting_list_arr[group]);

			if (sizeof($sec_setting_list_arr[group]) == 0 || !isset($sec_setting_list_arr[group])) {
				break;
			}

			if ($num > 0) {
				$index = $num - 1;
				$total =$sec_setting_list_arr[group][$index][total];
				array_pop($sec_setting_list_arr[group]);
			}

			$item = array_merge($item, $sec_setting_list_arr[group]);
		}
		return $item;
	 }
}
?>
