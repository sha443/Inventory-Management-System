<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.sales.php');
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$seId = "";
$salesId = "";
$categoryId = "";
$subCategoryId = "";
$explanation = "";
$pcs= "";
$unitPrice = "";
$date = "";
$bllSales = new BLLSales;
class BLLSales
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalSales = new DALSales;
		if(isset($_POST['insert_sales']))
		{

			// SE = Sales Executive
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			$unitPrice = $utility->getSalePrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;
			//echo $subCategoryId.$explanation.$pcs.$unitPrice.$SE;

			$result = $dalSales->insertSales($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Sales added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset sales !";
				//header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_sales']))
		{

			// SE = Sales Executive
			$id = $utility->secureInput($_POST['salesId']);
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			$unitPrice = $utility->getSalePrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;
			//echo $subCategoryId.$explanation.$pcs.$unitPrice.$SE;

			$result = $dalSales->updateSales($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Sales updated Successfully!";
				header('Location:../sales.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Sales!";
				//header('Location:../sales.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{

		
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalSales->deleteSales($id);
			if($result)
			{
				$_SESSION['message'] = "Sales deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Sales!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getSalesById($id);
		}
	}
	public function showSales($dateFrom,$dateTo)
	{
		$subTotalSales = 0;
		$data = "";
		$dalProductCategory = new DALProductCategory;
		$resultProdCat = $dalProductCategory->showCategory();
		while ($resProdCat = mysqli_fetch_assoc($resultProdCat))
		{
			// Data display 
			$data.='<div class="col-md-12">';
            $data.='<div class="card">';
			// Title of the menu table
			$data.='<div class="header">';
            $data.='<h4 class="title">'.$resProdCat['name'].'</h4>';
            $data.='</div>';

			// Table for each expense category
			$data.='<div class="table-responsive table-bordered">';
            $data.='<table class="table" id="'.$resProdCat['name'].'"">';
            
            // For each category find expenses

            $dalSales  = new DALSales;
            $resultSales = $dalSales->getSalesByCategoryId($resProdCat['id'],$dateFrom,$dateTo);

            $SL = 1;
            $total = 0;
            $data.= '<thead><th>SL</th><th>SE Name</th><th>Details</th><th>Sub Category</th><th>Amount</th><th>Unit Price</th><th>Net Amount</th><th>Edit</th><th>Delete</th></thead>';
            $data.= '<tbody>';
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
            	$data .= '<tr>';
            	$data .= '<td>'.$SL++.'</td>';
            	$data .= '<td>'.$resSales['seName'].'</td>';
            	$data .= '<td>'.$resSales['explanation'].'</td>';
            	$data .= '<td>'.$resSales['subCategory'].'</td>';
            	$data .= '<td>'.$resSales['pcs'].'</td>';
            	$data .= '<td>'.$resSales['unitPrice'].'</td>';
            	$data .= '<td>'.$resSales['netAmount'].'</td>';
            	$data .='<td><a href="sales.php?edit='.$resSales['id'].'">Edit</a></td>';
				$data .='<td><a href="sales.php?delete='.$resSales['id'].'">Delete</a></td>';
            	$data .= '</tr>';

            	$total += $resSales['netAmount'];
            }
            $data.= '</tbody>';

            $data.= '<tfoot>';
            $data.= '<tr>';
            $data.= '<td></td><td></td><td></td><td></td><td></td><td>Total = </td><td>'.$total.'</td><td></td><td></td>';
            $data.= '<tr>';
            $data.= '</tfoot>';


            // table for each expense category end
            $data.='</table>';
            $data.='</div>';

            // Data display End
            $data.='</div>';
            $data.='</div>';

            $subTotalSales += $total;



		}

		// grand total calculation
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		$data.='<div class="alert alert-info">';
        $data.='<span class="h3">Grand Total Sales:'.$subTotalSales.' BDT</span>';
        $data.='</div>';
        $data.='</div>';
        $data.='</div>';
        

		return $data;

	}
	public function showSESales($seId,$dateFrom,$dateTo)
	{
		
        $dalSales  = new DALSales;
        $resultSales = $dalSales->getSalesBySEId($seId,$dateFrom,$dateTo);

        $SL = 1;
        $data = "";
        $total = 0;
        // Data display 
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		// Title of the menu table
		$data.='<div class="header">';
        $data.='<h4 class="title"> Product Sales</h4>';
        $data.='</div>';

		// Table for each expense category
		$data.='<div class="table-responsive table-bordered">';
        $data.='<table class="table">';
        $data.= '<thead><th>SL</th><th>Details</th><th>Product</th><th>Amount</th><th>Unit Price</th><th>Net Amount</th><th>Edit</th><th>Delete</th></thead>';
        $data.= '<tbody>';
        while ($resSales = mysqli_fetch_assoc($resultSales))
        {
        	$data .= '<tr>';
        	$data .= '<td>'.$SL++.'</td>';
        	$data .= '<td>'.$resSales['explanation'].'</td>';
        	$data .= '<td>'.$resSales['subCategory'].'</td>';
        	$data .= '<td>'.$resSales['pcs'].'</td>';
        	$data .= '<td>'.$resSales['unitPrice'].'</td>';
        	$data .= '<td>'.$resSales['netAmount'].'</td>';
        	$data .='<td><a href="sales.php?edit='.$resSales['id'].'">Edit</a></td>';
			$data .='<td><a href="sales.php?delete='.$resSales['id'].'">Delete</a></td>';
        	$data .= '</tr>';

        	$total += $resSales['netAmount'];
        }
        $data.= '</tbody>';

        $data.= '<tfoot>';
        $data.= '<tr>';
        $data.= '<td></td><td></td><td></td><td></td><td>Total = </td><td>'.$total.'</td><td></td><td></td>';
        $data.= '<tr>';
        $data.= '</tfoot>';


        // table for each expense category end
        $data.='</table>';
        $data.='</div>';

        // Data display End
        $data.='</div>';
        $data.='</div>';

		return $data;

	}

	public function getSalesById($id)
	{
		$dalSales = new DALSales;
		$result = $dalSales->getSalesById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['salesId'] =$res['id'];
			$GLOBALS['seId'] =$res['seId'];
			$GLOBALS['categoryId'] =$res['categoryId'];
			$GLOBALS['subCategoryId'] =$res['subCategoryId'];
			$GLOBALS['explanation'] =$res['explanation'];
			$GLOBALS['pcs'] =$res['pcs'];
			$GLOBALS['unitPrice'] =$res['unitPrice'];
			$GLOBALS['date'] =$res['date'];
		}
	}

}
?>