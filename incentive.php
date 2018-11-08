<?php
// Head and body starting
include('./templates/head.php');

include_once('bll/bll.incentive.php');
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
                    <h4 class="title"><b>Add New Incentive</b></h4>
                </div>
            <div class="content">

                <form action="bll/bll.incentive.php" method="POST">
                 <div class="row">
                <!-- Hold -->
                <input type="text" name="id" value="<?php
                    if(isset($_GET['edit']))
                       echo $GLOBALS['id'];
                    ?>" style="display: none">
                <!-- Hold end -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Details</label>
                            <select name="explanation" class="form-control" required>
                                
                                <option>Arjon Commission</option>
                                <option>Durbar Commission</option>
                                <option>SAF Paper Commission</option>
                                <option>Service Kit Commission</option>
                                <option>Paper &amp; Activation Commission</option>
                                <option>10 Tk Scratch Card Lifting Commission</option
                                <option>Data Buzz Campaign</option>
                                <option>ERS STR Campaign</option>
                                <option>GA Campaign for DHFF</option>
                                <option>DH Post Commission</option>
                                <option>10 TK SOBAR SERA HOUSE</option>
                                <option>SIM REPLACEMENT COMMISSION</option>
                                <option>SAF Paper Commission HELD ON</option>
                                <option>ED-UII FITOR GA CAMPAIGN</option>
                                <option>10 TK VAUCHER CAMPAIGN</option>
                                <option>SE STR CAMPAIGN</option>
                                <option>19 Tk Scratch Card Lifting Commission</option>
                                <option>GP PREPAID SIM PRICE PROTECTION</option>
                                <option>MFS INCENTIVE</option>
                                <option>DURBER ADJUSTMENT</option>
                                <option>REGISTRATION COMMISSION</option>
                                <option>GA LIFTING DISCOUNT</option>

                            </select>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                            <label>Amount (Tk.)</label>
                            <input type="text" name="netAmount" class="form-control" placeholder="Incentive Amount" required value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['netAmount'];
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="<?php
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
         
                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_incentive";
                else 
                    echo "insert_incentive";
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
        <h4 class="title"><b>Incentive</b> 
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
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Incentives">
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
            <h4 class="title"><b>Incentive</b></h4>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
                <thead>
                    <th>SL.</th>
                    <th>Explanation</th>
                    <th>Net Amount</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                <?php
$bllIncentive = new BLLIncentive;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllIncentive->showIncentive($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllIncentive->showIncentive($today,$today);
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