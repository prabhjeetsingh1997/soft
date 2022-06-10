<?php include('header.php');
include('sidebar.php');
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reset Password Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Reset Password</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Reset Password </h3>
                </div><!-- /.box-header -->
				<div id="status"></div>
				<form role="form" method="POST" name="reset_password" id="reset_password">
				<div class="box-body">
                    
					<div class="form-group">
					<input type="password" name="oldpass" id="oldpass" class="form-control" placeholder="older password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					
					<div class="form-group">
					<input type="password" name="password1" id="password1" class="form-control" placeholder="New password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group">
					<input type="password" name="conpassword" id="conpassword" class="form-control" placeholder="Confirm password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
                   
					
                  </div><!-- /.box-body -->
				  
				  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                  </div>
                </form>
				</div>
            </div>
          </div>   
		  </section>
		  </div>
		  <script>
	 $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
	   $(document).ready(function(){
	  $("#reset_password").validate({
	  
		 rules:{									  
		oldpass:
		{
			required:true,
				minlength:5	
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
			}									 
		 },
		messages:{
					oldpass:
					{
						required:"please enter your current password",
							minlength:"minimum length should be 5 char"
					},
				password1:{
					required:"please enter your password",
					minlength:"minimum length should be 5 charcter long"
						},
				ConPassword:{
					   required  : "confirm your password",
					   minlength : "minimum length should be 5 charcter",
					   equalTo: "New password and confirm password doesn't match"
					}
				},
				submitHandler:function(form){
						 $.ajax({  
									type: "POST",  
									url: "_ajax_user_authentication.php?action=reset_pass",
									data: $("#reset_password").serialize(),
									beforeSend:function() {
									},
									success: function(msg)
									{  
										if(msg === '1')
										{
											$("#status").show().html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4> Succesfully Updated.</div>');
										
										}
										else
										{
											$("#status").show().html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4> Sorry, there is some problem.</div>');
											
										}
									} 
								});
					}
		});
	  });
		</script>
		  <?php  include('footer.php');?> 