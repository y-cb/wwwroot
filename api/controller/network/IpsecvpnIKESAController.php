<?php
namespace controller\network;
use controller\mController;



/**
 * @api {DELETE}  /api/ipsecvpn-ike-sa 删除一阶段SA
 * @apiName 查询一阶段SA
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {Number} sa_id  一阶段SA ID
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"sa_id": "1"
 *	}
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
 *		"code":"100",
 *		"str":""
 *	}
 *
 */


/**
 * @api {get}  /api/ipsecvpn-ike-sa 获取IKE SA策略
 * @apiName 获取IKE SA策略
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} name IKE SA策略名称
 * @apiSuccess {String} dst_address 对端网关
 * @apiSuccess {String} src_address 本地网关
 * @apiSuccess {Number} state 状态，0表示未连接，1表示连接
 * @apiSuccess {String} lifetime 剩余时间
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "aaa",
            "dst_address": "172.16.0.126",
            "src_address": "172.16.0.139",
            "state":"0",
            "lifetime": "3600",
	    "isakmp_sa_id": "4"
        }
    ],
    "total": 1
    }
 */

class IpsecvpnIKESAController extends mController{
	public $module = 'vpn_ikesa';
}

?>
