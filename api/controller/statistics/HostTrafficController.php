<?php
namespace controller\statistics;
use controller\mController;
use database\StatisticDb;

class HostTrafficController extends mController {	
	function get() {
		$db = new StatisticDb();
		$param = get_inputs();
		$where = '';

		if (!isset($param['interf']) || !isset($param['period'])) {
			echo json_encode(array('code'=>'-1','str'=>'Parameter error'));
			return;
		}
		if ($param['start_time'] && $param['end_time'] && $param['start_time']<time() && $param['end_time'] <= time()) {
			$where = ' WHERE "time" > '.$param['start_time'].' AND "time" < '.$param['end_time'];
		}
		$table_middle = '_flow_usage';
		$table_prefix = $this->get_table_prefix($param['interf']);
		$table_suffix = $this->get_table_suffix($param['period']);
		$table_name = $table_prefix . $table_middle . $table_suffix;

		$data = $db->org_query('SELECT AVG(bits_in) AS "bits_in",AVG(bits_out) AS "bits_out" FROM '. $table_name . $where);
		$seconds = $this->get_seconds($param['period']);
		//将流量速率转换为总流量
		$bytes_in = ceil(($data['bits_in'] / 8 * $seconds));
		$bytes_out = ceil(($data['bits_out'] / 8 * $seconds));
		$bytes_total = $bytes_in + $bytes_out;
		echo json_encode(array('bytes_in'=> $bytes_in, 'bytes_out'=> $bytes_out, 'bytes_total'=> $bytes_total));
	}

	protected function get_table_prefix($infname) {
		switch ($infname) {
			case '-1':
				return 'host';
				break;
			default:
				return str_replace('/', '_', $infname);
				break;
		}
	}

	protected function get_table_suffix($period) {
		switch ($period) {
			case '0':
				return '';
				break;
			case '1':
				return '_3hour';
				break;
			case '2':
				return '_1day';
				break;
			case '3':
				return '_1week';
				break;
			case '4':
				return '_1month';
				break;
			default:
				return '';
				break;
		}
	}

	protected function get_seconds($period) {
		switch ($period) {
			case '0':
				return 60 * 30;			//半小时
				break;
			case '1':
				return 3 * 60 * 60;	 	//三小时
				break;
			case '2':
				return 24 * 60 *60;		//一天
				break;
			case '3':
				return 7 * 24 * 60 * 60;//一周
				break;
			case '4':
				return 30 * 24 * 60 * 60;//一个月
				break;
		}		
	}
}
