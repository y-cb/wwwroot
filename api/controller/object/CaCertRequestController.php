<?php
namespace controller\object;
use controller\mController;


/**
 * @api {get} /api/ca-cert-req 获取CA根证书信息
 * @apiName 获取CA根证书信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} unit 部门
 * @apiSuccess {String} org 组织
 * @apiSuccess {String} location 位置
 * @apiSuccess {String} state 州/省
 * @apiSuccess {String} country 国家
 * @apiSuccess {String} e_mail 电子邮件
 * @apiSuccess {String} days 有效期
 * @apiSuccess {String} key_length 秘钥大小
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "CACert",
            "unit": "aaa",
            "org":"ccc",
            "location":"beijing",
            "state":"beijing",
            "country":"CN",
            "e_mail":"222@222.COM",
            "days": "33",
            "key_length":"1024"
        }
    ],
    }
 */

class CaCertRequestController extends mController {	
	public $module = 'pki_ca_carequest_info';
}
