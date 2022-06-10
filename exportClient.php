<?php
include('config/init.php');
	$db = $config['dbname'];
	
	$exportData=$objclient->client_list();
	
	$rowCol1=$objAdmin->getColName('clients',$db);
	/* $rowCol2=$objAdmin->getColName('designation',$db);
	$rowCol3=$objAdmin->getColName('department',$db); */
	$rowCol4=$objAdmin->getColName('phone_number',$db);
	
	$rowCol = array_merge($rowCol1,$rowCol4);
	
	foreach($rowCol as $key=>$val)
	{
		if($val['column_name'] == 'client_login_id')
		{
			$colName='Client Id';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'client_login_password')
		{
			$colName='Password';
			$header .= $colName."\t";
		}
		if($val['column_name'] == 'organization')
		{
			$colName='Organization';
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
		if($val['column_name'] == 'email')
		{
			$colName='Email';
			$header .= $colName."\t";
		}
	}
	$otherCols = "S.No\tName\tContact Numbers\t";
	
	//$otherCols1 = "Designation\tDepartment\t";
	
	$header = $otherCols.$header.$otherCols1;
	
	//print_r($exportData);
	
	$count=0;
	foreach($exportData as $key=>$val)
	{
		$count++;
		$line = '';
		
		/* $designId=$val['designation'];
		$departId=$val['department'];
		$arrDesignation=$objAdmin->getDesignationById($designId);
		$arrDepartment=$objAdmin->getDepartmentById($departId); */
		
		$phones=$objAdmin->getPhoneNumbers($val['client_id'], 'client', 'client_personal');
		//print_r($phones);
		$pHn = '';
		foreach($phones as $numbers)
		{
			$pHn .= $numbers['contact_no'].', ';
		}
		$pHn = rtrim($pHn,', ');
		
		//$attachdoc = $objAdmin->getdocumentbyid($val['admin_id'],'Employee');
		
		$name = $val['name_perfix'].' '.$val['first_name'].' '.$val['middle_name'].' '.$val['last_name'];
		
		//$otherCols = "S.No\tName\tContact Numbers\t";
		$otherVal = $count."\t".$name."\t".$pHn."\t";
		
		/* $designation = $arrDesignation[0]['designation_name'];
		$department = $arrDepartment[0]['department_name'];
		
		$otherVal1 = $designation."\t".$department."\t"; */
		
		//print_r($val);
		foreach($val as $key=>$value){
			
			if($key == 'client_id' || $key == 'name_perfix' || $key == 'first_name' || $key == 'middle_name' || $key == 'last_name' || $key == 'additional_email_address' || $key == 'data_of_birth' || $key == 'anniversary_date' || $key == 'job_title' || $key == 'company_email_address' || $key == 'refrence' || $key == 'salse_reprenstive' || $key == 'mother_middle_name' || $key == 'mother_last_name' || $key == 'data_of_birth' || $key == 'anniversary_date' || $key == 'forget_pass_string' || $key == 'user_type' || $key == 'email_address' || $key == 'joining_date' || $key == 'termination_date' || $key == 'pan_number' || $key == 'account_number' || $key == 'account_name' || $key == 'bank' || $key == 'branch' || $key == 'ifsc' || $key == 'biodata' || $key == 'education_proof' || $key == 'appontment_letter' || $key == 'pan_card' || $key == 'photo' || $key == 'address_proof' || $key == 'adhar_card' || $key == 'passport' || $key == 'designation_id' || $key == 'designation_name' || $key == 'status' || $key == 'id' || $key == 'panel_id' || $key == 'panel_name' || $key == 'contact_no' || $key == 'code' || $key == 'valid_no' || $key == 'type' || $key == 'ip_address' || $key == 'designation' || $key == 'department')
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
		$line = $otherVal.$line.$otherVal1;
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
	header("Content-Disposition: attachment; filename=Clients.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$result";	
?>