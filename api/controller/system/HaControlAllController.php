<?php
namespace controller\system;
use controller\mController;

/**
 * @api {put}  /api/ha-control-all 监控配置
 * @apiName 监控配置
 * @apiGroup 高可靠性
 *
 * @apiSuccess {Number} sync_action  是否同步配置到对端，1表示开启，0表示关闭
 * @apiSuccess {Number} swap_action  是否主备切换，1表示开启，0表示关闭
 * @apiSuccess {Number} sync_detect_action  是否检测配置，1表示开启，0表示关闭
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"local_name": "host",
 *			"peer_name": "host",
 *			"local_status": "1",
 *			"peer_status": "5",
 *			"local_moncnt": "0",
 *			"peer_moncnt": "0",
 *			"soft_version": "3"
 *	}
 */

class HaControlAllController extends mController {	
	public $module = 'ha_control_all';
}
