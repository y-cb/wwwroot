<?php
namespace database;
use SQLite3;

class MySQLite3Db extends SQLite3
{	
	private $row = null;
	private $db_file = '/tmp/local_tmp.db';
    private $db_tmp  = '/tmp/sqlite3_tmp.db';
	function __construct($file = '/tmp/local_tmp.db', $file_tmp = '/tmp/sqlite3_tmp.db')
    {
		$this->db_file = $file;
		$this->db_tmp = $file_tmp;

	//if (!file_exists($this->db_tmp))
			copy($this->db_file, $this->db_tmp);
        $this->open($this->db_tmp);
    }
	function get_SQLite3_data_result($table_name,$where=array(),$pageSize,$offset,$order_cloumn = 'id',$sort_status = 'desc',$start='',$end=''){
        $sqlWhere = '';

        if (!empty($start) && !empty($end)) {
            $sqlWhere .= ' where time between '.$start.' and '.$end;
        }
        if (isset($where)) {
            foreach ($where as $key => $val) {
                if ($key == 'srcip') {
                    $key = 'srcIp';
                }
                if ($key == 'dstip') {
                    $key = 'dstIp';
                }
               $sqlWhere .= ' and '.$key.'='."'$val'";
            }
        }
        $sql = 'select `ID`,`time`,`filename` as name,`filelen`,`filetype`,`malware`,`md5`,`App`,`srcIp`,`dstIp`,`Proto`,`result` from '.$table_name.' '.$sqlWhere.' order by '.$order_cloumn.' '.$sort_status.' limit '.$pageSize.' offset '.$offset.';';
        $result = $this->query($sql);
		$retdata = array();
		while ($line = $result->fetchArray()) {
			$row = (int)$i++;
			$retdata[group][$row] = $line;
		}
		return $retdata;
	}
	function get_SQLite3_data_count($table_name,$where=array(),$count_cloumn = '1',$start='',$end=''){
        $sqlWhere = '';
        if (!empty($start) && !empty($end)) {
            $sqlWhere .= ' where time between '.$start.' and '.$end;
        }
        if (isset($where)) {
            foreach ($where as $key => $val) {
                if ($key == 'srcip') {
                    $key = 'srcIp';
                }
                if ($key == 'dstip') {
                    $key = 'dstIp';
                }
                $sqlWhere .= ' and '.$key.'='."'$val'";
            }
        }
		$sql = 'SELECT count('.$count_cloumn.') FROM '.$table_name.' '.$sqlWhere.'';
		$totalNum = $this->querySingle($sql);
		$totalNum = (int)$totalNum;
		return $totalNum;
	}
	function __destruct()  
    {  
		$this->close();
		if (file_exists($this->db_tmp))
			system('rm -rf '.$this->db_tmp);
    }
}

?>