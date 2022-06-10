<?php 
//echo 'testing';
    $realpath = 'adminConfig/init.php';
    include($realpath);
    if(isset($_SESSION['admin_Id'])==true)
    {
    	if($_SESSION['user_type'] == 'Employee') {
    		header("Location:view_query.php");
    	}else{
    		header("Location:dashboard.php");
    	}
    }
$url= trim($_SERVER['HTTP_HOST'], '/');
    if(!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Travel CRM| Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="asset/dist/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="asset/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 <!-- jQuery 2.1.4 -->
    <script src="asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="asset/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="asset/plugins/iCheck/icheck.min.js"></script>
	<script src="jquery-validation/dist/jquery.validate.js"></script>
	<script src="jquery-validation/dist/additional-methods.js"></script>
  </head>
  <body class="hold-transition login-page" style="background:url('asset/dist/img/banner.jpg');background-repeat: no-repeat;background-size: cover;">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0)" style="font-size: 32px;text-align:left; color:#FFF;">
			<img src="images/pdf/travellogo.png">
		</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg" style="color: #367fa9;font-size: 20px;font-weight: bold;">Sign in to Mrs Capital Software</p>
		<div id="status"></div>
        <form action="" method="" id="user_login" name="user_login" >
        	<input type="hidden" name="partner_url" value="<?php echo $domain ?>">
          <div class="form-group has-feedback">
			<select name="userType" class="form-control">
				<option value="">Select</option>
				<option value="admin">Admin</option>
				<option value="emp">Employee</option>
			</select>
            <span class="glyphicon glyphicon-down-arrow form-control-feedback"></span>
          </div>
		  <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email" name="email" id="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" name="login_button" id="login_button">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <!--<a href="forgetpass.php">I forgot my password</a><br>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

   
    <script>
	$(function () {
		 $('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
		});
	});										  								
	
	$(document).ready(function(){
	  $("#user_login").validate({
		rules:{
			email:"required",
			password:
			{
				required:true,
				minlength:5
			},
			userType:"required"
				 
		  },
			messages:{
				email:"please enter your email",
				password:{
					required:"please enter your password",
					minlength:"minimum length should be 5 charcter long"
					
				}
			},
							
			submitHandler:function(form){
				 $.ajax({  
					type: "POST",  
					url: "_ajax_user_authentication.php?action=login",
					data: $("#user_login").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						
						if(msg === '1')
						{
							window.location.href='index.php';
						
						}
						else
						{
							$("#status").show().html('<div class="alert alert-danger">Sorry, that username/password is invalid!</div>');
							
						}
					} 
				});
			}					
		  });
	});
		  	  
    </script>
  </body>
</html>