<?php
namespace controller\statistics;
use controller\mController;
use database\SqliteDb;

/**
 * @api {GET}  /api/ips-list 获取防护统计列表
 * @apiName ips-list
 * @apiGroup 入侵防护统计
 *
 *
 * @apiParam {Number} querytime  不可为空，统计周期 0代表当天 1代表自定义日期 7代表最近7天 30代表最近30天 60代表最近60天 90代表最近90天
 * @apiParam {String} start_time  不可为空，自定义起始日期
 * @apiParam {String} end_time  不可为空，自定义结束日期

 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"querytime": 1,
 *		"start_time": "2018-09-05",
 *		"end_time": "2018-10-12",
 *	}
 *
 * @apiSuccess {String} type 类型，不可为空，ips攻击类型，取值不固定
 * @apiSuccess {Number} count 攻击总数，不可为空，整型值
 * @apiSuccess {Number} alert 告警，不可为空，整型值
 * @apiSuccess {Number} warning 警示，不可为空，整型值
 * @apiSuccess {Number} notification 通知，不可为空，整型值
 * @apiSuccess {Number} information 信息，不可为空，整型值

 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *
 *
 * {
 *     "data": [{
 *     "type": "全部",
 * 		"count": 0,
 * 		"alert": "0",
 * 		"warning": "0",
 * 		"information": "0",
 * 		"notification": "0"
 * 	}, {
 *   "0": {
 *       "type": "全部",
 * 			"count": 0,
 * 			"alert": "0",
 * 			"warning": "0",
 * 			"information": "0",
 * 			"notification": "0"
 * 		},
 * 		"type": "Backdoor",
 * 		"count": "0",
 * 		"alert": "0",
 * 		"notification": "0",
 * 		"warning": "0",
 * 		"information": "0"
 * 	}, {
 *   "0": {
 *       "type": "全部",
 * 			"count": 0,
 * 			"alert": "0",
 * 			"warning": "0",
 * 			"information": "0",
 * 			"notification": "0"
 * 		},
 * 		"type": "BufferOverflow",
 * 		"count": "0",
 * 		"alert": "0",
 * 		"notification": "0",
 * 		"warning": "0",
 * 		"information": "0"
 * 	}, {
 *   "0": {
 *       "type": "全部",
 * 			"count": 0,
 * 			"alert": "0",
 * 			"warning": "0",
 * 			"information": "0",
 * 			"notification": "0"
 * 		},
 * 		"type": "Bypass",
 * 		"count": "0",
 * 		"alert": "0",
 * 		"notification": "0",
 * 		"warning": "0",
 * 		"information": "0"
 * 	},...
 * ]
 * }
  */
class IpsStatListController extends mController {
 // 二维数组根据字段进行排序
 // @params array $array 需要排序的数组
 // @params string $field 排序的字段
 // @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序

	static function arraySequence($array, $field, $sort = 'SORT_DESC')
	{
	    $arrSort = array();
	    foreach ($array as $uniqid => $row) {
	        foreach ($row as $key => $value) {
	            $arrSort[$key][$uniqid] = $value;
	        }
	    }
	    array_multisort($arrSort[$field], constant($sort), $array);
	    return $array;
	}

    static function isDateValid($date, $formats = array('Y-m-d', 'Y/m/d')) {

        $unixTime = strtotime($date);
        if(!$unixTime) { //无法用strtotime转换，说明日期格式非法
            return false;
        }

        if($unixTime > time()) {
        	return false;
        }

        if ($unixTime < 0) {
        	return false;
        }
        //校验日期合法性，只要满足其中一个格式就可以
        foreach ($formats as $format) {
            if(date($format, $unixTime) == $date) {
                return true;
            }
        }
        return false;
    }

	function get(){
		$day = $_GET['querytime'];
		$start = $_GET['start_time'];
		$end = $_GET['end_time'];
		header('Content-type: application/json');  
        if(!isset($day) || !is_numeric($day) || ($day!=0 && $day!=1 && $day!=7 && $day!=30 && $day!=60 && $day!=90)){
            $ret = array("code"=> "-10","str"=> t('statics.ips_time_type_error'));
            echo json_encode($ret);
            exit(0);
        }
        // var_dump(self::isDateValid($start));die;s
        if((isset($start) && !self::isDateValid($start)) || (isset($end) && !self::isDateValid($end))){
            $ret = array("code"=> "-10","str"=> t('statics.ips_time_error'));
            echo json_encode($ret);
            exit(0);
        }

        if ($day!=0 && $day != 1) {
			$date = strtotime(date() . '-' . $day . 'days');
			$start_time = date('Ymd',$date);
			$end_time = date('Ymd');
			//var_dump($start_time);exit(0);

		} elseif (!empty($start) && !empty($end)) {
			$start_time = date('Ymd',strtotime($start));
			$end_time = date('Ymd',strtotime($end));
		}
		$level_table = 'IPSLOG_LEVEL_LITE';
		$type_table = 'IPSLOG_SecurityType_Lite';
		$alert_table = 'IPS_LEVEL_ALERT_TYPE';
		$information_table = 'IPS_LEVEL_INFORMATION_TYPE';
		$notice_table = 'IPS_LEVEL_NOTICE_TYPE';
		$warning_table = 'IPS_LEVEL_WARNING_TYPE';
		$sqlite_path = '/tmp/locallog/event_log.db';
		if (!file_exists($sqlite_path)) {
			echo json_encode(array());
			return;
		}
        $database = new SqliteDb();
		if ($day!=0) {
			$sql = "SELECT SUM(emergencies) AS emergencies,SUM(alert) AS alert,SUM(critical) AS critical,SUM(error) AS error,SUM(warning) AS warning,SUM(information) AS information,SUM(notification) AS notification FROM " . $level_table . " WHERE date>=" . $start_time . " AND date<=" . $end_time;
			$statistics_info = $database -> org_query($sql);
   
			$sql_prefix =  "SELECT SUM(Backdoor) AS Backdoor,SUM(BufferOverflow) AS BufferOverflow,SUM(Bypass) AS Bypass,SUM(CommandExecution) AS CommandExecution,SUM(DirectoryTraversal) AS DirectoryTraversal,SUM(DoS) AS DoS,SUM(InformationDisclosure) AS InformationDisclosure,SUM(RequestVulnerability) AS RequestVulnerability,SUM(SQLInjection) AS SQLInjection,SUM(VulnerabilityScanning) AS VulnerabilityScanning,SUM(WormVirus) AS WormVirus,SUM(XSS) AS XSS,SUM(cust_def_ips) AS cust_def_ips FROM ";

			$sql = $sql_prefix . $type_table . " WHERE date>=" . $start_time . " AND date<=" . $end_time;
			$statistics_virus = $database -> org_query($sql);
			
			$sql =  $sql_prefix . $alert_table . " WHERE date>=" . $start_time . " AND date<=" . $end_time;
			$statistics_alert = $database -> org_query($sql);

			$sql =  $sql_prefix . $information_table . " WHERE date>=" . $start_time . " AND date<=" . $end_time;
			$statistics_information = $database -> org_query($sql);

			$sql =  $sql_prefix . $notice_table . " WHERE date>=" . $start_time . " AND date<=" . $end_time;
			$statistics_notice = $database -> org_query($sql);

			$sql =  $sql_prefix . $warning_table . " WHERE date>=" . $start_time . " AND date<=" . $end_time;
			$statistics_warning = $database -> org_query($sql);
		} else {
			$data = $database -> org_select($level_table,'*',['date' => date('Ymd')]);
			$statistics_info = $data[0];
			$data = $database -> org_select($type_table,'*',['date' => date('Ymd')]);
			$statistics_virus = $data[0];
			$data = $database -> org_select($alert_table,'*',['date' => date('Ymd')]);
			$statistics_alert = $data[0];
			$data = $database -> org_select($information_table,'*',['date' => date('Ymd')]);
			$statistics_information = $data[0];
			$data = $database -> org_select($notice_table,'*',['date' => date('Ymd')]);
			$statistics_notice = $data[0];
			$data = $database -> org_select($warning_table,'*',['date' => date('Ymd')]);
			$statistics_warning = $data[0];
		}
		//计算统计总数,整合数据
		$info_array = array('alert','notification','warning','information');
		$item = array();
		$list = array();
		$i = 0;
		foreach ($statistics_info as $key => $value) {
			if ($key != 'date' && in_array($key,$info_array)) {
				if ($_GET['lang'] == 'cn') {
					$item[$i]['type'] = 'All';
					$item[$i]['show_name'] = '全部';
				} else {
					$item[$i]['type'] = 'All';
					$item[$i]['show_name'] = 'All';
				}
				$item[$i]['count'] += (int)$statistics_info[$key];
//				 $item[$i][$key] = empty($item[$i][$key])? 0: $item[$i][$key];
//				$item[$i][$key] = (int)$item[$i][$key];
                $item[$i][$key] = (int)$statistics_info[$key];
			}
		}
		$list[data][] = $item[$i];
		$virus = array('Backdoor','BufferOverflow','Bypass','CommandExecution','DirectoryTraversal','DoS','InformationDisclosure','RequestVulnerability','SQLInjection','VulnerabilityScanning','WormVirus','XSS','cust_def_ips');

		foreach ($statistics_virus as $key => $value) {
			$item = array();
			if ($key != 'date' && in_array($key,$virus)) {
				$item['type'] = $key;
				$item['show_name'] = t('ips_attack.'.$key);
				/*$item['count'] = empty($value)? 0: $value;
				$item['alert'] = empty($statistics_alert[$key])? 0: $statistics_alert[$key];
				$item['notification'] = empty($statistics_notice[$key])? 0: $statistics_notice[$key];
				$item['warning'] = empty($statistics_warning[$key])? 0: $statistics_warning[$key];
				$item['information'] = empty($statistics_information[$key])? 0: $statistics_information[$key];*/
				$item['count'] = (int)$value;
				$item['alert'] = (int)$statistics_alert[$key];
				$item['notification'] = (int)$statistics_notice[$key];
				$item['warning'] = (int)$statistics_warning[$key];
				$item['information'] = (int)$statistics_information[$key];
				$list[data][] = $item;
			}
		}
		// var_dump($list);die;
		
		$sequence_list = self::arraySequence($list['data'],'count');
		$new_list = array('data'=>$sequence_list);
		//var_dump($list,$new_list,$sequence_list,488);exit(0);
		echo get_jsondata($new_list);
		//echo get_jsondata($list);
		// print_r($list);die;
		return;
	}
}
