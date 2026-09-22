<?php
namespace controller\system;
use controller\Controller;
use lib\WriteLog;

/**
 * @api {GET}  /api/report-config 获取报表配置页面
 * @apiName 获取报表配置页面数据
 * @apiGroup 报表配置
 *
 *
 * @apiSuccess {String} name 报表名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 * {
 *   "data": [
 *       {
 *           "name": "test",
 *           "days": "userdefined",
 *            "title": "测试标题",
 *           "description": "测试详情",
 *           "start_time": "2018-05-01",
 *           "end_time": "2018-05-04",
 *           "flow_web": 1,
 *           "security_ips": 1,
 *           "security_av": 1,
 *           "security_log": 1
 *       },
 *       {
 *           "name": "test-scar",
 *           "days": "userdefined",
 *           "title": "title",
 *           "description": "description",
 *           "start_time": "2018-05-01",
 *           "end_time": "2018-05-10"
 *       }
 *   ],
 *   "total": 2
 *}
 */

/**
 * @api {PUT}  /api/report-config 修改报表配置页面
 * @apiName 修改报表配置页面
 * @apiGroup 报表配置
 *
 *
 * @apiSuccess {String} name 配置报表名称
 * @apiSuccess {String} title 报表标题
 * @apiSuccess {String} description 报表详情
 * @apiSuccess {String} days 天数设置项，daily代表每天，weekly代表每周，monthly代表每月，userdefined代表自定义
 * @apiSuccess {TimeStamp} start_time 开始时间，YYYY-MM-DD格式，days为userdefined时需设置
 * @apiSuccess {TimeStamp} end_time 结束时间，YYYY-MM-DD格式，days为userdefined时需设置
 * @apiSuccess {TimeStamp} end_time 结束时间，YYYY-MM-DD格式，days为userdefined时需设置
 * @apiSuccess {String} flow_app 应用流量，1为开启，days为自定义时不可开启
 * @apiSuccess {String} flow_user 用户流量，1为开启，days为自定义时不可开启
 * @apiSuccess {String} flow_web Web访问，1为开启
 * @apiSuccess {String} security_ips 入侵防护，1为开启
 * @apiSuccess {String} security_av 病毒防护，1为开启
 * @apiSuccess {String} security_log 安全日志，1为开启
 * @apiSuccess {String} system_flow 流量速率，1为开启
 * @apiSuccess {String} system_cpu CPU利用率，1为开启
 * @apiSuccess {String} system_memory 内存利用率，1为开启
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "sunya",
 *			"title": "title",
 *			"description": "description",
 *			"days": "userdefined",
 *			"start_time": "2018-05-01",
 *			"end_time": "2018-05-10",
 *			"flow_web": "1",
 *			"security_ips": "1",
 *			"security_av": "1",
 *			"security_log": "1",
 *			"system_flow": "1",
 *			"system_cpu": "1",
 *			"system_memory": "1"
 *	}
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 */

/**
 * @api {POST}  /api/report-config 添加报表配置页面
 * @apiName 添加报表配置页面
 * @apiGroup 报表配置
 *
 *
 * @apiSuccess {String} name 配置报表名称
 * @apiSuccess {String} title 报表标题
 * @apiSuccess {String} description 报表详情
 * @apiSuccess {String} days 天数设置项，daily代表每天，weekly代表每周，monthly代表每月，userdefined代表自定义
 * @apiSuccess {TimeStamp} start_time 开始时间，YYYY-MM-DD格式，days为userdefined时需设置
 * @apiSuccess {TimeStamp} end_time 结束时间，YYYY-MM-DD格式，days为userdefined时需设置
 * @apiSuccess {TimeStamp} end_time 结束时间，YYYY-MM-DD格式，days为userdefined时需设置
 * @apiSuccess {String} flow_app 应用流量，1为开启
 * @apiSuccess {String} flow_user 用户流量，1为开启
 * @apiSuccess {String} flow_web Web访问，1为开启
 * @apiSuccess {String} security_ips 入侵防护，1为开启
 * @apiSuccess {String} security_av 病毒防护，1为开启
 * @apiSuccess {String} security_log 安全日志，1为开启
 * @apiSuccess {String} system_flow 流量速率，1为开启
 * @apiSuccess {String} system_cpu CPU利用率，1为开启
 * @apiSuccess {String} system_memory 内存利用率，1为开启
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "sunya",
 *			"title": "title",
 *			"description": "description",
 *			"days": "userdefined",
 *			"start_time": "2018-05-01",
 *			"end_time": "2018-05-10",
 *			"flow_web": "1",
 *			"security_ips": "1",
 *			"security_av": "1",
 *			"security_log": "1",
 *			"system_flow": "1",
 *			"system_cpu": "1",
 *			"system_memory": "1"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 *
 */

/**
 * @api {DELETE}  /api/report-config 删除报表配置
 * @apiName 删除报表配置
 * @apiGroup 报表配置
 *
 *
 * @apiParam {String} name 报表名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "sunya"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 *
 */

class ReportCfgController extends Controller{
    public $path = '/mnt/boot/report.json';
    public $lang_path = '/tmp/webui/lang.conf';
    public $days = array('daily', 'weekly', 'monthly', 'userdefined');
    public $lang;

    function __construct(){
        parent::__construct();
        if (file_exists($this->lang_path)) {
            $this->lang = file_get_contents($this->lang_path);
        }
    }

    function get(){
        /*if ($_GET['page']){$current_page = $_GET['page']?$_GET['page']:1;}
        if ($_GET['pageSize']){$page_size = $_GET['pageSize'];}*/
        if ($_GET['name']){$name = $_GET['name'];}

        if($name) {
            $ret['data'] = $this -> system_report_query($name);
        } else {
            $ret['data'] = $this -> system_report_get($current_page,$page_size);
        }
        $ret['total'] = count($ret['data']);
        echo json_encode($ret);
    }

    function post(){
        $param = get_inputs();

        if (!$param['name']||!$param['title']){
            if ($this->lang == 2) {
                $msg = array('code'=>'-1','str'=>'名称和标题不能为空');
            } else {
                $msg = array('code'=>'-1','str'=>'Name and title cannot be empty');
            }
        }
        /*if($_POST['name']) $param['name'] = formatpost($_POST['name']);
        if($_POST['title']) $param['title'] = formatpost($_POST['title']);
        if($_POST['description']) $param['description'] = formatpost($_POST['description']);
        if($_POST['days']) $param['days'] = formatpost($_POST['days']);*/
        if(!in_array($param['days'], $this->days)){
            if ($this->lang == 2) {
                $msg = array('code'=>'-1','str'=>'数据格式错误');
            } else {
                $msg = array('code'=>'-1','str'=>'Data format error');
            }
        }

        /*$params = array("sync_module"=>"1","sync_type"=>"3","sync_name"=>"");
        $rspString = getResponse('ha_sync_module', "mod" ,$params);*/

        if($param['days']!="userdefined"){
            /*if($_POST['start_time']) $param['start_time'] = formatpost($_POST['start_time']);
            if($_POST['end_time']) $param['end_time'] = formatpost($_POST['end_time']);
        }else{*/
            $param['start_time'] = "";
            $param['end_time'] = "";
        }

        // if($_POST['flow_app']) $param['flow_app'] = formatpost($_POST['flow_app']);
        $param['flow_app'] = ($param['flow_app'])?"1":"0";
        // if($_POST['flow_user']) $param['flow_user'] = formatpost($_POST['flow_user']);
        $param['flow_user'] = ($param['flow_user'])?"1":"0";
        // if($_POST['flow_web']) $param['flow_web'] = formatpost($_POST['flow_web']);
        $param['flow_web'] = ($param['flow_web'])?"1":"0";

        // if($_POST['security_ips']) $param['security_ips'] = formatpost($_POST['security_ips']);
        $param['security_ips'] = ($param['security_ips'])?"1":"0";
        // if($_POST['security_av']) $param['security_av'] = formatpost($_POST['security_av']);
        $param['security_av'] = ($param['security_av'])?"1":"0";
        // if($_POST['security_log']) $param['security_log'] = formatpost($_POST['security_log']);
        $param['security_log'] = ($param['security_log'])?"1":"0";

        // if($_POST['system_flow']) $param['system_flow'] = formatpost($_POST['system_flow']);
        $param['system_flow'] = ($param['system_flow'])?"1":"0";
        // if($_POST['system_cpu']) $param['system_cpu'] = formatpost($_POST['system_cpu']);
        $param['system_cpu'] = ($param['system_cpu'])?"1":"0";
        // if($_POST['system_memory']) $param['system_memory'] = formatpost($_POST['system_memory']);
        $param['system_memory'] = ($param['system_memory'])?"1":"0";

        if($msg) {
            echo json_encode($msg);
            exit;
        }
        $list = $this -> system_report_query($param['name']);
        if (!empty($list)) {
            if ($this->lang == '2') {
                $str = '名称冲突';
            } else {
                $str = 'Name conflict';
            }
            echo json_encode(array('code'=>'-1','str'=>$str));
            return;
        }
        $sql_insert = $this->system_report_insert($param);

        if ($sql_insert) {
            $params = array("sync_module"=>"1","sync_type"=>"3","sync_name"=>"");
            $rspString = getResponse('ha_sync_module', "mod" ,$params);
            $msg = 'SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="add reports config template" ManageStyle=web Content="operation success"';
            WriteLog::ConfigWrite($msg);
        }

        if ($sql_insert === false){
            if ($this->lang == '2') {
                $code_str = '添加失败';
            } else {
                $code_str = 'add failed';
            }
            echo json_encode(array('code'=>'-1','str'=>$code_str));
        }
        exit;
    }

    function put() {
        $param = get_inputs();

        if (!$param['name']||!$param['title']){
            if ($this->lang == 2) {
                $msg = array('code'=>'-1','str'=>'名称和标题不能为空');
            } else {
                $msg = array('code'=>'-1','str'=>'Name and title cannot be empty');
            }
        }

        /*		if($_POST['name'])  $param['name'] = formatpost($_POST['name']);
                if($_POST['title']) $param['title'] = formatpost($_POST['title']);
                if($_POST['description']) $param['description'] = formatpost($_POST['description']);
                if($_POST['days']) $param['days'] = formatpost($_POST['days']);
                if($_POST['days']=="userdefined"){
                    if($_POST['start_time']) $param['start_time'] = formatpost($_POST['start_time']);
                    if($_POST['end_time']) $param['end_time'] = formatpost($_POST['end_time']);
                }
                else{
                    $param['start_time'] = "";
                    $param['end_time'] = "";
                }


                if($_POST['flow_app']) $param['flow_app'] = formatpost($_POST['flow_app']);*/

        if(!in_array($param['days'], $this->days)){
            if ($this->lang == 2) {
                $msg = array('code'=>'-1','str'=>'数据格式错误');
            } else {
                $msg = array('code'=>'-1','str'=>'Data format error');
            }
        }


        /*$params = array("sync_module"=>"1","sync_type"=>"3","sync_name"=>"");
        $rspString = getResponse('ha_sync_module', "mod" ,$params);*/

        $param['flow_app'] = ($param['flow_app'])?"1":"0";
        // if($_POST['flow_user']) $param['flow_user'] = formatpost($_POST['flow_user']);
        $param['flow_user'] = ($param['flow_user'])?"1":"0";
        // if($_POST['flow_web']) $param['flow_web'] = formatpost($_POST['flow_web']);
        $param['flow_web'] = ($param['flow_web'])?"1":"0";

        // if($_POST['security_ips']) $param['security_ips'] = formatpost($_POST['security_ips']);
        $param['security_ips'] = ($param['security_ips'])?"1":"0";
        // if($_POST['security_av']) $param['security_av'] = formatpost($_POST['security_av']);
        $param['security_av'] = ($param['security_av'])?"1":"0";
        // if($_POST['security_log']) $param['security_log'] = formatpost($_POST['security_log']);
        $param['security_log'] = ($param['security_log'])?"1":"0";

        // if($_POST['system_flow']) $param['system_flow'] = formatpost($_POST['system_flow']);
        $param['system_flow'] = ($param['system_flow'])?"1":"0";
        // if($_POST['system_cpu']) $param['system_cpu'] = formatpost($_POST['system_cpu']);
        $param['system_cpu'] = ($param['system_cpu'])?"1":"0";
        // if($_POST['system_memory']) $param['system_memory'] = formatpost($_POST['system_memory']);
        $param['system_memory'] = ($param['system_memory'])?"1":"0";
        //如果修改为自定义，默认清空应用流量和用户流量
        if($param['days']=="userdefined"){
            $param['flow_app'] = "0";
            $param['flow_user'] = "0";
        }

        if($msg) {
            echo json_encode($msg);
            exit;
        }

        $sql_update= $this->system_report_update($param['name'], $param);

        if ($sql_update) {
            $params = array("sync_module"=>"1","sync_type"=>"3","sync_name"=>"");
            $rspString = getResponse('ha_sync_module', "mod" ,$params);
            $msg = 'SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="update reports config template" ManageStyle=web Content="operation success"';
            WriteLog::ConfigWrite($msg);
        }

        if ($sql_update === false){
            $lang_cfg = file_get_contents('/tmp/webui/lang.conf');
            if ($lang_cfg == '2') {
                $code_str = '修改失败';
            } else {
                $code_str = 'update failed';
            }
            echo json_encode(array('code'=>'-1','str'=>$code_str));
        }

        exit;
    }

    function delete(){
        $param = get_inputs();
        $list = $this -> system_report_query($param['name']);

        if ($list) {
            $res = $this -> system_report_delete($list['name']);

            if ($res!==false) {
                $params = array("sync_module"=>"1","sync_type"=>"3","sync_name"=>"");
                $rspString = getResponse('ha_sync_module', "mod" ,$params);
                $msg = 'SrcIP='.$_SERVER["REMOTE_ADDR"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="delete reports config template" ManageStyle=web Content="operation success"';
                WriteLog::ConfigWrite($msg);
            }

            if ($res === false){
                echo json_encode(array('code'=>'-1','str'=>'delete failed'));
            }
        }
        exit;
    }

    function system_report_get($page,$pagenum) {
        $page = ($page - 1) * $pagenum;
        $report_arr = array();
        $report_query_time = array();

        if (file_exists($this->path)) {
            $str = file_get_contents($this->path);
            $report_arr = json_decode($str, true);
            $report_arr = array_reverse($report_arr);
        }
        $report_arr = array_slice($report_arr,$page,$pagenum);
        return $report_arr;
    }
    function system_report_query($name) {
        $report_arr = array();
        $report_query_time = array();

        if (file_exists($this->path)) {
            $str = file_get_contents($this->path);
            $report_arr = json_decode($str, true);
        }
        foreach($report_arr as $item) {
            if ($item['name'] == $name) {
                return $item;
            }
        }
        return null;
    }
    function system_report_insert($report) {
        $report_arr = array();

        if ($this->system_report_query($report['name'])) {
            return false;
        }
        if (file_exists($this->path)) {
            $str = file_get_contents($this->path);
            $report_arr = json_decode($str);
        }
        $report_arr[] = $report;

        $json = json_encode($report_arr);
        file_put_contents($this->path, $json);
        return true;
    }
    function system_report_update($name, $report) {
        $report_arr = array();

        if (file_exists($this->path)) {
            $str = file_get_contents($this->path);
            $report_arr = json_decode($str);
        }
        foreach($report_arr as $key => $item) {
            if ($item->name == $name) {
                $report['name'] = $name;
                $report_arr[$key] = $report;
                $json = json_encode($report_arr);
                file_put_contents($this->path, $json);
                return true;
            }
        }
        return false;
    }
    function system_report_delete($name) {
        $report_arr = array();
        $report_new_arr = array();

        if (file_exists($this->path)) {
            $str = file_get_contents($this->path);
            $report_arr = json_decode($str);
        }

        foreach($report_arr as $key => $item) {
            if ($item->name != $name) {
                array_push($report_new_arr,$item);
            }
        }
        $json = json_encode($report_new_arr);
        file_put_contents($this->path, $json);
    }
}

