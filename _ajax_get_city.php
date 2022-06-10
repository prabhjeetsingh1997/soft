<?php
include('config/init.php');
if($_POST['id'])
{
	extract($_POST);
	
	$city='';
	$arrId=explode(',',$id);
	$i=0;
	$newArr = array();
	//print_r($arrId);die;
	foreach($arrId as $val)
	{
		//echo $val;
		$cityName =$objAdmin->get_city($val);
		foreach($cityName as $newCity)
		{
			$newArr[$i] = $newCity;
			$i++;
		}
	
	}
//print_r($newArr);
	$optStr = '<option value="" >Select</option>';
	foreach($newArr as $val)
	{
		$city_name = $val['city'];
		$cityId = $val['id'];
		$optStr = $optStr.'<option value="'.$cityId.'" '.$sel.'>'.$city_name.'</option>';
	}
	echo $optStr;
	
}