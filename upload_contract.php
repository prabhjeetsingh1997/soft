<?php  

extract($_POST);
$result=array();
if (!file_exists("document/hotel_doc/".$hotl_id.'/')) {
    mkdir("document/hotel_doc/".$hotl_id.'/', 0777, true);
}
 if(is_array($_FILES))  
 {  	
      foreach($_FILES['file_upload2']['name'] as $name => $value)  
      {  
           $file_name = explode(".", $_FILES['file_upload2']['name'][$name]);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif","doc","docx","pdf","PDF");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["file_upload2"]["tmp_name"][$name];  
                $targetPath = "document/hotel_doc/".$hotl_id.'/'.$new_name;  
                move_uploaded_file($sourcePath, $targetPath);  
           }  
		  
		  $result[]= $new_name;
	         
      }
         echo json_encode($result);  

     
  
}
 ?>  