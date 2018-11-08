<?php
    // Head and body starting
include('./templates/head.php');
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
    $info= '<div id="alert" class="alert alert-info">';
    $info.='<span>'.$_SESSION['message'].'</span>';
    $info.='</div>';
    echo $info;
    unset($_SESSION['message']);
}
?>

    <!-- Add user -->
    <div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Add New User</b> 
            </h4>
        </div>
        <div class="content">
        <form action="bll/bll.newuser.php" method="POST">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>User Name</label>
                    <input type="text" name="name" class="form-control" required autofocus>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Set Password</label>
                    <input type="text" name="password" class="form-control" required>
                </div>
            </div>
        </div>
    
        <div class="row">
             <div class="col-md-8">
                <div class="form-group">
                    <input type="submit" name="addUser" class="btn btn-info btn-fill pull-right" value="Add User">
                </div>
            </div>

        </div>
        </form>
    </div>
    </div>
    </div>
    <!-- Add user end -->
   

    </div>
</div>
</div>

<script>

<link rel="stylesheet" type="text/css" href="assets/css/tableexport.min.css">

<!-- Report csv,xlsx,txt plugins -->
<script type="text/javascript" src="assets/js/bootstrap.min_1.js"></script>
<script type="text/javascript" src="assets/js/FileSaver.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/tableexport.min.js"></script>


<?php
    include('./templates/footer.php');
?>