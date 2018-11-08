<?php
    // Head and body starting
include('./templates/head.php');

include('./bll/bll.user.php');
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b>Add New Sales Executive</b></h4>
                            </div>
                            <div class="content">
                                <form action="bll/bll.user.php" method="POST">
                                    <div class="row">
                                        <input type="text" name="id" value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $_GET['edit'];
                                                ?>" style="display: none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="fullName" class="form-control" placeholder="Full Name" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['name'];
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone No</label>
                                                <input type="text" name="phoneNo" class="form-control" placeholder="Phone No" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['phoneNo'];
                                                ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control" placeholder="Address" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['address'];
                                                ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                                                if(isset($_GET['edit']))
                                                   echo "update_se";
                                                else 
                                                    echo "insert_se";
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
                   <!--  Add new User end-->
                   <!-- Data Display -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b>List of Sales Executive</b></h4>
                                <p class="category">Kazi Mobile Home</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Address</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                        echo $bllUser->showSE();
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