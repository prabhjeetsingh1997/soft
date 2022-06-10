<?php
include('config/init.php');
if (isset($_POST)) {
	$confirm_query = $objAdmin->undoConfirm_query($_POST['id']);
	if($confirm_query)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}else{
	echo 2;
}
?>