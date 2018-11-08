<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.expenses.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.expensecategory.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$id = "";
$categoryId = "";
$explanation = "";
$amount = "";
$seId = "";
$date = "";
$bllExpense = new BLLExpense;
class BLLExpense
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalExpense = new DALExpense;
		if(isset($_POST['insert_expense']))
		{
			$categoryId = $utility->secureInput($_POST['categoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$amount = $utility->secureInput($_POST['amount']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			//echo $categoryId.$explanation.$amount.$SE;

			$result = $dalExpense->insertExpense($categoryId,$explanation,$amount,$SE,$date);
			if($result)
			{
				$_SESSION['message'] = "Expense added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset expense !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_expense']))
		{

			$id = $utility->secureInput($_POST['id']);
			$categoryId = $utility->secureInput($_POST['categoryId']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$amount = $utility->secureInput($_POST['amount']);
			$SE = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			//echo $categoryId.$explanation.$amount.$SE;

			$result = $dalExpense->updateExpense($id,$categoryId,$explanation,$amount,$SE,$date);

			if($result)
			{
				$_SESSION['message'] = "Expense updated Successfully!";
				header('Location:../expenses.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Expense!";
				//header('Location:../expenses.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalExpense->deleteExpense($id);
			if($result)
			{
				$_SESSION['message'] = "Expense deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Expense!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getExpenseById($id);
		}
	}
	public function showExpense($dateFrom,$dateTo)
	{
		$subTotalCost = 0;
		$data = "";
		$dalExpenseCategory = new DALExpenseCategory;
		$resultExpCat = $dalExpenseCategory->showCategory();
		while ($resExpCat = mysqli_fetch_assoc($resultExpCat))
		{
			// Data display 
			$data.='<div class="col-md-12">';
            $data.='<div class="card">';
			// Title of the menu table
			$data.='<div class="header">';
            $data.='<h4 class="title">'.$resExpCat['name'].'</h4>';
            $data.='</div>';

			// Table for each expense category
			$data.='<div class="table-responsive table-bordered">';
            $data.='<table class="table" id="'.$resExpCat['name'].'"">';
            
            // For each category find expenses

            $dalExpense  = new DALExpense;
            $resultExpense = $dalExpense->getExpenseByCategoryId($resExpCat['id'],$dateFrom,$dateTo);

            $SL = 1;
            $total = 0;
            $data.= '<thead><th>SL</th><th>SE Name</th><th>Details</th><th>Tk.</th><th>Edit</th><th>Delete</th></thead>';
            $data.= '<tbody>';
            while ($resExp = mysqli_fetch_assoc($resultExpense))
            {
            	$data .= '<tr>';
            	$data .= '<td>'.$SL++.'</td>';
            	$data .= '<td>'.$resExp['seName'].'</td>';
            	$data .= '<td>'.$resExp['explanation'].'</td>';
            	$data .= '<td>'.$resExp['amount'].'</td>';
            	$data .='<td><a href="expenses.php?edit='.$resExp['id'].'">Edit</a></td>';
				$data .='<td><a href="expenses.php?delete='.$resExp['id'].'">Delete</a></td>';
            	$data .= '</tr>';

            	$total += $resExp['amount'];
            }
            $data.= '</tbody>';

            $data.= '<tfoot>';
            $data.= '<tr>';
            $data.= '<td></td><td></td><td>Total = </td><td>'.$total.'</td><td></td><td></td>';
            $data.= '<tr>';
            $data.= '</tfoot>';


            // table for each expense category end
            $data.='</table>';
            $data.='</div>';

            // Data display End
            $data.='</div>';
            $data.='</div>';

            $subTotalCost += $total;



		}

		// grand total calculation
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		$data.='<div class="alert alert-info">';
        $data.='<span class="h3">Grand Total Cost:'.$subTotalCost.' BDT</span>';
        $data.='</div>';
        $data.='</div>';
        $data.='</div>';
        

		return $data;


	}
	public function getExpenseById($id)
	{
		$dalExpense = new DALExpense;
		$result = $dalExpense->getExpenseById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
			$GLOBALS['categoryId'] =$res['expenseCategoryId'];
			$GLOBALS['explanation'] =$res['explanation'];
			$GLOBALS['amount'] =$res['amount'];
			$GLOBALS['seId'] =$res['seId'];
			$GLOBALS['date'] =$res['date'];
		}
	}

}
?>