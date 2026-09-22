<?php
namespace controller\object;
use controller\mController;


/**
 * @api {PUT} /api/user-cert-issue 签发证书
 * @apiName 签发证书
 * @apiGroup ca中心
 *
 *
 * @apiParam {String} name 证书名称
 * @apiParam {String} days 有效期
 * @apiParam {String} password 密码
 *
 * @apiParamExample {json} Request-Example:
 *  HTTP/1.1 200 OK
 *  {
 *    "data": [
 *        {
 *            "name": "CACert",
 *            "days": "222",
 *            "password":"111123",
 *        }
 *    ],
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
 *		"code":"非0"
 *	}
 */

class UserCertIssueController extends mController {    
    public $module = 'pki_ca_cert_sign';
}
