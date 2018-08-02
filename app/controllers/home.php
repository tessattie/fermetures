<?php
session_start();
class home extends Controller{

	private $brdata;
	
	private $today;
	
	private $from;
	
	private $to;

	private $exportURL;

	private $queryTitles;

	private $classname;

	private $fileArianne;

	public function __construct()
	{
		parent::__construct();
		$this->today = date('Y-m-d', strtotime("-1 days"));
		if(!isset($_COOKIE["from"]))
		{
			setCookie("from", date('Y-m-d', strtotime("-1 week")));
			$_COOKIE["from"] = date('Y-m-d', strtotime("-1 week"));
		}
		else
		{
			$this->from = $_COOKIE["from"];
		}
		if(!isset($_COOKIE["to"]))
		{
			setCookie("to", date('Y-m-d'));
			$_COOKIE["to"] = date('Y-m-d');
		}
		else
		{
			$this->to = $_COOKIE["to"];
		}
		$this->classname = "thereport";
		if(empty($_SESSION['caisses']['keyword'])){
			$_SESSION['caisses']['keyword'] = '';
		}
		$this->exportURL = "javascript: void(0)";
		$this->brdata = $this->model('brdata');
		$this->fileArianne = "HOME";
	} 

	public function index()
	{
		$data = array();
		$this->view('home', $data);
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
		$_COOKIE["from"] = $from;
		setCookie("to", $to);
		$_COOKIE["to"] = $to;
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