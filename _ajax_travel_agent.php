<?php
include('config/init.php');
@extract($_POST);
//print_r($_POST);

if($type == 'add_travel_client_detail')
{
	//print_r($_POST);
	//die;
	
	$agent_client_detail = $objtravel->travel_client_detail($_POST);
	if($agent_client_detail)
	{
		 $_SESSION['travelId'] =$agent_client_detail;
	}
	echo $travelAgentId=$_SESSION['travelId'];
	for($i=1; $i<=$item_count5; $i++)
	{
		$address = $_POST['address_'.$i];
		$address_line = $_POST['addressline_'.$i];
		$country = $_POST['country_'.$i];
		$city = $_POST['city_'.$i];
		$state = $_POST['state_'.$i];
		$pin_code = $_POST['pincode_'.$i];
		$address_id = $_POST['clntAddrid_'.$i];
		//echo $address;exit;
		if(!empty($editTravelid)){
			echo $clnt_addr_detail = $objtravel->travel_agent_address_detail($address_id,$address,$address_line,$country,$city,$state,$pin_code,$editTravelid,'travel_agent_client_address');
		}else{
			echo $clnt_addr_detail = $objtravel->travel_agent_address_detail($address_id,$address,$address_line,$country,$city,$state,$pin_code,$travelAgentId,'travel_agent_client_address');
		}
	}  
	
	for($i=1; $i<=$item_count3; $i++)
	{
		$userPhone 			= $_POST['userPhone_'.$i];
		$code	    		= $_POST['code_'.$i];
		$number				= $_POST['last_'.$i];
		$numberId           = $_POST['tra_clnt_num_id_'.$i];
		if(!empty($editTravelid)){
			
		echo $travel_contact_detail = $objtravel->travel_agent_contact_detail($numberId,$userPhone,$code,$editTravelid,'travel_agent_num');
		}else{
		echo $travel_contact_detail = $objtravel->travel_agent_contact_detail($numberId,$userPhone,$code,$travelAgentId,'travel_agent_num');
		}
	} 
	// if(!empty($editTravelid))
	// {
	// 	$deleteTravImg=$objtravel->deleteTravelImgByTravelId($editTravelid);
	// 	for($i=1; $i<=$item_count1; $i++)
	// 	{
	// 		$stype 				= $_POST['stype_'.$i];
	// 		$sDescription	    = $_POST['sDescription_'.$i];
	// 		$AminitiesF			= $_POST['AminitiesF_'.$i];
	// 		$Units				= $_POST['Units_'.$i];
	// 		$Pics				= $_POST['serviceImg_'.$i];
	// 		$srvDetailId        = $_POST['servDetailId_'.$i];
	// 		echo $service_detail = $objtravel->travel_agent_services_detail($srvDetailId,$stype,$sDescription,$AminitiesF,$Units,$Pics,$editTravelid);
	// 		if($service_detail)
	// 		{
	// 			$serviceImg=explode(",",rtrim($Pics,','));
	// 			foreach($serviceImg as $key=>$value)
	// 			{
	// 				$travelServiceImg=$objtravel->addTravelServicePic($editTravelid,$service_detail,$value);
	// 			}
	// 		}
	// 	}
	// }
	// else
	// {
	// 	for($i=1; $i<=$item_count1; $i++)
	// 	{
	// 	$stype 				= $_POST['stype_'.$i];
	// 	$sDescription	    = $_POST['sDescription_'.$i];
	// 	$AminitiesF			= $_POST['AminitiesF_'.$i];
	// 	$Units				= $_POST['Units_'.$i];
	// 	$Pics				= $_POST['serviceImg_'.$i];
	// 	$srvDetailId        = $_POST['servDetailId_'.$i];
		
	// 	echo $service_detail = $objtravel->travel_agent_services_detail($srvDetailId,$stype,$sDescription,$AminitiesF,$Units,$Pics,$travelAgentId);
	// 		if($service_detail)
	// 		{
	// 			$serviceImg=explode(",",rtrim($Pics,','));
	// 			foreach($serviceImg as $key=>$value)
	// 			{
	// 				$travelServiceImg=$objtravel->addTravelServicePic($travelAgentId,$service_detail,$value);
	// 			}
	// 		}
	// 	}
	// }
}
if($type == 'add_travel_query_detail')
{
	print_r($_POST);
	//die;
	if(!empty($editTravelid)){
		echo $query_detail = $objtravel->travel_query_detail($editTravelid,$_POST);
	}else{
		echo $query_detail = $objtravel->travel_query_detail($_SESSION['travelId'],$_POST);
	}
	for($i=1; $i<=$concpeople4; $i++)
	{
		$title 			    = $_POST['title_'.$i];
		$firstname 			= $_POST['firstname_'.$i];
		$middle	   		    = $_POST['middle_'.$i];
		$lastname			= $_POST['lastname_'.$i];
		$concPrsnId         = $_POST['concPrsnId_'.$i];
		if(!empty($editTravelid)){
			echo $concern_prsn_detail = $objtravel->travel_agent_detail($concPrsnId,$title,$firstname,$middle,$lastname,$editTravelid);
		}else{
			echo $concern_prsn_detail = $objtravel->travel_agent_detail($concPrsnId,$title,$firstname,$middle,$lastname,$_SESSION['travelId']);
		}
	}
	
	for($i=1; $i<=$contact3; $i++)
	{
		$userPhone 			= $_POST['userPhone_'.$i];
		$code	    		= $_POST['code_'.$i];
		$number				= $_POST['last_'.$i];
		$numberId           = $_POST['concPrsnNumId_'.$i];
		if(!empty($editTravelid)){
			echo $query_number = $objtravel->travel_agent_contact_detail($numberId,$userPhone,$code,$editTravelid,'travel_query_num');
		}else{
			echo $query_number = $objtravel->travel_agent_contact_detail($numberId,$userPhone,$code,$_SESSION['travelId'],'travel_query_num');
		}
		
		
	} 
}
if($type == 'add_travel_bank_detail')
{
	//print_r($_POST);
	
	if(!empty($editTravelid)){
		$travel_bank_detail = $objtravel->travel_bank_detail($editTravelid,$_POST);
	}else{
		$travel_bank_detail = $objtravel->travel_bank_detail($_SESSION['travelId'],$_POST);
	}
	if($travel_bank_detail)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

if($type == 'add_travel_doc_detail')
{
	//print_r($_POST);
	//die;
	
	$recordId = $editTravelid;
	if($editTravelid == '')
	{
		$recordId = $_SESSION['travelId'];
	}
	
	$docname=array();
	for($i=0;$i<count($docFileName);$i++){
		
		$fileName = $docFileName[$i];
		$uploadedDoc = $upldFileName[$i];
		$docId = $attachEdId[$i];
		if($uploadedDoc != '')
		{
			$saveDoc=$objtravel->travel_doc_detail($recordId,$fileName,$uploadedDoc,$docId);
		}	
	}
	
	if($saveDoc){
		$html['status'] ='1';
	}else{
		$html['status'] ='2';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die;
}

if($type == 'travel_agent_rates_detail')
{
	//print_r($_POST);
	//die;
	$fromdate= date("Y-m-d", strtotime($_POST['fromdate_1']));
	$todate=date("Y-m-d", strtotime($_POST['todate_1']));
	$serviceDateid=$_POST['dateRateId_1'];
	//$serviceDateid='';
	$description=$_POST['description_1'];
	if(!empty($editTravelid))
	{
		$date_detail=$objtravel->travel_agent_date_detail($fromdate,$todate,$description,$editTravelid,$serviceDateid);
	}
	else
	{
		$date_detail=$objtravel->travel_agent_date_detail($fromdate,$todate,$description,$_SESSION['travelId'],$serviceDateid);
	}
	
	$date_Id=$date_detail;
	
	for($i=1; $i<=$service_count; $i++)
	{
		$k=2;
		for($j=1;$j<=$total__rates_itmes;$j++)
		{
			$serviceTypeId=$_POST['serviceTypeId_1_'.$i.'_'.$k];
			$servicePrice=$_POST['servicePrice_1_'.$i.'_'.$k];
			$serviceRateId=$_POST['serviceRateId_1_'.$i.'_'.$k];
			$serviceNameId=$_POST['serviceNameId_1_'.$i.'_1'];
			//echo "<br/>";
			if(!empty($editTravelid))
			{
				$addServiceRates=$objtravel->travler_date_rates($editTravelid,$date_Id,$serviceNameId,$serviceTypeId,$servicePrice,$serviceRateId);
			}
			else
			{
				$addServiceRates=$objtravel->travler_date_rates($_SESSION['travelId'],$date_Id,$serviceNameId,$serviceTypeId,$servicePrice,$serviceRateId);
			}
			
			$k++;
		}
	} 
}

/*if($type == 'delete_travel_items')
{
	
	 
	echo $delete = $objtravel->deleteTravelAgentById($id);
}*/

if($type == 'delete_travel_items')
{
	echo $delete = $objtravel->delte_travel_items($id);
}

if($type == 'delete_travel_items1')
{
	echo $delete = $objtravel->delte_travel_items1($id);
}

if($type == 'delete_travel_items2')
{
	echo $delete = $objtravel->delte_travel_items2($id);
}


if($_GET['action'] == 'delAttach'){
	//print_r($_POST);
	extract($_POST);
	$deleteAttach=$objtravel->delete_travel_doc_attachment($attachId);
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
if($_REQUEST['action'] == 'deleteTravelImg')
{
	//print_r($_POST);
	//echo $imageId;
	$deleteImg=$objtravel->deleteServiceImgById($imageId);
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