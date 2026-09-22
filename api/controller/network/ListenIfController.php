<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/listen-interface 查询旁路部署配置
 * @apiName 查询旁路部署配置
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} name  接口名称
 * @apiSuccess {String} listen_mode  旁路功能开关  enable/disable
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "ge0/1",
 *			"listen_mode": "enable"
 *		},
 *		{
 *			"name": "ge0/2",
 *			"listen_mode": "disable"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {PUT}  /api/listen-interface 修改旁路部署配置
 * @apiName 修改旁路部署配置
 * @apiGroup 接口配置
 *
 *
 * @apiParam {String} name  接口名称
 * @apiParam {String} listen_mode  旁路功能开关, enable/disable
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "ge0/1",
 *		"listen_mode": "disable"
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


class ListenIfController extends mController{
	public $module = 'interface_listen';
}

?>
