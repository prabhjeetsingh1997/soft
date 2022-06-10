<?php
include('config/init.php');
extract($_POST);

if($_POST['flag']=='upload_file')
{
	if($_POST['direc'] == 'client_doc')
	{
		$chkEditId = $_POST['recordId'];
		if($chkEditId == '0' || $chkEditId == '')
		{
			$chkEditId = $_SESSION['clientId'];
		}
		$targetFolder ="document/client_doc/".$chkEditId.'/';
	}
	else if($_POST['direc'] == 'hotel_doc')
	{
		$chkEditId = $_POST['recordId'];
		if($chkEditId == '0' || $chkEditId == '')
		{
			$chkEditId = $_SESSION['hotelId'];
		}
		$targetFolder ="document/hotel_doc/".$chkEditId.'/';
	}
	else if($_POST['direc'] == 'transporter_doc')
	{
		$chkEditId = $_POST['recordId'];
		if($chkEditId == '0' || $chkEditId == '')
		{
			$chkEditId = $_SESSION['transporterId'];
		}
		$targetFolder ="document/transporter_doc/".$chkEditId.'/';
	}
	else if($_POST['direc'] == 'travel_doc')
	{
		$chkEditId = $_POST['recordId'];
		if($chkEditId == '0' || $chkEditId == '')
		{
			$chkEditId = $_SESSION['travelId'];
		}
		$targetFolder ="document/travel_doc/".$chkEditId.'/';
	}
	else if($_POST['direc'] == 'hotel_room_pic')
	{
		$targetFolder ="document/hotel_doc/hotel_room_pic/";
	}
	else if($_POST['direc'] == 'hotel_pics')
	{
		/* $chkEditId = $_POST['recordId'];
		if($chkEditId == '0' || $chkEditId == '')
		{
			$chkEditId = $_SESSION['hotelId'];
		}
		$targetFolder ="document/hotel_doc/".$chkEditId.'/hotel_pics/'; */
		$targetFolder ="document/hotel_doc/hotel_pics/";
	}
	else
	{
		$chkEditId = $_POST['recordId'];
		if($chkEditId == '0' || $chkEditId == '')
		{
			$chkEditId = $_SESSION['added_emp_id'];
		}
		$targetFolder ="document/employee/".$chkEditId.'/';
	}
	
	
	@mkdir($targetFolder, 0777, true);
	$arrMsg=array();
	$filename="";
	if (!empty($_FILES)) 
	{
		$verifyToken=time();
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = $targetFolder;
		$targetFile = rtrim($targetPath,'/') . '/' . $verifyToken;
		$fileTypes = array('pdf','doc','docx','xls','xlsx','txt','png','jpg','JPG','jpeg','JPEG');
		$fileParts = pathinfo($_FILES['Filedata']['name']);
		if(in_array($fileParts['extension'],$fileTypes)){
			move_uploaded_file($tempFile,$targetFile.'.'.$fileParts['extension']);
			$filename=$verifyToken.'.'.$fileParts['extension'];
			$ext=$fileParts['extension'];
			$uploadedfile=$tempFile;
			$path=$targetPath;
			$actual_image_name=$verifyToken;
			$newwidth=128;
			//$p_id=$_POST['p_id'];
			//$col='profilePic';
			$rttype=$filename;
			$msg='true';
		}
		else{
			  $msg='false';
		}
	}
	$result = json_encode(array('data'=>$msg,'imagename'=>$filename));
	echo  $result;
}
if($_POST['flag']=='temp_profile_image')
{
			$targetFolder ="temp_upload/"; 
			$arrMsg=array();
			$filename="";
			if (!empty($_FILES)) {
			$verifyToken=time();
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $verifyToken;
			$fileTypes = array('jpg','JPG','jpeg','JPEG','gif','png');
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
	
if($_REQUEST['flag'] == 'hotel_image')
{
	//print_r($_FILES);
	if($_POST['direc'] == 'transporter_fleet_pic')
	{
		$targetFolder="document/transporter_doc/trans_fleet_pic/";
	}
	else if($_POST['direc'] == 'travel_service_pic')
	{
		$targetFolder="document/travel_doc/service_pic/";
	}
	else
	{
		$targetFolder="document/hotel_doc/hotel_room_pic/";
	}
	$arrMsg=array();
	$filename="";
	if(!empty($_FILES)){
		//echo "fsdfs";
		$verifyToken=time().'_'.generateRandomString();
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = $targetFolder;
		$targetFile = rtrim($targetPath,'/') . '/' . $verifyToken;
		// Validate the file type
		$fileTypes = array('jpg','JPG','jpeg','JPEG','gif','png'); // File extensions
		$fileParts = pathinfo($_FILES['Filedata']['name']);
		//print_r($fileParts);
		if(in_array($fileParts['extension'],$fileTypes))
		{
			move_uploaded_file($tempFile,$targetFile.'.'.$fileParts['extension']);
			$filename=$verifyToken.'.'.$fileParts['extension'];
			$ext=$fileParts['extension'];
			$uploadedfile=$tempFile;
			$path=$targetPath;
			$actual_image_name=$verifyToken;
			$newwidth=480;
			//compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth);
			//$rId=$_POST['rId'];
			$image=$filename;
			$msg='true';
		}else{
			$msg='false';
		}
		
	}
	$result = json_encode(array('data'=>$msg,'imagename'=>$filename));
	//$result = array('data'=>$msg,'imagename'=>$filename);
	
	echo  $result;
}	
	function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
	{
		if($ext=="jpg" || $ext=="jpeg" )
		{
			$src = imagecreatefromjpeg($uploadedfile);
		}
		else if($ext=="png")
		{
			$src = imagecreatefrompng($uploadedfile);
		}
		else if($ext=="gif")
		{
			$src = imagecreatefromgif($uploadedfile);
		}
		else
		{
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
	function generateRandomString($length = 5){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	

?>