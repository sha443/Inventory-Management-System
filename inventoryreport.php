<?php
include('./templates/head.php');
include('./bll/bll.reports.php');


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
                <h3 class="title text-center"><b>Daily Inventory Report</b></h3>
                <p class="h5 text-center"><i><?php
                    $time = time();
                    if(isset($_GET['dateRange']))
                    echo $_GET['dateFrom'].' <b>';
                    else
                    echo date('d-M-Y',$time);
                ?></i></p>
            </div>

            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped" id="InventoryReport">
                    <thead>
                        <th>SL.</th>
                        <th>Product</th>
                        <th>Opening Goods</th>
                        <th>Recieved Goods</th>
                        <th>SE OnHand</th>
                        <th>Sales Goods</th>
                        <th>Return Goods</th>
                        <th>Closing Goods</th>
                        <th>Product Value</th>
                        </thead>
                    <tbody>
<?php
    $bllInventory = new BLLReports;
    $time = time();
    $today = date('Y-m-d',$time);
    $y = strtotime("-1 day", $time);
    $yesterday = date('Y-m-d',$y);

    echo $bllInventory->showInventoryReport($yesterday,$today);
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
    $('#InventoryReport').tableExport();
</script> -->
<!-- Report csv,xlsx,txt plugins -->

<?php
    include('./templates/footer.php');
?>