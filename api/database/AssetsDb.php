<?php
namespace database;
use database\Medoo;
use PDO;
class AssetsDb extends PDO{
	public $database;
	/*function getDb(){
		return new Medoo([
			// 必填
			'database_type' => 'sqlite',
			'database_name' => 'assets',
			'database_file' => '/tmp/assets.db',
		 
			// 连接参数可参考官方手册： http://www.php.net/manual/en/pdo.setattribute.php
			'option' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL
			]
		]);
	}*/

	function __construct()
	{
		$file = '/tmp/assets.db';
		
		try
		{
			$this->connection = new PDO('sqlite:'.$file);
		}
		catch(PDOException $e)
		{
			try
			{
				$this->connection = new PDO('sqlite2:'.$file);
			}
			catch(PDOException $e)
			{
				exit('<label style="font-size:12px;">'.LocalUtil::getCommonResource('log.error_nopath').'</label>');
			}
		}
	}
	
	function __destruct()
	{
		$this->connection=null;
	}

	function query($sql) //直接运行SQL，可用于更新、删除数据
	{
		return $this->connection->query($sql);
	}

	function get_list($counts_all,$table,$col_a){
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
		if($counts_all <= 50000){

			$items = self::queryForList($table, $col_a, $n,10000);

			$out_list = self::printFile($items);

	    }else if($counts_all >= 50000){
	  		
			$items = self::queryForList($table, $col_a, $n,10000);

			$out_list = self::printFile($items);
		}

		return $out_list;
	}

	function printFile($items){
		
		$cnt = 1;
		$list_arr = [];
		if($items){
			foreach($items as $k => $item) { 
				//var_dump($item);
				$cnt ++;
				if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
					ob_flush();
					flush();
					$cnt = 0;
				}
				$importance = t('assets.importance'.$item['importance']);
				$source = t('assets.source'.$item['source']);
				$state = t('assets.state'.$item['state']);

				$row = array("assets_ip"=>$item["ip"],"assets_desc"=>$item["desc"],"assets_name"=>$item["name"],"assets_part"=>$item["part"],"assets_importance"=>$importance,"assets_os"=>$item["os"],"assets_service"=>$item["service"],"assets_source"=>$source,"assets_state"=>$state);


				$list_arr[]=$row;
				
				unset($row);
			}
		}else{
			$list_arr[] = array("assets_ip"=>'',"assets_desc"=>'',"assets_name"=>'',"assets_part"=>'',"assets_importance"=>'',"assets_os"=>'',"assets_service"=>'',"assets_source"=>'',"assets_state"=>'');
		}
		
		return $list_arr;
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

	function isExitTable($table){
		
		$sql = 'SELECT COUNT(*) AS counts FROM sqlite_master WHERE type=\'table\' AND name =\''.$table.'\'';
		$stmt = $this->connection->prepare($sql);

		$stmt->execute();
		$counts = $stmt->fetch()['counts'];
		return $counts != 0?true:false;
	}

	function assets_insert($table,$sql_data)
	{
		if(!$this->isExitTable($table))
			return Array();//坑爹的逻辑！
		if(isset($sql_data)) {
			//$value_str = implode(',',$sql_data);
			//$sql = 'INSERT INTO '.$table.' (ip,desc,name,part,importance,os,service,source,state) VALUES ('.$value_str.')';
			$sql = 'INSERT INTO '.$table.' (ip,desc,name,part,importance,os,service,source,state,address_type) VALUES ('."'".$sql_data[0]."','".$sql_data[1]."','".$sql_data[2]."','".$sql_data[3]."','".$sql_data[4]."','".$sql_data[5]."','".$sql_data[6]."','".$sql_data[7]."','".$sql_data[8]."','".$sql_data[9]."'".')';	
			$this->connection->query($sql);
			//self::query($sql)
			/*$stmt = $this->connection->prepare($sql);
			var_dump(44444);exit(0);
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);*/
		}	
	}

	function assets_update($table,$sql_data)
	{
		if(!$this->isExitTable($table))
			return Array();//坑爹的逻辑！
		if(isset($sql_data)) {
//			$sql = 'UPDATE '.$table.' SET ip="'.$sql_data[0].'",desc="'.$sql_data[1].'",name="'.$sql_data[2].'",part="'.$sql_data[3].'",importance="'.$sql_data[4].'",os="'.$sql_data[5].'",service="'.$sql_data[6].'",source="'.$sql_data[7].'",state="'.$sql_data[8].'" WHERE ip="'.$sql_data[0].'"';
			$sql = 'UPDATE '.$table.' SET ip="'.$sql_data[0].'",desc="'.$sql_data[1].'",name="'.$sql_data[2].'",part="'.$sql_data[3].'",importance="'.$sql_data[4].'",os="'.$sql_data[5].'",source="'.$sql_data[7].'",state="'.$sql_data[8].'" WHERE ip="'.$sql_data[0].'"';
			$this->connection->query($sql);
		}	
	}

	public function queryForList($table, $col_a, $page_num, $page_count) {
		
		if(!$this->isExitTable($table))
			return Array();//坑爹的逻辑！
		$page_num = $page_num == 0?1:$page_num;
		$this->page_count = $page_count;
		$this->page_num = $page_num;
		$page_num = (int)$page_num;
		$page_count = (int)$page_count;
		$start = (($page_num - 1) * $page_count);
		$start = $start < 0 ? 0 : $start;
		$sql_tmp = '';
		/*$sql_daemon = '';
		$sql_time = '';
		$sql_srcip = '';
		$sql_dstip = '';*/

		if(isset($col_a)) {
			foreach($col_a as $key=>$value){
				if($key=='service'){
					$sql_tmp .= " AND ".$key." like '%".$value."%'";
					unset($col_a["$key"]);
				}else{
					$sql_tmp .= ' AND '.$key.' = ? ';
				}
				/*if('daemon' == $key){
					$sql_daemon = ' AND '.$key.' IN ('.$value.') ';
					unset($col_a["$key"]);
				} else if('time' == $key) {
					$sql_time = ' AND '.$key.' BETWEEN '.$value.' ';
					unset($col_a["$key"]);
					//$sql_tmp .= ' AND '.$key.' BETWEEN ? ';
				} else if('srcip' == $key) {
					$sql_srcip = ' AND src_ip BETWEEN '.$value.' ';
					unset($col_a["$key"]);
				} else if('dstip' == $key) {
					$sql_dstip = ' AND dst_ip BETWEEN '.$value.' ';
					unset($col_a["$key"]);
				} else {
					$sql_tmp .= ' AND '.$key.' = ? ';
				}*/
			}
		}
        $sql = 'SELECT * FROM '.$table.' WHERE 1 = 1 '.$sql_tmp.' ORDER BY id DESC LIMIT :page_count OFFSET :start';
        //var_dump($sql);exit(0);
		// echo '<br />'.$sql.'<br />';
		
		$stmt = $this->connection->prepare($sql);
		if(isset($col_a)) {
			$i = 1;
			foreach($col_a as $key=>$value){
				//echo $value.'<br />';
				$stmt->bindValue($i, $value);
				$i++;
			}
		}
		$stmt->bindParam(':page_count', $page_count);
		$stmt->bindParam(':start', $start);
		$stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } # end method


	public function getCount($table, $col_a) {
		if(!$this->isExitTable($table)){
			$counts = 0;
			$this->counts = $counts;
			$this->pages = (int)($counts / $this->page_count) + 1;
			return $counts;
		}
		$sql_tmp = '';
		/*$sql_daemon = '';
		$sql_time = '';
		$sql_srcip = '';
		$sql_dstip = '';*/
		if(isset($col_a)) {
			foreach($col_a as $key=>$value){
				if($key=='service'){
					$sql_tmp .= " AND ".$key." like '%".$value."%'";
					unset($col_a["$key"]);
				}else{
					$sql_tmp .= ' AND '.$key.' = ? ';
				}
				//$sql_tmp .= ' AND '.$key.' = ? ';
				/*if('daemon' == $key){
					$sql_daemon = ' AND '.$key.' IN ('.$value.') ';
					unset($col_a["$key"]);
				} else if('time' == $key) {
					$sql_time = ' AND '.$key.' BETWEEN '.$value.' ';
					unset($col_a["$key"]);
				} else if('srcip' == $key) {
					$sql_srcip = ' AND src_ip BETWEEN '.$value.' ';
					unset($col_a["$key"]);
				} else if('dstip' == $key) {
					$sql_dstip = ' AND dst_ip BETWEEN '.$value.' ';
					unset($col_a["$key"]);
				} else {
					$sql_tmp .= ' AND '.$key.' = ? ';
				}*/
			}
		}
        $sql = 'SELECT COUNT(id) AS counts FROM '.$table.' WHERE 1 = 1 '.$sql_daemon.$sql_time.$sql_tmp.$sql_srcip.$sql_dstip;
		//echo $sql.'<br />';
		$stmt = $this->connection->prepare($sql);
		if(isset($col_a)) {
			$i = 1;
			foreach($col_a as $key=>$value){
				$stmt->bindValue($i, $value);
				$i++;
			}
		}
		$stmt->execute();
		$counts = $stmt->fetch()['counts'];
		$this->counts = $counts;
		if($counts == 0) {
			$this->pages = 1;
		} else {
			if($this->page_count){
				$this->pages = (int)($counts / $this->page_count) + 1;
				if($counts % $this->page_count == 0) {
					$this->pages = $this->pages -1;
				}
			}
		}
        return $counts;
    } # end method
	
	//找到一个最小的可删除的流量发现且没经过修改的资产
	public function getRow($table){
		if(!$this->isExitTable($table))
			return Array();//坑爹的逻辑！
		$sql ='SELECT min(id) AS id,ip,time from '.$table.' where flag=0 AND source=0';
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	//根据id 删除对应的数据
	public function delRow($table,$id) {
		if(!$this->isExitTable($table))
			return Array();//坑爹的逻辑！
		
		$sql ='DELETE from '.$table.' where id ='.$id;
		
		return $this->query($sql);
	}
	
	//删除对应资产的服务table
	public function dropTable($table) {
		$sql = 'DROP TABLE '.$table;
		
		return $this->query($sql);
	}
	
}

?>
