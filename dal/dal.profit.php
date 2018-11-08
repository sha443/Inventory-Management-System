<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALProfit
{
	
	function __construct()
	{

	}
	public function insertProfit($subCategoryName)
	{
		$utility = new Utility;

		// Default buy and sale value add when new subCategory created 
		$sql = "INSERT INTO `profit`(`id`, `buy`, `sale`, `subCategoryId`) VALUES ('',1,1,(SELECT `id` FROM `subcategory` WHERE subcategory.name = '$subCategoryName'))";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateProfit($id,$buy,$sale)
	{
		$utility = new Utility;
		$sql = "UPDATE `profit` SET `buy`=$buy,`sale`=$sale WHERE id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showProfit()
	{
		$utility = new Utility;
		$sql = "SELECT profit.*,subcategory.name as subCategoryName FROM `profit`,`subcategory` WHERE profit.subCategoryId = subcategory.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>