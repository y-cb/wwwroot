<?php
namespace controller\login;
use lib\LoginHandler;


/**
 * @api {post} /api/login  登录
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

class LoginController{
	public $module = 'admin_authen_login';

	private static function login_secess(){
	    $token_file = '/mnt/boot/token.json';
		$rstr = '';
		$m = 32;
		$arr = array();
		$str = 'abcdefghijklmnopqrstuvwsyz0123456789';
		$max = strlen($str) - 1;
		for ($i = 1; $i <= $m; $i++) {
			$rstr .= $str[mt_rand(0, $max)];
		}
		
		if (file_exists($token_file)) {
			$str = file_get_contents($token_file);
			$arr = json_decode($str);
		}
		
		$item = array('token' => $rstr);
		$arr[] = $item;
		$json = json_encode($arr);
		file_put_contents($token_file, $json);

		return $item;
	}

	function get(){
		$is_code=LoginHandler::is_verycode();
		$exits_code= $is_code[0];
		if (file_exists('/etc/sys_lang')) {
    		$has_lang = 1;
    	}else{
    		$has_lang = 0;
    	}
    	$lang_cfg = file_get_contents('/tmp/webui/lang.conf');
		echo json_encode(array("exits_code"=>$exits_code,"has_lang"=>$has_lang,"lang_cfg"=>$lang_cfg));
		//echo json_encode(array("exits_code"=>$exits_code));
	}

  function get_admin_permission($user) {
    $param = array();
    $param['admin_name'] = $user;

    $rspString = getResponse("admin_permission", "showone", $param);
		$ret = getAssign($rspString, "admin_permission");
		if (!empty($ret)) {
		  $ret['category_items'] = json_decode($ret['category_items'])->group; 
		  $_SESSION[PERMISSION] = $ret;
		}
		return;
	}
  
    function ase_decrypt($data){
		$privateKey=$_SESSION[RANDOMKEY];
		$iv=$_SESSION[RANDOMKEY];

		$encryptedData=base64_decode($data);
		$decrypted=openssl_decrypt($encryptedData, "AES-128-CBC", $privateKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
		$result = rtrim($decrypted);
		return $result;
	}

	function post() {
		$input = get_inputs();
		/*$usr = $input['username'];
		$pwd = $input['password'];*/
		$usr = self::ase_decrypt($input['username']);
		$pwd = self::ase_decrypt($input['password']);
		//$api_key = $input['api_key'];
		@$fp = fopen( '/tmp/webui/lang.conf', 'w' );
		@flock($fp, 2);
		if($input['language']=='cn'){
			$lang = 1;		
			@fwrite($fp, 2);//英文lang.conf=1 中文lang.conf=2		
		}else{
			$lang = '0'; //页面英文由原来的2改为0
			@fwrite($fp, 1);
		}
		@fclose($fp);

		$captcha = strtolower($input['captcha']);

		$is_code = LoginHandler::is_verycode();
		$exits_code= $is_code[0];

		session_id();
		//session_id($api_key);
		session_start();
		if($exits_code==853){
			$_SESSION[CONFIG_CHECKNUM] = '####';
			$captcha = '####';
		}

		if (!$usr || !$pwd || !$captcha || !preg_match("/^[a-zA-Z0-9_-]*$/u",trim($usr) ) || !preg_match("/^[A-Za-z0-9!@#\$%&`,\-\.\*]*$/u", trim($pwd) )) {
			if($input['language']=='cn'){
				$str1 = '用户名或者密码错误';
			}else{
				$str1 = 'Username or password is incorrect';
			}
			$ret = array('code'=>'0','str'=>$str1);
			echo json_encode($ret);
			exit(0);
		}

		if($exits_code!=853){
			if ($_SESSION[CONFIG_CHECKNUM] != $captcha){
				if($input['language']=='cn'){
					$fail_msg = '验证码错误';
				}else{
					$fail_msg = 'Captcha Error';
				}
				//$fail_msg = t('login.captcha_error');
				$ret = array('code' => '-1002', 'str' => $fail_msg);
				echo json_encode($ret);
				exit(0);
			}
		}
		LoginHandler::login($usr, $pwd, $captcha, $lang);

		if (LoginHandler::isLoginFail()) {
			$fail_msg = $_SESSION[LEVEL];
			//var_dump($_SESSION);exit(0);
			if (strlen($fail_msg) <= 0) {
				$fail_msg = t('login.user_pwd_error');//用户名或者密码错误
			}

			if($fail_msg==trim("force_change_password")){
				$expire_msg = ($input['languange']=='cn')? "密码已过期，请重置密码": "Password has expired. Please reset your password";
				$ret = array('code' => '-1003', 'str' => $expire_msg, 'force_param'=>$_SESSION['FORCE_PARAM']);
			}else{
				$ret = array('code' => '-1001', 'str' => $fail_msg);
			}
			echo json_encode($ret);			
		}else{
			$token = array();
			$token['code'] = 0;
			$token['str'] = "success";
			$token['token'] = session_id();
			$_SESSION[CONNECTION.USERNAME] = $usr;
			$token['admin_otp_enable'] = $_SESSION['ADMIN_OPT_ENABLE'];
			$this->get_admin_permission($usr);
			echo json_encode($token);
			exit(0);
		}
    }
}
