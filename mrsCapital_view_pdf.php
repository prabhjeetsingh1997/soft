<?php
$realpath = 'adminConfig/init.php';
include($realpath);
ob_start();
//require('index.php');
//include();
ob_end_clean();
$name = base64_decode($_GET['name']);
$lastname = base64_decode($_GET['lastname']);
$age = base64_decode($_GET['age']);
$martialstatus = base64_decode($_GET['martialstatus']);
$mobilenumber = base64_decode($_GET['mobilenumber']);
$email = base64_decode($_GET['email']);
$address = base64_decode($_GET['address']);
$address1 = base64_decode($_GET['address1']);
$city = base64_decode($_GET['city']);
$state = base64_decode($_GET['state']);
$pincode = base64_decode($_GET['pincode']);
$height = base64_decode($_GET['height']);
$weight = base64_decode($_GET['weight']);
$bust = base64_decode($_GET['bust']);
$waist = base64_decode($_GET['waist']);
$hips = base64_decode($_GET['hips']);
$type=$_GET['type'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    </head>
    <body>
        <?php if($type == 'pdf') {?>
        <div class="row" style="margin-top:50px;">
            <div class="col-md-12">
                <table class="table table-bordered" style="width:100%;">
                        <tr style="background-color:black; color:white;">
                            <h5>PERSONAL INFORMATION</h5>
                        </tr>
                        <br>
                        <tr>
                            <td>First Name</td>
                            <td>Last Name</td>
                        </tr>
                        <br>
                        <tr>
                            <td><?php echo $name;?></td>
                            <td><?php echo $lastname;?></td>
                        </tr>
                        <br>
                        <tr>
                            <td>Age</td>
                            <td>Martial Status</td>
                        </tr>
                        <br>
                        <tr>
                            <td><?php echo $age;?></td>
                            <td><?php echo $martialstatus;?></td>
                        </tr>
                        <br>
                        <tr style="background-color:black; color:white;">
                            <h5>CONTACT DETAILS</h5>
                        </tr>
                        <br>
                        <tr>
                            <td>Contact</td>
                            <td>Last Name</td>
                        </tr>
                        <!--<tr>-->
                        <!--    <td><?php //echo $mobilenumber;?></td>-->
                        <!--    <td><?php //echo $email;?></td>-->
                        <!--</tr>-->
                </table>
            </div>
        </div>
        <?php } ?>
    </body>
</html>