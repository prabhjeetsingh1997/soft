<?php
$realpath = 'adminConfig/init.php';
    include($realpath);
//include('soft/adminConfig/init.php');

extract($_POST);
if($_GET['action']=='delete'){
    
    $id = $_POST['id'];
    //var_dump($id);
    $delete = $objAdmin->deleteMrsCapitalLeadById($id);
        if($delete > 0){
            echo 1;
            //header("location:dskevent.php");
            exit;
        }else{
            echo 0;
            exit;
        }
}
?>