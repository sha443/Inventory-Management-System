<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.expensecategory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$name = "";
$categoryId = "";
$bllExpenseCategory = new BLLExpenseCategory;
class BLLExpenseCategory
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalExpenseCategory = new DALExpenseCategory;
		if(isset($_POST['insert_category']))
		{

			// SE = Sales Executive
			$categoryName = $utility->secureInput($_POST['categoryName']);
			

			$result = $dalExpenseCategory->insertCategory($categoryName);
			if($result)
			{
				$_SESSION['message'] = "Category added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't create Category !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_category']))
		{

			// SE = Sales Executive
			$id = $utility->secureInput($_POST['id']);
			$categoryName = $utility->secureInput($_POST['categoryName']);


			$result = $dalExpenseCategory->updateCategory($id,$categoryName);
			if($result)
			{
				$_SESSION['message'] = "Category updated Successfully!";
				header('Location:../expensecategory.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Category!";
				header('Location:../expensecategory.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{

		
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalExpenseCategory->deleteCategory($id);
			if($result)
			{
				$_SESSION['message'] = "Category deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Category!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getCategoryById($id);
		}

//-------------- Sub category-----------------------

		if(isset($_POST['insert_sub_category']))
		{

			// SE = Sales Executive
			$subCategoryName = $utility->secureInput($_POST['subCategoryName']);
			$categoryId = $utility->secureInput($_POST['parent']);
			

			$result = $dalExpenseCategory->insertSubCategory($subCategoryName,$categoryId);
			if($result)
			{
				$_SESSION['message'] = "SubCategory added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't create SubCategory !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_sub_category']))
		{

			// SE = Sales Executive
			$id = $utility->secureInput($_POST['id']);
			$subCategoryName = $utility->secureInput($_POST['subCategoryName']);
			$categoryId = $utility->secureInput($_POST['parent']);



			$result = $dalExpenseCategory->updateSubCategory($id,$subCategoryName,$categoryId);

			if($result)
			{
				$_SESSION['message'] = "SubCategory updated Successfully!";
				header('Location:../expensecategory.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update SubCategory!";
				//header('Location:../expensecategory.php');
				exit();
			}

		}

		if(isset($_GET['deleteSub']))
		{

		
			$id = $utility->secureInput($_GET['deleteSub']);
		
			$result = $dalExpenseCategory->deleteSubCategory($id);
			if($result)
			{
				$_SESSION['message'] = "SubCategory deleted Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete SubCategory!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_GET['editSub']))
		{
			$id = $utility->secureInput($_GET['editSub']);
		
			$this->getSubCategoryById($id);
		}
	}
	public function showCategory()
	{
		$dalExpenseCategory = new DALExpenseCategory;
		$result = $dalExpenseCategory->showCategory();
		$data = "";
		$i  = 1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .='<tr>';
			$data .='<td>'.$i++.'</td>';
			$data .='<td>'.$res['name'].'</td>';
			$data .='<td><a href="expensecategory.php?edit='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="expensecategory.php?delete='.$res['id'].'">Delete</a></td>';
			$data .='</tr>';
		}
		return $data;

	}
	public function getCategoryById($id)
	{
		$dalExpenseCategory = new DALExpenseCategory;
		$result = $dalExpenseCategory->getCategoryById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['name'] =$res['name'];
		}
	}
	public function getCategoryAsOptions()
	{
		$dalExpenseCategory = new DALExpenseCategory;
		$result = $dalExpenseCategory->showCategory();
		$data ='<select name="parent" class="form-control">';
		$i  = 1;
		while ($res = mysqli_fetch_assoc($result))
		{
			if(isset($_GET['editSub']) && $GLOBALS['categoryId']==$res['id'])
			{
				$data .='<option selected="selected" value='.$res['id'].'>';
			}
			else
			{
				$data .='<option value='.$res['id'].'>';
			}
			$data .=$res['name'];
			$data .='</option>';
		}
		$data .='</select>';

		return $data;

	}

	public function showSubCategory()
	{
		$dalExpenseCategory = new DALExpenseCategory;
		$result = $dalExpenseCategory->showSubCategory();
		$data = "";
		$i  = 1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .='<tr>';
			$data .='<td>'.$i++.'</td>';
			$data .='<td>'.$res['subCategoryName'].'</td>';
			$data .='<td>'.$res['categoryName'].'</td>';
			$data .='<td><a href="expensecategory.php?editSub='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="expensecategory.php?deleteSub='.$res['id'].'">Delete</a></td>';
			$data .='</tr>';
		}
		return $data;

	}
	public function getSubCategoryById($id)
	{
		$dalExpenseCategory = new DALExpenseCategory;
		$result = $dalExpenseCategory->getSubCategoryById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['name'] =$res['name'];
			$GLOBALS['categoryId'] =$res['categoryId'];
		}
	}

}
?>