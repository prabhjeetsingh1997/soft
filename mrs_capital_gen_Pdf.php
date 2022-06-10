<?php
$realpath = 'adminConfig/init.php';
include($realpath);
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$id = $_GET['id'];
$arrQuery = $objAdmin->getmrsCapitalLeadDetail($id);
$folder = 'mrsCapital';
$uniquesavename=time().uniqid(rand(10000,99999));

    $name = $arrQuery[0]['first_name'];
	$lastname = $arrQuery[0]['last_name'];
	$email = $arrQuery[0]['email'];
	$mobilenumber = $arrQuery[0]['contact'];
	//$queryDate=$arrQuery[0]['date_time'];
	$age = $arrQuery[0]['age'];
	$martialstatus = $arrQuery[0]['maritial_status'];
	$address = $arrQuery[0]['address_line_1'];
	$address1 = $arrQuery[0]['address_line_2'];
	$city = $arrQuery[0]['city'];
	$state = $arrQuery[0]['state'];
	$pincode = $arrQuery[0]['postal_code'];
	$height = $arrQuery[0]['height'];
	$bust   = $arrQuery[0]['bust'];
	$waist  = $arrQuery[0]['waist'];
	$hips   = $arrQuery[0]['hips'];
	$weight = $arrQuery[0]['weight'];
	$photo1 = $arrQuery[0]['photo_1'];
	$photo2 = $arrQuery[0]['photo_2'];
	$photo3 = $arrQuery[0]['photo_3'];
	
	$html = '
 <style>
table {
    font-family: arial, sans-serif;
    width: 100%;
}

td, th {
    
    text-align: left;
    padding: 8px;
}

</style>
<table>
  <tr style="background-color: crimson; color: white;">
    <td colspan="3"><span><b>PHOTOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Candidate No: 00'.$id.'</b></span></td>
  </tr>
  <tr style="">
    <td style="width:200px; background-color:#dddddd;"><img src="images/mrscapitalimages/'.$photo1.'" style="width:200px;"></td>
    <td style="width:200px; background-color:#dddddd;"><img src="images/mrscapitalimages/'.$photo2.'" style="width:200px;"></td>
    <td style="width:200px; background-color:#dddddd;"><img src="images/mrscapitalimages/'.$photo3.'" style="width:200px;"></td>
  </tr>
  <tr style="background-color: crimson; color: white;">
    <td colspan="3"><b>PERSONAL INFORMATION</b></td>
  </tr>
  <tr style="">
    <td style=""><b>First Name</b></td>
    <td style="" colspan="2"><b>Last Name</b></td>
  </tr>
  <tr style="">
    <td style="font-size:14px; background-color:#dddddd;">'.$name.'</td>
    <td style="font-size:14px; background-color:#dddddd;" colspan="2">'.$lastname.'</td>
  </tr>
  <tr style="">
    <td style=""><b>Age</b></td>
    <td style="" colspan="2"><b>Marital Status</b></td>
  </tr>
  <tr style="">
    <td style="font-size:14px; background-color:#dddddd;">'.$age.'</td>
    <td style="font-size:14px; background-color:#dddddd;" colspan="2">'.$martialstatus.'</td>
  </tr>
  <tr style="background-color: crimson; color: white;">
    <td colspan="3"><b>CONTACT DETAILS</b></td>
  </tr>
  <tr style="">
    <td style=""><b>Contact</b></td>
    <td style="" colspan="2"><b>Email</b></td>
  </tr>
  <tr style="">
  <td style="font-size:14px; background-color: #dddddd;">'.$mobilenumber.'</td>
  <td style="font-size:14px; background-color: #dddddd;" colspan="2">'.$email.'</td>
  </tr>
  <tr style="background-color: crimson; color: white;">
    <td colspan="3"><b>COMMUNICATION ADDRESS</b></td>
  </tr>
  <tr style="">
    <td style=""><b>Address</b></td>
    <td style="" colspan="2"><b>Address Line 1</b></td>
  </tr>
  <tr style="">
  <td style="font-size:14px; background-color: #dddddd;">'.$address.'</td>
  <td style="font-size:14px; background-color: #dddddd;" colspan="2">'.$address1.'</td>
  </tr>
  <tr style="">
    <td style=""><b>City</b></td>
    <td style=""><b>State</b></td>
    <td style=""><b>Pin Code</b></td>
  </tr>
  <tr style="">
    <td style="font-size:14px; width:200px; background-color: #dddddd;">'.$city.'</td>
    <td style="font-size:14px; width:200px; background-color: #dddddd;">'.$state.'</td>
    <td style="font-size:14px; width:200px; background-color: #dddddd;">'.$pincode.'</td>
  </tr>
  <tr style="background-color: crimson; color: white;">
  <td colspan="3"><b>PHYSICAL ATTRIBUTES</b></td>
  </tr>
  <tr style="">
    <td style=""><b>Height</b></td>
    <td style="" colspan="2"><b>Weight</b></td>
  </tr>
  <tr style="">
    <td style="font-size:14px; background-color: #dddddd;">'.$height.'</td>
    <td style="font-size:14px; background-color: #dddddd;" colspan="2">'.$weight.'</td>
  </tr>
  <tr style="background-color: crimson; color: white;">
  <td colspan="3"><b>VITAL STATS (IN INCHES)</b></td>
  </tr>
  <tr style="">
    <td style=""><b>Bust</b></td>
    <td style=""><b>Waist</b></td>
    <td style=""><b>Hips</b></td>
  </tr>
  <tr>
    <td style="font-size:14px; width:200px; background-color: #dddddd;">'.$bust.'</td>
    <td style="font-size:14px; width:200px; background-color: #dddddd;">'.$waist.'</td>
    <td style="font-size:14px; width:200px; background-color: #dddddd;">'.$hips.'</td>
  </tr>
</table>';

//$data = 'mrsCapital_view_pdf.php';

//$url = 'https://www.mrscapital.in/soft/'.$data.'?type=pdf&name='.$name.'&lastname='.$lastname.'&age='.$age.'&martialstatus='.$martialstatus.'&mobilenumber='.$mobilenumber.'&email='.$email.'&address='.$address.'&address1='.$address1.'&city='.$city.'&state='.$state.'&pincode='.$pincode.'&height='.$height.'&weight='.$weight.'&bust='.$bust.'&waist='.$waist.'&hips='.$hips;
//$html = file_get_contents($url);
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$pdfName = $uniquesavename.'.pdf';
// write pdf to a file
$dompdf->stream($pdfName,array('Attachment'=>0));

//$file_to_save = 'generated_pdf/'.$folder.'/'.$pdfName;
//file_put_contents($file_to_save, $dompdf->output());
//echo $file_to_save;
?>