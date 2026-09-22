<?php
namespace controller\Statistics;
use controller\Controller;

class AppProfileController extends Controller {
    public $module = 'app_profile';
    public $others = array("instant-messaging", "online-community", "email", "file-transfer", "search-engine", "online-shopping");

    function get(){
        $param = get_inputs();
        $list = [];
    	$is_othters = 0;

    	if (isset($param['type'])) {
    		$data['name'] = $param['type'];
    	} else {
    		$is_othters = 1;
    	}
    	$rspString = getResponse($this->module , "show" , $data );
    	$retParam = getAssign($rspString,$this->module);

    	if($retParam){
                foreach($retParam as $key=>$value){
    				if ($value['name'] == 'any') {
    					continue;
    				} else {
    					if ($is_othters == 1 && in_array($value['category'], $this->others)) {
    						continue;
    					}
    					$list[] = $value;
    				}
    			}
    	}
    	return $list;
    }
}
