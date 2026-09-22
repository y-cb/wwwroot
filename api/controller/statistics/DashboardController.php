<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {get}  /api/dashboard 获取首页显示配置项
 * @apiName 获取首页显示配置项
 * @apiGroup 首页
 *
 *
 * @apiSuccess {String} name 用户名
 * @apiSuccess {Object} data 首页配置项信息
 * @apiSuccess {Number} sys_basic_info 基本信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} traffic_info 实时流量信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} sys_info 系统信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} license_info 授权信息显示，0表示不启用，1表示启用
 * @apiSuccess {Number} user_info 用户流量排名显示，0表示不启用，1表示启用
 * @apiSuccess {Number} admin_info 在线管理员显示，0表示不启用，1表示启用
 * @apiSuccess {Number} app_info 应用流量排行显示，0表示不启用，1表示启用
 * @apiSuccess {Number} syslog_info 系统日志显示，0表示不启用，1表示启用
 * @apiSuccess {Number} appcate_info 应用分类显示，0表示不启用，1表示启用
 * @apiSuccess {Number} seclog_info 安全日志显示，0表示不启用，1表示启用
 * @apiSuccess {Number} ips_info 攻击事件统计显示，0表示不启用，1表示启用
 * @apiSuccess {Number} av_info 病毒事件统计显示，0表示不启用，1表示启用
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
        	"name": "admin",
        	"data":{
				"sys_basic_info": "1",
            	"traffic_info": "1",
            	"sys_info": "1",
            	"license_info": "1",
            	"user_info": "1",
            	"admin_info": "1",
            	"app_info": "1",
            	"appcate_info": "1",
            	"syslog_info": "1",
            	"seclog_info": "0",
				"ips_info": "0",
            	"av_info": "0",
        	}
            
        }
    ],
    }
 */

/**
 * @api {PUT}  /api/dashboard 修改首页显示配置项
 * @apiName 修改首页显示配置项
 * @apiGroup 首页
 *
 *
 * @apiParam {String} name 用户名
 * @apiParam {Object} data 首页配置项信息
 * @apiParam {Number} sys_basic_info 基本信息显示，0表示不启用，1表示启用
 * @apiParam {Number} traffic_info 实时流量信息显示，0表示不启用，1表示启用
 * @apiParam {Number} sys_info 系统信息显示，0表示不启用，1表示启用
 * @apiParam {Number} license_info 授权信息显示，0表示不启用，1表示启用
 * @apiParam {Number} user_info 用户流量排名显示，0表示不启用，1表示启用
 * @apiParam {Number} admin_info 在线管理员显示，0表示不启用，1表示启用
 * @apiParam {Number} app_info 应用流量排行显示，0表示不启用，1表示启用
 * @apiParam {Number} syslog_info 系统日志显示，0表示不启用，1表示启用
 * @apiParam {Number} appcate_info 应用分类显示，0表示不启用，1表示启用
 * @apiParam {Number} seclog_info 安全日志显示，0表示不启用，1表示启用
 * @apiParam {Number} ips_info 攻击事件统计显示，0表示不启用，1表示启用
 * @apiParam {Number} av_info 病毒事件统计显示，0表示不启用，1表示启用
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "admin",
    	"data":{
			"sys_basic_info": "1",
        	"traffic_info": "1",
        	"sys_info": "1",
        	"license_info": "1",
        	"user_info": "1",
        	"admin_info": "1",
        	"app_info": "1",
        	"appcate_info": "1",
        	"syslog_info": "1",
        	"seclog_info": "0",
			"ips_info": "0",
        	"av_info": "0",
    	}
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 */

class DashboardController extends mController {	
	public $dir_file = '/tmp/webui/dashboard.json';
	function get(){
		if(file_exists($this->dir_file)){
			$content = file_get_contents($this->dir_file); 
			$json = json_decode($content,true);		 
		}else{ 
			 $json = '{"msg":"The file does not exist."}'; 
		}  
		echo json_encode($json);
	}
	function put(){
		$input = get_inputs();
		
		if($input['data']){
			foreach($input['data'] as $key=> $val){
				if($key!='lang' && $key!='interval_time_change'){
					if($val!='0' && $val!='1'){
						$ret = array('code'=>'-10','str'=>t('login.input_data_err'));
						echo json_encode($ret);
						return;
					}
				}
			}
		}
		if($input['data_ips']){
			foreach($input['data_ips'] as $key=> $val){
				if($key!='lang' && $key!='interval_time_change'){
					if($val!='0' && $val!='1'){
						$ret = array('code'=>'-10','str'=>t('login.input_data_err'));
						echo json_encode($ret);
						return;
					}
				}
			}
		}
		if($input['data_avg']){
			foreach($input['data_avg'] as $key=> $val){
				if($key!='lang' && $key!='interval_time_change'){
					if($val!='0' && $val!='1'){
						$ret = array('code'=>'-10','str'=>t('login.input_data_err'));
						echo json_encode($ret);
						return;
					}
				}
			}
		}
		if($input['data_acg']){
			foreach($input['data_acg'] as $key=> $val){
				if($key!='lang' && $key!='interval_time_change'){
					if($val!='0' && $val!='1'){
						$ret = array('code'=>'-10','str'=>t('login.input_data_err'));
						echo json_encode($ret);
						return;
					}
				}
			}
		}
		
		$content = file_get_contents($this->dir_file);
		$content_arr = json_decode($content);
		$new_json_arr = array();
		$new_name_arr = array();
		foreach ($content_arr as $key => $value) {
			if($value->name == $input['name']){
				if($input['data']){
					$value->data = $input['data'];	
				}
				if($input['data_ips']){
					$value->data_ips = $input['data_ips'];	
				}
				if($input['data_avg']){
					$value->data_avg = $input['data_avg'];	
				}
				if($input['data_acg']){
					$value->data_acg = $input['data_acg'];	
				}
				
			}
			$new_name_arr[] = $value->name;
			$new_json_arr[] = $value;
		}
		$change_data = $input['data'];
		if($input['data_ips']){
			$change_data = $input['data_ips'];
		}
		if($input['data_avg']){
			$change_data = $input['data_avg'];
		}
		if($input['data_acg']){
			$change_data = $input['data_acg'];
		}
		$new_input_arr = array(array("name"=>$input['name'],"data"=>$change_data,"data_avg"=>$change_data,"data_ips"=>$change_data,"data_acg"=>$change_data));
		if(!in_array($input['name'],$new_name_arr)){
			$new_json_arr = array_merge($new_json_arr, $new_input_arr);
		}
		$json = json_encode($new_json_arr,true);
		if(file_exists($this->dir_file)){
			file_put_contents($this->dir_file,$json);
			echo "ok"; 
		}
	}
}
