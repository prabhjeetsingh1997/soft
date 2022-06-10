<?php
include('config/init.php');
if (isset($_POST)) {
	$pull_query = $objAdmin->confirm_query($_POST['id']);
	if($pull_query)
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