<?php
include ('../includes/utility.php');

$changePassword = new ChangePassword;
class ChangePassword
{
	
	function __construct()
	{
		$utility = new Utility;
		
		if(isset($_POST['changePassword']))
		{
			$userId = $utility->secureInput($_POST['userId']);
			$new = $utility->secureInput($_POST['new']);
			$old = $utility->secureInput($_POST['old']);
			$hashOld = hash('sha256','shahid@cseku'.$old);
			$hashNew = hash('sha256','shahid@cseku'.$new);

			$result = $utility->changePassword($hashOld,$hashNew,$userId);

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