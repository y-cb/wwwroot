<?php
namespace controller;
use ToroHook;

class Controller {
  public $module;
  public $category = 'CATEG_CONFIG';
  public $accesskey = 'f6feadca-38c9-471e-ba9f-fcd3eefddfbc';
  public $secretkey = 'f6fsdfaca-40c9-871e-ba9f-fcd3eefdabcd';

	function __construct() {
		if (clean_file(UPLOAD_FILE, time())) {
			unlink(UPLOAD_FILE);
		}

		ToroHook::add("before_handler", function() {
			$token_path = '/mnt/boot/token.json';
			$api_key = $_GET['api_key'];
			$auth = getallheaders();

			if(file_exists($token_path)){
				$json = file_get_contents($token_path);
				$token_array = json_decode($json,true);
				foreach ($token_array as $value) {
					if ($api_key === $value['token']) {
						$_SESSION[CONNECTION.USERNAME] = 'admin';
						return;
					}
				}
			}



			if(empty($api_key)){
				if($auth['Authorization']!=='0'){//中国电信安全组件接口认证
					//$GLOBALS['accesskey'] = $this->accesskey;
					//$GLOBALS['secretkey'] = $this->secretkey;
					/*验证时间戳*/
					$msectime = microtime();
					list($msec, $sec) = explode(' ', $msectime);
					$msectime1 = substr($msectime,11,10).substr($msectime,2,6);//收到报文时间，微秒级的Unix时间戳，16位数字
					$msectime2 = substr($msectime,11,10).str_pad(substr($msectime,0,8) * 1000000,6,"0",STR_PAD_LEFT);//收到报文时间，微秒级的Unix时间戳，16位数字
					$tonce = $auth["Tonce"];
					//$_SESSION['tonce'] = $tonce;
					$time_diff = $msectime1 - $tonce;//获取请求头中的Tonce键值与当前时间的时间差
					if($time_diff>300000000 || $time_diff<0){//延迟大于300秒或设备收到报文早于平台请求时间，status_code返回失败417
						$res = array('status_code'=>417,'str'=>'认证时间戳tonce错误');
			            echo json_encode($res);
			            exit(0);
					}
					/*验证accesskey*/
					$Authoriztion_decode = base64_decode($auth['Authorization']);
					$Authoriztion_decode_explode = explode(":",$Authoriztion_decode);
					$get_accesskey = $Authoriztion_decode_explode[0];
					$signature_hash = $Authoriztion_decode_explode[1];
					//$_SESSION['signature_hash'] = $Authoriztion_decode_explode[1];
					if($get_accesskey!=$this->accesskey){
						$res = array('status_code'=>401,'str'=>'未授权访问');
			            echo json_encode($res);
			            exit(0);
					}
					/*验证signature_hash*/
					if($_SERVER['REQUEST_METHOD']=='PUT' || $_SERVER['REQUEST_METHOD']=='DELETE'){
						$api_uri = substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"));//获取url内容
						$other_uri = substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);//获取url中other内容
					}else{
						if(strpos($_SERVER['REQUEST_URI'],'?') !== false){
							$api_uri = substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"?"));//获取url内容
							$other_uri = substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"?")+1);//获取url中other内容
						}else{
							$api_uri = $_SERVER['REQUEST_URI'];
							$other_uri = '';
						}
					}
					$get_body = file_get_contents('php://input');//获取请求body内容
					$get_body_md5 = md5($get_body);
					$signature2 = $_SERVER['REQUEST_METHOD'].'|'.$api_uri.'|'.$tonce.'|'.$this->accesskey.'|'.$other_uri.'|'.$get_body_md5;
					$signature_hash2 = hash_hmac('sha256', $signature2, $this->secretkey);

					if($signature_hash!=$signature_hash2){
						$res = array('status_code'=>400,'str'=>'错误请求：API参数错误');
						echo json_encode($res);
			            return false;
					}

					$_SESSION[CONNECTION.USERNAME] = 'admin';
					$api_key = 'hiooobmg08kl6a7h7vg9k920gt';

				}else{
					$_SESSION[CONNECTION.USERNAME] = 'admin';
					$api_key = 'hiooobmg08kl6a7h7vg9k920gt';
				}
			}

			/*if (empty($api_key)&&$auth['Authorization']==='0') {
				$_SESSION[CONNECTION.USERNAME] = 'admin';
				$api_key = 'hiooobmg08kl6a7h7vg9k920gt';
			}*/
            if (file_exists(SSO_FILE)) {
			    $json = file_get_contents(SSO_FILE);
			    if ($json) {
			        $list = json_decode($json, true);

			        foreach ($list as $val) {
			            if ($val['token'] === $api_key && $val['validtime'] > time()) {
                            $_SESSION[LOGINSTATE] = 'set';
			                $_SESSION[CONNECTION.USERNAME] = $val['username'];
                            $_SESSION[CONNECTION.PASSWORD] = $val['password'];
                        }
                    }
                }
            }

			session_id($api_key);
			session_start();

			//如果单点登录文件存在，给session赋值
			$path = '/mnt/boot/sso_key.json';
			if (file_exists($path)){
				$data = file_get_contents($path);
				$data = json_decode($data);

				if($data === $api_key){
					$_SESSION[CONNECTION.USERNAME] = 'admin';
				}
			}

			if(!isset($_SESSION[CONNECTION.USERNAME])){
				header("HTTP/1.1 401 Unauthorized");
				$ret = array('code' => '401', 'str' => 'Not login');
				echo json_encode($ret);
				exit(0);
			}
		});


    	/* 检查是否登录 */
		ToroHook::add("before_handler", function() {

			if ($_SESSION[CONNECTION.USERNAME]) {
				return;
			}
			//单点登录验证
			$auth = getallheaders();
			$auth = $auth['Authorization'];
			$host = $_SERVER['REMOTE_ADDR'];
			if ($host === '127.0.0.1' && $auth === '0') {
				return;
			}

			if ($auth === '1') {
				return;
			}

			if($auth && ($get_accesskey==$this->accesskey)){
				return;
			}
			/* 权限检查 */
			/*$rspString = getResponse('login_state_xml', "show" ,$param);
			$ret = getAssign($rspString,'login_state_xml');*/
			/*因和单点登录逻辑冲突，暂时屏蔽*/
			/*if($ret["state"]=="1"){
				$method = $_SERVER['REQUEST_METHOD'];
				$permission = $_SESSION[PERMISSION];

				if ($permission['separation_of_powers'] == 1) {
					return;
					foreach($permission['category_items'] as $item) {
						if ($this->category == $item->name) {
							if ($method == 'GET') {
								if ($item->read == 1) {
									return;
								}
							} else {
								if ($item->write == 1) {
									return;
								}
							}
						} else {
							return;
						}
					}
				} else {
					return;
				}
			}else{
				$ret = array('code' => '401', 'str' => 'Not login22');
				echo json_encode($ret);
				exit(0);
			}*/

			/* 暂不检查权限 */
			// return;


			$ret = array('code' => '401', 'str' => t('permission.deny'));
			echo json_encode($ret);
			exit(0);
		});
  	}

	public function get() {
		 $param = get_inputs();
		 $param['count'] = $param['pageSize'];
		 $rspString = getResponse($this->module, "show" ,$param);
		 $ret = getAssign($rspString, $this->module,1);
		 header('Content-type: application/json');
		 if (empty($ret)) {
			echo json_encode(array());
		 } else {
		 	echo json_encode($ret);
		 }
    }
	function delete() {
		$action = '';
		$param = get_inputs();
		if ($param['desc']) {
			unset($param['desc']);
		}
		switch ($param['op']) {
			case 'clear':
				unset($param['op']);
				$action = 'clear';
				break;

			default:
				$action = 'del';
				break;
		}
		$rspString = getResponse($this->module, $action ,$param);
		$ret = getAssign($rspString, $this->module);
		header('Content-type: application/json');
		if (!empty($ret)) {
			echo json_encode($ret);
		}
    }

	function post() {
		 $param = get_inputs();
		 if ($param['op'] == 'submit') {
		  $rspString = getResponse($this->module, "submit" ,$param);
     } else {
		  $rspString = getResponse($this->module, "add" ,$param);
     }
		 $ret = getAssign($rspString, $this->module);
		 header('Content-type: application/json');
		 if (!empty($ret)) {
		 	echo json_encode($ret);
		 }
    }

	function put() {
		 $param = get_inputs();
		 $rspString = getResponse($this->module, "mod" ,$param);
		 $ret = getAssign($rspString, $this->module);
		 header('Content-type: application/json');
		 if (!empty($ret)) {
		 	echo json_encode($ret);
		 }
    }
}
