<?php
namespace controller\object;
use controller\mController;

/**
 * @api {POST} /api/user-cert-req 生成用户证书信息
 * @apiName 生成用户证书信息
 * @apiGroup ca中心
 *
 *
 * @apiParam {String} name  证书的名称
 * @apiParam {String} unit  证书的部门
 * @apiParam {String} org  证书的组织
 * @apiParam {String} location  城市信息
 * @apiParam {String} state  州/省信息
 * @apiParam {String} country  国家/地区信息
 * @apiParam {String} e_mail  电子邮件信息
 * @apiParam {Number} key_length  秘钥长度
 *
 * @apiParamExample {json} Request-Example:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "CACert",
            "unit": "sunyainfo",
            "org":"R",
            "location":"N",
            "state":"N",
            "country":"CN",
            "e_mail":"222@111.com",
            "key_length":"1024",
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

class UserCertRequestController extends mController {	
	public $module = 'pki_ca_request_info';
}
