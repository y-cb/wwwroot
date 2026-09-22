<?php
namespace controller\object;
use controller\mController;

/**
 * @api {GET} /api/root-ca-crl-conf 获取crl证书信息
 * @apiName 获取CA根证书信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} period 周期
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "period":"12",
        }
    ],
    }
 */

class RootCaCrlConfController extends mController {	
	public $module = 'pki_ca_crl_config';
}
