<?php
error_reporting(0);
$conn = new PDO("mysql:host=localhost;dbname=travler_delhi", 'travler_delhi', 'travler_delhi@123'); 
//$conn = new PDO("mysql:host=localhost;dbname=travelcrm", 'root', ''); 
$str='';
extract($_POST);

//print_r($_POST);

	$sql = "SELECT * FROM admin WHERE user_type='Employee'";



$header = '';
$result ='';
$exportData = $conn->query($sql);

$col = "select column_name from information_schema.columns where table_name='admin'";
 $exportCol = $conn->query($col);
 $rowCol = $exportCol->fetchAll(PDO::FETCH_ASSOC);
 foreach($rowCol as $cols)
 {
	// print_r($cols['column_name']);
	if($cols['column_name']=='admin_id')
	{
		$colName='S.No.';
	}
	
	if($cols['column_name']=='name_perfix')
	{
		$colName='Name Prefix';
	}
	if($cols['column_name']=='first_name')
	{
		$colName='First Name';
	}
	if($cols['column_name']=='middle_name')
	{
		$colName='Middle Name';
	}
	if($cols['column_name']=='last_name')
	{
		$colName='Last Name';
	}
	if($cols['column_name']=='username')
	{
		$colName='User Name';
	}
	if($cols['column_name']=='user_id')
	{
		$colName='User Id';
	}
	if($cols['column_name']=='email')
	{
		$colName='Email';
	}
	if($cols['column_name']=='password')
	{
		$colName='Password';
	}
	if($cols['column_name']=='user_password')
	{
		$colName='User Password';
	}
	if($cols['column_name']=='father_name_perfix')
	{
		$colName='Father Name Prefix';
	}
	if($cols['column_name']=='father_first_name')
	{
		$colName='Father First Name';
	}
	if($cols['column_name']=='father_middle_name')
	{
		$colName='Father Middle Name';
	}
	if($cols['column_name']=='father_last_name')
	{
		$colName='Father Last Name';
	}
	if($cols['column_name']=='mother_name_prefix')
	{
		$colName='Mother Name Prefix';
	}
	if($cols['column_name']=='mother_first_name')
	{
		$colName='Mother First Name';
	}
	if($cols['column_name']=='mother_middle_name')
	{
		$colName='Mother Middle Name';
	}
	if($cols['column_name']=='mother_last_name')
	{
		$colName='Mother Last Name';
	}
	if($cols['column_name']=='data_of_birth')
	{
		$colName='D.O.B';
	}
	if($cols['column_name']=='anniversary_date')
	{
		$colName='Anniversary Date';
	}
	if($cols['column_name']=='forget_pass_string')
	{
		$colName='Forget Pass String';
	}
	if($cols['column_name']=='user_type')
	{
		$colName='User Type';
	}
	if($cols['column_name']=='email_address')
	{
		$colName='Additional Email';
	}
	if($cols['column_name']=='designation')
	{
		$colName='Designation';
	}
	if($cols['column_name']=='department')
	{
		$colName='Department';
	}
	if($cols['column_name']=='joining_date')
	{
		$colName='Joining Date';
	}
	if($cols['column_name']=='termination_date')
	{
		$colName='Termination Date';
	}
	if($cols['column_name']=='pan_number')
	{
		$colName='Pan Number';
	}
	if($cols['column_name']=='account_number')
	{
		$colName='Account Number';
	}
	if($cols['column_name']=='account_name')
	{
		$colName='Account Name';
	}
	if($cols['column_name']=='bank')
	{
		$colName='Bank';
	}
	if($cols['column_name']=='branch')
	{
		$colName='Branch';
	}
	if($cols['column_name']=='ifsc')
	{
		$colName='Ifsc Code';
	}
	if($cols['column_name']=='biodata')
	{
		$colName='Biodata';
	}
	if($cols['column_name']=='education_proof')
	{
		$colName='Education Proof';
	}
	if($cols['column_name']=='appontment_letter')
	{
		$colName='Appontment Letter';
	}
	if($cols['column_name']=='pan_card')
	{
		$colName='Pan Card';
	}
	if($cols['column_name']=='photo')
	{
		$colName='Photo';
	}
	if($cols['column_name']=='address_proof')
	{
		$colName='Address Proof';
	}
	if($cols['column_name']=='adhar_card')
	{
		$colName='Adhar Card';
	}
	if($cols['column_name']=='passport')
	{
		$colName='Passport';
	}
	if($cols['column_name']!='ip_address')
	{
		$header .= $colName . "\t";	
	}
	
 }
 $count=1;
while( $row = $exportData->fetch(PDO::FETCH_ASSOC))
{
	//print_r($row);
   
	$line = '';
	if($row['admin_id'])
	{
		$row['admin_id']=$count++;
	}
/* 	if($row['forget_pass_string'])
	{
		$row['forget_pass_string']='';
	}
	if($row['user_type'])
	{
		$row['user_type']='';
	} */
    foreach($row as $key=>$value )
    {  
		
        if ((!isset($value)) || ($value==""))
        {
			//if($value['id'])
			//{
				
				//$value=$count++;
			//}
			//else{
					$value = "\t";
			//}
        } 
        else
        {

            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
		$line .= $value;
    }
    $result .= trim( $line ) . "\n";

}
$result = str_replace( "\r" , "" , $result );
 
if ( $result == "" )
{
    $result = "\nNo Record(s) Found!\n";                        
}
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=export.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
 
?>