<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


$utility = new Utility;

// Install User 
$sqlUser = "INSERT INTO `user`(`id`, `userName`, `password`) VALUES ('','Kazi','7a6b318ebb24d5bb9a1a3f8d566ebaaa50d7f30f0b4c0a5fb0004365ad45bda9'), ('','AC','7a6b318ebb24d5bb9a1a3f8d566ebaaa50d7f30f0b4c0a5fb0004365ad45bda9')";
$resultUser = $utility->dbQuery($sqlUser);

if($resultUser)
{
	echo "User Installation successfull!<br>";
}

// Install Permission 
$pageArray = array(
	'index.php',
	'productcategpry.php',
	'inventory.php',
	'inventoryreport.php',
	'mfs.php',
	'sales.php',
	'salesreport.php',
	'expensecategory.php',
	'expenses.php',
	'expensereport.php',
	'bankdeposite.php',
	'user.php',
	'newuser.php',
	'changepassword.php'
);

foreach ($pageArray as $page)
{
	$sqlPage = "INSERT INTO `permission`(`id`, `userId`, `page`) VALUES ('',1,'$page')";
	$resultPage = $utility->dbQuery($sqlPage);
}

if($resultPage)
{
	echo "Permission Installation successfull!<br>";
}

?>