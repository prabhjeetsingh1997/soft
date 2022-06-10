<?php
include('config/init.php');
if (isset($_POST)) {
	$pull_query = $objAdmin->record_per_page($_POST['record']);
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