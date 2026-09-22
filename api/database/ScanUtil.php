<?php
namespace database;
use PDO;

Class ScanUtil extends PDO
{
	public function __construct()
	{

		$file = '/tmp/locallog/event_log.db';
		
		
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

	
	//直接运行SQL，可用于更新、删除数据 by：copy
	function query($sql) 
	{
		return $this->connection->query($sql);
	}


	/**
	 *  是否存在某个表
	 */
	function isExitTable($table){
		$sql = 'SELECT COUNT(*) AS counts FROM sqlite_master WHERE type=\'table\' AND name =\''.$table.'\'';
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$counts = $stmt->fetch()['counts'];
		return $counts != 0?true:false;
	}

	//提交扫描信息到数据库 
	public function postInfo($table, $infor, $result) {  
	
		$sql = 'INSERT INTO '.$table.'( infor, result) VALUES (?,?)';

		$stmt = $this->connection->prepare($sql);

		$stmt->bindValue(1, $infor, PDO::PARAM_STR);
		$stmt->bindValue(2, $result, PDO::PARAM_STR);

		$stmt->execute();
		
	}

	//清空数据库

	public function deleInfo($table,$id){
		$sql = 'DELETE FROM '.$table.' where ID ='.$id;
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
	}

	
	//获取数据库信息
	public function getInfo($table){
		if(!$this->isExitTable($table))
			return Array();
		$sql = 'SELECT * FROM '.$table.' ORDER BY id DESC';
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll();
	}

	//获取单条信息
	public function getInfoOne($table,$id){
		$sql = 'SELECT * FROM '.$table.' where ID ='.$id;
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetch();
	}



	//获取最后一条信息
	public function getLastOne($table){
		$sql = 'SELECT * FROM '.$table.' ORDER BY id DESC LIMIT 1';
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetch();
	}

	public function getInfoCount($table){
		$sql = 'SELECT count(*) AS counts FROM '.$table;
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetch()['counts'];
	}
	
	//获取数据库信息
	public function getInfoList($table, $page_num, $page_count){
		if(!$this->isExitTable($table)){
			return Array();//坑爹的逻辑！
		}
		$page_num = $page_num == 0?1:$page_num;
		$this->page_count = $page_count;
		$this->page_num = $page_num;
		$page_num = (int)$page_num;
		$page_count = (int)$page_count;
		$start = (($page_num - 1) * $page_count);
		$start = $start < 0 ? 0 : $start;
		
		$sql = 'SELECT * FROM '.$table.' ORDER BY id DESC LIMIT :page_count OFFSET :start';
		echo '<br />'.$sql.'<br />';
		$stmt = $this->connection->prepare($sql);
		
		$stmt->bindParam(':page_count', $page_count);
		$stmt->bindParam(':start', $start);
		$stmt->execute();
        return $stmt->fetchAll();

	}
	
	/* 
     * 根据条件查询
     * @param $tableName 表名称
     * @param $col_a 查询条件，带字段名称
     * @param $page_num 页码
     * @param $page_count 每页记录条数
     * @return $记录详情
     */ 
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
		$sql_daemon = '';
		$sql_time = '';
		$sql_srcip = '';
		$sql_dstip = '';
		if(isset($col_a)) {
			foreach($col_a as $key=>$value){
				if('daemon' == $key){
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
				}
			}
		}
        $sql = 'SELECT * FROM '.$table.' WHERE 1 = 1 '.$sql_daemon.$sql_time.$sql_tmp.$sql_srcip.$sql_dstip.' ORDER BY id DESC LIMIT :page_count OFFSET :start';
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
	

	/* 
     * 插入系统事件日志，例如生成报表日志。type=SYSTEM_INFO,daemon=20,level=4。
     * @param $daemon,$type 事件类型
	 * @param $time 时间
	 * @param $level 级别
	 * @param $src_ip 源IP
	 * @param $msg 消息详情
	 * @param $table 数据库名
     * @return void
     */
    public function addEventLog($daemon, $time, $type, $level, $src_ip, $msg, $table='CONFIG_LOG') {
		// $sql = 'INSERT INTO EVENT_LOG(daemon, time, type, level, src_ip, msg) VALUES (?,?,?,?,?,?)';
		$sql = 'INSERT INTO '.$table.'(daemon, time, type, level, src_ip, msg) VALUES (?,?,?,?,?,?)';
		
		$stmt = $this->connection->prepare($sql);

		// $msg = mb_convert_encoding($msg,'GBK','UTF-8');
		// $msg = mb_convert_encoding($msg,'UTF-8');
		$stmt->bindValue(1, $daemon, PDO::PARAM_INT);
        $stmt->bindValue(2, $time, PDO::PARAM_STR);
        $stmt->bindValue(3, $type, PDO::PARAM_STR);
        $stmt->bindValue(4, $level, PDO::PARAM_INT);
        $stmt->bindValue(5, $src_ip, PDO::PARAM_STR);
        $stmt->bindValue(6, $msg, PDO::PARAM_STR);

		$stmt->execute();
    }

	/* 
     * 根据ID获取某条记录
     * @param $id id
     * @return 某个记录
     */ 
	public function queryById($id) {  
		$sql = "SELECT * FROM event_log WHERE ID = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->bindParam(1, $id);
		$stmt->execute();
		return $stmt->fetch();
	} 
	
	
	
	# end method
}
?>
