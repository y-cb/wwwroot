<?php
namespace controller\system;
use database\DbUtil;
use database\MysqlDb;
use lib\AutoReport;
use lib\AppReport;
use lib\WriteLog;


Class ExportReportController {
    public $path = '/mnt/boot/ftp.json';
    public $report_file = '/mnt/boot/report_file.json';
    function post() {
        //test
        /*		$report_map = array();
                $report_map['name'] = formatpost($_POST['name']);
                // $report_map['title'] = 'title';
                $report_map['description'] = formatpost($_POST['description']);
                $report_map['title'] = formatpost($_POST['title']);
                // $report_map['description'] = '君が好きだから、でもあなたの態度にわかでる';
                $report_map['flow_web'] = formatpost($_POST['flow_web']);
                    $report_map['flow_app'] = formatpost($_POST['flow_app']);
                    $report_map['flow_app'] = ($report_map['flow_app']) ?1 : 0;
                    $report_map['flow_user']= formatpost($_POST['flow_user']);
                    $report_map['flow_user'] = ($report_map['flow_user']) ?1 : 0;

                    $report_map['system_cpu']= formatpost($_POST['system_cpu']);
                $report_map['system_memory'] = formatpost($_POST['system_memory']);
                $report_map['system_flow'] = formatpost($_POST['system_flow']);
                $report_map['security_log'] = formatpost($_POST['security_log']);
                $report_map['days'] =  formatpost($_POST['days']);
                if ($_POST['start_time'] && $_POST['end_time']) {
                    $report_map['days'] =  'userdefined';
                    $report_map['start_time'] = $_POST['start_time'];
                    $report_map['end_time'] = $_POST['end_time'];
                }
                $report_map['security_ips'] = formatpost($_POST['security_ips']);
                $report_map['security_av'] = formatpost($_POST['security_av']);
                $report_map['security_ips'] = formatpost($_POST['security_ips']);*/
        $param = get_inputs();
        if($param['flow_app'] == '1') {
            $operate = 'export application flow report';
        } else if ($param['category'] == '1') {
            $operate = 'export application category flow report';
        } else {
            $operate = 'export report';
        }
        $msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName="'.$_SESSION[CONNECTION.USERNAME].'" Operate="'. $operate .'" ManageStyle=web Content="operation success"';
        WriteLog::ConfigWrite($msg);
//		$currentDate =  date('Ymd',time());

        /*if ($_SESSION[PERMISSION]['separation_of_powers'] == 0 || $_SESSION[CONNECTION.USERNAME] == 'audit') {
            if(file_exists('/mnt1/mysql/')) {
                $db = new MysqlDb();
                $table_name = 'config_log_'.$currentDate;
                $sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'20'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".'5'."','".' '."','".$msg."'".')';
                $db->sql_query($sql);
            }else{
                $db = new DBUtil();
                $table = 'CONFIG_LOG';
                $db->addAuditLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);
            }
        } else {
            if(file_exists('/mnt1/mysql/')) {
                $db = new MysqlDb();
                $table_name = 'audit_log_'.$currentDate;
                $sql = 'INSERT INTO '.$table_name.' (daemon, time, type, level, src_ip, msg) VALUES ('."'".'20'."','".date('Y-m-d H:i:s',time())."','".'SYSTEM_INFO'."','".'5'."','".' '."','".$msg."'".')';
                $db->sql_query($sql);
            }else{
                $db = new DBUtil();
                $table = 'AUDIT_LOG';
                $db->addEventLog(20,date('Y-m-d H:i:s',time()),'SYSTEM_INFO',5,'',$msg,$table);
            }

        }*/
        if ($param['flow_app'] == "1" || $param['category'] == "1") {
            $report = new AppReport($param);
            $res = $report -> pdf();
            $path = '/mnt1/reports/' . $res;
            if (file_exists($path)) {
                $info = file_get_contents($path);
            }
            if (file_exists($this->report_file)) {
                $json = file_get_contents($this->report_file);
                if ($json) {
                    $data = json_decode($json, true);
                    array_push($data,$res);
                    @file_put_contents($this->report_file, json_encode($data));
                }
            }
            $word_res = $report -> word();
            $word_path = '/mnt1/reports/'. $word_res;
            if (file_exists($word_path)) {
                $word_info = file_get_contents($word_path);
            }
            $data['name'] = $res;
            $data['content'] = base64_encode($info);
            $data['content_word'] = base64_encode($word_info);
            echo json_encode($data);
            exit;
        }
        $report = new AutoReport($param);
        $filename = $report -> run();

        $nameArr = explode('/', $filename);
        report_add($nameArr[count($nameArr)-1]);

        $send_flag = true;
        if ($param['ftp'] == '1') {
            $result = ftp_send_pdf($filename);

            if (!$result) {
                $send_flag = false;
                echo json_encode(array('code'=>'-1','str'=>t('report.ftp_config_file_error')));
                $msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName="'.$_SESSION[CONNECTION.USERNAME].'" Operate=ftp config"' .'" ManageStyle=web Content="error"';
                WriteLog::ConfigWrite($msg, 2);
                exit;
            }
        }

        if ($param['email'] == '1') {
            $ret = email_send_pdf($param['email_address'], $filename,$param['delete_file']);

            if (!empty($ret)) {
                $send_flag = false;
                echo json_encode($ret);
                return;
            }

        }

        if($param['delete_file'] == '1') {
            if($param['email'] == '1'){
                sleep(1);
                $check_send_state = check_email_send_pdf($param['email_address'], $filename);
                $state_code = $check_send_state['code'];
                while ($state_code==1) {
                    sleep(1);
                    $check_send_state = check_email_send_pdf($param['email_address'], $filename);
                    $state_code = $check_send_state['code'];
                }
                if ($state_code!=0) {
                    $send_flag = false;
                    $check_send_state['str'] = t('report.send_err');
                    echo json_encode($check_send_state);
                    $msg='SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName="'.$_SESSION[CONNECTION.USERNAME].'" Operate=email send failed"' .'" ManageStyle=web Content="error"';
                    WriteLog::ConfigWrite($msg, 2);
                    return;
                }
            }
            if (file_exists($filename) && $send_flag) {
                $json = file_get_contents($this->report_file);
                if ($json) {
                    $data = json_decode($json, true);
                    unset($data[array_search($nameArr[count($nameArr)-1], $data)]);
                    @file_put_contents($this->report_file, json_encode($data));
                    @unlink($filename);
                }
            }
        }
        if (!empty($filename) && strpos($filename, '.pdf')){
            echo json_encode('ok');
            exit;
        }

    }
}
