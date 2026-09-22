<?php
namespace controller\policy;
use controller\mController;
use lib\Util;

 /**
 * @api {GET}  /api/intelligence-database 获取云端威胁情报情报库升级历史
 * @apiName intelligence-database
 * @apiGroup 威胁情报
 *
 *
 * @apiParam {Number} page 情报库页面数（1）
 * @apiParam {String} pageSize 情报库页面大小（20）
 *  @apiParamExample {json} Request-Example:
 *	{
 *		"pageSize": 20,
 *		"page": "1"
 *	}
 * @apiSuccess {Number} id 历史索引
 * @apiSuccess {String} mode 情报拉取方式（自动/手动）
 * @apiSuccess {String} result 成功失败
 * @apiSuccess {String} type 拉取类型
 * @apiSuccess {String} time 拉取时间
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *	{
 *		"data": [{
 *			"Id": 1,
 *			"Vername": "20220225.2028",
 *			"Time": "2022-02-25 20:28:41",
 * 			"Type": "ioc",
 *			"Mode": "Auto",
 *			"Result": "Success"
 *		}, {
 *			"Id": 0,
 *			"Vername": "20220222.1348",
 *			"Time": "2022-02-22 14:05:28",
 *			"Type": "ioc",
 *			"Mode": "Auto",
 *			"Result": "Success"
 *		}]
 *	}
 *
 */
 
class IntelligenceDatabaseController extends mController {
    function get(){
        $url = "http://127.0.0.1:77/tiagent/api/iocrecord";
        $result = Util::httpRequest($url,'GET');
        $data['data'] = $result['tiagnet_update'];
        echo json_encode($data);
        return;
    }
}
