<?php
include('config/init.php');
@extract($_POST);

if($type == 'add_query'){
	//print_r($_POST);
	//die;
	$query_detail = $objAdmin->add_query($_POST);
	if($query_detail)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>