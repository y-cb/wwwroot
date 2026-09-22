<?php
namespace controller\system;
use controller\mController;


/**
 * @api {GET}  /api/utmbcp-b2s 配置文件备份
 * @apiName 配置文件备份
 * @apiGroup 系统设置
 *
 * @apiSuccess {Number} index 索引值，不需要填充信息
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [],
 *	 "total": 0
 *	}
 */

class UtmbcpB2sController extends mController{
	public $module = 'utmbcp_b2s';
}
