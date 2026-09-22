<?php
namespace controller\policy;
use controller\mController;
use lib\Util;

 /**
 * @api {GET}  /api/ioc-update 获取云端威胁情报情报库情况
 * @apiName ioc-update
 * @apiGroup 威胁情报
 * @apiSuccess {Number} code 错误码
 * @apiSuccessExample {json} Success-Response:
 *
 *
 *  HTTP/1.1 200 OK
 *		{
 *			"code": 0,
 *		}
 *
 *
 * @apiErrorExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *			"code": "1",
 *		}
 */
class IntelligenceIocUpdateController extends mController{
    
    public function get()
    {
        $url = "http://127.0.0.1:77/tiagent/api/iocupdate";
        $result = Util::httpRequest($url,'GET');
        echo json_encode($result);
        return;
    }
}

