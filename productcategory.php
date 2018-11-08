<?php
include('./templates/head.php');

include('./bll/bll.productcategory.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/permissionadmin.php');

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

                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><b>Top Category</b></h4>
            
                            </div>
                            <div class="content">
                                <form action="bll/bll.productcategory.php" method="POST">
                                    <div class="row">
                                    <input type="text" name="id" value="<?php
                                    if(isset($_GET['edit']))
                                       echo $_GET['edit'];
                                    ?>" style="display: none">
                                       
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input type="text" name="categoryName" class="form-control" placeholder="Category Name" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['name'];
                                                ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                                                if(isset($_GET['edit']))
                                                   echo "update_category";
                                                else 
                                                    echo "insert_category";
                                                ?>"" value="<?php
                                                if(isset($_GET['edit']))
                                                   echo "Update";
                                                else
                                                    echo "Save";
                                                ?>">
                                    <div class="clearfix"></div>
                                </form>

                                 <!-- Data display -->
                            <br>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>SL.</th>
                                        <th>Title</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                        echo $bllProductCategory->showCategory();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Data display end -->

                            </div>
                        </div>
                    </div>
                    <!-- Column end -->
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><b>Sub Category</b></h4>
            
                            </div>
                            <div class="content">
                                <form action="bll/bll.productcategory.php" method="POST">
                                    <div class="row">
                                    <input type="text" name="id" value="<?php
                                    if(isset($_GET['editSub']))
                                       echo $_GET['editSub'];
                                    ?>" style="display: none">
                                       
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>SubCategory Name</label>
                                                <input type="text" name="subCategoryName" class="form-control" placeholder="Sub Category Name" required value="<?php
                                                if(isset($_GET['editSub']))
                                                   echo $GLOBALS['name'];
                                                ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>Category Name</label>
                                            <?php
                                            echo $bllProductCategory->getCategoryAsOptions();
                                            ?>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                                                if(isset($_GET['editSub']))
                                                   echo "update_sub_category";
                                                else 
                                                    echo "insert_sub_category";
                                                ?>"" value="<?php
                                                if(isset($_GET['editSub']))
                                                   echo "Update";
                                                else
                                                    echo "Save";
                                                ?>">
                                    <div class="clearfix"></div>
                                </form>

                                 <!-- Data display -->
                            <br>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>SL.</th>
                                        <th>Title</th>
                                        <th>Parent</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                        echo $bllProductCategory->showSubCategory();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Data display end -->

                            </div>
                        </div>
                    </div>
                    <!-- Column end -->

                </div>

            </div>
        </div>

 <?php
    include('./templates/footer.php');
?>