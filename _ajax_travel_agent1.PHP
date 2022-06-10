<?php
include('config/init.php');
@extract($_POST);
//print_r($_POST);

if($type == 'add_travel_client_detail')
{
	print_r($_POST);
	echo $prsnl_detail = $objtravel->travel_client_detail($_POST);
	if($prsnl_detail)
	{
		 $_SESSION['travelId'] =$prsnl_detail;
		//echo $prsnl_detail;
	}
	for($i=1; $i<=$item_count5; $i++)
	{
	
		$address 			= $_POST['addressl_'.$i];
		$address_line	    = $_POST['addressline_'.$i];
		$city				= $_POST['city_'.$i];
		$state				= $_POST['state_'.$i];
		$pin_code			= $_POST['pincode_'.$i];
		
		echo $prsnl_detail = $objtravel->travel_agent_address_detail($address,$address_line,$city,$state,$pin_code);
		
		
		
	}
}
if($type == 'add_travel_query_detail')
{
	echo $prsnl_detail = $objtravel->travel_query_detail($_POST);
	
}

if($type == 'add_travel_bank_detail')
{
	
	echo $prsnl_detail = $objtravel->travel_bank_detail($_POST);
	
}

if($type == 'add_hotel_doc_detail')
{
	//print_r($_POST);
	echo $prsnl_detail = $objhotel->hotel_doc_detail($_POST);
	
}
/* if($type == 'add_hotel_rates_detail')
{
		print_r($_POST);
		
	$hotelId   = $_POST['hotel_id'];
   
	for($i=1; $i<=$item_count; $i++)
	{
		$itemName  						    = $_POST['item_'.$i];			
		$single_deluxe 						= $_POST['single_deluxe_'.$i];
		$single_premium 					= $_POST['single_premium_'.$i];
		$sinlge_metroview 					= $_POST['sinlge_metroview_'.$i];	
		$double_deluxe 						= $_POST['double_deluxe_'.$i];
		$double_premium 					= $_POST['double_premium_'.$i];	
		$double_mertoview 					= $_POST['double_mertoview_'.$i];
		$extra_deluxe 						= $_POST['extra_deluxe_'.$i];	
		$extra_premium 						= $_POST['extra_premium_'.$i];
		$extra_metroview 					= $_POST['extra_metroview_'.$i];	
		$extro_child_deluxe 				= $_POST['extro_child_deluxe_'.$i];
		
	
		echo $prsnl_detail = $objtravel->hotel_rate_detail($_POST);
	
	}
} */

if($type == 'travel_agent_rates_detail')
{
		print_r($_POST);
		
		//lunch_deluxe_3_7_2 == table_row_itme
	$hotelId   = $_POST['travel_agent_id'];
	/* $fromdate = date("Y-m-d", strtotime($fromdate));
	$todate = date("Y-m-d", strtotime($todate)); */
	//echo strtodate($valid_from, 'yyyy-mm-dd');
	for($i=1; $i<=$item_count9; $i++)
	{
	
		$fromdate 		= 	date("Y-m-d", strtotime($_POST['fromdate_'.$i]));
		$todate	    	= 	date("Y-m-d", strtotime($_POST['todate_'.$i]));
		$description	    = 	$_POST['description_'.$i];
		echo $prsnl_detail = $objtravel->travel_agent_date_detail($fromdate,$todate,$description);
		
		for($j=1; $j<=$total__rates_itmes; $j++)
		{
		//echo $i.'_'.$j.'_1';
			/* echo 	'<br/>'.$LidID = $_POST['LidID_'.$i.'_'.$j.'_1'];
			echo	'<br/>'.$Service1 = $_POST['Innova_'.$i.'_'.$j.'_2'];
			echo 	'<br/>'.$Service2 = $_POST['Indigo_'.$i.'_'.$j.'_3'];
			echo 	'<br/>'.$Service3 = $_POST['Traveller_'.$i.'_'.$j.'_4'];
			echo '<br/><br/><br/>'; */ 
			
				$LidID = $_POST['LidID_'.$i.'_'.$j.'_1'];
				$Service1 = $_POST['Innova_'.$i.'_'.$j.'_2'];
			 	$Service2 = $_POST['Indigo_'.$i.'_'.$j.'_3'];
			 	$Service3 = $_POST['Traveller_'.$i.'_'.$j.'_4'];	
			    echo '<br/>';
		echo $prsnl_detail = $objtravel->travler_date_rates($LidID,$Service1,$Service2,$Service3,$hotelId);
					
		}
		
	} 
	
}



?>









