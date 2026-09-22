<?php
namespace controller\policy;
use controller\mController;

/**
 * @api {GET}  /api/defense 获取情报库内容
 * @apiName defense
 * @apiGroup 获取情报库内容
 *
 * @apiParam {String} source 情报库来源
 * @apiParam {Number} page 情报库查询页面数
 * @apiParam {Number} pageSize 情报库查询页面大小
 * @apiParamExample {json} Request-Example:
 *	{
 *		"source": "local_coo_def",
 *		"page": "1"
 *		"page": "10"
 *	}
 *
 * @apiSuccess {Number} type 威胁情报类型，1代表IP，2代表域名，3代表URL，4代表文件SHA256
 * @apiSuccess {Number} level 威胁级别，-1代表未知, 0代表安全，1代表可疑，2代表低，3代表中，4代表高，5代表严重
 * @apiSuccess {Number} reliable 信誉值，1-100
 * @apiSuccess {Number} time 单位秒，60-59940，0代表永久
 * @apiSuccess {Number} buildtime 创建时间（秒级时间戳））
 * @apiSuccess {String} object 具体情报
 * @apiSuccess {String} des 描述(0-127字符)
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *		{
 *    		"type": "1",
 *    		"level": "1",
 *    		"reliable": "100",
 *    		"time": "3600",
 *    		"buildtime": "1525940130",
 *    		"object": "1.1.1.1",
 *    		"des": "test"
 *		},
 *		{
 *    		"type": "1",
 *    		"level": "1",
 *    		"reliable": "100",
 *    		"time": "600",
 *    		"buildtime": "1525940150",
 *    		"object": "1.1.1.12",
 *    		"des": "test1"
 *		}
 *	],
 *	"total": 2
 *	}
 */

/**
 * @api {POST}  /api/defense 添加或修改情报库内容
 * @apiName defense
 * @apiGroup 添加情报库内容
 *
 * @apiSuccess {Number} type 威胁情报类型，1代表IP，2代表域名，3代表URL，4代表文件SHA256
 * @apiSuccess {Number} level 威胁级别，-1代表未知, 0代表安全，1代表可疑，2代表低，3代表中，4代表高，5代表严重
 * @apiSuccess {Number} reliable 信誉值，1-100
 * @apiSuccess {Number} time 生效时间，单位秒，60-59940，0代表永久
 * @apiSuccess {Number} buildtime 创建时间（秒级时间戳）
 * @apiSuccess {String} object 具体情报
 * @apiSuccess {String} des 描述（0-127字符）
 * @apiSuccess {String} source 情报库来源（目前仅有local_coo_def）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *    		"type": "1",
 *    		"level": "1",
 *    		"reliable": "100",
 *    		"time": "3600",
 *    		"object": "1.1.1.1",
 *    		"des": "test",
 *    		"source": "local_coo_def"
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
 * @api {DELETE}  /api/defense 删除情报库内容
 * @apiName defense
 * @apiGroup 删除情报库内容
 *
 * @apiSuccess {Number} type 威胁情报类型，1代表IP，2代表域名，3代表URL,4代表文件SHA256
 * @apiSuccess {String} object 具体情报
 * @apiSuccess {String} source 情报库来源（目前仅有local_coo_def）
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *    		"type": "1",
 *    		"object": "1.1.1.1",
 *    		"source": "local_coo_def"
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


class DefenseController extends mController{	
	public $module = 'coo_defense';
	function get() {
		$param = get_inputs();
		if($param['op'] == 'detail'){
			$param['object'] = htmlspecialchars_decode($param['object']);
			$rspString = getResponse($this->module, "show_one" ,$param);
		    $ret = getAssign($rspString, $this->module);
			if ($ret['group']) {
				$ret['group'] = json_decode($ret['group']);
			}
			echo json_encode($ret);
			return;

		}else{
			$param['count'] = $param['pageSize'];
		 	$rspString = getResponse($this->module, "show" ,$param);
		 	$ret = getAssign($rspString, $this->module, false, true);
		 	header('Content-type: application/json');
		 	$data['data'] = $ret['group'];
            if (isset($ret['page'])) {
                $data['total'] = (int)$ret['page']['total'];
            } else {
                $data['total'] = (int)count($data['data']);
            }
            
		 	echo json_encode($data);
		}

	}
	function post(){
		$params = get_inputs();
		if($params['type']==5){
			$tmp_md5_file = '/tmp/md5.txt';
			$md5_file = $_POST['md5_file'];
			file_head_split($md5_file);
			file_put_contents($tmp_md5_file, base64_decode($md5_file));
			$params['object'] = hash_file('sha256', $tmp_md5_file);
			unset($params['md5_file']);
			unlink($tmp_md5_file);
		}
		$rspString = getResponse($this->module, "add" ,$params);
		$ret = getAssign($rspString, $this->module, false, true);
		if (!empty($ret)){
			echo json_encode($ret);
			return;
		}
	}
	/*function get() {
		$token = $_GET['api_key'];
		$obj = self::check_api($token);
		$module = 'coo_defense';
		$source = $_GET['source'];
		$page = $_GET['page'];
		$count = $_GET['count'];
		if (!$source || !$page || !$count) {
			$msg = array('code' => -1,'msg' => '缺少参数');
		} else {
			$param['source'] = $source;
			$param['page'] = $page;
			$param['count'] = $count;

			$rspString =getResponse($module,'show',$param);
			$ret = getAssign($rspString, $module);
			if (empty($ret)) {
				$msg = array();
			} else {
				$msg = $ret;
			}
		}
		echo json_encode($msg);
		exit(0);
	}
	function delete() {
		$token = $_GET['api_key'];
		$obj = self::check_api($token);
		$module = 'coo_defense';
		$source = $_POST['source'];
		$object = $_POST['object'];
		$type = $_POST['type'];

		if (!$source || !$object || !$type) {
			$msg = array('code'=>-1,'msg'=>'缺少参数');
		} else {
			$param['source'] = $source;
			$param['object'] = $object;
			$param['type'] = $type;
			
			$module_name = "coo_def_source";
			$rspString = getResponse($module_name"show",'');
			$ret = getAssign($rspString,$module_name);
			$str = substr($ret['source'],0,(strlen($ret['source'])-1));
			$arr = explode(',',$str);
			$check = 0;
			for($i = 0;$i < count($arr);$i++ ){
				if ($arr[$i] == $param['source']) {
					$check = 1;
				}
			}
			if (!$check) {
				$msg = array('code'=>'104','msg'=>'source is not found!');
			} else {
				$rspString = getResponse($module,'delete',$param);
				$ret = getAssign($rspString, $module);
				if (!empty($ret)) {
					echo json_encode($ret);
				} else {
					$msg = array('code'=>'1','msg'=>'删除成功！');
				}
			}
		}
		echo json_encode($msg);
		exit(0);
	}
	function post () {
		$module = 'coo_defense';
		$token = $_GET['api_key'];
		$obj = self::check_api($token);
		$object = $_POST['object'];
		$type = $_POST['type'];
		$time = $_POST['time'];
		$level = $_POST['level'];
		$source = $_POST['source'];
		$des = $_POST['des'];
		$reliability = $_POST['reliability'];

		if (!empty($object)) {
			$param['object'] = $object; 
		} else {
			$msg = array('code' => '-1','msg' => '策略对象不能为空！');
		}
		if (!empty($type)) {
			$param['type'] = $type; 
		} else {
			$msg = array('code' => '-1','msg' => '策略类型不能为空！');
		}
		if (!empty($time)) {
			$param['time'] = $time; 
		} else {
			$msg = array('code' => '-1','msg' => '阻断有效期不能为空！');
		}		
		if (!empty($level)) {
			$param['level'] = $level; 
		} else {
			$msg = array('code' => '-1','msg' => '威胁级别不能为空！');
		}
		if (!empty($source)) {
			$param['source'] = $source; 
		} else {
			$msg = array('code' => '-1','msg' => '策略来源设备名不能为空！');
		}
		if (!empty($reliability)) {
			$param['reliable'] = $reliability; 
		} else {
			$param['reliable'] = 100;
		}
		if (intval($param['level']) < 1 || intval($param['level']) > 3) {
			$msg = array('code' => '103','msg'=>'level is wrong!');
		}
		if(!empty($des)) {
			$param['des'] = $des;
		}

		if ($param['object'] && $param['type'] && $param['time'] && $param['level'] && $param['source'] && $param['reliable'] && empty($msg)){
			if ($param['type'] == 1) {
				$check = filter_var($param['object'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
				if (!$check) {
					$msg = array('code'=>105,'msg'=>'invalid field');
				}
			}
			if (empty($msg)) {
				$rspString = getResponse($module,'add',$param);
				$ret = getAssign($rspString, $module);
				if (!empty($ret)) {
					echo json_encode($ret);
				}
				$msg = array('code' => 1,'msg' => '添加成功！');				
			}
		}
		echo json_encode($msg);
		exit(0);
	}
	function check_api($api_key){

		if (!$api_key) {
			$ret = array('code' => '0','msg' => 'api_key not found!');
			echo json_encode($ret);
			exit;			
		}
		$token_file = '/mnt/boot/token.json';
		$str = file_get_contents($token_file);
		$arr = json_decode($str,true);
		$num = count($arr);
		$check = 0;
		for ($i = 0; $i < $num; $i++) {
			if ($arr[$i]['token'] == $api_key) {
				$check = 1;
				break;
			}
		}
		if ($check == 0) {
			$ret = array('code' => '0','msg' => 'api_key is wrong!');
			echo json_encode($ret);
			exit;			
		}		
	}*/
}

