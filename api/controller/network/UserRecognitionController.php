<?php
namespace controller\network;
use controller\mController;

/**
 * @api {GET}  /api/user-recognition 获取旁路部署用户识别参数
 * @apiName 获取旁路部署用户识别参数
 * @apiGroup 网络
 *
 *
 * @apiSuccess {Number} recogs_num  当前在线用户总数
 * @apiSuccess {String} recog_scope_name  用户识别的有效地址范围
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"recogs_num": "100",
 *			"recog_scope_name": "addr_obj_test"
 *		},
 *	],
 *	"total": 1
 *	}
 */

/**
 * @api {PUT}  /api/user-recognition 修改旁路部署用户识别参数
 * @apiName 修改旁路部署用户识别参数
 * @apiGroup 网络
 *
 *
 * @apiParam {String} recog_scope_name  用户识别的有效地址范围
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"recog_scope_name": "addr_obj_test"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"code":"0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":"地址对象 addr_obj_bad 不存在"
 *	}
 *
 */


class UserRecognitionController extends mController{
	public $module = 'auth_user_param';
}

?>
