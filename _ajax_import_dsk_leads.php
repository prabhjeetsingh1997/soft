<?php
include('config/init.php');
if($_GET['action'] == 'addnew'){
	$dsk_detail = $objAdmin->add_new_dsk_leads_detail($_FILES);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>