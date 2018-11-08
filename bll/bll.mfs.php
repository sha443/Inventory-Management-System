<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.mfs.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$seId = "";
$mfsId = "";
$categoryId = "";
$subCategoryId = "";
$explanation = "";
$pcs= "";
$unitPrice = "";
$date = "";
$bllMFS = new BLLMFS;
class BLLMFS
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalMFS = new DALMFS;
		if(isset($_POST['insert_mfs']))
		{

			// SE = MFS Executive
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);

			$unitPrice = $utility->getSalePrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;

			//echo $subCategoryId.$explanation.$pcs.$unitPrice.$SE;

			$result = $dalMFS->insertMFS($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Product on Hand added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset Product on Hand !";
				//header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_mfs']))
		{

			// SE = MFS Executive
			$id = $utility->secureInput($_POST['mfsId']);
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			$unitPrice = $utility->getSalePrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;

			$result = $dalMFS->updateMFS($id,$subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Product on Hand updated Successfully!";
				header('Location:../mfs.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Product on Hand!";
				//header('Location:../mfs.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{

		
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalMFS->deleteMFS($id);
			if($result)
			{
				$_SESSION['message'] = "Product on Hand deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Product on Hand!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getMFSById($id);
		}
	}
	public function showMFS($dateFrom,$dateTo)
	{
		$subTotalMFS = 0;
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

            $dalMFS  = new DALMFS;
            $resultMFS = $dalMFS->getMFSByCategoryId($resProdCat['id'],$dateFrom,$dateTo);

            $SL = 1;
            $total = 0;
            $data.= '<thead><th>SL</th><th>SE Name</th><th>Details</th><th>SubCategory</th><th>Amount</th><th>Unit Price</th><th>Net Amount</th><th>Edit</th><th>Delete</th></thead>';
            $data.= '<tbody>';
            while ($resMFS = mysqli_fetch_assoc($resultMFS))
            {
            	$data .= '<tr>';
            	$data .= '<td>'.$SL++.'</td>';
            	$data .= '<td>'.$resMFS['seName'].'</td>';
            	$data .= '<td>'.$resMFS['explanation'].'</td>';
            	$data .= '<td>'.$resMFS['subCategory'].'</td>';
            	$data .= '<td>'.$resMFS['pcs'].'</td>';
            	$data .= '<td>'.$resMFS['unitPrice'].'</td>';
            	$data .= '<td>'.$resMFS['netAmount'].'</td>';
            	$data .='<td><a href="mfs.php?edit='.$resMFS['id'].'">Edit</a></td>';
				$data .='<td><a href="mfs.php?delete='.$resMFS['id'].'">Delete</a></td>';
            	$data .= '</tr>';

            	$total += $resMFS['netAmount'];
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

            $subTotalMFS += $total;



		}

		// grand total calculation
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		$data.='<div class="alert alert-info">';
        $data.='<span class="h3">Total Product on Hand : '.$subTotalMFS.' BDT</span>';
        $data.='</div>';
        $data.='</div>';
        $data.='</div>';
        

		return $data;

	}
	public function showSEMFS($seId,$dateFrom,$dateTo)
	{
		
        $dalMFS  = new DALMFS;
        $resultMFS = $dalMFS->getMFSBySEId($seId,$dateFrom,$dateTo);

        $SL = 1;
        $data = "";
        $total = 0;
        // Data display 
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		// Title of the menu table
		$data.='<div class="header">';
        $data.='<h4 class="title"> Product On Hand</h4>';
        $data.='</div>';

		// Table for each expense category
		$data.='<div class="table-responsive table-bordered">';
        $data.='<table class="table">';
        $data.= '<thead><th>SL</th><th>Details</th><th>Product</th><th>Amount</th><th>Unit Price</th><th>Net Amount</th><th>Edit</th><th>Delete</th></thead>';
        $data.= '<tbody>';
        while ($resMFS = mysqli_fetch_assoc($resultMFS))
        {
        	$data .= '<tr>';
        	$data .= '<td>'.$SL++.'</td>';
        	$data .= '<td>'.$resMFS['explanation'].'</td>';
        	$data .= '<td>'.$resMFS['subCategory'].'</td>';
        	$data .= '<td>'.$resMFS['pcs'].'</td>';
        	$data .= '<td>'.$resMFS['unitPrice'].'</td>';
        	$data .= '<td>'.$resMFS['netAmount'].'</td>';
        	$data .='<td><a href="mfs.php?edit='.$resMFS['id'].'">Edit</a></td>';
			$data .='<td><a href="mfs.php?delete='.$resMFS['id'].'">Delete</a></td>';
        	$data .= '</tr>';

        	$total += $resMFS['netAmount'];
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

	public function getMFSById($id)
	{
		$dalMFS = new DALMFS;
		$result = $dalMFS->getMFSById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['mfsId'] =$res['id'];
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