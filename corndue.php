<?php
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# CORN JOB
# Call once per day at 12:01 AM
# 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    $host = "localhost";
    $user = "";
    $password = "";
    $db = "";
    $con = mysqli_connect($host,$user,$password,$db) or die ("Couldn't connnect".mysql_error());

class CornDue
{
        
    function __construct()
    {
       // Calculate each day inventory and save into database.
        $time = time();
        $today = date('Y-m-d',$time);
        $y = strtotime("-1 day", $time);
        $yesterday = date('Y-m-d',$y);

        // Retriving all SE
        
        $resultSE = $this->showSE();
        while ($resSE = mysqli_fetch_assoc($resultSE))
        {
            $seId = $resSE['id'];
            // Cron the job of yesterday due, since its 12:01 AM
            $this->cronDueProducts($yesterday,$yesterday,$seId);
        }
    }

    // Main Function [cloned from bll.query.php]

    public function cronDueProducts($dateFrom,$dateTo,$seId)
    {
        $resultSubCategory = $this->getSubCategories();

        while ($resSubCategory = mysqli_fetch_assoc($resultSubCategory))
        {
            $subCategoryId = $resSubCategory['id'];

            $resultMFS = $this->getMFSBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId);
            $totalMFS = 0;
            while ($resMFS= mysqli_fetch_assoc($resultMFS))
            {
                $totalMFS += $resMFS['pcs'];
            }

            $resultSales = $this->getSalesBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId);
            $totalSales = 0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
                $totalSales += $resSales['pcs'];
            }

            $resultReturns = $this->getReturnsBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId);
            $totalReturns = 0;
            while ($resReturns= mysqli_fetch_assoc($resultReturns))
            {
                $totalReturns += $resReturns['pcs'];
            }

            $due = $totalMFS - $totalSales - $totalReturns;
            

            $unitPrice = $this->getSalePrice($subCategoryId);
            $netAmount = $unitPrice*$due;


            $time = time();
            $today = date('Y-m-d',$time);
            if($due!=0)
            {
                $res = $this->insertMFS($subCategoryId,"Due Product",$due,$unitPrice,$netAmount,$seId,$today);
            }

        }

    }

// Independent functions
     // Sub category id
    public function getSubCategories()
    {
        global $con;
        $sql = "SELECT * FROM subcategory";
        $result = mysqli_query($con,$sql);
        return $result;
    }

    public function getMFSBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId)
    {
        global $con;
        $sql = "SELECT * FROM mfs WHERE mfs.subCategoryId = $subCategoryId && mfs.seId = $seId && mfs.date BETWEEN '$dateFrom' AND '$dateTo'";
        $result = mysqli_query($con,$sql);
        return $result;
    }

    public function getReturnsBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId)
    {
        global $con;
        $sql = "SELECT * FROM returns WHERE returns.subCategoryId = $subCategoryId && returns.seId = $seId && returns.date BETWEEN '$dateFrom' AND '$dateTo'";
        $result = mysqli_query($con,$sql);
        return $result;
    }

    public function getSalesBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId)
    {
        global $con;
        $sql = "SELECT * FROM `sales` WHERE sales.subCategoryId = $subCategoryId && sales.seId = $seId && sales.date BETWEEN '$dateFrom' AND '$dateTo'";
        $result = mysqli_query($con,$sql);
        return $result;
    }

    public function insertMFS($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$seId,$date)
    {
        global $con;
        $sql = "INSERT INTO `mfs`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `seId`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,$seId,'$date')";
        $result = mysqli_query($con,$sql);
        return $result;

    }
    public function showSE()
    {
        global $con;
        $sql = "SELECT * FROM `salesexecutive` WHERE 1 ORDER BY salesexecutive.id";
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
}
    
// Fireing
$cornDue = new CornDue;   
    
?>