<?php
include('config/init.php');
@extract($_POST);	
if($type == 'add_client_prsnl_detail'){
	$prsnl_detail = $objclient->client_prsnl_detail($_POST);
	if($prsnl_detail){
		$_SESSION['clientId'] = $prsnl_detail;
		$clientId=$_SESSION['clientId'];
		if(!empty($editId))
		{
			$objclient->client_phone_numbers($editId, $_POST, 'client_personal', 'client');
			$objclient->client_adderess_numbers($editId, $_POST, 'client_personal');
		}
		else
		{
			$objclient->client_phone_numbers($clientId, $_POST, 'client_personal', 'client');
			$objclient->client_adderess_numbers($clientId, $_POST, 'client_personal');
		}	
	}else{
		echo "Sorry, Data could't not be inserted.";	
	} 
}


if($type == 'add_client_company_detail'){
	print_r($_POST);
	$cPhone = count(array_filter($userPhone));
	$cCountry = count(array_filter($userCountry));
	$cCity = count(array_filter($usercity));
	$cState = count(array_filter($userState));
	
	if(!empty($editId))
	{
		$prsnl_detail = $objclient->client_company_detail($editId, $_POST);
		if($cPhone > 0)
		{
			$objclient->client_phone_numbers($editId, $_POST, 'client_company', 'client');
		}
		if($cCountry > 0 && $cState > 0)
		{
			$objclient->client_adderess_numbers($editId, $_POST, 'client_company');
		}
	}
	else
	{
		//print_r($_POST);
		$prsnl_detail = $objclient->client_company_detail($_SESSION['clientId'], $_POST);
		if($cPhone > 0)
		{
			$objclient->client_phone_numbers($_SESSION['clientId'], $_POST, 'client_company', 'client');
		}
		if($cCountry > 0 && $cState > 0)
		{
			$objclient->client_adderess_numbers($_SESSION['clientId'], $_POST, 'client_company');	
		}
	}
}

if($type == 'add_client_offical_detail'){
	if(!empty($editId))
	{
		$prsnl_detail = $objclient->client_offical_detail($editId, $_POST);
	}
	else
	{
		$prsnl_detail = $objclient->client_offical_detail($_SESSION['clientId'], $_POST);	
	}
}

if($type == 'add_client_bank_detail'){
	if(!empty($editId))
	{
		$prsnl_detail = $objclient->client_bank_detail($editId, $_POST);
	}
	else
	{
		$prsnl_detail = $objclient->client_bank_detail($_SESSION['clientId'], $_POST);	
	}
}
if($type == 'add_client_doc_detail')
{
	extract($_POST);
	
	$recordId = $editId;
	if($userId == '')
	{
		$recordId = $_SESSION['clientId'];
	}
	
	//$docname=array();
	for($i=0;$i<count($docFileName);$i++){
		$fileName = $docFileName[$i];
		$uploadedDoc = $upldFileName[$i];
		$docId = $attachEdId[$i];
		if($uploadedDoc != '')
		{
			//echo $docId.'===='.$fileName.'====='.$uploadedDoc.'<br/>';
			$saveDoc=$objclient->client_doc_detail($recordId,$fileName,$uploadedDoc,$docId);
		}
	}
	if($saveDoc){
		$html['status'] ='1';
	}else{
		//$html['msg'] = "<div class='alert alert-danger' style='text-align:center;'>Problem in Removing Image.</div>";	
		$html['status'] ='1';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die;
}
if($_GET['action'] == 'delAttach'){
	//print_r($_POST);
	extract($_POST);
	$deleteAttach=$objclient->delete_clnt_attachment($attachId);
	if($deleteAttach){
		//unlink($fileName);
		$html['status'] ='1';
	}else{
		//$html['msg'] = "<div class='alert alert-danger' style='text-align:center;'>Problem in Removing Image.</div>";	
		$html['status'] ='2';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die; 
}

?>