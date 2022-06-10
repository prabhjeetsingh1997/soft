<?php
include('config/init.php');
if($_POST['id'])
{
	extract($_POST);
	
	
		//echo $val;
		$cityName =$objAdmin->get_hotel_city_filter($id);
		//print_r($cityName);exit;
		foreach($cityName as $newCity)
		{
			$newArr[$i] = $newCity;
			$i++;
		}
	
	
//print_r($newArr);
	$optStr = '<option value="" >Select</option>';
	foreach($cityName as $val)
	{
		$city_name = $val['hotel_name'];
		$cityId = $val['hotel_id'];
		$optStr = $optStr.'<option value="'.$cityId.'">'.$city_name.'</option>';
	}
	echo $optStr;
	
}