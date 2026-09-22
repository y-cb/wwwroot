<?php
namespace lib;
use database\DbUtil;
use database\MysqlDb;

Class WriteLog {
    function ConfigWrite ($msg, $level = 5) {
        $currentDate =  date('Ymd',time());
        if ($_SESSION[PERMISSION]['separation_of_powers'] == 1 && $_SESSION[CONNECTION.USERNAME] == 'audit') {
            if(file_exists('/mnt1/mysql/')) {
                $db = new MysqlDb();
                $table_name = 'audit_log_'.$currentDate;
                $sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'20'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".$level."','".' '."','".$msg."'".')';
                $db->sql_query($sql);
            }else{
                $db = new DBUtil();
                $table = 'AUDIT_LOG';
                $db->addAuditLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',$level,'',$msg,$table);
            }
        } else {
            if(file_exists('/mnt1/mysql/')) {
                $db = new MysqlDb();
                $table_name = 'config_log_'.$currentDate;
                $sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'20'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".$level."','".' '."','".$msg."'".')';
                $db->sql_query($sql);
            }else{
                $db = new DBUtil();
                $table = 'CONFIG_LOG';
                $db->addEventLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',$level,'',$msg,$table);
            }

        }
    }
}
