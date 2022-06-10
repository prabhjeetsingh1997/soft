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
	$city_all1=explode(",",$_POST['city_all1']);
//print_r($newArr);
	$optStr = '<option value="" >Select</option>';
	foreach($newArr as $val)
	{
		$city_name = $val['city'];
		$cityId = $val['id'];
		$sel='';
		if(in_array($val['id'],$city_all1))
		{
			$sel .="selected";
		}
		else
		{
			$sel ='';
		}
		$optStr = $optStr.'<option value="'.$cityId.'" '.$sel.'>'.$city_name.'</option>';
	}
	echo $optStr;
	
}