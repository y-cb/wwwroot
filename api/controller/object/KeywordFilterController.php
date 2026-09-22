<?php
namespace controller\object;
use controller\mController;

class KeywordFilterController extends mController {
    public $module = 'obj_keywords_filter';

    public function get()
    {
        $param = $_GET;
        $data = array();
        header('Content-type: application/json');
        $rspString = getResponse($this->module, "show" ,$param);
        $ret = getAssign($rspString, $this->module, false, true);
        $data['data'] = $ret['group'];
        $data['total'] = $ret['page']['total'];
        echo json_encode($data);
    }
}