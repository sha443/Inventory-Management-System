<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/kmh/kmh/dal/dal.inventory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/kmh/kmh/includes/utility.php');

$id = "";
$categoryId = "";
$subCategoryId = "";
$explanation = "";
$pcs = "";
$unitPrice = "";
$date = "";
$bllInventory = new BLLInventory;
class BLLInventory
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalInventory = new DALInventory;
		if(isset($_POST['insert_inventory']))
		{
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$date = $utility->secureInput($_POST['dateOfSale']);

			$unitPrice = $utility->getBuyPrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;

			//echo $subCategoryId.$explanation.$pcs.$unitPrice;

			$result = $dalInventory->insertInventory($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date);
			if($result)
			{
				$_SESSION['message'] = "Inventory added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset inventory !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_inventory']))
		{

			$id = $utility->secureInput($_POST['id']);
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			$unitPrice = $utility->getBuyPrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;
			
			$result = $dalInventory->updateInventory($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date);

			if($result)
			{
				$_SESSION['message'] = "Inventory updated Successfully!";
				header('Location:../inventory.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Inventory!";
				header('Location:../inventory.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalInventory->deleteInventory($id);
			if($result)
			{
				$_SESSION['message'] = "Inventory deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Inventory!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getInventoryById($id);
		}
	}
	public function showInventory($dateFrom,$dateTo)
	{
		$totalInventory = 0;
		$data = "";
		$dalProductCategory = new DALProductCategory;
		$resultExpSubCat = $dalProductCategory->showSubCategory();
		while ($resInvSubCat = mysqli_fetch_assoc($resultExpSubCat))
		{
			// Data display 
			$data.='<div class="col-md-12">';
            $data.='<div class="card">';
			// Title of the menu table
			$data.='<div class="header">';
            $data.='<h4 class="title">'.$resInvSubCat['subCategoryName'].'</h4>';
            $data.='</div>';

			// Table for each inventory category
			$data.='<div class="table-responsive table-bordered">';
            $data.='<table class="table" id="'.$resInvSubCat['subCategoryName'].'"">';
            
            // For each category find inventory

            $dalInventory  = new DALInventory;
            $resultInventory = $dalInventory->getInventoryBySubCategoryId($resInvSubCat['id'],$dateFrom,$dateTo);

            $SL = 1;
            $totalPV = 0;
            $data.= '<thead><th>SL</th><th>Details</th><th>Amount(pcs.)</th><th>Unit Price</th><th>Product Value</th><th>Edit</th><th>Delete</th></thead>';
            $data.= '<tbody>';
            while ($resInv = mysqli_fetch_assoc($resultInventory))
            {
            	$data .= '<tr>';
            	$data .= '<td>'.$SL++.'</td>';
            	$data .= '<td>'.$resInv['explanation'].'</td>';
            	$data .= '<td>'.$resInv['pcs'].'</td>';
            	$data .= '<td>'.$resInv['unitPrice'].'</td>';
            	$data .= '<td>'.$resInv['netAmount'].'</td>';

            	$data .='<td><a href="inventory.php?edit='.$resInv['id'].'">Edit</a></td>';
				$data .='<td><a href="inventory.php?delete='.$resInv['id'].'">Delete</a></td>';
            	$data .= '</tr>';

            	$totalPV += $resInv['netAmount'];
            }
            $data.= '</tbody>';

            $data.= '<tfoot>';
            $data.= '<tr>';
            $data.= '<td>Total = </td><td></td><td></td><td></td><td>'.$totalPV.'</td><td></td><td></td>';
            $data.= '<tr>';
            $data.= '</tfoot>';


            // table for each inventory category end
            $data.='</table>';
            $data.='</div>';

            // Data display End
            $data.='</div>';
            $data.='</div>';

            $totalInventory += $totalPV;

		}

		// grand total calculation
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		$data.='<div class="alert alert-info">';
        $data.='<span class="h3">Total Inventory : '.floor($totalInventory).' BDT</span>';
        $data.='</div>';
        $data.='</div>';
        $data.='</div>';
        

		return $data;


	}
	public function getInventoryById($id)
	{
		$dalInventory = new DALInventory;
		$result = $dalInventory->getInventoryById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
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