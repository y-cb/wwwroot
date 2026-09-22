<?php
namespace database;
use database\Medoo;
use PDO;
class SqliteDb{
	public $database;
	function getDb(){
		return new Medoo([
			// 必填
			'database_type' => 'sqlite',
			'database_name' => 'syslog',
			'database_file' => '/tmp/locallog/event_log.db',
		 
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
		$end--;
		$s = strftime('%Y-%m-%d  %H:%M:%S', $start);
		$e = strftime('%Y-%m-%d  %H:%M:%S', $end);

		if (isset($where)) {
			$con = ["LIMIT" => [$idx, $num], "ORDER" => "id DESC"];
			$con['AND'] = array_merge($where, ["create_at[<>]" => [$s, $e]]);
		} else {
			$con = ["LIMIT" => [$idx, $num], "ORDER" => "id DESC"];
			$con["create_at[<>]"] = [$s, $e];
		}

		/*
		var_dump($start);
		var_dump($end);
		var_dump($where);
		*/
		$this->database = self::getDb();
		if (is_same_day($start, $end)) {
				$day = strftime("%Y%m%d", $start);
				$table_name = $module.'_'. $day;
				$data = $this->database->select($table_name, "*", $con);
				//echo $database->last_query();
				return $data;
		}
		return null;
	}

	function webui_count($module, $start, $end,  $where=array())
	{
		$end--;
		$s = strftime('%Y-%m-%d  %H:%M:%S', $start);
		$e = strftime('%Y-%m-%d  %H:%M:%S', $end);
		
		if (isset($where)) {
			$where["create_at[<>]"] = [$s, $e];
			$con['AND'] = $where;
		} else {
			$con = ["create_at[<>]" => [$s, $e]];
		}
		$this->database = self::getDb();

		if (is_same_day($start, $end)) {
			$day = strftime("%Y%m%d", $start);
			$table_name = $module.'_'. $day;

			$data = $this->database->count($table_name, $con);
			//echo $database->last_query();
			if ($data == false) {
				return 0;
			}
			return $data;
		}
		return 0;
	}
	function sys_report_query($module,$where=array())
	{
		if (isset($where)) {
			$con = ["ORDER" => "id DESC"];	
			$con['AND'] = $where;
			
			/*$where_name["name"]=$where;
			$con['AND'] = $where_name;*/
		} else {
			$con = [];
		}
		/*$where["name"] = $where;
		$con['AND'] = $where;*/
		//$where["name"] = $where; 

		/*$whereqqq=array(
		   "AND"=>array(
				  "name"=>$where
		   )
		  
		);*/
		$this->database = self::getDb();
		$table_name = $module;
		$data = $this->database->select($table_name, "*",$con);
		return $data;
	}

	function sys_report_update($table,$sql_data,$where=array())
	{
		$this->database = self::getDb();
		if (isset($where)) {
			$where_name["name"]=$where;
			$con['AND'] = $where_name;
		} else {
			$con = [];
		}
		$table_name = $table;
		$data = $this->database->update($table_name, $sql_data,$con);
		//var_dump($data)
		//return $data;
	}

	function sys_report_insert($table,$sql_data)
	{
		$this->database = self::getDb();
		$table_name = $table;
		//$report_name = $sql_data['name'];
		$where_name["name"]=$sql_data['name'];
		$con['AND'] = $where_name;
		$name_data = $this->database->select($table_name, "name",$con);
		if(!empty($name_data)){
			return false;
		}
		else{
			$data = $this->database->insert($table_name, $sql_data);
			return true;
		}		
	}

	function sys_report_delete($table,$where_arr=array())
	{
		$this->database = self::getDb();
		$table_name = $table;

	/*		$where_name["name"]=$where_arr;
			$con['AND'] = $where_name;
			$name_data = $database->delete($table_name, $con);

		var_dump($name_data);
			exit(0);*/
		foreach($where_arr as $key=>$value){

			$where_name["name"]=$value;
			$con['AND'] = $where_name;
			$name_data = $this->database->delete($table_name, $con);
		}
		return;
	}
	function sys_report_log_query($module, $start, $end,$where=array())
	{
		$this->database = self::getDb();
		$s = $start." 00:00:00";
		$e = $end." 23:59:59";
		//$aaa = ["'time'[>=]"=>"2017-10-16 00:00:00"];
		if (isset($where)) {
			$con = ["ORDER" => "id DESC"];	
			$con['AND'] = array_merge($where, ["time[<>]" => [$s, $e]]);
		} else {
			$con = [];
		}

		$table_name = $module;
		$data = $this->database->count($table_name, "*",$con);
		return $data;
	}
	function org_select($module,$col, $where=array())
	{

		$this->database = self::getDb();
		$data = $this->database->select($module, $col, $where);
		return $data;
	}
	function org_query($sql)
	{

		$this->database = self::getDb();
		$data = $this->database-> query($sql) -> fetch();
		return $data;
	}
}

?>
