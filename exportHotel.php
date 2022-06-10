<?php
include('config/init.php');
	$db = $config['dbname'];
	
	$exportData=$objhotel->getAllHotel();
	
	$rowCol1=$objAdmin->getColName('hotels',$db);
	/* $rowCol2=$objAdmin->getColName('designation',$db);
	$rowCol3=$objAdmin->getColName('department',$db); */
	$rowCol4=$objAdmin->getColName('phone_number',$db);
	
	$rowCol = array_merge($rowCol1,$rowCol4);

	foreach($rowCol as $key=>$val)
	{
		if($val['column_name'] == 'hotel_user_id')
		{
			$colName='Hotel Id';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'hotel_user_pass')
		{
			$colName='Password';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'star_rating')
		{
			$colName='Star Rating';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'primary_email')
		{
			$colName='Email';
			$header .= $colName."\t";
		}
		/* if($val['column_name'] == 'department_name')
		{
			$colName='Department';
			$header .= $colName."\t";
		} */
		/* if($val['column_name'] == 'contact_no')
		{
			$colName='Contact Numbers';
			$header .= $colName."\t";
		} */
		if($val['column_name'] == 'hotel_name')
		{
			$colName='Hotel Name';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'checkin_time')
		{
			$colName='Checkin Time';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'checkout_time')
		{
			$colName='Checkout Time';
			$header .= $colName."\t";
		}
	}
	$otherCols = "S.No\tHotel Name\tLocation\tCity\tState\tCountry\tStar Rating\tHotel ID\tConcerned Person Name\tConcerned Person Contact Nos\tEmail\tPassword\t";
	
	//$otherCols1 = "Designation\tDepartment\t";
	
	//$header = $otherCols.$header;
	$header = $otherCols;
	
	//print_r($exportData);
	
	$count=0;
	foreach($exportData as $key=>$val)
	{
		$count++;
		$line = '';
		
		$hotel_address_details = $objhotel->getHotelAddressById($val['hotel_id'],'hotel_permanent_addr');
		//print_r($hotel_address_details);
		$city = '';
		$country = '';
		$state = '';
		$location = '';
		foreach($hotel_address_details as $hd)
		{
			$arrState=$objAdmin->getStateNameById($hd['state']);
			$arrCity=$objAdmin->getCityById($hd['city']);
			$arrCountry=$objAdmin->getCountryNameById($hd['country']);
			$city = $arrCity[0]['city'];
			$country = $arrCountry[0]['country_name'];
			$state = $arrState[0]['state_name'];
			$location = $hd['address2'];
		}
		
		$concern_prsn=$objhotel->getConcPrsnByid($val['hotel_id']);
		//print_r($concern_prsn_detail);
	
		$conPerName = $concern_prsn[0]['title'].' '.$concern_prsn[0]['first_name'].' '.$concern_prsn[0]['middlename'].' '.$concern_prsn[0]['lastname'];
		
		$phones=$objAdmin->getPhoneNumbers($val['hotel_id'], 'hotel', 'hotel_concern_person');
		//print_r($phones);
		$pHn = '';
		foreach($phones as $numbers)
		{
			$pHn .= $numbers['contact_no'].', ';
		}
		$pHn = rtrim($pHn,', ');
		
		//$attachdoc = $objAdmin->getdocumentbyid($val['admin_id'],'Employee');
		$hotelname = $val['hotel_name'];
		$starRating = $val['star_rating'];
		$hotelid = $val['hotel_user_id'];
		$emails = $val['primary_email'];
		$password = $val['hotel_user_pass'];
		$name = $val['name_perfix'].' '.$val['first_name'].' '.$val['middle_name'].' '.$val['last_name'];
		
		$otherCols = "S.No\tHotel Name\tLocation\tCity\tState\tCountry\tStar Rating\tHotel ID\tConcerned Person Name\tConcerned Person Contact Nos\tEmail\tPassword\t";
		
		$otherVal = $count."\t".$hotelname."\t".$location."\t".$city."\t".$state."\t".$country."\t".$starRating."\t".$hotelid."\t".$conPerName."\t".$pHn."\t".$emails."\t".$password."\t";
		
		//print_r($val);
		foreach($val as $key=>$value){
			
			if($key == 'hotel_id' || $key == 'name_perfix' || $key == 'first_name' || $key == 'middle_name' || $key == 'last_name' || $key == 'additional_email_address' || $key == 'hotel_type' || $key == 'anniversary_date' || $key == 'base_currency' || $key == 'description' || $key == 'transport_id' || $key == 'hotel_amenity' || $key == 'pancard_no' || $key == 'account_no' || $key == 'bank_name' || $key == 'branch_name' || $key == 'ifsc_code' || $key == 'pancard_attch' || $key == 'photo_attch' || $key == 'contract_attch' || $key == 'termination_date' || $key == 'pan_number' || $key == 'account_number' || $key == 'account_name' || $key == 'bank' || $key == 'branch' || $key == 'ifsc' || $key == 'biodata' || $key == 'education_proof' || $key == 'appontment_letter' || $key == 'pan_card' || $key == 'photo' || $key == 'address_proof' || $key == 'adhar_card' || $key == 'passport' || $key == 'designation_id' || $key == 'designation_name' || $key == 'status' || $key == 'id' || $key == 'panel_id' || $key == 'panel_name' || $key == 'contact_no' || $key == 'code' || $key == 'valid_no' || $key == 'type' || $key == 'ip_address' || $key == 'designation' || $key == 'department')
			{
				
			}
			else
			{
				if($key == 'password')
				{
					$value = base64_decode($value);
				}
				$value = str_replace( '"','""' , $value );
				$value = '"'. $value .'"'."\t";
				$line .= $value;
			}
			
			//$line .= $value;
		}
		//$line = $otherVal.$line.$otherVal1;
		$line = $otherVal;
		$result .= trim( $line ) . "\n";
		//echo $result = $otherVal.$result;
		//echo '<br/><br/>';
	}
	$result = str_replace( "\r" , "" , $result);
	//die;
	if ($result == "")
	{
		$result = "\nNo Record(s) Found!\n";                        
	}

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=hotels.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$result";	
?>