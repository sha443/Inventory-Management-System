<?php
include('./templates/head.php');
// Head and body starting
include_once('bll/bll.sales.php');
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
            <h4 class="title"><b>Daily Sales</b></h4>
        </div>
        <div class="content">

             <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <form method="GET" name="se">
                            <label>SE Name</label>
                            <select class="form-control" name="SE" onchange="this.form.submit()" required>
                               <?php
                                $dalUser = new DALUser;
                                $result =  $dalUser->showSE();
                                $option = "";

                                while ($res = mysqli_fetch_assoc($result))
                                {
                                    if(isset($_GET['edit']) && $GLOBALS['seId']==$res['id'])
                                    {
                                        $option .= '<option value='.$res['id'].' selected>';
                                    }
                                    elseif(isset($_GET['SE']) && $_GET['SE']==$res['id'])
                                    {
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
                </div>
            
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
                            <!-- Hold -->
                            <input type="text" name="SE" value="<?php
                            if(isset($_GET['SE']))
                                echo $_GET['SE'];

                            ?>" style="display: none;">
                            <!-- Hold data end  -->
                        </form>

                        </div>
                    </div>
                    <form action="bll/bll.sales.php" method="POST">
                <!-- Hold -->
                    <input type="text" name="SE" value="<?php
                    if(isset($_GET['SE']))
                        echo $_GET['SE'];
                     elseif(isset($_GET['edit']))
                        echo $GLOBALS['seId'];
                    ?>" style="display: none;">
                <!-- Hold end -->
                    <div class="col-md-6">
                        <input type="text" name="salesId" value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['salesId'];
                            ?>" style="display: none;">
                <div class="form-group">
                    <label>Sub Category</label>
                    <select class="form-control" name="subCategoryId" required>

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
                            if(isset($_GET['edit']) && $GLOBALS['subCategoryId'] == $res['id'])
                            {
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
                            <label>Pcs.</label>
                            <input type="text" name="pcs" class="form-control" placeholder="Pcs. of Product" required value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['pcs'];
                            ?>">
                        </div>
                    </div>
                </div>


                <!-- Control user -->
<?php 
if(isset($_SESSION[$adminToken]))
{
?>

                <div class="row">
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

                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_sales";
                else 
                    echo "insert_sales";
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

<!-- Date selection -->
<div class="col-md-12">
<div class="card">
    <div class="header">
        <h4 class="title"><b>Sales</b> 
        </h4>
    </div>
    <div class="content">
    <form  method="GET">
<!-- Hold -->
    <input type="text" name="SE" value="<?php
    if(isset($_GET['SE']))
        echo $_GET['SE'];
     elseif(isset($_GET['edit']))
        echo $GLOBALS['seId'];
    ?>" style="display: none;">
<!-- Hold end -->
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
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Sales">
            </div>
        </div>

    </div>
    </form>
</div>
</div>
</div>
<!-- Date selection end -->

<!-- Data Display -->

<?php
$bllSales = new BLLSales;
if (isset($_GET['SE']) && isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllSales->showSESales($_GET['SE'],$dateFrom,$dateTo);
}
elseif (isset($_GET['SE']))
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllSales->showSESales($_GET['SE'],$today,$today);
}
elseif(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllSales->showSales($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllSales->showSales($today,$today);
}
?>

<!-- Data Display End -->

</div>
</div>
</div>
<?php
    include('./templates/footer.php');
?>