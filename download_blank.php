<?php

	if(!empty($_GET['cipher_group']))
	{
		$cipher_group = $_GET['cipher_group'];
		$cipher_group = mb_strtoupper($cipher_group);
		$pattern = '/^[А-ЯЁ]{2}[Б,М,С][В,З,О][-][0-9]{2}[-][0-9]{2}$/u';
		if(!preg_match($pattern, $cipher_group))
		{
			exit;
		}
	}
	else
	{
		exit;
	}
	
	require_once("Classes/PHPExcel.php");
	
	$objPHPexcel = new PHPExcel;
	
	$objPHPexcel->setActiveSheetIndex(0);
	
	$active_sheet = $objPHPexcel->getActiveSheet();
	
	$active_sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	$active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	
	$active_sheet->setTitle("Список студентов $cipher_group");
	$active_sheet->getColumnDimension('A')->setWidth(40);
	$active_sheet->getColumnDimension('B')->setWidth(20);
	$active_sheet->getColumnDimension('C')->setWidth(20);
	$active_sheet->getColumnDimension('D')->setWidth(20);
	$active_sheet->getColumnDimension('E')->setWidth(40);
	$active_sheet->getColumnDimension('F')->setWidth(20);
	$active_sheet->getColumnDimension('G')->setWidth(20);
	$active_sheet->getColumnDimension('H')->setWidth(20);
	$active_sheet->getColumnDimension('I')->setWidth(20);
	
	$active_sheet->mergeCells('A1:I1');
	$active_sheet->mergeCells('A2:F2');
	$active_sheet->mergeCells('G2:I2');
	
	$active_sheet->setCellValue('A1', $cipher_group);
	$active_sheet->setCellValue('A2', 'Студент');
	$active_sheet->setCellValue('G2', 'Научный руководитель');
	
	$active_sheet->setCellValue('A3', 'НЗК');
	$active_sheet->setCellValue('B3', 'Фамилия');
	$active_sheet->setCellValue('C3', 'Имя');
	$active_sheet->setCellValue('D3', 'Отечество');
	$active_sheet->setCellValue('E3', 'Тема');
	$active_sheet->setCellValue('F3', 'Тип работы');
	$active_sheet->setCellValue('G3', 'Фамилия');
	$active_sheet->setCellValue('H3', 'Имя');
	$active_sheet->setCellValue('I3', 'Отечество');
	
	$style_header_1 = array(
		'font' => array(
			'bold' => true,
			'name' => 'Arial',
			'size' => '18',
			
		),
		'alignment' => array(
			'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER
		)
	);
	
	$style_header_2 = array(
		'font' => array(
			'bold' => true,
			'name' => 'Arial',
			'size' => '16',
			
		),
		'alignment' => array(
			'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER
		)
	);
	
	$active_sheet->getStyle('A1:I1')->applyFromArray($style_header_1);
	$active_sheet->getStyle('A2:I2')->applyFromArray($style_header_1);
	$active_sheet->getStyle('A3:I3')->applyFromArray($style_header_2);
	
	header("Content-Type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=$cipher_group.xlsx");
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
	$objWriter->save('php://output');
	exit();

?>