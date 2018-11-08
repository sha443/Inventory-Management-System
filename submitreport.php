<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$time = time();
$date = date('Y-m-d',$time);
$sql = "INSERT INTO `flag`(`id`, `submit`, `date`) VALUES ('',1,'$date')";

$utility = new Utility;
$result = $utility->dbQuery($sql);

/// After submitting report log out automatically 

if($result)
{
	if(!isset($_SESSION))
	{
		session_start();
	}
	session_unset();
	session_destroy();
	header('Location:index.php');
}
?>