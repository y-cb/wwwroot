<?php
namespace controller\system;
use controller\mController;

class OemFeatureController extends mController{	
	function get(){
		$env_data = self::get_env_cfg();
		$has_app_file = '/etc/webui_module_remove/APP';
		$has_ips_file = '/etc/webui_module_remove/IPS';
		//$has_av_file = '/etc/webui_module_remove/AV';
		if(file_exists($has_app_file)){
			$deactive_app = true;
		}else{
			if(getenv('CONFIG_DEACTIVE_WEBAPP')){
				$deactive_app = true;
			}else{
				$deactive_app = false;
			}
			//$deactive_app = false;
		}
		if(getenv('CONFIG_DEACTIVE_AV')){
			$deactive_av = true;
		}else{
			if(getenv('CONFIG_DEACTIVE_WEBAV')){
				$deactive_av = true;
			}else{
				$deactive_av = false;
			}
			//$deactive_av = false;
		}
		if(file_exists($has_ips_file)){
			$deactive_ips = true;
		}else{
			if(getenv('CONFIG_DEACTIVE_WEBIPS')){
				$deactive_ips = true;
			}else{
				$deactive_ips = false;
			}
			//$deactive_ips = false;
		}
		
		$data = self::init_oem_arr();
		$oem_type = self::get_oem_type();
		if($deactive_app&&$deactive_av && $deactive_ips){
			$data['has_feature_ips']=false;
			//$data['has_feature_vrf']=false;
			$data['has_feature_url']=false;
			//$data['has_feature_app']=false;
			//$data['has_feature_appctrl']=false;
			$data['has_feature_avdash']=false;
			$data['has_feature_ipsdash']=false;
			$data['has_feature_baseforward']=false;
			$data['has_feature_av']=false;
			//$data['has_feature_threat']=false;
			//$data['has_feature_keyword_filetype']=false;
			//$data['has_feature_mirror']=false;
			//$data['has_feature_divert']=false;
		}else{

			if($deactive_app){
				$data['has_feature_ips']=false;
				//$data['has_feature_vrf']=false;
				$data['has_feature_url']=false;
				//$data['has_feature_app']=false;
				//$data['has_feature_appctrl']=false;
				$data['has_feature_avdash']=false;
				$data['has_feature_ipsdash']=false;
				$data['has_feature_baseforward']=false;
				$data['has_feature_av']=false;
				//$data['has_feature_threat']=false;
				//$data['has_feature_keyword_filetype']=false;
				//$data['has_feature_sslvpn']=false;
			}elseif ($deactive_av || $deactive_ips){
				//出货版本添加需求:如果指定目录文件同时存在，则屏蔽ips和av相关项，如存在单一项，则屏蔽指定项
				if ($deactive_av && $deactive_ips){
					$data['has_feature_ips']=false;                                                                              
	                //$data['has_feature_malurl']=false;                                                                               
	                $data['has_feature_avdash']=false;
	                $data['has_feature_ipsdash']=false;
	                $data['has_feature_baseforward']=false;
	                $data['has_feature_av']=false;    
	            	//$data['has_feature_mirror']=false;
					//$data['has_feature_divert']=false;      
					//$data['has_feature_sslvpn']=false;
				} elseif ($deactive_av) {
					//$data['has_feature_malurl']=false;
					$data['has_feature_avdash']=false;
					$data['has_feature_ipsdash']=false;
					$data['has_feature_baseforward']=false;
					$data['has_feature_av']=false;	
					//$data['has_feature_mirror']=false;
					//$data['has_feature_divert']=false;		
					//$data['has_feature_sslvpn']=false;
				} elseif ($deactive_ips) {
					$data['has_feature_ips']=false;
					//$data['has_feature_malurl']=false;
					$data['has_feature_avdash']=false;
					$data['has_feature_ipsdash']=false;
					$data['has_feature_baseforward']=false;
					//$data['has_feature_sslvpn']=false;
				}
			} else {
				switch ($oem_type) {
					case 'acg':
						//$data['has_feature_ips']=false;
						//$data['has_feature_sslvpn']=false;
						//$data['has_feature_vrrp']=false;
						//$data['has_feature_vrf']=false;
						//$data['has_feature_malurl']=false;
						$data['has_feature_avdash']=false;
						$data['has_feature_ipsdash']=false;
						$data['has_feature_baseforward']=false;
						$data['has_feature_acgname_change']=true;
						break;
					case 'ips':
						//$data['has_feature_sslvpn']=false;
						$data['has_feature_url']=false;
						//$data['has_feature_malurl']=false;
						//$data['has_feature_app']=false;
						//$data['has_feature_appctrl']=false;
						//$data['has_feature_qos']=false;
						$data['has_feature_avdash']=false;
						$data['has_feature_baseforward']=false;
						//$data['has_feature_userbasic']=false;
						//$data['has_feature_keyword_filetype']=false;
						break;
					case 'ids':
						//$data['has_feature_sslvpn']=false;
						//$data['has_feature_url']=false;
						//$data['has_feature_malurl']=false;
						//$data['has_feature_app']=false;
						//$data['has_feature_appctrl']=false;
						//$data['has_feature_qos']=false;
						$data['has_feature_avdash']=false;
						$data['has_feature_ipsdash']=false;
						//$data['has_feature_userbasic']=false;
						$data['has_feature_baseforward']=false;
						$data['has_feature_idsname_change']=true;
						//$data['has_feature_keyword_filetype']=false;
						break;
					case 'avg':
						// $data['has_feature_ips']=false;
						//$data['has_feature_sslvpn']=false;
						$data['has_feature_url']=false;
						//$data['has_feature_malurl']=false;
						//$data['has_feature_app']=false;
						//$data['has_feature_appctrl']=false;
						//$data['has_feature_qos']=false;
						$data['has_feature_ipsdash']=false;
						//$data['has_feature_userbasic']=false;
						// $data['has_feature_keyword_filetype']=true;
						//$data['has_feature_threat']=false;
						//$env_data['has_feature_edr']=false;
						$data['has_feature_baseforward']=false;
						$env_data['has_feature_dhcp']=true;
						//$data['has_feature_edr']=false;
						//$data['has_feature_mirror']=false;
						//$data['has_feature_divert']=false;
						break;
					default:
						$data['has_feature_avdash']=false;
						$data['has_feature_ipsdash']=false;
						$data['has_feature_baseforward']=false;
						break;
				}
			}
		}
		$lte_data = self::get_lte_cfg();
		echo json_encode(array_merge($data, $env_data, $lte_data));

	}
	function init_oem_arr(){
		$arr = array(
			"has_feature_ips"=>true,
			//"has_feature_sslvpn"=>true,
			"has_feature_vrrp"=>true,
			"has_feature_vrf"=>true,
			"has_feature_url"=>true,
			//"has_feature_malurl"=>true,
			//"has_feature_app"=>true,
			//"has_feature_appctrl"=>true,
			//"has_feature_qos"=>true,
			"has_feature_avdash"=>true,
			"has_feature_ipsdash"=>true,
			"has_feature_baseforward"=>true,
			//"has_feature_userbasic"=>true,
			"has_feature_av"=>true,
			//"has_feature_threat"=>true,
			//"has_feature_keyword_filetype"=>true,
			//"has_feature_edr"=>true,
			"has_feature_geo"=>true,
			//"has_feature_mirror"=>true,
			//"has_feature_divert"=>true
			);
		return $arr;
	}
	function get_oem_str()
	{
		return file_get_contents("/etc/oem_id");
	}
	function get_oem_type(){
		$oem_name = self::get_oem_str();
		$product_type_arr = explode("_",$oem_name);
		$arr_len  = sizeof($product_type_arr);
		$product_type = $product_type_arr[$arr_len-1];
		return $product_type;
	}
	function get_env_cfg(){
		$env_data = array();
		$env_config_arr = ['CONFIG_DHCP','CONFIG_DEACTIVE_OSPF','CONFIG_DEACTIVE_BGP','CONFIG_DEACTIVE_RIP','CONFIG_INF_BYPASS','CONFIG_INF_HTTP','CONFIG_INF_TELNET','CONFIG_DEACTIVE_GEO','CONFIG_DEACTIVE_EDR','CONFIG_DEACTIVE_THREAT','CONFIG_DEACTIVE_APP_POLICY','CONFIG_DEACTIVE_SSL','CONFIG_DEACTIVE_VPN','CONFIG_DEACTIVE_IPSECVPN','CONFIG_DEACTIVE_SSLVPN','CONFIG_DEACTIVE_USER_POLICY','CONFIG_DEACTIVE_USER_RESOURCE','CONFIG_DEACTIVE_USER_BRUTEFORCE','CONFIG_DEACTIVE_USER_QUOTA','CONFIG_DEACTIVE_NBC_QOS','CONFIG_DEACTIVE_ROUTE_ISP','CONFIG_DEACTIVE_ROUTE_POLICY','CONFIG_DEACTIVE_ROUTE6_POLICY','CONFIG_DEACTIVE_OSPFV3','CONFIG_DEACTIVE_IPV6_TUNNEL','CONFIG_DEACTIVE_VLINE','CONFIG_DEACTIVE_DNS_PROXY','CONFIG_DEACTIVE_AUTH_LOCAL','CONFIG_DEACTIVE_RADIUS_SERVER','CONFIG_DEACTIVE_LDAP_SERVER','CONFIG_DEACTIVE_AUTH_SERVER','CONFIG_DEACTIVE_AUTH_SMS','CONFIG_DEACTIVE_AUTH_PORTAL','CONFIG_DEACTIVE_AUTH_ADSSO','CONFIG_DEACTIVE_AUTH_OTP','CONFIG_DEACTIVE_AUTH_QRCODE','CONFIG_DEACTIVE_AUTH_FREE','CONFIG_DEACTIVE_NAT','CONFIG_DEACTIVE_WEB_ACCESS','CONFIG_DEACTIVE_DIVERT_PLCY','CONFIG_DEACTIVE_MIRROR_PLCY','CONFIG_DEACTIVE_APP_AUDIT','CONFIG_DEACTIVE_AV_SANDBOX','CONFIG_DEACTIVE_VPNIOS','CONFIG_WILDCARD_DOMAIN_OBJ','CONFIG_DEACTIVE_GLOBAL_WHITELIST','CONFIG_DEACTIVE_WEB_NGFW','CONFIG_DEACTIVE_SYSLOG_FW','CONFIG_DEACTIVE_SYSLOG_AVG','CONFIG_DEACTIVE_SYSLOG_IDS'];
		//$env_web_config_arr = ['CONFIG_DEACTIVE_WEBSANDBOX'];
		foreach ($env_config_arr as $key => $value) {
			if(stristr($value,'CONFIG_DEACTIVE')!== false){//环境变量带有deactive表示需要屏蔽，转换成has_feature为false
				$feature_tmp_name =  strtolower(str_replace("CONFIG_DEACTIVE","has_feature",$value));
				if(getenv($value)){
					$env_data[$feature_tmp_name] = false;
				} else {
					$env_data[$feature_tmp_name] = true;
				}
			}else{
				$feature_tmp_name =  strtolower(str_replace("CONFIG","has_feature",$value));
				if(getenv($value)){
					$env_data[$feature_tmp_name] = true;
				} else {
					$env_data[$feature_tmp_name] = false;
				}
			}
			if(getenv($value) == null) {
				$env_data[$feature_tmp_name] = true;
			}
			
		}
		/*foreach($env_web_config_arr as $key => $value){
			$feature_tmp_name =  strtolower(str_replace("CONFIG_DEACTIVE_WEB","has_feature_",$value));
			if(getenv($value)){
				$env_data[$feature_tmp_name] = false;
			} else {
				$env_data[$feature_tmp_name] = true;
			}
		}*/
		return $env_data;
	}
	function get_lte_cfg() {
		//通过接口判断设备是否包含lte
		$module = 'net_lte_module_status';
		$response = getResponse($module, 'show', '');
		$res = getAssign($response, $module);
		$is_lte = ($res['lte_module_status'] == '1')? true: false;
		return array('has_feature_lte'=> $is_lte);
	}
}

