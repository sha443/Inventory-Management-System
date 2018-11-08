<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALReturns
{
	
	function __construct()
	{

	}
	public function insertReturns($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `returns`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,$seId,'$date')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateReturns($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `returns` SET `subCategoryId`=$subCategoryId,`explanation`='$explanation',`pcs`=$pcs,`unitPrice`=$unitPrice,`netAmount`=$netAmount,`seId`=$seId,`date`='$date' WHERE `id`= $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showReturns()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `returns` WHERE 1";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteReturns($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `returns` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getReturnsById($id)
	{
		$utility = new Utility;
		$sql = "SELECT returns.*,category.id as categoryId,returns.subCategoryId as subCategoryId FROM `returns`,`subcategory`,`category` WHERE returns.subCategoryId = subcategory.id && subcategory.categoryId = category.id && returns.id = ".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getReturnsBySE($userId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `returns` WHERE returns.seId = $userId && returns.date ='".$utility->getDate()."'";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}
	public function getReturnsBySEId($seId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT returns.*,category.id as categoryId,subCategory.name as subCategory FROM `returns`,`subcategory`,`category` WHERE returns.subCategoryId = subcategory.id && subcategory.categoryId = category.id && returns.seId = $seId && returns.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getReturnsByCategoryId($categoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT returns.*, subcategory.name AS subCategory,salesexecutive.name as seName FROM returns,subcategory,salesexecutive WHERE $categoryId = subcategory.categoryId && subcategory.id = returns.subCategoryId && returns.seId = salesexecutive.id && returns.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}

}
?>