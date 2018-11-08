<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALQuery
{
	
	function __construct()
	{

	}
	public function getSE($seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `salesexecutive` WHERE salesexecutive.id = $seId";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;
	}

	public function getSales($dateFrom,$dateTo,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `sales` WHERE sales.seId = $seId && sales.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSalesBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `sales` WHERE sales.subCategoryId = $subCategoryId && sales.seId = $seId && sales.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getMFS($dateFrom,$dateTo,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM mfs WHERE mfs.seId = $seId && mfs.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getMFSBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM mfs WHERE mfs.subCategoryId = $subCategoryId && mfs.seId = $seId && mfs.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getReturns($dateFrom,$dateTo,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM returns WHERE returns.seId = $seId && returns.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getReturnsBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM returns WHERE returns.subCategoryId = $subCategoryId && returns.seId = $seId && returns.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getSECost($dateFrom,$dateTo,$seId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM expenses WHERE expenses.seId = $seId && expenses.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSEBank($dateFrom,$dateTo,$seId)
	{
		$utility = new Utility;
	    $sql = "SELECT * FROM bankdeposite WHERE bankdeposite.seId = $seId && bankdeposite.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

}
?>