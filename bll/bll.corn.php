<?php
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# CORN JOB
# Call once per day at 11:59 PM
# 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.inventory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/bll/bll.reports.php');

	$dalInventory = new DALInventory;
    $dalReports = new DALReports;
	$bllReports = new BLLReports;
	// Calculate each day inventory and save into database.
	$time = time();
    $today = date('Y-m-d',$time);
    $y = strtotime("-1 day", $time);
    $yesterday = date('Y-m-d',$y);

    // Fetch subCategory
    $resultSubCat = $dalReports->getSubCategories();
    while ($resSubCat = mysqli_fetch_assoc($resultSubCat))
    {
        $subCatId = $resSubCat['id'];
        $subCatName = $resSubCat['name'];

        // Inventory Opening
        $resultInventoryOpening = $dalReports->getOpeningInventory($subCatName,$yesterday);
        // variables
        $totalInventoryOpening = 0;
        $totalInventoryValueOpening = 0;
        while ($resInventoryOpening = mysqli_fetch_assoc($resultInventoryOpening))
        {
            // More than 1 row returns :-) ;-)
           $totalInventoryOpening += $resInventoryOpening['pcs'];
           $totalInventoryValueOpening += $resInventoryOpening['netAmount'];
        }
        if($totalInventoryOpening == NULL)
        {
            $totalInventoryOpening = 0;
            $totalInventoryValueOpening = 0;
        }

        // Inventory Today: Today actually
        $resultInventoryToday = $dalReports->getTodayInventory($subCatName,$today);
        // variables
        $totalInventoryToday = 0;
        $totalInventoryValueToday = 0;
        while ($resInventoryToday = mysqli_fetch_assoc($resultInventoryToday))
        {
            // More than 1 row returns :-) ;-)
           $totalInventoryToday += $resInventoryToday['pcs'];
           $totalInventoryValueToday += $resInventoryToday['netAmount'];
        }
        if($totalInventoryToday == NULL)
        {
            $totalInventoryToday = 0;
            $totalInventoryValueToday = 0;
        }

        // OnHand goods
        $resultOnHand = $dalReports->getOnHandBySubCategoryName($subCatName,$today);
        // variables
        $totalOnHand = 0;
        $totalOnHandValue = 0;
        while ($resOnHand = mysqli_fetch_assoc($resultOnHand))
        {
           $totalOnHand = $resOnHand['pcs'];
           $totalOnHandValue = $resOnHand['netAmount'];
        }
        if($totalOnHand == NULL)
        {
            $totalOnHand = 0;
            $totalOnHandValue = 0;
        }

         // Sales goods
        $resultSales = $dalReports->getSalesReportBySubCategoryName($subCatName,$today);
        // variables
        $totalSales = 0;
        $totalSalesValue = 0;
        while ($resSales = mysqli_fetch_assoc($resultSales))
        {
           $totalSales = $resSales['pcs'];
           $totalSalesValue = $resSales['netAmount'];
        }
        if($totalSales == NULL)
        {
            $totalSales = 0;
            $totalSalesValue = 0;
        }

         // Return goods
        $resultReturns = $dalReports->getReturnsReportBySubCategoryName($subCatName,$today);
        // variables
        $totalReturns = 0;
        $totalReturnsValue = 0;
        while ($resReturns = mysqli_fetch_assoc($resultReturns))
        {
           $totalReturns = $resReturns['pcs'];
           $totalReturnsValue = $resReturns['netAmount'];
        }
        if($totalReturns == NULL)
        {
            $totalReturns = 0;
            $totalReturnsValue = 0;
        }

        // Closing calculation

        $closingPcs = $totalInventoryOpening+$totalInventoryToday+$totalReturns-$totalOnHand;
        $utility = new Utility;
        // Why not buy?? othewise always will be increased
        $unitPrice = $utility->getBuyPrice($subCatId);
        $closingValue = $closingPcs*$unitPrice;

        $explanation = "Corn Job";
        $dalInventory->cornClosingInventory($subCatId,$explanation,$closingPcs,$unitPrice,$closingValue,$today);

    }
    /// Vault cron 

    $closingVault = $bllReports->getClosingVault($today,$yesterday);
    $dalInventory->cornClosingVault($closingVault,$today);

    //echo "Cron Job run successfully.";
?>