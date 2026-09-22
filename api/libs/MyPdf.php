<?php
namespace lib;
use lib\TCPDF;

class MyPdf extends TCPDF {
	// Colored table
	public function ColoredTable($header,$data,$postiony,$column_num) {
		// Colors, line width and bold font
		$this->SetY($postiony);
		$this->SetFillColor(157, 200, 241);//调整表头颜色
		$this->SetTextColor(255);
		$this->SetDrawColor(39, 40, 34);//调整表格画线的颜色
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// $this->setCellPaddings(0, 300, 0, 0);
		// Header
		$num_headers = count($header);
		if($column_num==4){
			$w = array(60, 40, 40,40);
		}elseif($column_num==5){
			$w = array(60, 30, 30,30,30);
		} elseif ($column_num == 2) {
			$w = array(160, 20);
        }elseif($column_num==51){
			$w = array(30, 30, 30,45,45);
		} else {
			$w = array(70, 40, 40);
		}	
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		if($column_num==4){
			foreach($data as $row) {
				$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
				$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
				$this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
				$this->Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
				$this->Ln();
				$fill=!$fill;
			}
			//$this->Cell(array_sum($w), 0, '', 'T');
		}elseif($column_num==5 || $column_num==51){
			foreach ($data as  $row) {
				$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
				$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
				$this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
				$this->Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
				$this->Cell($w[4], 6, $row[3], 'LR', 0, 'L', $fill);
				$this->Ln();
				$fill=!$fill;
			}
		}else{
			foreach($data as $row) {
				$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
				$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
				$this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
				$this->Ln();
				$fill=!$fill;
			}
			
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}