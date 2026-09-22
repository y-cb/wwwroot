<?php
namespace controller\Statistics;
use controller\Controller;
use database\MysqlDb;


class DstAppAuditController extends Controller {
    function get(){
        $param = get_inputs();
        $database = new MysqlDb();
        if ($param['time'] == 2) {
            $table_sql = monitor_auditlog_table($database, $param['type']);
            $find_sql = auditlog_field_sql($param);

            $data = $database->sql_query("select dstip as name,count(ID) as cnt from (".$table_sql.") as a ".$find_sql." group by name order by cnt desc limit 10")->fetchAll();        
        } else {
            $cur = time();
            $day = strftime("%Y%m%d", $cur);

            $table_name = $param['type'].'_'. $day;
            unset($param['type'], $param['lang']);
            if (!empty($param)) {
                $param = array_merge($param, ["LIMIT" => 10,  "GROUP" => "dstip", "ORDER" => "cnt DESC"]);
            } else {
                $param = ["LIMIT" => 10,  "GROUP" => "dstip", "ORDER" => "cnt DESC"];
            }
            $data = $database->org_select($table_name, [ 'dstip(name)', '[COUNT](cnt)'], $param);

        }

        echo json_encode($data);
        unset($data);
        return;
    }
}