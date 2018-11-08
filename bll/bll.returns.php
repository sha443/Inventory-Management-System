<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.returns.php');
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$seId = "";
$returnsId = "";
$categoryId = "";
$subCategoryId = "";
$explanation = "";
$pcs= "";
$unitPrice = "";
$date = "";
$bllReturns = new BLLReturns;
class BLLReturns
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalReturns = new DALReturns;
		if(isset($_POST['insert_returns']))
		{

			// SE = Returns Executive
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);

			$unitPrice = $utility->getSalePrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;

			//echo $subCategoryId.$explanation.$pcs.$unitPrice.$SE;

			$result = $dalReturns->insertReturns($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Returned Products added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset Returned Products !";
				//header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_returns']))
		{

			// SE = Returns Executive
			$id = $utility->secureInput($_POST['returnsId']);
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			$unitPrice = $utility->getSalePrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;

			$result = $dalReturns->updateReturns($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Returned Products updated Successfully!";
				header('Location:../returns.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Returned Products!";
				//header('Location:../returns.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{

		
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalReturns->deleteReturns($id);
			if($result)
			{
				$_SESSION['message'] = "Returned Products deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Returned Products!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getReturnsById($id);
		}
	}
	public function showReturns($dateFrom,$dateTo)
	{
		$subTotalReturns = 0;
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

            $dalReturns  = new DALReturns;
            $resultReturns = $dalReturns->getReturnsByCategoryId($resProdCat['id'],$dateFrom,$dateTo);

            $SL = 1;
            $total = 0;
            $data.= '<thead><th>SL</th><th>SE Name</th><th>Details</th><th>SubCategory</th><th>Amount</th><th>Unit Price</th><th>Net Amount</th><th>Edit</th><th>Delete</th></thead>';
            $data.= '<tbody>';
            while ($resReturns = mysqli_fetch_assoc($resultReturns))
            {
            	$data .= '<tr>';
            	$data .= '<td>'.$SL++.'</td>';
            	$data .= '<td>'.$resReturns['seName'].'</td>';
            	$data .= '<td>'.$resReturns['explanation'].'</td>';
            	$data .= '<td>'.$resReturns['subCategory'].'</td>';
            	$data .= '<td>'.$resReturns['pcs'].'</td>';
            	$data .= '<td>'.$resReturns['unitPrice'].'</td>';
            	$data .= '<td>'.$resReturns['netAmount'].'</td>';
            	$data .='<td><a href="returns.php?edit='.$resReturns['id'].'">Edit</a></td>';
				$data .='<td><a href="returns.php?delete='.$resReturns['id'].'">Delete</a></td>';
            	$data .= '</tr>';

            	$total += $resReturns['netAmount'];
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

            $subTotalReturns += $total;



		}

		// grand total calculation
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		$data.='<div class="alert alert-info">';
        $data.='<span class="h3">Total Returned Products : '.$subTotalReturns.' BDT</span>';
        $data.='</div>';
        $data.='</div>';
        $data.='</div>';
        

		return $data;

	}
	public function showSEReturns($seId,$dateFrom,$dateTo)
	{
		
        $dalReturns  = new DALReturns;
        $resultReturns = $dalReturns->getReturnsBySEId($seId,$dateFrom,$dateTo);

        $SL = 1;
        $data = "";
        $total = 0;
        // Data display 
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		// Title of the menu table
		$data.='<div class="header">';
        $data.='<h4 class="title"> Returned Products</h4>';
        $data.='</div>';

		// Table for each expense category
		$data.='<div class="table-responsive table-bordered">';
        $data.='<table class="table">';
        $data.= '<thead><th>SL</th><th>Details</th><th>Product</th><th>Amount</th><th>Unit Price</th><th>Net Amount</th><th>Edit</th><th>Delete</th></thead>';
        $data.= '<tbody>';
        while ($resReturns = mysqli_fetch_assoc($resultReturns))
        {
        	$data .= '<tr>';
        	$data .= '<td>'.$SL++.'</td>';
        	$data .= '<td>'.$resReturns['explanation'].'</td>';
        	$data .= '<td>'.$resReturns['subCategory'].'</td>';
        	$data .= '<td>'.$resReturns['pcs'].'</td>';
        	$data .= '<td>'.$resReturns['unitPrice'].'</td>';
        	$data .= '<td>'.$resReturns['netAmount'].'</td>';
        	$data .='<td><a href="returns.php?edit='.$resReturns['id'].'">Edit</a></td>';
			$data .='<td><a href="returns.php?delete='.$resReturns['id'].'">Delete</a></td>';
        	$data .= '</tr>';

        	$total += $resReturns['netAmount'];
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

	public function getReturnsById($id)
	{
		$dalReturns = new DALReturns;
		$result = $dalReturns->getReturnsById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['returnsId'] =$res['id'];
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