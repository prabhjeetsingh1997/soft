<?php
$realpath = 'adminConfig/init.php';
    include($realpath);
//include('config/init.php');
session_destroy();
unset( $_SESSION['admin_Email']);
header("Location:index.php");
?>