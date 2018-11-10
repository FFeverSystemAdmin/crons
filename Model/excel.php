<?php 
ini_set('memory_limit', '-1');
require_once realpath(__DIR__."/../files/excel/PHPExcel.php");

class Excel{
	private $excel;

	function __construct(){
		$this->excel = new PHPExcel();

	}
	
	function styleExcelSheet(){
		$style_cell = array(
           'alignment' => array(
               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
           )
        ); 
        $this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($style_cell);
        $this->excel->getActiveSheet()->setCellValue("A1","FFever Report Generation System");
        $this->excel->getActiveSheet()->mergeCells('A1:E1')->getStyle("A1:F1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A1:E1")->applyFromArray($style_cell);
        $this->excel->getActiveSheet()->setCellValue("A2","Vehicle Plate No.");
        $this->excel->getActiveSheet()->setCellValue("B2","From");
        $this->excel->getActiveSheet()->setCellValue("C2","To");
        $this->excel->getActiveSheet()->setCellValue("D2","Distance Travelled(in Km)");
        $this->excel->getActiveSheet()->setCellValue("E2","Last Location");
        
        $this->excel->getActiveSheet()->getStyle("A2:E2")->getFont()->setBold( true );
        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getStyle("A")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FCF3CF');
        $this->excel->getActiveSheet()->getStyle("B")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D4EFDF');
        $this->excel->getActiveSheet()->getStyle("C")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D6EAF8');
        $this->excel->getActiveSheet()->getStyle("D")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FADBD8');
        $this->excel->getActiveSheet()->getStyle("E")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FADBE2');
        $this->excel->getActiveSheet()->getStyle("A1:E1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('A2D9CE');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(70);
        $this->excel->getActiveSheet()->getRowDimension('1:100')->setRowHeight(30);
	}
	

	function insertData($dataArray){
		$this->excel->getActiveSheet()->fromArray($dataArray,NULL,"A3");
	}

	function saveExcelFile($filePath){
		$excelFile = PHPExcel_IOFactory::createWriter($this->excel,'Excel2007');
        $excelFile->save($filePath);
	}
}