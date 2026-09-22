<?php
namespace lib;

class ThreePower {
	public $power_key = array('CATEG_ACCOUNT'=>'0','CATEG_AUTHORITY'=>'1','CATEG_AUDIT'=>'2','CATEG_MANAGE'=>'3','CATEG_MONITOR'=>'4','CATEG_STATISTICS'=>'5','CATEG_CONFIG'=>'6','CATEG_SYSLOG'=>'7','CATEG_UPGRADE_REBOOT'=>'8');
	//是否开启三权
	function isOpen() {
		$is_power = $_SESSION[PERMISSION]['separation_of_powers'];

		if ($is_power) {
			return true;
		} else {
			return false;
		}
	}

	function setCurPermission($user) {
	    $param = array();
	    $param['admin_name'] = $user;

	    $rspString = getResponse("admin_permission", "showone", $param);
		$ret = getAssign($rspString, "admin_permission");
		if (!empty($ret)) {
		  $ret['category_items'] = json_decode($ret['category_items'])->group; 
		  $_SESSION[PERMISSION] = $ret;
		}
		return;
	}

	//获取当前用户权限
	function getAdminPermission($user,$type='current') {
		$param = array();
		$data = array();
		$param['admin_name'] = $user;
		if ($type == 'current') {
			$ret = $_SESSION[PERMISSION];
		} else {
			//可封装优化
			$rspString = getResponse("admin_permission", "showone", $param);
			$ret = getAssign($rspString, "admin_permission");
			$ret['category_items'] = json_decode($ret['category_items'])->group;
		}	
		
		if (!empty($ret)) {	
			foreach ($ret['category_items'] as $key => $value) {
				if (is_object($value)){
					$value = (array)$value;
				}
				
				$data[$value['name']]['read'] = $value['read'];
				$data[$value['name']]['write'] = $value['write'];
				$data[$value['name']]['assignable'] = $value['assignable'];
			}
		}					
		return $data;
	}

		//获取当前用户权限
	function getAdminPermissionList($user,$type='current') {
		$param = array();
		$data = array();
		$param['admin_name'] = $user;
		if ($type == 'current') {
			$ret = $_SESSION[PERMISSION];
		} else {
			//可封装优化
			$rspString = getResponse("admin_permission", "showone", $param);
			$ret = getAssign($rspString, "admin_permission");
			$ret['category_items'] = json_decode($ret['category_items'])->group;
		}	
		
		if (!empty($ret)) {	
			foreach ($ret['category_items'] as $key => $value) {
				if (is_object($value)){
					$value = (array)$value;
				}
				
				$data[$value['name'].'_read'] = $value['read'];
				$data[$value['name'].'_write'] = $value['write'];
				$data[$value['name'].'_assignable']= $value['assignable'];
			}
		}					
		return $data;
	}

	function getPermission($permission) {
		$key = $this->power_key[$permission];
		$isenable = $this -> isOpen();

		if ($isenable) {
			$data = $_SESSION[PERMISSION][category_items][$key];
		} else {
			$data = array('read'=>'1','write'=>'1');
		}

		return $data;
	}

/*	function getStatisticsPermission() {
		$key = $this->power_key['CATEG_STATISTICS'];
		$permission = $this->isOpen();

		if ($permission) {
			$data = $_SESSION[PERMISSION][category_items][$key];
		} else {
			//非三权模式下默认返回所有权限
			$data['read'] = '1';
			$data['write'] = '1';
		}

		return $data;
	}

	function getConfigPermission() {
		$key = $this->power_key['CATEG_CONFIG'];
		$permission = $this->isOpen();

		if ($permission) {
			$data = $_SESSION[PERMISSION][category_items][$key];
		} else {
			//非三权模式下默认返回所有权限
			$data['read'] = '1';
			$data['write'] = '1';
		}
		return $data;
	}

	function getSyslogPermission() {
		$key = $this->power_key['CATEG_SYSLOG'];
		$permission = $this->isOpen();

		if ($permission) {
			$data = $_SESSION[PERMISSION][category_items][$key];
		} else {
			//非三权模式下默认返回所有权限
			$data['read'] = '1';
			$data['write'] = '1';
		}
		return $data;		
	}

	function getRebootPermission() {
		$key = $this->power_key['CATEG_UPGRADE_REBOOT'];
		$permission = $this->isOpen();

		if ($permission) {
			$data = $_SESSION[PERMISSION][category_items][$key];
		} else {
			//非三权模式下默认返回所有权限
			$data['read'] = '1';
			$data['write'] = '1';
		}
		return $data;			
	}*/

}