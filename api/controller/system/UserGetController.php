<?php
namespace controller\system;
use controller\mController;

class UserGetController extends mController {	
	public $module = 'if_member_unused';
	function get() {
		$param = get_inputs();
		
		//ASG3.5版本没有角色表，默认返回超级管理员角色信息数据
		$list[] = array(
			'id' => 1,
			'nameCn' => '管理员',
			'nameEn' => 'admin',
			'desc' => 'default configuration administrator'
		);

		$data = array();
		$data['code'] = 1;
		$data['msg'] = '';
		$data['data'] = $list;

		echo json_encode($data);
		exit;
	}
}