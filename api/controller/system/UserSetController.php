<?php
namespace controller\system;
use controller\mController;

class UserSetController extends mController {	
	function post() {
		// $json = $GLOBALS['HTTP_RAW_POST_DATA'];
		$json = get_inputs();
		
		$uname = $json['userId'];
		$rname = $json['role'];

		if (!$uname || !$rname) {
			$ret = array('code' => '0','msg' => 'invalidate field!');
			echo json_encode($ret);
			exit;
		}
		//ASG3.5不存在角色表，固屏蔽下发数据逻辑，只要数据存在，就返回成功
		/*$res= getResponse('admin_db','show',array('name'=>$uname));
		$data = $res['admin_db']['group'];
		if ($data['authority_table_name'] == $rname) {
			$ret = array('code' => '1','msg' => 'success!');
			echo json_encode($ret);
			exit;
		}
		$data['name'] = $uname;
		$data['authority_table_name'] = $rname;
		$rtn = getResponse('admin_db','mod',$data);
	 	$ret = getAssign($rtn, 'admin_db');

		if (!$uname || !$rname) {
			$ret = array('code' => '1','msg' => 'success!');
			echo json_encode($ret);
		} else {
			echo json_encode($ret);
		}*/

		$ret = array('code' => '1','msg' => 'success!');
		echo json_encode($ret);
	}
}