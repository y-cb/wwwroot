<?php
namespace controller\system;
use lib\AutoReport;
use lib\ReportModel;
use database\DbUtil;
use database\MysqlDb;

Class ReportDayController {
	public $report_file = '/mnt/boot/report_file.json';
	function get(){
		$param = get_inputs();

		$sys_report_list_arr = ReportModel::system_report_get();

		$sys_report_daily = array();
		foreach($sys_report_list_arr as $item){
			if($item->days == "daily"){
				$item = json_decode(json_encode($item), true);
		        $auto_report = new AutoReport($item);
		        $filename = $auto_report->run();

		        $nameArr = explode('/', $filename);
		        report_add($nameArr[count($nameArr)-1]);

		        if($item['flow_app'] == '1') {
					$operate = 'export application flow report';
				} else if ($item['category'] == '1') {
					$operate = 'export application category flow report';
				} else {
					$operate = 'export report';
				}

				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName="'.$_SESSION[CONNECTION.USERNAME].'" Operate="'. $operate .'" ManageStyle=web Content="operation success"';
				$currentDate =  date('Ymd',time());

				if ($_SESSION[PERMISSION]['separation_of_powers'] == 0 || $_SESSION[CONNECTION.USERNAME] == 'audit') {
					if(file_exists('/mnt1/mysql/')) {
						$db = new MysqlDb();
						$table_name = 'config_log_'.$currentDate;
						$sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'20'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".'5'."','".' '."','".$msg."'".')';
						$db->sql_query($sql);
					}else{
						$db = new DBUtil();
						$table = 'CONFIG_LOG';
						$db->addAuditLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);
					}
				} else {
					if(file_exists('/mnt1/mysql/')) {
						$db = new MysqlDb();
						$table_name = 'audit_log_'.$currentDate;
						$sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'20'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".'5'."','".' '."','".$msg."'".')';
						$db->sql_query($sql);
					}else{
						$db = new DBUtil();
						$table = 'AUDIT_LOG';
						$db->addEventLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);
					}
					
				}


		        $send_flag = true;
		        if($item['ftp'] == '1') {
		        	$result = ftp_send_pdf($filename);
		        	if (!$result) {
						$send_flag = false;
						exit;
					}
		        }

		        if($item['email'] == '1') {
		        	$ret = email_send_pdf($item['email_address'], $filename,$item['delete_file']);
					if (!empty($ret)) {
						$send_flag = false;
						return;
					}
		        }

        		if($item['delete_file'] == '1') {
        			if($item['email'] == '1'){
						sleep(1);
						$check_send_state = check_email_send_pdf($item['email_address'], $filename);
						$state_code = $check_send_state['code'];
						while ($state_code==1) {
							sleep(1);
							$check_send_state = check_email_send_pdf($item['email_address'], $filename);
							$state_code = $check_send_state['code'];
						}
						if ($state_code!=0) {
							$send_flag = false;
							$check_send_state['str'] = t('report.send_err');
							return;
						}
					}
					if (file_exists($filename) && $send_flag) {
		                $json = file_get_contents($this->report_file);
		                if ($json) {
							$data = json_decode($json, true);
							unset($data[array_search($nameArr[count($nameArr)-1], $data)]);
							@file_put_contents($this->report_file, json_encode($data));
							@unlink($filename);
						}
		            }
				}
		        unset($auto_report);
		        //每次生成后缓冲5秒
		        sleep(5);
			}
		}
	}
}