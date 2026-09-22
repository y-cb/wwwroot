<?php
namespace controller\syslog;
use bar\baz\source_with_namespace;
use database\MySQLite3Db;
use lib\Json2Txt;
use lib\Json2Csv;
use lib\Arr2Xml;
use controller\Controller;
use database\MysqlDb;
use lib\AuditlogSession;
use lib\RegularMatching;
use lib\SysLogList;

/**
 * @api {GET}  /api/audit-log 获取日志有硬盘设备日志&导出日志文件
 * @apiName audit-log
 * @apiGroup 日志信息
 *
 *
 * @apiParam {String} module 请求日志名称，ips：入侵防护日志，有硬盘设备，av：病毒防护日志，web_access：web访问日志，instant_message：即时通讯日志，search_engine：搜索引擎日志，social_network：社交网络日志，email：电子邮件日志，file_transfer：文件传输日志，online_shopping：在线购物日志，app_others：其他应用日志
 * @apiParam {Number} page 分页，默认为1
 * @apiParam {Number} pageSize 页码，默认为10
 * @apiParam {String} language 语言：cn为中文，en为英文
 * @apiParam {Number} download 导出日志必填项，默认值为1
 * @apiParam {Number} num 导出日志必填项，导出日志数量
 * @apiParam {String} type 导出日志必填项，导出日志文件类型,EXCEL为csv，TXT为txt，XML为xml格式
 * @apiParam {String} time_type 导出日志必填项，时间范围：cur_day为当天，cur_week为本周，cur_month为本月，one_week为最近7天，one_month为最近30天，three_month为最近90天，user_def为自定义
 * @apiParam {String} start_time time_type为user_def必填项，导出日志开始时间，格式为yyyy-mm-dd hh:ii:ss
 * @apiParam {String} end_time time_type为user_def必填项，导出日志结束时间，格式为yyyy-mm-dd hh:ii:ss
 *
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"type": "1",
 *		"page": "1",
 *		"pageSize": "10"
 *	}
 *	
 *
 */

class LogAuditController extends Controller {

	function get(){
        $path = '/tmp/export/';
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
		$auditlog_tmpfile= '/tmp/auditlog_tmp.txt';

        $db = new MySQLite3Db('/mnt/boot/apt.db', '/tmp/apt_tmp.db');
        $table_name = 'apt_result';
		if(file_exists($auditlog_tmpfile)){
			$ret = array('code' => '-1000', 'str' => 'log is loading');
			echo json_encode($ret);
			unlink($auditlog_tmpfile);
			return;
		}else{
			$fopen = fopen($auditlog_tmpfile, 'wb');
			fclose($fopen);
		}
		$module = $_GET['module'];
		if ($module !='apt') {
		    $log_type = '1';
        } else{
            $log_type = 'apt';
        }

		if($module=='config_log'){
			$param['admin_name'] = $_SESSION[CONNECTION.USERNAME];
			$power3_str= getResponse('admin_permission','showone',$param);
			$power3_res= getAssign($power3_str,'admin_permission');
			$is_power3 = $power3_res['separation_of_powers'];
			if($is_power3==0){
				$module = 'config_log';
			}else{
				if($param['admin_name']=='audit'){
					$module = 'config_log';
				}else{
					$module = 'audit_log';
				}
			}
		}
		$start = $_GET['start_time'];
		$end = $_GET['end_time'];
		$sid = $_GET['sid'];
		$time_type = $_GET['time_type'];
		$ids = $_GET['daemon'];
        $param['page'] = $_GET['page'];
		//$param = getPageAttr();
		$database = new MysqlDb();
		if(isset($_GET['download'])){
			$param['count'] = $_GET['num'];
			if ($param['count'] == 5000) {
				$param['page'] = 1;
			}
		}else{
			$param['count'] = $_GET['pageSize'];
		}

		$param['type'] = $_GET['type'];

        $type = ['EXCEL','TXT','XML','CSV'];

        if ($param['type'] && !in_array($param['type'],$type)) {
            $ret = array('code' => '-1', 'str' => t('log_audit.type_error'));
            echo json_encode($ret);
            return;
        }
		$cur = time();
		$ret;
		$format="%Y-%m-%d %H:%M:%S";

		if ((!empty($time_type) && empty($start) && empty($end))&&$time_type!='user_def') {
			$time_array = get_time_range($time_type);
			$start = $time_array['start_time'];
			$end = $time_array['end_time'];
		}

		// 获取开始时间和结束时间
		if (empty($start)) {
			$start = $cur;
			$date = localtime($cur, true);
			$start = mktime(0, 0, 0, $date['tm_mon'] + 1, $date['tm_mday'], $date['tm_year'] + 1900);

		} else {
			$start =strptime($start, $format);
			$start = mktime($start['tm_hour'], $start['tm_min'], $start['tm_sec'], $start['tm_mon'] + 1, $start['tm_mday'], $start['tm_year'] + 1900);
		}

		if (empty($end)) {
			$end = $cur;
		} else {
			$end = strptime($end, $format);
			$end = mktime($end['tm_hour'], $end['tm_min'], $end['tm_sec'], $end['tm_mon'] + 1, $end['tm_mday'], $end['tm_year'] + 1900);
		}

		if ($end - $start > 91 * 24 * 60 * 60) {
			return;
		}
        $regularMatching = new RegularMatching();

        if (!empty($_GET['srcip'])) {
            $srcip = $regularMatching->checkIP($_GET['srcip']);
            $srcipv6 = $regularMatching->checkIPv6($_GET['srcip']);
            if (!$srcip&&!$srcipv6) {
                $ret = array('code' => '-1', 'str' => t('log_audit.sip_err'));
                echo json_encode($ret);
                return;
            }
        }
        if (!empty($_GET['dstip'])) {
            $dstip = $regularMatching->checkIP($_GET['dstip']);
            $dstipv6 = $regularMatching->checkIPv6($_GET['dstip']);
            if (!$dstip&&!$dstipv6) {
                $ret = array('code' => '-1', 'str' => t('log_audit.dip_err'));
                echo json_encode($ret);
                return;
            }
        }
        $type = ['domain','ip','url','file_sha256','inbound_ip','outbound_ip'];
        if (!empty($_GET['ioctype']) && !in_array($_GET['ioctype'],$type)) {
            $ret = array('code' => '-1', 'str' => t('log_audit.ioctype_err'));
            echo json_encode($ret);
            return;
        }

        if (!empty($_GET['risk']) && ($_GET['risk'] > 5 || $_GET['risk'] < -1)) {
            $ret = array('code' => '-1', 'str' => t('log_audit.risk_err'));
            echo json_encode($ret);
            return;
        }

        if (!empty($_GET['level']) && ($_GET['level'] > 6 || $_GET['level'] < 0)) {
            $ret = array('code' => '-1', 'str' => t('log_audit.level_err'));
            echo json_encode($ret);
            return;
        }

        if (!empty($_GET['action']) && $_GET['action']!='pass') {
            $_GET['action'] = 'drop';
        }
		$where = AuditlogSession::get_query_param($_GET);
		$idx = ($param['page'] - 1) * $param['count'];
		$num = $param['count'];

		if ($is_same_day = $database->is_same_day($start, $end)) {
            ini_set("memory_limit", "1024M");
		    if ($module != 'apt') {
//		    	$sql_count = $database->webui_count($module, $start, $end, $where);


                $data = $this->get_log_cache($database,$module, $start, $end, $idx, $num, $where);
                $sql_count = $_SESSION[$module.'_cache_total'];
                /*if (!empty($_SESSION[$module.'_cache_total'])) { //添加cache流程
                	$data = $this->get_log_cache($database,$module, $start, $end, $idx, $num, $where);
                } else {
                	$data = $database->webui_query($module, $start, $end, $idx, $num, $where);
                }*/


               
//                $row_count = $database->get_table_rows($module,$start);

//                if ($where == null && (int)$row_count[0]['TABLE_ROWS']>5000 && $_GET['start_time']==null && $_GET['end_time']==null) {
//                    $sql_count = $row_count;
//                } else {
//                }
            } else {
                $result = $db->get_SQLite3_data_result($table_name,$where,$num,$idx,'id','desc',$start,$end);
                $data = $result['group'];
                $sql_count = $db->get_SQLite3_data_count($table_name,$where,'id',$start,$end);
            }
		} else {
			for ($i = $idx; $i < $idx + $num; $i++) {
				if ($sid != $_SESSION['search_id'] && sizeof($_SESSION['scache_items'])==0) {//快速请求选中时间会使得sid和search_id不一致
					break;
				}
				if (is_array($_SESSION['scache_items']) && (sizeof($_SESSION['scache_items']) > $i)) {
					$data[] = $_SESSION['scache_items'][$i];
				}
            }
			$sql_count = count($_SESSION['scache_items']);
		}
		if($sql_count>5000){
			$sql_count = 5000;
		}
		if (!isset($_GET['download'])) {
			if (is_array($data)) {
				$ret['data'] = $data;
				$ret['total'] = $sql_count;
				echo json_encode($ret);
				unlink($auditlog_tmpfile);
				return;
			}
			unlink($auditlog_tmpfile);
			//echo '{"data":[]"total":0}';
			$audit_arr = array("data"=>array(),"total"=>0);
			echo json_encode($audit_arr);
			return;
		} else {
			if($module=='event_log'||$module=='config_log'||$module=='audit_log'||$module=='nat_log'||$module=='security_log'||$module=='divert_log' || $module == 'apt')
			{
				$data_list = SysLogList::printFile($data,$log_type);
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
				$data = $data_list;
			}
			$data_json = json_encode($data);
			$time = time();
//			if ($is_same_day) {
            if ($param['count'] < 5000){
				if ($_GET['type'] == 'XML') {
					$file_name = 'log_'.$time.'.xml';
					$data = json_decode($data_json,false);
					$data_res = Arr2Xml::export($data);
				} else if ($_GET['type'] == 'CSV') {
					$file_name = 'log_'.$time.'.csv';
					$data_res = Json2Csv::json_csv($data_json, $module);
				} else if ($_GET['type'] == 'TXT') {
					$file_name = 'log_'.$time.'.txt';
					$data_res = Json2Txt::json_txt($data_json, $module);
				}
				unlink($auditlog_tmpfile);
				Header('Content-Type: text/xml; charset=utf-8');
				Header('Content-Disposition: attachment;filename="'.$file_name.'"');
				Header('Cache-Control: max-age=0');
				echo $data_res;
				return;
			} else {
				set_time_limit(0);
				/*$start = strtotime($start);
				$end = strtotime($end);*/
				$max = 20000;
				$file_type = $_GET['type'];

				for ($i = $start; $i <= $end; $i+=86400) {
					$date = localtime($i, true);
					$start_time = mktime(0, 0, 0, $date['tm_mon'] + 1, $date['tm_mday'], $date['tm_year'] + 1900);
					$end_time = mktime(23, 59, 59, $date['tm_mon'] + 1, $date['tm_mday'], $date['tm_year'] + 1900);
					$log_name_time = date('Ymd',$i);
					$file_name = 'log_'.$log_name_time.'.'.strtolower($file_type);
					if ($module !='apt') {
                        $count = $database->webui_count($module, $start_time, $end_time, $where);
                    } else {
                        $count = $db->get_SQLite3_data_count($table_name,$where,'id',$start,$end);
                    }
					//如果数据超出最大值，则分批次从数据库导出
					if ($count) {
						$file_name_array[] = $file_name;
						
//						if ($count > $max) {
//							for ($j=0; $j < ceil($count/$max); $j++) {
//								$idx = $max * $j + 1;
//								if ($idx > $count){
//									$max = $count - $idx;
//								}
//								ini_set("memory_limit", "1024M");
//                                if ($module !='apt') {
//                                    $data = $database->webui_query($module, $start_time, $end_time, $idx, $max, $where);
//                                } else {
//
//                                    $result = $db->get_SQLite3_data_result($table_name,$where,$num,$idx,'id','desc',$start,$end);
//                                    $data = $result['group'];
//                                }
//								if($module=='event_log'||$module=='config_log'||$module=='audit_log'||$module=='nat_log'||$module=='security_log'||$module=='divert_log'||$module=='app_log' || $module=='apt'){
//									$data_list = SysLogList::printFile($data,$log_type);
//										//屏蔽结构体部分数据
//									foreach ($data_list as $key => $value) {
//
//										$prefix = 'Content="';
//
//										if ($value['msg'] && json_encode($value['msg']) === false) {
//											$data_list[$key]['msg'] = '';
//											continue;
//										}
//										if ($value['msg'] && strpos($value['msg'], $prefix) === 0){
//											$data_list[$key]['msg'] = substr($value['msg'], strlen($prefix), -1);
//										}
//									}
//									$data = $data_list;
//								}
//                                if ($file_type == 'XML') {
//                                    $data_res = Arr2Xml::export($data);
//                                    file_put_contents($path.$file_name,$data_res);
//                                } else {
//                                    $this -> putCsv($data, $file_name);
//                                }
//							}
//						} else {
						    if ($module!='apt') {
                                $data = $database->webui_query($module, $start_time, $end_time, $idx, $num, $where);
                            } else {
                                $result = $db->get_SQLite3_data_result($table_name,$where,$num,$idx,'id','desc',$start,$end);
                                $data = $result['group'];
                            }
							if($module=='event_log'||$module=='config_log'||$module=='audit_log'||$module=='nat_log'||$module=='security_log'||$module=='divert_log'||$module=='app_log' || $module=='apt'){
								$data_list = SysLogList::printFile($data,$log_type);
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
								$data = $data_list;
							}
							if (!empty($data)) {
                                if ($file_type == 'XML') {
                                    $data = json_decode(json_encode($data), false);
                                    $data_res = Arr2Xml::export($data);
                                    file_put_contents($path.$file_name,$data_res);
                                }else if($file_type == 'TXT') {
                                    file_put_contents(
                                        $path.$file_name,
                                        Json2Txt::json_txt($data, $module)
                                    );
                                }else {
                                    $this -> putCsv($data, $file_name);
                                }
							}
//						}
							$num -= $count;
							if ($num < 0) {
								break;
							}
					} else {
						continue;
					}
				}
			}
            if (!is_dir($path)) {
                mkdir($path);
            }

		    if (is_dir($path)) {
                $cur_time = date('YmdHis', time());
                $zip_name = 'log_'.$cur_time.'.zip';
                $exec_str = "cd {$path} && zip -q -r {$zip_name} ./*";
                exec($exec_str);
            }


			//删除多余csv文件
			foreach ($file_name_array as $value) {
				unlink($path.$value);
			}

			/*unlink($auditlog_tmpfile);
			Header('Content-Type: text/xml; charset=utf-8');
			Header('Content-Disposition: attachment;filename="'.$file_name.'"');
			Header('Cache-Control: max-age=0');
			echo $data_res;*/
			//输出压缩文件提供下载
			unlink($auditlog_tmpfile);
		    header("Cache-Control: public");
		    header("Content-Description: File Transfer");
		    header('Content-disposition: attachment; filename='.basename($zip_name)); // 文件名
		    header("Content-Type: application/zip"); // zip格式的
		    header("Content-Transfer-Encoding: binary"); //
		    header('Content-Length: ' . filesize($path.$zip_name)); //
		    @readfile($path.$zip_name);//输出文件;
		    unlink($path.$zip_name); //删除压缩包临时文件
			return;
		}
	}

	function delete(){
		$param = get_inputs();

		switch($param['module']) {
			case 'bell':
				unset($_SESSION['ips_cache_expire']);
				unset($_SESSION['av_cache_expire']);
				break;
			default:
				unset($_SESSION[$module.'_cache_expire']);
				break;
		}
		return;
	}

	function putCsv($data,$filename) {
		ob_flush();
	    flush();
	    ini_set("memory_limit", "1024M");
		$path = '/tmp/export/';
		if(!is_dir($path)){
			mkdir($path);
		}
		set_time_limit(0);

	    $fp = fopen($path.$filename, 'a'); //生成临时文件
	    $tmp = array_keys($data[0]);
	    $head = array();

	    foreach ($tmp as $value) {
	    	$head[] = t('log.'.$value);
	    }
	    fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));//输出BOM头
	    fputcsv($fp, $head);

		foreach ($data as $val) {
			if(is_numeric($val['level'])) {
                $val['level'] = t('log.level'.$val['level']);
            }
			fputcsv($fp, $val);
		}

		fclose($fp);
	}

	private function get_log_cache($database, $module, $start, $end, $idx, $num, $where) {
		$data = [];
		$cache_name = $module.'_cache_items';
		$cache_time = $module.'_cache_expire';
		$find_name = $module.'_search_field';
		$find_total = $module.'_cache_total';
		$time_name = $module.'_cache_time';

		if (count($_SESSION[$cache_time])>0 && $_SESSION[$cache_time] > time()) {
		    if (count($where) != count($_SESSION[$find_name])) {
                unset($_SESSION[$cache_name]);
                unset($_SESSION[$cache_time]);
                unset($_SESSION[$find_name]);
                unset($_SESSION[$find_total]);
                unset($_SESSION[$time_name]);
            } else {
		        $diff = array_diff($where, $_SESSION[$find_name]);
		        if (!empty($diff)) {
                    unset($_SESSION[$cache_name]);
                    unset($_SESSION[$cache_time]);
                    unset($_SESSION[$find_name]);
                    unset($_SESSION[$find_total]);
                    unset($_SESSION[$time_name]);
                }
            }
        }
        if (count($_SESSION[$cache_name]) == 0 || $_SESSION[$cache_time] < time() || $_SESSION[$time_name]-$start > 120 || $_SESSION[$cache_time] - $end > 120) {
            unset($_SESSION[$cache_name]);
            unset($_SESSION[$cache_time]);
            unset($_SESSION[$find_name]);
            unset($_SESSION[$find_total]);
            unset($_SESSION[$time_name]);
        }

        if (empty($_SESSION[$cache_name])) {
            $_SESSION[$cache_name] = $database->webui_query($module, $start, $end, 0, 5000, $where);
            $_SESSION[$find_name] = $where;
            $_SESSION[$find_total] = $database->webui_count($module, $start, $end, $where);
            if (!empty($where) || $_SESSION[$find_total] > 100000) {
            	$_SESSION[$cache_time] = time() + 120;
            }
            $_SESSION[$time_name] = $start;
        }

		for ($i = $idx; $i < $idx + $num; $i++) {
			if (is_array($_SESSION[$cache_name]) && (sizeof($_SESSION[$cache_name]) > $i)) {
				$data[] = $_SESSION[$cache_name][$i];
			}
        }
        return $data;
	}
}
