<?php
include('config/init.php');
@extract($_POST);
//print_r($_POST);

if($type == 'add_transport_client_detail')
{
	//print_r($_POST);
	//die;
	$editTransId=$_POST['editTransporterId'];
	echo $transp_client_detail = $objtransporter->transporter_client_detail($_POST);
	if($transp_client_detail)
	{
		$_SESSION['transporterId'] =$transp_client_detail;
		$transporterId=$_SESSION['transporterId'];
		
		if(!empty($editTransId))
		{
			/* ADD/UPDATE TRANSPORT CLIENT ADDRESS DETAIIL*/
			$trans_client_addr=$objtransporter->transporter_client_adderess($editTransId, $_POST, 'trans_clnt_prmnt_add');
			
			/* ADD/UPDATE TRANSPORT CLIENT PHONE DETAIIL*/
			$trans_client_number=$objtransporter->transporter_client_phone_numbers($editTransId, $_POST, 'trans_clnt_num');
			
			/* ADD/UPDATE TRANSPORT VEHICLE SERVICES DETAIIL*/
			$vehicle_desc=$objtransporter->vehicle_services_detail($editTransId, $_POST);
		}
		else
		{
			/* ADD/UPDATE TRANSPORT CLIENT ADDRESS DETAIIL*/
			$trans_client_addr=$objtransporter->transporter_client_adderess($transporterId, $_POST, 'trans_clnt_prmnt_add');
			
			/* ADD/UPDATE TRANSPORT CLIENT PHONE DETAIIL*/
			$trans_client_number=$objtransporter->transporter_client_phone_numbers($transporterId, $_POST, 'trans_clnt_num');
			
			/* ADD/UPDATE TRANSPORT VEHICLE SERVICES DETAIIL*/
			$vehicle_desc=$objtransporter->vehicle_services_detail($transporterId, $_POST);
		}
		
	}
}
if($type == 'add_transport_query_detail')
{
	//print_r($_POST);
	//echo $_SESSION['transporterId'];
	$query_detail = $objtransporter->transporter_query_detail($_SESSION['transporterId'],$_POST);
	
	$trans_query_number=$objtransporter->transporter_client_phone_numbers($_SESSION['transporterId'], $_POST, 'trans_query_num','transporter');
	
	/* Add/update hotel Concern person details */
	$concern_person_detail=$objtransporter->concern_person_detail($_SESSION['transporterId'],$_POST,'Transporter');
}

if($type == 'add_transporter_bank_detail')
{
	/* ADD/UPDATE TRANSPORTER BANK DETAIL*/
	$transporter_bank_detail = $objtransporter->transporter_bank_detail($_SESSION['transporterId'],$_POST);
	
}

if($type == 'add_transporter_doc_detail')
{
	//print_r($_POST);
	//die;
	$docname=array();
	$countDoc=count($docFileName);
	for($i=0;$i<$countDoc;$i++){
		$documentName=$docFileName[$i];
		$document=$upldFileName[$i];
		$docId=$attachEdId[$i];
		if(!empty($editTransporterId))
		{
			$saveDoc=$objtransporter->transporter_doc_detail($editTransporterId,$documentName,$document,$docId);
		}
		else
		{
			$saveDoc=$objtransporter->transporter_doc_detail($_SESSION['transporterId'],$documentName,$document,$docId);
		}
	}
	if($saveDoc)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
if($_GET['action'] == 'delAttach'){
	//print_r($_POST);
	extract($_POST);
	$deleteAttach=$objtransporter->delete_transporter_doc_attachment($attachId);
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
if($type == 'add_transporter_rates_detail')
{
	//print_r($_POST);
	//die;
	$fromdate= date("Y-m-d", strtotime($_POST['fromdate_1']));
	$todate=date("Y-m-d", strtotime($_POST['todate_1']));
	$fleetDateid=$dateRateId[0];
	$description=$_POST['description_1'];
	if(!empty($editTransporterId))
	{
		$date_detail=$objtransporter->transporters_date_detail($fromdate,$todate,$description,$editTransporterId,$fleetDateid);
	}
	else
	{
		$date_detail=$objtransporter->transporters_date_detail($fromdate,$todate,$description,$_SESSION['transporterId'],$fleetDateid);
	}
	
	$date_Id=$date_detail;
	
	for($i=1; $i<=$fleet_count; $i++)
	{
		$k=2;
		for($j=1;$j<=$total__rates_itmes;$j++)
		{
			$fleetTransId=$_POST['fleetTypeId_1_'.$i.'_'.$k];
			$fleetPrice=$_POST['fleetPrice_1_'.$i.'_'.$k];
			$fleetRateId=$_POST['fleetRateId_1_'.$i.'_'.$k];
			$fleetTransNameId=$_POST['fleetNameId_1_'.$i.'_1'];
			//echo "<br/>";
			if(!empty($editTransporterId))
			{
				$addFleetRates=$objtransporter->transporter_rates($editTransporterId,$date_Id,$fleetTransNameId,$fleetTransId,$fleetPrice,$fleetRateId);
			}
			else
			{
				$addFleetRates=$objtransporter->transporter_rates($_SESSION['transporterId'],$date_Id,$fleetTransNameId,$fleetTransId,$fleetPrice,$fleetRateId);
			}
			
			$k++;
		}
	} 
}
if($_REQUEST['action'] == 'deleteTransImg')
{
	//print_r($_POST);
	//echo $imageId;
	$deleteImg=$objtransporter->deleteFleetImgById($imageId);
	if($deleteImg)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>