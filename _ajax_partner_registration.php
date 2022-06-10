<?php
include('config/init.php');
@extract($_POST);

if($type == 'add_partner'){
	//print_r($_POST);
	//die;
	$partner_detail = $objAdmin->add_partner($_POST);
	if($partner_detail)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>