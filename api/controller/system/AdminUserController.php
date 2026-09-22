<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/admin 获取系统管理员
 * @apiName 获取系统管理员
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} name  管理员名
 * @apiSuccess {String} desc  管理员描述信息
 * @apiSuccess {Number} status  0：正常 1：禁用
 * @apiSuccess {Number} type  1:本地管理员 2：radius 3：ldap 
 * @apiSuccess {String} password  管理员密码
 * @apiSuccess {String} authority_table_name  引用的权限表
 * @apiSuccess {Number} password_expire_days  0
 * @apiSuccess {Number} password_expire_hours  0
 * @apiSuccess {Number} password_expire_minutes  0
 * @apiSuccess {String} radius_server_name  类型为1时，填写radius认证服务器对象名称
 * @apiSuccess {String} ldap_server_name  类型为2时，填写ldap认证服务器对象名称
 * @apiSuccess {Array} permit_addr  允许登录IP数组
 * @apiSuccess {String} permit_ip  允许登录IP
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *			"name": "admin",
 *			"desc": "default configuration administrator",
 *			"status": "0",
 *			"type": "1",
 *			"password": "admin",
 *			"password_expire_days": "0",
 *			"password_expire_hours": "0",
 *			"password_expire_minutes": "0",
 *			"permit_addr": [
 *				"permit_ip":"0.0.0.0/0"
 *			],
 *		},
 *		{
 *			"name": "audit",
 *			"desc": "default audit administrator",
 *			"status": "0",
 *			"type": "1",
 *			"password": "admin.audit",
 *			"password_expire_days": "0",
 *			"password_expire_hours": "0",
 *			"password_expire_minutes": "0"
 *		}
 *	],
 *	"total": 2
 *	}
 */

 /**
 * @api {GET} /api/admin 获取指定系统管理员
 * @apiName 获取指定系统管理员
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} name  管理员名
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "audit",
 *			"op": "detail"
 *	}
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *			"name": "audit",
 *			"desc": "default audit administrator",
 *			"status": "0",
 *			"type": "1",
 *			"password": "admin.audit",
 *			"password_expire_days": "0",
 *			"password_expire_hours": "0",
 *			"password_expire_minutes": "0"
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0",
 *		"str":"XXX"
 *	}
 *
 */
 
/**
 * @api {POST} /api/admin 添加系统管理员
 * @apiName 添加系统管理员
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} name  管理员名
 * @apiSuccess {String} desc  管理员描述信息
 * @apiSuccess {Number} status  0：正常 1：禁用
 * @apiSuccess {Number} type  1:本地管理员 2：radius 3：ldap 
 * @apiSuccess {String} password  管理员密码
 * @apiSuccess {String} authority_table_name  引用的权限表
 * @apiSuccess {String} radius_server_name  类型为1时，填写radius认证服务器对象名称
 * @apiSuccess {String} ldap_server_name  类型为2时，填写ldap认证服务器对象名称
 * @apiSuccess {Array} permit_addr  允许登录IP数组
 * @apiSuccess {String} permit_ip  允许登录IP
 * @apiSuccess {String} rd_key  加密16位随机数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "test",
 *			"desc": "test",
 *			"type": "1",
 *			"password": "test!11",
 *			"authority_table_name": "admin",
 *			"permit_addr": [
 *				"permit_ip":"1.1.1.1/32",
 *				"permit_ip":"1.1.1.2/32"
 *			],
 *			"rd_key": "slkd5lk6kjhdjdh8"
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
 *		"str":"XXX"
 *	}
 *
 */

/**
 * @api {PUT} /api/admin 修改系统管理员
 * @apiName 修改系统管理员
 * @apiGroup 管理员设置
 *
 *
 * @apiSuccess {String} name  管理员名
 * @apiSuccess {String} desc  管理员描述信息
 * @apiSuccess {Number} status  0：正常 1：禁用
 * @apiSuccess {Number} type  1:本地管理员 2：radius 3：ldap 
 * @apiSuccess {String} password  管理员密码
 * @apiSuccess {String} authority_table_name  引用的权限表
 * @apiSuccess {String} radius_server_name  类型为1时，填写radius认证服务器对象名称
 * @apiSuccess {String} ldap_server_name  类型为2时，填写ldap认证服务器对象名称
 * @apiSuccess {Array} permit_addr  允许登录IP数组
 * @apiSuccess {String} permit_ip  允许登录IP
 * @apiSuccess {String} rd_key  加密16位随机数
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *			"name": "test",
 *			"desc": "test   test",
 *			"type": "1",
 *			"password": "test!11",
 *			"authority_table_name": "admin",
 *			"permit_addr": [
 *				"permit_ip":"1.1.1.1/32",
 *				"permit_ip":"1.1.1.2/32"
 *			],
 *			"rd_key": "slkd5lk6kjhdjdh8"
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
 *		"str":"XXX"
 *	}
 *
 */

/**
 * @api {DELETE} /api/admin 删除系统管理员
 * @apiName 删除系统管理员
 * @apiGroup 管理员设置
 *
 *
 * @apiParam {String} name  系统管理员名字
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"name": "test"
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
 *		"str":"XXX"
 *	}
 *
 */

class AdminUserController extends mController {	
	public $module = 'admin_db';

    function ase_decrypt($data,$rd_key){
		/*$privateKey=$_SESSION[RANDOMKEY];
		$iv=$_SESSION[RANDOMKEY];*/
		$privateKey=$rd_key;
		$iv=$rd_key;

		$encryptedData=base64_decode($data);
		$decrypted=openssl_decrypt($encryptedData, "AES-128-CBC", $privateKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
		$result = rtrim($decrypted);
		return $result;
	}

	function post() {
		$data = get_inputs();
		if($data['password']){
			$data['password'] = htmlspecialchars($this->ase_decrypt($data['password'],$data['rd_key']));
		}
		$rspString = getResponse($this->module, "add" ,$data);

		$ret = getAssign($rspString, $this->module);
		
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}

	function put() {
		$data = get_inputs();
		if($data['password']){
			$data['password'] = htmlspecialchars($this->ase_decrypt($data['password'],$data['rd_key']));
		}
		$rspString = getResponse($this->module, "mod" ,$data);

		$ret = getAssign($rspString, $this->module);
		
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}
