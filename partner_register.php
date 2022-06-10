<?php
	include('header.php');
	include('sidebar.php');
	
	$id='';
	$partnerData='';
	//print_r($queryData);
	$partnerId='';
	$partnerName='';
	$contactNum='';
	$partnerEmail='';
	$userName='';
	$password='';
	$address='';
	$urlLink='';
	$markupHotel='';
	$markupPackage='';
	
	//$userId = $_SESSION['admin_Id'];
	
	
	if($_GET['action'] == 'edit')
	{
		$id=$_GET['id'];
		$partnerData=$objAdmin->getPartnerById($id);
		//print_r($partnerData);exit;
		$partnerId=$partnerData[0]['id'];
		$partnerName=$partnerData[0]['partner_name'];
		$contactNum=$partnerData[0]['contact_no'];
		$partnerEmail=$partnerData[0]['email'];
		$userName=$partnerData[0]['user_name'];
		$password=$partnerData[0]['password'];
		$address=$partnerData[0]['address'];
        $urlLink=$partnerData[0]['url_link'];
		$markupHotel=$partnerData[0]['hotel_markup'];
		$markupPackage=$partnerData[0]['package_markup'];
		
	}
	
	//print_r($_SESSION);
	
	/*$empType = $_SESSION['employee_type'];   // Internal or external
	
	$source = $_SESSION['employee_Id'];
	if($_SESSION['user_type'] == 'admin')
	{
		$source = 'admin';
	}*/
	
?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Partner Registeration
				<small>Preview</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li><a href="#">Forms</a></li>
				<li class="active">Add Partner</li>
			</ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">			
				<div class="box-header with-border">
					<ul class="nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>Add Partner Form</b></h3></a></li>
					  
					</ul>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
					<form role="form" method="POST" name="addPartnerForm" id="addPartnerForm">
						<!-- <input type="hidden" name="userId" id="userId" value="<?php //echo $userId; ?>" >
						<input type="hidden" name="addedBy" id="addedBy" value="<?php //echo $empType; ?>" > -->
						<input type="hidden" name="type" id="type" value="add_partner" >
						<!-- <input type="hidden" name="source" id="source" value="<?php //echo $source; ?>" > -->
						<input type="hidden" name="partnerId" id="partnerId" value="<?php if(!empty($partnerId)){echo $partnerId;}else{echo 0;}?>" >
						<div class="box-body">
							<div class="row">
								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Partner Name</b><span style="color:red;">*</span></h4>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="text" class="form-control" name="partnerName" id="partnerName" placeholder="Partner Name" value="<?php echo $partnerName;?>"/>
									</div>
								</div><!-- /.form-group -->
								
								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Contact Number</b><span style="color:red;">*</span></h4>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="text" class="form-control" name="contactNum" id="contactNum" placeholder="Contact Number" value="<?php echo $contactNum;?>"/>
									</div>
								</div><!-- /.form-group -->
								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Email</b><span style="color:red;">*</span></h4>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="email" class="form-control" name="partnerEmail" id="partnerEmail" placeholder="Email Address" value="<?php echo $partnerEmail;?>"/>
									</div>
								</div><!-- /.form-group -->
								 <div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">User Name</b><span style="color:red;">*</span></h4>
									</div>
								</div> 
		
								 <div class="col-md-4">
									<div class="form-group">
										<input type="username" class="form-control" name="userName" id="userName" placeholder="User Name" value="<?php echo $userName;?>"/>
									</div>
								</div> 

								<div style="clear:both;"></div>
								<div class="col-md-2">
								<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Password</b><span style="color:red;">*</span></h4>
								</div>
							</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password;?>"/>
									</div>
								</div><!-- /.form-group -->

								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Address</b><span style="color:red;">*</span></h4>
									</div>
								</div>
		
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<textarea class="form-control" name="address" id="address" placeholder="Address"><?php echo $address;?></textarea>
									</div>
								</div>

								<div style="clear:both;"></div>
								<div class="col-md-2">
								<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">URL Link</b><span style="color:red;">*</span></h4>
								</div>
							</div>
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="urllink" class="form-control" name="urlLink" id="urlLink" placeholder="URL Link" value="<?php echo $urlLink;?>"/>
									</div>
									
								</div>
									<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Hotel Markup</b><span style="color:red;">*</span></h4>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="text" class="form-control" name="markupHotel" id="markupHotel" placeholder="Markup For Hotel" value="<?php echo $markupHotel;?>"/>
									</div>
								</div>

									<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Package Markup</b><span style="color:red;">*</span></h4>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="text" class="form-control" name="markupPackage" id="markupPackage" placeholder="Markup For Package" value="<?php echo $markupPackage;?>"/>
									</div>
								</div>
								
								
									
								
								<div style="clear:both;"></div>
							</div><!-- /.form-group -->
						</div><!-- /.form-group -->
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="addPartnerBtn" id="addPartnerBtn"><?php if(!empty($partnerId)){echo "UPDATE";}else{echo "SUBMIT";}?></button>
						</div>
					</form>			
				</div>
			</div>
		</div>	
	</div>
	</section>
</div>
<script src="ckeditor_4.4.5_full/ckeditor/ckeditor.js" type="text/javascript"></script>	
<script src="asset/bootstrap-datetimepicker.js"></script>
 <script src="asset/bootstrap-datepicker.js"></script>
<script>


$(document).ready(function(){
	//CKEDITOR.replace('details');
/*	var titleEditor = CKEDITOR.replace( 'details', {
		width:'auto',
		height:200,
		startupFocus : false,
		customConfig: 'ckeditor_customconfig/ckeditor_config.js'
	});
	*/
	
/*	$("#queryDate").datepicker({
	  format: "dd MM yyyy"
	});*/

	$("#addPartnerForm").validate({
		rules: {
                partnerName:"required",
                userName:"required",
				password:"required",
				address:"required",
				urlLink:"required",
				markupHotel:"required",
				markupPackage:"required",
		        contactNum:"required",
			    partnerEmail:"required"
		      },

		messages: {
			partnerName: "Please enter Partner Name",	
			userName: "Please enter User Name",						
	        password: "Please enter Password",
	        address: "Please enter Address",	
            urlLink: "Please enter URL Link",	
            markupHotel: "Please markup Hotel",	
            markupPackage: "Please markup Package",	
            contactNum: "Please enter Contact number",
			partnerEmail: "Please enter Email address"
			},
		
		submitHandler: function(){ 
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: "_ajax_partner_registration.php",
				data: $("#addPartnerForm").serialize(),
				cache: false,
				beforeSend:function(){
					
				},
				success: function(msg)
				{
					if(msg == 1){
						
						$("#status").show().html('<div class="alert alert-success">Saved Succefully</div>');
						
						window.setTimeout(function() {
							window.location.href = 'partner_list.php';
						}, 2000);
						
					}else{
						
						$("#status").show().html('<div class="alert alert-danger">Problem in Sending Data</div>');
						
					}
				}
			}); 
		}
	});
});
	
</script>		
<?php  
	include('footer.php');
?> 