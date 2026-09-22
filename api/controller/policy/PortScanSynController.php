<?php
namespace controller\policy;
use database\ScanUtil;

class PortScanSynController{

public $module = 'assets_mgmt';//资产同步模块	
	//http://ip/api/port-scan-syn?api_key=0b1kg4o73w6muqd9p5dgqaqqljneymd8
	function get(){
		if ($_SERVER[REMOTE_ADDR] === '127.0.0.1') {
			$_SESSION[CONNECTION.ISUPER] = 1;
		} else {
			echo json_encode(['code'=>'401', 'str'=> 'Not Login']);
			return;
		}
		//$infor = get_inputs();
		//var_dump($param[id]);
		//$id = $infor['id'];
		//$id = '132';
		//var_dump("1111");
		//exit(0);
		$db = new ScanUtil();
		$onedata = $db->getLastOne('portsan_log');
		$data_json = $onedata['result'];
		$resultall = json_decode($data_json,true);

		$data_infor = $onedata['infor'];
		$infor = json_decode($data_infor,true);
		$iptype = $infor['type'];
		
		if($iptype == "3"){
			$syntype = "1";
		}else{
			$syntype = "0";
		}

		$resultallopen = [];
		//var_dump($resultall);
		foreach ($resultall as $resultones) {
			/* 	原数据
				172.23.0.118	21/tcp	closed	ftp
				172.23.0.118	22/tcp	open	ssh
				172.23.0.118	23/tcp	open	telnet
				172.23.0.145	21/tcp	closed	ftp
				172.23.0.145	22/tcp	open	ssh
				172.23.0.145	23/tcp	open	telnet
				172.23.0.156	21/tcp	open	ftp
				172.23.0.156	22/tcp	closed	ssh
				172.23.0.156	23/tcp	closed	telnet
			*/
			
			if ($resultones['port_status']=="open") {
				
				$resultallopen[] = $resultones;
			}
		}
			/* 	去掉非open
				172.23.0.118	22/tcp	open	ssh
				172.23.0.118	23/tcp	open	telnet
				172.23.0.145	22/tcp	open	ssh
				172.23.0.145	23/tcp	open	telnet
				172.23.0.156	21/tcp	open	ftp
			*/
		//$ip_tmp = '0.0.0.0'; 
		//$param['from_scan'] = '1';
		$arrlen = count($resultallopen);
		//var_dump($resultallopen);

		$paramall = array();
		
		$b = array();
		foreach($resultallopen as $v) {
			if(isset($b[$v['ip']])){
				$b[$v['ip']]['service'] .= $v['port'].":".$v['port_service'].";";
			}
			else{
				$v['service'] = $v['port'].":".$v['port_service'].";";
				$b[$v['ip']] = $v;
			}
		}

			/* 	格式化后
				172.23.0.118	22/tcp	open	ssh  22/tcp:ssh;23/tcp:telnet;
				172.23.0.145	22/tcp	open	ssh  22/tcp:ssh;23/tcp:telnet;
				172.23.0.156	21/tcp	open	ftp  21/tcp:ftp;
			*/
		
		$b = array_values($b);
		print_r($b);
		print_r("---------");
		foreach ($b as $value) {
			
			$param['ip'] = $value['ip'];
			$param['service'] = $value['service'];
			print_r($param);
			if ($param['service'] != '') {
				self::partSyn($param,$syntype);//同步
			}
		}
		unset($_SESSION[CONNECTION.ISUPER]);
		echo 'portsyn ok';
		//资产同步
		/*$param['ip']= '2.2.2.2';
		$param['service'] = '135:msrpc;139:netbios-ssn;445:microsoft-ds;';
		$param['from_scan'] = '1';
		$rspString = getResponse('assets_mgmt', 'add' ,$param);
		$ret = getAssign($rspString, 'assets_mgmt');*/
	}
	function partSyn($allparam,$syntype)
	{
		# code...
		$newparam['ip'] = $allparam['ip'];
		$newparam['address_type'] = $syntype;
		$servarr = explode(";",$allparam['service']); //服务大于80项需要分段传
		$servpartarr = array_chunk($servarr , 80);  
		for($x=0; $x< count($servpartarr); $x++) {

			$newparam['from_scan'] = $x+1;
			$newparam['service'] = implode(";" , $servpartarr[$x]);
			
			$rspString = getResponse('assets_mgmt', 'add' ,$newparam);
			$ret = getAssign($rspString, 'assets_mgmt');
			# code...
		}

	}
}
