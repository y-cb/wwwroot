<?php
namespace controller\syslog;
use database\DbUtil;
use lib\Json2Txt;
use lib\Json2Csv;
use lib\Arr2Xml;
use lib\SysLogList;
use lib\LocalUtil;
use lib\Util;
use controller\Controller;
use lib\RegularMatching;
/**
 * @api {GET}  /api/sys-log 获取日志信息
 * @apiName sys-log
 * @apiGroup 日志信息获取
 *
 *
 * @apiParam {String} type 1代表系统日志，2代表安全日志，3代表NAT日志，4代表应用控制日志，5代表操作日志，av代表无硬盘设备病毒防护日志，ips代表无硬盘设备ips防护日志
 * @apiParam {Number} page 分页，默认为1
 * @apiParam {Number} pageSize 页码，默认为10
 * @apiParam {Timestamp} start_time 开始时间，选填，格式：Y-m-d H:i
 * @apiParam {Timestamp} end_time 结束时间，选填，开始时间和结束时间需一起填写，格式：Y-m-d H:i
 * @apiParam {Number} level 日志等级，选填项，默认返回全部，0代表紧急，1代表告警，2代表严重，3代表错误，4代表警告，5代表通知，6代表信息
 * @apiParam {Number} ids 信息类型，系统日志、操作日志、安全日志使用，选填项，多选用逗号分隔，2：DDOS攻击，，14：防火墙策略，17：HA事件，20：系统事件，21：告警事件，22：接口信息，23：配置审计，24：SCAN攻击，26：OSPF事件，27：RIP事件，28：QOS事件，55：BGP事件，60:VRRP事件，63：Flood攻击，64：沙箱检测，65：威胁情报，76：审计事件
 * @apiParam {String} sip 源ip，选填项，除系统日志外，其他可查询
 * @apiParam {String} dip 目的ip，选填项，除系统日志，操作日志外，其他可查询
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type": "1",
 *		"page": "1",
 *		"pageSize": "10"
 *	}
 *
 * @apiSuccess {Number} ID 日志ID
 * @apiSuccess {Number} daemon 日志类型，数字与查询参数对应
 * @apiSuccess {Timestamp} time 日志生成时间
 * @apiSuccess {String} type 日志类型，系统日志字段，IF_INFO：接口信息，SYS_INFO：系统日志，SYSTEM_INFO：系统日志，WARNING_INFO：告警事件，CONFIG：配置审计，ATTACK：DDOS攻击，SCAN：SCAN攻击，FILTER：防火墙策略，FLOOD：Flood攻击，DEFENSE：威胁情报
 * @apiSuccess {Number} level 日志级别，数字与查询参数对应
 * @apiSuccess {String} UserName 管理员名称，操作日志字段
 * @apiSuccess {String} SrcIP 源IP，除系统日志、安全日志外，其余日志都有此字段
 * @apiSuccess {String} DstIP 目的IP，除系统日志、操作日志、安全日志外，其余日志都有此字段
 * @apiSuccess {String} ManageStyle 管理方式，操作日志字段
 * @apiSuccess {String} Operate 操作，操作日志字段
 * @apiSuccess {String} Content 结果，操作日志字段
 * @apiSuccess {String} SrcPort 源端口，NAT日志字段
 * @apiSuccess {String} DstPort 目的端口，NAT日志字段
 * @apiSuccess {String} DstPort 目的端口，NAT日志字段
 * @apiSuccess {String} BeforeTransAddr 转换前地址，NAT日志字段
 * @apiSuccess {String} BeforeTransPort 转换前端口，NAT日志字段
 * @apiSuccess {String} AfterTransAddr 转换后地址，NAT日志字段
 * @apiSuccess {String} AfterTransPort 转换后端口，NAT日志字段
 * @apiSuccess {String} PolicyId 策略/规则ID，应用控制日志字段
 * @apiSuccess {String} Protocol 协议，应用控制日志字段
 * @apiSuccess {String} SrcPort 源端口，NAT日志、应用控制日志、入侵防护日志、病毒防护日志字段
 * @apiSuccess {String} DstPort 目的端口，NAT日志、应用控制日志、入侵防护日志、病毒防护日志字段
 * @apiSuccess {String} AppName 应用名称，应用控制日志字段
 * @apiSuccess {String} AppAction 应用行为，应用控制日志字段
 * @apiSuccess {String} Action 应用行为，应用控制日志字段
 * @apiSuccess {String} EventName 事件名称，入侵防护日志字段
 * @apiSuccess {String} SecurityType 安全类型，入侵防护日志字段
 * @apiSuccess {String} count 次数，入侵防护日志字段
 * @apiSuccess {String} VirusName 病毒名称，病毒防护日志字段
 * @apiSuccess {String} VirusFileName 文件名，病毒防护日志字段
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	    "data": [
 *	        {
 *	            "0": "23186",
 *	            "1": "22",
 *	            "2": "1",
 *	            "3": "2019-04-01 17:23:14",
 *	            "4": "IF_INFO",
 *	            "5": "6",
 *	            "6": "",
 *	            "7": "",
 *	            "8": "Content=\"DHCP client set ip address [20.20.20.2/255.255.255.0] to the interface [ge0/0]\"",
 *	            "ID": "23186",
 *	            "daemon": "22",
 *	            "count": "1",
 *	            "time": "2019-04-01 17:23:14",
 *	            "type": "IF_INFO",
 *	            "level": "6",
 *	            "src_ip": "",
 *	            "dst_ip": "",
 *	            "msg": "DHCP client set ip address [20.20.20.2/255.255.255.0] to the interface [ge0/0]"
 *	        }
 *	    ],
 *	    "total": 1
 *	}
 */

class LogSysController extends Controller{
	function get(){
		$syslog_tmpfile= '/tmp/syslog_tmp.txt';
		if(file_exists($syslog_tmpfile)){
			$ret = array('code' => '-1000', 'str' => 'log is loading');
			echo json_encode($ret);
			unlink($syslog_tmpfile);
			return;
		}else{
			$fopen = fopen($syslog_tmpfile, 'wb');
			fclose($fopen);
		}
		if($_GET['type']!='av'&&$_GET['type']!='ips') {
			$ip_pre = '000000000000000000000000';
			$type = $_GET['type'];
			//$type = 1;
			if ($type == 1) {
				$table = 'event_log';
			} else if ($type == 2) {
				$table = 'security_log';
			} else if ($type == 3) {
				$table = 'nat_log';
			} else if ($type == 4) {
				$table = 'app_log';
			} else if ($type == 5) {
				$param['admin_name'] = $_SESSION[CONNECTION.USERNAME];
				$power3_str= getResponse('admin_permission','showone',$param);
				$power3_res= getAssign($power3_str,'admin_permission');
				$is_power3 = $power3_res['separation_of_powers'];
				if($is_power3==0){
					$table = 'config_log';
				}else{
					if($param['admin_name']=='audit'){
						$table = 'config_log';
					}else{
						$table = 'audit_log';
					}
				}
			} else if($type == 6) {
             	$table = 'divert_log';
            } else {
                return;
			}

			$vsys_id_data = getResponse('vsys_switch_ui','show','');
			$vsys_id_data = getAssign($vsys_id_data,'vsys_switch_ui');
			$vsys = $vsys_id_data['vsysid'];

			//$vsys = $_SERVER['VSYSID'];

			if ($vsys != 0) {
				$table .= "_".$vsys;
			}

			$db = new DBUtil();

			$col_a = array();
			$page_num = $_GET['page'];

			$level = $_GET['level'];
            if ($level!=null && ($level < 1 || $level > 6)) {
                $ret = array('code' => '-1', 'str' => t('log_sys.level_err'));
                echo json_encode($ret);
                return;
            }

			$src_ip = trim($_GET['sip']);//源IP
			$dst_ip = trim($_GET['dip']);//目标IP
			$srcipVer = Util::getIPVersion($src_ip);
			$dstipVer = Util::getIPVersion($dst_ip);

            $regularMatching = new RegularMatching();
			if($src_ip != null) {
                $checkSip = $regularMatching->checkIP($src_ip);
                if (!$checkSip) {
                    $ret = array('code' => '-1', 'str' => t('log_sys.sip_err'));
                    echo json_encode($ret);
                    return;
                }
				if(strpos($src_ip,'/') !== false){
					$srcip = Util::getRangeIP($src_ip, $srcipVer);
					$col_a['srcip'] = '\''.$srcip['startIP'].'\' AND \''.$srcip['endIP'].'\'';
				} else {
					$col_a['src_ip'] = Util::transIP($src_ip, $srcipVer);
				}
			}
			if($dst_ip != null) {
                $checkDip = $regularMatching->checkIP($dst_ip);
                if (!$checkDip) {
                    $ret = array('code' => '-1', 'str' => t('log_sys.dip_err'));
                    echo json_encode($ret);
                    return;
                }
				if(strpos($dst_ip,'/') !== false){
					$dstip = Util::getRangeIP($dst_ip, $dstipVer);
					$col_a['dstip'] = '\''.$dstip['startIP'].'\' AND \''.$dstip['endIP'].'\'';
				} else {
					$col_a['dst_ip'] = Util::transIP($dst_ip, $dstipVer);
				}
			}

			$start_date = $_GET['start_time'];
			$end_date = $_GET['end_time'];
			$delAll = $_GET['delAll'];
			$ids = $_GET['ids'];
			if(!is_null($delAll) && (0 == $delAll || 1 == $delAll)){
				$db->deleteLogs($delAll, $ids, $table);
			}

			if($level!=null)
				$col_a['level'] = $level;

            if ($start_date != null && $end_date != null && $end_date < $start_date) {
                $ret = array('code' => '-1', 'str' => t('log_sys.time_err'));
                echo json_encode($ret);
                return;
            }

			if($start_date != null && $end_date != null){
				$col_a['time'] = '\''.$start_date. '\' AND \''. $end_date.'\'';
			} else if($start_date != null) {
				$col_a['time'] = '\''.$start_date. '\' AND 2222-01-01';
			} else if($end_date != null) {
				$col_a['time'] = ' 1970-01-01 AND \''. $end_date.'\'';
			}

			//定义模块ID
			$model = $_GET['model'];

			if(!is_null($ids) && strlen($ids) > 0){
				$col_a['daemon'] = $ids;
			}

			$page_num = $page_num == 0? 1 : $page_num;
			$page_count = $_GET['pageSize'];

			$items = $db->queryForList($table, $col_a, $page_num, $page_count);

			$total = $db->getCount($table, $col_a);
			$tmp_array = array();
			if (strpos($table,'app_log')!==false || strpos($table,'nat_log')!==false || strpos($table,'audit_log')!==false || strpos($table,'config_log')!==false) {
				foreach ($items as $item) {
					if (empty($item[msg])){
						continue;
					}
					/*if ($item[ID] == 56) {
						var_dump($item[msg]);
						die;
					}*/
					$str = str_replace("\"", "",$item[msg]);
					$str = str_replace(" ", "&", $str);
					$is_wrong = false;
					parse_str($str, $arr);
					foreach ($arr as $key => $value) {
						if (!empty($value) && !htmlspecialchars($value)){
							$is_wrong = true;
							$arr[$key] = '';
							// break;
						}
					}

					if ($is_wrong) {
						unset($item[msg]);
					}
					$item = array_merge($item, $arr);


					if (preg_match("/Content=\".+\"/", $item[msg])) {
						preg_match("/Content=\".+\"/", $item[msg], $content);
						$item[Content] = substr($content[0], strlen('Content="'), -1);
					}
					if(preg_match("/{|}/", $item[msg])){
						$str = str_replace("\n", '', $item[msg]);
						preg_match("/{.+}/", $str,$operate);
						$item[Operate] = substr($operate[0], 1, (strlen(trim($operate[0]))-2));
					} else {
						$head = 'Operate="';
						$operate = strstr($item[msg], $head);
						$operate = substr($operate, strlen($head));
						$item[Operate] = substr($operate, 0, strpos($operate, "\""));

						// $item[Operate] = substr($operate[0], strlen('Operate="'), -1);
					}
					//$item = array_unique($item);


					$tmp_array[] = $item;
				}
			} else {
				foreach ($items as $item) {
					if (empty($item[msg])){
						continue;
					}
					if (substr($item[msg], 0, 9) == "Content=\"" && $item[msg]{strlen($item[msg]) - 1} == "\"") {
						$item[msg] = substr($item[msg], 9, strlen($item[msg]) - 9 - 1);
					}

					if (strstr(get_oem_str(), "zte")) {
						$key_array = array("SrcIP", "DstIP", "Protocol", "SrcPort", "DstPort", "InInterface", "OutInterface", "FwPolicyID", "Action", "Content");
						foreach ($key_array as $key) {
							$tr = LocalUtil::getCommonResource($key);
							//echo $key."=".$tr;
							//return;
							if ($tr) {
								$tr = $tr."=";
								$key = $key."=";
								$item[msg] = str_replace($key, $tr, $item[msg]);
							}
						}
					}
					$item[msg] = htmlspecialchars($item[msg]);

					if (empty($item[msg])){
						continue;
					}

					$tmp_array[] = $item;
				}
			}

			$group = array();
			$group['data'] = $tmp_array;
			$group['total']  = (int)$total;

		}else{
			$type = $_GET['type'];
			$param[priority] = $_GET['level'];

			if($type=='av'){
				$module_name = "av_log";
			}

			if($type=='ips'){
				$module_name = "ips_log";
				$param['id'] =25;
				$param['log_key'] = '';
				$param['dbseq'] = '';
				if($param[priority] != null){
					if ($param[priority] == '7') {
						$param[priority] = '0';
					}
				}
			}
			$param['page'] = $_GET['page'];
			$param['current_page'] = '';
			$param['count'] = $_GET['pageSize'];

			//$param = getPageAttr();
			$param[src_ip] = trim($_GET['sip']);//源IP
			$param[des_ip] = trim($_GET['dip']);//目标IP

			$start_time = $_GET['start_time'];
			if ($start_time != null) {
				$time = strtotime($start_time);
				$param[start_year] = date('y', $time);
				$param[start_month] = date('m', $time);
				$param[start_day] = date('d', $time);
				$param[start_hour] = date('H', $time);
				$param[start_minitus] = date('i', $time);
				$param[start_second] = date('s', $time);
			}

			$end_time = $_GET['end_time'];
			if ($end_time != null) {
				$time = strtotime($end_time);
				$param[end_year] = date('y', $time);
				$param[end_month] = date('m', $time);
				$param[end_day] = date('d', $time);
				$param[end_hour] = date('H', $time);
				$param[end_minitus] = date('i', $time);
				$param[end_second] = date('s', $time);
			}

			//Get model, send msg to system
			$rspString = getResponse($module_name, "show" , $param);

			$sec_setting_list_arr = getAssign($rspString, $module_name, 0);

			$num = count($sec_setting_list_arr[group]);
			$group = array();
			if (!empty($sec_setting_list_arr) && $num > 0) {
				$index = $num - 1;

				$total =$sec_setting_list_arr[group][$index][total];
				array_pop($sec_setting_list_arr[group]);
				if ($index == 0) {
					$total = "0";
				}
				$sec_setting_list_arr[data][total] = $total;
				$group['data'] = $sec_setting_list_arr[group];
				$group['total']  = (int)$total;
				$items = $sec_setting_list_arr[group];
			}

			if ($sec_setting_list_arr[group] == null) {
				$group['data'] = array();
				$group['total'] = '0';
			}




		}

		if(!isset($_GET['download'])){
			echo json_encode($group);
			unlink($syslog_tmpfile);
		}else{
			$data_list=SysLogList::get_list($_GET['filenum'],10000,$table,$col_a,$page_num,$page_count,$items,$type);
			//屏蔽结构体部分数据
			foreach ($data_list as $key => $value) {

				$prefix = 'Content="';
				if ($value['msg'] && json_encode($value['msg']) === false) {
					$data_list[$key]['msg'] = '';
					continue;
				}
				if ($value['msg'] && strpos($value['msg'], $prefix) === 0){
					$data_list[$key]['msg'] = substr($value['msg'], strlen($prefix), -1);
				}
			}

			$filetype = $_GET['filetype'];

            $type = ['EXCEL','TXT','XML','CSV'];

            if (empty($filetype)) {
                $ret = array('code' => '-1000', 'str' => t('log_sys.type_not_null'));
                echo json_encode($ret);
                return;
            }
            if (!in_array($filetype,$type)) {
                $ret = array('code' => '-1', 'str' => t('log_sys.type_err'));
                echo json_encode($ret);
                return;
            }


            $data_json = json_encode($data_list);
			if($filetype=='TXT'){
				$data_res = Json2Txt::json_txt($data_json);
			}else if($filetype=='EXCEL'){
				$filetype = 'CSV';
				$data_res = Json2Csv::json_csv($data_json);
			}else{
				$data_list = json_decode($data_json, false);
				$data_res = Arr2Xml::export($data_list);
			}

			$callEndTime =date('YmdHis',time());
			$contTypeArr = array(
				'TXT' => 'Content-type: application/txt;',
				'CSV' => 'Content-type:application/vnd.ms-excel;',
				'XML' => 'Content-Type: text/xml;'
			);
			$file_name = 'log_'.$callEndTime.'.'.strtolower($filetype);

			unlink($syslog_tmpfile);
			unlink($auditlog_tmpfile);
			Header($contTypeArr[$filetype].' charset=utf-8');
			Header('Content-Disposition: attachment;filename="'.$file_name.'"');
			Header('Cache-Control: max-age=0');
			echo $data_res;
		}
		return;
	}


	function delete(){
		$vsys_id_data = getResponse('vsys_switch_ui','show','');
		$vsys_id_data = getAssign($vsys_id_data,'vsys_switch_ui');
		$vsys = $vsys_id_data['vsysid'];
		$param=get_inputs();
		$type=$param['type'];
		$msg='';
		switch ($type){
			case '1':
			  	$table='event_log';
			  	$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all system log" ManageStyle=web Content="operation success"';
			  	break;
			case '2':
			  	$table='security_log';
			  	$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all security log" ManageStyle=web Content="operation success"';
			  	break;
			case '3':
			  	$table='nat_log';
			  	$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all NAT log" ManageStyle=web Content="operation success"';
			  	break;
			case '4':
			  	$table='app_log';
			  	$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all application control log" ManageStyle=web Content="operation success"';
			  	break;
			case '5':
				$param['admin_name'] = $_SESSION[CONNECTION.USERNAME];
				$power3_str= getResponse('admin_permission','showone',$param);
				$power3_res= getAssign($power3_str,'admin_permission');
				$is_power3 = $power3_res['separation_of_powers'];
				if($is_power3==0){
					$table = 'config_log';
				}else{
					if($param['admin_name']=='audit'){
						$table = 'config_log';
					}else{
						$table = 'audit_log';
					}
				}
			  	$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all config log" ManageStyle=web Content="operation success"';
			  	break;
			case '6':
			  	$table='divert_log';
			  	$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all divert control log" ManageStyle=web Content="operation success"';
			  	break;
			case 'ips':
				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all IPS log" ManageStyle=web Content="operation success"';
			  	break;
			case 'av':
				$msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="clear all AV log" ManageStyle=web Content="operation success"';
				break;
			default:
			  $table='';
		}
		$db = new DbUtil();
		if($type=='av'){
			$counts = self::nodisk_log_num('av');
			$log_del = getResponse('av_log', "submit");
		}else if($type=='ips'){
			$counts = self::nodisk_log_num('ips');
			$log_del = getResponse('ips_log', "submit");
		}else{
			//$vsys = $_SERVER['VSYSID'];
			if ($vsys != 0) {
				$table .= "_".$vsys;
			}
			$counts=$db->getCount($table,'');
			$db->deleteLogs(1,'1',$table);
		}
		/*if ($type == '5') {
			if($counts!=0){
				if ($is_power3==0 || $_SESSION[CONNECTION.USERNAME] == 'audit'){
					$db->addAuditLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg);
				} else{
					$db->addEventLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg);
				}
			}
		}*/
		// if($counts!=0){
		//三权分立模式下separation_of_powers为1，并且会有useradmin和audit字段
		if ($_SESSION[PERMISSION]['separation_of_powers'] == 1 && $_SESSION[CONNECTION.USERNAME] == 'audit'){
			$table = 'AUDIT_LOG';
			if ($vsys != 0) {
				$table .= "_".$vsys;
			}
			$db->addAuditLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);
		} else{
			$table = 'CONFIG_LOG';
			if ($vsys != 0) {
				$table .= "_".$vsys;
			}
			$db->addEventLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);
		}
		// }
		$ret = array('code' =>0 ,'str'=>t('log.del_success'));
		echo json_encode($ret);
		return;
	}

	function nodisk_log_num($log_type){
		$param[priority] = $_GET['level'];
		$param['page'] = $_GET['page'];
		$param['current_page'] = '';
		$param['count'] = $_GET['pageSize'];
		if($log_type=='av'){
			$module_name = "av_log";
		}

		if($log_type=='ips'){
			$module_name = "ips_log";
			$param['id'] =25;
			$param['log_key'] = '';
			$param['dbseq'] = '';
			if($param[priority] != null){
				if ($param[priority] == '7') {
					$param[priority] = '0';
				}
			}
		}
		$rspString = getResponse($module_name, "show",$param);
		$sec_setting_list_arr = getAssign($rspString, $module_name, 0);
		$num = count($sec_setting_list_arr[group]);
		return $num;
	}

}
