<?php
namespace controller\statistics;
use controller\mController;
use database\AppflowDb;

/**
 * @api {GET}  /api/user-monitor 获取所有用户流量统计
 * @apiName 获取所有用户流量统计
 * @apiGroup 用户流量统计
 *
 *
 * @apiSuccess {Number} range 范围
 * @apiSuccess {String} direct 流量方向
 * @apiSuccess {String} app_name 应用名称为空
 * @apiSuccess {String} cateogry 应用种类为空
 * @apiSuccess {String} user_name 用户名为空
 * @apiSuccess {String} lang 语言类型
 * @apiSuccess {String} api_key token
 *
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"range":1,
 * 		"direct":"all"
 * 		"app_name":
 * 		"category":
 * 		"user_name":
 * 		"lang":"cn"
 * 		"api_key":"i2mqk2os55ops9ivb3yc9cupzn699qe5"
 *	}
 *
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 * {
 *    "data": [
 *        {
 *           "items": {
 *           "group": [
 *                   {
 *                       "name": "172.16.0.211",
 *                       "up_bytes": "13547",
 *                       "down_bytes": "0",
 *                       "total_bytes": "13547"
 *                   },
 *                   {
 *                       "name": "172.16.0.143",
 *                       "up_bytes": "12616",
 *                       "down_bytes": "0",
 *                       "total_bytes": "12616"
 *                   },
 *                   {
 *                       "name": "172.16.0.139",
 *                       "up_bytes": "10856",
 *                       "down_bytes": "0",
 *                       "total_bytes": "10856"
 *                   }
 *               ]
 *           },
 *           "all_total_bytes": 75385
 *       }
 *   ]
 * }
 *
 *
 */


class UserMonitorController extends mController {	
	public $module = 'monitor_users';
	function get($param=array()) {
        $is_return = false;
		if (empty($param)) {
            $param = get_inputs();
        } else {
            $is_return = true;
        }
        
		if (!$param['app_name']) {
			$user_stat = true;
		}

		if ($param['range'] == '1'){
			$num = 60;

		} else if ($param['range'] == '2') { 
			$num = 144;

		} else if ($param['range'] == '3') {
			$num = 168;

		}


		$data = AppMonitorController::get_db_config($num);
		$db = new AppflowDb();
		$db->dbname = '/tmp/result.db';
		/*if(file_exists('/mnt1/mysql/')) {
			$path = '/mnt1/flow_statistic/'.$data['file_path'].'/';
		} else {
			$path = '/var/mem_db/flow_statistic/'.$data['file_path'].'/';
		}*/
		$path='/tmp/flow_statistic/'.$data['file_path'].'/';
		$db -> stat_route($data['data'], $path, $param, true);

		if ($param['user_name']) {
			if($param['category']!=''){
				$data = $db -> user_detail_trend_query('user_cate_detail',200,1);
			}else{
				$data = $db -> user_detail_trend_query('user_detail');
			}
			//var_dump($param,99);exit(0);
		
			
			//$data = $db -> user_detail_trend_query('user_detail');														   
		} else {
			$data = $db -> user_info_sort($param,$user_stat);
		}

        $ret=$data['data'][0]['items']['group'];
        foreach ($ret as $key => $row){
            if($param['direct']=='up'){
                $volume[$key]  = $row['up_bytes'];
            }
            if($param['direct']=='down'){
                $volume[$key] = $row['down_bytes'];
            }
            if($param['direct']=='all'){
                $volume[$key] = $row['total_bytes'];
            }
        }
        if($param['direct']=='up'||$param['direct']=='down'||$param['direct']=='all'){
            array_multisort($volume, SORT_DESC, $ret);
        }

        if ($is_return) {
            return $ret;
        } else {
            $data['data'][0]['items']['group']=$ret;
            echo json_encode($data);            
        }
	}
}
