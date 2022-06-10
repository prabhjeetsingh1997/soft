<?php
include('config/init.php');
if (isset($_POST)) {
	$pull_query = $objAdmin->pull_query($_POST['id'],$_POST['userId']);
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