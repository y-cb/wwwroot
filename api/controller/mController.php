<?php
namespace controller;
use controller\Controller;

class mController extends Controller {
    function get() {
         $data = array();
		 $param = get_inputs();

		 $show_one = false;
		 if ($param['op'] == 'list') {
			$rspString = getResponse($this->module, "show_index" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 } else if ($param['op'] == 'detail') {
			$show_one = true;
			$rspString = getResponse($this->module, "show_one" ,$param);
		    $ret = getAssign($rspString, $this->module);
			if ($ret['group']) {
				$ret['group'] = json_decode($ret['group']);
			}
		 } else if ($param['op'] == 'detail_o') {
			$show_one = true;
			$rspString = getResponse($this->module, "show_o" ,$param);
		    $ret = getAssign($rspString, $this->module);
			if ($ret['group']) {
				$ret['group'] = json_decode($ret['group']);
			}
		 } else if ($param['op'] == 'list_i') {
			$rspString = getResponse($this->module, "show_i" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 } else if ($param['op'] == 'detail_one') {
			$rspString = getResponse($this->module, "showone" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 } else {
			$rspString = getResponse($this->module, "show" ,$param);
		    $ret = getAssign($rspString, $this->module, false, true);
		 }
         header('Content-type: application/json');  

		 if($show_one) {
		 	echo json_encode($ret);
			return;
		 } else if (empty($ret)) {
		 	unset($ret);
			$ret['data'] = Array();
			$ret['total'] = 0;
		 	echo json_encode($ret);
			return;
		 } else {
            $data['data'] = $ret['group'];
            if (isset($ret['page'])) {
                $data['total'] = (int)$ret['page']['total'];
            } else {
                $data['total'] = (int)count($data['data']);
            }
		 	echo json_encode($data);
		 }
    }
    function put () {
    	$param = get_inputs();

    	switch ($param['op']) {
    		case 'submit':
    			unset($param['op']);
    			$rspString = getResponse($this->module, "submit" ,$param);
    			break;
    		default:
    			$rspString = getResponse($this->module, "mod" ,$param);
    			break;
    	}

		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
    }
}
