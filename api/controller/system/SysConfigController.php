<?php
namespace controller\system;
use controller\mController;


/**
 * @api {PUT}  /api/sysconfig 保存配置
 * @apiName 保存配置
 * @apiGroup 系统设置
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 **/

class SysConfigController extends mController{	
	public $module = 'save_config';
}

