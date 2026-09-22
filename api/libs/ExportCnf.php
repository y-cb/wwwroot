<?php
namespace lib;
use message\MainModel;

class ExportCnf{
	function export($get_type){
		$type = $get_type;
		$arr = array("sc" => "SYSCONFIG", "ic" => "IPSCONFIG", "uic" => "USER_DEFINE", "av" => "AVCONFIG", 'bayes' => 'BAYES_DB', 'eventlog' => 'EVENT_LOG', 'ipslog' => 'IPS_LOG', 'avlog' => 'AV_LOG', 'isp'=>'ISP_OUT_', 'addr'=>'ADDR_OBJ','certl'=>'CERTL_OUT_', 'cal'=>'CAL_OUT_', 'dhcp'=>'DHCP_BIND', 'arp'=>'ARP_BIND', 'blist'=>'BLIST_OBJ','resource'=>'USER_RES_OBJ','url'=>'CUSTOM_URL_CATEGORY',"all"=>"ALL");

		$configtype = $arr[$type];
		$fname = $configtype . ".TXT";
		if ('bayes' == $type) {
			$fname = $configtype;
		}
		if ('eventlog' == $type | 'ipslog' == $type | 'avlog' == $type) {
			$fname = $configtype . ".tgz";	
		}
		if ('isp' == $type)
			$fname = $_GET['name'];	

		if ('certl' == $type){
			$fname = $_GET['certname'].'.cer';	
		}	
		if ('cal' == $type){
			$fname = $_GET['certname'].'.cer';		
		}

		if ('isp' == $type || 'certl' == $type || 'cal' == $type)
			$data = MainModel::fetchConfig($configtype . $fname);
		else
			$data = MainModel::fetchConfig($configtype . "_OUT");

		return $data;
	}
}

?>
