<?php
namespace controller\syslog;
use controller\mController;
use lib\Util;

class LogThreatenDetailController extends mController {
	
	function get(){
        $param = get_inputs();
        $id = $param['id'];
        $url = "http://127.0.0.1:77/tiagent/api/getlink?id=".$id;
        $http_info = Util::httpRequest($url,'GET');
        $data['data'] = $http_info;
        echo json_encode($data);
        return;
	}
}
