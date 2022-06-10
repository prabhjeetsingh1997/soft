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
    <link rel="stylesheet" href="asset/dist/css/AdminLTE.min.css">
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
        <a href="../../index2.html"><b>Parichay Sammelan</b>App</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Forget your password</p>
		<div id="status"></div>
        <form action="" method="" id="forget_password" name="forget_password">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
            <div class="col-lg-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
            </div><!-- /.col -->
          </div>
        </form>

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
	  $("#forget_password").validate({
	  
		 rules:{									  
		email:
			 {
				required:true,
				email:true
			 }									 
		 },
		messages:{
				email:{
					required:"please enter your email",
					email:"invalid format"
					}
				},
				submitHandler:function(form){
						 $.ajax({  
									type: "POST",  
									url: "_ajax_user_authentication.php?action=forget_pass",
									data: $("#forget_password").serialize(),
									beforeSend:function() {
									},
									success: function(msg)
									{  
										
										if(msg === '1')
										{
											$("#status").show().html('Please check your Email');
										
										}
										else
										{
											$("#status").show().html('Sorry, there is some problem');
											
										}
									} 
								});
					}
		});
	  });
		</script>
	</body>
</html>