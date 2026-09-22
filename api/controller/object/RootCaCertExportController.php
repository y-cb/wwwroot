<?php
namespace controller\object;
use controller\mController;



/**
 * @api {GET} /api/root-ca-cert-exp 导出CA根证书信息
 * @apiName 导出CA根证书信息
 * @apiGroup ca中心
 *
 *
 * @apiSuccess {String} name 名称
 * @apiSuccess {String} cert_file_content 证书内容
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
    {
    "data": [
        {
            "name": "CACert",
            "cert_file_content":"LS0tLS1CRUdJTiBDRVJUSUZJQ0FURS0tLS0tCk1JSUNpVENDQWZLZ0F3SUJBZ0lKQUswbEJWUE9wOHJZTUEwR0NTcUdTSWIzRFFFQkJRVUFNSFF4Q3pBSkJnTlYKQkFZVEFrTk9NVll3REFZRFZRUUtFd1ZzWVhabGNqQU1CZ05WQkFzVEJYZGxZblZwTUE0R0ExVUVCeE1IWW1WcAphbWx1WnpBT0JnTlZCQWdUQjJKbGFXcHBibWN3R0FZSktvWklodmNOQVFrQkZnc3hNVEZBTWpJeUxtTnZiVEVOCk1Bc0dBMVVFQXhNRWFHaG9hREFlRncweE9EQTBNVGd4TWpBMU1qSmFGdzB4T0RBMU1UQXhNakExTWpKYU1IUXgKQ3pBSkJnTlZCQVlUQWtOT01WWXdEQVlEVlFRS0V3VnNZWFpsY2pBTUJnTlZCQXNUQlhkbFluVnBNQTRHQTFVRQpCeE1IWW1WcGFtbHVaekFPQmdOVkJBZ1RCMkpsYVdwcGJtY3dHQVlKS29aSWh2Y05BUWtCRmdzeE1URkFNakl5CkxtTnZiVEVOTUFzR0ExVUVBeE1FYUdob2FEQ0JuekFOQmdrcWhraUc5dzBCQVFFRkFBT0JqUUF3Z1lrQ2dZRUEKeWMrV3lHRitZbFIzUThHajhvemJRWUdxQm1KbTcyRXhsOUdnZXpUMGRlZVBOZ2FoV3kyeU5UNHJJRU84L29XWApaMm9kcjJDZllkajlGaDViUHU0RlpXVUFWc0VVcSt6Zldoc21OTlc3N2RVaTk2T3ErUmIreWpoNFRtUmY4NS82CkU4eFoyR2thcGxyREowME5tTmRmR3Z2WUdsY1pYc0oxMDZJc1ZOblZ3NU1DQXdFQUFhTWpNQ0V3RHdZRFZSMFQKQVFIL0JBVXdBd0VCL3pBT0JnTlZIUThCQWY4RUJBTUNBWVl3RFFZSktvWklodmNOQVFFRkJRQURnWUVBb3dBdwplazFIdCtFUFIwRUtRL0pRZzJHUVNRSjVUeGlsZzJGOWI5Z3VjYVdoejFuc1Bkbm9VZHd0MGxWVXlGdEptZzlKCnpLb054TXh2eTU5dUdjbWhTTVRNbmhlMkkrQXh2TGZLSDJBTCtVVUJVMmd6REtBaGdZdmdHL0drQ0N4dkdpcFcKS0FqVGxBQ1lqaGRYUTRYRDlEWUg1NFdHaEg3aitndWZUVEs1c2hFPQotLS0tLUVORCBDRVJUSUZJQ0FURS0tLS0tCg=="
        }
    ],
    }
 */

class RootCaCertExportController extends mController {	
	public $module = 'pki_ca_cacert_export';
	/*function get(){
		$param = get_inputs();
		var_dump($param);exit(0);
	}*/
}
