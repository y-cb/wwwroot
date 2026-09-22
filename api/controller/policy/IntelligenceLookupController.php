<?php
namespace controller\policy;
use controller\mController;
use lib\Util;


class IntelligenceLookupController extends mController {
    function get(){
        $params = get_inputs();
        $url = "http://127.0.0.1:77/tiagent/api/ioclib?obj=".$params['url'];
        $data['data']= [];
        if (!empty($params['url'])) {
            $result = Util::httpRequest($url,'GET');
            if(sizeof($result)>0){
                if(!empty($result['tiagnet_ioclib']['Ioc_id'])){
                    array_push($data['data'],$result['tiagnet_ioclib']);
                    //$data['data'][0] = $result['tiagnet_ioclib'];
                }
            }
            
        } 
        echo json_encode($data);
        return;
    }
}
