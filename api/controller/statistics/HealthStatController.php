<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

/**
 * @api {GET} /api/health-stat 获取健康检查信息
 * @apiName 健康检查信息
 * @apiGroup 设备健康统计
 *
 *
 * @apiParam {String} name  接口名称
 * @apiParam {Number} period  时间类型 （0为最近半小时，1为最近三小时，2为最近一天，3为最近一周，4为最近一月）
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *{
    "data": [
        {
            "data": {
                "group": [
                    {
                        "date": "17:27",
                        "loss": "10",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:28",
                        "loss": "20",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:28",
                        "loss": "30",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:28",
                        "loss": "40",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:28",
                        "loss": "50",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:29",
                        "loss": "60",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:29",
                        "loss": "70",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:29",
                        "loss": "80",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:30",
                        "loss": "90",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:30",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:30",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:30",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:31",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:31",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:31",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:31",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:32",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:32",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:32",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:32",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:33",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:33",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:33",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:34",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:34",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:34",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:34",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:35",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:35",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:35",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:35",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:36",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:36",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:36",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:36",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:37",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:37",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:37",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:38",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:38",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:38",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:38",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:39",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:39",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:39",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:39",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:40",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:40",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:40",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:40",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:41",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:41",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    },
                    {
                        "date": "17:41",
                        "loss": "100",
                        "delay": "65535",
                        "jitter": "1"
                    }
                ]
            }
        }
    ]
}
*
* @apiSuccess {String} date  时间
* @apiSuccess {String} loss  链路丢包率
* @apiSuccess {String} delay  链路延时率
* @apiSuccess {String} jitter  链路抖动率
*/



//use lib\ArrayMap;

class HealthStatController extends mController{	
	function get(){
		//可自定义定义数据库文件位置
		$db = new StatisticDb();
		$db->path = '/tmp/hm_statistics.db';
		$param = get_inputs();
		if ($param['name']) {
			switch ($param['period']) {
				case '0':
					$table_name =  '_halfhour_' . md5($param['name'].'_'.$param['inf']);
					break;
				case '5':
					$table_name = '_hour_' . md5($param['name'].'_'.$param['inf']);
					break;
				case '2':
					$table_name = '_day_'  . md5($param['name'].'_'.$param['inf']);
					break;
				case '3':
					$table_name = '_week_' . md5($param['name'].'_'.$param['inf']);
					break;
				// case '4':
				// 	$table_name = $param['name'] . '_month';
				// 	break;
			}

			$res = $db -> org_select($table_name,['time', 'loss', 'delay', 'type', 'jitter']);
			$data= array();
            //将半小时数据细化
            if($param['period'] == 0) {
                $i = 0;
                foreach ($res as $key => $value) {
                    $n;$max;$sum;
                    $tmp_time = $res[$key]['time'];
                    $next_time = $res[$key+1]['time'];
                    $tmp_loss = $res[$key]['loss'];
                    $next_loss = $res[$key+1]['loss'];
                    $tmp_delay = $res[$key]['delay'];
                    $next_delay = $res[$key+1]['delay'];
                    $tmp_jitter = $res[$key]['jitter'];
                    $next_jitter = $res[$key+1]['jitter'];

                    $data[$i]['date']= date('H:i:s', $tmp_time);
                    $data[$i]['loss']= $tmp_loss;
                    $data[$i]['delay']= $tmp_delay;
                    $data[$i]['jitter'] = $tmp_jitter;

                    $i++;

                    if ($next_time - $tmp_time < 10 || $next_time - $tmp_time > 600) {
                        continue;
                    }

                    $n = floor(($next_time - $tmp_time) / 10);

                    for($j = 1; $j <= $n; $j++){
                        $t_time = $tmp_time + $j * 10;
                        $data[$i]['date']= date('H:i:s', $t_time);
                        $data[$i]['loss'] = floor(($next_loss + $tmp_loss)/2);
                        $data[$i]['delay'] = floor(($next_delay + $tmp_delay)/2);
                        $data[$i]['jitter'] = floor(($next_jitter + $tmp_jitter)/2);

                        $i++;
                    }
                }
            } else {
                for($i=0;$i<count($res);$i++){
                    $tmp_time = $res[$i]['time'];
                    $tmp_loss = $res[$i]['loss'];
                    $tmp_delay = $res[$i]['delay'];
                    $tmp_jitter = $res[$i]['jitter'];

                    if ($param['period'] == 0 || $param['period'] == 5) {
                        $data[$i]['date']= date('H:i:s', $tmp_time);
                    }else if ($param['period'] == 1 || $param['period'] == 2 ) {
                        $data[$i]['date']= date('H:i', $tmp_time);
                    }  
                    else {
                        $data[$i]['date']= date('m-d H:i', $tmp_time);
                    }
                    
                    $data[$i]['loss']= $tmp_loss;
                    $data[$i]['delay']= $tmp_delay;
                    $data[$i]['jitter'] = $tmp_jitter;
                }               
            }

			$new_data['data'][0]['data']['group']=$data;
		} else {
			$new_data['data'][0]['data']['group'] = array();
		}


		echo json_encode($new_data);
	}
	/*function get(){
		$map = new ArrayMap();
		$map['period']=$_GET['period'];
		$map['name']=$_GET['interf'];		
		$map['type']=$_GET['type'];
		$flow = getResponse($this->module,"show",$map);	
		$data= array();
		$data = $flow['device_perf']['group'];
		echo json_encode($data);
	}*/
}