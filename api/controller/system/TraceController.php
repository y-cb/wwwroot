<?php
namespace controller\system;
use controller\mController;

/**
 * @api {GET}  /api/trace traceroute某个地址
 * @apiName traceroute
 * @apiGroup 系统维护
 *
 *
 * @apiParam {String} address 需要trace的地址
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"address":  "172.16.0.1"
 *	}
 *
 * @apiSuccess {String} trace_info traceroute结果
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *	    "data": {
 *	        "trace_info": "traceroute to 172.16.0.1 (172.16.0.1), 30 hops max, 46 byte packets\n 1  172.16.0.1 (172.16.0.1)  1.172 ms  1.541 ms  0.956 ms\n"
 *	    }
 *	}
 *
 * @apiErrorExample {json} Error-Response:
 *	HTTP/1.1 422 Not Found
 *	{
 *		"code":"非0"
 *	}
 *
 */

class TraceController extends mController{
	private $preg = "/^([a-z0-9A-Z]+\.)+(?:[a-z]+)$/";
	private $file_path;

	function __construct() {
		$param = get_inputs();
		$this->file_path = '/tmp/' . $param['address'] . '.log';
	}

	public function get() {
		$param = get_inputs();
		//防止XSS注入
		$data = array('code'=>-1, 'str'=> 'Data return error');
		$param['address'] = $param['address']? htmlspecialchars($param['address']): '';

		if (file_exists($this->file_path)) {
			unlink($this->file_path);
		}
		// if ($param['address'] &&(filter_var($param['address'], FILTER_VALIDATE_IP) || preg_match($preg, $param['address']))) {
		if ($param['address'] || preg_match($this->preg, $param['address'])) {
			$cmd = 'traceroute '. $param['address'] . ' > ' . $this->file_path . ' &';
			exec($cmd, $output);

			//解析ping命令返回数据
			if (!empty($output)) {
				$data = array('code' => '-1', 'str'=> 'Unknown wrong');
			} else {
				$data = array('');
			}
			/*if (is_array($output)) {
				if (!empty($output)) {
					foreach ($output as $value) {
						$info['trace_info'] .= $value . "\n";
					}
				} else {
					$info = array('trace_info'=> 'Bad address');
				}
				unset($data);
				$data['data'] = $info;
			}*/
		}
		echo json_encode($data) ;
	}

	public function post() {
		$param = get_inputs();
		$cnt;
		$data['data'] = array('code'=>-1, 'str'=> 'Data return error');
		$param['address'] = $param['address']? htmlspecialchars($param['address']): '';

		if ($param['address'] || preg_match($this->preg, $param['address'])) {

			if (file_exists($this->file_path)) {
				$content = file_get_contents($this->file_path);
				$data_arr = explode("\n", trim($content));
				/*if ($param['cnt'] == 0) {
					$cnt = 0;
				} else {
					$cnt = $param['cnt'] - 1;
				}*/

				$data['data'] = $data_arr;
				$data['total'] = count($data_arr);
			}
		}

		echo json_encode($data);
	}

	public function delete() {
		if (file_exists($this->file_path)) {
			unlink($this->file_path);
		}
	}
}