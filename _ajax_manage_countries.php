<?php 
require 'config/init.php';
@extract($_POST);
//print_r($_POST);
if($type == 'country')
{
	$inputcountry = strtoupper($inputcountry);
	if($objAdmin->country_exists($inputcountry) === true){
		echo 'N';
	}
	else
	{	
		echo $country = $objAdmin->Add_country($inputcountry);
	}
}	
else if($type == 'state')
{
	$stateName = strtoupper($stateName);	
	if($objAdmin->state_exists($countryId, $stateName) === true){
		echo 'N';
	}
	else
	{	
		echo $country = $objAdmin->Add_state($countryId, $stateName);
	}
}	
else if($type == 'getstate')
{
	$cityarr = $objAdmin->get_stats_list($countryId);
	$opt = '<option value="">Select</option>';
	foreach($cityarr as $arr)
	{
		$sid = $arr['id'];  //stats id
		$stateName = $arr['state_name'];  //stats id
		$opt .= '<option value="'.$sid.'">'.$stateName.'</option>';
	}
	echo $opt;
}	
else if($type == 'city')
{
	$cityName = strtoupper($cityName);	
	if($objAdmin->city_exists_add($countryId, $stateId, $cityName) === true){
		echo 'N';
	}
	else
	{	
		echo $city = $objAdmin->Add_city($countryId, $stateId, $cityName);
	}
}
die;
if($type == 'bulk')
{
	$action = $_GET['action'];		
	foreach($ids as $delId)
	{	
		if($item == 'gt')
		{
			$tourType = 1;  //1=>general 2=>fixed, 3=>fam	
			echo $supplier = $objAdmin->Delete($delId, 'tours', $tourType, $action);
		}
		else if($item == 'ft')
		{
			$tourType = 2;  //1=>general 2=>fixed, 3=>fam	
			echo $supplier = $objAdmin->Delete($delId, 'tours', $tourType, $action);
		}	
		else if($item == 'famt')
		{
			$tourType = 3;  //1=>general 2=>fixed, 3=>fam	
			echo $supplier = $objAdmin->Delete($delId, 'tours', $tourType, $action);
		}
		if($item == 'elearn')
		{
			echo $supplier = $objAdmin->Delete($delId, 'elearning_programs', 0, $action);
		}
		if($item == 'images' || $item == 'videos')
		{
			echo $supplier = $objAdmin->Delete($delId, 'gallary', 0, $action);
		}	
		if($item == 'offer')
		{
			echo $supplier = $objAdmin->Delete($delId, 'offers_and_deals', 0, $action);
		}
		if($item == 'brochure')
		{
			echo $supplier = $objAdmin->Delete($delId, 'brochures', 0, $action);
		}	
		if($item == 'office')
		{
			echo $supplier = $objAdmin->Delete($delId, 'tourist_offices', 0, $action);
		}
		if($item == 'client')
		{
			echo $supplier = $objAdmin->Delete($delId, 'clients', 0, $action);
		}
	}
	
}	
else
{	
	$action = 'delete';
	if($item == 'gt')
	{
		$tourType = 1;  //1=>general 2=>fixed, 3=>fam	
		echo $supplier = $objAdmin->Delete($delId, 'tours', $tourType, $action);
	}
	else if($item == 'ft')
	{
		$tourType = 2;  //1=>general 2=>fixed, 3=>fam	
		echo $supplier = $objAdmin->Delete($delId, 'tours', $tourType, $action);
	}	
	else if($item == 'famt')
	{
		$tourType = 3;  //1=>general 2=>fixed, 3=>fam	
		echo $supplier = $objAdmin->Delete($delId, 'tours', $tourType, $action);
	}
	if($item == 'elearn')
	{
		echo $supplier = $objAdmin->Delete($delId, 'elearning_programs', 0, $action);
	}
	if($item == 'images' || $item == 'videos')
	{
		echo $supplier = $objAdmin->Delete($delId, 'gallary', 0, $action);
	}	
	if($item == 'offer')
	{
		echo $supplier = $objAdmin->Delete($delId, 'offers_and_deals', 0, $action);
	}
	if($item == 'brochure')
	{
		echo $supplier = $objAdmin->Delete($delId, 'brochures', 0, $action);
	}	
	if($item == 'office')
	{
		echo $supplier = $objAdmin->Delete($delId, 'tourist_offices', 0, $action);
	}
	if($item == 'client')
	{
		echo $supplier = $objAdmin->Delete($delId, 'clients', 0, $action);
	}
}
?>