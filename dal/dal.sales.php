<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALSales
{
	
	function __construct()
	{

	}
	public function insertSales($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `sales`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,$seId,'$date')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateSales($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `sales` SET `subCategoryId`=$subCategoryId,`explanation`='$explanation',`pcs`=$pcs,`unitPrice`=$unitPrice,`netAmount`=$netAmount,`seId`=$seId,`date`='$date' WHERE `id`= $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showSales()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `sales` WHERE 1";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteSales($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `sales` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSalesById($id)
	{
		$utility = new Utility;
		$sql = "SELECT sales.*,category.id as categoryId FROM `sales`,`subcategory`,`category` WHERE sales.subCategoryId = subcategory.id && subcategory.categoryId = category.id && sales.id = ".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSalesBySE($userId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `sales` WHERE sales.seId = $userId && sales.date ='".$utility->getDate()."'";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}
	public function getSalesBySEId($seId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT sales.*, subcategory.name AS subCategory FROM sales,category,subcategory WHERE category.id = subcategory.categoryId && subcategory.id = sales.subCategoryId && sales.seId = $seId && sales.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);

		return $result;
	}

	public function getSalesByCategoryId($categoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT sales.*, subcategory.name AS subCategory,salesexecutive.name as seName FROM sales,subcategory,salesexecutive WHERE $categoryId = subcategory.categoryId && subcategory.id = sales.subCategoryId && sales.seId = salesexecutive.id && sales.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}

}
?>