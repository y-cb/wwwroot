<?php
namespace controller\policy;
use controller\mController;
use lib\Util;

 /**
 * @api {GET}  /api/ioc-lasttime 获取云端威胁情报最近一次升级时间
 * @apiName ioc-lasttime
 * @apiGroup 威胁情报
 *
 *
 * @apiSuccess {Number} code 错误码
 * @apiSuccess {String} lastuptime 最近一次升级时间
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *		{
 *			"code": 0,
 *			"lastuptime": "20220225.2028",
 *		}
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *		{
 *			"code": 1,
 *			"lastuptime": "20220225.2028",
 *		}
 */
class IntelligenceIocLasttimeController extends mController{
    
    public function get()
    {
        $url = "http://127.0.0.1:77/tiagent/api/ioclastuptime";
        $result = Util::httpRequest($url,'GET');
        echo json_encode($result);
        return;
    }
}

