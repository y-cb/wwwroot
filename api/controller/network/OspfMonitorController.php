<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ospf-monitor 查看ospf邻居信息
 * @apiName 查看ospf邻居信息
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} vrf_name  ospf邻居所属VRF名称
 * @apiSuccess {String} nbr_id  ospf邻居id
 * @apiSuccess {String} nbr_addr  ospf邻居地址
 * @apiSuccess {Number} priority  ospf邻居优先级
 * @apiSuccess {String} status  ospf邻居状态
 * @apiSuccess {String} timeout  ospf邻居时限
 * @apiSuccess {String} if_addr  发现邻居接口名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"nbr_id": "1",
 *			"nbr_addr": "1.1.1.1",
 *			"priority": "2",
 *			"status": "",
 *			"timeout": "",
 *			"if_addr": "2.2.2.2"
 *		}
 *	],
 *	"total": 1
 *	}
 */

class OspfMonitorController extends mController{
	public $module = 'ospf_neighbor';
}

?>
