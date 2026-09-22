<?php

namespace controller\statistics;

use controller\mController;

/**
 * @api {GET}  /api/ips-map 获取入侵防护TOP20攻击地域分布图
 * @apiName ips-map
 * @apiGroup 入侵防护统计
 *
 *
 * @apiParam {String} attack_type 类型，sps代表攻击源，dps代表攻击目的
 *
 * @apiParamExample {json} Request-Example:
 *    {
 *        "attack_type": "sps"
 *    }
 *
 * @apiSuccess {String} cnt 攻击次数
 * @apiSuccess {String} dstprovince 地点
 *
 * @apiSuccessExample {json} Success-Response:
 *    HTTP/1.1 200 OK
 *    [{
 *      "dstprovince": "",
 *      "cnt": null
 *     }]
 */

use database\MysqlDb;

class SafetyMapController extends mController
{
    function get()
    {
        if(file_exists('/mnt1/mysql/')) {
            $cur = time();
            $day = strftime("%Y%m%d", $cur);
            $day1 = strftime("%Y%m%d", $cur-24*60*60);
            $day2= strftime("%Y%m%d",$cur-2*24*60*60);

            $time_type = $_GET['time_type'];
            $page_num = $_GET['page'];
            $page_num = $page_num == 0? 1 : $page_num;
            $page_count = $_GET['pageSize']?$_GET['pageSize']:10;
            $start = (($page_num - 1) * $page_count);
            $start = $start < 0 ? 0 : $start;

            $ips_table_name = 'ips_'. $day;
            //$ips_table_name = 'ips_20201109';
            $ips_table_name1 = 'ips_'. $day1;
            //$ips_table_name1 = 'ips_20201110';
            $ips_table_name2 = 'ips_'. $day2;

            $av_table_name = 'av_'. $day;
            //$av_table_name = 'av_20201106';
            $av_table_name1 = 'av_'. $day1;
            //$av_table_name1 = 'av_20201111';
            $av_table_name2 = 'av_'. $day2;

            if($time_type=='1'){
                $all_tb_arr = [$ips_table_name,$av_table_name];
            }else{
                $ips_tb_arr = [$ips_table_name,$ips_table_name1,$ips_table_name2];
                $av_tb_arr = [$av_table_name,$av_table_name1,$av_table_name2];
                $all_tb_arr = array_merge($ips_tb_arr, $av_tb_arr);
            }

            
            $all_real_arr=[];

            foreach ($all_tb_arr as $key => $value) {
                $sql= "SHOW TABLES LIKE "."'%".$value."%'";
                $sql_query = MysqlDb::sql_query($sql);
                if(!empty($sql_query)){
                    array_push($all_real_arr,$value);
                }
            }

            if(empty($all_real_arr)){
                $data = [];
            }else{
                if(sizeof($all_real_arr)==1){
                    $sql = "SELECT country,COUNT(*) AS cnt FROM ".$all_real_arr[0]." GROUP BY country ORDER BY cnt DESC LIMIT ".$page_count." OFFSET ".$start;
                }else{
                    $arr_len = sizeof($all_real_arr);
                    $sql_cnt="SELECT country,COUNT(*) AS cnt FROM (";
                    foreach ($all_real_arr as $key => $value){
                        if($key!=$arr_len-1){
                            $sql_cnt = $sql_cnt."SELECT country,create_at FROM ".$value." UNION ALL ";
                        }else{
                            $sql_cnt = $sql_cnt."SELECT country,create_at FROM ".$value;
                        }
                    }
                    $sql = $sql_cnt." ) as alias GROUP BY country ORDER BY cnt DESC Limit 10";
                    //$sql = $sql_cnt." ) as alias GROUP BY srcip ORDER BY cnt DESC";

                }
                $sql_data = MysqlDb::sql_query($sql);
            }



        } else {
            $ips_module = 'sys_top_attack_monitor';
            $ips_param['top_n'] = 20;
            if ($_GET['attck_type'] == 'sps') {
                $ips_param['type'] = 4;
            } else {
                $ips_param['type'] = 5;
            }
            $ips_rspString = getResponse($ips_module, "show", $ips_param);
            $ips_ret = getAssign($ips_rspString, $ips_module, false, true);
            if (!empty($ips_ret)) {
                if ($_GET['attck_type'] == 'sps') {
                    for ($i = 0; $i < count($ret['group']); $i++) {
                        $ips_ret['group'][$i]['srcprovince'] = $ips_ret['group'][$i]['name'];
                        $ips_ret['group'][$i]['cnt'] = $ips_ret['group'][$i]['count'];
                    }
                } else {
                    for ($i = 0; $i < count($ret['group']); $i++) {
                        $ret['group'][$i]['dstprovince'] = $ips_ret['group'][$i]['name'];
                        $ips_ret['group'][$i]['cnt'] = $ips_ret['group'][$i]['count'];
                    }
                }
                $ips_data = $ips_ret['group'];                
            }

            $av_module = 'sys_top_attack_monitor';
            $av_param['top_n'] = 20;
            if ($_GET['attck_type'] == 'sps') {
                $av_param['type'] = 4;
            } else {
                $av_param['type'] = 5;
            }
            $av_rspString = getResponse($av_module, "show", $av_param);
            $av_ret = getAssign($av_rspString, $av_module, false, true);
            if (!empty($av_ret)) {
                if ($_GET['attck_type'] == 'sps') {
                    for ($i = 0; $i < count($ret['group']); $i++) {
                        $av_ret['group'][$i]['srcprovince'] = $av_ret['group'][$i]['name'];
                        $av_ret['group'][$i]['cnt'] = $av_ret['group'][$i]['count'];
                    }
                } else {
                    for ($i = 0; $i < count($ret['group']); $i++) {
                        $av_ret['group'][$i]['dstprovince'] = $av_ret['group'][$i]['name'];
                        $av_ret['group'][$i]['cnt'] = $av_ret['group'][$i]['count'];
                    }
                }
                $av_data = $av_ret['group'];                
            }
        }
        $data['data'] = $sql_data;
        $data['total'] = (int)count($sql_data);
        echo json_encode($data);
        return;
    }
}
