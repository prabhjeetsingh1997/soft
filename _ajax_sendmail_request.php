<?php
//include('config/init.php');
$realpath = 'adminConfig/init.php';
include($realpath);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$array = explode('/',$_SERVER['DOCUMENT_ROOT']);
array_pop($array);
$path = implode('/',$array);
$real_path = $path.'/mrscapital.in/invoice/';
$mail = new PHPMailer(true);
if (isset($_POST)) {
	$mailing = $objAdmin->mailing($_POST['id']);
	if($mailing)
	{
        $template = file_get_contents("mail/ordermail.html");

        $variable = array();
        $variable['id']             = $mailing[0]['id'];
        $variable['first_name']     = $mailing[0]['first_name'];
        $variable['last_name']      = $mailing[0]['last_name'];
        $variable['age']            = $mailing[0]['age'];
        $variable['contact']        = $mailing[0]['contact'];
        // $variable['photo']          = $mailing[0]['photo'];
        // $variable['parent_fname']   = $mailing[0]['parent_fname'];
        $variable['email']          = $mailing[0]['email'];
        // $variable['relationship']   = $mailing[0]['relationship'];
        // $variable['mobile_no']      = $mailing[0]['mobile_no'];
        $variable['address_line_1'] = $mailing[0]['address_line_1'];
        $variable['address_line_2'] = $mailing[0]['address_line_1'];
        $variable['city']           = $mailing[0]['city'];
        $variable['postal_code']    = $mailing[0]['postal_code'];
        $variable['state']          = $mailing[0]['state'];
        $variable['reference_id']   = $mailing[0]['reference_id'];
        $variable['amount']         = $mailing[0]['amount'];

        $to = $mailing[0]['email'];
        $subject = "Order Confirmation Mail";
        foreach($variable as $key => $value)
        {
         $template = str_replace('{{ '.$key.' }}', $value, $template);
        }

        $mail->setFrom('admin@mrscapital.in', 'Mrs Capital');
        $mail->addAddress($to);
        $attachment = $real_path.'receipt'.$mailing[0]['id'].'.pdf';
        $mail->addAttachment($attachment);
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Mrs Capital Confirmation Mail';
        $mail->Body    = $template;
        if ($mail->send()) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
	}else{
        echo 2;
        exit;
    }
	
}else{
    echo 3;
    exit;
}
?>

