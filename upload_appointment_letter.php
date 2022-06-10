<?php  
 //upload.php  
extract($_POST);
 $output = ''; 
$result=array();
//print_r($hotl_id);exit;
if (!file_exists("document/emp_doc/".$hotl_id.'/')) {
    mkdir("document/emp_doc/".$hotl_id.'/', 0777, true);
}
 if(is_array($_FILES))  
 {  	
      foreach($_FILES['file_upload7']['name'] as $name => $value)  
      {  
           $file_name = explode(".", $_FILES['file_upload7']['name'][$name]);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif","doc","docx","pdf","PDF");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["file_upload7"]["tmp_name"][$name];  
                $targetPath = "document/emp_doc/".$hotl_id.'/'.$new_name;  
                move_uploaded_file($sourcePath, $targetPath);  
           }  
		  
		  $result[]= $new_name;
	         
      }
         echo json_encode($result);  

      // $images = glob("uploads2/*.*");  
      // foreach($images as $image)  
      // {  
           // $output .= '<div class="col-md-2" align="center" ><img src="' . $image .'" width="100px" height="100px" style="margin-top:15px; padding:8px; border:1px solid #ccc;" /></div>';  
      // }  
      // echo $output;  
  
}
 ?>  