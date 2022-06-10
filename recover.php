<?php require 'config/init.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>FlatLab - Flat & Responsive Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

     
        <h2 class="form-signin-heading"> Recover Password </h2>
        <div class="login-wrap">
            <?php
        if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
            ?>
            <h3 style="font-size: 11px;margin: 10px;">Thank you, we've send you a randomly generated password in your email.</h3>
            <?php
            
        } else if (isset ($_GET['email'], $_GET['generated_string']) === true) {
            
            $email		=trim($_GET['email']);
            $string	    =trim($_GET['generated_string']);	
            
            if ($objAdmin->email_exists($email) === false || $objAdmin->recover($email, $string) === false) {
                $errors[] = 'Sorry, something went wrong and we couldn\'t recover your password.';
            }
            
            if (empty($errors) === false) {    		

        		echo '<p>' . implode('</p><p>', $errors) . '</p>';
    			
            } else {

                header('Location: recover.php?success');
                exit();
            }
        
        } else {
            header('Location: index.php'); // If the required parameters are not there in the url. redirect to index.php
            exit();
        }
        ?>
            
			

        </div>



    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
  </body>
</html>
