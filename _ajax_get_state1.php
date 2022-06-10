<?php
include('config/init.php');
if($_POST['id'])
{
	$id=$_POST['id'];

	$intCatId=$objAdmin->get_state($id);
	//print_r($intCatId);
	//
     $state_all=explode(",",$_POST['state_all']);
	$optStr = '<option value="" >Select</option>';
	foreach($intCatId as $val)
	{
		$state_name = $val['state_name'];
		$stateId = $val['id'];
		$sel='';
		if(in_array($val['id'],$state_all))
		{
			$sel .="selected";
		}
		else
		{
			$sel ='';
		}
		$optStr = $optStr.'<option value="'.$stateId.'" '.$sel.'>'.$state_name.'</option>';
	}
	echo $optStr;
	
}
	
?>