<?php
include('config/init.php');
if (isset($_POST)) {
	$invoice = $objAdmin->invoice($_POST['id']);
	if($invoice)
	{
		echo $id=$_POST['id'];
	}
	
}
?>

