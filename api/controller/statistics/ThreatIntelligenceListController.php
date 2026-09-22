<?php
namespace controller\statistics;
use controller\mController;
use lib\Util;

class ThreatIntelligenceListController extends mController {
	
	function get(){
        $param = get_inputs();
        $day = $param['querytime'];
        $type = $param['type'];
        $url = "http://127.0.0.1:77/tiagent/api/ioctop?field=".$type."&day=".$day;
        $https_info = Util::httpRequest($url,'GET');
        $data['data'] = $https_info['tiagnet_ioctop'];
        echo json_encode($data);
        return;
	}
}
