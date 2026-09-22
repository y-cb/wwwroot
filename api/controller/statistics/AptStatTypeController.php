<?php
namespace controller\statistics;
use controller\mController;
use database\MySQLite3Db;

/**
 * @api {GET}  /api/apt-type 获取沙箱样本类型统计
 * @apiName 获取沙箱样本类型统计
 * @apiGroup 病毒防护统计
 *
 * @apiSuccess {Array} data  对应横坐标统计结果个数
 * @apiSuccess {String} label  统计结果等级
 * @apiSuccess {String} seriesname  统计结果等级
 *
 * @apiSuccessExample {json} Success-Response:
 *	HTTP/1.1 200 OK
 *	{
 *		"categories": [
 *		{
 *			"label":"bmp"
 *		},
 *		{
 *			"label":"exe"
 *		},
 *		{
 *			"label":"txt"
 *		},
 *	],
 *		"dataset": [
 *		{
 *			"data":[1,0,0],
 *			"seriesname":"危险"
 *		},
 *		{
 *			"data":[0,1,0],
 *			"seriesname":"可信"
 *		},
 *		{
 *			"data":[0,0,1],
 *			"seriesname":"未见异常"
 *		},
 *	],
 *	}
 */

class AptStatTypeController extends mController {	
	function get(){
		$avail = array(4, 5, 6);
		$db = new MySQLite3Db('/mnt/boot/apt.db', '/tmp/apt_tmp.db');
		$table_name = 'apt_result';

		$category=array();

		$datasets1=array('seriesname'=>t('apt.level0'));
		$datasets2=array('seriesname'=>t('apt.level1'));
		$datasets3=array('seriesname'=>t('apt.level2'));
		$datasets4=array('seriesname'=>t('apt.level3'));
		$keys=array();
		$sql = 'select filetype from '.$table_name.' group by filetype;';
		$result = $db->query($sql);
		while ($line = $result->fetchArray()) {
			$category = array();
			$category['label'] = $line[0];
			$keys[]=$line[0];
			$categories[]=$category;
		}
		$tmp=array();
		$arr=array();
		foreach ($keys as $val) {
			//$sql = 'select filetype, count(*) from '.$table_name.' where result = '. $val.' group by filetype;';
			$sql = "select filetype,result,count(*) as num from apt_result where filetype='".$val."' group by filetype,result;";
																												  
			$result = $db->query($sql);
			while ($row = $result->fetchArray()) {
				if($row[1]==0){
					$arr[0]=$row[2];
				}else if($row[1]==1){
					$arr[1]=$row[2];
				}else if($row[1]==2){
					$arr[2]=$row[2];
				} else if($row[1]==3) {
					$arr[3]=$row[2];
				}
			}
			
			$tmp[$val][]=$arr;
			$arr=[];
		}			
		$ds1=array();
		$ds2=array();
		$ds3=array();
		$ds4=array();
		foreach ($tmp as $key => $value) {
			// var_dump($value[0]);
			if(array_key_exists(0, $value[0])){
				$ds1= $value[0][0];
			}else{
				$ds1= 0;
			}
			if(array_key_exists(1, $value[0])){
				$ds2= $value[0][1];
			}else{
				$ds2= 0;
			}
			if(array_key_exists(2, $value[0])){
				$ds3= $value[0][2];
			} else{
				$ds3= 0;
			}
			if(array_key_exists(3, $value[0])){
				$ds4= $value[0][3];
			} else{
				$ds4= 0;
			}
			$datasets1['data'][]=$ds1;  
			$datasets2['data'][]=$ds2;  
			$datasets3['data'][]=$ds3;
			$datasets4['data'][]=$ds4;
		}
		header('Content-type: application/json'); 

		$arr = array(
			'categories'=>$categories,
			'dataset'=>array(0=>$datasets1,1=>$datasets2,2=>$datasets3,3=>$datasets4)
		);
		echo json_encode($arr);
	}
}
?>

