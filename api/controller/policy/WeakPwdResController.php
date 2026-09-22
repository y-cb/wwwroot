<?php
namespace controller\policy;
use controller\mController;
use database\ScanUtil;
use lib\Json2Csv;
use lib\WriteLog;
/**
 * @api {GET}  /api/port_scan_result 获取扫描结果
 * @apiName sys-port_scan_result
 * @apiGroup 获取扫描结果
 *
 *
 * @apiSuccess {Number} id 结果ID
 * @apiSuccess {String} infor 扫描信息
 * @apiSuccess {String} result 扫描结果
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 	    data: [{0: "76",…}]
		0: {0: "76",…}
			0: "76"
			1: "{"normal_port":"23,25","scan_time":"0","time_type":"week","time":"NaN:NaN","assets_sync":"0","fuzzy_port":"0","ip_items":[{"ip_range1":"172.16.0.153","ip_range2":"172.16.0.158","type":"2"}],"custom_port_enable":"0","name":"hhhh","desc":"","week":"","status":"0","lang":"cn"}"
			2: "{"0":{"ip":"172.16.0.153","service":"23\/tcp open   telnet;25\/tcp closed smtp;"},"1":{"ip":"172.16.0.156","service":"23\/tcp closed telnet;25\/tcp closed smtp;"},"2":{"ip":"172.16.0.158","service":"23\/tcp open   telnet;25\/tcp closed smtp;"},"status":"1"}"

			id: "76"
			infor: "{"normal_port":"23,25","scan_time":"0","time_type":"week","time":"NaN:NaN","assets_sync":"0","fuzzy_port":"0","ip_items":[{"ip_range1":"172.16.0.153","ip_range2":"172.16.0.158","type":"2"}],"custom_port_enable":"0","name":"hhhh","desc":"","week":"","status":"0","lang":"cn"}"
			result: "{"0":{"ip":"172.16.0.153","service":"23\/tcp open   telnet;25\/tcp closed smtp;"},"1":{"ip":"172.16.0.156","service":"23\/tcp closed telnet;25\/tcp closed smtp;"},"2":{"ip":"172.16.0.158","service":"23\/tcp open   telnet;25\/tcp closed smtp;"},"status":"1"}"
		total: 21
 *	}
 */

class WeakPwdResController extends mController{


	
	function get(){
		$param = get_inputs();
		if($param['download']==1){//导出信息
			$id = $param['id'];
			$db = new ScanUtil();
			$onedata = $db->getInfoOne('weakpwdscan_log',$id);
			
			$data_json = $onedata['result'];
			
			$data_res = Json2Csv::json_csv($data_json);

			$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="download weakpwdscan scan result" ManageStyle=web Content="operation success"';
		    WriteLog::ConfigWrite($msg);

			$callEndTime =date('YmdHis',time());
			
			$file_name = 'scanlog_'.$callEndTime.'.csv';

			unlink($syslog_tmpfile);
			unlink($auditlog_tmpfile);
			Header('Content-type:application/vnd.ms-excel; charset=utf-8');
			Header('Content-Disposition: attachment;filename="'.$file_name.'"');
			Header('Cache-Control: max-age=0'); 

			echo $data_res; 
		}else{
			
			$page_num = $param['page']?$param['page']:1;
			$page_count = $param['pageSize'];
			$start_num = ($page_num-1)*$page_count;
			
			$db = new ScanUtil();
			$alldata = $db->getInfo('weakpwdscan_log');  //获取数据
			$total = count($alldata);

			for($i=0;$i<$page_count;$i++){
				if(isset($alldata[$start_num+$i])){
					$paged_sys_token_list_arr[] =  $alldata[$start_num+$i];
				}	
			}

			$data = array();
			$data['total'] = $total;
			$data['data'] = $paged_sys_token_list_arr;
			echo json_encode($data);	
		}
		return;
	}
	
	function post(){
		


	}


	function delete(){
		$param = get_inputs();
		//var_dump($param[id]);
		$id = $param[id];
		$db = new ScanUtil();
		$db->deleInfo('weakpwdscan_log',$id);
		$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="delete weakpassword scan result" ManageStyle=web Content="operation success"';
		WriteLog::ConfigWrite($msg);
		
	}


}
