<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');


class DALReports
{
	
	function __construct()
	{

	}
// Sub category id
	public function getSubCategories()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM subcategory";
		$result = $utility->dbQuery($sql);
		return $result;
	}
// Sales report
	public function getSalesReport($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT category.name as categoryName, SUM(sales.netAmount) as total FROM sales,subcategory,category WHERE sales.subCategoryId = subcategory.id && subcategory.categoryId = category.id && sales.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY categoryName";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getSalesReportBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(sales.pcs) as pcs, SUM(sales.netAmount) as netAmount FROM sales,subcategory WHERE sales.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && sales.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getOnHandBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(mfs.pcs) as pcs, SUM(mfs.netAmount) as netAmount FROM mfs,subcategory WHERE mfs.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && mfs.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
// Expense report
	public function getExpenseReport($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT expensecategory.name as categoryName, SUM(expenses.amount) as total FROM expenses,expensecategory WHERE expensecategory.id = expenses.expenseCategoryId && expenses.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY categoryName";
		$result = $utility->dbQuery($sql);
		return $result;
	}

// Closing goods of yesterday 
// Closings are calcualted by corn job.
	public function getOpeningInventory($subCatName,$yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `closinginventory`,`subcategory` WHERE closinginventory.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && closinginventory.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTodayInventory($subCatName,$today)
	{
		$utility = new Utility;
		$sql = "SELECT inventory.* FROM `inventory`,`subcategory` WHERE inventory.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && inventory.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

// Return goods
	public function getReturnsReportBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(returns.pcs) as pcs, SUM(returns.netAmount) as netAmount FROM returns,subcategory WHERE returns.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && returns.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
/// Opening vault
	public function getOpeningVault($yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM closingvault WHERE closingvault.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Corn Job: Closing Inventory
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function cornClosingInventory($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closinginventory`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,$date)";
		$result = $utility->dbQuery($sql);
		return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Final Inventory Report
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getTotalOpeningInventory($yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM closinginventory WHERE closinginventory.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTotalArrivedInventory($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM inventory WHERE inventory.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getTotalSales($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM sales WHERE sales.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	/// only mfs returns
	public function getTotalReturns($today)
	{
		$utility = new Utility;
		$sql = "SELECT returns.* FROM returns WHERE  returns.subCategoryId = 2 && returns.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTotalIncentives($today)
	{
		// 2.75% is for POS value
		$utility = new Utility;
		$sql = "SELECT * FROM incentive WHERE incentive.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTotalCost($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM expenses WHERE expenses.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getBankDeposite($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `bankdeposite` WHERE bankdeposite.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getStatus($date)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `flag` WHERE flag.date = '$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>