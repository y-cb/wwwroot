<?php
namespace lib;

Class ReportModel {
    public static $config_file = '/mnt/boot/report.json';

    function system_report_insert($report) {
        $report_arr = array();

        if (system_report_query($report['name'])) {
            return false;
        }
        if (file_exists(self::$config_file)) {
            $str = file_get_contents(self::$config_file);
            $report_arr = json_decode($str);
        }
        $report_arr[] = $report;

        $json = json_encode($report_arr);
        file_put_contents(self::$config_file, $json);
        return true;
    }

    function system_report_get() {
        $report_arr = array();
        if (file_exists(self::$config_file)) {
            $str = file_get_contents(self::$config_file);
            $report_arr = json_decode($str);
        }
        return $report_arr;
    }

    function system_report_query($name) {
        $report_arr = array();
        $report_query_time = array();
        
        if (file_exists(self::$config_file)) {
            $str = file_get_contents(self::$config_file);
            $report_arr = json_decode($str, true);
        }
         foreach($report_arr as $item) {
            if ($item['name'] == $name) {
                return $item;
            }
        } 
        /*if($query_time==""){
            foreach($report_arr as $item) {
                if ($item['name'] == $name) {
                    return $item;
                }
            }
        }else{      
            foreach($report_arr as $item){
                if ($item['days'] == $query_time) {
                    array_push($report_query_time, $item);            
                }
            }
            return $report_query_time;
        }*/
        return null;
    }

    function system_report_update($name, $report) {
        $report_arr = array();

        if (file_exists(self::$config_file)) {
            $str = file_get_contents(self::$config_file);
            $report_arr = json_decode($str);
        }
        foreach($report_arr as $key => $item) {
            if ($item->name == $name) {
                $report['name'] = $name;
                $report_arr[$key] = $report;
                $json = json_encode($report_arr);
                file_put_contents(self::$config_file, $json);
                return true;
            }
        }
        return false;
    }

    function system_report_delete($name_arr) {
        $report_arr = array();
        $report_new_arr = array();
        
        if (file_exists(self::$config_file)) {
            $str = file_get_contents(self::$config_file);
            $report_arr = json_decode($str);
        }
        foreach($report_arr as $key => $item) {
            if (!in_array($item->name, $name_arr)) {
                array_push($report_new_arr,$item);            
            }
        }
        $json = json_encode($report_new_arr);
        file_put_contents(self::$config_file, $json);
        /*foreach($report_arr as $key => $item) {
            if (in_array($item->name, $name_arr)) {
                array_splice($report_arr, $key, 1);
                $json = json_encode($report_arr);
                file_put_contents($config_file, $json);
            }
        }*/
        return false;
    }

    function system_report_generate_time() {
        $Nowdate = date('Y-m-d',time());
        $timeBegin1 = strtotime($Nowdate . "00:00:00");  
        $timeEnd1 = strtotime($Nowdate . "06:00:00");  
        $curr_time = time();
        if ($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1) {  
            $generate_time = date("Y-m-d",strtotime("-1 day"))." 23:59:59";
        }else{
            $generate_time = date("Y-m-d H:i:s",$curr_time);
        }
        return $generate_time;
    }
}

?>
