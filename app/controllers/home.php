<?php
session_start();
class home extends Controller{

	private $logidb;
	
	private $today;
	
	private $date;
	
	private $exportURL;

	private $queryTitles;

	private $classname;

	private $fileArianne;

	private $lboss;

	public function __construct()
	{
		parent::__construct();
		$this->today = date('Y-m-d', strtotime("-1 days"));
		if(!isset($_SESSION["date"]))
		{
			setCookie("date", date('Y-m-d'));
			$_SESSION["date"] = date('Y-m-d');
		}
		else
		{
			$this->date = $_SESSION["date"];
		}
		$this->classname = "thereport";
		if(empty($_SESSION['caisses']['cashier'])){
			$_SESSION['caisses']['cashier'] = '';
		}
		$this->exportURL = "javascript: void(0)";
		$this->logidb = $this->model('logidb');
		$this->lboss = $this->model('lboss');
		$this->fileArianne = "HOME";
	} 

	public function index()
	{
		$saved_report = array();
		$report = array();
		$statuses = array();
		$cashiers = $this->logidb->getCashiers();
		if(!empty($_SESSION["date"])){
			$from = $_SESSION["date"] . " 00:00:00.000";
			$to = $_SESSION["date"] . " 29:59:59.999";
			$m = 0;
			foreach($cashiers as $cs){
				$report = $this->logidb->getReport($from, $to, "D", $cs['ident']);
				if(!empty($report)){
					$saved_report = $this->lboss->getReport($cs['ident'], $from);
					if(!empty($saved_report)){
						$status = 1;
					}else{
						$status = 2;
					}
				}else{
					$status = 0;
				}
				$statuses[$m] = array("cashier_id" => $cs['ident'], 'cashier_name' => $cs['username'], 'status' => $status);
				$m = $m +1;
			}
		}
		if(!empty($_COOKIE["date"]) && !empty($_COOKIE["cashier"])){
			$from = $_COOKIE["date"] . " 00:00:00.000";
			$to = $_COOKIE["date"] . " 29:59:59.999";
			$report = $this->logidb->getReport($from, $to, "D", $_COOKIE["cashier"]);
			$saved_report = $this->lboss->getReport($_COOKIE["cashier"], $from);
		}

		$data = array('cashiers' => $cashiers, 'report' => $report, 'saved_report' => $saved_report, "statuses" => $statuses);
		$this->view('home', $data);
	}

	public function deleteItem($id){
		$saved_report = $this->lboss->deleteItem($id);
		header("Location:/caisses/public/home/globalReport");
	}

	public function globalReport(){
		$cashiers = $this->logidb->getCashiers();
		if(!empty($_SESSION["date"])){
			$from = $_SESSION["date"]." 00:00:00.000";
			$to = $_SESSION["date"]." 29:59:59.999";
			$m = 0;
			foreach($cashiers as $cs){
				$report = $this->logidb->getReport($from, $to, "D", $cs['ident']);
				if(!empty($report)){
					$saved_report = $this->lboss->getReport($cs['ident'], $from);
					if(!empty($saved_report)){
						$status = 1;
					}else{
						$status = 2;
					}
				}else{
					$status = 0;
				}
				$statuses[$m] = array("cashier_id" => $cs['ident'], 'cashier_name' => $cs['username'], 'status' => $status);
				$m = $m +1;
			}
		}
		$date = $_SESSION["date"] . " 00:00:00.000";
		$reports = $this->lboss->getReports($date, $_SESSION["report_type"]);

		$data = array('reports' => $reports, 'cashiers' => $cashiers, "statuses" => $statuses);
		$this->view('home/report', $data);
	}

	public function globalTotalReport(){
		$cashiers = $this->logidb->getCashiers();
		if(!empty($_SESSION["date"])){
			$from = $_SESSION["date"] . " 00:00:00.000";
			$to = $_SESSION["date"] . " 29:59:59.999";
			$m = 0;
			foreach($cashiers as $cs){
				$report = $this->logidb->getReport($from, $to, "D", $cs['ident']);
				if(!empty($report)){
					$saved_report = $this->lboss->getReport($cs['ident'], $from);
					if(!empty($saved_report)){
						$status = 1;
					}else{
						$status = 2;
					}
				}else{
					$status = 0;
				}
				$statuses[$m] = array("cashier_id" => $cs['ident'], 'cashier_name' => $cs['username'], 'status' => $status);
				$m = $m +1;
			}
		}
		$date = $_SESSION["date"] . " 00:00:00.000";
		$reports = $this->lboss->getReports($date, $_SESSION["report_type"]);

		$data = array('reports' => $reports, 'cashiers' => $cashiers, "statuses" => $statuses);
		$this->view('home/totals', $data);
	}

	public function report(){
		if(!empty($_POST['submit'])){
			// var_dump($_POST);
			// die();
			if($_POST['action'] == 2){
				$_SESSION["date"] = $_POST['timestamp'];
				$_SESSION["report_type"] = $_POST['report_type'];
				// var_dump($_SESSION['report_type']);
				header("Location:/caisses/public/export/excel");
				
			}

			if($_POST['action'] == 1){
				$_SESSION["report_type"] = $_POST['report_type'];
				$_SESSION["date"] = $_POST['timestamp'];
				$_SESSION["report_type"] = $_POST['report_type'];
				header("Location:/caisses/public/home/globalReport");
				
			}

		}
	}

	public function totals(){
		if(!empty($_POST['submit'])){
			$_SESSION["report_type"] = $_POST['report_type'];
			$_SESSION["date"] = $_POST['timestamp'];
			header("Location:/caisses/public/home/globalTotalReport");
		}
	}

	public function saveReport(){
		if(!empty($_POST['submit'])){

			$date = $_SESSION["date"] . " 00:00:00.000";
			if(!empty($_POST['report_id'])){
				// var_dump($_POST);
				// die();
				for($j=0;$j<count($_POST["sale_id"]);$j++){
					if(!empty($_POST["item_id"][$j])){
						$item = $this->lboss->getItem($_POST["item_id"][$j]);
					}else{
						$item = '';
					}
					// var_dump($_POST);
					// var_dump()
					if(!empty($item)){
						$this->lboss->updateItem($_POST["item_id"][$j], $_POST["real_amount"][$j]);
					}else{
						$item = array("report_id" => $_POST['report_id'], "weight" => $_POST['weight'][$j], "sale_name" => $_POST['sale_name'][$j], 
								  "quantity" => $_POST['quantity'][$j], 'sale_id' => $_POST['sale_id'][$j],
								  "amount" => $_POST['amount'][$j], 'real_amount' => $_POST['real_amount'][$j]);
						$this->lboss->setItem($item);
					}
				}
			}else{
				$report = array('timestamp' => $date, "cashier_id" => $_POST['cashier_id'], 'period' => "D", "cashier_name" => $_POST['cashier_name'], "report_type" => $_POST['report_type'], "initial_charge" => $_POST['initial_charge']);
				$report_id = $this->lboss->setReport($report);
				for($i=0;$i<count($_POST['sale_id']);$i++){
					$item = array("report_id" => $report_id, "weight" => $_POST['weight'][$i], "sale_name" => $_POST['sale_name'][$i],
								  "quantity" => $_POST['quantity'][$i], 'sale_id' => $_POST['sale_id'][$i],
								  "amount" => $_POST['amount'][$i], 'real_amount' => $_POST['real_amount'][$i]);
					$this->lboss->setItem($item);
				}
			}
		}
		header('Location:/caisses/public/home');
	}

	public function setData(){
		if(empty($_POST['submit'])){
			header("Location:/caisses/public/home");
		}
		if(!empty($_POST['date']))
		{
			setCookie("date", $_POST['date']);
			$_SESSION["date"] = $_POST['date'];
		}

		if(!empty($_POST['cashier']))
		{
			setCookie("cashier", $_POST['cashier']);
			$_SESSION["cashier"] = $_POST['cashier'];
		}else{
			setCookie("cashier", "");
			$_SESSION["cashier"] = "";
		}
		header("Location:/caisses/public/home");
	}

	public function setKeyword(){
		if(!empty($_POST['key'])){
			$_SESSION['caisses']['keyword'] = $_POST['key'];
		}else{
			$_SESSION['caisses']['keyword'] = '';
		}
		echo $_SESSION['caisses']['keyword']; die();
	}





	public function logout()
	{
		session_unset();
		session_destroy();
		header('Location: /caisses/public/login');
	}

	private function renderView($data)
	{
		if(!empty($data))
		{
			$this->view('home', $data);
		}
		else
		{
			$this->view('home');
		}
	}

	public function setDefaultDates($from, $to)
	{
		setCookie("from", $from);
		$_SESSION["from"] = $from;
		setCookie("to", $to);
		$_SESSION["to"] = $to;
		if(!empty($from))
		{
			$this->from = $from;
		}
		if(!empty($to))
		{
			$this->to = $to;
		}
	}
}