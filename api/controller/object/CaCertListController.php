<?php
namespace controller\object;
use controller\mController;


/**
 * @api {GET} /api/ca-cert-list 获取用户证书管理列表信息
 * @apiName 获取用户证书管理列表信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} name 证书名称
 * @apiSuccess {String} subject 证书主题
 * @apiSuccess {String} type 类型
 * @apiSuccess {String} state 签发状态
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "CACert",
            "subject": "C=CN,L=esfs,O=erwe,ST=dfsdf,OU=werwe,emailAddress=444@www.com,CN=erew",
            "type":"R",
            "state":"N",
        },
        {
            "name": "aaaa",
            "subject": "C=CN,L=esfs,O=erwe,ST=dfsdf,OU=werwe,emailAddress=444@www.com,CN=erew",
            "type":"R",
            "state":"N",
        }
    ],
    "total":"2"
    }
 */
 
 /**
 * @api {DELETE} /api/ca-cert-list 获取用户证书管理列表信息
 * @apiName 获取用户证书管理列表信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} name 证书名称
 * @apiSuccess {String} subject 证书主题
 * @apiSuccess {String} type 类型
 * @apiSuccess {String} state 签发状态
 *
 * @apiParamExample {json} Request-Example:
 *	{
        "name": "CACert",
        "subject": "C=CN,L=esfs,O=erwe,ST=dfsdf,OU=werwe,emailAddress=444@www.com,CN=erew",
        "type":"R",
        "state":"N",
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"326"
 *	}
 *
 */


class CaCertListController extends mController {	
	public $module = 'pki_ca_cert_list_info';
}
