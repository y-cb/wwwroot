<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/net-lte-connect 获取LTE连接状态
 * @apiName 获取LTE连接状态
 * @apiGroup LTE
 *
 *
 *
 * @apiSuccess {String} lte_connect_flags LTE连接状态，1:连接；2:断开；
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * 		"data": [
 *		{
 *			"lte_connect_flags": "0"
 *		}
 *  ],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/net-lte-connect 修改LTE连接状态
 * @apiName 修改LTE连接状态
 * @apiGroup LTE
 *
 *
 *
 * @apiSuccess {String} lte_connect_flags LTE连接状态，1:连接；2:断开；
 *
 * 
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * 		"lte_connect_flags": "0"
 * }
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"100",
 *		"str":""
 *	}
 *
 */

class NetLTEConController extends mController{
	public $module = 'net_lte_connect';
}

?>
