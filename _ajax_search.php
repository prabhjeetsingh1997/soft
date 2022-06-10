<?php
include('config/init.php');

extract($_POST);

if($type=='van')
{
    $searchbyvan = $objAdmin->van_number($van_number);
	//print_r($searchbyvan);
	$count=count($searchbyvan);
	if($count)
	{
	foreach($searchbyvan as $key=>$val){
	?>	
	  <tr>
		<td><?php echo $val['van_number'];?></td>
		<td><?php echo $val['visited_date'];?></td>
		<td><?php echo $val['village_name'];?></td>
		<td><?php echo $val['no_of_patien_register'];?></td>
		<td><?php echo $val['no_of_fem_patient'];?></td>
		<td><?php echo $val['no_of_infant_child'];?></td>
	  
		<td>
			<div class="btn-group btn-group-xs">
				<a href="addReporting.php?action=edit&id=<?php echo $val['id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
				<a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
			</div>
		</td>
	  </tr>
	<?php
	}
	}
	else{
		?>
		<tr>
		<td colspan="10" style="text-align:center;color:red;">No data found.</td>
		</tr>
		<?php
	}
	die;
	if ($login === false) {
		echo 0;
		$errors[] = 'Sorry, that username/password is invalid';
	}else {
				$row=$login;		
		$_SESSION['admin_Id'] =$row[0]['admin_id'];
		$_SESSION['user_type'] =$row[0]['user_type'];
		$_SESSION['admin_Email'] =$email;
		
		echo 1;
		exit();
	}
}
else if($type=='date')
{
	
    $searchbyvan = $objAdmin->filter_date($searchByVan,$fromDate,$toDate);
	//print_r($searchbyvan);
	$count=count($searchbyvan);
	if($count)
	{
	foreach($searchbyvan as $key=>$val){
	?>	
	  <tr>
		<td><?php echo $val['van_number'];?></td>
		<td><?php echo $val['visited_date'];?></td>
		<td><?php echo $val['village_name'];?></td>
		<td><?php echo $val['no_of_patien_register'];?></td>
		<td><?php echo $val['no_of_fem_patient'];?></td>
		<td><?php echo $val['no_of_infant_child'];?></td>
	  
		<td>
			<div class="btn-group btn-group-xs">
				<a href="addReporting.php?action=edit&id=<?php echo $val['id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
				<a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
			</div>
		</td>
	  </tr>
	<?php
	}
	}
	else{
		?>
		<tr>
		<td colspan="10" style="text-align:center;color:red;">No data found.</td>
		</tr>
		<?php
	}
	die;
	if ($login === false) {
		echo 0;
		$errors[] = 'Sorry, that username/password is invalid';
	}else {
				$row=$login;		
		$_SESSION['admin_Id'] =$row[0]['admin_id'];
		$_SESSION['user_type'] =$row[0]['user_type'];
		$_SESSION['admin_Email'] =$email;
		
		echo 1;
		exit();
	}
}
else if($_GET['action'] == 'addUser')
{
	//print_r($_POST);
	extract($_POST);
	$users=$objAdmin->email_exists($email);
	
	if ($users === true) {
		echo 2;
	}
	else{
		 $adduser = $objAdmin->adduser($userId,$userName,$userEmail,$userPhone,$userAddress);	
		 if( $adduser)
		 {
		   echo 1;
		   exit();
        }else{
		    echo 0;
		    exit();
		}
    } 
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
		

?>