<?php
namespace database;
use database\Medoo;
use PDO;
use lib\LocalUtil;
use lib\RegularMatching;
use lib\Util;

class MysqlDb{
	public static $database;
	function getDb(){
		return new Medoo([
		    // 必填
		    'database_type' => 'mysql',
		    'database_name' => 'syslog',
		    'server' => 'localhost',
			'socket' => '/tmp/mysql.sock',
		    'username' => 'root',
		    'password' => '',

		    // 可选参数
		    'port' => 3306,
		    'charset' => 'utf8',
		    // 连接参数可参考官方手册： http://www.php.net/manual/en/pdo.setattribute.php
		    'option' => [
		        PDO::ATTR_CASE => PDO::CASE_NATURAL
		    ]
		]);
	}

	function is_same_day($start, $end)
	{
		$s = getdate($start);
		$e = getdate($end);

		if ($s['year'] == $e['year'] && $s['mon'] == $e['mon'] && $s['mday'] == $e['mday']) {
			return true;
		}
		return false;
	}

	function webui_query($module, $start, $end, $idx, $num, $where=array())
	{
		//global $database;
		$end--;
		$s = strftime('%Y-%m-%d  %H:%M:%S', $start);
		$e = strftime('%Y-%m-%d  %H:%M:%S', $end);
		$flag = false;
		if (isset($where)) {
			$con = ["LIMIT" => [$idx, $num], "ORDER" => "id DESC"];
			$con['AND'] = array_merge($where, ["create_at[<>]" => [$s, $e]]);
			if($module=='defense'){
				foreach($where as $key=>$value){
					if($key=='defense_query_str'){
						$flag = true;
						$iochash_arr = explode(",", $value);

						unset($where[$key]);
					}					

				}
				$con['AND'] = array_merge($where,["create_at[<>]" => [$s, $e]]);
				if($flag){
					$con['AND'] = array_merge($con['AND'], ['query[~]'=>$iochash_arr]);
				}
					
			}else if($module=='event_log'||$module=='config_log'||$module=='security_log'||$module=='audit_log'||$module=='nat_log'||$module=='app_log'){
				$sipflag = false;
				$dipflag = false;
				foreach($where as $key=>$value){
					if($key=='daemon'){
						$flag = true;
						$daemon_arr = explode(",", $value); 
						unset($where[$key]);
					}

					if($key=='sip'){
						
						$sipflag = true;
						$sipflag_range = false;
						$regularMatching = new RegularMatching();
						$src_ip = trim($_GET['sip']);//源IP
						$srcipVer = Util::getIPVersion($src_ip);
						if($src_ip != null) {
			                $checkSip = $regularMatching->checkIP($src_ip);
			                if (!$checkSip) {
			                    $ret = array('code' => '-1', 'str' => t('log_sys.sip_err'));
			                    echo json_encode($ret);
			                    return;
			                }
							if(strpos($src_ip,'/') !== false){
								$srcip = Util::getRangeIP($src_ip, $srcipVer);
								$srcip_arr = [$srcip['startIP'], $srcip['endIP']];
								$sipflag_range = true;
								//$col_a['srcip'] = '\''.$srcip['startIP'].'\' AND \''.$srcip['endIP'].'\'';
							} else {
								$srcip_arr = Util::transIP($src_ip, $srcipVer);
								$sipflag_range = false;
								//$col_a['src_ip'] = Util::transIP($src_ip, $srcipVer);
							}
						}
						unset($where[$key]);
					}
				
					if($key=='dip'){
						$dipflag_range = false;
						$dipflag = true;
						$regularMatching = new RegularMatching();
						$dst_ip = trim($_GET['dip']);//源IP
						$dstipVer = Util::getIPVersion($dst_ip);
						if($dst_ip != null) {
			                $checkDip = $regularMatching->checkIP($dst_ip);
			                if (!$checkDip) {
			                    $ret = array('code' => '-1', 'str' => t('log_sys.sip_err'));
			                    echo json_encode($ret);
			                    return;
			                }
							if(strpos($dst_ip,'/') !== false){
								$dstip = Util::getRangeIP($dst_ip, $dstipVer);
								$dstip_arr = [$dstip['startIP'], $dstip['endIP']];
								$dipflag_range = true;
							} else {
								$dstip_arr = Util::transIP($dst_ip, $dstipVer);
								$dipflag_range = false;
							}
						}
						unset($where[$key]);
					}
				}
				$con['AND'] = array_merge($where,["create_at[<>]" => [$s, $e]]);
				if($flag){
					$con['AND'] = array_merge($con['AND'], ['daemon'=>$daemon_arr]);
				}
				if($sipflag){
					if( $sipflag_range){
						$con['AND'] = array_merge($con['AND'], ['srcip[<>]'=>$srcip_arr]);
					}else{
						$con['AND'] = array_merge($con['AND'],['src_ip'=>$srcip_arr]);
					}
				}
				if($dipflag){
					if($dipflag_range){
						$con['AND'] = array_merge($con['AND'], ['dstip[<>]'=>$dstip_arr]);
					}else{
						$con['AND'] = array_merge($con['AND'],['dst_ip'=>$dstip_arr]);
					}


				}
					
				
			}else{
				$con['AND'] = array_merge($where, ["create_at[<>]" => [$s, $e]]);
			}
		} else {
			$con = ["LIMIT" => [$idx, $num], "ORDER" => "id DESC"];
			$con["create_at[<>]"] = [$s, $e];
		}
		/*
		var_dump($start);
		var_dump($end);
		var_dump($where);
		*/
		if(empty(self::$database)) {
			self::$database = self::getDb();
		}
		
		if (self::is_same_day($start, $end)) {

				$day = strftime("%Y%m%d", $start);
				$table_name = $module.'_'. $day;
				$data = self::$database->select($table_name, "*", $con);
				$tmp_array = array();
				if ($module=='nat_log' || $module=='audit_log' || $module=='config_log'||$module=='app_log') {
					foreach ($data as $item) {
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
					$data = $tmp_array;
				} else if($module=='divert_log'||$module=='event_log'||$module=='security_log'){
					foreach ($data as $item) {
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
					$data = $tmp_array;
				}
				return $data;
		}
		return null;
	}

	function webui_count($module, $start, $end,  $where=array())
	{
		$end--;
		$s = strftime('%Y-%m-%d  %H:%M:%S', $start);
		$e = strftime('%Y-%m-%d  %H:%M:%S', $end);
		$flag = false;
		if (isset($where)) {
			$where["create_at[<>]"] = [$s, $e];
			//$con['AND'] = $where;
			if($module=='defense'){

				foreach($where as $key=>$value){
					if($key=='defense_query_str'){
						$flag = true;
						$iochash_arr = explode(",", $value);

						unset($where[$key]);
					}					

				}
				$con['AND'] = array_merge($where,["create_at[<>]" => [$s, $e]]);
				if($flag){
					$con['AND'] = array_merge($con['AND'], ['query[~]'=>$iochash_arr]);
				}
					
			}else if($module=='event_log'||$module=='config_log'||$module=='security_log'||$module=='audit_log'||$module=='nat_log'||$module=='app_log'){
				$sipflag = false;
				$dipflag = false;
				foreach($where as $key=>$value){
					if($key=='daemon'){
						$flag = true;
						$daemon_arr = explode(",", $value); 
						unset($where[$key]);
					}

					if($key=='sip'){
						
						$sipflag = true;
						$sipflag_range = false;
						$regularMatching = new RegularMatching();
						$src_ip = trim($_GET['sip']);//源IP
						$srcipVer = Util::getIPVersion($src_ip);
						if($src_ip != null) {
			                $checkSip = $regularMatching->checkIP($src_ip);
			                if (!$checkSip) {
			                    $ret = array('code' => '-1', 'str' => t('log_sys.sip_err'));
			                    echo json_encode($ret);
			                    return;
			                }
							if(strpos($src_ip,'/') !== false){
								$srcip = Util::getRangeIP($src_ip, $srcipVer);
								$srcip_arr = [$srcip['startIP'], $srcip['endIP']];
								$sipflag_range = true;
								//$col_a['srcip'] = '\''.$srcip['startIP'].'\' AND \''.$srcip['endIP'].'\'';
							} else {
								$srcip_arr = Util::transIP($src_ip, $srcipVer);
								//$col_a['src_ip'] = Util::transIP($src_ip, $srcipVer);
							}
						}
						unset($where[$key]);
					}
					if($key=='dip'){
						$dipflag_range = false;
						$dipflag = true;
						$regularMatching = new RegularMatching();
						$dst_ip = trim($_GET['dip']);//源IP
						$dstipVer = Util::getIPVersion($dst_ip);
						if($dst_ip != null) {
			                $checkDip = $regularMatching->checkIP($dst_ip);
			                if (!$checkDip) {
			                    $ret = array('code' => '-1', 'str' => t('log_sys.sip_err'));
			                    echo json_encode($ret);
			                    return;
			                }
							if(strpos($dst_ip,'/') !== false){
								$dstip = Util::getRangeIP($dst_ip, $dstipVer);
								$dstip_arr = [$dstip['startIP'], $dstip['endIP']];
								$dipflag_range = true;
							} else {
								$dstip_arr = Util::transIP($dst_ip, $dstipVer);
							}
						}
						unset($where[$key]);
					}					
				}
				$con['AND'] = array_merge($where,["create_at[<>]" => [$s, $e]]);
				if($flag){
					$con['AND'] = array_merge($con['AND'], ['daemon'=>$daemon_arr]);
				}
				if($sipflag){
					if( $sipflag_range){
						$con['AND'] = array_merge($con['AND'], ['srcip[<>]'=>$srcip_arr]);
					}else{
						$con['AND'] = array_merge($con['AND'],['src_ip'=>$srcip_arr]);
					}
				}
				if($dipflag){
					if($dipflag_range){
						$con['AND'] = array_merge($con['AND'], ['dstip[<>]'=>$dstip_arr]);
					}else{
						$con['AND'] = array_merge($con['AND'],['dst_ip'=>$dstip_arr]);
					}


				}
			}else{
				$con['AND'] = array_merge($where);
			}
		} else {
			$con = ["create_at[<>]" => [$s, $e]];
		}

		if(empty(self::$database)) {
			self::$database = self::getDb();
		}

		if (self::is_same_day($start, $end)) {
			$day = strftime("%Y%m%d", $start);
			$table_name = $module.'_'. $day;
			$data = self::$database->count($table_name, $con);
			// echo $this->database->last_query();
			if ($data == false) {
				return 0;
			}
			return $data;
		}
		return 0;
	}
	function if_table_exists($table_name) {
		$sql = "SELECT `TABLE_NAME` FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME='".$table_name."'";
		return MysqlDb::sql_query($sql);
	}
	function report_sec_query($module,$start, $end,$where=array())
	{
		$start_time = strtotime($start);
		$end_time = strtotime($end);
		$join = [];
		for ($i = $start_time; $i <= $end_time; $i += 24 * 3600) {
	    	$tmp_date = date("Y-m-d", $i);
	    	$date_str = str_replace("-","",$tmp_date);
			$table = $module.'_'. $date_str;
			if (!empty($this->if_table_exists($table))) {
				$join[] = $table;
			}
		}
		//$join_arr_len = count($join);

		$day = strftime("%Y%m%d", $start_time);
		$table_name = $module.'_'. $day;
		
		if (isset($where)) {
			$con = $where;
		}
		if(empty(self::$database)) {
			self::$database = self::getDb();
		}

		if (self::is_same_day($start_time, $end_time)) {
			$count = self::$database->count($table_name, "*", $con);
			return $count;
		}else{
			$num = 0;
			foreach($join as $key){
				$count = self::$database->count($key,  '*', $con);
				$num+=$count;
			}
			return $num;
			//return $data['eventname'];
		}
		//return null;
	}
	function org_select($module,$col, $where=array())
	{
		self::$database = self::getDb();
		$data = self::$database->select($module, $col, $where);

		return $data;
	}
	function org_max($module,$col, $where=array())
	{
		self::$database = self::getDb();
		$data = self::$database->max($module, $col, $where);
		return $data;
	}
	function org_count($module,$group, $where=array())
	{
		self::$database = self::getDb();
		$data = self::$database->distinct()->count($module, $group, $where);
		return $data;
	}

		/**
	 * 二维数组根据字段进行排序
	 * @params array $array 需要排序的数组
	 * @params string $field 排序的字段
	 * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
	 */

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

	//计算重复事件值，合成新数组
	static function getArrayUniqueByKeys($arr,$keystr)
	{
	    $arr_out = $arr_wish = array();
	    $arr_num = array();
	    foreach ($arr as $k => $v) {
	        $key_out = $v[$keystr]; //提取内部一维数组的key(ip url)作为外部数组的键
	        if (array_key_exists($key_out, $arr_out)) {
	        	$arr_num[$key_out]['num'] = $arr_num[$key_out]['num']+$v['num'];
	            continue;
	        } else {
	            $arr_out[$key_out] = $arr[$k]; //以key_out作为外部数组的键
	            $arr_wish[$k] = $arr[$k];  //实现二维数组唯一性
	            $arr_num[$key_out]['num'] = $v['num'];
	        }
	        //$arr_wish[$k]['num'] = $arr_num[$key_out]['num'];
	    }

	    foreach($arr_wish as $key=>$value){
	    	if( in_array($value[$keystr],array_keys($arr_num)) ){
	    		$value['num']=$arr_num[$value[$keystr]]['num'];
	    		//$value['num']=1;
	    		//var_dump($value);
	    	}
	    	$new_arr[]=$value;
	    }
	    //var_dump($arr_num);
	    return $new_arr;
	}
	function report_query($module, $group, $start, $end)
	{
		self::$database = self::getDb();
		$start_time = strtotime($start);
		$end_time = strtotime($end);
		for ($i = $start_time; $i <= $end_time; $i += 24 * 3600) {
	    	$tmp_date = date("Y-m-d", $i);
	    	$date_str = str_replace("-","",$tmp_date);
	    	$join[] = $module.'_'. $date_str;

		}

	    $data = array();
	    foreach($join as $key){
	        $sql = "SELECT COUNT(*) as num,". $group ." from " . $key . " group by " . $group . ' order by num desc limit 200';
	        $ret = self::$database->query($sql);
	        if ($ret) {
	            $data_tmp = $ret->fetchAll();
	            $data = array_merge($data, $data_tmp);
	            $data = self::getArrayUniqueByKeys($data, $group);
	        } else {
	            //var_dump($database->error());
	        }
	    }
	    if (sizeof($data) > 0) {
	        $data = self::arraySequence($data, 'num');
	        return array_slice($data, 0, 10);
	    }
	    return $data;
	}

    function report_cache_query($table, $group) {
        self::$database = self::getDb();

        //创建索引，加快整理速度
        $indexsql = "ALTER TABLE ".$table." ADD INDEX report_".$group." (".$group.")";
        $indexret = self::$database->query($indexsql);

        if (!$indexret) {

        }

        $sql = "SELECT COUNT(*) as num,". $group ." from " . $table . " group by " . $group . ' order by num desc';
        $ret = self::$database->query($sql);

        if ($ret) {
            $data = $ret->fetchAll();
            return $data;
        }

    }

	function get_table_rows($table_name,$day) {
		self::$database = self::getDb();
		$day = strftime("%Y%m%d", $day);
		$table_name = $table_name.'_'. $day;
		$sql = "SELECT TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME='".$table_name."'";
		$ret = self::$database->query($sql);
		if ($ret) {
			$data = $ret->fetchAll();
		}

		return $data;
	}

	function sql_query($sql) {
		self::$database = self::getDb();
		if (!empty($sql)) {
			// var_dump(date('Ymd H:i:s',time()));
			$ret = self::$database->query($sql);
			$data = array();
			//返回如果为false,返回错误数据，否则返回空
			if ($ret) {
				$data = $ret->fetchAll();
			}
			return $data;
		}
	}
	static function if_column_exists($table,$column){
		self::$database = self::getDb();
		$sql  = "select count(*) as count from information_schema.columns where table_name ='".$table."' and column_name='$column'";
		$data = MysqlDb::sql_query($sql);
		return $data[0]['count'];
	}
}

?>
