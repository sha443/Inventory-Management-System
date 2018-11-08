<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALInventory
{
	
	function __construct()
	{

	}
	public function insertInventory($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;

		$sql = "INSERT INTO `inventory`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,'$date')";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function updateInventory($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `inventory` SET `explanation`='$explanation',`pcs`=$pcs,`unitPrice`=$unitPrice,`date`='$date',`subCategoryId`=$subCategoryId, `netAmount` = $netAmount WHERE id = $id";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function showInventory()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `inventory` WHERE 1 ORDER BY inventory.date ASC";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteInventory($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `inventory` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getInventoryById($id)
	{
		$utility = new Utility;
		$sql = "SELECT inventory.*,category.id as categoryId FROM `inventory`,`subcategory`,`category` WHERE inventory.subCategoryId = subcategory.id && subcategory.categoryId = category.id && inventory.id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getInventoryBySubCategoryId($subCategoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `inventory` WHERE inventory.subCategoryId = $subCategoryId && inventory.date  BETWEEN '".$dateFrom."' AND '".$dateTo."'";
		//echo $sql;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getProfitSE($subCategoryId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `profit` WHERE profit.subCategoryId = $subCategoryId";
		$result = $utility->dbQuery($sql);

		$percentage=0;
		while ($res = mysqli_fetch_assoc($result))
		{
			$percentage = $res['seRate'];
		}
		return $percentage ;
	}
	public function getProfitPOS($subCategoryId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `profit` WHERE profit.subCategoryId = $subCategoryId";
		$result = $utility->dbQuery($sql);

		$percentage=0;
		while ($res = mysqli_fetch_assoc($result))
		{
			$percentage = $res['seRate'];
		}
		return $percentage ;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# CORN JOB HERE
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function cornClosingInventory($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closinginventory`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,'$date')";

		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function cornClosingVault($closingVault,$today)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closingvault`(`id`, `netAmount`, `date`) VALUES('',$closingVault,'$today')";
		$result = $utility->dbQuery($sql);
		return $result;

	}

}
?>