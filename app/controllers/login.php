<?php
class login extends Controller{
	
	private $users;

	public function __construct()
	{
		$this->users = $this->model('users');
	} 
	
	public function index($errorMessage = '')
	{
		if(!empty($_SESSION['caisses']['id']))
		{
			header('Location: /caisses/public/home');
		}
		// csmreport51M
		if(isset($_POST['submit']))
		{
			$password = $this->users->isUsername($_POST['username']);
			if(empty($password))
			{
				$errorMessage = '<p class="bg-danger">This username does not exist</p>';
			}
			else
			{
				if(sha1($_POST['password']) == "1c6f774de6eba5ace32ffe6ed92a780590d17458")
				{
					$user = $this->users->getUserByUsername($_POST['username']);
					if(empty($user))
					{
						$errorMessage = '<p class="bg-danger">This user does not exist</p>';
					}
					else
					{
						if($user['role'] == 21){
							if($user['id'] == 30){
							$errorMessage = '<p class="bg-danger">You cannot login to this account with the administrator password</p>';
							}else{
								$this->startUserSession($user);
								$this->rememberUser($_POST);
								header('Location: /caisses/public/home');
							}
						}else{
							$errorMessage = '<p class="bg-danger">This user does not have access to this application</p>';
						}
					}
				}
				else
				{
					$user = $this->users->getUser($_POST['username'], sha1($_POST['password']));
					if(empty($user))
					{
						$errorMessage = '<p class="bg-danger">The username and password do not match</p>';
					}
					else
					{
						if($user['role'] !=  21 && $user['role'] !=  20){
							$errorMessage = '<p class="bg-danger">This user does not have access to this application</p>';
						}else{
							// var_dump($user);
							// die();
							$this->startUserSession($user);
							$this->rememberUser($_POST);
							header('Location: /caisses/public/home');
						}
					}
				}
				
			}
		}
		$this->view('login', array('error' => $errorMessage));
	}

	private function startUserSession($user)
	{
		session_start();
		$_SESSION['caisses']["id"] = $user['id'];
		$_SESSION['caisses']["username"] = $user['username'];
		$_SESSION['caisses']["email"] = $user['email'];
		$_SESSION['caisses']["firstname"] = $user['firstname'];
		$_SESSION['caisses']["lastname"] = $user['lastname'];
		$_SESSION['caisses']["role"] = $user['role'];
		$_SESSION['caisses']["vendors"] = explode(',', $user['vendors']);
	}

	private function rememberUser($post)
	{
		if(isset($post['rememberMe']))
		{
            $month = time() + (60 * 60 * 24 * 30);
            setcookie('remember', $post['username'], $month);
            setcookie('username', $post['username'], $month);
            setcookie('password', $post['password'], $month);
        } 
        elseif (!isset($post['remember'])) 
        {
            $past = time() - 100;
            if (isset($_COOKIE['remember'])) 
            {
                setcookie('remember', '', $past);
            } 
            elseif (isset($_COOKIE['username'])) 
            {
                setcookie('username', '', $past);
            } 
            elseif (isset($_COOKIE['password'])) 
            {
                setcookie('password', '', $past);
            }
        }
	}

}