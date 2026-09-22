<?php
namespace controller\system;
use controller\mController;


/**
* @api {get} /api/vrf 获取虚拟系统
 * @apiName 虚拟系统名称
 * @apiGroup 获取虚拟系统
 *
 *
 */

/**
 * @api {POST} /api/vrf 新建虚拟系统
 * @apiName 虚拟系统名称
 * @apiGroup 新建虚拟系统
 *
 *
 * @apiSuccess {String} vrf_name 虚拟系统名称
 * @apiSuccess {String} vrf_ifname_items 虚拟系统接口数组
 * @apiSuccess {String} ifname 虚拟系统接口名称
 * @apiSuccess {String} desc 描述
 *
* @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vsys_1",
 
 *		"vrf_ifname_items": [
 *		{
 *			"ifname"ge0/3",
 *		},
 *		{
 *			"ifname"ge0/4",
 *		}
 *		],
 *			"desc": "vsys_1",
 *		}
 *	],
 *	"total": 1
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
 * @api {PUT} /api/vrf 修改虚拟系统
 * @apiName 虚拟系统名称
 * @apiGroup 修改虚拟系统
 *
 *
 * @apiSuccess {String} vrf_name 虚拟系统名称
 * @apiSuccess {String} vrf_ifname_items 虚拟系统接口数组
 * @apiSuccess {String} ifname 虚拟系统接口名称
 * @apiSuccess {String} desc 描述
 *
* @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vsys_1",
 
 *		"vrf_ifname_items": [
 *		{
 *			"ifname"ge0/2",
 *		},
 *		{
 *			"ifname"ge0/1",
 *		}
 *		],
 *			"desc": "vsys_2",
 *		}
 *	],
 *	"total": 1
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

/**
  * @api {DELETE} /api/vrf 删除虚拟系统
 * @apiName 虚拟系统名称
 * @apiGroup 删除虚拟系统
 *
 * @apiSuccess {String} vrf_name 虚拟系统名称
 * @apiSuccess {String} vrf_ifname_items 虚拟系统接口数组
 * @apiSuccess {String} ifname 虚拟系统接口名称
 * @apiSuccess {String} desc 描述
 *
* @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vsys_1",
 
 *		    "vrf_ifname_items": [
 *		    {
 *				"ifname"ge0/2",
 *			},
 *			{
 *				"ifname"ge0/1",
 *			}
 *			],
 *			"desc": "vsys_2",
 *		}
 *	],
 *	"total": 1
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"Success!"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"0",
 *		"str":"Error!"
 *	}
 *
 */

class VRFController extends mController{	
	public $module = 'vrf';
}

