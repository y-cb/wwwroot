<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET}  /api/ssl-virtul-address 获取虚地址
 * @apiName 获取虚地址
 * @apiGroup SSL卸载
 *
 *
 * @apiSuccess {Number} iptype ip地址类型
 * @apiSuccess {String} addr IP地址
 * @apiSuccess {Number} unit_id 单元id
 * @apiSuccess {Number} enable 是否使能
 * @apiSuccess {Number} advertise_type 默认1
 * @apiSuccess {Number} arp 默认0
 * @apiSuccess {Number} route_advertise 默认0
 * @apiSuccess {Number} status 地址状态
 * @apiSuccess {Number} ref 虚地址引用计数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"iptype": "0",
 *		"addr": "5.6.7.8",
 *		"unit_id": "1",
 *		"enable": "0",
 *		"advertise_type": "1",
 *		"arp": "0",
 *		"route_advertise": "0",
 *		"status": "3",
 *		"ref": "0",
 *	}
 *	
 *	
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
		"total": 1, 
		"data": [
		{
			"arp": "0", 
			"status": "4", 
			"enable": "0", 
			"iptype": "0", 
			"unit_id": "1", 
			"route_advertise": "0", 
			"advertise_type": "1", 
			"ref": "1", 
			"addr": "5.6.7.8"
		}
		]

 *	}
 */


/**
 * @api {PUT}  /api/ssl-virtul-address 修改虚拟地址信息
 * @apiName 修改虚拟地址信息
 * @apiGroup SSL卸载 
 *
 *
 * @apiSuccess {Number} iptype ip地址类型
 * @apiSuccess {String} addr IP地址
 * @apiSuccess {Number} unit_id 单元id
 * @apiSuccess {Number} enable 是否使能
 * @apiSuccess {Number} advertise_type 默认1
 * @apiSuccess {Number} arp 默认0
 * @apiSuccess {Number} route_advertise 默认0
 * @apiSuccess {Number} status 地址状态
 * @apiSuccess {Number} ref 虚地址引用计数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"iptype": "0",
 *		"addr": "5.6.7.8",
 *		"unit_id": "1",
 *		"enable": "1",
 *		"advertise_type": "1",
 *		"arp": "0",
 *		"route_advertise": "0",
 *		"status": "3",
 *		"ref": "0",
 *	}
 *
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
 *		"code":"非0",
 *		"str":"对应的错误提示信息"
 *	}
 *
 */



class SSLVirtulAddressController extends mController {	
	public $module = 'vaddr_config';
}
