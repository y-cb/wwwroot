<?php
class pgsql {
    private $linkid; // PostgreSQL连接标识符
    private $host; // PostgreSQL服务器主机
    private $port; // PostgreSQL服务器主机端口
    private $user; // PostgreSQL用户
    private $passwd; // PostgreSQL密码
    private $db; // Postgresql数据库
    private $result; // 查询的结果
    private $querycount; // 已执行的查询总数
	private $tb_name; //进行操作数据表
    /* 类构造函数，用来初始化$host、$user、$passwd和$db字段。 */
    function __construct($tb_name,$host = '127.0.0.1', $port = '5432', $db = 't_log', $user = 'postgres', $passwd = '') {
        $this->tb_name = $tb_name;
		$this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->passwd = $passwd;
        $this->db = $db;
    }
    /* 连接Postgresql数据库 */
    function connect() {
        try {
            $this->linkid = @pg_connect("host=$this->host port=$this->port dbname=$this->db user=$this->user password=$this->passwd");
            if (!$this->linkid) throw new Exception("Could not connect to PostgreSQL server.");
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
    }
    /* 执行数据库查询。 */
    function query($query) {
		 $this->result = @pg_query($this->linkid, $query);
        /*try {
            $this->result = @pg_query($this->linkid, $query);
            if (!$this->result) throw new Exception("The database query failed.");
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }*/
        $this->querycount++;
        return $this->result;
    }
    /* 确定受查询所影响的行的总计。 */
    function affectedRows() {
        $count = @pg_affected_rows($this->linkid);
        return $count;
    }
    /* 确定查询返回的行的总计。 */
    function numRows() {
        $count = @pg_num_rows($this->result);
        return $count;
    }
    /* 将查询的结果行作为一个对象返回。 */
    function fetchObject() {
        $row = @pg_fetch_object($this->result);
        return $row;
    }
    /* 将查询的结果行作为一个索引数组返回。 */
    function fetchRow() {
        $row = @pg_fetch_row($this->result);
        return $row;
    }
    /* 将查询的结果行作为一个关联数组返回。 */
    function fetchArray() {
        $row = @pg_fetch_array($this->result);
        return $row;
    }
    /* 返回在这个对象的生存期内执行的查询总数。这不是必须的，但是您也许会感兴趣。 */
    function numQueries() {
        return $this->querycount;
    }
	/* 返回的指定表总查询数 */
	function get_PG_data_result($where = '',$pageSize = 20,$offset = 0,$order_cloumn = 'id',$sort_status = 'desc'){
		$sql = 'select * from '.$this->tb_name.' '.$where.' order by '.$order_cloumn.' '.$sort_status.' limit '.$pageSize.' offset '.$offset.';';
        $this->result = $this->query($sql);
		$retdata = array();
		while ($line = $this->fetchArray()) {
			$row = (int)$i++;
			$retdata[group][$row] = $line;
		}
		return $retdata;
	}
	/* 返回的指定表总记录数 */
	function get_PG_data_count($where = '',$max_flag = '0',$count_cloumn = 'id'){
		if($max_flag == '1' && $where == 'where id > 0 ')
			$sql = 'SELECT max('.$count_cloumn.') as num FROM '.$this->tb_name.' '.$where.'';
		else
			$sql = 'SELECT count('.$count_cloumn.') as num FROM '.$this->tb_name.' '.$where.'';
		$this->result = $this->query($sql);
		$row = $this->fetchArray();
		return (int)$row[0];
	}
	/* 返回特定日期总记录数,通过MAX(id)得到近似值 */
	function get_PG_about_total_count($count_cloumn = 'id'){
		$sql = 'SELECT max('.$count_cloumn.') as num FROM '.$this->tb_name;
		$this->result = $this->query($sql);
		$row = $this->fetchArray();
		return (int)$row[0];
	}
	function __destruct()  
    {  
		@pg_close($this->linkid);
    }
}
?>