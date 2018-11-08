<?php
include('./templates/head.php');
// Head and body starting\
include_once('bll/bll.query.php');

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
                <h4 class="title"><b>Query Sales Executive</b></h4>
            </div>
            <div class="content">
            
            <form  method="POST">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sales Executive</label>
                            <select class="form-control" name="SE">
                               <?php
                                $dalUser = new DALUser;
                                $result =  $dalUser->showSE();
                                $option = "";

                                while ($res = mysqli_fetch_assoc($result))
                                {

                                    $option .= '<option value='.$res['id'].'>';
                                    $option .= $res['name'];
                                    $option .= '</option>';
                                }
                                echo $option;
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
            
            <!-- Date selection -->

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

            <!-- Date selection end -->

                <input type="submit" class="btn btn-info btn-fill pull-right" name="querySE" value="Query SE">
                <div class="clearfix"></div>
            </form>
            </div>
        </div>
    </div>


<!-- Data Display -->
<div class="row">
<div class="col-md-6">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Summary</b></h4>
        
        
<?php
    if(isset($_POST['querySE']))
    {   
        $seId = $_POST['SE'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];

        echo '<h5 class="title"> ';
        echo $dateFrom." To ".$dateTo;
        echo '</h5>';
        echo '</div>'; // header end
        echo '<div class="content table-responsive table-full-width">';
        $bllQuery = new BLLQuery;
        echo $bllQuery->showQuery($dateFrom,$dateTo,$seId);
    }    
    else
    {
        $time = time();
        $dummy = date('Y-m-d',$time);   
        $bllQuery = new BLLQuery;
        echo $bllQuery->showAllQuery($dummy);
    }
?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Due Products</b></h4>
        </div>
        <div class="content table-responsive table-full-width">
<?php
    if(isset($_POST['querySE']))
    {   
        $seId = $_POST['SE'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        
        $bllQuery = new BLLQuery;
        echo $bllQuery->showDueProducts($dateFrom,$dateTo,$seId);
    }

?>
        </div>
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