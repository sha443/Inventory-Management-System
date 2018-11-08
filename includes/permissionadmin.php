<?php
    // Admin Only
	$adminToken = "37d1323ddba2320ae4cd8b0692fa2203bcba0615";
    if(!isset($_SESSION[$adminToken]))
    {
        echo "<script>window.location='inventory.php'</script>";

    }
?>