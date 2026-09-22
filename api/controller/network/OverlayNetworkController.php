<?php
namespace controller\network;
use controller\mController;
use lib\Util;

/**
 * @api {GET}  /api/overlay-network 查询overlay网关配置(该版本不支持该接口)
 * @apiName 查询overlay网关配置
 * @apiGroup Overlay网关
 *
 *
 * @apiSuccess {Number} enable  overlay网关功能开关
 * @apiSuccess {Number} type  目前只支持vxlan封装
 * @apiSuccess {String} vtep_addr  VTEP地址
 * @apiSuccess {Number} vtep_port  VTEP端口  
 * @apiSuccess {String} cont_addr  Controller地址
 * @apiSuccess {Number} cont_port  Controller端口
 * @apiSuccess {Number} fresh_timer  刷新时间
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *
 *		{
 *			"enable": "1",
 *			"type": "1",
 *			"vtep_addr": "1.1.1.1",
 *			"vtep_port": "8848",
 *			"cont_addr": "2.2.2.2",
 *			"cont_port": "2322",
 *			"fresh_timer": "22"
 *		}
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/overlay-network 修改overlay网关配置(该版本不支持该接口)
 * @apiName 修改overlay网关配置
 * @apiGroup Overlay网关
 *
 *
 * @apiParam {Number} enable  overlay网关功能开关
 * @apiParam {Number} type  目前只支持vxlan封装
 * @apiParam {String} vtep_addr  VTEP地址
 * @apiParam {Number} vtep_port  VTEP端口  
 * @apiParam {String} cont_addr  Controller地址
 * @apiParam {Number} cont_port  Controller端口
 * @apiParam {Number} fresh_timer  刷新时间
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"enable": "1",
 *		"type": "1",
 *		"vtep_addr": "1.1.1.1",
 *		"vtep_port": "8848",
 *		"cont_addr": "2.2.2.2",
 *		"cont_port": "2322",
 *		"fresh_timer": "22"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


class OverlayNetworkController extends mController{
	public $module = 'overlay_config';
	function post(){
		$$param = get_inputs();
		$get_port = $param['port'];
		$get_ip = $param['ip'];
		$get_state = $param['getall_state'];
		if($get_state=="true"){
			$url = "https://".$get_ip.":".$get_port."/opc/overlay/info?getall=true";
		}
		else{
			$url="https://".$get_ip.":".$get_port."/opc/overlay/info?getall=false";
		}
		$https_info = Util::get_https($url);
		if(isset($https_info)){
			$https_arr=json_decode($https_info, true); 
			if($https_arr['data']['change']=="true"){
				$param['change']=1;
			}
			else{
				$param['change']=0;
			}
			$param['vmnum'] = $https_arr['data']['vmnum'];
			$param['version_id'] = $https_arr['data']['version_id'];

			foreach($https_arr['data']['data'] as $https_data){
				if($https_data['state']=="add"){
					$https_data['state']=1;
				}
				else{
					$https_data['state']=2;
				}
				$https_data_arr[] = $https_data;
			}
			$param['vm'] = $https_data_arr;
			$rspString = getResponse($this->module, "add" ,$param);
			$ret_param_sslvpn_user_bind = getAssign($rspString,$this->module);


		}
	}
}

?>