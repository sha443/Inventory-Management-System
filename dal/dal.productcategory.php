<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.profit.php');

class DALProductCategory
{
	
	function __construct()
	{

	}
	public function insertCategory($categoryName)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `category`(`id`, `name`) VALUES ('','$categoryName')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateCategory($id,$categoryName)
	{
		$utility = new Utility;
		$sql = "UPDATE `category` SET `name`='$categoryName' WHERE id=$id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showCategory()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `category` WHERE 1 ORDER BY name ASC";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteCategory($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `category` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getCategoryById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `category` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
//---------------- Sub Category---------------------

	public function insertSubCategory($subCategoryName,$categoryId)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `subcategory`(`id`, `name`, `categoryId`) VALUES ('','$subCategoryName',$categoryId)";
		$result = $utility->dbQuery($sql);

		// Create profit chart.
		$dalProfit = new DALProfit;
		$result = $dalProfit->insertProfit($subCategoryName);

		return $result;

	}
	public function updateSubCategory($id,$subCategoryName,$categoryId)
	{
		$utility = new Utility;
		$sql = "UPDATE `subcategory` SET `name`='$subCategoryName',`categoryId`=$categoryId WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showSubCategory()
	{
		$utility = new Utility;
		$sql = "SELECT subcategory.name AS subCategoryName,subcategory.id,category.name AS categoryName,subcategory.categoryId FROM `subcategory`,`category` WHERE subcategory.categoryId = category.id ";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteSubCategory($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `subcategory` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSubCategoryById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `subcategory` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSubCategoryByCategoryId($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `subcategory` WHERE categoryId=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>