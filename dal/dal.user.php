<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALUser
{
	
	function __construct()
	{

	}
	public function insertSE($fullName,$phoneNo,$address)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `salesexecutive`(`id`, `name`, `phoneNo`, `address`) VALUES ('','$fullName','$phoneNo','$address')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateSE($id,$fullName,$phoneNo,$address)
	{
		$utility = new Utility;
		$sql = "UPDATE `salesexecutive` SET `name`='$fullName',`phoneNo`='$phoneNo',`address`= '$address' WHERE id=$id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showSE()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `salesexecutive` WHERE 1 ORDER BY salesexecutive.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getUser()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `user` WHERE 1 ORDER BY user.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteSE($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `salesexecutive` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSEById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `salesexecutive` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>