<?php
namespace controller\statistics;
use controller\mController;

/**
 * @api {GET}  /api/interface-vsys 获取vsys接口信息
 * @apiName 获取vsys接口信息
 * @apiGroup 接口信息
 *
 *
 * @apiSuccess {String} ifname  接口名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ifname": "ge0/1",
 *		},
 *		{
 *			"ifname": "ge0/2",
 *		},
 *		{
 *			"ifname": "ge0/0",
 *		},
 *		{
 *			"ifname": "mgt",
 *		}
 *	],
 *	"total": 4
 *	}
 */

class InterfaceVsysController extends mController{
	public $module = 'vsys_if';
}

