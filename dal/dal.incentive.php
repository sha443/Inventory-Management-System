<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALIncentive
{
	
	function __construct()
	{

	}
	public function getIncentive($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `incentive` WHERE incentive.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function insertIncentive($explanation,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `incentive`(`id`, `explanation`, `netAmount`, `date`) VALUES ('','$explanation','$netAmount','$date')";
		$result = $utility->dbQuery($sql);

		return $result;

	}
	public function updateIncentive($id,$explanation,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `incentive` SET explanation = '$explanation',netAmount=$netAmount,`date`= '$date' WHERE incentive.id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}

	public function deleteIncentive($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `incentive` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getIncentiveById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `incentive` WHERE incentive.id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>