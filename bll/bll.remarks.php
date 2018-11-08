<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.remarks.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$id = "";
$userId = "";
$text = "";
// Date uneditable 
$date = "";
$bllRemarks = new BLLRemarks;
class BLLRemarks
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalRemarks = new DALRemarks;
		if(isset($_POST['insert_remarks']))
		{
			$userId = $utility->secureInput($_POST['userId']);
			$text = $utility->secureInput($_POST['text']);
			$date = $utility->getDate();
			$result = $dalRemarks->insertRemarks($userId,$text,$date);
			if($result)
			{
				$_SESSION['message'] = "Remarks added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset remarks !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_remarks']))
		{

			$id = $utility->secureInput($_POST['id']);
			$userId = $utility->secureInput($_POST['userId']);
			$text = $utility->secureInput($_POST['text']);
			// Date uneditable 
			$result = $dalRemarks->updateRemarks($id,$userId,$text);

			if($result)
			{
				$_SESSION['message'] = "Remarks updated Successfully!";
				header('Location:../remarks.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Remarks!";
				header('Location:../remarks.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalRemarks->deleteRemarks($id);
			if($result)
			{
				$_SESSION['message'] = "Remarks deleted Successfully!";

			}
			else
			{
				$_SESSION['message'] = "Can't delete Remarks!";
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getRemarksById($id);
		}
	}
	public function showRemarks($dateFrom,$dateTo)
	{
		
        $dalRemarks  = new DALRemarks;
        $resultRemarks = $dalRemarks->getRemarks($dateFrom,$dateTo);
        $SL = 1;
        $total = 0;
        $data = "";

        while ($res = mysqli_fetch_assoc($resultRemarks))
        {
        	$data .= '<tr>';
        	$data .= '<td>'.$SL++.'</td>';
        	$data .= '<td>'.$res['text'].'</td>';
        	$data .= '<td>'.$res['userName'].'</td>';
        	$data .= '<td>'.$res['date'].'</td>';
        	$data .='<td><a href="remarks.php?edit='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="remarks.php?delete='.$res['id'].'">Delete</a></td>';
        	$data .= '</tr>';
        }

		return $data;


	}
	public function getRemarksById($id)
	{
		$dalRemarks = new DALRemarks;
		$result = $dalRemarks->getRemarksById($id);
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
			$GLOBALS['userId'] =$res['userId'];
			$GLOBALS['text'] =$res['text'];
		}
	}

}
?>