<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET} /api/sys-token 获取token列表
 * @apiName 获取token列表
 * @apiGroup 系统维护
 *
 * @apiSuccess {String} token token值
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"data": [
 *			{"token": "ws60z9d178s2sqda3gthctuam7hszagh"}, 
 *			{"token": "92mjunbealkj3kmidp4ecukmzvea9na6"}, 
 *			{"token": "6gukqtd1moos5k98klmomy6lnqymwaa6"}, 
 *			{"token": "ws60z9d178s2sqda3gt2345778hszagh"}, 
 *			{"token": "ws60z9d178s2sq234567890am7hszagh"}, 
 *	],
 *	"total": 5
 *	}
 */


/**
 * @api {POST} /api/sys-token 添加token
 * @apiName  添加token
 * @apiGroup 系统维护
 *
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"ok"
 *	}
 */

/**
 * @api {DELETE} /api/sys-token 删除token
 * @apiName 删除token
 * @apiGroup 系统维护
 *
 *
 * @apiParam {String} token token值
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *   {
 *    	"ok"
 *   }
 */

class SysTokenController extends mController{
	public $module = 'power_off';
	public $token_file = '/mnt/boot/token.json';
	function get(){
		$param = get_inputs();
		$page_num = $param['page']?$param['page']:1;
		$page_count = $param['pageSize'];
		$start_num = ($page_num-1)*$page_count;

		if (file_exists($this->token_file)) {
			$str = file_get_contents($this->token_file);
			$sys_token_list_arr = json_decode($str);
		}
		$total = count($sys_token_list_arr);

		for($i=0;$i<$page_count;$i++){
			if(isset($sys_token_list_arr[$start_num+$i])){
				$paged_sys_token_list_arr[] =  $sys_token_list_arr[$start_num+$i];
			}
			
		}

		$data = array();
		$data['total'] = $total;
		$data['data'] = $paged_sys_token_list_arr;

		echo json_encode($data);
		return;
	}
	function post(){
		$rstr = '';
		$m = 32;
		$arr = array();
		$str = 'abcdefghijklmnopqrstuvwsyz0123456789';
		$max = strlen($str) - 1;
		for ($i = 1; $i <= $m; $i++) {
			$rstr .= $str[mt_rand(0, $max)];
		}
		
		if (file_exists($this->token_file)) {
			$str = file_get_contents($this->token_file);
			$arr = json_decode($str);
		}
		$arr[] = array('token' => $rstr);
		$json = json_encode($arr);
		file_put_contents($this->token_file, $json);
		echo "ok";
		return;
	}
	function delete(){
		$param = get_inputs();
		if (!file_exists($this->token_file)) {
			$ret = array('code'=>'0','str'=>'token文件不存在');
			echo json_encode($ret);
			exit(0);
		}else{
			if($param['token']){
				$str = file_get_contents($this->token_file);
				$arr = json_decode($str);

				foreach ($arr as $item) {
					if ($item->token == $param['token']) {
						continue;
					}
					$new_arr[] = $item;
				}
				$str = json_encode($new_arr);
				file_put_contents($this->token_file, $str);
				echo "ok";
			}else{
				$ret = array('code'=>'0','str'=>'token不存在');
				exit(0);
			}
		}
		
	}
}

