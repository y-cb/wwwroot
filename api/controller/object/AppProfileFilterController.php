<?php
namespace controller\object;
use controller\mController;

class AppProfileFilterController extends mController {
	public $module = 'app_profile_filter';
	
    public function get()
    {
        $param = get_inputs();
        $data = array();
        header('Content-type: application/json');
        $rspString = getResponse($this->module, "show" ,$param);
        $ret = getAssign($rspString, $this->module, false, true);
        $data['data'] = $ret['group'];
        $data['total'] = $ret['page']['total'];
        echo json_encode($data);
    }
}
