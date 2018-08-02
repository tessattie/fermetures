<?php
class Controller{

	private $roles;

	protected $userRole;

	protected $log;

	public function __construct()
	{
		$this->userRole = $this->setRole();
		$this->logs = $this->model('log');
	}

	public function model($model)
	{
		if(file_exists('../app/models/' . $model . '.php'))
		{
			require_once '../app/models/' . $model . '.php';
			$return = new $model();
		}
		else
		{
			$return = false;
		}
		return $return;
	}

	public function phpExcel()
	{
		if(file_exists('../app/vendors/PHPExcel/Classes/PHPExcel.php'))
		{
			require_once '../app/vendors/PHPExcel/Classes/PHPExcel.php';
		}
		else
		{
			require_once '../app/vendors/PHPExcel/Classes/PHPExcel.php';
		}
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		return new PHPExcel();
	}

	public function view($view, $data = [])
	{
		if(file_exists('../app/views/'. $view . '/index.php'))
		{
			require_once '../app/views/'. $view . '/index.php';
		}
		else
		{
			require_once '../app/views/default.php';
		}
	}

	public function checkSession()
	{
		if(!isset($_SESSION['caisses']['id']))
		{
			header('Location: /caisses/public/login');
		}
	}

	public function setRole()
	{
		$role = "";
		if(isset($_SESSION['caisses']['role']))
		{
			$role = $this->roles[$_SESSION['caisses']['role']];
		}
		else
		{
			if(!isset($_SESSION['caisses']['id']))
			{
				header('Location: /caisses/public/login');
			}
		}
		return $role;
	}

	public function saveLog($action)
	{
		$this->logs->saveLog($date, 1, $action);
	}
}