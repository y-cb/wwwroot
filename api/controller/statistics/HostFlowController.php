<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

class HostFlowController extends mController {	
	function get() {
		$table_name = 'host_flow_usage_1month';
		$db = new StatisticDb();
		$param = get_inputs();
		$where = '';
		$data = array();

		/*if ($param['start_time'] && $param['end_time'] && $param['start_time']<time() && $param['end_time'] <= time()) {
			$where = ' WHERE "time" > '.$param['start_time'].' AND "time" < '.$param['end_time'];
		}*/
		if (!date("Y-m-d H:i:s", $param['start_time']) && !date("Y-m-d H:i:s", $param['end_time'])) {
			echo json_encode(array('code'=> -1, 'str' => 'Time format wrong'));
			return;
		}

		if ($param['start_time'] > $param['end_time']) {
			echo json_encode(array('code'=> -2, 'str' => 'Time range wrong'));
			return;			
		}

		for ($i = $param['start_time']; $i < $param['end_time']; $i += 86400){ 
			$i = strtotime(date('Y-m-d',$i));
			$where = ' WHERE "time" > '.$i.' AND "time" < '.($i + 86400);
			$tmp = $db->org_query('SELECT AVG(bits_in) AS "bits_in",AVG(bits_out) AS "bits_out" FROM '. $table_name . $where);
					//将流量速率转换为总流量
			$bytes_in = ceil(($tmp['bits_in'] / 8 * 86400));
			$bytes_out = ceil(($tmp['bits_out'] / 8 * 86400));
			$bytes_total = $bytes_in + $bytes_out;
			$data[] = array('date'=> date("Y-m-d", $i),'bytes_in'=> $bytes_in, 'bytes_out'=> $bytes_out, 'bytes_total'=> $bytes_total);
		}


		echo json_encode($data);
	}
}
