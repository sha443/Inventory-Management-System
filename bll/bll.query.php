<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.query.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.productcategory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.user.php');

$bllQuery = new BLLQuery;
class BLLQuery
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalQuery = new DALQuery;
	}
	public function showQuery($dateFrom,$dateTo,$seId)
	{
        $dalQuery  = new DALQuery;
        $resultSales = $dalQuery->getSales($dateFrom,$dateTo,$seId);
        $totalSales = 0;
        while ($resSales = mysqli_fetch_assoc($resultSales))
        {
            $totalSales += intval($resSales['netAmount']);
        }

        $resultMFS = $dalQuery->getMFS($dateFrom,$dateTo,$seId);
        $totalMFS = 0;
        while ($resMFS= mysqli_fetch_assoc($resultMFS))
        {
            $totalMFS += intval($resMFS['netAmount']);
        }

        $resultReturns = $dalQuery->getReturns($dateFrom,$dateTo,$seId);
        $totalReturns = 0;
        while ($resReturns= mysqli_fetch_assoc($resultReturns))
        {
            $totalReturns += intval($resReturns['netAmount']);
        }

        $resultSECost= $dalQuery->getSECost($dateFrom,$dateTo,$seId);
        $totalSECost=0;
        while ($resSECost= mysqli_fetch_assoc($resultSECost))
        {
            $totalSECost+= intval($resSECost['amount']);
        }
        $resultSEBank= $dalQuery->getSEBank($dateFrom,$dateTo,$seId);
        $totalSEBank=0;
        while ($resSEBank= mysqli_fetch_assoc($resultSEBank))
        {
            $totalSEBank+= intval($resSEBank['netAmount']);
        }

        // Null Removal
        if($totalSales==null)
        {
            $totalSales = 0;
        }
        if($totalMFS==null)
        {
            $totalMFS = 0;
        }
        if($totalReturns==null)
        {
            $totalReturns = 0;
        }
        if($totalSECost==null)
        {
            $totalSECost = 0;
        }
        if($totalSEBank==null)
        {
            $totalSEBank = 0;
        }
        // if($totalMobiCashReturns==null)
        // {
        //     $totalMobiCashReturns = 0;
        // }
        

        // Format 
        $data = "";
        $data .= "<table class='table table-hover table-striped'>";

        $data.= "<tr><td> Product Taken: </td><td>".$totalMFS."</td></tr>";
        $data.= "<tr><td> Sales: </td><td>".$totalSales."</td></tr>";
        $data.= "<tr><td> Product Return: </td><td>".$totalReturns."</td></tr>";
        $data.= "<tr><td> Cotal Cost: </td><td>".$totalSECost."</td></tr>";
        $data.= "<tr><td> Bank Deposite: </td><td>".$totalSEBank."</td></tr>";
        $data.= "<tr><td> Product Due: </td><td>".($totalMFS-$totalSales-$totalReturns)."</td></tr>";
        $data.= "<tr><td> Return Money: </td><td>".($totalSales-$totalSECost-$totalSEBank)."</td></tr>";
        $data.= "</table>";

		return $data;
	}
    public function showAllQuery($dummy)
    {
        $dalUser = new DALUser;
        $result =  $dalUser->showSE();
        $data = "";

        while ($res = mysqli_fetch_assoc($result))
        {
            $data .= '<h3><b>'.$res['name'].'</h3></b>';
            $data .= $this->showQuery($dummy,$dummy,$res['id']);
        }
        return $data;
    }
    public function showDueProducts($dateFrom,$dateTo,$seId)
    {
        $dalProductCategory  = new DALProductCategory;       
        $resultSubCategory = $dalProductCategory->showSubCategory();

        $dataSE = "<table class='table table-hover table-striped'>";
        $dataSE.= "<thead><th> Product </th><th> PCS </th></thead>";

        while ($resSubCategory = mysqli_fetch_assoc($resultSubCategory))
        {
            $subCategoryId = $resSubCategory['id'];

            $dalQuery  = new DALQuery;

            $resultMFS = $dalQuery->getMFSBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId);
            $totalMFS = 0;
            while ($resMFS= mysqli_fetch_assoc($resultMFS))
            {
                $totalMFS += $resMFS['pcs'];
            }

            $resultSales = $dalQuery->getSalesBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId);
            $totalSales = 0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
                $totalSales += $resSales['pcs'];
            }

            $resultReturns = $dalQuery->getReturnsBySubCatSE($dateFrom,$dateTo,$subCategoryId,$seId);
            $totalReturns = 0;
            while ($resReturns= mysqli_fetch_assoc($resultReturns))
            {
                $totalReturns += $resReturns['pcs'];
            }

            $due = $totalMFS - $totalSales - $totalReturns;

            if($due!=0)
            {
                $dataSE.= "<tr><td> ".$resSubCategory['subCategoryName'].": </td><td>".$due."</td></tr>";

            }

        }
        $dataSE .= "</table>";

        return $dataSE;
    }

}
?>