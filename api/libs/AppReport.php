<?php
namespace lib;
use lib\Graph;
use lib\MyPdf;
use lib\PiePlot;
use lib\ArrayMap;
use lib\LinePlot;
use lib\AccLinePlot;
use lib\AutoReport;
use message\MainModel;
use database\DbUtil;
use controller\statistics\AppMonitorController;
use controller\statistics\AppMonitorTrendController;
use lib\phpoffice\phpword\src\PhpWord\PhpWord;

ob_end_clean();

DEFINE('INTERVAL1', 1*60);
DEFINE('INTERVAL2', 10*60);
DEFINE('INTERVAL3', 60*60);

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

class AppReport {
	public $colors=array('#9dc8f1','#686887','#90ed7d','#f7a35c','#7277d4','#f15b7f','#e4d354','#2fb1be','#91e8e1','#8d4653','#C3BDBE');
	public $colors2=array('#9dc8f1','#686887','#90ed7d','#f7a35c','#7277d4','#f15b7f','#e4d354','#2fb1be','#91e8e1','#8d4653');
	public $row_list = array();

	function __construct($report){

		$this -> app_flow_report($report);
		$this -> app_top_report($report);
		$this -> pdf($report);
		$this -> word($report);
	}

	function app_flow_report($report) {
		$map = new ArrayMap();
		$map['direct'] = $report['direct'];
		$map['range'] = $report['range'];

		$stringa=t('app_report.last_one_flow');
		$stringb=t('app_report.app_both');
		if($map['range']==1){
			$stringa=t('app_report.last_one_flow');
		}elseif ($map['range']==2) {
			$stringa=t('app_report.last_day_flow');
		}else{
			$stringa=t('app_report.last_week_flow');
		}
		if($map['direct']=='all'){
			$stringb=t('app_report.app_both');
		}elseif ($map['direct']=='up') {
			$stringb=t('app_report.index_top_app_up');
		}else{
			$stringb=t('app_report.index_top_app_down');
		}
		$upbytes=array();
		$downbytes=array();
		$totalbytes=array();
		$label=array();
		$row=array();

		$label_list=array();
		$upbytes_list=array();
		$downbytes_list=array();
		$totalbytes_list=array();


		$apps = new AppMonitorTrendController();
		$appsflow = $apps->get($map);
		if (empty($appsflow)) {
			return;
		}

		$start = floor(time()/INTERVAL1)*INTERVAL1;
		$times = array();
		if($map['range']==1){
			for( $i=59; $i >= 0; $i-- ) {
				if($i==59){
					$times[$i] = $start-INTERVAL1;
				}else{
					$times[$i] = $times[$i+1]-INTERVAL1;
				}
			}
		}elseif ($map['range']==2) {
			for( $i=143; $i >= 0; $i-- ) {
				if($i==143){
					$times[$i] = $start-INTERVAL2;
				}else{
					$times[$i] = $times[$i+1]-INTERVAL2;
				}
			}
		}else{
			for( $i=167; $i >= 0; $i-- ) {
				if($i==167){
					$times[$i] = (floor(time()/INTERVAL3)*INTERVAL3)-INTERVAL3;
				}else{
					$times[$i] = $times[$i+1]-INTERVAL3;
				}
			}
		}


		if ($appsflow['name']) {
			$label[]=$appsflow['name_cn'];
			$upbytes[]=$appsflow['up_bytes'];
			$downbytes[]=$appsflow['down_bytes'];
			$totalbytes[]=$appsflow['total_bytes'];
		} else {
			foreach ($appsflow as $key => $value) {
				$label[]=$value['name_cn'];
				$upbytes[]=$value['up_bytes'];
				$downbytes[]=$value['down_bytes'];
				$totalbytes[]=$value['total_bytes'];
			}
		}

		$graph = new Graph(600,400);
		$graph->SetScale('datlin');
		$graph->SetShadow();



		$graph->SetMargin(70,30,20,70);

		foreach ($label as $key => $value) {
			$datasValue=explode(',', $totalbytes[$key]);
			if($map['direct']=='all'){
				$datasValue=explode(',', $totalbytes[$key]);
			}elseif ($map['direct']=='up') {
				$datasValue=explode(',', $upbytes[$key]);
			}else{
				$datasValue=explode(',', $downbytes[$key]);
			}
			// $datasValue=explode(',', $upbytes[$key]);
			foreach ($datasValue as $key1 => $value1) {
				if ($value1=="") {
					$datasValue[$key1]="0";
				}else{
					// $datasValue[$key1]=formatkbs($value1);
					$datasValue[$key1]=$value1;
				}
			}

			$dplot[]=new LinePLot($datasValue,$times);
			$dplot[$key]->SetFillColor($this->colors[$key]);
			$dplot[$key]->SetLegend($value);
			$dplot[$key]->SetColor($this->colors[$key]);
		}

		// 叠加的时候用
		// $accplot = new AccLinePlot($dplot);
		$accplot = new AccLinePlot(array_reverse($dplot));
		$graph->Add($accplot);
		// $graph->xaxis->scale->SetTimeAlign(MINADJ_5);

		// Force labels to only be displayed every 5 minutes
		if($map['range']==1){
			$graph->xaxis->scale->SetTimeAlign(MINADJ_5);
			$graph->xaxis->scale->ticks->Set(5*60);
		}elseif ($map['range']==2) {
			$graph->xaxis->scale->SetTimeAlign(MINADJ_15);
			$graph->xaxis->scale->ticks->Set(60*60);
			$graph->xaxis->SetTextLabelInterval(2);

		}else{
			$graph->xaxis->scale->ticks->Set(1*60*60);
			$graph->xaxis->SetTextLabelInterval(23);
		}

		// Use hour:minute format for the labels
		if($map['range']==1){
			$graph->xaxis->scale->SetDateFormat('H:i');
		}elseif ($map['range']==2) {
			$graph->xaxis->scale->SetDateFormat('H:i');
		}else{
			$graph->xaxis->scale->SetDateFormat('m-d');
		}
		$graph->title->Set($stringa.t('app_report.app').$stringb.t('app_report.area'));
		$graph->yaxis->SetLabelFormatCallback('lib\formatkbs');
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		$graph->legend->SetShadow('gray@0.4',5);
		$graph->legend->SetPos(0.5,0.98,'center','bottom');
		$graph->legend->SetColumns(4);
		$graph->Stroke('/tmp/app_up_flow_static.png');

	}

	function app_top_report($map) {
		$datay=array();
		$datax=array();
		$app = new AppMonitorController();
		$group = $app->get($map);

		if (empty($group)) {
			return;
		}

		$group = $group['data'][0]['items']['group'];

		if ($group['name']) {
			$label_list[] = $group['name_cn'];
			$upbytes_list[] = $group['up_bytes'];
			$downbytes_list[]=$group['down_bytes'];
			$totalbytes_list[]=$group['total_bytes'];
			$col=array();
			$tmp_col=array();
			$col[0]=$group['name_cn'];
			$col[1]= formatbytes($group['up_bytes']);
			$col[2]= formatbytes($group['down_bytes']);
			$col[3]= formatbytes($group['total_bytes']);

			if ($group['total_bytes'] == 0){
				unset($label_list[$key1]);
				unset($totalbytes_list[$key1]);
			}
			$tmp_col[0]=$group['name_cn'];
			$tmp_col[1]=$group['up_bytes'];
			$tmp_col[2]=$group['down_bytes'];
			$tmp_col[3]=$group['total_bytes'];
			$this->row_list[]=$col;
			$tmp_row[]=$tmp_col;
			/*foreach ($appslist['monitor_apps']['group']['items'] as $key => $value) {
				foreach ($value as $key1 => $value1) {
					$label_list[] = $group['name_cn'];
					$upbytes_list[] = $group['up_bytes'];
					$downbytes_list[]=$group['down_bytes'];
					$totalbytes_list[]=$group['total_bytes'];
					$col=array();
					$tmp_col=array();
					$col[0]=$value1['name_cn'];
					$col[1]=$this->formatbytes($value1['up_bytes']);
					$col[2]=$this->formatbytes($value1['down_bytes']);
					$col[3]=$this->formatbytes($value1['total_bytes']);

		        	if ($value1['total_bytes'] == 0){
		        		unset($label_list[$key1]);
		        		unset($totalbytes_list[$key1]);
		        	}
					$tmp_col[0]=$value1['name_cn'];
					$tmp_col[1]=$value1['up_bytes'];
					$tmp_col[2]=$value1['down_bytes'];
					$tmp_col[3]=$value1['total_bytes'];
					$this->row_list[$key1]=$col;
					$tmp_row[$key1]=$tmp_col;
				}
			}*/
		} else {
			foreach ($group as $key => $value1) {

				$label_list[]=$value1['name_cn'];
				$col[0]=$value1['name_cn'];
				$tmp_col[0]=$value1['name_cn'];

				$upBytes = $value1['up_bytes'];
				$upbytes_list[]=$upBytes;
				$col[1]=$upBytes;
				$tmp_col[1]=$upBytes;

				$downBytes = $value1['down_bytes'];
				$downbytes_list[]=$downBytes;
				$col[2]=$downBytes;
				$tmp_col[2]=$downBytes;

				$totalBytes = $value1['total_bytes'];
				$totalbytes_list[]=$value1['total_bytes'];
				$col[3]=$value1['total_bytes'];
				$tmp_col[3]=$value1['total_bytes'];
				$this->row_list[] = $col;
				$tmp_row[]=$tmp_col;
			}
		}

		if($map['direct']=='all'){
			$label_top10list=array_slice($label_list,0,10);
			$datax=$label_top10list;
			$datay=array_slice($totalbytes_list,0,10);
		}elseif ($map['direct']=='up') {
			array_multisort(array_column($tmp_row, 1),SORT_NUMERIC, SORT_DESC, $tmp_row);
			$datay=array_slice(array_column($tmp_row, 1),0,10);
			$datax=array_slice(array_column($tmp_row, 0),0,10);
		}else{
			array_multisort(array_column($tmp_row, 2),SORT_NUMERIC, SORT_DESC, $tmp_row);
			$datay=array_slice(array_column($tmp_row, 2),0,10);
			$datax=array_slice(array_column($tmp_row, 0),0,10);
		}
		if(empty($datax) && empty($datay)){
			$datay=array(0);
			$datax=array(LocalUtil::getCommonResource('report.app.app.nodata'));
		}

		if($map['category']==1){
			$graph = new PieGraph(630,440);
			$graph->SetShadow();
			$graph->title->Set($stringa.t('app_report.app').$stringb.t('app_report.bar'));
			$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
			$pieplot = new PiePlot($datay);
			$pieplot->SetGuideLines();
			$pieplot->SetLegends($datax);

			$graph->Add($pieplot);

			$graph->Stroke('/tmp/app_topten.png');

		}else{
			$graph = new Graph(630,440);
			$graph->SetScale("textlin");
			$graph->Set90AndMargin(130,80,20,70);
			$graph->SetShadow();

			$graph->title->Set($stringa.t('app_report.app').$stringb.t('app_report.bar'));

			$graph->xaxis->SetTickLabels($datax);
			// We don't want to display Y-axis
			$graph->yaxis->Hide();

			// Now create a bar pot
			$bplot = new BarPlot($datay);

			$bplot->SetShadow();
			//You can change the width of the bars if you like
			//$bplot->SetWidth(0.5);
			// We want to display the value of each bar at the top
			// Add the bar to the graph
			$graph->Add($bplot);
			$bplot->SetFillColor($this->colors2);
			$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
			$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
			$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
			$graph->yaxis->SetFont(FF_SIMSUN,FS_BOLD);
			$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
			$bplot->value->Show();

			$bplot->value->SetFont(FF_SIMSUN,FS_BOLD);
			// $bplot->value->SetAngle(45);
			$bplot->value->SetFormatCallback('lib\formatbytes');
			// $bplot->value->SetAlign('left','center');
			$bplot->SetValuePos('top');
			$bplot->value->SetColor("black","darkred");
			$graph->Stroke('/tmp/app_topten.png');
		}
	}

	function pdf($map=array('')){
		// create new PDF document
		$pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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

		// set font
		$pdf->SetFont('droidsansfallback', '', 12);

		// add a page
		$pdf->AddPage();


		$pdf->setJPEGQuality(100);

		if (!file_exists('/tmp/webui/lang.conf')) {
			return 'cn';
		}
		// $pdf->Image('/tmp/text.png', 50, 50, 100, 100, '', 'http://www.tcpdf.org', '', true, 150);
		$pdf->Image('/tmp/app_up_flow_static.png',  10, 20,0,0, 'png', '', '', true, 150,'C');
		$pdf->Image('/tmp/app_topten.png',  10, 140,0,0, 'png', '', '', true, 150,'C');
		// $pdf->Image('/tmp/user_total_flow_static.png',  10, 260,0,0, 'png', 'http://www.tangchuanbin.com', '', true, 150,'C');


		$pdf->AddPage();
		// column titles
		$header = array(t('app_report.index_top_app'), t('app_report.index_top_app_up'), t('app_report.index_top_app_down'), t('app_report.index_top_app_totalspeed'));
		// print colored table
		$pdf->ColoredTable($header, array_slice($this->row_list, 0, 10), 180, 4);
		$dir_report = '/mnt1/reports/';
		if(!is_dir($dir_report)){
			mkdir($dir_report,0755,true);
		}
		$db = new DBUtil();
		// $pdf->Output('app_flow_statistic.pdf', 'D');
		if ($map['category']) {
			$catereport_msg='SrcIP='.$_SERVER["SERVER_NAME"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="导出分类流量统计" ManageStyle=web Content="operation success"';
			$db->addEventLog(20,date('Y-m-d h:i:s',time()),'SYSTEM_INFO',5,'',$catereport_msg);
			$file =  'app_category_flow_statistic_'.date("YmdHis").'.pdf';
			$pdf->Output($dir_report . $file, 'F');
		} else {
			$flowreport_msg='SrcIP='.$_SERVER["SERVER_NAME"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="导出对象流量统计" ManageStyle=web Content="operation success"';
			$db->addEventLog(20,date('Y-m-d h:i:s',time()),'SYSTEM_INFO',5,'',$flowreport_msg);
			$file = 'app_flow_statistic_'.date("YmdHis").'.pdf';
			$pdf->Output($dir_report. $file, 'F');
		}
		return $file;
	}
	public function word($map=array('')) {

		$file = '/usr/local/wwwroot/sslvpn/word/word.docx';
		$PHPWord = new PhpWord();
		$template = $PHPWord->loadTemplate($file);
		if ($map['category']) {
			$file =  'app_category_flow_statistic_'.date("YmdHis").'.docx';
		} else {
			$file = 'app_flow_statistic_'.date("YmdHis").'.docx';
		}
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		$template->setImageValue('img', ['path'=>'/tmp/app_up_flow_static.png', 'width'=>500, 'height'=>400]);
		$template->setImageValue('img1', ['path'=>'/tmp/app_topten.png', 'width'=>500, 'height'=>400]);
		// column titles
		$template->setValue('app', t('app_report.index_top_app'));
		$template->setValue('app_up', t('app_report.index_top_app_up'));
		$template->setValue('app_down', t('app_report.index_top_app_down'));
		$template->setValue('app_totalspeed', t('app_report.index_top_app_totalspeed'));

		$row_list = $this->row_list;
		$count = count($row_list);
		for ($i = 0; $i < $count; $i++) {
			$template->setValue('name_cn#' . ($i + 1), $row_list[$i]['name_cn']);
			$template->setValue('up_bytes#' . ($i + 1), $row_list[$i]['up_bytes']);
			$template->setValue('down_bytes#' . ($i + 1), $row_list[$i]['down_bytes']);
			$template->setValue('total_bytes#' . ($i + 1), $row_list[$i]['total_bytes']);
		}
		$dir_report  = '/mnt1/reports/';
		if(!is_dir($dir_report)){
			mkdir($dir_report,0755,true);
		}
		$db = new DBUtil();
		if ($map['category']) {
			$catereport_msg='SrcIP='.$_SERVER["SERVER_NAME"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="导出分类流量统计" ManageStyle=web Content="operation success"';
			$db->addEventLog(20,date('Y-m-d h:i:s',time()),'SYSTEM_INFO',5,'',$catereport_msg);
			$template->saveAs($dir_report.$file);
		} else {
			$flowreport_msg='SrcIP='.$_SERVER["SERVER_NAME"].' UserName='.$_SESSION[CONNECTION.USERNAME].' Operate="导出对象流量统计" ManageStyle=web Content="operation success"';
			$db->addEventLog(20,date('Y-m-d h:i:s',time()),'SYSTEM_INFO',5,'',$flowreport_msg);
			$template->saveAs($dir_report.$file);
		}
		return $file;
	}
}
?>
