<?php 
session_start();
class export extends Controller{
	
	// Database attributes
	private $lboss;

	private $logidb;

	// PHPExcel atteibutes
	private $phpExcel;
			
	private $sheet;

	// Date attribute
	private $today;

	// FPDF attributes
	private $pdf;


	public function __construct()
	{
		parent::__construct();

		// PHPExcel configuration for excel export
		date_default_timezone_set('America/Port-au-Prince');
		$this->today = date('Y-m-d');
		$this->phpExcel = $this->phpExcel();
		$this->cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory; 
		
		$this->phpExcel->createSheet();
		$this->sheet = $this->phpExcel->getActiveSheet();

		$this->logidb = $this->model('logidb');
		$this->lboss = $this->model('lboss');
	} 

	public function index($errormessage = '')
	{
		
		$this->view('export', array());
	}

	public function excel(){
		$this->setSheetName("Fermeture de Caisse");
		$date = $_SESSION["date"] . " 00:00:00.000";
		$report = $this->lboss->getReports($date, $_SESSION["report_type"]);
		$lastItem = count($report) + 4;
			// var_dump($report); 
			// die();
		$subtitle = "GLOBAL REPORT - [ SALES DATE : " . $_SESSION["date"] . " ] - [ PERIOD : Daily ] - [ EXPORT DATE : " . date("Y-m-d") . " ] ";  
		$this->setHeader("CASHIER CONTROL REPORT", $subtitle, "closing", $lastItem);
		$this->setReport($report);
		$this->saveReport('CashierControl_' . $this->today);
		die();
	}


	public function pdf(){

		$this->view('export/pdf', array());
	}

	private function setSheetName($sheetName)
	{
		$this->sheet->Name = $sheetName;
	}

	private function setHeader($title, $subtitle, $reportType, $lastItem)
	{
		$myWorkSheet = new PHPExcel_Worksheet($this->phpExcel, $reportType); 
		// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object 
		$this->phpExcel->addSheet($myWorkSheet, 0);

		// Set report to landscape 
		$this->phpExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		

		$this->sheet->mergeCells('A1:G1');
		$this->sheet->mergeCells('A2:G2');
		$this->sheet->getRowDimension('1')->setRowHeight(35);
		$this->sheet->setCellValue('A1', $title);
		$this->sheet->setCellValue('A2', $subtitle);
		$this->sheet->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A1:G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->sheet->getRowDimension('2')->setRowHeight(25);
		$this->sheet->getRowDimension('3')->setRowHeight(25);
		$this->sheet->getStyle('A1:G3')->getFont()->setBold(true);
		$this->sheet->getStyle('A1:G1')->getFont()->setSize(14);


		$this->sheet->getPageMargins()->setRight(0); 
		$this->sheet->getPageMargins()->setLeft(0);
		$this->sheet->getPageMargins()->setTop(0); 
		$this->sheet->getPageMargins()->setBottom(0);
		$this->sheet->getPageSetup()->setFitToWidth(1);
		$this->sheet->getPageSetup()->setFitToHeight(0);  
		// $this->sheet->getPageSetup()->setPrintArea("A1:" . $lastKey . $lastItem);  


		$this->phpExcel->getProperties()->setCreator("Caribbean Supermarket S.A."); 
		$this->phpExcel->getProperties()->setLastModifiedBy("Today"); 
		$this->phpExcel->getProperties()->setTitle($title); 
		$this->phpExcel->getProperties()->setSubject("Office 2005 XLS Test Document"); 
		$this->phpExcel->getProperties()->setDescription("Test document for Office 2005 XLS, generated using PHP classes."); 
		$this->phpExcel->getProperties()->setKeywords("office 2007 openxml php"); 
		$this->phpExcel->getProperties()->setCategory("Test result file");


		$this->phpExcel->getActiveSheet()
		    ->getHeaderFooter()->setOddHeader('&R &P / &N');
		$this->phpExcel->getActiveSheet()
		    ->getHeaderFooter()->setEvenHeader('&R &P / &N');


		$this->sheet->setCellValue("A3", "");
		$this->sheet->setCellValue("B3", "Sale Type");
		$this->sheet->setCellValue("C3", "Weight");
		$this->sheet->setCellValue("D3", "Quantity");
		$this->sheet->setCellValue("E3", "Amount");
		$this->sheet->setCellValue("F3", "Real Amount");
		$this->sheet->setCellValue("G3", "Balance");

		$this->sheet->getColumnDimension("A")->setWidth('7');
		$this->sheet->getColumnDimension("B")->setWidth('35');
		$this->sheet->getColumnDimension("C")->setWidth('15');
		$this->sheet->getColumnDimension("D")->setWidth('15');
		$this->sheet->getColumnDimension("E")->setWidth('15');
		$this->sheet->getColumnDimension("F")->setWidth('15');
		$this->sheet->getColumnDimension("G")->setWidth('15');
	}

	private function setReport($report){
		$j = 4;
		$csh = "none";
		$total = 0;
		$real_total = 0;
		$dailytotal=0; 
		$dailyrealtotal=0;
		for ($i=0;$i<count($report);$i++){
			if($csh != $report[$i]['cashier_name']){
				$initial = $report[$i]["initial_charge"];
				if($total > 0){
					$dailytotal = $dailytotal + $total;
					$dailyrealtotal = $dailyrealtotal + $real_total;
					$this->sheet->mergeCells('A'.$j.':D'.$j);
					$this->sheet->setCellValue("A" . $j, "SUBTOTAL");
					$this->sheet->getRowDimension($j)->setRowHeight(22);
					$this->sheet->getStyle('A'.$j)->getFont()->setBold(true);
					$this->sheet->getStyle('A'.$j)->getFont()->setSize(12);
					$this->sheet->getStyle('A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->sheet->setCellValue("E" . $j, number_format($total, 2, ".", ","));
					$this->sheet->setCellValue("F" . $j, number_format($real_total, 2, ".", ","));
					$this->sheet->setCellValue("G" . $j, number_format($total - $real_total, 2, ".", ","));
					$this->sheet->getStyle('E'.$j)->getFont()->setBold(true);
					$this->sheet->getStyle('E'.$j)->getFont()->setSize(12);
					$this->sheet->getStyle('F'.$j)->getFont()->setBold(true);
					$this->sheet->getStyle('F'.$j)->getFont()->setSize(12);
					$j = $j + 1;
				}
				$real_total=0;
				$total=0;
				$this->sheet->mergeCells('A'.$j.':F'.$j);
				$this->sheet->setCellValue("A" . $j, "#" . $report[$i]["cashier_id"]. " - " . $report[$i]["cashier_name"]);
				$this->sheet->getRowDimension($j)->setRowHeight(22);
				$this->sheet->getStyle('A'.$j)->getFont()->setBold(true);
				$this->sheet->getStyle('A'.$j)->getFont()->setSize(12);
				$j=$j+1;
				$this->sheet->setCellValue("A" . $j, "1200");
				$this->sheet->setCellValue("B" . $j, "Initial Charge");
				$this->sheet->setCellValue("E" . $j, $report[$i]["initial_charge"]);
				
				$j = $j + 1;
			}
			$this->sheet->setCellValue("A" . $j, trim($report[$i]["sale_id"]));
			$this->sheet->setCellValue("B" . $j, trim($report[$i]["sale_name"]));
			$this->sheet->setCellValue("C" . $j, number_format($report[$i]["weight"], 2, ".", ","));
			$this->sheet->setCellValue("D" . $j, trim($report[$i]["quantity"]));
			if($report[$i]["sale_id"] == "1201"){
				$this->sheet->setCellValue("E" . $j, number_format($report[$i]["amount"]+$report[$i]["initial_charge"], 2, ".", ","));
			}else{
				$this->sheet->setCellValue("E" . $j, number_format($report[$i]["amount"], 2, ".", ","));
			}
			
			$this->sheet->setCellValue("F" . $j, number_format($report[$i]["real_amount"], 2, ".", ","));

			if($report[$i]["sale_id"] == "1201"){
				$total = $total + $initial;
				$this->sheet->setCellValue("G" . $j, number_format($report[$i]["amount"]+$report[$i]["initial_charge"]-$report[$i]["real_amount"], 2, ".", ","));
			}else{
				$this->sheet->setCellValue("G" . $j, number_format($report[$i]["amount"] - $report[$i]["real_amount"], 2, ".", ","));
			}


			$j = $j+1;
			$total=$total + $report[$i]['amount'];
			$real_total=$real_total+$report[$i]['real_amount'];
			$csh = $report[$i]['cashier_name'];
		}
		$dailytotal = $dailytotal + $total;
		$dailyrealtotal = $dailyrealtotal + $real_total;
		$this->sheet->mergeCells('A'.$j.':D'.$j);
		$this->sheet->setCellValue("A" . $j, "SUBTOTAL");
		$this->sheet->getRowDimension($j)->setRowHeight(22);
		$this->sheet->getStyle('A'.$j)->getFont()->setBold(true);
		$this->sheet->getStyle('A'.$j)->getFont()->setSize(12);
		$this->sheet->getStyle('A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->sheet->setCellValue("E" . $j, number_format($total, 2, ".", ","));
		$this->sheet->setCellValue("F" . $j, number_format($real_total, 2, ".", ","));
		$this->sheet->setCellValue("G" . $j, number_format($total - $real_total, 2, ".", ","));

		$this->sheet->getStyle('E'.$j)->getFont()->setBold(true);
		$this->sheet->getStyle('E'.$j)->getFont()->setSize(12);
		$this->sheet->getStyle('F'.$j)->getFont()->setBold(true);
		$this->sheet->getStyle('F'.$j)->getFont()->setSize(12);
		$j = $j + 1;

		$this->sheet->mergeCells('A'.$j.':D'.$j);
		$this->sheet->setCellValue("A" . $j, "TOTAL");
		$this->sheet->getRowDimension($j)->setRowHeight(22);
		$this->sheet->getStyle('A'.$j)->getFont()->setBold(true);
		$this->sheet->getStyle('A'.$j)->getFont()->setSize(12);
		$this->sheet->getStyle('A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->sheet->setCellValue("E" . $j, number_format($dailytotal, 2, ".", ","));
		$this->sheet->setCellValue("F" . $j, number_format($dailyrealtotal, 2, ".", ","));
		$this->sheet->setCellValue("G" . $j, number_format($dailytotal - $dailyrealtotal, 2, ".", ","));
		$this->sheet->getStyle('E'.$j)->getFont()->setBold(true);
		$this->sheet->getStyle('E'.$j)->getFont()->setSize(12);
		$this->sheet->getStyle('F'.$j)->getFont()->setBold(true);
		$this->sheet->getStyle('F'.$j)->getFont()->setSize(12);

		$this->sheet->getStyle('C1:G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A1:G3'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$styleArray = array( 'borders' => array( 'allborders' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'), ), ), ); 
		$this->phpExcel->getActiveSheet()->getStyle('A1:G'.$j)->applyFromArray($styleArray);
	}

	private function SaveReport($documentName)
	{
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="' . $documentName . '.xls"'); 
		header('Cache-Control: max-age=0'); $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel5'); 
		$objWriter->save('php://output');
	}
}