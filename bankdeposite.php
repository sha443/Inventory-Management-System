<?php
// Head and body starting
include('./templates/head.php');

include_once('bll/bll.bankdeposite.php');
include_once('dal/dal.expensecategory.php');
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
                    <h4 class="title"><b>Add New Bank Deposite</b></h4>
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

                <form action="bll/bll.bankdeposite.php" method="POST">
                 <div class="row">
                <!-- Hold -->
                    <input type="text" name="id" value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['id'];
                            ?>" style="display: none">

                    <input type="text" name="SE" value="<?php
                    if(isset($_GET['SE']))
                        echo $_GET['SE'];
                     elseif(isset($_GET['edit']))
                        echo $GLOBALS['seId'];
                    ?>" style="display: none;">
                <!-- Hold end -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Token No</label>
                           <input type="text" name="tokenNo" class="form-control" placeholder="Token No" value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['tokenNo'];
                            ?>">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank Name</label>
                            <select class="form-control" name="bankName">
                               <?php
                                $bankArray = array('SIBL','IBBL');
                                $option = "";

                                foreach ($bankArray as $res)
                                {

                                    if(isset($_GET['edit']) && $GLOBALS['bankName']==$res)
                                    {
                                        $option .= '<option value='.$res.' selected>';
                                    }
                                    else
                                    {
                                    $option .= '<option value='.$res.'>';

                                    }
                                    $option .= $res;
                                    $option .= '</option>';
                                }
                                echo $option;
                            ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Net Amount (Tk.)</label>
                            <input type="text" name="netAmount" class="form-control" placeholder="Net Amount" required value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['netAmount'];
                            ?>">
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
<?php
    }// end of if
    else
    {
?>
                <div class="row">
                    <input type="date" name="date" class="form-control" value="<?php
                        $time = time();
                        echo date('Y-m-d',$time);
                    ?>" style="display: none;">
                </div>
<?php
} // end of else
?>
</div>
<!-- Control user end-->
                

                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_bankdeposite";
                else 
                    echo "insert_bankdeposite";
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

<?php
    if(isset($_SESSION[$adminToken]))
    {
?>
<div class="col-md-12">
<div class="card">
    <div class="header">
        <h4 class="title"><b>Bank Deposites</b> 
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
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Bank Deposites">
            </div>
        </div>

    </div>
    </form>
</div>
</div>
</div>
<?php
   }// End if 
?>
<!-- Date selection end -->
<!-- Data Display -->
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Bank Deposite</b></h4>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
                <thead>
                    <th>SL.</th>
                    <th>SE Name</th>
                    <th>Token No</th>
                    <th>Bank Name</th>
                    <th>Net Amount</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                <?php
$bllBankDeposite = new BLLBankDeposite;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllBankDeposite->showBankDeposite($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllBankDeposite->showBankDeposite($today,$today);
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