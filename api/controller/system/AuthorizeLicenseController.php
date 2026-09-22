<?php
namespace controller\system;
use controller\mController;
use lib\ArrayMap;
use lib\ArrayList;

class AuthorizeLicenseController extends mController{	
	function post(){
		$param = get_inputs();
		$hostinfo = getResponse('hostinfo', "show",$param);
		$sn=$hostinfo['hostinfo']['group']["serial_no"];
		$licenseKey=$param['licensekey'];

		$dns = getResponse('dns', "show",$param);
		$dns_ip=$dns['dns']['group']['first_dns'];
		$data = new ArrayList();	
		$my_data = new ArrayMap();
		$my_data['dns_name']='license2.sec-inside.com';	
		$my_data['first_dns']=$dns_ip;	
		$my_data['second_dns']='0.0.0.0';	
		$data[] = $my_data;

		$IPaddress=getResponse('detect', "show",$my_data);
		
		$myip=$IPaddress['detect']['group']['ip'];

		$options = array(
			'http' => array(
				'method' => 'GET',
				'header' => "Content-type:application/x-www-form-urlencoded\r\n"
							."Host: license2.sec-inside.com:8080\r\n"
			)
		);
		$context = stream_context_create($options);

		$url='http://'.$myip.':8080/activation/bindLicense.do?sn='.$sn;
		$str=file_get_contents($url,false,$context);

		if(!$str){		
			$err_str = t('license.license4');
			$ret = array('code' => '-1', 'str' => $err_str);
			echo json_encode($ret);
		}else{
			$result = json_decode($str);
			if($result->code==0){
				$license=$result->dataObject->generatedLicense;
				$data = new ArrayList();	
				$my_data = new ArrayMap();
				$my_data['license']=$license;	
				$data[] = $my_data;
				$rspString = getResponse('license_info',"mod",$my_data);
				$ret = getAssign($rspString, 'license_info');
				if($ret[code]!=0){
					echo json_encode($ret);
				}else{
					echo "success";
				}

			}else{
				$err_str = t('license.license'.substr($result->code,1));
				$ret = array('code' => $result->code, 'str' => $err_str);
				echo json_encode($ret);
			}
		}

	}
}

