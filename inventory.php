<?php
// Head and body starting
include('./templates/head.php');

include_once('bll/bll.inventory.php');
include_once('dal/dal.productcategory.php');
include_once('dal/dal.user.php');


?>
<div class="wrapper">
    <!--Sidebar here-->
<?php
    // Dashboard Sidebar
include('./templates/sidebar.php');
   
?>
<div class="main-panel">

<?php
// Top Navbar
include('./templates/navbar.php');
?>
<!--Page contend starts here .. seperated in each file -->

<div class="content">
<div class="container-fluid">
<div class="row">

<?php
if (isset($_SESSION['message']))
    {
        $info= '<div class="alert alert-info">';
        $info.='<span>'.$_SESSION['message'].'</span>';
        $info.='</div>';
        echo $info;
        unset($_SESSION['message']);
    }
?>


<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Add New Inventory</b></h4>
        </div>
        <div class="content">
            
                 <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <form method="GET" name="cat">
                            <select name="productCategory" class="form-control" onchange="this.form.submit()" required>
                            <option>Select a category</option>

                            <?php
                            $dalProductCategory = new DALProductCategory;
                                $result =  $dalProductCategory->showCategory();
                                $option = "";

                                while ($res = mysqli_fetch_assoc($result))
                                {
                                    if(isset($_GET['productCategory']) && $_GET['productCategory']==$res['id'])
                                    {
                                        $option .= '<option value='.$res['id'].' selected>';
                                    }
                                    elseif (isset($_GET['edit']) && $GLOBALS['categoryId']==$res['id']) {
                                        $option .= '<option value='.$res['id'].' selected>';
                                    }
                                    else
                                    {
                                    $option .= '<option value='.$res['id'].'>';

                                    }
                                    $option .= $res['name'];
                                    $option .= '</option>';
                                }
                                echo $option;
                            ?>
                            </select>
                        </form>

                        </div>
                    </div>
                    <form action="bll/bll.inventory.php" method="POST">
                    <div class="col-md-6">
                        <input type="text" name="id" value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['id'];
                            ?>" style="display: none;">
                <div class="form-group">
                    <label>Sub Category</label>
                    <select class="form-control" name="subCategoryId">

                    <?php
                    $dalProductCategory = new DALProductCategory;
                    if (isset($_GET['productCategory']) || isset($_GET['edit']))
                    {
                         $result = "";
                        if(isset($_GET['edit']))
                        {
                            $result =  $dalProductCategory->getSubCategoryByCategoryId($GLOBALS['categoryId']);
                        }
                        else
                        {
                            $result =  $dalProductCategory->getSubCategoryByCategoryId($_GET['productCategory']);
                        }
                       
                        $option = "";

                        while ($res = mysqli_fetch_assoc($result))
                        {
                            if(isset($_GET['edit']) && $GLOBALS['subCategoryId'])
                            {
                                if($res['id']==$GLOBALS['subCategoryId'])
                                {
                                    $option .= '<option value='.$res['id'].' selected>';

                                }
                            }
                            else
                            {
                                $option .= '<option value='.$res['id'].'>';
                            }
                           
                            $option .= $res['name'];
                            $option .= '</option>';
                        }
                        echo $option;
                    }
                    ?>
                    </select>
                </div>
            </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Details</label>
                            <input type="text" name="explanation" class="form-control" placeholder="Explanation" value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['explanation'];
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount(Pcs.)</label>
                            <input type="text" name="pcs" class="form-control" placeholder="Pcs. of Product" required value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['pcs'];
                            ?>">
                        </div>
                    </div>
                </div>

               
                <div class="row">

                   <!-- Control user -->
<?php 
if(isset($_SESSION[$adminToken]))
{
?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="dateOfSale" class="form-control" value="<?php
                            if(isset($_GET['edit']))
                            {
                                echo $GLOBALS['date'];
                            }
                            else
                            {
                                $time = time();
                                echo date('Y-m-d',$time);
                            }
                            
                            ?>" required>
                        </div>
                    </div>

<?php
    }// end of if
    else
    {
?>
                <div class="col-md-6">
                    <input type="date" name="dateOfSale" class="form-control" value="<?php
                        $time = time();
                        echo date('Y-m-d',$time);
                    ?>" style="display: none;">
                </div>
<?php
} // end of else
?>
<!-- Control user end-->
                </div>

                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_inventory";
                else 
                    echo "insert_inventory";
                ?>" value="<?php
                if(isset($_GET['edit']))
                   echo "Update";
                else
                    echo "Save";
                ?>">
                <div class="clearfix"></div>
            </form>

        </div>
        
    </div>
</div>

<?php
    if(isset($_SESSION[$adminToken]))
    {
?>
<!-- Date selection -->
<div class="col-md-12">
<div class="card">
    <div class="header">
        <h4 class="title"><b>Inventory</b> 
        </h4>
    </div>
    <div class="content">
    <form  method="GET">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>From</label>
                <input type="date" name="dateFrom" class="form-control" value="<?php
                $time = time();
                if(isset($_GET['edit']))
                    echo $GLOBALS['date'];
                else
                echo date('Y-m-d',$time);
                ?>" required>
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
                <label>To</label>
                <input type="date" name="dateTo" class="form-control" value="<?php
                $time = time();
                if(isset($_GET['edit']))
                    echo $GLOBALS['date'];
                else
                echo date('Y-m-d',$time);
                ?>" required>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-8">
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Inventory">
            </div>
        </div>

    </div>
    </form>
</div>
</div>
</div>
<!-- Date selection end -->
<?php
   }// End if 
?>

<!-- Data Display -->

<?php
$bllInventory = new BLLInventory;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllInventory->showInventory($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllInventory->showInventory($today,$today);
}
?>

<!-- Data Display End -->

</div>
</div>
</div>
<?php
    include('./templates/footer.php');
?>