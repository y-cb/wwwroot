<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/ospf6_neighbor 查看ospf邻居信息
 * @apiName 查看ospf邻居信息
 * @apiGroup IPv4路由
 *
 *
 * @apiSuccess {String} vrf_name  ospf6邻居所属VRF名称
 * @apiSuccess {String} nbr_id  ospf6邻居id
 * @apiSuccess {Number} priority  ospf6邻居优先级
 * @apiSuccess {String} status  ospf6邻居状态
 * @apiSuccess {String} timeout  ospf6邻居时限
 * @apiSuccess {String} if_addr  发现邻居接口名称
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"vrf_name": "vrf0",
 *			"nbr_id": "1",
 *			"priority": "2",
 *			"status": "",
 *			"timeout": "",
 *			"if_addr": "2.2.2.2"
 *		}
 *	],
 *	"total": 1
 *	}
 */

class RouteOspf3NeighborController extends mController{
	public $module = 'ospf6_neighbor';
}

?>
