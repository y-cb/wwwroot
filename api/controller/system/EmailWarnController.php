<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/email-warning 获取告警邮件配置
 * @apiName email-warning
 * @apiGroup 日志设定
 *
 *
 * @apiSuccess {String} smtp_server SMTP服务器
 * @apiSuccess {String} sender 发件人E-Mail
 * @apiSuccess {String} receiver1 收件人E-Mail
 * @apiSuccess {Number} auth_enable 认证使能状态
 * @apiSuccess {Number} ssl_enable 安全连接使能状态
 * @apiSuccess {Number} interval 最短发送间隔
 * @apiSuccess {Number} smtp_server_port SMTP服务器端口
 * @apiSuccess {String} test_receiver 测试邮件地址
 * @apiSuccess {String} smtp_user SMTP用户
 * @apiSuccess {String} smtp_passwd SMTP用户对应密码
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data":,
 *		{
 *			"smtp_server": "smtp.qq.com",
 *			"sender": "test@sunyainfo.com",
 *			"receiver1": "test2@sunyainfo.com",
 *			"auth_enable": "1",
 *			"ssl_enable": "1",
 *			"interval": "5",
 *			"smtp_server_port": "25",
 *			"test_receiver": "test3@sunyainfo.com",
 *			"smtp_user": "test@sunyainfo.com",
 *			"smtp_passwd": "abcdef"
 *		}
 *	}
 */

/**
 * @api {POST}  /api/email-warning 添加告警邮件配置
 * @apiName email-warning
 * @apiGroup 日志设定
 *
 *
 * @apiParam {String} smtp_server SMTP服务器
 * @apiParam {String} sender 发件人E-Mail
 * @apiParam {String} receiver1 收件人E-Mail
 * @apiParam {Number} auth_enable 认证使能状态
 * @apiParam {Number} ssl_enable 安全连接使能状态
 * @apiParam {Number} interval 最短发送间隔
 * @apiParam {Number} smtp_server_port SMTP服务器端口
 * @apiParam {String} test_receiver 测试邮件地址
 * @apiParam {String} smtp_user SMTP用户
 * @apiParam {String} smtp_passwd SMTP用户对应密码
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"smtp_server": "smtp.qq.com",
 *		"sender": "test@sunyainfo.com",
 *		"receiver1": "test2@sunyainfo.com",
 *		"auth_enable": "1",
 *		"ssl_enable": "1",
 *		"interval": "5",
 *		"smtp_server_port": "25",
 *		"test_receiver": "test3@sunyainfo.com",
 *		"smtp_user": "test@sunyainfo.com",
 *		"smtp_passwd": "abcdef"
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
 *		"str":""
 *	}
 *
 */

/**
 * @api {PUT}  /api/email-warning 修改告警邮件配置
 * @apiName email-warning
 * @apiGroup 日志设定
 *
 *
 * @apiParam {String} smtp_server SMTP服务器
 * @apiParam {String} sender 发件人E-Mail
 * @apiParam {String} receiver1 收件人E-Mail
 * @apiParam {Number} auth_enable 认证使能状态
 * @apiParam {Number} ssl_enable 安全连接使能状态
 * @apiParam {Number} interval 最短发送间隔
 * @apiParam {Number} smtp_server_port SMTP服务器端口
 * @apiParam {String} test_receiver 测试邮件地址
 * @apiParam {String} smtp_user SMTP用户
 * @apiParam {String} smtp_passwd SMTP用户对应密码
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"smtp_server": "smtp.qq.com",
 *		"sender": "test@sunyainfo.com",
 *		"receiver1": "test2@sunyainfo.com",
 *		"auth_enable": "1",
 *		"ssl_enable": "1",
 *		"interval": "5",
 *		"smtp_server_port": "25",
 *		"test_receiver": "test3@sunyainfo.com",
 *		"smtp_user": "test@sunyainfo.com",
 *		"smtp_passwd": "abcdef"
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
 *		"str":""
 *	}
 *
 */

class EmailWarnController extends mController{	
	public $module = 'email_warn';

	function get () {
		$param = get_inputs();
		$data = array();

		$rspString = getResponse($this->module, "show" ,$param);
	    $ret = getAssign($rspString, $this->module, false, true);

	   	if(empty($ret)) {
	   		$data['data'] = array();
	   		$data['total'] = 0;
	   	} else {
	   		foreach ($ret['group'] as $key => $value) {
		   		if ($value['auth_enable'] && $value['auth_enable'] == 1) {
		   			$value['smtp_passwd'] = hex2bin($value['smtp_passwd']);
		   		}
	   			$data['data'][] = $value;
	   		}

	   		if (isset($ret['page'])) {
	   			$data['total'] = (int)$ret['page']['total'];
	   		} else {
	   			$data['total'] = (int)count($data['data']);
	   		}
	   	}

	   	header('Content-type: application/json');
	   	echo json_encode($data);
	}

	function put () {
		$param = get_inputs();

		if ($param['auth_enable']== '1') {
			$param['smtp_passwd'] = bin2hex(htmlspecialchars_decode($param['smtp_passwd']));
		}

		$rspString = getResponse($this->module, "mod" ,$param);
		
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}

	function post () {
		$param = get_inputs();

		if ($param['auth_enable']== '1') {
			$param['smtp_passwd'] = bin2hex(htmlspecialchars_decode($param['smtp_passwd']));
		}

		$rspString = getResponse($this->module, "add" ,$param);
		
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
	}
}

