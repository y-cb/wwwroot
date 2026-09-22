<?php
namespace controller\object;
use controller\mController;


/**
 * @api {GET} /api/root-ca-crl-exp 导出CRL信息
 * @apiName 导出CRL信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} content 证书内容
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "cacrl.crl",
            "content":"MIIB4jCCAUsCAQEwDQYJKoZIhvcNAQEFBQAwdDELMAkGA1UEBhMCQ04xVjAMBgNVBAoTBWxhdmVyMAwGA1UECxMFd2VidWkwDgYDVQQHEwdiZWlqaW5nMA4GA1UECBMHYmVpamluZzAYBgkqhkiG9w0BCQEWCzExMUAyMjIuY29tMQ0wCwYDVQQDEwRoaGhoFw0xODA0MTkwMzQxMzRaFw0xODA1MDYwMzQxMzRaoIGiMIGfMAoGA1UdFAQDAgEBMIGQBgNVHSMEgYgwgYWheKR2MHQxCzAJBgNVBAYTAkNOMVYwDAYDVQQKEwVsYXZlcjAMBgNVBAsTBXdlYnVpMA4GA1UEBxMHYmVpamluZzAOBgNVBAgTB2JlaWppbmcwGAYJKoZIhvcNAQkBFgsxMTFAMjIyLmNvbTENMAsGA1UEAxMEaGhoaIIJAK0lBVPOp8rYMA0GCSqGSIb3DQEBBQUAA4GBAIKk8sWNnHCyD0WbpY0MZfdQB9AQSaT+kTD+6cr5A4eLOjMSacT34f7oohQ7rKPVt2dz6FZxZscVuYU0uBA+vUihGmfUsZt9GOmMVyndykEtdpV54rfFHbSplCx3jvqlVnY3Vgi1rxkcBME9+JyH/vmc3Jzviz0+SpQ6FkF4/Je4=="
        }
    ],
    }
 */

class RootCaCrlExportController extends mController {	
	public $module = 'pki_ca_crl_export';
}
