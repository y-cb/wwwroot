<?php
namespace controller\network;
use controller\mController;

/**
 * @api {PUT}  /api/interfaces-status 根据传入的参数修改接口配置
 * @apiName 根据传入的参数修改接口配置
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} ifname  接口名称（别名）
 * @apiSuccess {Number} shut  接口管理状态，1表示打开，0表示关闭
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test2",
 *		"shut": "1",
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"35",
 *		"str":"地址与其它接口地址冲突"
 *	}
 *
 */


class InterfaceStatusController extends mController{
	public $module = 'interface_status';
}

?>
