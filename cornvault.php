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
$cornVault = new CornVault;
class CornVault
{
	
	function __construct()
	{
		// Calculate each day inventory and save into database.
    	$time = time();
        $today = date('Y-m-d',$time);
        $y = strtotime("-1 day", $time);
        $yesterday = date('Y-m-d',$y);

        $closingVault = $this->getClosingVault($today,$yesterday);
        $this->cornClosingVault($closingVault,$today);

    }

    public function getClosingVault($today,$yesterday)
    {
        // Total Opening Inventory
        $resultOpening = $this->getTotalOpeningInventory($yesterday);
        $valueOpening = 0;
        while ($resOpening = mysqli_fetch_assoc($resultOpening))
        {
           $valueOpening += $resOpening['netAmount'];
        }

        // Total Inventory Arrived today
        $resultArrived= $this->getTotalArrivedInventory($today);
        $valueArrived = 0;
        while ($resArrived = mysqli_fetch_assoc($resultArrived))
        {
           $valueArrived += $resArrived['netAmount'];
        }
        // Lifting commission

        $valueCommission = $this->getTotalCommission($today,$yesterday);

        // Total Sales
        $resultSales= $this->getTotalSales($today);
        $valueSales = 0;
        while ($resSales = mysqli_fetch_assoc($resultSales))
        {
           $valueSales += $resSales['netAmount'];
        }

        // Total Cost
        $resultCost= $this->getTotalCost($today);
        $valueCost = 0;
        while ($resCost = mysqli_fetch_assoc($resultCost))
        {
           $valueCost += $resCost['amount'];
        }

        // Bank Deposite
        $resultBank= $this->getBankDeposite($today);
        $valueBank = 0;
        while ($resBank = mysqli_fetch_assoc($resultBank))
        {
           $valueBank += $resBank['netAmount'];
        }

        // Total Incentives
        $resultIncentives= $this->getTotalIncentives($today);
        $valueIncentives= 0;
        while ($resIncentives = mysqli_fetch_assoc($resultIncentives))
        {
           $valueIncentives += $resIncentives['netAmount'];
        }
        // Left 2.75% incentives for POS value
        if($valueIncentives>0)
        {
            $valueIncentives =$valueIncentives- $valueIncentives*(2.75/100);
        }
        // init zero rather deleting from all places :-P
        $valueReturns = 0;

        // Flooring
        $valueOpening = floor($valueOpening);
        $valueArrived = floor($valueArrived);
        $valueSales = floor($valueSales);
        $valueReturns = floor($valueReturns);
        $valueCost = floor($valueCost);
        $valueBank = floor($valueBank);
        $valueIncentives= floor($valueIncentives);
        $valueCommission = floor($valueCommission);

        // Calculations 

        // Opening Value
        // Incentive 
        // PO IN
        // Commission
        // MFS Return
        // -----------------
        // Total Value
        
        $totalValue= $valueOpening+$valueArrived+$valueIncentives+$valueReturns+$valueCommission;


        $closingProduct = $totalProduct+$valueReturns-$valueSales;

        // Opening Vault
        // Total Sale
        // -----------------
        // Total Sale Value
        $openingVault = 0;
        $resultVault = $this->getOpeningVault($yesterday);
        while ($res = mysqli_fetch_assoc($resultVault))
        {
            $openingVault+= $res['netAmount'];
        }
        if($openingVault == NULL)
        {
            $openingVault = 0;
        }
        
        $totalSaleValue = $openingVault+$valueSales;
        // Total Sale Value
        //- Bank 
        //- MFS Return
        //-Cost
        
        // --------------------
        // Close Vault
        $closeVault =$totalSaleValue- ($valueBank+$valueReturns+$valueCost);
        return $closeVault;
    }

// Cron job function
    public function cornClosingVault($closingVault,$today)
    {
        global $con;
        $sql = "INSERT INTO `closingvault`(`id`, `netAmount`, `date`) VALUES('',$closingVault,'$today')";
        $result = mysqli_query($con,$sql);
        return $result;

    }
       
// Helper functions


/// Opening vault
    public function getOpeningVault($yesterday)
    {
        global $con;
        $sql = "SELECT * FROM closingvault WHERE closingvault.date = '$yesterday'";
        $result = mysqli_query($con,$sql);
        return $result;
    }


    public function getTotalOpeningInventory($yesterday)
    {
        global $con;
        $sql = "SELECT * FROM closinginventory WHERE closinginventory.date = '$yesterday'";
        $result = mysqli_query($con,$sql);
        return $result;
    }
    public function getTotalArrivedInventory($today)
    {
        global $con;
        $sql = "SELECT * FROM inventory WHERE inventory.date = '$today'";
        $result = mysqli_query($con,$sql);
        return $result;
    }

    public function getTotalSales($today)
    {
        global $con;
        $sql = "SELECT * FROM sales WHERE sales.date = '$today'";
        $result = mysqli_query($con,$sql);
        return $result;
    }
   
    public function getTotalIncentives($today)
    {
        // 2.75% is for POS value
        global $con;
        $sql = "SELECT * FROM incentive WHERE incentive.date = '$today'";
        $result = mysqli_query($con,$sql);
        return $result;
    }
    public function getTotalCost($today)
    {
        global $con;
        $sql = "SELECT * FROM expenses WHERE expenses.date = '$today'";
        $result = mysqli_query($con,$sql);
        return $result;
    }
    public function getBankDeposite($today)
    {
        global $con;
        $sql = "SELECT * FROM `bankdeposite` WHERE bankdeposite.date = '$today'";
        $result = mysqli_query($con,$sql);
        return $result;
    }

     public function getTotalCommission($today,$yesterday)
    {
        $resultSubCat = $this->getSubCategories();
        $totalCommission = 0;
    
        while ($resSubCat = mysqli_fetch_assoc($resultSubCat))
        {
            $subCatId = $resSubCat['id'];
            $subCatName = $resSubCat['name'];



            // Inventory Today
            $resultInventoryToday = $this->getTodayInventory($subCatName,$today);
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

             
        
            $commissionPcs = $totalInventoryToday;

            $buyPrice = $this->getBuyPrice($subCatId);
            $salePrice = $this->getSalePrice($subCatId);
            $closingProfit = ($commissionPcs*$salePrice)-($commissionPcs*$buyPrice);

            $totalCommission += $closingProfit;

        }

        // Incentive Today
        $resultIncentiveToday = $this->getTotalIncentives($today);
        // variables
        $totalIncentiveToday = 0;
        $totalIncentiveValueToday = 0;
        while ($resIncentiveToday = mysqli_fetch_assoc($resultIncentiveToday))
        {
            // More than 1 row returns :-) ;-)
           $totalIncentiveToday += $resIncentiveToday['pcs'];
           $totalIncentiveValueToday += $resIncentiveToday['netAmount'];
        }
        if($totalIncentiveToday == NULL)
        {
            $totalIncentiveToday = 0;
            $totalIncentiveValueToday = 0;
        }
        $incentiveValue = $incentiveValue-$incentiveValue*(2.75/100);

        return $totalCommission+$incentiveValue;
    }

    public function getTodayInventory($subCatName,$today)
    {
        global $con;
        $sql = "SELECT inventory.* FROM `inventory`,`subcategory` WHERE inventory.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && inventory.date = '$today'";
        $result = mysqli_query($con,$sql);
        return $result;
    }
    public function getSubCategories()
    {
        global $con;
        $sql = "SELECT * FROM subcategory";
        $result = mysqli_query($con,$sql);
        return $result;
    }

    public function getSalePrice($subCategoryId)
    {
        global $con;
        $sql = "SELECT * FROM profit WHERE profit.subCategoryId = $subCategoryId";
        $result = mysqli_query($con,$sql);
        $price;
        while ($res = mysqli_fetch_assoc($result))
        {
            $price = $res['sale'];
        }
        if($price==null)
        {
            $price = 1;
        }
        return $price;
    }

    public function getBuyPrice($subCategoryId)
    {
        global $con;
        $sql = "SELECT * FROM profit WHERE profit.subCategoryId = $subCategoryId";
        $result = mysqli_query($con,$sql);
        $price;
        while ($res = mysqli_fetch_assoc($result))
        {
            $price = $res['buy'];
        }
        if($price==null)
        {
            $price = 1;
        }
        return $price;
    }
}
?>