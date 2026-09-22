<?php

namespace controller\statistics;

use controller\mController;

/**
 * @api {GET}  /api/ips-map 获取入侵防护TOP20攻击地域分布图
 * @apiName ips-map
 * @apiGroup 入侵防护统计
 *
 *
 * @apiParam {String} attack_type 攻击类型，不可为空，sps代表攻击源，dps代表攻击目的
 *
 * @apiParamExample {json} Request-Example:
 *    {
 *        "attack_type": "sps"
 *    }
 *
 * @apiSuccess {String} cnt 攻击次数，不可为空，整型值
 * @apiSuccess {String} dstprovince 地点，不可为空，取值范围不固定
 *
 * @apiSuccessExample {json} Success-Response:
 *    HTTP/1.1 200 OK
 *    [{
 *      "dstprovince": "",
 *      "cnt": null
 *     }]
 */

use database\MysqlDb;

class IpsStatMapController extends mController
{
    function get()
    {
        $limit = 20;
        if (file_exists('/mnt1/mysql/')) {
            $cur = time();
            $day = strftime("%Y%m%d", $cur);
            $table_name = 'ips_' . $day;
            //$table_name = 'ips_20170808';
            $new_data=[];
            if ($_GET['attack_type'] == 'sps') {
                $data = MysqlDb::org_select($table_name, ['srcprovince', '[SUM](cnt)'], ["LIMIT" => ($limit+1), "GROUP" => "srcprovince", "ORDER" => "cnt DESC"]);
                for($i = 0; $i < count($data); $i++){
                    if($data[$i]['srcprovince']){
                        if($data[$i]['srcprovince']=="中国香港"||$data[$i]['srcprovince']=="中国台湾"||$data[$i]['srcprovince']=="中国澳门"){
                            $data[$i]['srcprovince']=mb_substr($data[$i]['srcprovince'], 2);
                        }
                        $new_data[]=$data[$i];
                    }
                }
            } else {
                $data = MysqlDb::org_select($table_name, ['dstprovince', '[SUM](cnt)'], ["LIMIT" => ($limit+1), "GROUP" => "dstprovince", "ORDER" => "cnt DESC"]);
                for($i = 0; $i < count($data); $i++){
                    if($data[$i]['dstprovince']){
                        if($data[$i]['dstprovince']=="中国香港"||$data[$i]['dstprovince']=="中国台湾"||$data[$i]['dstprovince']=="中国澳门"){
                            $data[$i]['dstprovince']=mb_substr($data[$i]['dstprovince'], 2);
                        }
                        $new_data[]=$data[$i];
                    }
                }
            }
            $data = $new_data;
        } else {
            $module = 'sys_top_attack_monitor';
            $param['top_n'] = ($limit-1);
            if ($_GET['attack_type'] == 'sps') {
                $param['type'] = 4;
            } else {
                $param['type'] = 5;
            }
            $rspString = getResponse($module, "show", $param);
            $ret = getAssign($rspString, $module, false, true);
            if (!empty($ret)) {
                if ($_GET['attack_type'] == 'sps') {
                    for ($i = 0; $i < count($ret['group']); $i++) {
                        $ret['group'][$i]['srcprovince'] = $ret['group'][$i]['name'];
                        $ret['group'][$i]['cnt'] = $ret['group'][$i]['count'];
                    }
                } else {
                    for ($i = 0; $i < count($ret['group']); $i++) {
                        $ret['group'][$i]['dstprovince'] = $ret['group'][$i]['name'];
                        $ret['group'][$i]['cnt'] = $ret['group'][$i]['count'];
                    }
                }
                $data = $ret['group'];
            }
        }
        if (!$data) {
            $data = [];
        }
        if(count($data) > $limit) {
            $data = array_slice($data, 0, $limit);
        }
        echo json_encode($data);
        exit;
    }
}
