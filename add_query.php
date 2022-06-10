<?php
	include('header.php');
	include('sidebar.php');
	
	$id='';
	$queryData='';
	//print_r($queryData);
	$queryId='';
	$queryNum='';
	$prsnName='';
	$orgName='';
	$prsnEmail='';
	$contactNum='';
	$queryDate='';
	$refrnce='';
	
	$userId = $_SESSION['admin_Id'];
	
	$details = '<table border="1" cellspacing="1" cellpadding="1" style="width:100%;"><tbody><tr><td style="width:60%;">Destination:</td><td style="min-width:40%"></td></tr><tr><td>Travel Dates:</td><td></td></tr><tr><td>Nights:</td><td></td></tr><tr><td>No. of Pax:</td><td></td></tr><tr><td>No. of Rooms Reqd.:</td><td></td></tr><tr><td>Hotel Category:</td><td></td></tr><tr><td>Vehicle Reqd.:</td><td></td></tr><tr><td>Meal Plan:</td><td></td></tr><tr><td>Other Req.:</td><td></td></tr></tbody></table>';
	if($_GET['action'] == 'edit')
	{
		$id=$_GET['id'];
		$queryData=$objAdmin->getQueryById($id);
		//print_r($queryData);
		$queryId=$queryData[0]['id'];
		$queryNum=$queryData[0]['query_no'];
		$prsnName=$queryData[0]['person_name'];
		$orgName=$queryData[0]['organisation'];
		$prsnEmail=$queryData[0]['email'];
		$contactNum=$queryData[0]['contact'];
		$queryDate=$queryData[0]['query_date'];
		$refrnce=$queryData[0]['reference'];
		$details=$queryData[0]['details'];
		$message=$queryData[0]['message'];
		$status=$queryData[0]['status'];
		$reason=$queryData[0]['reason'];
		$source=$queryData[0]['source'];
	}
	
	//print_r($_SESSION);
	
	$empType = $_SESSION['employee_type'];   // Internal or external
	
	$source = $_SESSION['employee_Id'];
	if($_SESSION['user_type'] == 'admin')
	{
		$source = 'admin';
	}
	
?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Query Management 
				<small>Preview</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li><a href="#">Forms</a></li>
				<li class="active">Add Query</li>
			</ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">			
				<div class="box-header with-border">
					<ul class="nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>Add Query Form</b></h3></a></li>
					  
					</ul>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
					<form role="form" method="POST" name="addQueryFrm" id="addQueryFrm">
						<input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>" >
						<input type="hidden" name="addedBy" id="addedBy" value="<?php echo $empType; ?>" >
						<input type="hidden" name="type" id="type" value="add_query" >
						<input type="hidden" name="source" id="source" value="<?php echo $source; ?>" >
						<input type="hidden" name="queryId" id="queryId" value="<?php if(!empty($queryId)){echo $queryId;}else{echo 0;}?>" >
						<div class="box-body">
							<div class="row">
								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Person Name</b><span style="color:red;">*</span></h4>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<input type="text" class="form-control" name="prsnName" id="prsnName" placeholder="Person Name" value="<?php echo $prsnName;?>"/>
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
										<input type="email" class="form-control" name="prsnEmail" id="prsnEmail" placeholder="Email Address" value="<?php echo $prsnEmail;?>"/>
									</div>
								</div><!-- /.form-group -->
								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Message</b></h4>
									</div>
								</div>
		
								<div class="col-md-4">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<textarea class="form-control" name="message" id="message" placeholder="Message"><?php echo $message;?></textarea>
									</div>
								</div><!-- /.form-group -->
								<div style="clear:both;"></div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Detail</b></h4>
									</div>
								</div>
									
								<div class="col-md-6">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<textarea class="form-control" name="details" id="details" placeholder="Details">
												
										<?php echo $details;?>
										
										</textarea>
									</div>
								</div><!-- /.form-group -->
								<div style="clear:both;"></div>
								<div class="col-md-2" style="display: none;">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Status</b></h4>
									</div>
								</div>
								<div class="col-md-6" style="display: none;">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<select class="form-control" name="status" id="status">
											<option value="0" style="color:orange" <?php if($status == '0'){echo 'selected';}?>>Reply Pending</option>
											<option value="1" style="color:blue" <?php if($status == '1'){echo 'selected';}?>>Replied & Ongoing</option>
											<option value="2" style="color:green" <?php if($status == '2'){echo 'selected';}?>>Confirmed</option>
											<option value="3" style="color:red" <?php if($status == '3'){echo 'selected';}?>>Cancelled</option> 
											<option value="4" style="color:cyan" selected <?php if($status == '4'){echo 'selected';}?>>Open</option>
										</select>
										
									</div>
								</div><!-- /.form-group -->
								
								<div style="clear:both;"></div>
								<div class="col-md-2" style="display: none;">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Status Reason</b></h4>
									</div>
								</div>
									
								<div class="col-md-6" style="display: none;">
									<div class="form-group">
										<!--<label for="name">Title</label>-->
										<textarea class="form-control" name="reason" id="reason" placeholder="Status Reason"><?php echo $reason;?></textarea>
									</div>
								</div><!-- /.form-group -->
								<div style="clear:both;"></div>
							</div><!-- /.form-group -->
						</div><!-- /.form-group -->
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="addQueryBtn" id="addQueryBtn"><?php if(!empty($queryId)){echo "UPDATE";}else{echo "SUBMIT";}?></button>
						</div>
					</form>			
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
	var titleEditor = CKEDITOR.replace( 'details', {
		width:'auto',
		height:200,
		startupFocus : false,
		customConfig: 'ckeditor_customconfig/ckeditor_config.js'
	});
	
	
	$("#queryDate").datepicker({
	  format: "dd MM yyyy"
	});
	$("#addQueryFrm").validate({
		rules: {
			queryNum: "required",				
			queryDate: "required",				
			prsnName: "required",				
			orgName: "required",				
			contactNum:{
				required:true,
				number:true
			},
			prsnEmail:{
				required:true,
				email:true
			}
		},
		messages: {
			queryNum: "Please enter Query number",				
			queryDate: "Please select Query Date",				
			prsnName: "Please enter Person name",				
			orgName: "Please enter Organization name",				
			contactNum:{
				required:"Please enter Contact number",
				number:"Only number/digit is allowed"
			},
			prsnEmail:{
				required:"Please enter Email address",
				email:"Please enter valid Email address"
			}
		},
		submitHandler: function(){ 
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: "_ajax_query_management.php",
				data: $("#addQueryFrm").serialize(),
				cache: false,
				beforeSend:function(){
					
				},
				success: function(msg)
				{
					if(msg == 1){
						
						$("#status").show().html('<div class="alert alert-success">Saved Succefully</div>');
						
						window.setTimeout(function() {
							window.location.href = 'view_query.php';
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