<?php
namespace lib;
use lib\Graph;
use lib\MyPdf;
use lib\AccLinePlot;
use database\MysqlDb;
use database\SqliteDb;
use database\StatisticDb;
use database\ReportCache;
use controller\statistics\AppMonitorController;
use controller\statistics\AppMonitorTrendController;
use controller\statistics\UserMonitorController;
use lib\phpoffice\phpword\src\PhpWord\PhpWord;
use lib\PiePlot;
use lib\ArrayMap;
use message\MainModel;

ob_end_clean();
set_time_limit(300);
ignore_user_abort(true);


// require_once('tcpdf_include.php');
/*require_once('../../reports/examples/tcpdf_include.php');
require_once ('../../reports/examples/jpgraph/jpgraph.php');
require_once ('../../reports/examples/jpgraph/jpgraph_line.php');
require_once ('../../reports/examples/jpgraph/jpgraph_date.php');
require_once ('../../reports/examples/jpgraph/jpgraph_bar.php');
require_once ('../../reports/examples/jpgraph/jpgraph_pie.php');*/
// require_once ('../../ui/include/cfgeng.inc');
// require_once ('../../ui/include/func.inc');
// require_once ('../../ui/include/mysqldb_rep.inc');
// require_once ('../../ui/include/sqlitedb.inc');

//require_once('../../ui/include/mysqldb_rep.inc');
//require_once('../../ui/include/sqlitedb.inc');

/*
//计算重复事件值，合成新数组
function getArrayUniqueByKeys($arr,$keystr)
{
    $arr_out = $arr_wish = array();
    $arr_num = array();
    foreach ($arr as $k => $v) {
        $key_out = $v[$keystr]; //提取内部一维数组的key(ip url)作为外部数组的键
        if (array_key_exists($key_out, $arr_out)) {
        	$arr_num[$key_out]['num'] = $arr_num[$key_out]['num']+1;
            continue;
        } else {
            $arr_out[$key_out] = $arr[$k]; //以key_out作为外部数组的键
            $arr_wish[$k] = $arr[$k];  //实现二维数组唯一性
            $arr_num[$key_out]['num'] = 1;
        }
        //$arr_wish[$k]['num'] = $arr_num[$key_out]['num'];
    }

    foreach($arr_wish as $key=>$value){
    	if( in_array($value[$keystr],array_keys($arr_num)) ){
    		$value['num']=$arr_num[$value[$keystr]]['num'];
    		//$value['num']=1;
    		//report_debug($value);
    	}
    	$new_arr[]=$value;
    }
    //report_debug($arr_num);
    return $new_arr;
}
*/

/**
 * 二维数组根据字段进行排序
 * @params array $array 需要排序的数组
 * @params string $field 排序的字段
 * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 */


/*function arraySequence($array, $field, $sort = 'SORT_DESC')
{
    $arrSort = array();
    foreach ($array as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrSort[$key][$uniqid] = $value;
        }
    }
    array_multisort($arrSort[$field], constant($sort), $array);
    return $array;
}*/


DEFINE('INTERVAL1', 1*60);
DEFINE('INTERVAL2', 10*60);
DEFINE('INTERVAL3', 60*60);
DEFINE('INTERVAL4', 60*60*24);
DEFINE('REPORT_PATH', '/mnt1/report_cache.db');
$GLOBALS['language_cmd'] = 'CN';
$global['count'] = 20;

function formatbytes($aVal){
	if($aVal>=0 && $aVal<1000){
		$aVal=$aVal.'B';
	}elseif ($aVal>=1000 && $aVal<1000*1000) {
		$aVal=round($aVal/1000,2);
		$aVal=$aVal.'KB';
	}elseif ($aVal>=1000*1000 && $aVal<1000*1000*1000) {
		$aVal=round($aVal/(1000*1000),2);
		$aVal=$aVal.'MB';
	}else{
		$aVal=round($aVal/(1000*1000*1000),2);
		$aVal=$aVal.'GB';
	}
	return $aVal;
}

function formatkbs($aVal){
	if ($aVal == 0) {
		$aVal = '';
	} elseif($aVal > 0 && $aVal<1000){
		$aVal=$aVal.'b/s';
	} elseif ($aVal>=1000 && $aVal<1000*1000) {
		$aVal=round($aVal/1000,2);
		$aVal=$aVal.'Kb/s';
	} elseif ($aVal>=1000*1000 && $aVal<1000*1000*1000) {
		$aVal=round($aVal/(1000*1000),2);
		$aVal=$aVal.'Mb/s';
	} else{
		$aVal=round($aVal/(1000*1000*1000),2);
		$aVal=$aVal.'Gb/s';
	}
	return $aVal;
}

function formatpercentage($aVal){
	$aVal = $aVal.'%';
	return $aVal;
}

function formattime($aVal){
	$aVal = $aVal.'ms';
	return $aVal;
}

function my_wordwrap($str, $width ,$break= "\r\n",$encoding = 'UTF-8'){
	mb_internal_encoding($encoding);
	$s = '';
	for($i=0,$len=mb_strlen($str);$i<$len;$i+=$width){
		$s .= mb_substr($str,$i,$width).($len-$i>=$width?$break:'' );
	}
	return $s;
}

function report_debug($v)
{
	/*$file_path = '/var/log/wrong.log';
	if (file_exists($file_path)) {
		$data = file_get_contents($file_path);
		$data = json_decode($data);
		$data .= $v;
		$data = json_encode($data);
		file_put_contents($file_path, $data);
	} else {
		$data = json_encode($v);
		file_put_contents($file_path, $data);
	}*/
	return;
}

class AutoReport {
	public $report_map;
	//public $stringb=LocalUtil::getCommonResource('report.app.both');
	//public $stringa=LocalUtil::getCommonResource('object.app.last.one.flow');
	public $colors=array('#9dc8f1','#686887','#90ed7d','#f7a35c','#7277d4','#f15b7f','#e4d354','#2fb1be','#91e8e1','#8d4653','#C3BDBE');
	public $colors2=array('#9dc8f1','#686887','#90ed7d','#f7a35c','#7277d4','#f15b7f','#e4d354','#2fb1be','#91e8e1','#8d4653');
	public $type;
	public $days;
	public $start;
	public $end;

	public $is_av_null;
	public $is_ips_null;
	public $is_def_null;
	public $is_quality_null;
	public $is_security_null;
	public $is_seclevel_null;
	public $is_secsystem_null;
	public $ips_data_table = array();
	public $av_data_table = array();
	public $defense_data_table = array();
	public $def_num;
	public $sec_data_table = array();
	public $app_row_list = array();
	public $app_row_cate = array();
	public $webhost_data_table = array();
	public $webuser_data_table = array();
	public $webcategory_data_table = array();
	public $security_data_table = array();
	public $security_assets_table = array();
	public $null_image_path;
	public $database;

	function __construct($report_map) {

		if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {
			$_SESSION[CONNECTION.ISUPER] = 1;
		}

		$this->days = $report_map['days'];
		$this->report_map = $report_map;
		$this->null_image_path = t('report.no_image_path');
		/*if ($this->days == "monthly"){

            $this->report_map['flow_app']=0;
            $this->report_map['flow_user']=0;

            $this->report_map['system_cpu']=0;
            $this->report_map['system_memory'] = 0;
            $this->report_map['system_flow'] = 0;
            $this->report_map['security_log'] = 0;
        }*/

		if(file_exists(REPORT_PATH)) {
			$this->database = new ReportCache();
		}

		if($report_map['sign_quality'] == 1){
			switch ($this->days) {
				case 'daily':
					$this->report_map['quality_prefix'] = '_day_';
					break;

				default:
					$this->report_map['quality_prefix'] = '_week_';
					break;
			}
		}



		if ($this->days == "userdefined") {
			$this->report_map['flow_app']=0;
			$this->report_map['flow_user']=0;
		}
		$this->set_time($report_map);
	}

	function __destruct() {
		if ($_SERVER[REMOTE_ADDR] == '127.0.0.1') {
			unset($_SESSION[CONNECTION.ISUPER]);
		}
	}

	protected function set_time($report_map)
	{
		$endtime = time() - 6 * 60 * 60;
		$end = date('Y-m-d', $endtime);

		if ($this->days == 'daily') {
			// $start_time = date('Y-m-d', $endtime - 24 * 60 * 60); //此处逻辑会导致自动报表导出数据多一天
			$start_time = $end;
			$start = date($start_time);
			$title_start = $end;
			$type = 'auto';
		} else if ($this->days == 'weekly') {
			// $start_time = date('Y-m-d', $endtime - 7 * 24 * 60 * 60);
			$start_time = date('Y-m-d', $endtime - 6 * 24 * 60 * 60);
			$start = date($start_time);
			// $title_start = date('Y-m-d', $endtime - 6 * 24 * 60 * 60);
			$title_start = $start_time;
			$type = 'auto';
		} else if ($this->days == 'monthly') {
			// $start_time = date('Y-m-d', $endtime - 30 * 24 * 60 * 60);
			//$start_time = date('Y-m-d', $endtime - 29 * 24 * 60 * 60);
			$start_time = date('Y-m-01', $endtime);
			$start = date($start_time);
			$title_start = $start_time;
			$type = 'auto';
		} else if ($this->days == 'userdefined') {
			$start = $report_map['start_time'];
			$end = $report_map['end_time'];
			$title_start = $start;
			$type = 'manual';
		}
		$this->end = $end;
		$this->start = $start;
		$this->title_start=$title_start;
	}

	public function run()
	{
		session_write_close();
		$report_map = $this->report_map;
		report_debug('flow_app');
		if ($report_map['flow_app']) {
			$this->flow_app_report();
			report_debug('flow_app_top');
			$this->flow_app_top_report();
			report_debug('flow_app_cate');
			$this->flow_app_cate_report();
		}
		report_debug('flow_user');
		if ($report_map['flow_user']) {
			$this->flow_user_report();
		}
		report_debug('flow_web');
		if ($report_map['flow_web']) {
			$this->flow_web_access_host();
			$this->flow_web_access_user();
			$this->flow_web_access_category();
		}
		report_debug('signal quality');
		if ($report_map['sign_quality']) {
			$this->health_signal_quality();
		}
		report_debug('security ips');
		if ($report_map['security_ips']) {
			$this->security_ips_report();
		}
		report_debug('security av');
		if ($report_map['security_av']) {
			$this->security_av_report();
		}

		report_debug('security log');
		if ($report_map['security_log']) {
			$this->security_log_report();
		}

		report_debug('threat log');
		if ($report_map['threat_log']) {
			$this->security_threat_report();
		}
		report_debug('system cpu');
		if ($report_map['system_cpu']) {
			$this->system_cpu_report();
		}
		report_debug('system memory');
		if ($report_map['system_memory']) {
			$this->system_memory_report();
		}
		report_debug('system flow');
		if ($report_map['system_flow']) {
			$this->system_flow_report();
		}
		report_debug('security analysis');
		if ($report_map['security_analysis']) {
			$this->security_analysis_report();
			$this->security_assets_analysis();
		}

		//对旧版本未配置适配兼容
		if (!isset($report_map['type'])) {
			$report_map['type'] = 'pdf';
		}

		switch ($report_map['type']) {
			case 'pdf':
				return $this->pdf();
				break;
			case 'wps':
				return $this->word();
				break;
			default:
				# code...
				break;
		}
	}


	/*
    if ($report_map['days'] == 2){
        //计算时间差并取节点
        $report_map['start_time'] = $_POST['start_time'];
        $report_map['end_time'] = $_POST['end_time'];
        $time_diff = strtotime($report_map['end_time'])-strtotime($report_map['start_time']);
        $time_diff = $time_diff/86400;
        //截取每个时间点的时间差
        $time_seconds_diff = $time_diff * 86400;
        $defined_time = ceil($time_seconds_diff/10);

        for ($i = 1 ;$i<11;$i++) {
            $time_short = $defined_time * $i;
            $time_point = strtotime($report_map['start_time']) + $time_short;
            if ($time_point>strtotime($report_map['end_time'])){
                $time_point = strtotime($report_map['end_time']);
            }
            $sysflowdate[$i] = substr(date("Y-m-d",$time_point),5,5);
            $sysmemeorydate[$i] = substr(date("Y-m-d",$time_point),5,5);
            $syscpudate[$i] = substr(date("Y-m-d",$time_point),5,5);
            //遍历取出现有的数据比对，可以匹配上则取值，匹配不上则置空
            foreach ($sysflow_data as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    if ($sysflowdate[$i] == substr($value1['date'],5,5)){

                        $sysflowdevice_in[$i] = (int)$value1['device'];
                        // $sysflowdevice_out[$i] = (int)$value1['down_bytes'];
                    }
                }
            }
            //如果为空则给赋空值
            if (!$sysflowdevice_in[$i]){
                $sysflowdevice_in[$i]=0;
            }
            foreach ($sysmemeory_data as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    if ($sysmemeorydate[$i] == substr($value1['date'],5,5)){
                        $sysmemeoryusage[$i]=(float)$value1['usage'];
                    }
                }
            }
            //如果为空则给赋空值
            if (!$sysmemeoryusage[$i]){
                $sysmemeoryusage[$i]=0;
            }
            foreach ($syscpu_data as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    if ($syscpudate[$i] == substr($value1['date'],5,5)){
                        $syscpuusage[$i]=(float)$value1['usage']*100;
                    }
                }
            }
            if (!$syscpuusage[$i]){
                $syscpuusage[$i]=0;
            }
        }
    }
    */

	function pdf()
	{
		$report_map = $this->report_map;
		// create new PDF document
		$pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetHeaderData('', '', $report_map['title'], '');

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		$pdf->setFontSubsetting(true);
		// set font
		$pdf->SetFont('droidsansfallback', '', 22);

		// add a page
		$pdf->AddPage();
		$pdf->SetXY(25, 80);
		$pdf->MultiCell(160, 20, $report_map['title'], $border=0,$align='C', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		// $pdf->Cell(160, 20, $report_map['title'], 0, 1, 'C');
		// $pdf->SetFont('droidsansfallback', '', 13);
		$desc_date = $this->title_start .t('report.to'). $this->end;
		$pdf->Cell(0, 20, $desc_date, 0, 1, 'C');

		if (isset($report_map['description'])) {
			// $pdf->Cell(180, 20, $report_map['description'], 0, 1, 'C');
			$pdf->MultiCell(180, 20, $report_map['description'], $border=0,$align='C', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		}
		$pdf->SetFont('droidsansfallback', '', 12);

		$pdf->setJPEGQuality(100);

		if (!file_exists('/tmp/webui/lang.conf')) {
			return 'cn';
		}

		if($report_map['flow_app']==1){
			/*$app_module = 'app_profile';
			// $app_items = MainModel::getDataIndex($app_module);
			$app_items = getResponse($app_module, 'show_i', '');
			$app_items = getAssign($app_items, $app_module);
			$app_num = count($app_items);*/

			$pdf->AddPage();
			$pdf->SetFont('droidsansfallback', '', 11);
//			$app_info = t('report.app_des1').$this->app_row_list[0][0].t('report.app_des5');
			$app_info = t('report.app_des1');
			$pdf->Write(10, $app_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image('/tmp/app_up_flow_static.png',  10, 50,0,0, 'png', '', '', true, 150,'C');

//			$header = array(t('report.top_app'), t('report.template_flowin'), t('report.template_flowout'), t("report.template_flowtotal"));
			// print colored table
//			$pdf->ColoredTable($header, array_slice($this->app_row_list, 0, 10), 180, 4);

			$pdf->AddPage();
			$app_top_info = t('report.app_des4').$this->app_row_list[0][0].t('report.app_des5');
			$pdf->Write(10, $app_top_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image('/tmp/app_topten.png',  10, 30,0,0, 'png', '', '', true, 150,'C');

			$header = array(t('report.top_app'), t('report.template_flowin'), t('report.template_flowout'), t("report.template_flowtotal"));
			// print colored table
			$pdf->ColoredTable($header, array_slice($this->app_row_list, 0, 10), 180, 4);

			$pdf->AddPage();
			$category_info = t('report.app_des6')."\n".t('report.app_des7')."\n".t('report.app_des8');
			$pdf->Write(10, $category_info, '', 0, '', false, 0, false, false, 0);
			//$pdf->Cell(0, 0, "上元应用分类总共为20类", 0, $ln=0, 'C', 0, '', 0, false, 'C', 'C');
			$pdf->Image('/tmp/app_category.png',  10, 80,0,0, 'png', '', '', true, 150,'C');
			$pdf->AddPage();
			$appcate_info = t('report.category_des1');
			$pdf->Write(10, $appcate_info, '', 0, '', false, 0, false, false, 0);
			$header_cate = array(t('report.catelist'), t('report.template_flowin'), t('report.template_flowout'), t("report.template_flowtotal"));
			// print colored table
			$pdf->ColoredTable($header_cate, array_slice($this->app_row_cate, 0, 10),25,4);

		}
		if($report_map['flow_user']==1){
			$pdf->AddPage();
			$user_info = t('report.user_flow_des1').$this->user_row_flow[0][0].t('report.user_flow_des2');
			$pdf->Write(10, $user_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image('/tmp/flow_user.png',  10, 30,0,0, 'png', '', '', true, 150,'C');

			$header = array("IP", t('report.template_flowin'), t('report.template_flowout'), t("report.template_flowtotal"));
			// print colored table
			$pdf->ColoredTable($header, array_slice($this->user_row_flow, 0, 10), 150, 4);

		}
		if($report_map['flow_web']==1){
			$pdf->AddPage();
			$sysflow_info = t('report.web_asscess_des1').$this->webhost_data_table[0][0].t('report.user_asscess_des2');
			$pdf->Write(10, $sysflow_info, '', 0, '', false, 0, false, false, 0);
			if ($this->is_null_host == 1){
				$pdf->Image($this->null_image_path,  10, 30,0,0, 'png', '', '', true, 150,'C');
			} else {
				$pdf->Image('/tmp/web_access.png',  10, 30,0,0, 'png', '', '', true, 150,'C');
			}

			$header = array(t('report.web_access_name'), t('report.access_times'));
			// print colored table
			$pdf->ColoredTable($header, $this->webhost_data_table, 150, 2);

			$pdf->AddPage();
			$userflow_info = t('report.user_asscess_des1').$this->webuser_data_table[0][0].t('report.user_asscess_des2');
			$pdf->Write(10, $userflow_info, '', 0, '', false, 0, false, false, 0);
			if ($this->is_null_username == 1){
				$pdf->Image($this->null_image_path,  10, 30,0,0, 'png', '', '', true, 150,'C');
			} else{
				$pdf->Image('/tmp/user_access.png',  10, 30,0,0, 'png', '', '', true, 150,'C');
			}

			$header = array(t('report.web_access_name'), t('report.access_times'));
			// print colored table
			$pdf->ColoredTable($header, $this->webuser_data_table, 150, 2);

			$pdf->AddPage();
			$category_info = t('report.web_category_des1').$this->webcategory_data_table[0][0].t('report.user_asscess_des2');
			$pdf->Write(10, $category_info, '', 0, '', false, 0, false, false, 0);
			if ($this->is_null_category == 1){
				$pdf->Image($this->null_image_path,  10, 30,0,0, 'png', '', '', true, 150,'C');
			} else {
				$pdf->Image('/tmp/web_category.png',  10, 30,0,0, 'png', '', '', true, 150,'C');
			}

			$header = array(t('report.cate_access_name'), t('report.access_times'));
			// print colored table
			$pdf->ColoredTable($header, $this->webcategory_data_table, 150, 2);
		}
		if($report_map['sign_quality'] == 1) {
			$pdf->AddPage();

			if ($this->is_quality_null) {
				$loss_info = $delay_info = $jitter_info = t('report.null_desc');
				$loss_img = $delay_img = $jitter_img = $this->null_image_path;
			}  else {
				$loss_info = t('report.loss_desc');
				$delay_info = t('report.delay_desc');
				$jitter_info = t('report.jitter_desc');
				$loss_img = '/tmp/loss_quality.png';
				$delay_img = '/tmp/delay_quality.png';
				$jitter_img = '/tmp/jitter_quality.png';
			}

			$pdf->Write(10, $loss_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image($loss_img,  10, 30,0,0, 'png', '', '', true, 150,'C');

			$pdf->AddPage();
			$pdf->Write(10, $delay_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image($delay_img,  10, 30,0,0, 'png', '', '', true, 150,'C');

			$pdf->AddPage();
			$pdf->Write(10, $jitter_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image($jitter_img,  10, 30,0,0, 'png', '', '', true, 150,'C');
		}

		if($report_map['security_ips']==1){
			$pdf->AddPage();

			$ips_module = 'ips_set_node';
			$ips_map = array();
			$ips_map['set_name']="All";
			$ips_map['except'] = 0;
			$ips_map['mode'] = 0;
			// $ips_items = MainModel::getConvertedData($ips_module, $ips_map);
			$ips_items = getResponse($ips_module, 'show', $ips_map);
			$ips_items = getAssign($ips_items, $ips_module);
			$ips_num = count($ips_items);
			if($this->is_ips_null!=1){
				$ips_info = t('report.ips_des1').$ips_num.t('report.app_des3')."\n".t('report.ips_des2').$this->ips_data_table[0][0].t('report.ips_des4').$this->ips_data_table[0][1].t('report.ips_des3')."\n".t('report.ips_des5');
				$pdf->Write(10, $ips_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image('/tmp/sec_ips.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			}else{
				$ips_info = t('report.ips_des6');
				$pdf->Write(10, $ips_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}

			//$pdf->SetFont('droidsansfallback', '', 10);
			//$pdf->AddPage();
			// column titles
			$header_ips = array(t('report.ips_setname'), t('report.attack_times'));
			// print colored table
			$pdf->ColoredTable($header_ips, $this->ips_data_table, 190, 2);
		}
		if($report_map['security_av']==1){
			$pdf->AddPage();
			//$pdf->SetFont('droidsansfallback', '', 12);
			if(!$this->is_av_null){
				$av_module = "av_info";
				$av_resp_arr = getResponse( $av_module, "show","","");
				$av_num = $av_resp_arr['av_info']['group']["av_statistics"];
				$av_info = t('report.av_des1').$av_num.t('report.app_des3')."\n".t('report.av_des2').$this->av_data_table[0][0].t('report.ips_des4').$this->av_data_table[0][1].t('report.ips_des3')."\n".t('report.ips_des5');
				$pdf->Write(10, $av_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image('/tmp/sec_av.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			}else{
				$av_info = t('report.av_des3');
				$pdf->Write(10, $av_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}

			$header_av = array(t('report.ips_setname'), t('report.attack_times'));
			// print colored table
			$pdf->ColoredTable($header_av, $this->av_data_table, 190, 2);
		}
		if($report_map['security_log']==1){
			$pdf->AddPage();
			// column titles
			$security_info = t('report.object_security_log')."\n";
			$pdf->Write(10, $security_info, '', 0, '', false, 0, false, false, 0);

			if(!$this->is_null){
				$pdf->Image('/tmp/sec_log.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			} else {
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}
			$header_sec_log = array(t('report.name'), t('report.ips_log_num'));

			// print colored table
			$pdf->ColoredTable($header_sec_log, $this->sec_data_table, 190, 2);
		}
		if($report_map['threat_log']==1){
			$pdf->AddPage();
			//$pdf->SetFont('droidsansfallback', '', 12);
			if(!$this->is_def_null){
				/*$av_module = "av_info";
				$av_resp_arr = getResponse( $av_module, "show","","");
				$av_num = $av_resp_arr['av_info']['group']["av_statistics"];*/
				$defense_info = t('report.def_des1').$this->def_num.t('report.app_des3')."\n".t('report.def_des2').$this->defense_data_table[0][0].t('report.def_des4').$this->defense_data_table[0][1].t('report.ips_des3')."\n".t('report.ips_des5');
				$pdf->Write(10, $defense_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image('/tmp/sec_threat.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			}else{
				$defense_info = t('report.def_des3');
				$pdf->Write(10, $defense_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}

			$header_defense = array(t('report.def_name'), t('report.attack_times'));
			// print colored table
			$pdf->ColoredTable($header_defense, $this->defense_data_table, 190, 2);
		}

		if($report_map['system_flow']==1){
			$pdf->AddPage();
			$sysflow_info = t('report.flow_both_des1');
			$pdf->Write(10, $sysflow_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image('/tmp/sys_flow.png',  10, 30,0,0, 'png', '', '', true, 150,'C');
		}
		if($report_map['system_cpu']==1){
			$pdf->AddPage();
			$syscpu_info = t('report.cpu_usage_des1');
			$pdf->Write(10, $syscpu_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image('/tmp/sys_cpu.png',  10, 30,0,0, 'png', '', '', true, 150,'C');
		}
		if($report_map['system_memory']==1){
			$pdf->AddPage();
			$sysmem_info = t('report.mem_usage_des1');
			$pdf->Write(10, $sysmem_info, '', 0, '', false, 0, false, false, 0);
			$pdf->Image('/tmp/sys_memory.png',  10, 30,0,0, 'png', '', '', true, 150,'C');
		}

		if($report_map['security_analysis'] == 1) {
			$pdf->AddPage();

			if(!$this->is_security_null){
				$security_info = t('report.security_desc');
				$pdf->Write(10, $security_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image('/tmp/security_analysis.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			}else{
				$security_info = t('report.security_null_desc');
				$pdf->Write(10, $security_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}

			$header_security = array(t('report.country'), t('report.nums'), t('report.attacker'), t('report.start_time'), t('report.end_time'));
			// print colored table
			$pdf->ColoredTable($header_security, $this->security_data_table, 190, 51);

			$pdf->AddPage();

			if(!$this->is_seclevel_null) {
				$seclevel_info = t('report.seclevel_desc');
				$pdf->Write(10, $seclevel_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image('/tmp/assets_level.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			} else {
				$seclevel_info = t('report.seclevel_null_desc');
				$pdf->Write(10, $seclevel_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}

			if(!$this->is_secsystem_null) {
				$secsystem_info = t('report.secsysten_desc');
				$pdf->Write(10, $secsystem_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image('/tmp/assets_system.png',  10, 60,0,0, 'png', '', '', true, 150,'C');
			} else {
				$secsystem_info = t('report.secsysten_null_desc');
				$pdf->Write(10, $secsystem_info, '', 0, '', false, 0, false, false, 0);
				$pdf->Image($this->null_image_path,  10, 60,0,0, 'png', '', '', true, 150,'C');
			}

			$header_assets = array(t('report.assets_addr'), t('report.importance'), t('report.os'), t('report.attack_counts'), t('report.risk_level'));
			// print colored table
			$pdf->ColoredTable($header_assets, $this->security_assets_table, 190, 5);
			$pdf->AddPage();
		}



		/*$reportimgdir='/tmp/report_img'; //要操作的目录名

		$filesnames = scandir($reportimgdir);//获取全部文件名

		sort($filesnames,SORT_NUMERIC);//文件名排序，根据数字从小到大排列
		//遍历文件名
		//添加一个页面
		foreach ($filesnames as $name) {
			if(strstr($name,'png')){//如果是图片则添加到pdf中
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
				$pdf->AddPage();
				$filename_new = $reportimgdir.'/'.$name;//拼接文件路径
				//report_debug($filename_new);exit(0);

				                        //gd库操作  读取图片
				///$source = imagecreatefrompng($filename);
				                       //gd库操作  旋转90度
				///$rotate = imagerotate($source, 90, 0);
				                      //gd库操作  生成旋转后的文件放入别的目录中
				///imagejpeg($rotate,$reportimgdir.'\\123\\'.$name.'_1.png');
				                        //tcpdf操作  添加图片到pdf中
				$pdf->Image($filename_new, 10, 20, 0, 0, 'png', '', '', true, 150,"C");

				}
		}
		*/


		//$report_name="asdfhh";

		// $pdf->Output('app_flow_statistic.pdf', 'D');
		//$pdf->Output('app_flow_statistic_'.date("YmdHis").'.pdf', 'F');
		$dir_report = '/mnt1/reports/';
		if(!is_dir($dir_report)){
			mkdir($dir_report,0755,true);
		}

		$report_time = $this->get_report_filename();
		$filename = $dir_report.$report_map['name'].$report_time. '.pdf';
		if ($report_map['days'] != 'userdefined') {
			if (file_exists($filename)) {
				for ($i=1; $i< 1024; $i++) {
					$filename = $dir_report.$report_map['name'].$report_time. "_".$i. '.pdf';
					if (!file_exists($filename)) {
						break;
					}
				}
			}
		}else{
			if (file_exists($filename)) {
				$currentTime = time();
				$filename = $dir_report.$report_map['name'].$report_time. "_".$currentTime. '.pdf';
			}
		}
		$pdf->Output($filename, 'F');
		//echo json_encode("OK");
		return $filename;
	}
	function word()
	{
		$report_map = $this->report_map;
		$file = '/usr/local/wwwroot/sslvpn/word/auto_word.docx';
		$PHPWord = new PhpWord();
		$template = $PHPWord->loadTemplate($file);
		$template->setValue('title',$report_map['title']);

		$template->setValue('start_time', $this->title_start);
		$template->setValue('end_time', $this->end);
		$template->setValue('to', t('report.to'));

		if (isset($report_map['description'])) {
			$template->setValue('description', $report_map['description']);
		} else {
			$template->setValue('description', '');
		}
		$init = ['', '', '',''];

		if ($report_map['flow_app']==1) {
			if (empty($this->app_row_list)) {
				$this->app_row_list[] = $init;
			}
			if (empty($this->app_row_cate)) {
				$this->app_row_cate[] = $init;
			}
		} else {
			$this->app_row_list[] = $init;
			$this->app_row_cate[] = $init;
		}
		if ($report_map['flow_app']==1) {

			$app_info = t('report.app_des1');

			$template->setValue('app_des', $app_info);

			$template->setImageValue('img', ['path'=> '/tmp/app_up_flow_static.png',  'width'=>500, 'height'=>400]);

			$app_row_list = array_slice($this->app_row_list, 0, 10);
			$app_rows = count($app_row_list);
			$app_top_info = t('report.app_des4').$this->app_row_list[0][0].t('report.app_des5');
			$template->setValue('app_des1', $app_top_info);
			$template->setImageValue('img1', ['path'=> '/tmp/app_topten.png', 'width'=>500, 'height'=>400]);

			$template->setValue('top_app1', t('report.top_app'));
			$template->setValue('flowin1', t('report.template_flowin'));
			$template->setValue('flowout1', t('report.template_flowout'));
			$template->setValue('flowtotal1', t('report.template_flowtotal'));

			$template->cloneRow('name_cn1', $app_rows);
			for ($i = 0; $i < $app_rows; $i++) {
				$template->setValue('name_cn1#' . ($i + 1), $this->app_row_list[$i][0]);
				$template->setValue('up_bytes1#' . ($i + 1), $this->app_row_list[$i][1]);
				$template->setValue('down_bytes1#' . ($i + 1), $this->app_row_list[$i][2]);
				$template->setValue('total_bytes1#' . ($i + 1), $this->app_row_list[$i][3]);
			}

			$category_info = t('report.app_des6')."\n".t('report.app_des7')."\n".t('report.app_des8');

			$template->setValue('app_des6', $category_info);

			$template->setImageValue('img2', ['path'=>'/tmp/app_category.png', 'width'=>500, 'height'=>400]);

			$appcate_info = t('report.category_des1');
			$template->setValue('category_des1', $appcate_info);


			$template->setValue('catelist', t('report.catelist'));
			$template->setValue('flowin2', t('report.template_flowin'));
			$template->setValue('flowout2', t('report.template_flowout'));
			$template->setValue('flowtotal2', t('report.template_flowtotal'));


			$app_row_cate = array_slice($this->app_row_cate, 0, 10);

			$cate_row = count($app_row_cate);
			$template->cloneRow('name_cn2',$cate_row);

			for ($i = 0; $i < $cate_row; $i++) {
				$template->setValue('name_cn2#' . ($i + 1), $this->app_row_cate[$i][0]);
				$template->setValue('up_bytes2#' . ($i + 1), $this->app_row_cate[$i][1]);
				$template->setValue('down_bytes2#' . ($i + 1), $this->app_row_cate[$i][2]);
				$template->setValue('total_bytes2#' . ($i + 1), $this->app_row_cate[$i][3]);
			}
		} else {
			$template->setValue('app_des', '');

			$template->setImageValue('img', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('top_app', t('report.top_app'));
			$template->setValue('template_flowin', t('report.template_flowin'));
			$template->setValue('template_flowout', t('report.template_flowout'));
			$template->setValue('template_flowtotal', t('report.template_flowtotal'));

			$template->setValue('name_cn', '');
			$template->setValue('up_bytes', '');
			$template->setValue('down_bytes', '');
			$template->setValue('total_bytes', '');

			$template->setValue('app_des1', '');
			$template->setImageValue('img1',['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('top_app1', t('report.top_app'));
			$template->setValue('flowin1', t('report.template_flowin'));
			$template->setValue('flowout1', t('report.template_flowout'));
			$template->setValue('flowtotal1', t('report.template_flowtotal'));

			$template->setValue('name_cn1', '');
			$template->setValue('up_bytes1','');
			$template->setValue('down_bytes1','');
			$template->setValue('total_bytes1', '');

			$category_info = t('report.app_des6')."\n".t('report.app_des7')."\n".t('report.app_des8');

			$template->setValue('app_des6', $category_info);

			$template->setImageValue('img2', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$appcate_info = t('report.category_des1');
			$template->setValue('category_des1', $appcate_info);


			$template->setValue('catelist', t('report.catelist'));
			$template->setValue('flowin2', t('report.template_flowin'));
			$template->setValue('flowout2', t('report.template_flowout'));
			$template->setValue('flowtotal2', t('report.template_flowtotal'));

			$template->setValue('name_cn2', '');
			$template->setValue('up_bytes2', '');
			$template->setValue('down_bytes2','');
			$template->setValue('total_bytes2','');

		}
		if ($report_map['flow_user']==1) {
			$img3 = '/tmp/flow_user.png';
			if (empty($this->user_row_flow)) {
				$this->user_row_flow[] = $init;
			}
		} else {
			$img3 = $this->null_image_path;
			$this->user_row_flow[] = $init;
		}
		if($report_map['flow_user']==1){
			$user_info = t('report.user_flow_des1').$this->user_row_flow[0][0].t('report.user_flow_des2');

			$template->setValue('user_flow_des1', $user_info);

			$template->setImageValue('img3', ['path' => $img3, 'width'=>500, 'height'=>400]);

			$template->setValue('IP', t('report.catelist'));
			$template->setValue('flowin3', t('report.template_flowin'));
			$template->setValue('flowout3', t('report.template_flowout'));
			$template->setValue('flowtotal3', t('report.template_flowtotal'));

			$row_flow = array_slice($this->user_row_flow, 0, 10);
			$flow_rows = count($row_flow);
			$template->cloneRow('name_cn3', $flow_rows);

			for ($i = 0; $i < $flow_rows; $i++) {
				$template->setValue('name_cn3#' . ($i + 1), $this->user_row_flow[$i][0]);
				$template->setValue('up_bytes3#' . ($i + 1), $this->user_row_flow[$i][1]);
				$template->setValue('down_bytes3#' . ($i + 1), $this->user_row_flow[$i][2]);
				$template->setValue('total_bytes3#' . ($i + 1), $this->user_row_flow[$i][3]);
			}
		} else {
			$template->setValue('user_flow_des1', '');

			$template->setImageValue('img3', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('IP', t('report.catelist'));
			$template->setValue('flowin3', t('report.template_flowin'));
			$template->setValue('flowout3', t('report.template_flowout'));
			$template->setValue('flowtotal3', t('report.template_flowtotal'));

			$template->setValue('name_cn3', $this->user_row_flow[$i][0]);
			$template->setValue('up_bytes3', $this->user_row_flow[$i][1]);
			$template->setValue('down_bytes3', $this->user_row_flow[$i][2]);
			$template->setValue('total_bytes3', $this->user_row_flow[$i][3]);
		}
		if($report_map['flow_web']==1){

			$sysflow_info = t('report.web_asscess_des1').$this->webhost_data_table[0][0].t('report.user_asscess_des2');
			$template->setValue('web_asscess_des1', $sysflow_info);

			if ($this->is_null_host == 1){
				$template->setImageValue('img4', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			} else {
				$template->setImageValue('img4', ['path'=> '/tmp/web_access.png', 'width'=>500, 'height'=>400]);
			}

			$webhost = $this->webhost_data_table;
			$template->setValue('web_access_name', t('report.web_access_name'));
			$template->setValue('access_times', t('report.access_times'));

			$init_data = [0=>'',1=>''];
			if (empty($webhost)) {
				$webhost[] = $init_data;
			}

			$webhost_rows = count($webhost);
			$template->cloneRow('web_access_name_value',$webhost_rows);

			for ($i = 0; $i < $webhost_rows; $i++) {
				$template->setValue('web_access_name_value#' . ($i + 1), $webhost[$i][0]);
				$template->setValue('access_times_value#' . ($i + 1), $webhost[$i][1]);
			}

			$userflow_info = t('report.user_asscess_des1').$this->webuser_data_table[0][0].t('report.user_asscess_des2');
			$template->setValue('user_asscess_des1', $userflow_info);

			if ($this->is_null_username == 1){
				$template->setImageValue('img5', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			} else{
				$template->setImageValue('img5', ['path'=> '/tmp/user_access.png', 'width'=>500, 'height'=>400]);

			}

			$webuser = $this->webuser_data_table;
			$template->setValue('web_access_name1', t('report.web_access_name'));
			$template->setValue('access_times1', t('report.access_times'));
			if (empty($webuser)) {
				$webuser[] = $init_data;
			}

			$webuser_rows = count($webuser);
			$template->cloneRow('web_access_name1_value', $webuser_rows);

			for ($i = 0; $i < $webuser_rows; $i++) {
				$template->setValue('web_access_name1_value#' . ($i + 1), $webuser[$i][0]);
				$template->setValue('access_times1_value#' . ($i + 1), $webuser[$i][1]);
			}

			$category_info = t('report.web_category_des1').$this->webcategory_data_table[0][0].t('report.user_asscess_des2');
			$template->setValue('web_category_des1', $category_info);

			if ($this->is_null_category == 1){
				$template->setImageValue('img6', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			} else {
				$template->setImageValue('img6', ['path'=> '/tmp/web_category.png', 'width'=>500, 'height'=>400]);
			}

			$template->setValue('cate_access_name', t('report.cate_access_name'));
			$template->setValue('access_times2', t('report.access_times'));
			$webcategory = $this->webcategory_data_table;
			if (empty($webcategory)) {
				$webcategory[] = $init_data;
			}
			$webcategory_rows = count($webcategory);
			$template->cloneRow('cate_access_name_value', $webcategory_rows);

			for ($i = 0; $i < $webcategory_rows; $i++) {
				$template->setValue('cate_access_name_value#' . ($i + 1), $webcategory[$i][0]);
				$template->setValue('access_times2_value#' . ($i + 1), $webcategory[$i][1]);
			}
		} else {

			$template->setValue('web_asscess_des1', '');

			$template->setImageValue('img4', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('web_access_name', t('report.web_access_name'));
			$template->setValue('access_times', t('report.access_times'));

			$template->setValue('web_access_name_value', '');
			$template->setValue('access_times_value', '');

			$template->setValue('user_asscess_des1', '');

			$template->setImageValue('img5', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('web_access_name1', t('report.web_access_name'));
			$template->setValue('access_times1', t('report.access_times'));

			$template->setValue('web_access_name1_value','');
			$template->setValue('access_times1_value', '');

			$template->setValue('web_category_des1', '');

			$template->setImageValue('img6', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);


			$template->setValue('cate_access_name', t('report.cate_access_name'));
			$template->setValue('access_times2', t('report.access_times'));

			$template->setValue('cate_access_name_value','');
			$template->setValue('access_times2_value','');

		}
		if($report_map['sign_quality'] == 1) {

			if ($this->is_quality_null) {
				$loss_info = $delay_info = $jitter_info = t('report.null_desc');
				$loss_img = $delay_img = $jitter_img = $this->null_image_path;
			}else {
				$loss_info = t('report.loss_desc');
				$delay_info = t('report.delay_desc');
				$jitter_info = t('report.jitter_desc');
				$loss_img = '/tmp/loss_quality.png';
				$delay_img = '/tmp/delay_quality.png';
				$jitter_img = '/tmp/jitter_quality.png';
			}

			$template->setValues([
				'loss_info' => $loss_info,
				'delay_info' => $delay_info,
				'jitter_info' => $jitter_info,
			]);
			$template->setImageValue('loss_img', ['path' => $loss_img, 'width' => 470, 'height' => 290,]);
			$template->setImageValue('delay_img', ['path' => $delay_img, 'width' => 470, 'height' => 290,]);
			$template->setImageValue('jitter_img', ['path' => $jitter_img, 'width' => 470, 'height' => 290,]);
		}else {
			$loss_info = $delay_info = $jitter_info = t('report.null_desc');
			$loss_img = $delay_img = $jitter_img = $this->null_image_path;
			$template->setValues([
				'loss_info' => $loss_info,
				'delay_info' => $delay_info,
				'jitter_info' => $jitter_info,
			]);
			$template->setImageValue('loss_img', ['path' => $loss_img, 'width' => 470, 'height' => 290,]);
			$template->setImageValue('delay_img', ['path' => $delay_img, 'width' => 470, 'height' => 290,]);
			$template->setImageValue('jitter_img', ['path' => $jitter_img, 'width' => 470, 'height' => 290,]);
		}

		if($report_map['system_flow']==1){
			$sysflow_info = t('report.flow_both_des1');
			$template->setValue('flow_both_des1', $sysflow_info);
			$template->setImageValue('img7', ['path'=> '/tmp/sys_flow.png', 'width'=>500, 'height'=>400]);
		} else {
			$sysflow_info = t('report.flow_both_des1');
			$template->setValue('flow_both_des1', $sysflow_info);
			$template->setImageValue('img7', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
		}
		if($report_map['system_cpu']==1){
			$syscpu_info = t('report.cpu_usage_des1');
			$template->setValue('cpu_usage_des1', $syscpu_info);
			$template->setImageValue('img8', ['path'=> '/tmp/sys_cpu.png', 'width'=>500, 'height'=>400]);
		} else {
			$syscpu_info = t('report.cpu_usage_des1');
			$template->setValue('cpu_usage_des1', $syscpu_info);
			$template->setImageValue('img8', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
		}
		if($report_map['system_memory']==1){
			$sysmem_info = t('report.mem_usage_des1');
			$template->setValue('mem_usage_des1', $sysmem_info);
			$template->setImageValue('img9', ['path'=> '/tmp/sys_memory.png', 'width'=>500, 'height'=>400]);
		} else {
			$sysmem_info = t('report.mem_usage_des1');
			$template->setValue('mem_usage_des1', $sysmem_info);
			$template->setImageValue('img9', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
		}

		if($report_map['security_ips']==1){
			$ips_module = 'ips_set_node';
			$ips_map = new arraymap();
			$ips_map['set_name']="All";
			$ips_map['except'] = 0;
			$ips_map['mode'] = 0;
			$ips_items = MainModel::getConvertedData($ips_module, $ips_map);
			$ips_num = count($ips_items);
			if($this->is_ips_null!=1){
				$ips_info = t('report.ips_des1').$ips_num.t('report.app_des3')."\n".t('report.ips_des2').$this->ips_data_table[0][0].t('report.ips_des4').$this->ips_data_table[0][1].t('report.ips_des3')."\n".t('report.ips_des5');
				$template->setValue('ips_des6', $ips_info);
				$template->setImageValue('img10', ['path'=> '/tmp/sec_ips.png', 'width'=>500, 'height'=>400]);
			}else{
				$ips_info = t('report.ips_des6');
				$template->setValue('ips_des6', $ips_info);
				$template->setImageValue('img10', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			}
			$template->setValue('ips_setname', t('report.ips_setname'));
			$template->setValue('attack_times', t('report.attack_times'));

			$ips = $this->ips_data_table;
			if (empty($ips)) {
				$ips[] = $init_data;
			}

			$ips_rows = count($ips);
			$template->cloneRow('ips_setname_value',$ips_rows);

			for ($i = 0; $i < $ips_rows; $i++) {
				$template->setValue('ips_setname_value#' . ($i + 1), $ips[$i][0]);
				$template->setValue('attack_times_value#' . ($i + 1), $ips[$i][1]);
			}
		} else {
			$ips_map = new arraymap();
			$ips_map['set_name']="All";
			$ips_map['except'] = 0;
			$ips_map['mode'] = 0;
			$ips_info = t('report.ips_des6');
			$template->setValue('ips_des6', $ips_info);
			$template->setImageValue('img10', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			$template->setValue('ips_setname', t('report.ips_setname'));
			$template->setValue('attack_times', t('report.attack_times'));

			$template->setValue('ips_setname_value','');
			$template->setValue('attack_times_value','');
		}
		if($report_map['security_av']==1){
			if(!$this->is_av_null){
				$av_module = "av_info";
				$av_resp_arr = getResponse( $av_module, "show","","");
				$av_num = $av_resp_arr['av_info']['group']["av_statistics"];

				$av_info = t('report.av_des1').$av_num.t('report.app_des3')."\n".t('report.av_des2').$this->av_data_table[0][0].t('report.ips_des4').$this->av_data_table[0][1].t('report.ips_des3')."\n".t('report.ips_des5');
				$template->setValue('av_des1', $av_info);
				$template->setImageValue('img11', ['path'=> '/tmp/sec_av.png', 'width'=>500, 'height'=>400]);
			}else{
				$av_info = t('report.av_des3');
				$template->setValue('av_des1', $av_info);
				$template->setImageValue('img11', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			}

			$template->setValue('ips_setname1', t('report.ips_setname'));
			$template->setValue('attack_times1', t('report.attack_times'));
			$av = $this->av_data_table;
			if (empty($av)) {
				$av[] = $init_data;
			}

			$av_rows = count($av);
			$template->cloneRow('ips_setname1_value',$av_rows);

			for ($i = 0; $i < $av_rows; $i++) {
				$template->setValue('ips_setname1_value#' . ($i + 1), $av[$i][0]);
				$template->setValue('attack_times1_value#' . ($i + 1), $av[$i][1]);
			}
		} else {

			$av_info = t('report.av_des3');
			$template->setValue('av_des1', $av_info);
			$template->setImageValue('img11', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('ips_setname1', t('report.ips_setname'));
			$template->setValue('attack_times1', t('report.attack_times'));

			$template->setValue('ips_setname1_value','');
			$template->setValue('attack_times1_value','');
		}
		if($report_map['security_log']==1){

			$security_info = t('report.object_security_log')."\n";
			$template->setValue('object_security_log', $security_info);

			if(!$this->is_null){
				$template->setImageValue('img12', ['path'=> '/tmp/sec_log.png', 'width'=>500, 'height'=>400]);
			} else {
				$template->setImageValue('img12', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);
			}
			// print colored table
			$template->setValue('report_name', t('report.name'));
			$template->setValue('ips_log_num', t('report.ips_log_num'));

			$sec = $this->sec_data_table;

			if (empty($sec)) {
				$sec[] = $init_data;
			}

			$sec_rows = count($sec);
			$template->cloneRow('report_name_value', $sec_rows);

			for ($i = 0; $i < $sec_rows; $i++) {
				$template->setValue('report_name_value#' . ($i + 1), $sec[$i][0]);
				$template->setValue('ips_log_num_value#' . ($i + 1), $sec[$i][1]);
			}
		} else {
			$security_info = t('report.object_security_log')."\n";
			$template->setValue('object_security_log', $security_info);
			$template->setImageValue('img12', ['path'=> $this->null_image_path, 'width'=>500, 'height'=>400]);

			$template->setValue('report_name', t('report.name'));
			$template->setValue('ips_log_num', t('report.ips_log_num'));

			$template->setValue('report_name_value','');
			$template->setValue('ips_log_num_value','');

		}
		if($report_map['threat_log'] == 1) {
			if(!$this->is_def_null){
				$defense_info = t('report.def_des1').$this->def_num.t('report.app_des3')."\n".t('report.def_des2').$this->defense_data_table[0][0].t('report.def_des4').$this->defense_data_table[0][1].t('report.ips_des3')."\n".t('report.ips_des5');
				$sec_threat_path = '/tmp/sec_threat.png';
			}else{
				$defense_info = t('report.def_des3');
				$sec_threat_path = $this->null_image_path;
			}
			$template->setValue('defense_info', $defense_info);
			$template->setImageValue('sec_threat', [
				'path' => $sec_threat_path,
				'width' => 470,
				'height' => 290,
			]);
			$template->setValues([
				'sec_name' => t('report.def_name'),
				'sec_nums' => t('report.attack_times'),
			]);

			$defense = $this->defense_data_table;
			if (empty($defense)) {
				$defense[] = $init_data;
			}

			$defense_row = count($defense);

			$template->cloneRow('sec_name_value',$defense_row);

			for ($i = 0; $i < $defense_row; $i++) {
				$template->setValue('sec_name_value#' . ($i+1), $defense[$i][0]);
				$template->setValue('sec_num_value#' . ($i+1), $defense[$i][1]);
			}
		}else {
			$defense_info = t('report.def_des3');
			$sec_threat_path = $this->null_image_path;
			$template->setValue('defense_info', $defense_info);
			$template->setImageValue('sec_threat', [
				'path' => $sec_threat_path,
				'width' => 470,
				'height' => 290,
			]);
			$template->setValues([
				'sec_name' => t('report.def_name'),
				'sec_nums' => t('report.attack_times'),
				'sec_name_value' => '',
				'sec_num_value' => '',
			]);
		}

		$dir_report = '/mnt1/reports/';
		if(!is_dir($dir_report)){
			mkdir($dir_report,0755,true);
		}
		$report_time = $this->get_report_filename();
		$file = $report_map['name'].$report_time. '.wps';

		if ($report_map['days'] != 'userdefined') {
			if (file_exists($dir_report.$file)) {
				for ($i=1; $i< 1024; $i++) {
					$file = $report_map['name'].$report_time. "_".$i. '.wps';//文件名
					if (!file_exists($dir_report.$file)) {
						break;
					}
				}
			}
		}else{
			if (file_exists($dir_report.$file)) {
				$currentTime = time();
				$file = $report_map['name'].$report_time. "_".$currentTime. '.wps';
			}
		}
		$template->saveAs($dir_report.$file);
		return $dir_report.$file;
	}
	protected function get_report_filename() {
		$report_map = $this->report_map;
		$time = time() - 3600;

		if ($this->days == 'daily') {
			$report_filename = "_day_".date("Ymd",$time);
		} else if ($this->days == 'weekly') {
			$report_filename = "_week_".date("Ymd",$time);
		} else if ($this->days == 'monthly') {
			$report_filename = "_month_".date("Ymd",$time);
		} else if ($this->days == 'userdefined') {
			$report_filename = "_".$report_map['start_time']."_".$report_map['end_time'];
		}
		return $report_filename;
	}

	/**
	 * 应用流量对象图片生成
	 * @param  [array] $app_map 查询条件
	 * @param [intval] $days 时长
	 */
	protected function get_app_map() {
		$app_map = array();
		if ($this->days == 'daily') {
			$app_map['range'] = 2;
		} else if ($this->days == 'weekly') {
			$app_map['range'] = 3;
		} else if ($this->days == 'monthly') {
			$app_map['range'] = 4;
		}
		$app_map['direct']="all";
		return $app_map;
	}

	protected function get_app_cate_map() {
		$app_cate_map = $this->get_app_map();
		$app_cate_map['category'] = 1;
		$app_cate_map['count'] = 20;
		return $app_cate_map;
	}

	protected function get_table_name($module_name) {
		if ($this->days == 'daily') {
			$table_name = $module_name . '_usage_1day';
		} else if ($this->days == 'weekly') {
			$table_name = $module_name . '_usage_1week';
		} else if ($this->days == 'monthly') {
			$table_name = $module_name . '_usage_1month';
		} else {
			//自定义后期开发
			// $sys_map['period'] = 5;
			$table_name = $module_name . '_usage_1month';
		}
		return $table_name;
	}
	protected function get_sys_interval() {
		if ($this->days == 'daily') {
			return 2;
		} else if ($this->days == 'weekly') {
			return 4;
		} else if ($this->days == 'monthly') {
			return 4;
		}
		return 4;
	}


	protected function flow_app_report() {
		$label=array();
		$upbytes=array();
		$downbytes=array();
		$totalbytes=array();
		$app_row_flow=array();
		$app_map = $this->get_app_map();
		//生成图片标题
		if ($this->days == 'daily') {
			$stringa=LocalUtil::getCommonResource('object.app.last.day.flow');
		} elseif ($this->days =='weekly') {
			$stringa=LocalUtil::getCommonResource('object.app.last.week.flow');
		} elseif($this->days == 'monthly') {
			$stringa=LocalUtil::getCommonResource('report.every_month');
		}
		//查询数据
		$apps = new AppMonitorTrendController();
		$appsflow = $apps->get($app_map);
		$time = time();
		$start = floor($time/INTERVAL1)*INTERVAL1;
		$times = array();
		$interval;

		if (empty($appsflow)){
			return $this->draw_null_bar('/tmp/app_up_flow_static.png', $stringa);
		}

		//每天
		if ($this->days == 'daily') {
			for ($i=143; $i >= 0; $i-- ) {
				if($i==143){
					$times[$i] = $start-INTERVAL2;
				}else{
					$times[$i] = $times[$i+1]-INTERVAL2;

				}
			}
			$interval = 2;
		} elseif($this->days=='weekly') {
			for( $i=167; $i >= 0; $i-- ) {
				if($i==167){
					$times[$i] = (floor($time/INTERVAL3)*INTERVAL3)-INTERVAL3;
				}else{
					$times[$i] = $times[$i+1]-INTERVAL3;
				}
			}
			$interval = 2;
		} elseif($this->days=='monthly') {
			$end_arr = explode('-',$this->$end);
			$month_day_num = (int)$end_arr[2];//当月总天数
			$month_day_index = $month_day_num - 1;
			//逻辑稍后添加,选择每月不展示应用流量
			for( $i= $month_day_index; $i >= 0; $i-- ) {
				if($i == $month_day_index){
					$times[$i] = (floor($time/INTERVAL4)*INTERVAL4)-INTERVAL4;
				}else{
					$times[$i] = $times[$i+1]-INTERVAL4;
				}
			}
			$interval = 4;
		}

		//统计标点
		// $group = $appsflow['monitor_apps_trend']['group']['items']['group'];
		if ($appsflow['name']) {
			$label[]=$appsflow['name_cn'];
			$upbytes[]=$appsflow['up_bytes'];
			$downbytes[]=$appsflow['down_bytes'];
			$totalbytes[]=$appsflow['total_bytes'];
			$col=array();
			$col[0]=$appsflow['name_cn'];
			$col[1]=formatbytes($appsflow['up_bytes']);
			$col[2]=formatbytes($appsflow['down_bytes']);
			$col[3]=formatbytes($appsflow['total_bytes']);
			$app_row_flow[]=$col;
		} else {
			foreach ($appsflow as $key => $value) {
				$label[]=$value['name_cn'];
				$upbytes[]=$value['up_bytes'];
				$downbytes[]=$value['down_bytes'];
				$totalbytes[]=$value['total_bytes'];
				$col=array();
				$col[0]=$value['name_cn'];
				$col[1]=formatbytes($value['up_bytes']);
				$col[2]=formatbytes($value['down_bytes']);
				$col[3]=formatbytes($value['total_bytes']);
				$app_row_flow[]=$col;
			}
		}
		//生成图片
		$graph = new Graph(600, 440);
		$graph->SetScale('datlin');
		$graph->SetShadow();
		//$graph->SetMargin(70, 30, 20, 200);
		$graph->SetMargin(70, 30, 20, 80);

		foreach ($label as $key => $value) {
			$datasValue=explode(',', $totalbytes[$key]);

			foreach ($datasValue as $key1 => $value1) {
				if ($value1=="") {
					$datasValue[$key1]="0";
				}else{
					// $datasValue[$key1]=formatkbs($value1);
					$datasValue[$key1]=$value1;
				}
			}
			$dplot[]=new LinePlot($datasValue,$times);
			$dplot[$key]->SetFillColor($this->colors[$key]);
			$dplot[$key]->SetLegend($value);
			$dplot[$key]->SetColor($this->colors[$key]);
		}
		// 叠加的时候用
		// $accplot = new AccLinePlot($dplot);
		$accplot = new AccLinePlot(array_reverse($dplot));

		$graph->Add($accplot);
		$graph->xaxis->SetTextLabelInterval($interval);
		$graph->xaxis->SetLabelAngle(10);
		// Use hour:minute format for the labels
		$graph->xaxis->scale->SetDateFormat('m-d H:i');
		$graph->title->Set($this->stringa.t('report.app.app').$this->stringb.t('report.app.area'));
		$graph->yaxis->SetLabelFormatCallback('lib\formatkbs');

		$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		//$graph->legend->SetShadow('gray@0.4',5);
		$graph->legend->SetPos(0.5, 0.99,'center','bottom');
		$graph->legend->SetColumns(4);

		$graph->Stroke('/tmp/app_up_flow_static.png');
	}

	/**
	 * 应用流量排行图片生成
	 * @param [array] $app_map 后台接口查询条件
	 * @param [intval] $days 时长
	 */
	protected function flow_app_top_report(){
		$label_list=array();
		$upbytes_list=array();
		$downbytes_list=array();
		$totalbytes_list=array();
		$app_map = $this->get_app_map();
		$title = $this->stringa." ".t('report.app_top10');

		$app = new AppMonitorController();
		$group = $app->get($app_map);

		if (empty($group)){
			return $this->draw_null_bar('/tmp/app_topten.png', $title);
		}

		$group = $group['data'][0]['items']['group'];
		//没有进行单条数据处理case及数据返回为空case
		if ($group['name']) {
			$label_list[] = $group['name_cn'];
			$upbytes_list[] = $group['up_bytes'];
			$downbytes_list[]=$group['down_bytes'];
			$totalbytes_list[]=$group['total_bytes'];
			$col=array();
			$col[0]=$group['name_cn'];
			$col[1]=formatbytes($group['up_bytes']);
			$col[2]=formatbytes($group['down_bytes']);
			$col[3]=formatbytes($group['total_bytes']);
			$this->app_row_list[]=$col;
		} else {
			foreach ($group as $key => $value1) {
				$label_list[] = $value1['name_cn'];
				$upbytes_list[] = $value1['up_bytes'];
				$downbytes_list[]=$value1['down_bytes'];
				$totalbytes_list[]=$value1['total_bytes'];
				$col=array();
				$col[0]=$value1['name_cn'];
				$col[1]=formatbytes($value1['up_bytes']);
				$col[2]=formatbytes($value1['down_bytes']);
				$col[3]=formatbytes($value1['total_bytes']);
				$this->app_row_list[]=$col;
			}
		}
		//生成图片
		$datay=array();
		$datax=array();


		$label_top10list=array_slice($label_list,0,10);
		$datax=$label_top10list;
		$datay=array_slice($totalbytes_list,0,10);

		if(empty($datax) && empty($datay)){
			$datay=array(0);
			$datax=array(t('report.app_nodata'));
		}

		$graph = new Graph(600,440);
		$graph->SetScale("textlin");
		//$graph->Set90AndMargin(130,80,20,70);
		$graph->SetShadow();

		$graph->title->Set($title);

		$graph->xaxis->SetTickLabels($datax);
		// We don't want to display Y-axis
		// $graph->yaxis->Hide();

		// Now create a bar pot
		$bplot = new BarPlot($datay);

		$bplot->SetShadow();
		$graph->Add($bplot);
		$bplot->SetFillColor($this->colors2);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->yaxis->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->SetLabelAngle(20);
		$graph->yaxis->SetLabelFormatCallback('lib\formatbytes');
		$bplot->value->Show();

		$bplot->value->SetFont(FF_SIMSUN,FS_BOLD);

		// $bplot->value->SetAngle(45);
		$bplot->value->SetFormatCallback("lib\formatbytes");
		$graph->SetMargin(80, 30, 20, 80);
		// $bplot->value->SetAlign('left','center');
		$bplot->SetValuePos('top');
		$bplot->value->SetColor("black","darkred");
		$graph->Stroke('/tmp/app_topten.png');
	}

	/**
	 * 应用分类流量图片生成
	 * @param  [array] $app_cate_map 应用分类接口查询条件
	 * @param  [intval] $days 时长
	 */
	protected function flow_app_cate_report(){
		$label_cate=array();
		$upbytes_cate=array();
		$downbytes_cate=array();
		$totalbytes_cate=array();
		$app_cate_map = $this->get_app_cate_map();
		$title = $stringa.t('report.catelist').$stringb.t('report.app_bar');

		/*$appscate = getResponse('monitor_apps', "showone" , $app_cate_map, "");

		//数据整合
		$group = $appscate['monitor_apps']['group']['items']['group'];*/

		$app = new AppMonitorController();
		$group = $app->get($app_cate_map);
		$group = $group['data'][0]['items']['group'];
		if (empty($group)) {
			$this->draw_null_bar("/tmp/app_category.png", $title);
			return;
		}

		if ($group['name']) {
			$label_cate[]=$group['name_cn'];
			$upbytes_cate[]=$group['up_bytes'];
			$downbytes_cate[]=$group['down_bytes'];
			$totalbytes_cate[]=$group['total_bytes'];
			$col=array();
			$col[0]=$group['name_cn'];
			$col[1]=formatbytes($group['up_bytes']);
			$col[2]=formatbytes($group['down_bytes']);
			$col[3]=formatbytes($group['total_bytes']);
			$this->app_row_cate[]=$col;
		} else {
			foreach ($group as $key1 => $value1) {
				$label_cate[$key1]=$value1['name_cn'];
				$upbytes_cate[$key1]=$value1['up_bytes'];
				$downbytes_cate[$key1]=$value1['down_bytes'];
				$totalbytes_cate[$key1]=$value1['total_bytes'];
				$col=array();
				$col[0]=$value1['name_cn'];
				$col[1]=formatbytes($value1['up_bytes']);
				$col[2]=formatbytes($value1['down_bytes']);
				$col[3]=formatbytes($value1['total_bytes']);
				$this->app_row_cate[$key1]=$col;
			}
		}


		//生成饼图
		$graph1 = new PieGraph(630, 440);
		$graph1->SetShadow();

		$graph1->title->Set($title);
		$graph1->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph1->legend->Pos(0.25, 0.9, 'left', 'top');

		$top10_totalbytes_cate = array();
		$top10_label_cate = array();
		$other_flow = 0;
		$tmp_arr = array();
		$byte_sum = array_sum($totalbytes_cate);

		if( sizeof($totalbytes_cate)>10 ){
			foreach($totalbytes_cate as $key => $value){
				$tmp_arr[$key]['name'] = $label_cate[$key];
				$tmp_arr[$key]['value'] = $value;
			}
			$new_byte_arr = array_slice($tmp_arr, 0, 10);

			foreach($new_byte_arr as $key=>$val){
				if($key<10 && (int)$val['value']>$byte_sum/120 ){

					$top10_totalbytes_cate[] = (int)$val['value'];
					$top10_label_cate[] = $val['name'];
				}else{
					$other_flow +=  $val['value'];
				}
			}
			array_push($top10_totalbytes_cate, $other_flow);
			array_push($top10_label_cate, t('report.url_category'));
		}else{
			$top10_totalbytes_cate = $totalbytes_cate;
			$top10_label_cate = $label_cate;
		}
		$pieplot1 = new PiePlot($top10_totalbytes_cate);
		$pieplot1->SetGuideLines();

		$pieplot1->SetLegends($top10_label_cate);
		$pieplot1->SetCenter(0.5,0.5);
		$graph1->Add($pieplot1);

		$graph1->Stroke('/tmp/app_category.png');
	}

	/**
	 * 用户流量图片生成
	 * @param  [array] $app_map 用户流量查询条件
	 * @param  [intval] $days 时长
	 */
	protected function flow_user_report(){
		$label_user=array();
		$upbytes_user=array();
		$downbytes_user=array();
		$totalbytes_user=array();
		$app_map = $this->get_app_map();

		$module =new UserMonitorController();
		$usrflow = $module->get($app_map);

		foreach ($usrflow as $key => $value) {
			$label_user[] = $value['name'];
			$upbytes_user[]=$value['up_bytes'];
			$downbytes_user[]=$value['down_bytes'];
			$totalbytes_user[]=round($value['total_bytes']/(1000*1000),2);

			$col=array();
			$col[0]=$value['name'];
			$col[1]=formatbytes($value['up_bytes']);
			$col[2]=formatbytes($value['down_bytes']);
			$col[3]=formatbytes($value['total_bytes']);
			$this->user_row_flow[]=$col;
			/*foreach ($value as $key1 => $value1) {
				// $label_user[$key1]=my_wordwrap($value1['name'],4);
				$label_user[$key1] = $value1['name'];
		 		$upbytes_user[$key1]=$value1['up_bytes'];
				$downbytes_user[$key1]=$value1['down_bytes'];
				$totalbytes_user[$key1]=round($value1['total_bytes'], 2);
				$col=array();

				$col[0]=$value1['name'];
				$col[1]=formatbytes($value1['up_bytes']);
				$col[2]=formatbytes($value1['down_bytes']);
				$col[3]=formatbytes($value1['total_bytes']);
				$this->user_row_flow[$key1]=$col;

			}*/
		}
		//生成图片
		$user_xdata = array_slice($label_user,0,10,true);
		$user_ydata = array_slice($totalbytes_user,0,10,true);
		$title = t('report.statics_user_flow');
		$this->draw_bar("/tmp/flow_user.png", $title, $user_xdata, $user_ydata, "formatbytes");
	}

	function draw_null_bar($path, $title)
	{
		$xdata = [""];
		$ydata = [""];
		return $this->draw_bar($path, $title, $xdata, $ydata);
	}

	function draw_bar($path, $title, $xdata, $ydata, $ycallback=null)
	{
		if (empty($xdata) || empty($ydata)) {
			return $this->draw_null_bar($path, $title);
		}

		// Create the graph. These two calls are always required
		$graph = new Graph(630, 440, 'auto');
		$graph->SetScale("textlin");
		$graph->img->SetMargin(60, 50, 20, 140);// 设置图表灰度四周边距，顺序为左右上下

		if ($ycallback) {
			$ycallback = 'lib\\'.$ycallback;
			$graph->yaxis->SetLabelFormatCallback($ycallback);
		}
		$graph->xaxis->SetLabelAngle(45);
		$graph->xaxis->SetFont(FF_SIMSUN, FS_BOLD);

		$graph->xaxis->SetTickLabels($xdata);
		// Create the bar plots
		$b1plot = new BarPlot($ydata);

		// ...and add it to the graPH
		$graph->Add($b1plot);
		//$b1plot->value->Show();
		$graph->title->SetFont(FF_SIMSUN, FS_BOLD);//设置字体
		$graph->title->Set($title);

		$graph->Stroke($path);
	}

	function draw_usage_line($path, $title, $xdata, $ydata, $type='cpu')
	{
		if (empty($xdata) || empty($ydata)) {
			return $this->draw_null_bar($path, $title);
		}

		$sys_graph = new Graph(630,440);//创建统计图对象
		$sys_graph->SetScale('textlin');//设置刻度样式datlin
		$sys_graph->SetShadow();//设置背景带阴影
		$sys_graph->img->SetMargin(60, 50, 20, 80);// 设置图表灰度四周边距，顺序为左右上下
		$sys_graph->title->Set($title);

		$lineplot = new LinePlot($ydata);//建立LinePlot对象
		//$lineplot->SetFillFromYMax();

		$sys_graph->Add($lineplot);

		if ($type == 'cpu') {
			$lineplot->SetFillGradient('#FFFFFF','#aaaFFF');
			$lineplot->SetColor('#6495ED');
		} else {
			$lineplot->SetFillGradient('#FFFFFF','#FFFF00');
			$lineplot->SetColor('#FFFF00');
		}

		$sys_graph->xaxis->SetLabelAngle(45);

		// $sys_graph->xaxis->SetTextLabelInterval($this->get_sys_interval());
		$count = 1;
		if (count($xdata) > 10) {
			$count = floor(count($xdata)/10);
		}

		$sys_graph->xaxis->SetTextLabelInterval($count);
		$sys_graph->xaxis->SetTickLabels($xdata);

		$sys_graph->yaxis->SetLabelFormatCallback('lib\formatpercentage');

		$sys_graph->yaxis->title->SetMargin(10);//设置左边的title到图的距离
		$sys_graph->title->SetFont(FF_SIMSUN, FS_BOLD);//设置字体
		$sys_graph->yaxis->title->SetFont(FF_SIMSUN, FS_BOLD);
		$sys_graph->xaxis->title->SetFont(FF_SIMSUN, FS_BOLD);

		//图例文字框的位置 0.4，0.95 是以右上角为基准的，0.4是距左右距离，0.95是上下距离。
		$sys_graph->Stroke($path);
	}


	/**
	 * 报表生成ips图片
	 * @param timestamp $start 开始时间
	 * @param timestamp $end 结束时间
	 */
	function security_ips_report()
	{
		$path = '/tmp/sec_ips.png';
		$title = t('report.ips_attack_protection_top10');
		if(file_exists(REPORT_PATH)) {
            $ips_data = $this->database->get_cahce_data('ips', $this->start, $this->end);
		} else {
            $ips_data = MysqlDb::report_query('ips', 'eventname',  $this->start, $this->end);
		}

		if (empty($ips_data)) {
			$this->is_ips_null = 1;
			return;
			// return $this->draw_null_bar($path, $title);
		}
		foreach($ips_data as $key=>$value){
			$ips_xdata_all[] = mb_substr($value['eventname'], 0, 12 , "UTF8");
//			$ips_xdata_all[] = my_wordwrap(mb_substr($value['eventname'], 0, 30, "UTF8"),10);
			$ips_ydata_all[] = $value['num'];
			$col=array();
			$col[0]=strlen($value['eventname'])>68? mb_substr($value['eventname'], 0, 68, "UTF8"): $value['eventname'];
			$col[1]=$value['num'];
			$this->ips_data_table[$key]=$col;
		}
		$this->draw_bar($path, $title, $ips_xdata_all, $ips_ydata_all);
		return;
	}

	/**
	 * 报表生成av图片
	 * @param timestamp $start 开始时间
	 * @param timestamp $end 结束时间
	 */
	function security_av_report()
	{
		$path = '/tmp/sec_av.png';
		$title = t('report.av_attack_protection_top10');
        if(file_exists(REPORT_PATH)) {
            $av_data = $this->database->get_cahce_data('av', $this->start, $this->end);
        } else {
            $av_data = MysqlDb::report_query('av', 'virusname',  $this->start, $this->end);
        }

		if (empty($av_data)) {
			$this->is_av_null = 1;
			return;
			// return $this->draw_null_bar($path, $title);
		}

		foreach($av_data as $key=>$value) {
			$av_xdata_all[] = mb_substr($value['virusname'], 0, 12, "UTF8");
//			$av_xdata_all[] = my_wordwrap(mb_substr($value['virusname'], 0, 16, "UTF8"), 8);
			$av_ydata_all[] = $value['num'];

			$col=array();
			$col[0]=$value['virusname'];
			$col[1]=$value['num'];
			$this->av_data_table[$key]=$col;
		}
		$av_xdata = array_slice($av_xdata_all,0,10,true);
		$av_ydata = array_slice($av_ydata_all,0,10,true);
		$this->draw_bar($path, $title, $av_xdata, $av_ydata);
		return;
	}

	/**
	 * 报表生成威胁情报图片
	 * @param timestamp $start 开始时间
	 * @param timestamp $end 结束时间
	 */
	function security_threat_report()
	{
		$path = '/tmp/sec_threat.png';
		$title = t('report.threat_protection_top10');
		$defense_data = MysqlDb::report_query('defense', 'object',  $this->start, $this->end);
		if (empty($defense_data)) {
			$this->is_def_null = 1;
			return;
		}

		foreach($defense_data as $key=>$value) {
			$def_xdata_all[] = my_wordwrap($value['object'], 12);
//			$def_xdata_all[] = my_wordwrap(mb_substr($value['object'], 0, 8, "UTF8"), 8);
			$def_ydata_all[] = $value['num'];

			$col=array();
			$col[0]=$value['object'];
			$col[1]=$value['num'];
			$this->defense_data_table[$key]=$col;
		}
		$def_xdata = array_slice($def_xdata_all,0,10,true);
		$def_ydata = array_slice($def_ydata_all,0,10,true);
		$this->draw_bar($path, $title, $def_xdata, $def_ydata);

		//获取情报事件数量
		$this->def_num = MysqlDb::org_count('ahdb_hot_details', 'id', []);
		return;
	}

	/**
	 * 报表生成日志图片
	 * @param timestamp $start 开始时间
	 * @param timestamp $end 结束时间
	 */
	function security_log_report()
	{
		$start = $this->start;
		$end = $this->end;

		$query_where_flood = ["type"=>"FLOOD"];
		$query_where_apt = ["type"=>"APT"];
		$query_where_filter = ["type"=>"FILTER"];
		$query_where_scan = ["type"=>"SCAN"];
		$query_where_attack = ["type"=>"ATTACK"];
		$query_where_user_bf = ["type"=>"USER_BF"];
		$query_where_resplcy = ["type"=>"USER_RESPLCY"];
		$query_where_serv = ["type"=>"SERV_EXCONN_PLCY"];
		$query_where_violent= ["type"=>"VIOLENT"];

		if(file_exists('/mnt1/mysql/')){

			$db = new MysqlDb();
			$security_data_arr_flood_len = $db -> report_sec_query('security_log',$start,$end,$query_where_flood);
			$security_data_arr_apt_len = $db -> report_sec_query('security_log',$start,$end,$query_where_apt);
			$security_data_arr_filter_len = $db -> report_sec_query('security_log',$start,$end,$query_where_filter);
			$security_data_arr_scan_len = $db -> report_sec_query('security_log',$start,$end,$query_where_scan);
			$security_data_arr_attack_len = $db -> report_sec_query('security_log',$start,$end,$query_where_attack);
			$security_data_arr_user_bf_len = $db -> report_sec_query('security_log',$start,$end,$query_where_user_bf);
			$security_data_arr_resplcy_len = $db -> report_sec_query('security_log',$start,$end,$query_where_resplcy);
			$security_data_arr_serv_len = $db -> report_sec_query('security_log',$start,$end,$query_where_serv);
			$security_data_arr_violent_len = $db -> report_sec_query('security_log',$start,$end,$query_where_violent);
		}else{
			$sqlitedb = new SqliteDb();
			$security_data_arr_flood_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_flood);
			$security_data_arr_apt_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_apt);
			$security_data_arr_filter_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_filter);
			$security_data_arr_scan_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_scan);
			$security_data_arr_attack_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_attack);
			$security_data_arr_user_bf_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_user_bf);
			$security_data_arr_resplcy_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_resplcy);
			$security_data_arr_serv_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_serv);
			$security_data_arr_violent_len = $sqlitedb -> sys_report_log_query('security_log',$start,$end,$query_where_violent);
		}
		$security_len_arr = [
			$security_data_arr_flood_len,
			$security_data_arr_apt_len,
			$security_data_arr_filter_len,
			$security_data_arr_scan_len,
			$security_data_arr_attack_len,
			$security_data_arr_user_bf_len,
			$security_data_arr_resplcy_len,
			$security_data_arr_serv_len,
			$security_data_arr_violent_len
		];
		$security_name_arr = [t('log.module63'),t('log.module64'),t('log.module14'),t('log.module24'),t('log.module2'),t('log.module79'),t('log.module80'),t('log.module87'),t('log.module88')];
		$seclog_arr = [
			[t('log.module64'),$security_data_arr_apt_len],
			[t('log.module63'),$security_data_arr_flood_len],
			[t('log.module14'),$security_data_arr_filter_len],
			[t('log.module24'),$security_data_arr_scan_len],
			[t('log.module2'),$security_data_arr_attack_len],
			[t('log.module79'),$security_data_arr_user_bf_len],
			[t('log.module80'),$security_data_arr_resplcy_len],
			[t('log.module87'),$security_data_arr_serv_len],
			[t('log.module88'),$security_data_arr_violent_len],
		];
		$this->sec_data_table = $seclog_arr;

		$this->is_null = true;
		foreach($security_len_arr as $k=>$item) {
			if ($item > 0) {
				$this->is_null = false;
			}
			if ($item == 0){
				unset($security_len_arr[$k]);
				unset($security_name_arr[$k]);
			}
		}
		if ($this->is_null) {
			/*$this->draw_null_bar("/tmp/sec_log.png", LocalUtil::getCommonResource('report.object.security.log.title'));*/

			return;
		}
		//生成饼图
		$graph1 = new PieGraph(630, 440);
		$graph1->SetShadow();

		$graph1->title->Set(t('report.object_security_log'));
		$graph1->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph1->legend->Pos(0.25, 0.9, 'left', 'top');

		$pieplot1 = new PiePlot($security_len_arr);

		$pieplot1->SetLegends($security_name_arr);

		$graph1->Add($pieplot1);

		$graph1->Stroke('/tmp/sec_log.png');
		return;
	}

	function flow_web_access($path, $title, $key)
	{
		if(file_exists(REPORT_PATH)) {
            $web_data = $this->database->get_cahce_data('web_'.$key, $this->start, $this->end);
		} else {
            $web_data = MysqlDb::report_query('web_access', $key, $this->start, $this->end);
		}

		if (empty($web_data)) {
			// return $this->draw_null_bar($path, $title);
			if ($key == 'host'){
				$this->is_null_host = 1;
			} elseif($key == 'username'){
				$this->is_null_username = 1;
			} elseif($key == 'category'){
				$this->is_null_category = 1;
			}
			return;
		}
		foreach($web_data as $k =>$value){
			$web_xdata_all[] = my_wordwrap($value[$key], 16);
			$web_ydata_all[] = $value['num'];

			$col=array();
			$col[0]=$value[$key];
			$col[1]=$value['num'];
			$web_data_table[$k]=$col;
		}

		if ($key == 'host') {
			$this->webhost_data_table = $web_data_table;
		} else if ($key == 'username') {
			$this->webuser_data_table = $web_data_table;
		} else if ($key == 'category') {
			$this->webcategory_data_table = $web_data_table;
		}

		$web_xdata = array_slice($web_xdata_all,0,10,true);
		$web_ydata = array_slice($web_ydata_all,0,10,true);
		$this->draw_bar($path, $title, $web_xdata, $web_ydata);
		return;
	}

	function flow_web_access_host()
	{
		return $this->flow_web_access('/tmp/web_access.png', t('report.web_access_top10'), 'host');
	}

	function flow_web_access_user()
	{
		return $this->flow_web_access('/tmp/user_access.png', t('report.user_access_top10'), 'username');
	}

	function flow_web_access_category()
	{
		return $this->flow_web_access('/tmp/web_category.png', t('report.object_web_statistics'), 'category');
	}

	function system_cpu_report()
	{
		$table_name = $this->get_table_name('health_info');

		if ($this->days == "userdefined") {
			//自定义多天情况
			/*$start_time = strtotime($this->report_map['start_time']);
			$end_time = strtotime($this->report_map['end_time'])+86400;*/
			$where['time[<>]'] = [strtotime($this->report_map['start_time']), (strtotime($this->report_map['end_time'])+86400)];
		} else {
			$where = array();
		}
		$db = new StatisticDb();
		// $res = $db -> org_select($table_name,['time','bits_in','bits_out','max_bits_in','min_bits_in','max_bits_out','min_bits_out']);
		$res = $db -> org_select($table_name,['time','cpu_usage','min_cpu_usage','max_cpu_usage'], $where);
		//根据最后一个数据循环计算时间
		for ($i = 0;$i < count($res);$i++){
			$syscpudate[] = date("m-d H:i",$res[$i]['time']);
			$syscpuusage[] = (float)$res[$i]['cpu_usage']/100;
			$syscpuusagemin[] = (float)$res[$i]['min_cpu_usage']/100;
			$syscpuuasgemax[]= (float)$res[$i]['max_cpu_usage']/100;
		}
		if(count($syscpudate)==1){
			array_unshift($syscpudate,date("m-d H:i",$res[0]['time']-60));
			array_unshift($syscpuusage,$syscpuusage[0]);
		}

		$this->draw_usage_line('/tmp/sys_cpu.png',
			t('report.cpuusage'),
			$syscpudate, $syscpuusage, 'cpu');
		return;
	}

	function system_memory_report()
	{
		/*		$sys_map = $this->get_table_name('host_flow');
                $sys_map['type'] = 2;
                $start_time = strtotime($this->report_map['start_time']);
                $end_time = strtotime($this->report_map['end_time'])+86400;

                if ($this->days == "userdefined"){
                    //自定义多天情况
                    for ($start_time;$start_time<=$end_time;$start_time+=86400){
                        $sys_map['date'] = $start_time;
                        $sysmemeory = getResponse( 'mem_usage_stat', "show" , $sys_map, '' );
                        $sysmemeory_data = $sysmemeory['mem_usage_stat']['group']['data']['group'];

                        //自定义为一天时的处理
                        foreach ($sysmemeory_data as $key => $value) {
                            //以每天的首个数据为横坐标
                            $sysmemeorydate[]=substr($value['date'],5,11);
                            $sysmemeoryusage[]=(float)$value['usage'];
                        }
                    }
                } else {
                    $sysmemeory = getResponse( 'mem_usage_stat', "show" , $sys_map, '' );
                    $time_interval = $sysmemeory['mem_usage_stat']['group']['time_interval'];
                    $sysmemeory_data = $sysmemeory['mem_usage_stat']['group']['data']['group'];
                    $time = strtotime($sysmemeory['mem_usage_stat']['group']['data']['group'][count($sysmemeory_data)-1]['date']);

                    for ($i=count($sysmemeory_data);$i>0;$i--){
                        $sysmemeorydate[]=date("m-d H:i",$time-$time_interval*$i);
                        $sysmemeoryusage[]=(float)$sysmemeory_data[$i]['usage'];
                    }
                    //将数据反转处理
                    $sysmemeoryusage=array_reverse($sysmemeoryusage,false);

                }
                $this->draw_usage_line('/tmp/sys_memory.png',
                    t('report.memusage'),
                    $sysmemeorydate, $sysmemeoryusage, 'memory');
                return;*/

		$table_name = $this->get_table_name('health_info');

		if ($this->days == "userdefined") {
			//自定义多天情况
			/*$start_time = strtotime($this->report_map['start_time']);
			$end_time = strtotime($this->report_map['end_time'])+86400;*/
			$where['time[<>]'] = [strtotime($this->report_map['start_time']), (strtotime($this->report_map['end_time'])+86400)];
		} else {
			$where = array();
		}

		$db = new StatisticDb();
		// $res = $db -> org_select($table_name,['time','bits_in','bits_out','max_bits_in','min_bits_in','max_bits_out','min_bits_out']);
		$res = $db -> org_select($table_name,['time','memory_usage','min_memory_usage','max_memnory_usage'], $where);
		//根据最后一个数据循环计算时间
		for ($i=0;$i < count($res);$i++){
			$sysmemeorydate[] = date("m-d H:i",$res[$i]['time']);
			$sysmemeoryusage[] = (float)$res[$i]['memory_usage']/100;
			$sysmemeoryusagemin[] = (float)$res[$i]['min_memory_usage']/100;
			$sysmemeoryusagemax[]= (float)$res[$i]['max_memnory_usage']/100;
		}
		if(count($sysmemeorydate)==1){
			array_unshift($sysmemeorydate,date("m-d H:i",$res[0]['time']-60));
			array_unshift($sysmemeoryusage,$sysmemeoryusage[0]);
		}

		$this->draw_usage_line('/tmp/sys_memory.png',
			t('report.memusage'),
			$sysmemeorydate, $sysmemeoryusage, 'memory');
		return;
	}

	function system_flow_report()
	{

		/*		$sys_map = $this->get_table_name('health_info');
                $sys_map['type'] = 4;
                $start_time = strtotime($this->report_map['start_time']);
                $end_time = strtotime($this->report_map['end_time'])+86400;
                if ($this->days == "userdefined"){
                    //自定义多天情况
                    for ($start_time;$start_time<=$end_time;$start_time+=86400){
                        $sysflow = array();
                        $sys_map['date'] = $start_time;
                        $sysflow = getResponse( 'device_perf', "show" , $sys_map, '' );
                        $sysflow_data = $sysflow['device_perf']['group']['data']['group'];
                        //自定义为一天时的处理
                        foreach ($sysflow_data as $key => $value) {
                            $sysflowdate[]=substr($value['date'],5,11);
                            $sysflowdevice_in[]=(int)$value['device_in'];
                            $sysflowdevice_out[]=(int)$value['device_out'];

                        }
                    }
                } else {
                    $sysflow = getResponse( 'device_perf', "show" , $sys_map, '' );
                    $time_interval = $sysflow['device_perf']['group']['time_interval'];
                    $sysflow_data = $sysflow['device_perf']['group']['data']['group'];
                    $time = strtotime($sysflow['device_perf']['group']['data']['group'][count($sysflow_data)-1]['date']);

                    for ($i=count($sysflow_data);$i>0;$i--){
                        $sysflowdate[]=date("m-d H:i",$time-$time_interval*$i);
                        $sysflowdevice_in[]=(float)$sysflow_data[$i]['device_in'];
                        $sysflowdevice_out[]=(int)$sysflow_data[$i]['device_out'];

                    }
                    $sysflowdevice_in=array_reverse($sysflowdevice_in,false);
                    $sysflowdevice_out=array_reverse($sysflowdevice_out,false);
                }*/

		if ($this->days == "userdefined") {
			//自定义多天情况
			/*$start_time = strtotime($this->report_map['start_time']);
			$end_time = strtotime($this->report_map['end_time'])+86400;*/
			$where['time[<>]'] = [strtotime($this->report_map['start_time']), (strtotime($this->report_map['end_time'])+86400)];
		} else {
			$where = array();
		}

		$table_name = $this->get_table_name('host_flow');
		$db = new StatisticDb();
		$res = $db -> org_select($table_name,['time','bits_in','bits_out','max_bits_in','min_bits_in','max_bits_out','min_bits_out'], $where);
		//根据最后一个数据循环计算时间
		for ($i=0;$i < count($res);$i++){
			$sysflowdate[] = date("m-d H:i",$res[$i]['time']);
			$sysflowdevice_in[] = (float)$res[$i]['bits_in'];
			$sysflowdevice_out[] = (float)$res[$i]['bits_out'];
			$min_sysflowdevice_in[] = (float)$res[$i]['min_bits_in'];
			$max_sysflowdevice_in[] = (float)$res[$i]['max_bits_in'];
			$min_sysflowdevice_out[] = (float)$res[$i]['min_bits_out'];
			$max_sysflowdevice_out[] = (float)$res[$i]['max_bits_out'];
		}

		$sys_flow_graph = new Graph(630,440);//创建统计图对象
		$sys_flow_graph->SetScale('textlin');//设置刻度样式datlin
		//$graph->SetY2Scale('lin');
		$sys_flow_graph->SetShadow();//设置背景带阴影
		$sys_flow_graph->img->SetMargin(60, 50, 20, 80);// 设置图表灰度四周边距，顺序为左右上下
		$sys_flow_graph->title->Set(t('report.statics_ele_healthy_flow'));//设置走势图的标题

		$lineplot1 = new LinePlot($sysflowdevice_in);//建立LinePlot对象
		$lineplot2 = new LinePlot($sysflowdevice_out);//建立LinePlot对象

		$sys_flow_graph->Add($lineplot1);
		$sys_flow_graph->Add($lineplot2);

		// $sys_flow_graph->xaxis->title->Set(LocalUtil::getCommonResource('index.log.table.time'));//设置x轴的标题
		$sys_flow_graph->xaxis->SetTickLabels($sysflowdate);
		// $sys_flow_graph->xaxis->SetTextLabelInterval($this->get_sys_interval());
		// var_dump(count($sysflowdevice_in));die;
		$count = 1;
		if (count($sysflowdevice_in)>10) {
			$count = floor(count($sysflowdevice_in)/10);
		}

		// if ($this->report_map['days'] != 'userdefined'){$count = 10;}
		$sys_flow_graph->xaxis->SetTextLabelInterval($count);
		$sys_flow_graph->yaxis->SetLabelFormatCallback('lib\formatkbs');
		$sys_flow_graph->xaxis->SetLabelAngle(45);
		$sys_flow_graph->yaxis->title->SetMargin(10);//设置左边的title到图的距离
		$sys_flow_graph->title->SetFont(FF_SIMSUN, FS_BOLD);//设置字体
		$sys_flow_graph->yaxis->title->SetFont(FF_SIMSUN, FS_BOLD);
		$sys_flow_graph->xaxis->title->SetFont(FF_SIMSUN, FS_BOLD);

		$lineplot1->SetColor('red');//设置颜色
		$lineplot2->SetColor('blue');
		$lineplot1->SetLegend(t('report.app_out'));//绑定
		$lineplot2->SetLegend(t('report.app_in'));
		$sys_flow_graph->legend->SetLayout(LEGEND_HOR);
		$sys_flow_graph->legend->Pos(0.4, 0.95, 'center', 'bottom');
		//图例文字框的位置 0.4，0.95 是以右上角为基准的，0.4是距左右距离，0.95是上下距离。
		$sys_flow_graph->Stroke('/tmp/sys_flow.png');//输出

	}

	function health_signal_quality()
	{
		$lossdata = $delaydata = $jitterdata = array();
		$lossusage = $delayusage = $jittertime = array();
		$db = new StatisticDb();
		$db->path = '/tmp/hm_statistics.db';
		$table = $this->report_map['quality_prefix'] . md5($this->report_map['health_name'].'_'.$this->report_map['health_inf']);
		$res = $db -> org_select($table,['time', 'loss', 'delay', 'type', 'jitter'],array());

		if (empty($res) || !$res) {
			$this->is_quality_null = true;
			return;
		}

		for($i=0;$i<count($res);$i++) {
			$lossdata[] = $delaydata[] = $jitterdata[] = date("m-d H:i",$res[$i]['time']);
			$lossusage[] = $res[$i]['loss'];
			$delayusage[] = $res[$i]['delay'];
			$jittertime[] = $res[$i]['jitter'];
		}

		if (empty($lossdata) && empty($lossusage) || (count($lossdata) == 1 || count($lossusage) == 1)) {
			$this->is_quality_null = true;
			return;
		}

		$this->draw_line('/tmp/loss_quality.png',
			t('report.device_loss_rate'),
			$lossdata, $lossusage, 'loss', 'formatpercentage');

		$this->draw_line('/tmp/delay_quality.png',
			t('report.device_delay_rate'),
			$delaydata, $delayusage, '', 'formattime');

		$this->draw_line('/tmp/jitter_quality.png',
			t('report.device_jitter_rate'),
			$jitterdata, $jittertime, '', 'formattime');

	}

	function get_health_param()
	{
		$param = array('name'=> $this->report_map['health_name']);
		switch ($this->days) {
			case 'daily':
				$param['period'] = '2';
				break;

			case 'weekly':
				$param['period'] = '3';
				break;
		}

		return $param;
	}

	function draw_line($path, $title, $xdata, $ydata, $type, $format=null)
	{
		//如果为空，使用空图片
		if (empty($xdata) || empty($ydata)) {
			return $this->draw_null_bar($path, $title);
		}

		$sys_graph = new Graph(630,440);//创建统计图对象

		if ($type === 'loss') {
			$sys_graph->SetScale('textlin',0 ,100);//设置刻度样式datlin
		} else {
			$sys_graph->SetScale('textlin');//设置刻度样式datlin
		}
		$sys_graph->SetShadow();//设置背景带阴影
		$sys_graph->img->SetMargin(60, 50, 20, 80);// 设置图表灰度四周边距，顺序为左右上下
		$sys_graph->title->Set($title);

		$lineplot = new LinePlot($ydata);//建立LinePlot对象
		$sys_graph->Add($lineplot);



		/*if ($type == 'cpu') {
            $lineplot->SetFillGradient('#FFFFFF','#aaaFFF');
            $lineplot->SetColor('#6495ED');
        } else {
            $lineplot->SetFillGradient('#FFFFFF','#FFFF00');
            $lineplot->SetColor('#FFFF00');
        }*/
		$lineplot->SetFillGradient('#FFFFFF','#FFFF00');
		$lineplot->SetColor('#FFFF00');

		$sys_graph->xaxis->SetLabelAngle(45);

		$count = 1;
		if (count($xdata) > 10) {
			$count = floor(count($xdata)/10);
		}

		$sys_graph->xaxis->SetTextLabelInterval($count);
		$sys_graph->xaxis->SetTickLabels($xdata);

		if($format) {
			$sys_graph->yaxis->SetLabelFormatCallback('lib\\'.$format);
		}



		$sys_graph->yaxis->title->SetMargin(10);//设置左边的title到图的距离
		$sys_graph->title->SetFont(FF_SIMSUN, FS_BOLD);//设置字体
		$sys_graph->yaxis->title->SetFont(FF_SIMSUN, FS_BOLD);
		$sys_graph->xaxis->title->SetFont(FF_SIMSUN, FS_BOLD);

		//图例文字框的位置 0.4，0.95 是以右上角为基准的，0.4是距左右距离，0.95是上下距离。
		$sys_graph->Stroke($path);
	}

	function security_analysis_report() {
		$xdata = $ydata = array();
		$table = $this->get_table_array($this->days);

		if (empty($table)) {
			$this->is_security_null = true;
			return;
		}

		$sql = $this->security_sql_generate($table);

		$data = MysqlDb::sql_query($sql);

		foreach ($data as $key => $value) {
			if (count($xdata)<10){
				$xdata[] = $value['country'];
				$ydata[] = $value['cnt'];
			}
			$tmp[] = $value['country'];
			$tmp[] = $value['cnt'];
			$tmp[] = $value['attacker'];
			$tmp[] = $value['min_created'];
			$tmp[] = $value['max_created'];
			$this->security_data_table[] = $tmp;
		}

		$graph = new Graph(600,400);
		$graph->SetScale("textlin");
		$graph->SetShadow();

		$graph->title->Set(t('report.security_top10_title'));

		$graph->xaxis->SetTickLabels($xdata);
		// We don't want to display Y-axis
		// Now create a bar pot
		$bplot = new BarPlot($ydata);

		$bplot->SetShadow();
		$graph->Add($bplot);
		$bplot->SetFillColor($this->colors2);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->yaxis->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->SetLabelAngle(20);
		$bplot->value->Show();

		$bplot->value->SetFont(FF_SIMSUN,FS_BOLD);

		$graph->SetMargin(80, 30, 40, 80);
		$bplot->SetValuePos('top');
		$bplot->value->SetColor("black","darkred");
		$graph->Stroke('/tmp/security_analysis.png');
	}

	function security_assets_analysis() {

		switch ($this->days) {
			case 'daily':
				$tmp = 'day';
				break;
			case 'weekly':
				$tmp = 'week';
				break;
			case 'monthly':
				$tmp = 'month';
				break;
		}

		$param['time_interval'] = $tmp;

		$module = 'assets_security_stat';
		$rspString = getResponse($module, 'show', $param);
		$ret = getAssign($rspString, $module);

		if ($ret['code']) {
			$this->is_seclevel_null = $this->is_secsystem_null = true;
			return;
		}

		$module = 'assets_security_user';
		$rspString = getResponse($module, 'show', array('page'=> 1, 'pageSize'=> 50));
		$userRet = getAssign($rspString, $module);

		//数据整理
		$level_array = array($ret['risk_level_high'], $ret['risk_level_middle'], $ret['risk_level_low'], $ret['risk_level_safe']);
		$system_array = array($ret['os_stat_windows'], $ret['os_stat_linux'], $ret['os_stat_unix'], $ret['os_stat_ios'], $ret['os_stat_android']);

		$level_label_array = array(t('report.level_high'), t('report.level_middle'), t('report.level_low'), t('report.level_safe'));
		$system_label_array = array('Windows', 'Linux', 'Unix', 'IOS', 'Android');

		foreach ($userRet as  $value) {
			$tmp = array();
			$tmp[] = $value['assets_addr'];
			$tmp[] = $value['importance'];
			$tmp[] = $value['os'];
			$tmp[] = empty($value['attack_counts'])? '0': $value['attack_counts'];
			$tmp[] = $value['risk_level'];
			$this->security_assets_table[] = $tmp;
		}

		if ($this->if_array_null($level_array)) {
			$this->is_seclevel_null = true;
		}
		if ($this->if_array_null($system_array)) {
			$this->is_secsystem_null = true;
			return;
		}

		$this->draw_pie('/tmp/assets_level.png', t('report.assets_level_title'), $level_label_array, $level_array);
		$this->draw_pie('/tmp/assets_system.png', t('report.assets_system_title'), $system_label_array, $system_array);
	}

	/**
	 * 获取数据库中可用表名称数组
	 */
	function get_table_array($period) {
		$table_arr = array();
		switch ($period) {
			case 'daily':
				$days = 1;
				break;
			case 'weekly':
				$days = 7;
				break;
			case 'monthly':
				$days = 30;
				break;
			case 'userdefined':
				$days = (strtotime($this->report['end_time']) - strtotime($this->report['start_time'])) / 86400;
				break;
		}

		$cur = time();
		if ($period == 'userdefined') {
			$cur = strtotime($this->report['end_time']);
		}

		for($i=0;$i<$days;$i++) {
			$timeStr = date('Ymd', $cur - 86400 * $i);
			$table = 'ips_'.$timeStr;
			if (!empty($this->if_table_exists($table))) {
				array_push($table_arr, $table);
			}
			$table = 'av_'.$timeStr;
			if (!empty($this->if_table_exists($table))) {
				array_push($table_arr, $table);
			}
		}

		return $table_arr;
	}

	function if_table_exists($table_name) {
		$sql = "SELECT `TABLE_NAME` FROM INFORMATION_SCHEMA.TABLES where TABLE_NAME='".$table_name."'";
		return MysqlDb::sql_query($sql);
	}

	function security_sql_generate($table_array) {
		$union_sql;

		for ($i=0;$i<count($table_array);$i++) {
			if ($union_sql) {
				$union_sql .= ' UNION ALL SELECT attacker,country,create_at FROM ' . $table_array[$i];
			} else {
				$union_sql = 'SELECT attacker,country,create_at FROM ' . $table_array[$i];
			}
		}

		$sql = 'SELECT attacker,country,max(create_at) as max_created,min(create_at) as min_created,COUNT(*) AS cnt FROM (' . $union_sql . ') as `union` GROUP BY attacker ORDER BY cnt DESC';

		return $sql;
	}

	function draw_pie($img_path, $title='', $label_array, $data_array) {

		if (empty($img_path) || empty($label_array) || empty($data_array)) {
			return;
		}

		//生成饼图
		$graph = new PieGraph(630, 440);
		$graph->SetShadow();

		$graph->title->Set($title);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD);

		$pieplot = new PiePlot($data_array);

		$pieplot->SetLegends($label_array);

		$graph->Add($pieplot);

		$graph->Stroke($img_path);
	}

	function if_array_null($array) {
		foreach ($array as $key => $value) {
			if ($value != '0') {
				return false;
			}
		}
		return true;
	}
}

?>
