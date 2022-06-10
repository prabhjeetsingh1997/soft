<?php
//date_default_timezone_set('America/Los_Angeles');
$filepath = $_REQUEST['f'];
//$filepath = 'generated_pdf/mrsCapital/ABC_Testing.pdf';
//$filepath = 'generated_pdf/hotels/ABC_Testing.pdf';
$pathArr = array_reverse(explode('/', $filepath));
//var_dump($pathArr);
$file_name = $pathArr[0];
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$file_name);
readfile($filepath); 
exit;
