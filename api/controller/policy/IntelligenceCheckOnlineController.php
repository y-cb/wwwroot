<?php
namespace controller\policy;
use controller\mController;
use lib\Util;

 /**
 * @api {GET}  /api/check-online 获取与云端威胁情报中心连接状态
 * @apiName check-online
 * @apiGroup 威胁情报
 *
 * @apiSuccess {Number} code 错误码
 * @apiSuccess {String} last_updatetime 上次升级时间
 * @apiSuccess {String} message 状态信息
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *		{
 *			"code": 0,
 *			"last_updatetime": "20220225.2028",
 *			"message": "Online"
 *		}
 *
 * @apiErrorExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *		{
 *			"code": -1,
 *			"last_updatetime": "20220225.2028",
 *			"message": "Offline"
 *		}
 */

class IntelligenceCheckOnlineController extends mController{
	
	public function get()
    {
        $url = "http://127.0.0.1:77/tiagent/api/checkonline";
        $result = Util::httpRequest($url,'GET');
        echo json_encode($result);
        return;
    }
    
}

