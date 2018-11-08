<?php
include('./templates/head.php');
//include($_SERVER['DOCUMENT_ROOT'].'/kmh/includes/permissionadmin.php');

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

    <!-- Date selection -->
    <div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Final Report</b> 
            </h4>
        </div>
        <div class="content">
        <form  method="GET">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>From</label>
                    <input type="date" name="date" class="form-control" value="<?php
                    $time = time();
                    if(isset($_GET['dateSelect']))
                    echo $_GET['date'];
                    else
                    echo date('Y-m-d',$time);
                    ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label></label>
                   <div class="form-group">
                   
                    <input type="submit" name="dateSelect" class="btn btn-info btn-fill pull-right" value="Load Report">
                </div>
                </div>
            </div>
        </div>

        </form>
    </div>
    </div>
    </div>
    <!-- Date selection end -->
<!-- <button class="btn btn-primary" onclick="CallPrint('print')">Print</button> -->

<div id="print">
    <!-- Data Display -->
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h3 class="title text-center"><b>Kazi Mobile Home</b></h3>
                <br>
                <p class="text-center">Authorized Distributor of Grameenphone Ltd.<br>Dumuria, Khulna.</p>
                <p class="h5 text-center"><i><?php
                    $time = time();
                    if(isset($_GET['dateSelect']))
                    echo $_GET['date'];
                    else
                    echo date('l, F d, Y',$time);
                ?></i></p>
            </div>

            <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped" id="SalesReport">
            <thead>
                <th>Details</th><th>Tk.</th>
            </thead>
            <tbody>
<?php
$bllReports = new BLLReports;
if(isset($_GET['dateSelect']))
{
    $today= $_GET['date'];


    $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today)));

   echo $bllReports->showFinalReport($today,$yesterday);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    $y = strtotime("-1 day", $time);
    $yesterday = date('Y-m-d',$y);

    echo $bllReports->showFinalReport($today,$yesterday);
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Data Display -->
</div> 
<!-- Print div end -->

<!-- Notification  -->
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <p class="alert-success well">
                  <?php
                  $time = time();
                  $date = date('Y-m-d',$time);
                    echo $bllReports->getStatus($date);
                  ?>
                </p>
            </div>
        </div>
    </div>
<!-- Notification end -->

    </div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="assets/css/tableexport.min.css">

<!-- Report csv,xlsx,txt plugins -->
<script type="text/javascript" src="assets/js/bootstrap.min_1.js"></script>
<script type="text/javascript" src="assets/js/FileSaver.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/tableexport.min.js"></script>
<script language="javascript" type="text/javascript">
    function CallPrint(id) {
        var prtContent = document.getElementById(id);
        var WinPrint = window.open();
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
        prtContent.innerHTML = strOldOne;
    }
</script>
<?php
    include('./templates/footer.php');
?>