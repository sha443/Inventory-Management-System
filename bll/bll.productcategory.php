<?php
include($_SERVER['DOCUMENT_ROOT'].'/kmh/dal/dal.productcategory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/utility.php');

$name = "";
$categoryId = "";
$bllProductCategory = new BLLProductCategory;
class BLLProductCategory
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalProductCategory = new DALProductCategory;
		if(isset($_POST['insert_category']))
		{

			// SE = Sales Executive
			$categoryName = $utility->secureInput($_POST['categoryName']);
			

			$result = $dalProductCategory->insertCategory($categoryName);
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


			$result = $dalProductCategory->updateCategory($id,$categoryName);
			if($result)
			{
				$_SESSION['message'] = "Category updated Successfully!";
				header('Location:../productcategory.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Category!";
				header('Location:../productcategory.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{

		
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalProductCategory->deleteCategory($id);
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
			

			$result = $dalProductCategory->insertSubCategory($subCategoryName,$categoryId);
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



			$result = $dalProductCategory->updateSubCategory($id,$subCategoryName,$categoryId);

			if($result)
			{
				$_SESSION['message'] = "SubCategory updated Successfully!";
				header('Location:../productcategory.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update SubCategory!";
				//header('Location:../productcategory.php');
				exit();
			}

		}

		if(isset($_GET['deleteSub']))
		{

		
			$id = $utility->secureInput($_GET['deleteSub']);
		
			$result = $dalProductCategory->deleteSubCategory($id);
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
		$dalProductCategory = new DALProductCategory;
		$result = $dalProductCategory->showCategory();
		$data = "";
		$i  = 1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .='<tr>';
			$data .='<td>'.$i++.'</td>';
			$data .='<td>'.$res['name'].'</td>';
			$data .='<td><a href="productcategory.php?edit='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="productcategory.php?delete='.$res['id'].'">Delete</a></td>';
			$data .='</tr>';
		}
		return $data;

	}
	public function getCategoryById($id)
	{
		$dalProductCategory = new DALProductCategory;
		$result = $dalProductCategory->getCategoryById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['name'] =$res['name'];
		}
	}
	public function getCategoryAsOptions()
	{
		$dalProductCategory = new DALProductCategory;
		$result = $dalProductCategory->showCategory();
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
		$dalProductCategory = new DALProductCategory;
		$result = $dalProductCategory->showSubCategory();
		$data = "";
		$i  = 1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .='<tr>';
			$data .='<td>'.$i++.'</td>';
			$data .='<td>'.$res['subCategoryName'].'</td>';
			$data .='<td>'.$res['categoryName'].'</td>';
			$data .='<td><a href="productcategory.php?editSub='.$res['id'].'">Edit</a></td>';
			$data .='<td><a href="productcategory.php?deleteSub='.$res['id'].'">Delete</a></td>';
			$data .='</tr>';
		}
		return $data;

	}
	public function getSubCategoryById($id)
	{
		$dalProductCategory = new DALProductCategory;
		$result = $dalProductCategory->getSubCategoryById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['name'] =$res['name'];
			$GLOBALS['categoryId'] =$res['categoryId'];
		}
	}

}
?>