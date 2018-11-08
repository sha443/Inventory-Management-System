<?php
   // ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) .'/data/session'));
    if (!isset($_SESSION))
    {
        session_start();
    }

    include_once($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php');
    
    // Admin-User
    $adminToken = "37d1323ddba2320ae4cd8b0692fa2203bcba0615";
    $userToken = "deecae70425e77c2f903e5a37946d459e26637a0";
    if((!isset($_SESSION[$adminToken])) && (!isset($_SESSION[$userToken])))
    {
         echo "<script>window.location='login.php'</script>";

    }

?>