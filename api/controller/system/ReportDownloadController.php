<?php
namespace Controller\System;
use controller\Controller;
use lib\WriteLog;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class ReportDownloadController  extends Controller {
    public $dir = '/mnt1/reports/';
    private $report_file_list = '/mnt/boot/report_file.json';
    function get() {
        $param = get_inputs();
        $name = $param['name'];
        $mydir = dir($this->dir);
        $files = array();
        $nameArr = array();
        $num = ($param['page']-1) * $param['pageSize'];

        if ($name){
            $path = $this->dir . $name;
            if (file_exists($path)) {
                $data = file_get_contents($path);
                echo base64_encode($data);
            }else {
                $msg = 'SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="download report" ManageStyle=web Content="operation error"';
                WriteLog::ConfigWrite($msg, 2);
            }
            exit;
        }
        if (file_exists($this->report_file_list)) {
            $data = $list = array();
            $json = file_get_contents($this->report_file_list);
            if ($json) {
                $data = json_decode($json, true);
                $tmp = array_slice($data, $num, $param['pageSize']);
                foreach ($tmp as $value) {
                    /*$name_arr = explode('.',$value);
                    if (empty($name_arr[0])) {
                        continue;
                    }*/
                    $info['name'] = $value;
                    $info['time'] = date('Y-m-d H:i:s', filemtime($this->dir.$value));
                    $list[] = $info;
                }
            }
            $arr['data'] = $list;
            $arr['total'] = count($data);
        } else {
            if ($mydir) {
                while($filename = $mydir->read())
                {
                    /*if ($filename == '.' || $filename == '..' || !file_exists($this->dir.$filename) || $filename=='word') {
                        continue;
                    }*/
                    if (!is_dir($this->dir.$filename)) {
                        $file = array();
                        /*$name_arr = explode('.',$filename);

                        if (empty($name_arr[0])) {
                            continue;
                        }
                        $file['name'] = $name_arr[0];//不带后缀的名称*/
                        $file['filename'] = $file['name'] = $filename;
                        $file['time'] = date('Y-m-d H:i:s', filemtime($this->dir.$filename));
                        $files[] = $file;
                    }
                }
                $mydir->close();
            }

            foreach($files as $key => $value){
                $filetime[$key]=strtotime($value['time']);
            }

            array_multisort($filetime,SORT_DESC, $files);//按时间排序
            //缓存下载文件列表
            if (!file_exists($this->report_file_list) && sizeof($files) > 0) {
                foreach ($files as $key => $value) {
                    $nameArr[] = $value['filename'];
                }
                @file_put_contents($this->report_file_list, json_encode($nameArr));
            }


            if(sizeof($files)== 0){
                echo '{"data":[],"total":0}';
                return;
            }
            //计算当前页显示信息
            $arr['data'] = array_slice($files,$num,$param['pageSize']);
            $arr['total'] = sizeof($files);
        }
        /*		$num = ($param['page']-1)*$param['count'];
                $arr[group] = array_slice($files,$num,$param['count']);*/
        /*		$arr[page][total] = sizeof($files);;
                $arr[page][count] = $param['count'];
                $arr[page][current] = $param['page'];*/
        echo json_encode($arr);
        return;
    }
    function delete() {
        $param = get_inputs();

        if (file_exists($this->report_file_list)) {
            $json = file_get_contents($this->report_file_list);

            if ($json) {
                $data = json_decode($json, true);
                unset($data[array_search($param['name'], $data)]);
                @file_put_contents($this->report_file_list, json_encode($data));
            }
        }
        if (file_exists($this->dir.$param['name'])){
            unlink($this->dir.$param['name']);
        }

        $msg = 'SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="delete report" ManageStyle=web Content="operation success"';
        WriteLog::ConfigWrite($msg);

        echo json_encode('');
    }
}
