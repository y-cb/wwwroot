<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/ha-trunk 获取HA状态信息
 * @apiName 获取HA状态信息
 * @apiGroup 高可靠性
 *
 *
 * @apiSuccess {String} local_name  本地设备名称
 * @apiSuccess {String} peer_name  对端设备名称
 * @apiSuccess {Number} local_status  本地HA状态 0：备状态 1：主状态 
 * @apiSuccess {Number} peer_status  对端HA状态
 * @apiSuccess {Number} local_moncnt  本地故障统计
 * @apiSuccess {Number} peer_moncnt  对端故障通知
 * @apiSuccess {Number} soft_version  软件版本
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"local_name": "host",
 *			"peer_name": "host",
 *			"local_status": "1",
 *			"peer_status": "5",
 *			"local_moncnt": "0",
 *			"peer_moncnt": "0",
 *			"soft_version": "3"
 *	}
 */


class HaTrunkMonitorController extends mController {	
	public $module = 'ha_status_all';
	function get(){
		$param = get_inputs();
		$rspString = getResponse( $this->module, "show" , $param );
		$ret = getAssign($rspString, $this->module, 0);
		$data=array();
		
		if($ret['group'][0]['trunk_monitor']!=""){
			if(count($ret['group'][0]['trunk_monitor'])==1 && $ret['group'][0]['trunk_monitor']['group']['name']){
				$data['data'][0]['name']=$ret['group'][0]['trunk_monitor']['group']['name'];
				$data['data'][0]['mem_cnt']=$ret['group'][0]['trunk_monitor']['group']['mem_cnt'];
				$data['data'][0]['threshold']=$ret['group'][0]['trunk_monitor']['group']['threshold'];
				$data['data'][0]['act_cnt']=$ret['group'][0]['trunk_monitor']['group']['act_cnt'];
				$data['data'][0]['status']=$ret['group'][0]['trunk_monitor']['group']['status'];
				$data['total']=1;			
			}else{		
				$num = count($ret['group'][0]['trunk_monitor']['group']);			
				for($i=0;$i<$num;$i++){
				 	$data['data'][$i]['name']=$ret['group'][0]['trunk_monitor']['group'][$i]['name'];
					$data['data'][$i]['mem_cnt']=$ret['group'][0]['trunk_monitor']['group'][$i]['mem_cnt'];
					$data['data'][$i]['threshold']=$ret['group'][0]['trunk_monitor']['group'][$i]['threshold'];
					$data['data'][$i]['act_cnt']=$ret['group'][0]['trunk_monitor']['group'][$i]['act_cnt'];
					$data['data'][$i]['status']=$ret['group'][0]['trunk_monitor']['group'][$i]['status'];
				}
				$data['total']=$num;
			}
		}
		
		echo json_encode($data);	
		
		return;
	}
}
