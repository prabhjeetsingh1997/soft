<?php
    $realpath = 'adminConfig/init.php';
    include($realpath);
//include('soft/adminConfig/init.php');

extract($_POST);
if($_GET['action']=='login')
{
    $login = $objAdmin->login($email,$password,$userType,$partner_url);
	
	if ($login === false){
		echo 0;
		$errors[] = 'Sorry, that username/password is invalid';
	}else {
		$row=$login;		
		$_SESSION['admin_Id'] =$row[0]['admin_id'];
		$_SESSION['user_type'] =$row[0]['user_type'];
		$_SESSION['employee_type'] =$row[0]['employee_type'];
		$_SESSION['employee_Id'] =$row[0]['user_id'];
		$_SESSION['admin_Email'] =$email;
		
		echo 1;
		exit();
	}
}
else if($_GET['action'] == 'addUser'){
	//print_r($_POST);
	//die;
	extract($_POST);
	//$users=$objAdmin->email_exists($email);
	
	$adduser = $objAdmin->adduser($_POST);
	
	if($adduser){
		//$_SESSION['employee_id'] = $adduser;	
		//print_r($_POST);
		//die;
		$pramAddArr = array();
		$currAddArr = array();
		$emrContactArr = array();
		$userContactArr = array();
		$usrEmailArr = array();
		$usrEmailArr = array();
		
		$employee_id = $adduser;
		$_SESSION['added_emp_id'] = $adduser;
		$empId=$_SESSION['added_emp_id'];
		$_SESSION['employee_id'] = $employee_id;
		
		for($l=0; $l<count(array_filter($userMobile)); $l++){
			$updUser = $objAdmin->addUserContactDetails($empId,$userMobile[$l],$code[$l],'personal','employee');

		}
		
		for($l=0;$l<count(array_filter($EmergencyMObNum)); $l++){
			$updUser = $objAdmin->addUserContactDetails($empId,$EmergencyMObNum[$l],$EmrCode[$l],'Emergency','employee');
		}
		
		for($l=0;$l<count(array_filter($pramAdd1)); $l++){
			$updUser = $objAdmin->addUserAddressDetails($empId,$pramAdd1[$l],$pramAdd2[$l],$pramCountry[$l],$pramCity[$l],$pramState[$l],$pramPin[$l],'Permanent', 'Employee');
		}
		
		for($l=0;$l<count(array_filter($currAdd1)); $l++){
			$updUser = $objAdmin->addUserAddressDetails($empId,$currAdd1[$l],$currAdd2[$l],$currCountry[$l],$currCity[$l],$currState[$l],$currPin[$l],'Current', 'Employee');
		}
		
		/* for($m=0;$m<count(array_filter($userEmail)); $m++){
			$usrEmailArr[] = $userEmail[$m];
		}
		
		$usrEmailArr = json_encode($usrEmailArr);
		$updUser = $objAdmin->addUserInfo($adduser,$employee_id, $usrEmailArr); */
		
		echo 1;
		die;
		exit();
	}
	else
	{
		 echo 0;
		 exit();
	}
}

else if($_GET['action'] == 'editUser')
{
	extract($_POST);
	//print_r($_POST);
	//die;
	$adduser = $objAdmin->edituser($_POST);
	if($adduser)
	{
		//$_SESSION['employee_id'] = $adduser;
		
		$pramAddArr = array();
		$currAddArr = array();
		$emrContactArr = array();
		$userContactArr = array();
		$usrEmailArr = array();
		$usrEmailArr = array();
		
		$employee_id = 'LiDE0'.$adduser;
		$_SESSION['added_emp_id'] = $adduser;
		$empId=$_SESSION['added_emp_id'];
		$_SESSION['employee_id'] = $employee_id;
		
		for($l=0;$l<count(array_filter($userMobile)); $l++)
		{
			$updUser = $objAdmin->edituserContactDetails($contactNumId[$l],$userId,$userMobile[$l],$code[$l],'personal','employee');

		}
		for($l=0;$l<count(array_filter($EmergencyMObNum)); $l++)
		{
			$updUser = $objAdmin->edituserContactDetails($emergNumId[$l],$userId,$EmergencyMObNum[$l],$EmrCode[$l],'Emergency','employee');
		}
		for($l=0;$l<count(array_filter($pramAdd1)); $l++)
		{
			$updUser = $objAdmin->edituserAddressDetails($prmntAddrId[$l],$userId,$pramAdd1[$l],$pramAdd2[$l],$pramCountry[$l],$pramCity[$l],$pramState[$l],$pramPin[$l],'Permanent','Employee');
		}
		for($l=0;$l<count(array_filter($currAdd1)); $l++)
		{
			$updUser = $objAdmin->edituserAddressDetails($currAddId[$l],$userId,$currAdd1[$l],$currAdd2[$l],$currCountry[$l],$currCity[$l],$currState[$l],$currPin[$l],'Current','Employee');
		}
		/* for($m=0;$m<count(array_filter($userEmail)); $m++)
		{
			$usrEmailArr[] = $userEmail[$m];
		}
		$usrEmailArr = json_encode($usrEmailArr);
		$updUser = $objAdmin->addUserInfo($adduser,$employee_id, $usrEmailArr); */
		
		echo 1;
		exit();
	}
	else
	{
		 echo 0;
		 exit();
	}
}


else if($_GET['action'] == 'official_detail')
{
	extract($_POST);
	if(!empty($userId)){
		echo $updUserOfficial = $objAdmin->addEmpOfficialDetail($userId, $designation, $department, $joingDate, $terminationDate,$userPass,$empType);
	}else{
		echo $updUserOfficial = $objAdmin->addEmpOfficialDetail($_SESSION['added_emp_id'], $designation, $department, $joingDate, $terminationDate,$userPass,$empType);
	}
}
else if($_GET['action'] == 'banking_detail')
{
	extract($_POST);
	if(!empty($userId)){
		echo $updUserOfficial = $objAdmin->addEmpBakingDetail($userId, $panNum, $accNumber, $accName, $bank, $branch, $ifsc);
	}else{
		echo $updUserOfficial = $objAdmin->addEmpBakingDetail($_SESSION['added_emp_id'], $panNum, $accNumber, $accName, $bank, $branch, $ifsc);
	}
}
else if($_GET['action'] == 'documents')
{
	//print_r($_POST);
	//die;
	$recordId = $userId;
	if($userId == '')
	{
		$recordId = $_SESSION['added_emp_id'];
	}
	
	//echo $_SESSION['added_emp_id'];
	$docname=array();
	for($i=0;$i<count($docFileName);$i++){
		//print_r($upldFileName);exit;
		$fileName = $docFileName[$i];
		$uploadedDoc = $upldFileName[$i];
		$docId = $attachEdId[$i];
		if($uploadedDoc != '')
		{
			$saveDoc=$objAdmin->addEmpDocument($recordId,$fileName,$uploadedDoc,$docId);
		}	
	}
	if($saveDoc){
		//unlink($fileName);
		$html['status'] ='1';
	}else{
		//$html['msg'] = "<div class='alert alert-danger' style='text-align:center;'>Problem in Removing Image.</div>";	
		$html['status'] ='1';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die;
	 
}
else if($_GET['action'] == 'addNewOption')
{
	//print_r($_POST);
	//extract($_POST);
	$addOption=$objAdmin->add_new_option($_POST);
	if($addOption)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
else if($_GET['action'] == 'delAttach'){
	//print_r($_POST);
	extract($_POST);
	$deleteAttach=$objAdmin->delete_emp_attachment($attachId);
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
if($_GET['action'] == 'delete_items')
{
	//print_r($_POST);
	//die;
	//Array ( [id] => 919 [itemType] => contactNumbers )
	
	$delete = $objAdmin->delte_items($id,$itemType);
	if($delete){
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
else if($_GET['action'] == 'addVan')
{
	//print_r($_POST);
	extract($_POST);
	$addvan = $objAdmin->addvan($vanId,$vanNumber);
	if($addvan===true)
	{
		echo 1;
		exit();
	}
	else{
		echo 0;
		exit();
	}
	
}
else if($_GET['action']=='addReport')
{
	//print_r($_POST);
	extract($_POST);
	$addreport = $objAdmin->add_report($_POST);
	if($addreport===true)
	{
		echo 1;
		exit();
	}
	else{
		echo 0;
		exit();
	}
}
else if($_GET['action']=='reg')
{
	extract($_POST);
	$users=$objAdmin->email_exists($email);
	
	if ($users === true) {
		echo 2;
	}
	else{
		 $reg = $objAdmin->register($username,$email,$password1,$permanentAddress,$residenceAddress);	
		 if( $reg)
		 {
		   echo 1;
		   exit();
        }else{
		     echo 0;
		     exit();
		}
    } 
}

else if($_GET['action']=='detail')
{
	//print_r($_POST);
	 extract($_POST);
    if($_POST['user_id']!='0')
	{
		$cond=$objAdmin->condidate_exists($ca_Name, $dob, $fa_Name);
	}	
	else{
		$cond=false;
	}
		
	if ($cond === true) {
		echo 2;
		exit();
	}
	else
	{
		$admin_id=$_SESSION['admin_Id'];
		 $detail = $objAdmin->user_detail($_POST,$admin_id);
		 if( $detail)
		{
			  echo 1;
			  exit();
		}else
		{
				echo 0;
		}
	} 
}


else if($_GET['action']=='addpsdetail')
{  


	extract($_POST);

	  $admin_id=$_SESSION['admin_Id'];
	 
	$detail = $objAdmin->add_Parichay($ps_id, $city,$cast,$psNameEng, $psNameHin, $ps_date);
	if( $detail)
	{
	  echo 1;
		exit();
	}
	else
	{
		echo 0;
	}
}

else if($_GET['action']=='updatepsDetail')
{
	extract($_POST);
	 $admin_id=$_SESSION['admin_Id'];
	 $detail = $objAdmin->editparichayData($city,$cast,$psName,$admin_id);
	 
		 if( $detail)
		 {
		  echo 1;
		exit();
        }else
		{
			echo 0;
		}
}

else if($_GET['action'] == 'forget_pass')
{
	extract($_POST);
	$users=$objAdmin->email_exists($email);
	if($users)
	{
		echo $user_pass = $objAdmin->forget_password($email,$password);
	}else{
		echo 0;
	}
	/* 
	if($user_pass)
	{
		echo 1;
	}
	else
	{
		echo 0;
	} */
}
else if($_GET['action']=='addcity')
{
	extract($_POST);
	
	if(preg_match("/^[a-zA-Z]+$/", $cityNameHin) == 1) {
       // string only contain the a to z , A to Z, 0 to 9
	   echo 3;
	   exit;
    }
	
	$cit=$objAdmin->city_exists(strtolower($cityNameEng),$city_id);
	if($cit === true)
	{
		echo 2;
	}
	else{
	     $city = $objAdmin->addcity(strtolower($cityNameEng),$cityNameHin,$city_id);	 
		 if($city)
		 {
		  echo 1;
		exit();
        }else
		{
			echo 0;
		}
	}
}
else if($_GET['action']=='change_val')
{
	 extract($_POST);
	$pName=$objAdmin->parichay_name($city,$lang);
	if($lang=='hi')
	{
		$optStr='<option value="0">एक का चयन करें</option>';
	foreach($pName as $value){
		$optStr .= '<option value="'.$value['id'].'">'.$value['psName_hi'].'</option>';
	}
	echo $optStr;
		
	}else{
	$optStr='<option value="0">Select</option>';
	foreach($pName as $value){
		$optStr .= '<option value="'.$value['id'].'">'.$value['psName_en'].'</option>';
	}
	echo $optStr;
	}
}
else if($_GET['action']=='reset_pass')
{
	extract($_POST);
	
	$admin_id=$_SESSION['admin_Id'];
	$users=$objAdmin->reset_password($oldpass, $conpassword,$admin_id);
	if($users)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
	
}else if($_GET['action']=='verify_pass'){
	  extract($_POST);
	  $email=$_SESSION['admin_Email'];
	  $login = $objAdmin->login($email,$addpassword);
	  if ($login === false) {
		echo 0;
		
	}else {
		
		echo 1;
		exit();
	}
}else if(@$_POST['flag']=='profile_image')
	{
	            $targetFolder ="upload/"; 
                $arrMsg=array();
				$filename="";
				if (!empty($_FILES)) {
				$verifyToken=time();
				$tempFile = $_FILES['Filedata']['tmp_name'];
				$targetPath = $targetFolder;
				$targetFile = rtrim($targetPath,'/') . '/' . $verifyToken;

				
				$fileTypes = array('jpg','jpeg','gif','png');
				$fileParts = pathinfo($_FILES['Filedata']['name']);

				if (in_array($fileParts['extension'],$fileTypes)) {
				    $filename=$verifyToken.'.'.$fileParts['extension'];
				    /*$temp = explode(".", $_FILES["Filedata"]["name"]);
				    $extension = end($temp);
				    $tempFilename = $filename;
				
				    $uploadedfile = $_FILES["Filedata"]["tmp_name"];
					
				    $newwidth = 300;	
				    $filename=$this->compressImage($extension,$uploadedfile,"admin/upload/thumb/",$tempFilename,$newwidth);*/
					move_uploaded_file($tempFile,$targetFile.'.'.$fileParts['extension']);
					
					
					$p_id=$_POST['p_id'];
					$col='profilePic';
					$rttype=$filename;
                    $objAdmin->update_user_data($col,$rttype,$p_id);
					
					$msg='true';
				}
				else {
				      $msg='false';
				}
		}
		$result          = json_encode(array('data'=>$msg,'imagename'=>$filename));
	    echo  $result;
}else if($_POST['flag']=='temp_profile_image')
{
	            $targetFolder ="temp_upload/"; 
                $arrMsg=array();
				$filename="";
				if (!empty($_FILES)) {
				$verifyToken=time();
				$tempFile = $_FILES['Filedata']['tmp_name'];
				$targetPath = $targetFolder;
				$targetFile = rtrim($targetPath,'/') . '/' . $verifyToken;

				
				$fileTypes = array('jpg','jpeg','gif','png');
				$fileParts = pathinfo($_FILES['Filedata']['name']);

				if (in_array($fileParts['extension'],$fileTypes)) {
					move_uploaded_file($tempFile,$targetFile.'.'.$fileParts['extension']);
					$filename=$verifyToken.'.'.$fileParts['extension'];
					$ext=$fileParts['extension'];
					$uploadedfile=$tempFile;
					$path=$targetPath;
					$actual_image_name=$verifyToken;
					$newwidth=128;
					
					
					$p_id=$_POST['p_id'];
					$col='profilePic';
					$rttype=$filename;
                    
					$msg='true';
				}
				else {
				      $msg='false';
				}
		}
		$result          = json_encode(array('data'=>$msg,'imagename'=>$filename));
	    echo  $result;
	}
	
function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth){
	if($ext=="jpg" || $ext=="jpeg" ){
		$src = imagecreatefromjpeg($uploadedfile);
	}else if($ext=="png"){
		$src = imagecreatefrompng($uploadedfile);
	}else if($ext=="gif"){
		$src = imagecreatefromgif($uploadedfile);
	}else{
		$src = imagecreatefrombmp($uploadedfile);
	}
																	
	list($width,$height)=getimagesize($uploadedfile);
	$newheight=($height/$width)*$newwidth;
	$tmp=imagecreatetruecolor($newwidth,$newheight);
	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	$filename = $path.$newwidth.'_'.$actual_image_name;
	imagejpeg($tmp,$filename,100);
	imagedestroy($tmp);
	return $newwidth.'_'.$actual_image_name;
}
?>