<?php
include('config/init.php');
if($_GET['action'] == 'massDelete'){
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->dsk_leads_mass_delete($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if($_GET['action'] == 'massMove'){
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->dsk_leads_mass_move($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'massLeads') {
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->massLeads($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'fromPayment') {
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->massFromPayment($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'fromCancelled') {
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->massFromCancelled($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'massMovePayment') {
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->dsk_leads_mass_move_payment($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'massCancelled') {
	foreach ($_POST as $key) {
		$data = $key; 
	}
	$dsk_detail = $objAdmin->dsk_leads_mass_cancelled($data);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'massEmail') {
	$data = json_decode($_POST['ids'], TRUE);
	$dsk_detail = $objAdmin->dsk_leads_mass_mail($data,$_POST['content'],$_FILES['bulkattachment']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'move_payment_to_photo') {
	$dsk_detail = $objAdmin->move_individual_payment_to_photo($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'move_cancel_to_photo') {
	$dsk_detail = $objAdmin->move_individual_cancel_to_photo($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'move_cancel_to_payment') {
	$dsk_detail = $objAdmin->move_individual_cancel_to_payment($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'move_cancel_to_leads') {
	$dsk_detail = $objAdmin->move_individual_cancel_to_leads($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'move_leads_to_photo') {
	$dsk_detail = $objAdmin->move_individual_leads_to_photo($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'movetosecond') {
	$dsk_detail = $objAdmin->move_individual_photo_to_payment($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'cancelData') {
	$dsk_detail = $objAdmin->dsk_leads_cancel_data($_POST);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'Mail') {
	$dsk_detail = $objAdmin->send_individual_mail($_POST['id'],$_POST['email'],$_FILES['attachment']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'movetoleads') {
	$dsk_detail = $objAdmin->move_individual_photo_to_leads($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'move_payment_to_leads') {
	$dsk_detail = $objAdmin->move_individual_payment_to_leads($_POST['leadid']);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
if ($_GET['action'] == 'changeRowColor') {
	$dsk_detail = $objAdmin->change_dsk_row_color($_POST);
	if($dsk_detail == true)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if ($_GET['action'] == 'changeBulkColor') {
	
	$dsk_detail = $objAdmin->dsk_leads_mass_change_color($_POST['leadsid'],$_POST['code']);
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