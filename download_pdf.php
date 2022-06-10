<?php
//date_default_timezone_set('America/Los_Angeles');
//$filepath = $_REQUEST['f'];

$filepath = 'generated_pdf/hotels/ABC_Testing.pdf';
$pathArr = array_reverse(explode('/', $filepath));
$file_name = $pathArr[0];

echo "<pre>@@@";
print_r($file_name);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$file_name);
readfile($filepath); 
exit;