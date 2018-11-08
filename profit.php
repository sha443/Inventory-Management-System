<?php
// Head and body starting
include('./templates/head.php');
include($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/permissionadmin.php');
include_once('bll/bll.profit.php');
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

<!-- Data Display -->
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Price Table (Per Unit price in Tk.)</b></h4>
        </div>
        <div class="content">
        <hr><h4>
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    SL.
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    Product Name
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    Purchase Price
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    Selling Price
                </div>
            </div>
        </div>
        </h4><hr>

<!-- Editing from -->
<form action="bll/bll.profit.php" method="POST">

<?php
$bllProfit = new BLLProfit;
    echo $bllProfit->showProfit();
?>  
    <input type="submit" name="update_profit" value="Update Profit Chart" class="btn btn-info btn-fill pull-right">
 <div class="clearfix"></div>
</form>
        </div>
    </div>
</div>

<!-- Data Display End -->
</div>
</div>
</div>
<?php
    include('./templates/footer.php');
?>