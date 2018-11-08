<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.bankdeposite.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$id = "";
$tokenNo = "";
$bankName = "";
$netAmount = "";
$seId = "";
$date = "";
$bllBankDeposite = new BLLBankDeposite;
class BLLBankDeposite
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalBankDeposite = new DALBankDeposite;
		if(isset($_POST['insert_bankdeposite']))
		{
			$tokenNo = $utility->secureInput($_POST['tokenNo']);
			$bankName = $utility->secureInput($_POST['bankName']);
			$netAmount = $utility->secureInput($_POST['netAmount']);
			$seId = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['date']);
			
			//echo $tokenNo.$bankName.$netAmount.$seId;

			$result = $dalBankDeposite->insertBankDeposite($tokenNo,$bankName,$netAmount,$seId,$date);
			if($result)
			{
				$_SESSION['message'] = "Bank Deposite added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset bank deposite !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_bankdeposite']))
		{

			$id = $utility->secureInput($_POST['id']);
			$tokenNo = $utility->secureInput($_POST['tokenNo']);
			$bankName = $utility->secureInput($_POST['bankName']);
			$netAmount = $utility->secureInput($_POST['netAmount']);
			$seId = $utility->secureInput($_POST['SE']);
			$date = $utility->secureInput($_POST['date']);
			
			//echo $tokenNo.$bankName.$netAmount.$seId;

			$result = $dalBankDeposite->updateBankDeposite($id,$tokenNo,$bankName,$netAmount,$seId,$date);

			if($result)
			{
				$_SESSION['message'] = "Bank Deposite updated Successfully!";
				header('Location:../bankdeposite.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update BankDeposite!";
				header('Location:../bankdeposite.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalBankDeposite->deleteBankDeposite($id);
			if($result)
			{
				$_SESSION['message'] = "Bank Deposite deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Bank Deposite!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getBankDepositeById($id);
		}
	}
	public function showBankDeposite($dateFrom,$dateTo)
	{
		
        $dalBankDeposite  = new DALBankDeposite;
        $resultBankDeposite = $dalBankDeposite->getBankDeposite($dateFrom,$dateTo);
        $SL = 1;
        $total = 0;
        $data = "";

        while ($resExp = mysqli_fetch_assoc($resultBankDeposite))
        {
        	$data .= '<tr>';
        	$data .= '<td>'.$SL++.'</td>';
        	$data .= '<td>'.$resExp['seName'].'</td>';
        	$data .= '<td>'.$resExp['tokenNo'].'</td>';
        	$data .= '<td>'.$resExp['bankName'].'</td>';
        	$data .= '<td>'.$resExp['netAmount'].'</td>';
        	$data .='<td><a href="bankdeposite.php?edit='.$resExp['id'].'">Edit</a></td>';
			$data .='<td><a href="bankdeposite.php?delete='.$resExp['id'].'">Delete</a></td>';
        	$data .= '</tr>';

        	$total += $resExp['netAmount'];
        }

		return $data;


	}
	public function getBankDepositeById($id)
	{
		$dalBankDeposite = new DALBankDeposite;
		$result = $dalBankDeposite->getBankDepositeById($id);
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
			$GLOBALS['tokenNo'] =$res['tokenNo'];
			$GLOBALS['bankName'] =$res['bankName'];
			$GLOBALS['netAmount'] =$res['netAmount'];
			$GLOBALS['seId'] =$res['seId'];
			$GLOBALS['date'] =$res['date'];
		}
	}

}
?>