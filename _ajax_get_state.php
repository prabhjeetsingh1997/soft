<?php
include('config/init.php');
if($_POST['id'])
{
	$id=$_POST['id'];

	$intCatId=$objAdmin->get_state($id);
	//print_r($intCatId);
	//

	$optStr = '<option value="" >Select</option>';
	foreach($intCatId as $val)
	{
		$state_name = $val['state_name'];
		$stateId = $val['id'];
		$optStr = $optStr.'<option value="'.$stateId.'" '.$sel.'>'.$state_name.'</option>';
	}
	echo $optStr;
	
}
	
?>