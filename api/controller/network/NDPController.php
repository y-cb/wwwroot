<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET} /api/ndp 获取动态NDP表项
 * @apiName 获取动态ARP表项
 * @apiGroup ARP
 *
 *
 * @apiSuccess {Number} ip  IP地址
 * @apiSuccess {String} mac  MAC地址
 * @apiSuccess {String} if_name  接口名称
 * @apiSuccess {String} nud_state  arp表项状态
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ip": "172.16.0.254", 
 *       	"mac": "00:10:f3:4c:04:51", 
 *       	"nud_state": "valid", 
 *       	"if_name": "ge0/0"
 *		},
 *		{
 *	 		"ip": "172.16.0.11", 
 *		 	"mac": "50:7b:9d:8e:63:43", 
 *		 	"nud_state": "valid", 
 *		 	"if_name": "ge0/0"
 *		}
 *	],
 *	"total": 2
 *	}
 */
 
/**
 * @api {DELETE} /api/ndp 删除动态NDP表项
 * @apiName 删除动态ARP表项
 * @apiGroup ARP
 *
 *
 * @apiSuccess {Number} ip  IP地址
 * @apiSuccess {String} if_name  接口名称
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"ip": "1.1.1.6", 
 *		"if_name": "ge0/0" 
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":""
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":""
 *	}
 *
 */


class NDPController extends mController{
	public $module = 'ndp_table';
}

?>
