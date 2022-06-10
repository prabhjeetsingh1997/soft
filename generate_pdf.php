<?php
include('config/init.php');
require_once("dompdf/dompdf_config.inc.php");
$param = $_SERVER['QUERY_STRING'];

echo "hello";
$pdfType = $_POST['pdfType'];

$dataUrl = 'view_hotel_data.php';
$folder = 'hotels';
$title = str_replace(' ','_',base64_decode($_GET['hotel']));
$title = str_replace('&','and',$title);

$prices = base64_encode($_POST['prices']);
$selRooms = base64_encode($_POST['selRooms']);
$selMealPlans = base64_encode($_POST['selMealPlans']);
$qNo = base64_encode($_POST['qNo']);
$pMargin = base64_encode($_POST['pMargin']);

$url = APP_URL.$dataUrl.'?type=pdf&'.$param.'&prices='.$prices.'&selRooms='.$selRooms.'&qNo='.$qNo.'&pMargin='.$pMargin.'&selMealPlans='.$selMealPlans;

if($pdfType == 'package')
{
	$dataUrl = 'view_package_data.php';
	$folder = 'package';
	$title = str_replace(' ','_',base64_decode($_GET['itiTitle']));
	$title = str_replace('&','and',$title);
	
	//print_r($_POST['selHotels']);
	
	//$selHotels = base64_encode($_POST['selHotels']);
	$selHotels = $_POST['selHotels'];  // Already it is in base64 from javascript
	$selVehicle = base64_encode($_POST['selVehicle']);
	$url = APP_URL.$dataUrl.'?type=pdf&'.$param.'&prices='.$prices.'&selRooms='.$selRooms.'&selHotels='.$selHotels.'&selVehicle='.$selVehicle.'&qNo='.$qNo.'&pMargin='.$pMargin.'&selMealPlans='.$selMealPlans;
}
//echo $url;
//die;
$html = file_get_contents($url);

//$title = str_replace(' ','_',base64_decode($_GET['hotel'])).time();

$pdfName = $title.'.pdf';

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
//$dompdf->stream("tour_description.pdf"); 


echo $file_to_save = 'generated_pdf/'.$folder.'/'.$pdfName;
exit;

//save the pdf file on the server
file_put_contents($file_to_save, $dompdf->output()); 
echo $file_to_save;
/* header("Content-type:application/pdf");

//It will be called downloaded.pdf
header("Content-Disposition:attachment;filename=$pdfName");
readfile($file_to_save); */