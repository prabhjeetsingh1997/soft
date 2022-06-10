<?php  
 //upload.php  
 $output = ''; 
$result=array();
 if(is_array($_FILES))  
 {  
      foreach($_FILES['images']['name'] as $name => $value)  
      {  
           $file_name = explode(".", $_FILES['images']['name'][$name]);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["images"]["tmp_name"][$name];  
                $targetPath = "document/hotel_doc/hotel_pics/".$new_name;  
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