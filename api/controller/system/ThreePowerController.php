<?php
namespace controller\system;
use controller\mController;
use lib\ThreePower;

class ThreePowerController extends mController{	
	public $power_key = array('CATEG_ACCOUNT','CATEG_AUTHORITY','CATEG_AUDIT','CATEG_MANAGE','CATEG_MONITOR','CATEG_STATISTICS','CATEG_CONFIG','CATEG_SYSLOG','CATEG_UPGRADE_REBOOT');
	function get(){
		if ($_GET['name']){$name = $_GET['name'];}
		if ($_GET['power']){$power = $_GET['power'];}
		$obj = new ThreePower();
		$is_power = $obj -> isOpen();
		if ($is_power) {
			if ($name) {
				$power_list = $obj -> getAdminPermissionList($name,'other');
			} else {
				$power_list = $obj -> getAdminPermission($_SESSION[CONNECTION.USERNAME]);
			}
			if ($power) {
				$power_list = $obj -> getPermission($power);		
			}
		} else {
			$power_list['no_permission'] = '1'; 
		}

		echo json_encode($power_list);

	}

	function put(){
		$param = get_inputs();
		$param1 = array();
		$param1['admin_name'] = $param['admin_name'];
		foreach ($this->power_key as  $value) {
			$tmp_arr = array();
			$tmp_arr['name'] = $value;
			$tmp_arr['read'] = $param[$value.'_read'];
			$tmp_arr['write'] = $param[$value.'_write'];
			$param1['category_items'][] = $tmp_arr;
		}
		$rsp = getResponse('admin_permission','mod',$param1);
		$response = getAssign($rsp,'admin_permission');

		if (!empty($response)) {
			echo json_encode($response);
		}
	}
}

