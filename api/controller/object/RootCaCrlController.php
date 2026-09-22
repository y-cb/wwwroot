<?php
namespace controller\object;
use controller\mController;


/**
 * @api {GET} /api/root-ca-crl 获取crl证书信息
 * @apiName 获取CA根证书信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} issuer 发行者
 * @apiSuccess {String} start_time 有效起始
 * @apiSuccess {String} end_time 有效终止
 * @apiSuccess {String} version 版本
 * @apiSuccess {String} serial 序列号
 * @apiSuccess {String} ext_info 扩展
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "issuer":"C=CN,L=esfs,O=erwe,ST=dfsdf,OU=werwe,emailAddress=444@www.com,CN=erew",
            "start_time":"Apr 18 08:58:59 2018 GMT",
            "end_time":"Nov 26 08:58:59 2018 GMT",
            "version":"C=CN,L=esfs,O=erwe,ST=dfsdf,OU=werwe,emailAddress=444@www.com,CN=erew",
            "serial":"CF4732923449EA94",
            "ext_info": "X509v3 Basic Constraints:&#xD;CA:TRUE&#xD;X509v3 Key Usage:&#xD;Digital Signature, Certificate Sign, CRL Sign&#xD;",
        }
    ],
    }
 */

class RootCaCrlController extends mController {	
	public $module = 'pki_ca_crl_info';
}
