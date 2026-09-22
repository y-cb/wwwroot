<?php
namespace controller\syslog;
use database\MySQLite3Db;
use lib\Json2Txt;
use lib\Json2Csv;
use lib\Arr2Xml;
use controller\Controller;
use database\MysqlDb;
use lib\AuditlogSession;

class LogAuditTimelineController extends Controller {
	const max_cache_num = 5000;
	
	function get(){
		$auditlog_tmpfile= '/tmp/audittl_tmp.txt';
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
		$start = $_GET['start_time'];
		$end= $_GET['end_time'];
		$sid = $_GET['sid'];
		$time_type = $_GET['time_type'];
		$cur = time();
		$retdata;
		$num = 0;
		$total = 0;
		$format="%Y-%m-%d %H:%M:%S";

		if ((!empty($time_type) && empty($start) && empty($end))&&$time_type!='user_def') {
			$time_array = get_time_range($time_type);
			$start = $time_array['start_time'];
			$end = $time_array['end_time'];
		}
		// var_dump($start,$end);die;
		/* 获取开始时间和结束时间 */
		if (!isset($start)) {
			$start = $cur;
			$date = localtime($cur, true);
			$start = mktime(0, 0, 0, $date['tm_mon'] + 1, $date['tm_mday'], $date['tm_year'] + 1900);
		} else {
			$start = strptime($start, $format);
			$start = mktime($start['tm_hour'], $start['tm_min'], $start['tm_sec'], $start['tm_mon'] + 1, $start['tm_mday'], $start['tm_year'] + 1900);
		}
		
		if (!isset($end)) {
			$end = $cur;
		} else {
			$end = strptime($end, $format);
			$end = mktime($end['tm_hour'], $end['tm_min'], $end['tm_sec'], $end['tm_mon'] + 1, $end['tm_mday'], $end['tm_year'] + 1900);
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
        if (!empty($_GET['action']) && $_GET['action']!='pass') {
            $_GET['action'] = 'drop';
        }
		$where = AuditlogSession::get_query_param($_GET);
		/* 查看有无cache项 */
		$cache = AuditlogSession::get_searcher($module, $start, $end, $sid, $where);

		if ($cache['is_time_cursored'] == false) {
			// 第一次计算分隔点，首先把内容返回给页面 
			$cache['is_time_cursored'] = true;

			if ($end - $start > 91 * 24 * 60 * 60) {
				// 大于三个月 
				$ret = array('code' => '-1001', 'str' => 'The query interval should not exceed 3 months');
				echo json_encode($ret);
				unlink($auditlog_tmpfile);
				//echo '{error:error}';
				return;
			}
			$_SESSION['scache'] = $cache;
			//echo json_encode($cache);
			//return;
		}

		for ($i = sizeof($cache['buckets']) - 1; $i >= 0; $i--) {
			$bucket = $cache['buckets'][$i];
			if ($bucket['is_finalized'] == true) {
				continue;
			}
   
			if ($module != 'apt') {
                /* 查阅时间在一天之内，只需要查询出结果 */
                $count = MysqlDb::webui_count($module, $bucket['earliest_time'], $bucket['earliest_time'] + $bucket['duration']);
                if (isset($where)) {
                    $total = MysqlDb::webui_count($module, $bucket['earliest_time'], $bucket['earliest_time'] + $bucket['duration'],$where);
                } else {
                    $total = $count;
                }
                if (!MysqlDb::is_same_day($start, $end)) {
                    /* 查询时间跨天，需要查询出cache的条目 */
                    $num = self::max_cache_num - sizeof($_SESSION['scache_items']);
                    if ($num > 0) {
                        $items = MysqlDb::webui_query($module, $bucket['earliest_time'], $bucket['earliest_time']  + $bucket['duration'], 0, $num, $where);
                        if (is_array($items)) {
                            if (is_array($_SESSION['scache_items'])) {
                                $_SESSION['scache_items'] = array_merge($_SESSION['scache_items'], $items);
                            } else {
                                $_SESSION['scache_items'] = $items;
                            }
                        }
                    }
                }
            } else {
                $db = new MySQLite3Db('/mnt/boot/apt.db', '/tmp/apt_tmp.db');
                $table_name = 'apt_result';
                $count = $db->get_SQLite3_data_count($table_name, $where,'id',$bucket['earliest_time'], $bucket['earliest_time'] + $bucket['duration']);
                $total = $count;
                if (!MysqlDb::is_same_day($start, $end)) {
                    /* 查询时间跨天，需要查询出cache的条目 */
                    $num = self::max_cache_num - sizeof($_SESSION['scache_items']);
                    if ($num > 0) {
                        $result =$db->get_SQLite3_data_result($table_name,$where,$num,0,'id','desc',$start,$end);
                        $items = $result['group'];
                        if (is_array($items)) {
                            if (is_array($_SESSION['scache_items'])) {
                                $_SESSION['scache_items'] = array_merge($_SESSION['scache_items'], $items);
                            } else {
                                $_SESSION['scache_items'] = $items;
                            }
                        }
                    }
                }
            }
			$bucket['is_finalized'] = true;
			$bucket['total_count'] = $total;
			$bucket['available_count'] = $total;

			$cache['buckets'][$i] = $bucket;
			$cache['event_count'] += $count;

			if (time() - $cur >= 5) {
				/* 超过5秒，直接返回 */
				break;
			}
		}
		$_SESSION['scache'] = $cache;
        $_SESSION['scache_find'] = $where;
        
        if ($cache['event_count'] > 100000) {
			$_SESSION['scache_expire'] = time() + 120;
        }
		
		$_SESSION['event_count'] = $cache['event_count'];
		$_SESSION['scache_module'] = $module;
		$_SESSION['scache_time'] = $start;
		unlink($auditlog_tmpfile);
		echo json_encode($cache);
		return;
	}

	function delete(){
		$param = get_inputs();

		switch($param['module']) {
			case 'bell':
				if ($_SESSION['scache_module'] == 'ips'){
					unset($_SESSION['scache_expire']);
					unset($_SESSION['scache_items']);
				}
				if ($_SESSION['scache_module'] == 'av'){
					unset($_SESSION['scache_expire']);
					unset($_SESSION['scache_items']);
				}
				break;
			default:
				if ($_SESSION['scache_module'] == $param['module']){
					unset($_SESSION['scache_expire']);
					unset($_SESSION['scache_items']);
				}
				break;
		}
		return;
	}
}