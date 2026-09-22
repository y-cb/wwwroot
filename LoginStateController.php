<?php
namespace controller\login;
use controller\mController;
/**
 * @api {GET} /api/login-state  查看登录是否超时
 * @apiName 查看登录是否超时
 * @apiGroup 登录认证
 *
 * @apiParam {Number} state 超时状态，1表示未超时，0表示超时
 * @apiParamExample {json} Request-Example:
 *     {
 *       "state": "1",
 *     }
 */

class LoginStateController extends mController{
	public $module = 'login_state_xml';

}
