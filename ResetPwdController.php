<?php
namespace controller\login;
use lib\LoginHandler;
use message\MainModel;
use lib\ArrayMap;
use lib\ArrayList;

/**
 * @api {post} /api/reset-pwd  重置密码
 * @apiName 登录
 * @apiGroup 登录认证
 *
 * @apiParam {String} username 用户名
 * @apiParam {String} password 密码
 * @apiParam {String} captcha 验证码
 * @apiParamExample {json} Request-Example:
 *     {
 *       "username": "admin",
 *       "password": "admin",
 *       "captcha": ""
 *     }
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "token": "b13d4d69rua1kf426lmd7oh6d3"
 *     }
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 422 Not Found
 *     {
 *       "code": "1001",
 *       "str": 用户名或密码错误"
 *     }
 * @apiSuccess {String} token 登录成功后的token，在获取/下发配置的时候可以使用
 */

class ResetPwdController{

    function ase_decrypt($data){
		$privateKey=$_SESSION[RANDOMKEY];
		$iv=$_SESSION[RANDOMKEY];

		$encryptedData=base64_decode($data);
		$decrypted=mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$privateKey,$encryptedData,MCRYPT_MODE_CBC,$iv);
		$result = rtrim($decrypted);
		return $result;
	}

	function post() {
		$input = get_inputs();
		@$fp = fopen( '/tmp/webui/lang.conf', 'w' );
		@flock($fp, 2);
		if($input['lang']=='cn'){
			$lang = 1;
			@fwrite($fp, 2);//英文lang.conf=1 中文lang.conf=2
		}else{
			$lang = 2;
			@fwrite($fp, 1);
		}
		@fclose($fp);

		/*$username=self::ase_decrypt($input['username']);
		$password=self::ase_decrypt($input['password']);*/
		$username=$input['username'];
		$password=$input['password'];
		$old_password=$input['old_password'];
		//三权分立添加功能

		$data = new ArrayList();
		$my_data = new ArrayMap();
		$my_data['new_password']=$password;
		$my_data['old_password']=$old_password;
		$my_data['username']=$username;
		$my_data['nocheck']=1;
		$my_data['ip_addr'] = $_SERVER['REMOTE_ADDR'];
		$rspString = getResponse('change_admin_passwd', 'mod', $my_data);
		$ret = getAssign($rspString, 'change_admin_passwd', false, true);
		if($ret['code']){
			echo json_encode($ret);
		}
    }
}
