<?php
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# CORN JOB
# Call once per day at 11:59 PM
# 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	$host = "localhost";
	$user = "";
	$password = "";
	$db = "";
	$con = mysqli_connect($host,$user,$password,$db) or die ("Couldn't connnect".mysql_error());
$corn = new Corn;
class Corn
{
	
	function __construct()
	{
		// Calculate each day inventory and save into database.
    	$time = time();
        $today = date('Y-m-d',$time);
        $y = strtotime("-1 day", $time);
        $yesterday = date('Y-m-d',$y);

        // Fetch subCategory
        $resultSubCat = $this->getSubCategories();
        while ($resSubCat = mysqli_fetch_assoc($resultSubCat))
        {
            $subCatId = $resSubCat['id'];
            $subCatName = $resSubCat['name'];

    // Get Opening inventory
            $resultInventoryOpening = $this->getOpeningInventory($subCatName,$yesterday);
            $totalInventoryOpening = 0;
            $totalInventoryValueOpening = 0;
            while ($resInventoryOpening = mysqli_fetch_assoc($resultInventoryOpening))
            {
               $totalInventoryOpening += $resInventoryOpening['pcs'];
               $totalInventoryValueOpening += $resInventoryOpening['netAmount'];
            }
            if($totalInventoryOpening == NULL)
            {
                $totalInventoryOpening = 0;
                $totalInventoryValueOpening = 0;
            }
    // Inventory Today
            $resultInventoryToday = $this->getTodayInventory($subCatName,$today);
            $totalInventoryToday = 0;
            $totalInventoryValueToday = 0;
            while ($resInventoryToday = mysqli_fetch_assoc($resultInventoryToday))
            {
               $totalInventoryToday += $resInventoryToday['pcs'];
               $totalInventoryValueToday += $resInventoryToday['netAmount'];
            }
            if($totalInventoryToday == NULL)
            {
                $totalInventoryToday = 0;
                $totalInventoryValueToday = 0;
            }
    // Sales goods
            $resultSales = $this->getSalesReportBySubCategoryName($subCatName,$today);
            // variables
            $totalSales = 0;
            $totalSalesValue = 0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
                // At most 1 row returns :-)
               $totalSales = $resSales['pcs'];
               $totalSalesValue = $resSales['netAmount'];
            }
            if($totalSales == NULL)
            {
                $totalSales = 0;
                $totalSalesValue = 0;
            }
    // Return goods
            $resultReturns = $this->getReturnGoodsBySubCategoryName($subCatName,$today);
            // variables
            $totalReturns = 0;
            $totalReturnsValue = 0;
            while ($resReturns = mysqli_fetch_assoc($resultReturns))
            {
                // At most 1 row returns :-)
               $totalReturns = $resReturns['pcs'];
               $totalReturnsValue = $resReturns['netAmount'];
            }
            if($totalReturns == NULL)
            {
                $totalReturns = 0;
                $totalReturnsValue = 0;
            }



            // Closing calculation
            // Closing = opening + today - sales
            $closingPcs = $totalInventoryOpening+$totalInventoryToday - $totalSales+$totalReturns;
            $closingValue = $totalInventoryValueOpening+$totalInventoryValueToday - $totalSalesValue+$totalReturnsValue;
            // Assumed average unit price today.
            if($closingPcs==0)
            {
                $divider = 1;
            }
            else
            {
                $divider = $closingPcs;
            }
            $unitPrice = $closingValue/$divider;
            //echo $subCatName."->".$closingPcs." PCS.->".$closingValue." TK.".$today.'<br>';
            $explanation = "Opening Product";
            $this->cornClosingInventory($subCatId,$explanation,$closingPcs,$unitPrice,$closingValue,$today);
        }
    }



/// Functions 
       
 // Sub category id
	public function getSubCategories()
	{
	    global $con;
		$sql = "SELECT * FROM subcategory";
		$result = mysqli_query($con,$sql);
		return $result;
	}
// Closing goods of yesterday 
// Closings are calcualted by corn job.
	public function getOpeningInventory($subCatName,$yesterday)
	{
		global $con;
		$sql = "SELECT * FROM `closinginventory`,`subcategory` WHERE closinginventory.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && closinginventory.date = '$yesterday'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
	public function getTodayInventory($subCatName,$today)
	{
		global $con;
		$sql = "SELECT inventory.* FROM `inventory`,`subcategory` WHERE inventory.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && inventory.date = '$today'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
	public function getSalesReportBySubCategoryName($subCategoryName,$date)
	{
		global $con;
		$sql = "SELECT SUM(sales.pcs) as pcs, SUM(sales.netAmount) as netAmount FROM sales,subcategory WHERE sales.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && sales.date ='$date'";
		$result = mysqli_query($con,$sql);
		return $result;
	}
    public function getReturnGoodsBySubCategoryName($subCategoryName,$date)
    {
        global $con;
        $sql = "SELECT SUM(returns.pcs) as pcs, SUM(returns.netAmount) as netAmount FROM returns,subcategory WHERE returns.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && returns.date ='$date'";
        $result = mysqli_query($con,$sql);
        return $result;
    }
	
	public function cornClosingInventory($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date)
	{
		global $con;
		$sql = "INSERT INTO `closinginventory`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,'$date')";
		$result = mysqli_query($con,$sql);
		return $result;

	}

}
	
       
       


?>