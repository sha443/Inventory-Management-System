<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALExpenseCategory
{
	
	function __construct()
	{

	}
	public function insertCategory($expensecategoryName)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `expensecategory`(`id`, `name`) VALUES ('','$expensecategoryName')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateCategory($id,$expensecategoryName)
	{
		$utility = new Utility;
		$sql = "UPDATE `expensecategory` SET `name`='$expensecategoryName' WHERE id=$id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showCategory()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `expensecategory` WHERE 1 ORDER BY name ASC";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteCategory($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `expensecategory` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getCategoryById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `expensecategory` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}

}
?>