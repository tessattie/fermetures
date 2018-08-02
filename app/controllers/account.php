<?php 
session_start();
class account extends Controller{

	private $users;

	private $exportURL;

	private $roles = [];

	private $from;
	
	private $to;


	public function __construct()
	{
		parent::__construct();
		$this->exportURL = "#";
		$this->roles = array(20 => "Admin", 21 => "User");
		$this->users = $this->model('users');
		$this->from = date('Y-m-01');
		$this->to = date('Y-m-d');
	} 

	public function index($errormessage = '')
	{
		// Crypted default password
		$this->checkSession();
		$password = "af2c173028114539479ac8e71208f42d921dbafd";

		if(isset($_POST['submit']))
		{
			if(empty($this->roles[$_POST["role"]]))
			{
				$_POST["role"] = 21;
			}
			$_POST['password'] = $password;
			$this->users->setUser($_POST);
		}

		$users = $this->users->getUsers();
		$count = count($users);

		for($i=0;$i<$count;$i++)
		{
			$users[$i]['role'] = $this->roles[$users[$i]['role']];
		}

		$this->view('account', array('users' => $users, 'error' => $errormessage, "menu" => $this->userRole, "exportURL" => $this->exportURL, "from" => $this->from, "to" => $this->to));
	}

	public function delete($userId)
	{
		$this->users->deleteUser($userId);
		if($_SESSION['caisses']['id'] == $userId)
		{
			header('Location: /caisses/public/login');
		}
		else
		{
			header('Location: /caisses/public/account');
		}
	}

	public function edit($id = false)
	{
		$errormessage = "";
		if(isset($_POST['submit']))
		{
			// print_r($_POST);die();
			$this->users->updateUser($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['role'], $_POST['id'], $_POST['vendors']);
		}
		$users = $this->users->getUsers();
		$user = $this->users->getUserById($id);
		$this->view('account/edit', array("user" => $user, "users" => $users, "error" => $errormessage, "menu" => $this->userRole, "exportURL" => $this->exportURL, "from" => $this->from, "to" => $this->to));
	}

	public function reset($userId)
	{
		$password = "01b307acba4f54f55aafc33bb06bbbf6ca803e9a";
		$this->users->setPassword($userId, $password);
		if($_SESSION['caisses']['id'] == $userId)
		{
			header('Location: /caisses/public/login');
		}
		else
		{
			header('Location: /caisses/public/account');
		}
	}

	public function changePassword()
	{
		if(isset($_POST['oldpass']))
		{
			$oldpass = sha1($_POST['oldpass']);
			$user = $this->users->getUser($_SESSION['caisses']['username'], sha1($_POST['oldpass']));
			if(!empty($user))
			{
				if(isset($_POST['newpass']) && isset($_POST['newpass2']) && $_POST['newpass2'] == $_POST['newpass'])
				{
					$this->users->setPassword($_SESSION['caisses']['id'], sha1($_POST['newpass']));
					session_unset();
					session_destroy();
					header('Location: /caisses/public/login');
				}
				else
				{
					header('Location: /caisses/public/account');
				}
			}
			else
			{
				header('Location: /caisses/public/account/');
			}
		}
	}
}