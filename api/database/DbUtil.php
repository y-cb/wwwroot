<?php
namespace database;
use PDO;

class DbUtil extends PDO
{
	function __construct()
	{
		//$file = '/mnt1/event_log.db';
		$file = '/tmp/locallog/event_log.db';
		//$file = '../../event_log.db';//wwwroot/event_log.db
		//$file = '../../t1.db';
		
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

	function query($sql) //直接运行SQL，可用于更新、删除数据
	{
		return $this->connection->query($sql);
	}

	function getlist($sql) //取得记录列表
	{
		$recordlist=array();
		foreach($this->query($sql) as $rstmp)
		{
			$recordlist[]=$rstmp;
		}
		return $recordlist;
	}

	function Execute($sql)
	{
		return $this->query($sql)->fetch();
	}

	function RecordArray($sql)
	{
		return $this->query($sql)->fetchAll();
	}

	function RecordCount($sql)
	{
		return count($this->RecordArray($sql));
	}

	function RecordLastID()
	{
		return $this->connection->lastInsertId();
	}

	/* 
     * 删除数据
     * @param $ids 需要删除的日志ID
     * @param $isAll 是否清空日志 1-YES 0-NO
     * @return 某个记录
     */
	public function deleteLogs($isAll, $ids, $table){
		if(!$this->isExitTable($table))
			return;
		$sql = 'DELETE FROM '.$table;
		$con = '';
		if($isAll == 0){
			$con = ' WHERE ID IN('.$ids.')';
		}
		$sql .= $con;
		$stmt = $this->connection->prepare($sql);
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
    } # end method

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
     * 根据条件查询
     * @param $tableName 表名称
     * @param $col_a 查询条件，带字段名称
     * @return $记录详情
     */ 
	public function queryForListAll($table, $col_a) {
		if(!$this->isExitTable($table))
			return Array();//坑爹的逻辑！
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
		
		 $maxtop = $this->getCount($table, $col_a);
	if($maxtop>10000)
		$sql = 'SELECT * FROM '.$table.' WHERE 1 = 1 '.$sql_daemon.$sql_time.$sql_tmp.$sql_srcip.$sql_dstip.' ORDER BY id DESC limit 10000';
	else
		$sql = 'SELECT * FROM '.$table.' WHERE 1 = 1 '.$sql_daemon.$sql_time.$sql_tmp.$sql_srcip.$sql_dstip.' ORDER BY id DESC';
		
		$stmt = $this->connection->prepare($sql);
		if(isset($col_a)) {
			$i = 1;
			foreach($col_a as $key=>$value){
				//echo $value.'<br />';
				$stmt->bindValue($i, $value);
				$i++;
			}
		}
		$stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	/* 
     * 根据条件查询记录条目数
     * @param $tableName 表名称
     * @param $col_a 查询条件，带字段名称
     * @return 根据条件查询记录总数
     */ 
	public function getCount($table, $col_a) {
		if(!$this->isExitTable($table)){
			$counts = 0;
			$this->counts = $counts;
			$this->pages = (int)($counts / $this->page_count) + 1;
			return $counts;
		}
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

	/* 
     * 打印上一页下一页等工具条
     * @param $isbottom 是否是底部的工具条
     * @return void
     */ 
	public function printPage($isbottom) {
		
		if($isbottom) {
			$tmp = sprintf(LocalUtil::getCommonResource('log.counts'), $this->counts);
		} else {
			$list_count = $this->counts;
			if($list_count >0){
				//数据大于零是可以导出
				//$tmp .= '<a href="#" id="a_exportDivShow" onClick="showEcportDiv(event); return false;">'.LocalUtil::getCommonResource('log.page.exportLog').'</a>&nbsp;&nbsp;&nbsp;';
				$tmp .= '<input type="button" id="a_exportDivShow" onClick="showEcportDiv(event);" value="'.LocalUtil::getCommonResource('log.page.exportLog').'" />&nbsp;&nbsp;&nbsp;';
				
			}else{
				//$tmp .= '<a style="color:#666;text-decoration:none;">'.LocalUtil::getCommonResource('log.page.exportLog').'</a>&nbsp;&nbsp;&nbsp;';
				$tmp .= '<input type="button" disabled="disabled" value="'.LocalUtil::getCommonResource('log.page.exportLog').'" />&nbsp;&nbsp;&nbsp;';
			}
			
			$tmp .= '<img src="'.LocalUtil::getCommonResource('img.mini_button_help').'" align="absmiddle" class="mini_help" title="'.LocalUtil::getCommonResource('tOne.help').'" onClick="javascript:openHelpWindow(\'module=logs&tip=logs_monitor_lis\')">&nbsp;';
			$tmp .= sprintf(LocalUtil::getCommonResource('log.counts'), $this->counts);
		}
		$pre = $this->page_num == 1 ? '<label title="'.LocalUtil::getCommonResource('log.first').'">&lt;&lt;</label>&nbsp;<label title="'.LocalUtil::getCommonResource('log.pre').'">&lt;</label>&nbsp;' : '<a href="javascript:firstPage();" title="'.LocalUtil::getCommonResource('log.first').'">&lt;&lt;</a>&nbsp;<a href="javascript:prePage();" title="'.LocalUtil::getCommonResource('log.pre').'">&lt;</a>&nbsp;';
		$tmp .= $pre;
		if($this->pages <= 5){
			//if($this->page_num = 1){
			//	$tmp = '&lt;&lt;&nbsp;&lt;';
			//}
			for($i = 1;$i<=$this->pages;$i++){
				if($this->page_num == $i) {
					$tmp .= '<b>'.$i.'</b>&nbsp;';
				} else {
					$tmp .= '<a href="javascript:toPage('.$i.')">'.$i.'</a>&nbsp;';
				}
			}
		} else {
			if($this->page_num <= 3){
				for($i = 1;$i<=5;$i++){
					if($this->page_num == $i) {
						$tmp .= '<b>'.$i.'</b>&nbsp;';
					} else {
						$tmp .= '<a href="javascript:toPage('.$i.')">'.$i.'</a>&nbsp;';
					}
				}
			} else {
				$end = ($this->page_num + 2) > $this->pages ? $this->pages : ($this->page_num + 2);
				$start = $end - 4;
				for($i = $start;$i <= $end; $i++){
					if($this->page_num == $i) {
					$tmp .= '<b>'.$i.'</b>&nbsp;';
					} else {
						$tmp .= '<a href="javascript:toPage('.$i.')">'.$i.'</a>&nbsp;';
					}
				}
			}
		}
		$next = $this->page_num == $this->pages ? '<label title="'.LocalUtil::getCommonResource('log.next').'">&gt;</label>&nbsp;<label title="'.LocalUtil::getCommonResource('log.last').'">&gt;&gt;</label>&nbsp;':'<a href="javascript:nextPage();" title="'.LocalUtil::getCommonResource('log.next').'">&gt;</a>&nbsp;<a href="javascript:lastPage();" title="'.LocalUtil::getCommonResource('log.last').'">&gt;&gt;</a>&nbsp;';
		if($isbottom)
			$tmp .= $next.'<input id="to_b" onKeyPress="convertCR2Tab_b(event)" type="text" style="width:30px"/>/'.$this->pages.'&nbsp;<input type="button" onclick="javascript:toPage_b()" style="font-size:12px;" value="'.LocalUtil::getCommonResource('log.to').'">';
        else
			$tmp .= $next.'<input id="to" onKeyPress="convertCR2Tab(event)" type="text" style="width:30px"/>/<label style="font-size:12px;" id="pages">'.$this->pages.'</label>&nbsp;<input type="button" onclick="javascript:toPage()" style="fong-size:12px;" value="'.LocalUtil::getCommonResource('log.to').'"/>';
		echo $tmp;
    } # end method

	/* 
     * 获取最新10条高级别日志
     * @param $tables 表名称，支持多个表
     * @return 10条高级别日志
     */ 
    public function queryHighLevelLog($tables) {
		$sql = '';
		$i = 0;
		foreach($tables as $table){
			if($this->isExitTable($table)){
				if($i == 0){
					$sql = 'SELECT * FROM(SELECT * FROM '.$table.' WHERE level <= 4 ORDER BY time DESC LIMIT 10 OFFSET 0)';
				} else {
					$sql .= ' UNION ALL SELECT * FROM(SELECT * FROM '.$table.' WHERE level <= 4 ORDER BY time DESC LIMIT 10 OFFSET 0)';
				}
				$i++;
			}
		}
		if(strlen($sql) < 1){
			return array();
		}
		$sql = 'SELECT * FROM ('.$sql.') ORDER BY time DESC LIMIT 10 OFFSET 0';
		//echo $sql;
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
        return $stmt->fetchAll();
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
    public function addAuditLog($daemon, $time, $type, $level, $src_ip, $msg, $table='AUDIT_LOG') {
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
    } # end 

}
?>
