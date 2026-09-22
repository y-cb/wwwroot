<?php
namespace controller\policy;
use controller\mController;
use lib\Util;

 /**
 * @api {GET}  /api/register 设备注册云端威胁情报中心（弃用）
 * @apiName register
 * @apiGroup 威胁情报
 *
 *
 * @apiSuccess {Number} code 错误码
 * @apiSuccess {String} message 错误信息
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *		{
 *			"code": 0,
 *			"message": "",
 *		}
 *
 * @apiErrorExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *		{
 *			 "code": "1",
 *			"lastuptime": "错误信息",
 *		}
 */

class IntelligenceRegisterController extends mController{
    public function get()
    {
        $url = "http://127.0.0.1:77/tiagent/api/register";
        $result = Util::httpRequest($url,'GET');
        echo json_encode($result);
        return;
    }
}

