<?php
namespace controller\system;
use controller\mController;

class UserDelController extends mController {
	public $module = 'admin_db';
	function get () {
		$param = get_inputs();
		$uname = $param['userId'];
		if (!$uname) {
			$ret = array('code'=>'0','msg'=>'userId is not found!');
			echo json_encode($ret);
			exit;
		}

		if ($uname == 'admin' || $uname == 'useradmin' || $uname == 'audit') {
			$ret = array('code'=>'0','msg'=>'userId invalidate!');
			echo json_encode($ret);
			exit;			
		}

		//默认不操作管理员表
		$ret = array('code'=>'1','msg'=>'success!');
		echo json_encode($ret);
		return;

		/*$data['name'] = $uname;
		$rspString = getResponse($module, "del" ,$data);
		$ret = getAssign($rspString, $module);
		if (empty($ret)) {
			$ret = array('code'=>'1','msg'=>'success!');
			echo json_encode($ret);
		}else {
			echo json_encode($ret);
		}*/
	}
}