<?php
namespace database;
use PDO;
class AppflowDb{
	public $path='/tmp/webui/lang.conf';
	public $lang;
	public $database;
	public $dbname;

	function __construct(){
		if (file_exists($this->path)) {
			$this->lang = file_get_contents($this->path);
		}
	}
	
	function get_db() {
		//链接数据库，如果为空则会进行创建
		$this->database = new PDO('sqlite:'.$this->dbname);
		$sql = "PRAGMA synchronous = off";
		$this->sql_exec($sql);
		/*$this->database = new PDO(
		    'sqlite::memory:',
		    null,
		    null,
		    array(PDO::ATTR_PERSISTENT => true)
		); */
		
		//判断流程
/*		if (!$this->database){
			echo 'success';
		} else {
			return false;
		}*/
	}
	function clean_table($table) {
		if ($table) {
			$sql = "drop table IF EXISTS ".$table;
			$this->sql_exec($sql);
		}
	}
	/**
	 * @ sqlite数据库统计排序函数
	 * @ param table_arr array 数据库存放数组
	 * @ param db_path string 数据库所在位置
	 * @ param db_name string 生成最终数据库名称
	 * @ param limit int 获取最大数量
	 */
	function app_sort_query($table_arr, $db_path, $param, $limit=200) {
		$this->get_db();
		//遍历引入数据库并创建数据库视图
		$view_arr = array();
		$last_file;

		if ($param['category']) {
			$table_name = 'category';
			$table_main = 'category_main';
			$field_name = 'category_id';
		} else {
			$table_name = 'app';
			$table_main = 'app_main';
			$field_name = 'app_id';
		}

        $file = glob('/tmp/flow_statistic/'.$this->get_time_range($param['range']).'/*.db');
        $num = count($file);

		if ($this->sql_exists('tmp')){
			$sql = "drop table tmp";
			$this->sql_exec($sql);
		}
		//查询临时数据缓存表是否存在
		/*$time_table = 'generate_time';
		if ($this->sql_exists($table_name) && $this->sql_exists($time_table)) {
			$sql = "select timerange,updatetime,filenum from " . $time_table . " WHERE name='".$table_name."'";
			$time = $this->sql_query($sql);
			$time = $time[0];
			if ($param['range'] == $time['timerange'] && $num == $time['filenum']) {
				return;
			}
		}*/
		$updatetime = $this->get_cache_time($param, $table_name);

		if ($updatetime !== false) {
			$table_arr = $this->get_db_array($param['range'], $updatetime);
		} else {
			$table_arr = $this->get_db_array($param['range'], time());
		}

		//在内存创建数据整合表
		$this->clean_table($table_name);
		if (!$this->sql_exists($table_name)) {
			//创建结果表用于汇总数据
			$sql = "CREATE TABLE `".$table_name."` (
				`".$field_name."` int,
				`flow_up` int,
				`flow_down` int,
				`flow_total` int
		    )";

		
			$this->sql_exec($sql);

			//添加索引
			$sql = "CREATE INDEX IF NOT EXISTS ".$field_name."_".$table_name." ON ".$table_name."(".$field_name.")";
			$this->sql_exec($sql);
			$sql = "CREATE INDEX IF NOT EXISTS flow_total_".$table_name." ON ".$table_name."(flow_total)";
			$this->sql_exec($sql);
		}

		if (!$this->sql_exists($time_table)) {
			$this->create_time_table();
		}

		foreach ($table_arr as $key=>$val) {
			if ($key == (count($table_arr) - 1)) {
				$last_file = $val;
			}
			//引入外部数据库
			if (file_exists($db_path.$val)) {
				$sql = "attach database '". $db_path . $val ."' as app_tmp";
			} else {
				continue;
			}

			if (!$this->sql_exec($sql)) {
				continue;
			}
			
			$sql_select = "select ".$field_name.",flow_up,flow_down,flow_up+flow_down from app_tmp.".$table_main." where app_tmp.".$table_main.".rowid<=".$limit;
			$sql_update = "update ".$table_name." set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where ".$field_name."=?";
			$sql_insert = "insert into ".$table_name."(".$field_name.", flow_up, flow_down, flow_total) values(?,?,?,?)";

			$stmt_update = $this->database->prepare($sql_update);
			$stmt_insert = $this->database->prepare($sql_insert);
			//合并已有数据
			/*$sql = "update tmp set 
					flow_up=flow_up+(select flow_up from \"tmp\".".$table_main." where \"tmp\".".$table_main.".".$field_name."=tmp.".$field_name." limit ".$limit."), 
					flow_down=flow_down+(select flow_down from \"tmp\".".$table_main." where \"tmp\".".$table_main.".".$field_name."=tmp.".$field_name." limit ".$limit.") 
					where tmp.".$field_name."=(select ".$field_name." from \"tmp\".".$table_main." where \"tmp\".".$table_main.".".$field_name."=tmp.".$field_name." limit ".$limit.")";
			$this->sql_exec($sql);
			//添加数据表中不存在的数据
			$sql = "insert or ignore into tmp(".$field_name.",flow_up,flow_down) select ".$field_name.",flow_up,flow_down from \"tmp\".".$table_main." limit ".$limit;
			$this->sql_exec($sql);
			//删除外联数据库
			$sql = "detach database tmp";
			$this->sql_exec($sql);*/
			//修改为批量插入数据
			$stmt_select = $this->database->prepare($sql_select);
			//数据库为空情况处理
			if (!$stmt_select) {
				continue;
			}
			$stmt_select->execute();
			$stmt_select->bindColumn(1, $app_id, PDO::PARAM_INT);
			$stmt_select->bindColumn(2, $flow_up, PDO::PARAM_INT);
			$stmt_select->bindColumn(3, $flow_down, PDO::PARAM_INT);
			$stmt_select->bindColumn(4, $flow_total, PDO::PARAM_INT);
			//开启事务
			$this->database->beginTransaction();
			while ($stmt_select->fetch(PDO::FETCH_BOUND)) {
				$stmt_update->bindValue(1, $flow_up, PDO::PARAM_INT);
				$stmt_update->bindValue(2, $flow_down, PDO::PARAM_INT);
				$stmt_update->bindValue(3, $flow_total, PDO::PARAM_INT);
				$stmt_update->bindValue(4, $app_id, PDO::PARAM_INT);

				if ($stmt_update->execute() && $stmt_update->rowCount()>=1){
					continue;
				}
				$stmt_insert->bindValue(1, $app_id, PDO::PARAM_INT);
				$stmt_insert->bindValue(2, $flow_up, PDO::PARAM_INT);
				$stmt_insert->bindValue(3, $flow_down, PDO::PARAM_INT);
				$stmt_insert->bindValue(4, $flow_total, PDO::PARAM_INT);
				$stmt_insert->execute();
			}
			//提交事务
			$this->database->commit();
			//删除临时表
			$sql = "detach database app_tmp";
			$this->sql_exec($sql);

		}
		//向generate_time表中更新updatetime字段
		$this->update_time_table(array('name'=>$table_name, 'timerange'=>$param['range'], 'updatetime'=> time(),'filenum'=>$num,'filename'=>$last_file));
		//汇总数据并进行排序
		/*$sql = "insert into ".$table_name."(".$field_name.",flow_up,flow_down,flow_total) 
		select ".$field_name.",flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp order by flow_total desc limit ".$limit;
		$this->sql_exec($sql);*/

		//做表关联数据整合
		/*$sql = '';
		foreach ($view_arr as $value) {
			if (empty($sql)){
				$sql = 'select * from '.$value;
			} else {
				$sql .= ' union all select * from '.$value;
			}
		}*/
		// $query = "select app_id, sum(flow_up), sum(flow_down), (sum(flow_up) + sum(flow_down)) as flow_total  from (".$sql.") group by app_id order by flow_total desc limit 1,200";
		// $query = "select * from table_201807211831";
		//汇聚数据
		// $query = "insert into ".$tmp_db.".app_main(app_id,flow_up,flow_down,flow_total) select app_id, sum(flow_up), sum(flow_down), (sum(flow_up) + sum(flow_down)) as flow_total  from (".$sql.") group by app_id order by flow_total desc limit 1,200";
		// var_dump($query);die;
		// $res = $this->database->query($query);
		// var_dump($query);
		// $data = $res->fetchAll();
		// $res = $this->database->exec($query);
		// $res = $this->database->query('select * from '.$tmp_db.'.app_main');
		// $data = $res->fetchAll();
		// var_dump($res);

/*		$sql = "select * from table_bbb";
		var_dump($this->database->query($sql)->fetchAll());
		$sql = "drop view aaa.table_aaa";
		$this->database->query($sql);
		var_dump($this->database->query($sql));*/
		// $data = $this->database->query($sql)->fetch();
	}

	function app_trend_query($path, $param, $limit=10) {

		if ($param['category']) {
			$table_name = 'category';
			$field_name = 'category_id';
			$user_table = 'category_info';
			$name_cn = 'category_name_cn';
			$name_en = 'category_name_en';
			$main_table = 'category_main';
		} else {
			$table_name = 'app';
			$field_name = 'app_id';
			$user_table = 'app_info';
			$name_cn = 'app_name_cn';
			$name_en = 'app_name_en';
			$main_table = 'app_main';
		}

		$updatetime = $this->get_cache_time($param, $table_name);

		if ($updatetime !== false) {
			$db_arr = $this->get_db_array($param['range'], $updatetime);
		} else {
			$db_arr = $this->get_db_array($param['range'], time());
		}

		$num = count($db_arr);

		//查询所有app_id
		$this->get_db();
		if ($param['direct'] === 'up') {
			$order_field = 'flow_up';
		} elseif ($param['direct'] === 'down') {
			$order_field = 'flow_down';
		} else {
			$order_field ='flow_total';
		}
		$sql = "select ".$field_name." from ".$table_name." order by ".$order_field." desc limit 0,".$limit;
		$arr = $this->sql_query($sql);

		//数据整合
		$appname_arr = array();
		$sql = "attach database '/tmp/app_statistic.db' as app_name";
		$this->sql_exec($sql);
		foreach ($arr as $value) {
			$appidstr .= $value[$field_name].',';
			//在此整理应用名称
			if ($param['category']) {
				$tmp = $this->get_category_name($value[$field_name]);
			}else{
				$tmp = $this->get_app_name($value[$field_name]);
			}
			if (!empty($tmp)){
				$appname_arr[$value[$field_name]]['name_cn'] = ($this->lang==2)?$tmp[0][$name_cn] : $tmp['0'][$name_en];
				$appname_arr[$value[$field_name]]['name_en'] = $tmp[0][$name_en];				
			}
			/*$sql = "select ".$name_en.",".$name_cn." from app_name.".$user_table." where ".$field_name."=".$value[$field_name];
			$tmp = $this->sql_query($sql);
			if (!empty($tmp)){
				$appname_arr[$value[$field_name]]['name_cn'] = ($this->lang==2)?$tmp[0][$name_cn] : $tmp['0'][$name_en];
				$appname_arr[$value[$field_name]]['name_en'] = $tmp[0][$name_en];				
			}*/
		}

		$appidstr = substr($appidstr, 0,strlen($appidstr)-1);
		//逐表查询整合数据
		if ($appidstr) {
			$data = array();
			$arr = explode(",", $appidstr);
			if (!$arr){
				$arr[] = $appidstr;
			}
			$app_num = count($arr);
			foreach($db_arr as $val) {
				$sign = false;
				$flow_up_sum=0;
				$flow_down_sum=0;
				$flow_total_sum=0;
				if (file_exists($path.$val)) {
					$sql = "attach database '". $path . $val ."' as tmp";
					if (!$this->sql_exec($sql)) {
						continue;
					}
				} else {
					$sign = true;
				}
				for ($i =0;$i<$app_num;$i++) {
					if ($sign == false){
						$sql = "select ".$field_name.",flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp.".$main_table." where ".$field_name."=".$arr[$i];
						$info = $this->sql_query($sql);					
					} else {
						$info = array();
					}
					if ($num == 60) {
						$seconds = 60;
					} elseif($num == 144) {
						$seconds = 600;
					} else {
						$seconds = 3600;				
					}
					$flow_up = $info?(ceil($info[0]['flow_up']*8/$seconds)):0;
					$flow_down = $info?(ceil($info[0]['flow_down']*8/$seconds)):0;
					$flow_total = $info?(ceil($info[0]['flow_total']*8/$seconds)):0;
					if(!$data[$i][name]){$data[$i][name] = $appname_arr[$arr[$i]][name_en];}
					if(!$data[$i][name_cn]){$data[$i][name_cn] = ($this->lang==2)?$appname_arr[$arr[$i]][name_cn]:$appname_arr[$arr[$i]][name_en];}
					$data[$i][up_bytes] .= $flow_up;
					$data[$i][up_bytes] .= ',';
					$data[$i][down_bytes] .= $flow_down;
					$data[$i][down_bytes] .= ',';
					$data[$i][total_bytes] .= $flow_total;
					$data[$i][total_bytes] .= ',';
					//计算其他流量
					if ($app_num===10) {
						$flow_up_sum += $flow_up;
						$flow_down_sum += $flow_down;
						$flow_total_sum += $flow_total;
					}
				}

				if ($app_num===10) {
					$sql = "select flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp.summary";
					$info = $this->sql_query($sql);
					if(!$data[$app_num][name]){$data[$app_num][name] = 'other';}
					if(!$data[$app_num][name_cn]){$data[$app_num][name_cn] = ($this->lang==2)?'其他应用':'other';}
					if ($num == 60) {
						$seconds = 60;
					} elseif($num == 144) {
						$seconds = 600;
					} else {
						$seconds = 3600;				
					}
					$flow_up = ceil($info[0]['flow_up']*8/$seconds);
					$flow_down = ceil($info[0]['flow_down']*8/$seconds);
					$flow_total = ceil($info[0]['flow_total']*8/$seconds);
					$data[$app_num][up_bytes] .= ($flow_up > $flow_up_sum)? $flow_up - $flow_up_sum: 0;
					$data[$app_num][up_bytes] .= ',';
					$data[$app_num][down_bytes] .= ($flow_down > $flow_down_sum)? $flow_down - $flow_down_sum: 0;
					$data[$app_num][down_bytes] .= ',';
					$data[$app_num][total_bytes] .= ($flow_total > $flow_total_sum)? $flow_total - $flow_total_sum: 0;
					$data[$app_num][total_bytes] .= ',';
				}
				
				if ($sign == false) {
					$sql = "detach database tmp";
					$this->sql_exec($sql);
				}
			}
			//去掉整合数据后的多余的逗号
			foreach ($data as $key => $value) {
				$data[$key][up_bytes] = substr($value[up_bytes], 0, strlen($value[up_bytes])-1);
				$data[$key][down_bytes] = substr($value[down_bytes], 0, strlen($value[down_bytes])-1);
				$data[$key][total_bytes] = substr($value[total_bytes], 0, strlen($value[total_bytes])-1);
			}

		} else {
			$data = array();
		}
		return $data;
	}

	function sql_exec($sql) {
		if (!empty($sql)) {
			$res = $this->database->exec($sql);

			//返回如果为false,返回错误数据，否则返回空
			if ($this->database->errorcode()!=='00000') {
				$rtn = $this->database->errorInfo();

				/*var_dump($sql);
				var_dump($rtn[0].":".$rtn[2]);*/
				return false;
			}
			return true;
		}
	}

	function sql_query($sql) {
		if (!empty($sql)) {
			// var_dump(date('Ymd H:i:s',time()));
			$res = $this->database->query($sql);
			// var_dump(date('Ymd H:i:s',time()));
			$data = array();
			//返回如果为false,返回错误数据，否则返回空
			if ($res != false) {
				while($row = $res->fetch()) {
					$data[] = $row;
				}
				return $data; 
			}
		}
	}

	function sql_exists($name) {
		$this->get_db();
		$sql = "SELECT count(*) as count FROM sqlite_master WHERE type='table' AND name='".$name."'";
		$res = $this->database->query($sql);
		$rtn = $res->fetch();
		
		if (empty($rtn['count'])) {
			return false;
		} else {
			return true;
		}
	}

	function app_info_sort($param) {
		// $delete_key = 0;
		if ($param['category']) {
			$table_name = 'category';
			$field_name = 'category_id';
			$table_info ="category_info";
			$name_cn = 'category_name_cn';
			$name_en = 'category_name_en';
		} else {
			$table_name = 'app';
			$field_name = 'app_id';
			$table_info = 'app_info';
			$name_cn = 'app_name_cn';
			$name_en = 'app_name_en';
		}

		if ($param['direct'] === 'up'){
			$order = 'flow_up';
		}elseif ($param['direct'] === 'down'){
			$order = 'flow_down';
		}else {
			$order = 'flow_total';
		}

		$this->get_db(); 
		$sql = "select ".$field_name.",flow_up,flow_down,flow_total from ".$table_name." order by ".$order." desc";
		$data = $this->sql_query($sql);
		//获取应用名称外联数据库
		$sql = "attach database '/tmp/app_statistic.db' as stat";
		$this->sql_exec($sql);
		$list = array();
		//数据格式整合
		foreach ($data as $key => $value) {
			$sql = " select ".$field_name.','.$name_cn.','.$name_en." from stat.".$table_info." where ".$field_name."=".$value[$field_name];
			$name_arr = $this->sql_query($sql);
			//添加自定义应用查询
			if (empty($name_arr) && !$param['category']) {
				$app_custom_table = 'app_custom_info';
				$custom_sql = " select ".$field_name.','.$name_cn.','.$name_en." from stat.".$app_custom_table." where ".$field_name."=".$value[$field_name];
				$custom_name = $this->sql_query($custom_sql);

				if (!empty($custom_name)) {
					$name_arr = $custom_name;
				} else {
					//获取第一次已经删除的自定义应用
					// if ($delete_key === 0) {$delete_key = $key;}
					$name_arr = array(
						0 => array(
							$name_cn => '已删除应用' . $value[$field_name],
							$name_en => 'Application Deleted' . $value[$field_name]
						)
					);
				}
			}

			// if ($delete_key === 0) {
			$list[$key][name] = $name_arr[0][$name_en];
			//中文乱码，暂用英文显示
			$list[$key][name_cn] = ($this->lang==2)? $name_arr[0][$name_cn]: $name_arr[0][$name_en];
			$list[$key][up_bytes] = $value['flow_up'];
			$list[$key][down_bytes] = $value['flow_down'];
			$list[$key][total_bytes] = $value['flow_total'];
			// }

		}

		$sql = "select sum(flow_total) as  all_total from ".$table_name;
		$res = $this->sql_query($sql);
		$data = array();
		if (!empty($list)&&!empty($res)) {
			$data[data][0][items][group] = $list;
			$data[data][0][all_total_bytes] = $res[0]['all_total']?$res[0]['all_total']:0;			
		}

		return $data;
	}

	function user_info_sort($param, $user_stat = false, $limit=200) {
		$this->get_db();

		if ($param['category']) {
			$table_name = 'category_detail';
		} elseif ($user_stat == true) {
			$table_name = 'user';
		} else {
			$table_name = 'app_detail';
		}
		

		$sql = "select user_ip,user_name,user_type,flow_up,flow_down,flow_total from ".$table_name." order by flow_total desc limit ".$limit;
		$data = $this->sql_query($sql);
		$list = array();
		//数据格式整合
		foreach ($data as $key => $value) {
			$list[$key][name] = $value['user_name'] ? $value['user_name'] : inet_ntop($value['user_ip']);
			//添加标志位，用于区别ip和name
			if ($value['user_type'] == 'auth'){$list[$key][is_name]=1;}
			$list[$key][up_bytes] = $value['flow_up'];
			$list[$key][down_bytes] = $value['flow_down'];
			$list[$key][total_bytes] = $value['flow_total'];
			$sum += $value['flow_total'];
		}

		$data = array();
		if (!empty($list) && $sum) {
			$data[data][0][items][group] = $list;
			$data[data][0][all_total_bytes] = $sum;
		}
		return $data;
	}

	/**
	 * 数据库路由表，计划后期把控制器获取数据统一传入此函数，统一进行处理，注释后期优化会补充说明
	 */
	function stat_route($data,$path,$param,$is_return=false) {
		//先进性简单的详情和应用分类，后期再优化
		if ($param['app_name']) {
			$this->app_detail_query($data, $path, $param);
		} elseif ($param['user_name']){
			if($param['category']!=''){
				$this->user_cate_detail_query($data, $path, $param);
			}else{
				$this->user_detail_query($data, $path, $param);
			}
			//$this->user_detail_query($data, $path, $param);												
		} else {
			if ($is_return == true) {
				$this->user_trend_query($data, $path, $param);
			} else {
				$this->app_sort_query($data, $path, $param);
			}	
			// $list = $this->app_trend_query($data, $path, $name, $param);
		}
	}

	function app_detail_query($data, $path, $param, $is_return=false, $limit = 200) {
		$this->get_db();
		//判断是否为应用
		if ($param['category']) { 
			$user_table = 'category_user';
			$user_table_field = 'category_name_en';
			$main_table = 'category_main';
			$name_table = 'category_info';
			$table_name = 'category_detail';
			$field_name = 'category_id';
		} else {
			$user_table = 'app_user';
			$user_table_field = 'app_name_en';
			$main_table = 'app_main';
			$name_table = 'app_info';
			$table_name = 'app_detail';
			$field_name = 'app_id';
		}

		$this->clean_table($table_name);

		//根据名称查找对应app_id
		$sql = "attach database '/tmp/app_statistic.db' as statistic";
		$this->sql_exec($sql);
		
		$sql = "select ".$field_name." from statistic.".$name_table." where ".$user_table_field."='".$param['app_name']."'";
		$info = $this->sql_query($sql);
		$app_id = $info[0][$field_name];
		//自定义应用名称查询
		if (!$param['category'] && !$app_id) {
			$sql = "select ".$field_name." from statistic.app_custom_info where ".$user_table_field."='".$param['app_name']."'";
			$info = $this->sql_query($sql);
			$app_id = $info[0][$field_name];
		}

		$sql = "detach database statistic";
		$this->sql_exec($sql);

/*		$sql = "CREATE TABLE `tmp` (
	      `user_ip` blob,
	      `user_name` varchar(50),
	      `flow_up` int,
	      `flow_down` int
	    )";
		$this->sql_exec($sql);*/

		$sql = "CREATE TABLE `".$table_name."` (
	      `user_ip` blob,
	      `user_name` varchar(64),
	      `user_type` varchar(24),
	      `flow_up` int,
	      `flow_down` int,
	      `flow_total` int
	    )";
		$this->sql_exec($sql);

		//添加索引
		$sql = "CREATE INDEX IF NOT EXISTS user_ip_key_".$table_name." ON ".$table_name."(user_ip)";
		$this->sql_exec($sql);

		$sql = "CREATE INDEX IF NOT EXISTS user_name_key_".$table_name." ON ".$table_name."(user_name)";
		$this->sql_exec($sql);

		$sql = "CREATE INDEX IF NOT EXISTS user_name_key_".$table_name." ON ".$table_name."(flow_total)";
		$this->sql_exec($sql);

		$sql_update_ip = "update ".$table_name." set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where user_ip=?";
		$sql_update_name = "update ".$table_name." set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where user_name=?";
		$sql_insert = "insert into ".$table_name."(user_ip, user_name, flow_up, flow_down, flow_total) values(?,?,?,?,?)";

		foreach ($data as $key => $value) {

			if (file_exists($path.$value)) {
				$sql = "attach database '".$path.$value."' as main_tmp";
				$this->sql_exec($sql);
			}else {
				continue;
			}

			$sql = "select rank from main_tmp.".$main_table." where ".$field_name."=".$app_id;
			$rank = $this->sql_query($sql);
			if (!empty($rank)) {
				//修改user_name存在的字段
				$sql_select = "select user_ip,user_name,flow_up,flow_down,(flow_up+flow_down) as flow_total from main_tmp.".$user_table." where main_tmp.".$user_table.".parent=? order by flow_total desc limit ?";

				$stmt_update_ip = $this->database->prepare($sql_update_ip);
				$stmt_update_name = $this->database->prepare($sql_update_name);
				$stmt_insert = $this->database->prepare($sql_insert);

				$stmt_select = $this->database->prepare($sql_select);
				$stmt_select->bindParam(1, $rank[0]['rank'], PDO::PARAM_INT);
				$stmt_select->bindParam(2, $limit, PDO::PARAM_INT);
				$stmt_select->execute();

				$stmt_select->bindColumn(1, $user_ip, PDO::PARAM_LOB);
				$stmt_select->bindColumn(2, $user_name, PDO::PARAM_STR);
				$stmt_select->bindColumn(3, $flow_up, PDO::PARAM_INT);
				$stmt_select->bindColumn(4, $flow_down, PDO::PARAM_INT);
				$stmt_select->bindColumn(5, $flow_total, PDO::PARAM_INT);
				
				//开启事务
				$this->database->beginTransaction();
				while ($stmt_select->fetch(PDO::FETCH_BOUND)) {
					if ($user_name){
						$stmt_update = $stmt_update_name;
						$stmt_update->bindParam(4, $user_name, PDO::PARAM_STR);
					} else {
						$stmt_update = $stmt_update_ip;
						$stmt_update->bindParam(4, $user_ip, PDO::PARAM_LOB);
					}
					$stmt_update->bindParam(1, $flow_up, PDO::PARAM_INT);
					$stmt_update->bindParam(2, $flow_down, PDO::PARAM_INT);
					$stmt_update->bindParam(3, $flow_total, PDO::PARAM_INT);

					if ($stmt_update->execute() && $stmt_update->rowCount()>=1){
						continue;
					}				 
					if ($user_name) {
						$stmt_insert->bindParam(1, $user_ip, PDO::PARAM_NULL);
						$stmt_insert->bindParam(2, $user_name, PDO::PARAM_STR);
					} else {
						$stmt_insert->bindParam(1, $user_ip, PDO::PARAM_LOB);
						$stmt_insert->bindParam(2, $user_name, PDO::PARAM_NULL);						
					}

					$stmt_insert->bindParam(3, $flow_up, PDO::PARAM_INT);
					$stmt_insert->bindParam(4, $flow_down, PDO::PARAM_INT);
					$stmt_insert->bindParam(5, $flow_total, PDO::PARAM_INT);
					$stmt_insert->execute();
				}
				$this->database->commit();

			}

			if (file_exists($path.$value)) {
				$sql = "detach database main_tmp";
				$this->sql_exec($sql);			
			}
		}

/*		$sql = "insert into ".$table_name."(user_ip,user_name,flow_up,flow_down,flow_total) select user_ip,user_name,flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp order by flow_total desc";
		$this->sql_exec($sql);

		$sql = "drop table tmp";
		$this->sql_exec($sql);
*/
		if ($is_return) {
			return $this->detail_trend_query($data, $path, $table_name, $param, $app_id);
		}
		

	}

	function user_detail_query($data, $path, $param, $limit=200) {
		$this->get_db();
		//数据表整合
		$main_table = "user_main";
		$user_table = "user_app";
		$table_name = "user_detail";
		if ($param['is_user'] == 1) {
			$user_name = trim($param['user_name']);
		} else {
			$user_ip = inet_pton($param['user_name']);
		}

		if ($user_ip) {
			$user_query = "user_ip=?";
		}
		if ($user_name) {
			$user_query = "user_name=?";
		}

		$this->clean_table($table_name);

		/*$sql = "CREATE TABLE `tmp` (
	      `app_id` int PRIMARY KEY,
	      `flow_up` int,
	      `flow_down` int,
	      `flow_total` int
	    )";
		$this->sql_exec($sql);*/

		$sql = "CREATE TABLE `".$table_name."` (
	      `app_id` int,
	      `flow_up` int,
	      `flow_down` int,
	      `flow_total` int
	    )";
		$this->sql_exec($sql);

		//添加索引
		$sql = "CREATE INDEX IF NOT EXISTS app_id_".$table_name." ON ".$table_name."(app_id)";
		$this->sql_exec($sql);
		$sql = "CREATE INDEX IF NOT EXISTS flow_total_".$table_name." ON ".$table_name."(flow_total)";
		$this->sql_exec($sql);

		foreach ($data as $key => $value) {

			if (file_exists($path.$value)) {
				$sql = "attach '".$path.$value."' as udetail_tmp";	
				if (!$this->sql_exec($sql)) {
				continue;
				}		
			} else {
				continue;
			}

			$sql = "select rank from udetail_tmp.".$main_table." where ".$user_query;
			$stmt = $this->database->prepare($sql);
			if ($user_ip){
				$stmt->bindParam(1, $user_ip,  PDO::PARAM_LOB);
			}
			if ($user_name) {
				$stmt->bindParam(1, $user_name, PDO::PARAM_STR, 64);
			}
			$stmt->execute();
			$rank = $stmt->fetchAll();
			if (empty($rank)){
				goto next;
			}

			$sql_select = "select app_id,flow_up,flow_down,(flow_up+flow_down) as flow_total from udetail_tmp.".$user_table." where udetail_tmp.".$user_table.".parent=? order by flow_total desc";
			$sql_update = "update ".$table_name." set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where app_id=?";
			$sql_insert = "insert into ".$table_name."(app_id, flow_up, flow_down, flow_total) values(?,?,?,?)";

			$stmt_update = $this->database->prepare($sql_update);
			$stmt_insert = $this->database->prepare($sql_insert);

			$stmt_select = $this->database->prepare($sql_select);
			$stmt_select->bindParam(1, $rank[0]['rank'], PDO::PARAM_INT);
			// $stmt_select->bindParam(2, $limit, PDO::PARAM_INT);
			$stmt_select->execute();

			$stmt_select->bindColumn(1, $app_id, PDO::PARAM_INT);
			$stmt_select->bindColumn(2, $flow_up, PDO::PARAM_INT);
			$stmt_select->bindColumn(3, $flow_down, PDO::PARAM_INT);
			$stmt_select->bindColumn(4, $flow_total, PDO::PARAM_INT);

			//开启事务
			$this->database->beginTransaction();
			while ($stmt_select->fetch(PDO::FETCH_BOUND)) {
				$stmt_update->bindParam(1, $flow_up, PDO::PARAM_INT);
				$stmt_update->bindParam(2, $flow_down, PDO::PARAM_INT);
				$stmt_update->bindParam(3, $flow_total, PDO::PARAM_INT);
				$stmt_update->bindParam(4, $app_id, PDO::PARAM_INT);

				if ($stmt_update->execute() && $stmt_update->rowCount()>=1){
					continue;
				}				 

				$stmt_insert->bindParam(1, $app_id, PDO::PARAM_INT);
				$stmt_insert->bindParam(2, $flow_up, PDO::PARAM_INT);
				$stmt_insert->bindParam(3, $flow_down, PDO::PARAM_INT);
				$stmt_insert->bindParam(4, $flow_total, PDO::PARAM_INT);
				$stmt_insert->execute();
			}
			$this->database->commit();

		next:
			$sql = "detach database udetail_tmp";
			$this->sql_exec($sql);
		}
		/*$sql = "insert into ".$table_name."(app_id,flow_up,flow_down,flow_total) select app_id,flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp order by flow_total desc";
		$this->sql_exec($sql);

		$sql = "drop table tmp";
		$this->sql_exec($sql);*/
	}

	function user_cate_detail_query($data, $path, $param, $limit=200) {
		$this->get_db();
		//数据表整合
		$main_table = "user_main";
		$user_table = "user_category";
		$table_name = "user_cate_detail";
		if ($param['is_user'] == 1) {
			$user_name = trim($param['user_name']);
		} else {
			$user_ip = inet_pton($param['user_name']);
		}

		if ($user_ip) {
			$user_query = "user_ip=?";
		}
		if ($user_name) {
			$user_query = "user_name=?";
		}

		$this->clean_table($table_name);

		/*$sql = "CREATE TABLE `tmp` (
	      `app_id` int PRIMARY KEY,
	      `flow_up` int,
	      `flow_down` int,
	      `flow_total` int
	    )";
		$this->sql_exec($sql);*/

		$sql = "CREATE TABLE `".$table_name."` (
	      `category_id` int,
	      `flow_up` int,
	      `flow_down` int,
	      `flow_total` int
	    )";
		$this->sql_exec($sql);

		//添加索引
		$sql = "CREATE INDEX IF NOT EXISTS category_id_".$table_name." ON ".$table_name."(category_id)";
		$this->sql_exec($sql);
		$sql = "CREATE INDEX IF NOT EXISTS flow_total_".$table_name." ON ".$table_name."(flow_total)";
		$this->sql_exec($sql);

		foreach ($data as $key => $value) {

			if (file_exists($path.$value)) {
				$sql = "attach '".$path.$value."' as udetail_tmp";	
				if (!$this->sql_exec($sql)) {
				continue;
				}		
			} else {
				continue;
			}

			$sql = "select rank from udetail_tmp.".$main_table." where ".$user_query;
			$stmt = $this->database->prepare($sql);
			if ($user_ip){
				$stmt->bindParam(1, $user_ip,  PDO::PARAM_LOB);
			}
			if ($user_name) {
				$stmt->bindParam(1, $user_name, PDO::PARAM_STR, 64);
			}
			$stmt->execute();
			$rank = $stmt->fetchAll();
			if (empty($rank)){
				goto next;
			}

			
			$sql_select = "select category_id,flow_up,flow_down,(flow_up+flow_down) as flow_total from udetail_tmp.".$user_table." where udetail_tmp.".$user_table.".parent=? order by flow_total desc";
			$sql_update = "update ".$table_name." set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where category_id=?";
			$sql_insert = "insert into ".$table_name."(category_id, flow_up, flow_down, flow_total) values(?,?,?,?)";

			$stmt_update = $this->database->prepare($sql_update);
			$stmt_insert = $this->database->prepare($sql_insert);

			$stmt_select = $this->database->prepare($sql_select);
			$stmt_select->bindParam(1, $rank[0]['rank'], PDO::PARAM_INT);
			// $stmt_select->bindParam(2, $limit, PDO::PARAM_INT);
			$stmt_select->execute();

			$stmt_select->bindColumn(1, $category_id, PDO::PARAM_INT);
			$stmt_select->bindColumn(2, $flow_up, PDO::PARAM_INT);
			$stmt_select->bindColumn(3, $flow_down, PDO::PARAM_INT);
			$stmt_select->bindColumn(4, $flow_total, PDO::PARAM_INT);

			//开启事务
			$this->database->beginTransaction();

			while ($stmt_select->fetch(PDO::FETCH_BOUND)) {
				$stmt_update->bindParam(1, $flow_up, PDO::PARAM_INT);
				$stmt_update->bindParam(2, $flow_down, PDO::PARAM_INT);
				$stmt_update->bindParam(3, $flow_total, PDO::PARAM_INT);
				$stmt_update->bindParam(4, $category_id, PDO::PARAM_INT);

				if ($stmt_update->execute() && $stmt_update->rowCount()>=1){
					continue;
				}				 

				$stmt_insert->bindParam(1, $category_id, PDO::PARAM_INT);
				$stmt_insert->bindParam(2, $flow_up, PDO::PARAM_INT);
				$stmt_insert->bindParam(3, $flow_down, PDO::PARAM_INT);
				$stmt_insert->bindParam(4, $flow_total, PDO::PARAM_INT);
				$stmt_insert->execute();
			}
			$this->database->commit();

		next:
			$sql = "detach database udetail_tmp";
			$this->sql_exec($sql);
		}

		/*$sql = "insert into ".$table_name."(app_id,flow_up,flow_down,flow_total) select app_id,flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp order by flow_total desc";
		$this->sql_exec($sql);

		$sql = "drop table tmp";
		$this->sql_exec($sql);*/
	}
	function detail_trend_query($data, $path, $name, $param, $app_id, $limit=10) {

		$sql = "select user_ip,user_name,(flow_up+flow_down) as flow_total from ".$name." order by flow_total desc limit 0,".$limit;
		$list = $this->sql_query($sql);
		$num = count($data);

		if ($param['category']) {
			$main_table = "category_main";
			$user_table = "category_user";
			$field_name = 'category_id';
/*			$name_cn = 'category_name_cn';
			$name_en = 'category_name_en';*/
		} else {
			$main_table = "app_main";
			$user_table = "app_user";
			$field_name = 'app_id';
/*			$name_cn = 'app_name_cn';
			$name_en = 'app_name_en';*/			
		}

		$item = array();
		$user_item = array();
		//整合统计图数据
		foreach($data as $key=>$val) {
			//用于判断数据库是否存在
			$sign = false;
			if (file_exists($path.$val)) {
				$sql = "attach database '". $path . $val ."' as tmp";
				$this->sql_exec($sql);
			} else {
				$sign = true;
			}

			if ($sign == false){
				$sql = "select rank,flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp.".$main_table." where ".$field_name."=".$app_id;
				$tmp = $this->sql_query($sql);
			} else {
				$tmp = array();
			}
			//统计图显示数据
			if(!$item[name])$item[name] = $param['app_name'];
			if(!$item[name_cn])$item[name_cn] = $param['app_name'];
			if ($num == 60) {
				$flow_up = $tmp?(ceil($tmp[0]['flow_up']*8/60)):0;
				$flow_down = $tmp?(ceil($tmp[0]['flow_down']*8/60)):0;
				$flow_total = $tmp?(ceil($tmp[0]['flow_total']*8/60)):0;
			} elseif($num == 144) {
				$flow_up = $tmp?(ceil($tmp[0]['flow_up']*8/600)):0;
				$flow_down = $tmp?(ceil($tmp[0]['flow_down']*8/600)):0;
				$flow_total = $tmp?(ceil($tmp[0]['flow_total']*8/600)):0;
			} else {
				$flow_up = $tmp?(ceil($tmp[0]['flow_up']*8/3600)):0;
				$flow_down = $tmp?(ceil($tmp[0]['flow_down']*8/3600)):0;
				$flow_total = $tmp?(ceil($tmp[0]['flow_total']*8/3600)):0;			
			}
			$item[up_bytes] .= $flow_up;
			$item[up_bytes] .= ',';
			$item[down_bytes] .= $flow_down;
			$item[down_bytes] .= ',';
			$item[total_bytes] .= $flow_total;
			$item[total_bytes] .= ',';
			for ($i =0;$i<count($list);$i++) {
				if (!empty($tmp)) {
					if ($list[$i]['user_ip']) {
						$sql_query = " and tmp.".$user_table.".user_ip=?";
					}
					if ($list[$i]['user_name']) {
						$sql_query = " and tmp.".$user_table.".user_name=?";
					}

					$sql = "select user_ip,user_name,flow_up,flow_down,(flow_up+flow_down) as flow_total from tmp.".$user_table." where tmp.".$user_table.".parent=?" . $sql_query;
					$stmt = $this->database->prepare($sql);

					$stmt->bindParam(1, $tmp[0]['rank'],  PDO::PARAM_INT);
					if ($list[$i]['user_ip']){
						$stmt->bindParam(2, $list[$i]['user_ip'],  PDO::PARAM_LOB);
					}
					if ($list[$i]['user_name']) {
						$stmt->bindParam(2, $list[$i]['user_name'], PDO::PARAM_STR);
					}
					
					$stmt->execute();
					$info = $stmt->fetchAll();
				} else {
					$info = array();
				}

				$tmp_arr = array();

				if(!empty($info)) {

					$tmp_arr[name] = $info[0]['user_name'] ? $info[0]['user_name']: inet_ntop($info[0]['user_ip']);
					if ($num == 60) {
						$user_flow_up = ceil($info[0]['flow_up']*8/60);
						$user_flow_down = ceil($info[0]['flow_down']*8/60);
						$user_flow_total = ceil($info[0]['flow_total']*8/60);
					} elseif($num == 144) {
						$user_flow_up = ceil($info[0]['flow_up']*8/600);
						$user_flow_down = ceil($info[0]['flow_down']*8/600);
						$user_flow_total = ceil($info[0]['flow_total']*8/600);
					} else {
						$user_flow_up = ceil($info[0]['flow_up']*8/3600);
						$user_flow_down = ceil($info[0]['flow_down']*8/3600);
						$user_flow_total = ceil($info[0]['flow_total']*8/3600);				
					}
					$tmp_arr[up_bytes] = $user_flow_up;
					$tmp_arr[down_bytes] = $user_flow_down;
					$tmp_arr[total_bytes] = $user_flow_total;
					$user_item[pos_.$key][group][] = $tmp_arr;
				}
			}
			if (file_exists($path.$val)) {
				$sql = "detach database tmp";
				$this->sql_exec($sql);
			}
		}

		$list = array();
		$list[start_time] = $this->get_start_time($data);
		$items[group] = $item;
		$list[items] = json_encode($items);
		$list[user_items] = json_encode($user_item);
		return $list;
	}

	function user_name_trend_query($data, $path, $param, $limit=200) {
		$this->get_db();
		$main_table = "user_main";
		$table_name = "user";
		$user_table = "user_app";
		$num = count($data);

		if ($param['is_user'] == 1) {
			$user_name = $param['user_name'];
		} else {
			$user_ip = inet_pton($param['user_name']);
		}

		if (file_exists('/tmp/app_statistic.db')) {
			$sql = "attach database '/tmp/app_statistic.db' as app_name";
			$this->sql_exec($sql);
		}

		$sql = "select app_id,flow_total from user_detail order by flow_total desc limit 0,".$limit;
		$list = $this->sql_query($sql);
		//将数据转为一维数组
		$list = array_column($list,'app_id');
		$list_arr = implode(',', $list);

		if ($user_ip) {
			$query = " user_ip=?";
		}
		if ($user_name) {
			$query = " user_name=?";
		}

		$item = array();
		$user_item = array();
		//整合统计图数据
		foreach($data as $key=>$val) {
			//用于判断数据库是否存在
			$sign = false;
			$is_exists = file_exists($path.$val);
			if ($is_exists) {
				$sql = "attach database '". $path . $val ."' as user_app_tmp";
				if (!$this->sql_exec($sql)) {
					continue;
				}
			} else {
				$sign = true;
			}

			if ($sign == false){
				$sql = "select rank,flow_up,flow_down,(flow_up+flow_down) as flow_total from user_app_tmp.".$main_table." where ".$query;
				$stmt = $this->database->prepare($sql);
				if ($user_ip){
					$stmt->bindParam(1, $user_ip,  PDO::PARAM_LOB);
				}
				if ($user_name) {
					$stmt->bindParam(1, $user_name, PDO::PARAM_STR);
				}
				$stmt->execute();
				$info = $stmt->fetchAll();
			} else {
				$info = array();
			}
			//通过主表的rank值匹配子表中关联数据
			if (!empty($info)) {
				$sql = "select app_id,flow_up,flow_down,(flow_up+flow_down) as flow_total from user_app_tmp.".$user_table." where user_app_tmp.".$user_table.".parent=".$info[0]['rank']." and user_app_tmp.".$user_table.".app_id in(".$list_arr.")";
				$info = $this->sql_query($sql);
			} else {
				$info = array();
			}

			if(!empty($info)) {
				for ($i=0; $i < count($info); $i++) { 
					if (in_array($info[$i]['app_id'], $list)){
						$user_item[$info[$i]['app_id']][$key]['flow_up'] = $info[$i]['flow_up']*8;
						$user_item[$info[$i]['app_id']][$key]['flow_down'] = $info[$i]['flow_down']*8;
						$user_item[$info[$i]['app_id']][$key]['flow_total'] = $info[$i]['flow_total']*8;
					}
				}
			}

			if ($is_exists) {
				$sql = "detach database user_app_tmp";
				$this->sql_exec($sql);				
			}
		}
		$user_item_index = 0;
		$otherapp_flow_up_arr = array();
		$otherapp_flow_down_arr = array();
		$otherapp_flow_total_arr = array();
		//循环查询应用名称
		foreach ($list as $key => $value) {
			$tmp_arr = array();
			$tmp_otherapp_arr = array();
			$tmp_otherapp_arr[name]="other";
			$tmp_otherapp_arr[name_cn]=($this->lang==2)?"其他应用":"other";
			/*$sql = "select app_name_cn,app_name_en from app_name.app_info where app_id=".$value;
			$tmp = $this->sql_query($sql);*/
			$tmp = $this->get_app_name($value);
			if(!$tmp_arr[name])$tmp_arr[name] = $tmp[0]['app_name_en'];
			if(!$tmp_arr[name_cn])$tmp_arr[name_cn] = ($this->lang==2)?$tmp[0]['app_name_cn']:$tmp[0]['app_name_en'];
			for ($i = 0;$i<count($data);$i++){
				if ($num == 60) {
					if($user_item_index>9){
						$otherapp_flow_up_arr[$i] +=$user_item[$value][$i]['flow_up']?(ceil($user_item[$value][$i]['flow_up']/60)):0;
						$otherapp_flow_down_arr[$i] += $user_item[$value][$i]['flow_down']?(ceil($user_item[$value][$i]['flow_down']/60)):0;
						$otherapp_flow_total_arr[$i] += $user_item[$value][$i]['flow_total']?(ceil($user_item[$value][$i]['flow_total']/60)):0;
					}else{
						$flow_up = $user_item[$value][$i]['flow_up']?(ceil($user_item[$value][$i]['flow_up']/60)):0;
						$flow_down = $user_item[$value][$i]['flow_down']?(ceil($user_item[$value][$i]['flow_down']/60)):0;
						$flow_total = $user_item[$value][$i]['flow_total']?(ceil($user_item[$value][$i]['flow_total']/60)):0;
					}
					
				} elseif($num == 144) {
					if($user_item_index>9){
						$otherapp_flow_up_arr[$i]+=$user_item[$value][$i]['flow_up']?(ceil($user_item[$value][$i]['flow_up']/600)):0;
						$otherapp_flow_down_arr[$i] += $user_item[$value][$i]['flow_down']?(ceil($user_item[$value][$i]['flow_down']/600)):0;
						$otherapp_flow_total_arr[$i] += $user_item[$value][$i]['flow_total']?(ceil($user_item[$value][$i]['flow_total']/600)):0;
					}else{
						$flow_up = $user_item[$value][$i]['flow_up']?(ceil($user_item[$value][$i]['flow_up']/600)):0;
						$flow_down = $user_item[$value][$i]['flow_down']?(ceil($user_item[$value][$i]['flow_down']/600)):0;
						$flow_total = $user_item[$value][$i]['flow_total']?(ceil($user_item[$value][$i]['flow_total']/600)):0;
					}
				} else {
					if($user_item_index>9){
						$otherapp_flow_up_arr[$i]+=$user_item[$value][$i]['flow_up']?(ceil($user_item[$value][$i]['flow_up']/3600)):0;
						$otherapp_flow_down_arr[$i] += $user_item[$value][$i]['flow_down']?(ceil($user_item[$value][$i]['flow_down']/3600)):0;
						$otherapp_flow_total_arr[$i] += $user_item[$value][$i]['flow_total']?(ceil($user_item[$value][$i]['flow_total']/3600)):0;
					}else{

						$flow_up = $user_item[$value][$i]['flow_up']?(ceil($user_item[$value][$i]['flow_up']/3600)):0;
						$flow_down = $user_item[$value][$i]['flow_down']?(ceil($user_item[$value][$i]['flow_down']/3600)):0;
						$flow_total = $user_item[$value][$i]['flow_total']?(ceil($user_item[$value][$i]['flow_total']/3600)):0;	
					}			
				}

				if($user_item_index < 10) {
					$tmp_arr[up_bytes] .= $flow_up;
					$tmp_arr[up_bytes] .= ',';
					$tmp_arr[down_bytes] .= $flow_down;
					$tmp_arr[down_bytes] .= ',';
					$tmp_arr[total_bytes] .= $flow_total;
					$tmp_arr[total_bytes] .= ',';
				}

				
				/*$tmp_arr[up_bytes] .= $flow_up;
				$tmp_arr[up_bytes] .= ',';
				$tmp_arr[down_bytes] .= $flow_down;
				$tmp_arr[down_bytes] .= ',';
				$tmp_arr[total_bytes] .= $flow_total;
				$tmp_arr[total_bytes] .= ',';*/
					
			}

			//$order = array_search($value, $list);
			$item[] = $tmp_arr;
			$user_item_index++;
		}
		//数组重新排序
		$tmp_otherapp_arr[up_bytes] = implode(",", $otherapp_flow_up_arr);
		$tmp_otherapp_arr[down_bytes] = implode(",", $otherapp_flow_down_arr);
		$tmp_otherapp_arr[total_bytes] = implode(",", $otherapp_flow_total_arr);
		//ksort($item);

		if( count($user_item)>10){

			$item_10 = array_slice($item,0,10);
			$item_10[] = $tmp_otherapp_arr;
			$item = $item_10;
		}
		
		
		$sql = "detach database app_name";
		$this->sql_exec($sql);

		return $item;
	}

	function user_trend_query($data, $path, $param, $limit=200) {
		$this->get_db();
		$user_table = 'user_main';
		//如果临时表未删除则删除临时表
		$this->clean_table('user');

		//创建临时表添加索引
		$sql = "CREATE TABLE `user` (	
			`user_ip` blob,
			`user_name` varchar(64),
			`user_type` varchar(24),
			`flow_up` int,
			`flow_down` int,
			`flow_total` int
	    )";
		$this->sql_exec($sql);
		//后期商议，因临时表速度优于结果表，暂取消临时表
/*		$sql = "CREATE TABLE `user` (
	      `user_ip` blob,
	      `user_name` varchar(64),
	      `flow_up` int,
	      `flow_down` int,
	      `flow_total` int
	    )";
		$this->sql_exec($sql);*/

		//创建索引
		$sql = "CREATE INDEX IF NOT EXISTS user_ip_key ON user(user_ip)";
		$this->sql_exec($sql);
		$sql = "CREATE INDEX IF NOT EXISTS user_name_key ON user(user_name)";
		$this->sql_exec($sql);
		$sql = "CREATE INDEX IF NOT EXISTS flow_total_key ON user(flow_total)";
		$this->sql_exec($sql);

		$sql_select = "select user_ip,user_name,flow_up,flow_down,flow_up+flow_down from user_tmp.".$user_table." where user_tmp.".$user_table.".rowid<=".$limit;
		$sql_update_ip = "update user set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where user_ip=?";
		$sql_update_name = "update user set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where user_name=?";
		$sql_insert = "insert or ignore into user(user_ip, user_name, user_type, flow_up, flow_down, flow_total) values(?,?,?,?,?,?)";
		/*$sql_update_ip = "update user set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where user_ip=? and user_type=?";
		$sql_update_name = "update user set flow_up=flow_up+?,flow_down=flow_down+?,flow_total=flow_total+? where user_name=? and user_type=?";
		$sql_insert = "insert or ignore into user(user_ip, user_name, user_type, flow_up, flow_down, flow_total) values(?,?,?,?,?,?)";*/

		foreach ($data as $key => $value) {
			$stmt_update_ip = $this->database->prepare($sql_update_ip);
			$stmt_update_name = $this->database->prepare($sql_update_name);
			$stmt_insert = $this->database->prepare($sql_insert);

			if (file_exists($path.$value)) {
				$sql = "attach '".$path.$value."' as user_tmp";
				if(!$this->sql_exec($sql)){
					continue;
				}
			} else {
				continue;
			}

			//修改为批量插入数据
			$stmt_select = $this->database->prepare($sql_select);
			$stmt_select->execute();
			$stmt_select->bindColumn(1, $uip, PDO::PARAM_LOB);
			$stmt_select->bindColumn(2, $uname, PDO::PARAM_STR);
			$stmt_select->bindColumn(3, $flow_up, PDO::PARAM_INT);
			$stmt_select->bindColumn(4, $flow_down, PDO::PARAM_INT);
			$stmt_select->bindColumn(5, $flow_total, PDO::PARAM_INT);

			//开启事务
			$this->database->beginTransaction();
			while ($stmt_select->fetch(PDO::FETCH_BOUND)) {
				if ($uname){
					$stmt_update = $stmt_update_name;
				} else {
					$stmt_update = $stmt_update_ip;
				}

				$stmt_update->bindValue(1, $flow_up, PDO::PARAM_INT);
				$stmt_update->bindValue(2, $flow_down, PDO::PARAM_INT);
				$stmt_update->bindValue(3, $flow_total, PDO::PARAM_INT);
				//修改和添加动作查询条件
				if ($uname){
					$stmt_update->bindValue(4, $uname, PDO::PARAM_STR);
					// $stmt_update->bindValue(5, 'auth', PDO::PARAM_STR);
				} else {
					$stmt_update->bindValue(4, $uip, PDO::PARAM_LOB);
					// $stmt_update->bindValue(5, 'anonymous', PDO::PARAM_STR);
				}	
				if ($stmt_update->execute() && $stmt_update->rowCount()>=1){
					continue;
				}
				if ($uname) {
					if(inet_pton($uname)) {
						$stmt_insert->bindValue(1, inet_pton($uname), PDO::PARAM_LOB);
					} else {
						$stmt_insert->bindValue(1, $uip, PDO::PARAM_NULL);
					}
					
					$stmt_insert->bindValue(2, $uname, PDO::PARAM_STR);
					$stmt_insert->bindValue(3, 'auth', PDO::PARAM_STR);
				} else {
					$stmt_insert->bindValue(1, $uip, PDO::PARAM_LOB);
					$stmt_insert->bindValue(2, inet_ntop($uip), PDO::PARAM_STR);
					$stmt_insert->bindValue(3, 'anonymous', PDO::PARAM_STR);
				}

				$stmt_insert->bindValue(4, $flow_up, PDO::PARAM_INT);
				$stmt_insert->bindValue(5, $flow_down, PDO::PARAM_INT);
				$stmt_insert->bindValue(6, $flow_total, PDO::PARAM_INT);
				$stmt_insert->execute();
			}
			//提交事务
			$this->database->commit();

			$sql = "detach database user_tmp";
			$this->sql_exec($sql);

		}
	}

	function user_detail_trend_query($table,$limit=200,$category=''){
		$sql = "select * from ".$table." order by flow_total desc limit 0,".$limit;
		$list = $this->sql_query($sql);

		if (file_exists('/tmp/app_statistic.db')) {
			$sql = "attach database '/tmp/app_statistic.db' as app_name";
			$this->sql_exec($sql);
		}

		$data = array();
		if (!empty($list)) {
			foreach ($list as $key => $value) {
				if($category!=''){
					$sql = "select category_name_cn,category_name_en from app_name.category_info where category_id=".$value['category_id'];
					$tmp_name = $this->sql_query($sql);

					$data[$key][name] = $tmp_name[0]['category_name_en'];
					$data[$key][name_cn] = ($this->lang==2)?$tmp_name[0]['category_name_cn']:$tmp_name[0]['category_name_en'];
					
				}else{
					/*$sql = "select app_name_cn,app_name_en from app_name.app_info where app_id=".$value['app_id'];
					$tmp_name = $this->sql_query($sql);*/
					$tmp_name = $this->get_app_name($value['app_id']);

					$data[$key][name] = $tmp_name[0]['app_name_en'];
					$data[$key][name_cn] = ($this->lang==2)?$tmp_name[0]['app_name_cn']:$tmp_name[0]['app_name_en'];
					/*$data[$key][up_bytes] = $value['flow_up'];
					$data[$key][down_bytes] = $value['flow_down'];
					$data[$key][total_bytes] = $value['flow_total'];*/
				}
				$data[$key][up_bytes] = $value['flow_up'];
				$data[$key][down_bytes] = $value['flow_down'];
				$data[$key][total_bytes] = $value['flow_total'];
				
			}
			$sql = "select sum(flow_total) as all_total_bytes from ".$table;
			$total = $this->sql_query($sql);
			$item[data][0][items][group] = $data;
			$item[data][0][items][all_total_bytes] = $total[0]['all_total_bytes'];

			return $item;
		}
	}

	function get_start_time($data) {
		$time = explode('.', $data[0])[0];
		$time = str_replace('_', ' ', $time);
		$time = strtotime($time);
/*		$num = count($data);
		$min = 60;
		$hour = 60 * 60;
		//计算起始时间
		if ($num == 60) {
			$time = $time - $min * (60 - 1);
		} else if ($num == 144) {
			$time = $time - ($hour * 24 - 1);
		} else {
			$time = $time - $hour * (24 * 7 - 1);
		}*/
		//加时差
		$time = $time + date('Z');
		return $time;
	}

	function get_app_name($name) {
		$this->get_db();
		$info=array();
		//判断数据库是否存在
		if (file_exists('/tmp/app_statistic.db')) {
			$sql = "attach database '/tmp/app_statistic.db' as app_name";
			$this->sql_exec($sql);
			//查询语句拼接
			$sql = "select app_name_cn,app_name_en from app_name.app_info where app_id=".$name;
			$tmp_name = $this->sql_query($sql);

			if (!empty($tmp_name)){
				$info = $tmp_name;
			} else {
				//自定义表单查询
				$app_custom_table = 'app_custom_info';
				$custom_sql = " select app_name_cn,app_name_en from app_name.".$app_custom_table." where app_id=".$name;
				$custom_name = $this->sql_query($custom_sql);

				if (!empty($custom_name)) {
					$info = $custom_name;
				} else {
					$info = array(
						0 => array(
							'app_name_cn' => '已删除应用'.$name,
							'app_name_en' => 'Application Deleted'.$name
						)
					);
				}
			}
		}
		return $info;
	}
	function get_category_name($name) {
		$this->get_db();
		$info=array();
		//判断数据库是否存在
		if (file_exists('/tmp/app_statistic.db')) {
			$sql = "attach database '/tmp/app_statistic.db' as category_name";
			$this->sql_exec($sql);
			//查询语句拼接
			$sql = "select category_name_cn,category_name_en from category_name.category_info where category_id=".$name;
			$tmp_name = $this->sql_query($sql);

			if (!empty($tmp_name)){
				$info = $tmp_name;
			} else {
				//自定义表单查询
				$app_custom_table = 'category_custom_info';
				$custom_sql = " select category_name_cn,category_name_en from category_name.".$app_custom_table." where category_id=".$name;
				$custom_name = $this->sql_query($custom_sql);

				if (!empty($custom_name)) {
					$info = $custom_name;
				}
			}
		}
		return $info;
	}
	function create_time_table() {
		$this->get_db();
		$table = 'generate_time';
		$sql = "CREATE TABLE  `".$table."` (		
			`name` varchar(64) PRIMARY KEY,
			`timerange` varchar(32),
			`filenum` int,
			`filename` varchar(32),
			`updatetime` int
	    )";
		$this->sql_exec($sql);

		$sql = "CREATE INDEX IF NOT EXISTS timerange_key ON ".$table."(timerange);
				CREATE INDEX IF NOT EXISTS updatetime_key ON ".$table."(updatetime)";
		$this->sql_exec($sql);

		$sql = "insert into generate_time(name,timerange,filenum,updatetime,filename) values('app',0,0,0,''),('category',0,0,0,''),('user',0,0,0,'')";
		$this->sql_exec($sql);
	}
	function update_time_table($data) {
		$this->get_db();
		$sql = 'update generate_time set timerange=' . $data['timerange'] . ',updatetime='.time().',filenum='.$data['filenum'].',filename="'.$data['filename'].'" where name="'.$data['name'].'"';
		$this->sql_exec($sql);
	}
	function get_time_range($range) {
		switch ($range) {
			case '1':
				return 'min1';
				break;
			case '2':
				return 'min10';
				break;
			case '3':
				return 'hour1';
				break;
			default:
				break;
		}
	}
	function get_db_array($range, $date) {
		$data = array();

		switch ($range) {
			case '1':
				$per = 60;
				$num = 60;
				break;
			case '2':
				$per = 60 * 10;
				$num = 144;
				break;
			case '3':
				$per= 60 * 60;
				$num = 168;
				break;
		}

		for($i=1;$i<=$num;$i++){
			$tmp = $date - $i * $per;
			if ($num == 168) {
				$data[] = date('Ymd_H',$tmp).'0000.db';
			} else if ($num == 144) {
				$tmp = floor($tmp/$per) * $per;
				$data[] = date('Ymd_Hi',$tmp).'00.db';
			} else {
				$data[] = date('Ymd_Hi',$tmp).'00.db';
			}
		}
		$data = array_reverse($data);
		return $data;
	}

	function get_cache_time($param, $table_name) {
		$time_table = 'generate_time';
		if ($this->sql_exists($table_name) && $this->sql_exists($time_table)) {
			//防止4.0版本升级4.1后数据表不更新
			$field_query_sql = 'select * from sqlite_master where name="'.$time_table.'" and sql like "%filename%"';
			$field_query = $this->sql_query($field_query_sql);
			if (empty($field_query[0])) {
				$del_sql = 'DROP TABLE '.$time_table;
				$ret = $this->sql_exec($del_sql);

				if ($ret) {
					$this->create_time_table();
					return false;
				}
			}
			$sql = "select timerange,updatetime,filenum,filename from " . $time_table . " WHERE name='".$table_name."'";
			$time = $this->sql_query($sql);
			$time = $time[0];
			if ($param['range'] == $time['timerange'] && $num == $time['filenum']) {
				//异常机制处理
				$file_array = scandir('/tmp/flow_statistic/'.$this->get_time_range($param['range']).'/', 1);
				$last_file = $file_array[0];
				if (strrchr($last_file, '.db') !==  '.db'){
					$last_file = $file_array[1];
				}

				if ($last_file === $time['filename']) {
					return $time['updatetime'];				
				}
				return false;
			}
		}

		return false;
	}
}
?>