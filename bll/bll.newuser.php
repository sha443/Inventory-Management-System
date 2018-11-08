<?php
include ('../includes/utility.php');

$newUser = new NewUser;
class NewUser
{
	
	function __construct()
	{
		$utility = new Utility;
		
		if(isset($_POST['addUser']))
		{
			$name = $utility->secureInput($_POST['name']);
			$password = $utility->secureInput($_POST['password']);
			$hash = hash('sha256','shahid@cseku'.$password);
			
			$result = $utility->newUser($name,$hash);

			if($result)
			{
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();

			}
		}
	}
}

?>