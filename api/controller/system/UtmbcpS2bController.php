<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/utmbcp-s2b 从备份配置文件恢复配置
 * @apiName 从备份配置文件恢复配置
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


class UtmbcpS2bController extends mController{
	public $module = 'utmbcp_s2b';
}
