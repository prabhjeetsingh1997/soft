<?php
if(isset($_POST['submit']))
{


$user_name=$_POST['user_name'];
$user_email=$_POST['user_email'];
$usr_pass=$_POST['usr_pass'];
$user_pass1=$_POST['user_pass1'];
$user_phone=@$_POST['user_phone'];


$filename='';
if(@$_FILES["user_img"]["size"])
{
$target_dir = "img/";
$target_thumb ="img/thumb/";
$target_file = $target_dir . basename($_FILES["user_img"]["name"]);


$name=$_FILES['user_img']['name'];
$size = $_FILES['user_img']['size'];
  
                  list($txt, $ext) = explode(".", @$name);
                  $file = time().substr(str_replace(" ", "_", $txt), 0);
 
                  $info = pathinfo($file);
                  $filename = $file.".".$ext;
                   if(move_uploaded_file($_FILES['user_img']['tmp_name'], $target_dir.$filename)) { 
                     date_default_timezone_set ("Asia/Calcutta");
                     $currentdate=date("d M Y");
                     //@$file_name_all.=$filename."*";	 
                   }else{
$filepath="";
}

createThumbnail($filename); 
}

$select_sql = "SELECT * FROM rgistration where email='".$user_email."'";
$result     = mysql_query($select_sql);

$count=mysql_num_rows($result);
if(!$count)
{
  
$sql = "INSERT INTO rgistration (fname , email , password , phone ,image )
VALUES ('".$user_name."', '".$user_email."',  '".$usr_pass."','".$user_phone."','".$filename."')";

$query = mysql_query($sql)or die(mysql_error());
$id=mysql_insert_id();
if($id)
{
$msg='New data inserted successfully';
}else{
$msg= 'New data not inserted';
}
}else{
$msg='email is already exist.';
}

}




?>