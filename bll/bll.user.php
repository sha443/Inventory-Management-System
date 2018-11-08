<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$name = "";
$phoneNo = "";
$address = "";
$bllUser = new BLLUser;
class BLLUser
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalUser = new DALUser;
		if(isset($_POST['insert_se']))
		{

			// SE = Sales Executive
			$fullName = $utility->secureInput($_POST['fullName']);
			$phoneNo = $utility->secureInput($_POST['phoneNo']);
			$address = $utility->secureInput($_POST['address']);

			$result = $dalUser->insertSE($fullName,$phoneNo,$address);
			if($result)
			{
				$_SESSION['message'] = "Executive added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't insert Sales Executive !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_se']))
		{

			// SE = Sales Executive
			$id = $utility->secureInput($_POST['id']);
			$fullName = $utility->secureInput($_POST['fullName']);
			$phoneNo = $utility->secureInput($_POST['phoneNo']);
			$address = $utility->secureInput($_POST['address']);

			$result = $dalUser->updateSE($id,$fullName,$phoneNo,$address);
			if($result)
			{
				$_SESSION['message'] = "Executive updated Successfully!";
				header('Location:../user.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Sales Executive !";
				header('Location:../user.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{

			// SE = Sales Executive
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalUser->deleteSE($id);
			if($result)
			{
				$_SESSION['message'] = "Sales Executive deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Sales Executive !";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getSEById($id);
		}
	}
	public function showSE()
	{
		$dalUser = new DALUser;
		$result = $dalUser->showSE();
		$data = "";
		$i  = 1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .='<tr>';
			$data .='<td>'.$i++.'</td>';
			$data .='<td>'.$res['name'].'</td>';
			$data .='<td>'.$res['phoneNo'].'</td>';
			$data .='<td>'.$res['address'].'</td>';
			$data .='<td><a href="user.php?edit='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="user.php?delete='.$res['id'].'">Delete</a></td>';
			$data .='</tr>';
		}
		return $data;

	}
	public function getSEById($id)
	{
		$dalUser = new DALUser;
		$result = $dalUser->getSEById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['name'] =$res['name'];
			$GLOBALS['phoneNo'] =$res['phoneNo'];
			$GLOBALS['address'] =$res['address'];
		}
	}

}
?>