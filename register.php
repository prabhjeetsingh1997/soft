<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Parichay Sammelan | Registration Page</title>
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
  </head>
  <body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="index.php" style="font-size: 32px;text-align:left;"><b>Parichay Sammelan</b>App</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg" style="color: #367fa9;font-size: 20px;font-weight: bold;">Register a new membership</p>
		<div id="status"></div>
        <form action="" method="" id="user_register" name="user_register" enctype="multipart/form-data">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="User name" name="username" id="username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password1" id="password1" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="conpassword" id="conpassword" class="form-control" placeholder="Retype password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
		  <div class="form-group">
			<textarea name="permanentAddress" class="form-control" placeholder="Parmanent Address" value=""></textarea>
          </div>
		  <div class="form-group">
			<textarea name="residenceAddress" class="form-control" placeholder="Residence Address" value=""></textarea>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="terms" id="terms" checked="checked"> I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary  btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center" style="display:none;>
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using Google+</a>
        </div>

        <a href="index.php" class="text-center">I already have a membership</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="asset/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="asset/plugins/iCheck/icheck.min.js"></script>
	<script src="jquery-validation/dist/jquery.validate.js"></script>
	<script src="jquery-validation/dist/additional-methods.js"></script>
	
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
	  
	  $(document).ready(function(){
	  $("#user_register").validate({
	  
		 rules:{
		username:"required",  
											  
		email:
			 {
				required:true,
				email:true
			 },
		password1:
			{
				required:true,
				minlength:5								
			},
		conpassword:
			{
				required:true,
				minlength:5,
				equalTo:"#password1"
											
			},
		permanentAddress:"required",
		residenceAddress:"required",
		terms:"required"									 
		 },
		messages:{
				fullname:"Please enter your full name",
				email:{
					required:"please enter your email",
					email:"Invalid format"
					},
				password1:{
					required:"Please enter your password",
					minlength:"Minimum length should be 5 charcter long"
												
						},
				ConPassword:{
					   required  : "Confirm your password",
					   minlength : "Minimum length should be 5 charcter",
					   equalTo: "Password and Confirm password doesn't match"
					
						},
				permanentAddress:"Parmanent address field can not be empty",
				residenceAddress:"Residence address field can not be empty",
				terms:"please accept the terms and condition"
				},
							
					submitHandler:function(form){
						 $.ajax({  
									type: "POST",  
									url: "_ajax_user_authentication.php?action=reg",
									data: $("#user_register").serialize(),
									beforeSend:function() {
									},
									success: function(msg)
									{  
										if(msg === '1')
										{
											$("#status").show().html('<div class="alert alert-success">sucessfully registered</div>');
											$("#user_register")[0].reset();
										
										}else if(msg === '2'){
										        $("#status").show().html('<div class="alert alert-danger">email is already register.</div>');
										}
										else
										{
											$("#status").show().html('<div class="alert alert-danger">Sorry, there is some problem</div>');
											
										}
									} 
								});
					}
								
		
		  });
	});
    </script>
  </body>
</html>