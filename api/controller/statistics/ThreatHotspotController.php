<?php
namespace controller\Statistics;
use controller\Controller;
use database\MysqlDb;

/**
 * @api {GET}  /api/threat-hotspot 获取热点情报事件
 * @apiName threat-hotspot
 * @apiGroup 威胁情报统计
 *
 *
 * @apiParam {Number} page 分页，默认为1
 * @apiParam {Number} pageSize 页码，默认为10
 *
 * @apiParamExample {json} Request-Example:
 *	{
 *		"page": "1",
 *		"pageSize": "10"
 *	}
 *
 *
 */

class ThreatHotspotController extends Controller {

	function get(){
		$auditlog_tmpfile= '/tmp/auditlog_tmp.txt';
		if(file_exists($auditlog_tmpfile)){
			$ret = array('code' => '-1000', 'str' => 'log is loading');
			echo json_encode($ret);
			unlink($auditlog_tmpfile);
			return;
		}else{
			$fopen = fopen($auditlog_tmpfile, 'wb');
			fclose($fopen);
		}
		$module = 'ahdb_hot_details';//$_GET['module'];

		$param['page'] = $_GET['page'];
		$database = new MysqlDb();
		$param['count'] = $_GET['pageSize'];

		$idx = ($param['page'] - 1) * $param['count'];
		$num = $param['count'];
		$con = ["LIMIT" => [$idx, $num], "ORDER" => "id DESC"];

		$data = $database->org_select($module,'*',$con);
		$sql_count = $database->org_count($module, 'id', []);


		if($sql_count>5000){
			$sql_count = 5000;
		}
		if (is_array($data)) {
			$ret['data'] = $data;
			$ret['total'] = $sql_count;
			echo json_encode($ret);
			unlink($auditlog_tmpfile);
			return;
		}
		unlink($auditlog_tmpfile);
		//echo '{"data":[]"total":0}';
		$audit_arr = array("data"=>array(),"total"=>0);
		echo json_encode($audit_arr);
		return;
	}	
}
