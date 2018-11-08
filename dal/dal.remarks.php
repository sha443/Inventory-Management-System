<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALRemarks
{
	
	function __construct()
	{

	}
	public function getRemarks($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `remarks`,`user` WHERE remarks.userId = user.id && remarks.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function insertRemarks($userId,$text,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `remarks`(`id`, `userId`, `text`, `date`) VALUES ('',$userId,'$text','$date')";
		$result = $utility->dbQuery($sql);

		return $result;

	}
	public function updateRemarks($id,$userId,$text)
	{
		// Date uneditable 
		$utility = new Utility;
		$sql = "UPDATE `remarks` SET `userId`='$userId',`text`='$text' WHERE remarks.id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}

	public function deleteRemarks($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `remarks` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getRemarksById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `remarks`,`user` WHERE remarks.userId = user.id && remarks.id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>