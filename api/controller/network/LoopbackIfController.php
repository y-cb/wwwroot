<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/interface-loopback 获取环回接口的名称信息
 * @apiName 获取环回接口的名称信息
 * @apiGroup 接口配置
 *
 *
 * @apiSuccess {String} interface_name  接口名称信息
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"interface_name": "lo"
 *		},
 *	],
 *	"total": 1
 *	}
 */


class LoopbackIfController extends mController{
	public $module = 'tb_special_interface';
}
