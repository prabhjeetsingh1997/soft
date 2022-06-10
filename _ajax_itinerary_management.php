<?php
include('config/init.php');
@extract($_POST);
//print_r($_POST);

if($type == 'add_itinerary_management')
{
	//print_r($_POST);
	$itinerary_detail = $objAdmin->itinerary_management($_POST);
	if($itinerary_detail)
	{
		//$_SESSION['itinerary_management'] =$prsnl_detail;
		echo 1;
	}
	else
	{
		echo 0;
	}
}