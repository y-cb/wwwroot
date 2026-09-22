<?php
namespace controller\system;
use controller\mController;
use database\MysqlDb;

class DropLogController extends mController{
	private $log_type = array('ips'=> 'ips_', 'av'=> 'av_', 'web'=> 'web_');
	function post() {
		$param = get_inputs();

		$sql = 'SELECT table_name FROM information_schema.TABLES WHERE `table_name` LIKE \'' . $this->log_type[$param['type']] . '%\'';

		$ret = MysqlDb::sql_query($sql);

		if (!empty($ret)) {
			foreach ($ret as $value) {
				if ($value['table_name']) {
					$sql = 'TRUNCATE TABLE '.$value['table_name'];
					MysqlDb::sql_query($sql);
				}
			}
		}

		return;
	}
}