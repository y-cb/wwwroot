<?php
namespace controller\Statistics;
use controller\Controller;
use database\MysqlDb;


class SrcAppAuditController extends Controller {
	function get(){
        $param = get_inputs();
        $database = new MysqlDb();
    	if ($param['time'] == 2) {
    		$table_sql = monitor_auditlog_table($database, $param['type']);
    		$find_sql = auditlog_field_sql($param);

    		$data = $database->sql_query("select srcip as name,count(ID) as cnt from (".$table_sql.") as a ".$find_sql." group by srcip order by cnt desc limit 10")->fetchAll();
    	} else {
    		$cur = time();
    		$day = strftime("%Y%m%d", $cur);

    		$table_name = $param['type'].'_'. $day;
            unset($param['type'], $param['lang']);
    		if (!empty($param)) {
    			$where = array_merge($param, ["LIMIT" => 10,  "GROUP" => "srcip", "ORDER" => "cnt DESC"]);
    		} else {
    			$where = ["LIMIT" => 10,  "GROUP" => "srcip", "ORDER" => "cnt DESC"];
    		}
    		$data = $database->org_select($table_name, [ 'srcip(name)', '[COUNT](cnt)'], $where);

    	}

    	echo json_encode($data);
    	unset($data);
    	return;
	}
}