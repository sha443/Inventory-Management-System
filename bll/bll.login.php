<?php
include ('../includes/utility.php');

$login = new Login;
class Login
{
	
	function __construct()
	{
		$utility = new Utility;
		
		if(isset($_POST['login_submit']))
		{
			$userName = $_POST['userName'];
			$password = $_POST['password'];
			$secureUserName = $utility->secureInput($userName);
			$securePassword = $utility->secureInput($password);
			$hash = hash('sha256','shahid@cseku'.$securePassword);
			$result = $utility->userLogin($secureUserName,$hash);

			if($result)
			{
				//echo "logged in";
				$_SESSION['message'] = "Login Successul! Welcome.";
				$utility->redirect('../index.php');
			}
			else
			{
				//$_SESSION['message'] = "Login failed !";
				$utility->redirect('../login.php');

			}
		}
	}
}

?>