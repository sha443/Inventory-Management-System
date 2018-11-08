<?php
include('./templates/head.php');
include('./bll/bll.reports.php');

//include($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/permissionadmin.php');

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

    <!-- Date selection -->
    <div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Sales Report</b> 
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
                    if(isset($_GET['dateRange']))
                    echo $_GET['dateFrom'];
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
                    if(isset($_GET['dateRange']))
                    echo $_GET['dateTo'];
                    else
                    echo date('Y-m-d',$time);
                    ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
             <div class="col-md-8">
                <div class="form-group">
                   
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
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h3 class="title text-center"><b>Daily Cash Report</b></h3>
                <p class="h5 text-center"><i><?php
                    $time = time();
                    if(isset($_GET['dateRange']))
                    echo $_GET['dateFrom'].' <b>To</b> '.$_GET['dateTo'];
                    else
                    echo date('d-M-Y',$time);
                ?></i></p>
            </div>

            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped" id="SalesReport">
                    <thead>
                        <th>SL.</th>
                        <th>Product</th>
                        <th>Tk</th>
                        </thead>
                    <tbody>
<?php
$bllSales = new BLLReports;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllSales->showSalesReport($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllSales->showSalesReport($today,$today);
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Data Display -->

    </div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="assets/css/tableexport.min.css">

<!-- Report csv,xlsx,txt plugins -->
<script type="text/javascript" src="assets/js/bootstrap.min_1.js"></script>
<script type="text/javascript" src="assets/js/FileSaver.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/tableexport.min.js"></script>

<!-- <script>
    $('#SalesReport').tableExport();
</script> -->
<!-- Report csv,xlsx,txt plugins -->

<?php
    include('./templates/footer.php');
?>