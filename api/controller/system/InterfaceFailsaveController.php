<?php
namespace controller\system;
use controller\mController;

class InterfaceFailsaveController extends mController{
	function get(){
		$data = array();
		$data1=array();
		$param = get_inputs();
		$rspString1 = getResponse( 'tb_vlan', "show_i" , $param );
		$ret1 = getAssign($rspString1, 'tb_vlan',false,true);
		if($ret1['group']){
			for($i=0;$i<count($ret1['group']);$i++){
				$data1[$i]['name'] = $ret1['group'][$i]['vlan_name'];
			}
		}
		$data2=array();
		$rspString2 = getResponse( 'interface_sub', "show" , $param );
		$ret2 = getAssign($rspString2, 'interface_sub',false,true);
		if($ret2['group']){
			for($i=0;$i<count($ret2['group']);$i++){
				if($ret2['group'][$i]['name']!='mgt'){
					$data2[$i]['name'] = $ret2['group'][$i]['name'];
				}
				
			}
		}

		$data['data'] = array_merge($data1,$data2);
		echo json_encode($data);
	}
	
}

?>
