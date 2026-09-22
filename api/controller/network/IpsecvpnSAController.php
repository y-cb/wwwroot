<?php
namespace controller\network;
use controller\mController;


/**
 * @api {DELETE}  /api/ipsecvpn-sa 删除指定ipsec二阶段sa
 * @apiName 删除指定ipsec二阶段sa
 * @apiGroup IPsec-VPN
 *
 *
 * @apiParam {Number} sa_id  二阶段sa id
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
 * @api {get}  /api/ipsecvpn-sa 获取IPsec SA策略
 * @apiName 获取IPsec SA策略
 * @apiGroup IPsec-VPN
 *
 *
 * @apiSuccess {String} tunnel_name IPsec SA策略名称
 * @apiSuccess {Number} ipsec_sa_id IPsec SA策略id
 * @apiSuccess {String} peer 对端网关
 * @apiSuccess {String} local 本地网关
 * @apiSuccess {Number} state 状态，0表示未连接，1表示连接
 * @apiSuccess {String} timeout 剩余时间/流量
 * @apiSuccess {String} in_out_bytes 流量(入/出KB)
 * @apiSuccess {String} local_client 源网络
 * @apiSuccess {String} remote_client 目的网络
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "ipsec_sa_id": "1165",
            "tunnel_name": "aaa",
            "peer": "172.16.0.126",
            "local": "172.16.0.139",
            "state":"0",
            "timeout": "35s/0KB",
            "in_out_bytes": "0/0",
            "local_client": "0.0.0.0/0",
            "remote_client": "0.0.0.0/0",
        }
    ],
    "total": 1
    }
 */

class IpsecvpnSAController extends mController{
	public $module = 'vpn_ipsecsa';
}

?>
