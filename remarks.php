<?php
// Head and body starting
include('./templates/head.php');

include_once('bll/bll.remarks.php');
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
                    <h4 class="title"><b>Add New Remarks</b></h4>
                </div>
            <div class="content">

                <form action="bll/bll.remarks.php" method="POST">
                 <div class="row">
                <!-- Hold -->
                <input type="text" name="id" value="<?php
                    if(isset($_GET['edit']))
                       echo $GLOBALS['id'];
                    ?>" style="display: none">

                <input type="text" name="userId" value="<?php
                    if(isset($_GET['edit']))
                        echo $GLOBALS['userId'];
                    elseif(isset($_SESSION[$adminToken]))
                       echo $_SESSION[$adminToken];
                    else if(isset($_SESSION[$userToken]))
                        echo $_SESSION[$userToken];

                    ?>" style="display: none">
                <!-- Hold end -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="text" class="form-control" required><?php if (isset($_GET['edit']))
                                {
                                   echo $GLOBALS['text'];
                                } ?></textarea>

                        </div>
                    </div>

                </div>
         
                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_remarks";
                else 
                    echo "insert_remarks";
                ?>"" value="<?php
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
        <h4 class="title"><b>Remarks</b> 
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

                echo date('Y-m-d',$time);
                ?>" required>
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
                <label>To</label>
                <input type="date" name="dateTo" class="form-control" value="<?php
                $time = time();
                echo date('Y-m-d',$time);
                ?>" required>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-8">
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Remarkss">
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
            <h4 class="title"><b>Remarks</b></h4>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
                <thead>
                    <th>SL.</th>
                    <th>Text</th>
                    <th>By</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                <?php
$bllRemarks = new BLLRemarks;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllRemarks->showRemarks($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllRemarks->showRemarks($today,$today);
}
?>
                </tbody>
            </table>

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