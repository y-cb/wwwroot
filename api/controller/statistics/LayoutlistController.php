<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {get}  /api/layoutlist 获取首页位置信息
 * @apiName 获取首页首页位置信息
 * @apiGroup 首页
 *
 *
 * @apiSuccess {Number} id 模块名称
 * @apiSuccess {Number} span 模块宽度
 * @apiSuccess {Number} hasFullScreen 全屏按钮，0表示不显示，1表示显示
 * @apiSuccess {Number} chartType 图表切换图标，0表示table，1表示charts
 * @apiSuccess {Number} hasRefresh 刷新按钮，1表示显示
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
        	{id:'sys_basic',span:12},
        	{id:'traffic',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
        	{id:'ips',span:12,hasFullScreen:1},
        	{id:'av',span:12,hasFullScreen:1},
        	{id:'sys',span:6},
        	{id:'license',span:6},
        	{id:'userflow',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
        	{id:'admin',span:12},
        	{id:'apptop',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
        	{id:'seclog',span:12},
        	{id:'appcate',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
        	{id:'syslog',span:12}
            
        }
    ],
    }
 */

/**
 * @api {PUT}  /api/layoutlist 修改首页位置信息
 * @apiName 修改首页位置信息
 * @apiGroup 首页
 *
 *
 * @apiParam {Number} id 模块名称
 * @apiParam {Number} span 模块宽度
 * @apiParam {Number} hasFullScreen 全屏按钮，0表示不显示，1表示显示
 * @apiParam {Number} chartType 图表切换图标，0表示table，1表示charts
 * @apiParam {Number} hasRefresh 刷新按钮，1表示显示
 * 
 * @apiParamExample {json} Request-Example:
 *	{
 		[
	 		{id:'sys_basic',span:12},
	        {id:'traffic',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
	        {id:'ips',span:12,hasFullScreen:1},
	        {id:'av',span:12,hasFullScreen:1},
	        {id:'sys',span:6},
	        {id:'license',span:6},
	        {id:'userflow',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
	        {id:'admin',span:12},
	        {id:'apptop',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
	        {id:'seclog',span:12},
	        {id:'appcate',span:12,hasFullScreen:1,chartType:1,hasRefresh:1},
	        {id:'syslog',span:12}
        ]
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 */

class LayoutlistController extends mController {	
	public $dir_file = '/tmp/webui/layoutList.json';
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
		$json = json_encode($input,true);
		if(file_exists($this->dir_file)){
			file_put_contents($this->dir_file,$json);
			echo "ok"; 
		}
	}
}
