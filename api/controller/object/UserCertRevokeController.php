<?php
namespace controller\object;
use controller\mController;


/**
 * @api {PUT} /api/user-cert-revoke 撤销证书
 * @apiName 撤销证书
 * @apiGroup ca中心
 *
 *
 * @apiParam {String} name 证书名称
 * @apiParam {String} reason 撤销原因
 *
 * @apiParamExample {json} Request-Example:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "CACert",
            "reason": "2",
        }
    ],
    }
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 */

class UserCertRevokeController extends mController {    
    public $module = 'pki_ca_cert_revoke';
}
