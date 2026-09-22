<?php
namespace controller\policy;
use controller\mController;
use lib\Util;

 /**
 * @api {GET}  /api/check-update 获取云端威胁情报情报库情况
 * @apiName check-update
 * @apiGroup 威胁情报
 *
 *
 * @apiSuccess {Number} code 错误码
 * @apiSuccess {String} cur_version 当前情报库版本
 * @apiSuccess {Number} ioc_total 设备生效情报数
 * @apiSuccess {String} message 信息
 * @apiSuccess {String} new_version 云端新版本（该参数已经被弃用）
 * @apiSuccessExample {json} Success-Response:
 *
 *
 *  HTTP/1.1 200 OK
 *		{
 *			"code": 0,
 *			"cur_version": "20220225.2028",
 *			"message": ""
 *			"ioc_total": 500000
 *			"new_version": "20220225.2028" 
 *		}
 *
 * @apiErrorExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *			"code": "非0",
 *			"cur_version": "20220225.2028",
 *			"message": "错误信息"
 *			"ioc_total": 500000
 *			"new_version": "20220225.2028" 
 *		}
 */
 
class IntelligenceCheckUpdateController extends mController{
    
    public function get()
    {
        $url = "http://127.0.0.1:77/tiagent/api/checkupdate";
        $result = Util::httpRequest($url,'GET');
        echo json_encode($result);
        return;
    }
}

