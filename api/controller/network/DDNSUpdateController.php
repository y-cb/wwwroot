<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ddns
 * @apiName 
 * @apiGroup DDNS
 *
 *
 * @apiSuccess {String} ipaddr  IP地址
 * @apiSuccess {String} macaddr  MAC地址
 * @apiSuccess {String} start_time  地址租赁起始时间
 * @apiSuccess {String} end_time  地址租赁截止时间
 * @apiSuccess {String} ifname  客户端对应的接口名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"ipaddr": "1.1.1.1",
 *			"macaddr": "00:db:df:ad:fc:9b",
 *			"start_time": "2018-01-01 00-00-00",
 *			"end_time": "2018-01-01 12-59-59",
 *			"ifname": "ge0/1"
 *		},
 *		{
 *			"ipaddr": "2.2.2.2",
 *			"macaddr": "00:db:de:ad:fc:9b",
 *			"start_time": "2018-02-02 00-00-00",
 *			"end_time": "2018-02-02 12-59-59",
 *			"ifname": "ge0/2"
 *		}
 *	],
 *	"total": 2
 *	}
 */


class DDNSUpdateController extends mController{
	public $module = 'ddns_update_table';
}

?>