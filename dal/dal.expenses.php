<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALExpense
{
	
	function __construct()
	{

	}
	public function insertExpense($categoryId,$explanation,$amount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `expenses`(`id`, `explanation`, `amount`, `date`, `expenseCategoryId`, `seId`) VALUES ('','$explanation',$amount,'$date',$categoryId,$seId)";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function updateExpense($id,$categoryId,$explanation,$amount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `expenses` SET `explanation`='$explanation',`amount`=$amount,`date`='$date',`expenseCategoryId`=$categoryId,`seId`=$seId WHERE id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}

	public function deleteExpense($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `expenses` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getExpenseById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `expenses` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getExpenseByCategoryId($categoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT salesexecutive.name AS seName,expenses.* FROM expenses,salesexecutive WHERE salesexecutive.id = expenses.seId && expenses.expenseCategoryId = $categoryId && expenses.date BETWEEN '".$dateFrom."' AND '".$dateTo."'";
		//echo $sql;
		$result = $utility->dbQuery($sql);
		return $result;
	}

}
?>