<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.incentive.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$id = "";
$explanation = "";
$netAmount = "";
$date = "";
$bllIncentive = new BLLIncentive;
class BLLIncentive
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalIncentive = new DALIncentive;
		if(isset($_POST['insert_incentive']))
		{
			$explanation = $utility->secureInput($_POST['explanation']);
			$netAmount = $utility->secureInput($_POST['netAmount']);
			$date = $utility->secureInput($_POST['date']);
			$result = $dalIncentive->insertIncentive($explanation,$netAmount,$date);
			if($result)
			{
				$_SESSION['message'] = "Incentive added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset incentive !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_incentive']))
		{

			$id = $utility->secureInput($_POST['id']);
			$explanation = $utility->secureInput($_POST['explanation']);
			$netAmount = $utility->secureInput($_POST['netAmount']);
			$date = $utility->secureInput($_POST['date']);

			$result = $dalIncentive->updateIncentive($id,$explanation,$netAmount,$date);

			if($result)
			{
				$_SESSION['message'] = "Incentive updated Successfully!";
				header('Location:../incentive.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Incentive!";
				header('Location:../incentive.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalIncentive->deleteIncentive($id);
			if($result)
			{
				$_SESSION['message'] = "Incentive deleted Successfully!";

			}
			else
			{
				$_SESSION['message'] = "Can't delete Incentive!";
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getIncentiveById($id);
		}
	}
	public function showIncentive($dateFrom,$dateTo)
	{
		
        $dalIncentive  = new DALIncentive;
        $resultIncentive = $dalIncentive->getIncentive($dateFrom,$dateTo);
        $SL = 1;
        $total = 0;
        $data = "";

        while ($res = mysqli_fetch_assoc($resultIncentive))
        {
        	$data .= '<tr>';
        	$data .= '<td>'.$SL++.'</td>';
        	$data .= '<td>'.$res['explanation'].'</td>';
        	$data .= '<td>'.$res['netAmount'].'</td>';
        	$data .= '<td>'.$res['date'].'</td>';
        	$data .='<td><a href="incentive.php?edit='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="incentive.php?delete='.$res['id'].'">Delete</a></td>';
        	$data .= '</tr>';
        }

		return $data;


	}
	public function getIncentiveById($id)
	{
		$dalIncentive = new DALIncentive;
		$result = $dalIncentive->getIncentiveById($id);
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
			$GLOBALS['explanation'] =$res['explanation'];
			$GLOBALS['netAmount'] =$res['netAmount'];
			$GLOBALS['date'] =$res['date'];
		}
	}

}
?>