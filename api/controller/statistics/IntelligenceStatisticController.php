<?php
namespace controller\statistics;
use controller\mController;
use database\DbUtil;
use lib\Util;

class IntelligenceStatisticController extends mController {
    private $sqlite_field = ['SrcIP', 'DstIP', 'Protocol', 'Action', 'Object', 'LogLevel', 'Source', 'IocType', 'Confidence', 'Risk', 'ThreatType', 'IocID', 'IocHash', 'HotID', 'Query'];
	
	function get(){
        $param = get_inputs();
        // $type = $param['type'];
        $type_arr = ['srcip','dstip','object','threattype'];

        if (file_exists('/mnt1/mysql/')) {
            if ($param['type']!='' && !in_array($param['type'],$type_arr)) {
                $ret = array('code'=>'0','str'=>t('sys_config_export.type_error'));
                echo json_encode($ret);
                return;
            }
            if ($param['type']) {
                $url = "http://127.0.0.1:77/tiagent/api/ioctop?field=" . $param['type'] . "&day=1";
                $https_info = Util::httpRequest($url,'GET');
                $data['data'][$param['type']] = $https_info['tiagnet_ioctop'];
            } else {
                foreach ($type_arr as $value) {
                    $url = "http://127.0.0.1:77/tiagent/api/ioctop?field=".$value."&day=1";
                    $https_info = Util::httpRequest($url,'GET');
                    $data['data'][$value] = $https_info['tiagnet_ioctop'];
                }
            }
        } else {
            $src = $dst = $obj = $threat=[];
            $db = new DbUtil();
            $start_time = date("Y-m-d", time());
            $start_time .= ' 00:00:00';
            $end_time = date("Y-m-d H:i:s", time());

            $col_a['time'] = '\''.$start_time. '\' AND \''. $end_time.'\'';
            $col_a['type'] = 'DEFENSE';

            $items = $db->queryForList('security_log', $col_a, 1, 3000);

            foreach ($items as $item) {
                $url = str_replace(' ', '&', $item['msg']);
                parse_str($url, $arr);

                if (!isset($src[$arr[SrcIP]])) {
                    $src[$arr[SrcIP]] = 1;
                } else {
                    $src[$arr[SrcIP]] += 1;
                }

                if (!isset($dst[$arr[DstIP]])) {
                    $dst[$arr[DstIP]] = 1;
                } else {
                    $dst[$arr[DstIP]] += 1;
                }

                if (!isset($obj[$arr["Object"]])) {
                    $obj[$arr["Object"]] = 1;
                } else {
                    $obj[$arr["Object"]] += 1;
                }

                if (!isset($threat[$arr[ThreatType]])) {
                    $threat[$arr[ThreatType]] = 1;
                } else {
                    $threat[$arr[ThreatType]] += 1;
                }
            }

            arsort($src);
            arsort($dst);
            arsort($obj);
            arsort($threat);

            $data['data']['srcip'] = $this->array_translate($src, 'srcip');
            $data['data']['dstip'] = $this->array_translate($dst, 'dstip');
            $data['data']['object'] = $this->array_translate($obj, 'object');
            $data['data']['threattype'] = $this->array_translate($threat, 'threattype');
        }

        echo json_encode($data);
        return;
	}

    private function array_translate($data, $field) {
        $list = [];
        if (empty($data)) {
            return [];
        }

        foreach ($data as $key => $val) {
            $arr_tmp = array($field=> $key, 'count'=> $val);
            $list[] = $arr_tmp;
        }
        return $list;
    }
}
