<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALMFS
{
	
	function __construct()
	{

	}
	public function insertMFS($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `mfs`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,$seId,'$date')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateMFS($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `mfs` SET `subCategoryId`=$subCategoryId,`explanation`='$explanation',`pcs`=$pcs,`unitPrice`=$unitPrice,`netAmount`=$netAmount,`seId`=$seId,`date`='$date' WHERE `id`= $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showMFS()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `mfs` WHERE 1";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteMFS($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `mfs` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getMFSById($id)
	{
		$utility = new Utility;
		$sql = "SELECT mfs.*,category.id as categoryId,mfs.subCategoryId as subCategoryId FROM `mfs`,`subcategory`,`category` WHERE mfs.subCategoryId = subcategory.id && subcategory.categoryId = category.id && mfs.id = ".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getMFSBySE($userId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `mfs` WHERE mfs.seId = $userId && mfs.date ='".$utility->getDate()."'";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}
	public function getMFSBySEId($seId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT mfs.*,category.id as categoryId,subcategory.name as subCategory FROM `mfs`,`subcategory`,`category` WHERE mfs.subCategoryId = subcategory.id && subcategory.categoryId = category.id && mfs.seId = $seId && mfs.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getMFSByCategoryId($categoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT mfs.*, subcategory.name AS subCategory,salesexecutive.name as seName FROM mfs,subcategory,salesexecutive WHERE $categoryId = subcategory.categoryId && subcategory.id = mfs.subCategoryId && mfs.seId = salesexecutive.id && mfs.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}

}
?>