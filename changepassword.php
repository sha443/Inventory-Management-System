<?php
// Head and body starting
include('./templates/head.php');
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

    <!-- Change Password  -->
    <div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Change Password</b> 
            </h4>
        </div>
        <div class="content">
        <form action="bll/bll.changepassword.php" method="POST" name="cngForm" onsubmit="return checkPassword();">
        <input type="text" name="userId" value="<?php  
        if(isset($_SESSION[$adminToken]))
        {
            echo $_SESSION[$adminToken]; 
        }
        elseif(isset($_SESSION[$userToken]))
        {
            echo $_SESSION[$userToken]; 
        }
        ?>" style="display: none;">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" name="old" class="form-control" required autofocus>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
             <div class="col-md-8">
                <div class="form-group">
                    <input type="submit" name="changePassword" class="btn btn-info btn-fill pull-right" value="Change Password">
                </div>
            </div>

        </div>
        </form>
    </div>
    </div>
    </div>
    <!-- Change Password end -->
   

    </div>
</div>
</div>
<script>

function checkPassword() {
    var New = document.forms["cngForm"]["new"].value;
    var Confirm = document.forms["cngForm"]["confirm"].value;
    
    if(New != Confirm)
    {
        alert("Password doesn't matched!");
        return false;
    }
}
</script>

<link rel="stylesheet" type="text/css" href="assets/css/tableexport.min.css">

<!-- Report csv,xlsx,txt plugins -->
<script type="text/javascript" src="assets/js/bootstrap.min_1.js"></script>
<script type="text/javascript" src="assets/js/FileSaver.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/tableexport.min.js"></script>

<script>
    $('#SalesReport').tableExport();
</script>
<!-- Report csv,xlsx,txt plugins -->

<?php
    include('./templates/footer.php');
?>