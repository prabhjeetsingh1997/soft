<?php
include('header.php');
include('sidebar.php');
//echo "ffsdfsdf";
//die;
/* if(!isset($_GET['t']))
{
	$tab = 1;
}
else
{
	$tab = $_GET['t'];
}  */
$editUserId=0;
$countDiv=''; 

$staticArr = array('Biodata','Educational Proof','Appointment Letter','PAN Card','Photo','Address Proof','Adhaar Card','Passport');

$showPrevBtn = 0;
if($_GET['action']=='edit')
{
	$showPrevBtn = 1;
	$editUserId=$_GET['id'];
	$usrData = $objAdmin->getUsrById($editUserId);
	$arrEmail=explode(',',$usrData['email_address']);
	//print_r($arrEmail);
	
	$phone_number=$objAdmin->getPhoneNumbers($editUserId, 'employee', 'personal');
	$phone_number1=$objAdmin->getPhoneNumbers($editUserId, 'employee', 'Emergency');
	
	$address_details = $objAdmin->getaddressById($editUserId,'Permanent');
	$address_details1 = $objAdmin->getaddressById($editUserId,'Current');
	$attachdoc = $objAdmin->getdocumentbyid($editUserId,'Employee');
	//echo "<pre>";print_r($attachdoc);
	$ttlDoc=count($attachdoc);
	$countPrsnNum=count($phone_number);  
	$countEmrgNum=count($phone_number1);
	$countEmail=count($arrEmail);
	$countPrmntAddr=count($address_details);
	$countCurrAddr=count($address_details1);
	$action = 'editUser';
	//print_r($usrData);
	
	//print_r($attachdoc);
	//print_r($staticArr);
	
	$docsStaticArr = array();
	$docsArr = array();
	$docsCustArr = array();
	foreach($attachdoc as $docs)
	{
		$docsArr[$docs['name']]['id'] = $docs['id'];
		$docsArr[$docs['name']]['doc'] = $docs['doc'];
		if(in_array($docs['name'], $staticArr))
		{
			$docsStaticArr[] = $docs;
		}
		else
		{
			$docsCustArr[] = $docs;
		}
	}
} 
else{
	$action = 'addUser';
}

$arrDesignation=$objAdmin->getAllDesignation();
$arrDepartment=$objAdmin->getAllDepartment();
//print_r($arrDepartment);
$tab = 1;
if(isset($_GET['t']))
{
	$tab = base64_decode($_GET['t']);
}
$tabUrl = 'addUser.php?t=';
if(isset($_GET['action']))
{
	$tabUrl = 'addUser.php?action=edit&id='.$_GET['id'].'&t=';
}
$arrcountery=$objAdmin->get_countery();
$arrAllState=$objAdmin->get_stateAll();
$arrAllCity=$objAdmin->get_cityAll('');
//print_r($arrAllState);

$autoempId = $objAdmin->autogenerate_id($_SESSION['added_emp_id'], 'E');
$url= trim($_SERVER['HTTP_HOST'], '/'); 
if (!preg_match('#^http(s)?://#', $url)) 
{    
 $url = 'http://' . $url;
}
$urlParts = parse_url($url); 
$domain = preg_replace('/^www\./', '', $urlParts['host']);
?>
?>
<link href="uploadify/uploadify.css" rel="stylesheet">
<style>
.v_hidden{ visibility:hidden !important}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<?php // print_r($address_details); ;?>
		<h1>
			Employee Form
			<small>Preview</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Add Employee</li>
		</ol>
	</section>
	
	<!-- Main content -->
    <section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				 <ul class="nav nav-tabs">
				  <li <?php if($tab == 1){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 1){ echo 'class="disabled"';}?> href="#home" title="Use Next Button to open"> <h3 class="box-title"><b>PERSONAL DETAILS</b></h3></a></li>
				  <li <?php if($tab == 2){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 2){ echo 'class="disabled"';}?> id="official_detail" href="#menu1" title="Use Next Button to open"><h3 class="box-title"><b>OFFICIAL DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 3){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 3){ echo 'class="disabled"';}?> id="banking_detail" href="#menu2" title="Use Next Button to open"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 4){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 4){ echo 'class="disabled"';}?> id="attached_document" href="#menu3" title="Use Next Button to open"><h3 class="box-title"><b>ATTACHED DOCUMENTS</b></h3> </a></li>
				
				</ul>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
			</div>
			<div class="tab-content">
				<!--Personal Detail Starts Here-->
				<div id="home" class="tab-pane fade  <?php if($tab == 1){ echo 'in active';}?>">
					<form role="form" method="POST" name="add_User" id="add_User">
						<input type="hidden" id="permAddCount" name="permAddCount" value="1"> 
						<input type="hidden" id="currAddCount" name="currAddCount" value="1"> 
						<input type="hidden" id="emNumbrCount" name="emNumbrCount" value="<?php if($countEmrgNum>1){echo $countEmrgNum; }else{echo 1;}?>"> 
						<input type="hidden" id="contactNumCount" name="contactNumCount" value="<?php if($countPrsnNum>1){echo $countPrsnNum; }else{echo 1;}?>"> 
						<input type="hidden" id="PerEmailCount" name="PerEmailCount" value="<?php if($countEmail>1){echo $countEmail; }else{echo 1;}?>"> 
						<input type="hidden" id="action" name="action" value="<?php echo $action; ?>"> 
						<input type="hidden" name="userId" value="<?php echo @$usrData['admin_id']; ?>" />
						<input type="hidden" name="partner_url" value="<?php echo @$domain; ?>" />
						<div class="box-body">
							<div class="row">
								<!-- Frist Line -->	
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Name </b><span style="color:red;">*</span></h4>
									</div>
								</div>
							<div class="col-md-10" style="padding:0;">
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="title">Title</label>-->
										<select class="form-control" name="name_prefix" id="name_prefix">
											<option value="">--</option>
											<option  value="Mr." <?php if(@$usrData['name_perfix'] == 'Mr.'){echo "selected";}?>>Mr.</option>
											<option value="Miss." <?php if(@$usrData['name_perfix'] == 'Miss.'){echo "selected";}?>>Miss.</option>
											<option value="Mrs." <?php if(@$usrData['name_perfix'] == 'Mrs.'){echo "selected";}?>>Mrs.</option>
											<option value="Ms." <?php if(@$usrData['name_perfix'] == 'Ms.'){echo "selected";}?>>Ms.</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="firstname">First Name</label>-->
										<input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value="<?php echo $usrData['first_name']; ?>"/>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="middle">Middle Name</label>-->
										<input type="text" class="form-control" name="middle" id="middle" placeholder="Middle Name" value="<?php echo $usrData['middle_name']; ?>"/>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="last">Last Name</label>-->
										<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo $usrData['last_name']; ?>"/>
									</div>
								</div>
							</div>
								<!--END Frist Line -->
								<!--Second line -->
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	Contact Nos </b><span style="color:red;">*</span></h4>
									</div>
								</div>
							<div class="col-md-10" style="padding:0">	
								<div class="items3">
								<?php
									if($countPrsnNum>0){
									$countDiv=1;
									foreach($phone_number as $key=>$val){
								?>
								
								<div id="Mobnumbbr_<?php echo $countDiv;?>">
									<div style="clear:both"></div>	
									<input type="hidden" name="contactNumId[]" id="contactNumId" value="<?php echo @$val['id'];?>"/>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Mobile</label>-->
											<input type="number" class="form-control" name="userMobile[]" placeholder="Mobile Number" value="<?php echo $val['contact_no']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">Code</label>-->
											<select class="form-control" name="code[]" placeholder="Code" value="">
												<option value="">-----SELECT-----</option>
												<option value="Mobile" <?php if($val['code'] == 'Mobile'){echo "selected";}?>>Mobile</option>
												<option value="Home" <?php if($val['code'] == 'Home'){echo "selected";}?>>Home</option>
												<option value="Work" <?php if($val['code'] == 'Work'){echo "selected";}?>>Work</option>
												<option value="Main" <?php if($val['code'] == 'Main'){echo "selected";}?>>Main</option>
												<option value="WorkFax" <?php if($val['code'] == 'WorkFax'){echo "selected";}?>>Work Fax</option>
												<option value="HomeFax" <?php if($val['code'] == 'HomeFax'){echo "selected";}?>>Home Fax</option>
												<option value="Pager" <?php if($val['code'] == 'Pager'){echo "selected";}?>>Pager</option>
												<option value="Other" <?php if($val['code'] == 'Other'){echo "selected";}?>>Other</option>
											</select>
										</div>
									</div>
									<!--<div class="col-md-3 v_hidden" >
										<div class="form-group">
											<input type="text" class="form-control" name="phoneNum[]" placeholder="Enter Valid Number" value=""/>
										</div>
									</div>-->
									<?php
										if($countDiv > 1){
									?>
									<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_item2(<?php echo $countDiv; ?>, <?php echo @$val['id'];?>, 'main')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
									<?php	
										}
									?>
								</div>
								<?php 
									$countDiv++;
									}
								?>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php	
								}else{
								?>
								<input type="hidden" name="contactNumId[]" id="contactNumId" value="0"/>
								<div id="Mobnumbbr_1">
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Mobile</label>-->
											<input type="number" class="form-control" name="userMobile[]" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">Code</label>-->
											<select class="form-control" name="code[]" placeholder="Code" value="">
												<option value="">-----SELECT-----</option>
												<option value="Mobile">Mobile</option>
												<option value="Home">Home</option>
												<option value="Work">Work</option>
												<option value="Main">Main</option>
												<option value="WorkFax">Work Fax</option>
												<option value="HomeFax">Home Fax</option>
												<option value="Pager">Pager</option>
												<option value="Other">Other</option>
											</select>
										</div>
									</div>
									<div class="col-md-3 v_hidden" >
										<div class="form-group">
											<!--<label for="last">Enter valid Number</label>-->
											<input type="text" class="form-control" name="phoneNum[]" placeholder="Enter Valid Number" value=""/>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php
								}
								?>
								</div>
							</div>
								<!--Second line End-->
								<!--Third line -->
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Email </b><span style="color:red;">*</span></h4>

									</div>
								</div> 
								<div class="items4">
									<?php
										if($countEmail>0){
											$k=1;
											
											for($k=1;$k<=$countEmail;$k++){
												
										?>
											
										<div id="Email_<?php echo $k;?>">
											
											<?php
											if($k>1){
											?>
												<div class="clearfix"></div>
												<div class="col-md-2"><div class="form-group"></div></div>
											<?php
												}
											?>
											<div class="col-md-5">
												<div class="form-group">
													<!--<label for="userEmail" >Email</label>-->
													<input type="email" class="form-control" name="userEmail[]" placeholder="Email" value="<?php echo $arrEmail[$k-1]; ?>" />
												</div>
											</div>
											<?php
												if($k>1){
											?>
											<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $k; ?>" href="javascript:void(0)" onclick="remove_item1(<?php echo $k; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
											<?php
												}
											?>
											
										</div>
									<?php
										if($k==1){
									?>
									
									<?php
											}
										}
									?>
									<div class="col-md-1">
										<div class="form-group">
											<!--<label for="last">Add More</label>-->
											<a href="javascript:void(0);" class="emails" id="emails" title="Add More Emails" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>
									<?php	
									}else{
									?>
									<div id="Email_1" >
										<div class="col-md-5">
											<div class="form-group">
												<!--<label for="userEmail" >Email</label>-->
												<input type="email" class="form-control" name="userEmail[]" placeholder="Email" value="" />
											</div>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<!--<label for="last">Add More</label>-->
											<a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>
									<?php
									}
									?>
								</div>
								<!--Third Line End-->
								<div class="clearfix"></div>
								<!--Fourth Line-->
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	Father Name </b></h4>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="title">Title</label>-->
										<select class="form-control" name="faPrefix">
											<option>--</option>
											<option value="Mr." <?php if(@$usrData['father_name_perfix'] == 'Mr.'){echo "selected";}?>>Mr.</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="name">First Name</label>-->
										<input type="text" class="form-control" name="faFName" id="faFName" placeholder="Father Name" value="<?php echo @$usrData['father_first_name']; ?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="middle">Middle Name</label>-->
										<input type="text" class="form-control" name="faMName" id="faMName" placeholder="Middle Name" value="<?php echo @$usrData['father_middle_name']; ?>"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="last">Last Name</label>-->
										<input type="text" class="form-control" name="faLName" id="faLName" placeholder="Last Name" value="<?php echo @$usrData['father_last_name']; ?>"/>
									</div>
								</div>
								<!--End Fourth Line-->
								<div class="clearfix"></div>
								<!--Fifth Line-->
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Mother Name </b></h4>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="title">Title</label>-->
										<select class="form-control" name="moPrefix">
										<option>--</option>
										<option value="Ms." <?php if(@$usrData['mother_name_prefix'] == 'Ms.'){echo "selected";}?> >Ms.</option>
										<option value="Mrs." <?php if(@$usrData['mother_name_prefix'] == 'Mrs.'){echo "selected";}?> >Mrs.</option>
										<!--<option value="Mrs.">Mrs.</option>-->
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="name">First Name</label>-->
										<input type="text" class="form-control" name="MoFname" id="MoFname" placeholder="First Name" value="<?=$usrData['mother_first_name']; ?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="middle">Middle Name</label>-->
										<input type="text" class="form-control" name="MoMname" id="MoMname" placeholder="Middle Name" value="<?=$usrData['mother_middle_name']; ?>"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="last">Last Name</label>-->
										<input type="text" class="form-control" name="MoLname" id="MoLname" placeholder="Last Name" value="<?=$usrData['mother_last_name']; ?>"/>
									</div>
								</div>
								<!--End Fifth Line-->
								<div class="clearfix"></div>
								<!--Sixth Line-->
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	D.O.B </b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
										<div class='input-group date' >
										<input type='text' class="form-control" id="dob" name="dob"  
										value="<?php if(isset($usrData['data_of_birth'])){echo date('j M Y',strtotime($usrData['data_of_birth']));}?>"/>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										</div>
									</div>
									</div>
								</div>
								<!--End sixth Line-->
								<div class="clearfix"></div>
								<!--Seventh Line-->
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Emergency Nos </b></h4>
									</div>
								</div>
									
								<div class="items2">
									<?php if($countEmrgNum>0){
										$countDiv=1;
										foreach($phone_number1 as $key=>$val){
									?>
										
									<div id="EmNumber_<?php echo $countDiv;?>" >
										<?php
										if($countDiv>1){
										?>
										<div class="clearfix"></div>
										<div class="col-md-2"><div class="form-group"></div></div>
										<?php
										}
										?>
										<input type="hidden" name="emergNumId[]" id="emergNumId" value="<?php echo @$val['id'];?>"/>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="userPhone">Mobile</label>-->
												<input type="number" class="form-control" name="EmergencyMObNum[]" placeholder="Mobile Number" value="<?php echo @$val['contact_no']; ?>"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="middle">Code</label>-->
													<select class="form-control" name="EmrCode[]" placeholder="Code" value="">
														<option value="">-----SELECT-----</option>
														<option value="Mobile" <?php if(@$val['code'] == 'Mobile'){echo "selected";}?> >Mobile</option>
														<option value="Home" <?php if(@$val['code'] == 'Home'){echo "selected";}?>>Home</option>
														<option value="Work" <?php if(@$val['code'] == 'Work'){echo "selected";}?>>Work</option>
														<option value="Main" <?php if(@$val['code'] == 'Main'){echo "selected";}?>>Main</option>
														<option value="WorkFax" <?php if(@$val['code'] == 'WorkFax'){echo "selected";}?>>Work Fax</option>
														<option value="HomeFax" <?php if(@$val['code'] == 'HomeFax'){echo "selected";}?>>Home Fax</option>
														<option value="Pager" <?php if(@$val['code'] == 'Pager'){echo "selected";}?>>Pager</option>
														<option value="Other" <?php if(@$val['code'] == 'Other'){echo "selected";}?>>Other</option>
													</select>
											</div>
										</div>
										<!--<div class="col-md-3 v_hidden">
											<div class="form-group">
												<select class="form-control" name="EmrPhoneNum[]" placeholder="Enter Valid Number" value=""><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select>
											</div>
										</div>-->
										<?php
											if($countDiv>1){
										?>
										<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_item2(<?php echo $countDiv; ?>, <?php echo @$val['id'];?>, 'emergency')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
										<?php
											}
										?>
									</div>
									<?php
									$countDiv++;
										}
									?>
									<div class="col-md-1">
										<div class="form-group">
											<!--<label for="last">Add More</label>-->
											<a href="javascript:void(0);" class="Emnumbbr" id="Emnumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>
									<?php	
									}else{
									?>
									<div id="EmNumber_1" >
										<input type="hidden" name="emergNumId[]" id="emergNumId" value="0"/>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="userPhone">Mobile</label>-->
												<input type="number" class="form-control" name="EmergencyMObNum[]" placeholder="Mobile Number" value=""/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="middle">Code</label>-->
													<select class="form-control" name="EmrCode[]" placeholder="Code" value="">
														<option value="">-----SELECT-----</option>
														<option value="Mobile">Mobile</option>
														<option value="Home">Home</option>
														<option value="Work">Work</option>
														<option value="Main">Main</option>
														<option value="WorkFax">Work Fax</option>
														<option value="HomeFax">Home Fax</option>
														<option value="Pager">Pager</option>
														<option value="Other">Other</option>
													</select>
											</div>
										</div>
										<div class="col-md-3 v_hidden">
											<div class="form-group">
												<!--<label for="last">Enter valid Number</label>-->
												<select class="form-control" name="EmrPhoneNum[]" placeholder="Enter Valid Number" value=""><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select>
											</div>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<!--<label for="last">Add More</label>-->
											<a href="javascript:void(0);" class="Emnumbbr" id="Emnumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>
									<?php
									}
									?>
								</div>
								<!--End seventh Line-->
								<div class="clearfix"></div>
								<!--Eight Line-->
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 16px;">	Permanent Address </b><span style="color:red;">*</span></h4>
									</div>
								</div>
							   <div class="col-md-10" style="padding:0;">
								<div class="items">
									<?php
										if($countPrmntAddr>0){
											$countDiv=1;
											foreach($address_details as $key=>$val){
												//print_r($val);
									?>
									
									<div id="address_<?php echo $countDiv;?>">
										<?php
											if($countDiv>1){
										?>
										<div class="col-md-2"><div class="form-group"></div></div>
										<?php
											}
										?>
										<input type="hidden" name="prmntAddrId[]" id="prmntAddrId" value="<?php echo @$val['id'];?>"/>
										<div class="col-md-6">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 1</label>-->
												<input type="text" class="form-control" name="pramAdd1[]" placeholder="Address line 1" value="<?php echo @$val['address1']; ?>"/>
											</div>
										</div>
									
										<div class="col-md-5">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 2</label>-->
												<input type="text" class="form-control" name="pramAdd2[]" placeholder="Address line 2" value="<?php echo @$val['address2']; ?>"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="userPhone">Country</label>-->
												<!--<input type="text" class="form-control" name="pramCountry[]" placeholder="Country" value="<?php echo @$val['country']; ?>"/>-->
												<select class="form-control select2" name="pramCountry[]" id="pramCountry" data-placeholder="Select a Country">
													<option value="">--Select Country--</option>
													<?php
														foreach($arrcountery as $count)
														{ 
													?>	
														<option value="<?php echo $count['id']; ?>" <?php if($count['id'] == @$val['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
													<?php		
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="last">State</label>
												<input type="text" class="form-control" name="pramState[]" placeholder="State" value="<?php echo @$val['state']; ?>"/>-->
												<select class="form-control select2" name="pramState[]" id="pramState" data-placeholder="Select a State">
													<option value="">--Select State--</option>
													<?php
													$arrState=$objAdmin->get_state($val['country']);
														foreach($arrState as $k=>$value)
														{
															//foreach($arrStateId as $value)
															//{
															
													?>
														<option value="<?php echo $value['id'];?>" <?php if($value['id'] == $val['state']){echo "selected";}?>><?php echo $value['state_name'];?></option>
													<?php
															//}
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="middle">City</label>-->
												<!--<input type="text" class="form-control" name="pramCity[]" placeholder="City" value="<?php echo @$val['city']; ?>"/>-->
												<select class="form-control select2" name="pramCity[]" id="pramCity" data-placeholder="Select a City">
													<option value="">--Select City--</option>
													<?php
														$newCityArr =$objAdmin->get_city($val['state']);
														foreach($newCityArr as $k=>$value)
														{
															
															//foreach($arrCityId as $value)
															//{
													?>
													<option value="<?php echo $value['id'];?>" <?php if($value['id'] == $val['city']){echo "selected";}?>><?php echo $value['city'];?></option>
													<?php
															//}
															
														}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-2">
											<div class="form-group">
												<!--<label for="last">Pin Code</label>-->
												<input type="text" class="form-control" name="pramPin[]" placeholder="Code" value="<?php echo @$val['pin_code']; ?>"/>
											</div>
										</div>
									</div>
									<?php
										if($countDiv==1){
									?>
										<!--<div class="col-md-1">
											<div class="form-group">
												
												<a href="javascript:void(0);" class="add_Morepram_add" id="add_Morepram_add" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
											</div>
										</div>-->
									
									<?php
												}
										$countDiv++;
											}
										}else{
									?>
									<div id="address_1">
									   <input type="hidden" name="prmntAddrId[]" id="prmntAddrId" value="0"/>
										<div class="col-md-6">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 1</label>-->
												<input type="text" class="form-control" name="pramAdd1[]" id="pramAdd1" placeholder="Address line 1" value=""/>
											</div>
										</div>
									
										<div class="col-md-5">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 2</label>-->
												<input type="text" class="form-control" name="pramAdd2[]" id="pramAdd2" placeholder="Address line 2" value=""/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="userPhone">Country</label>-->
												<!--<input type="text" class="form-control" name="pramCountry[]" id="pramCountry" placeholder="Country" value=""/>-->
												<select class="form-control select2" name="pramCountry[]" id="pramCountry" data-placeholder="Select a Country">
													<option value="">--Select Country--</option>
													<?php
														foreach($arrcountery as $count)
														{ 
													?>	
														<option value="<?php echo $count['id']; ?>"><?php echo $count['country_name']; ?></option>
													<?php		
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="last">State</label>-->
												<!--<input type="text" class="form-control" name="pramState[]" id="pramState" placeholder="State" value=""/>-->
												
												<select class="form-control select2" name="pramState[]" id="pramState" data-placeholder="Select a State">
													<option value="">--Select State--</option>
													<?php
														foreach($arrState as $key=>$val)
														{	
													?>
														<option value="<?php echo $val['id'];?>" ><?php echo $val['state_name'];?></option>
													<?php	
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="middle">City</label>-->
												<!--<input type="text" class="form-control" name="pramCity[]" id="pramCity" placeholder="City" value=""/>-->
												<select class="form-control select2" name="pramCity[]" id="pramCity" data-placeholder="Select a City">
													<option value="">--Select City--</option>
													<?php
														
														foreach($newCityArr as $key=>$val)
														{
													?>
													<option value="<?php echo $cityId;?>" <?php if($value == $cityId){echo "selected";}?>><?php echo $city_name;?></option>
													<?php	
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<!--<label for="last">Pin Code</label>-->
												<input type="text" class="form-control" name="pramPin[]" id="pramPin" placeholder="Code" value=""/>
											</div>
										</div>
									</div>
									
									<!--<div class="col-md-1">
										<div class="form-group">
											
											<a href="javascript:void(0);" class="add_Morepram_add" id="add_Morepram_add" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>-->
									<?php
									}
									?>
								</div>
								</div>
								<!--End Eight Line-->
								<!--Ninth Line-->
								<div class="clearfix"></div>
								<!--End Ninth Line-->
								<!--End Tenth Line-->
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 16px;">	Current Address </b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10" style="padding:0;">	
								<div class="items1">
									<?php
										if($countCurrAddr>0){
										$countDiv=1;
										foreach($address_details1 as $key=>$val){
									?>
								
									<div id="address2_<?php echo $countDiv;?>" >
										<?php
											if($countDiv>1){
										?>
											<div class="col-md-2"><div class="form-group"></div></div>
										<?php
											}
										?>
										<input type="hidden" name="currAddId[]" id="currAddId" value="<?php echo @$val['id'];?>"/>
										<div class="col-md-6">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 1</label>-->
												<input type="text" class="form-control" name="currAdd1[]" placeholder="Address line 1" value="<?php echo @$val['address1']; ?>"/>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 2</label>-->
												<input type="text" class="form-control" name="currAdd2[]" placeholder="Address line 2" value="<?php echo @$val['address2']; ?>"/>
											</div>
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="userPhone">Country</label>-->
												<!--<input type="text" class="form-control" name="currCountry[]" placeholder="Country" value="<?php echo $val['country']; ?>"/>-->
												<select class="form-control select2" name="currCountry[]" id="currCountry" data-placeholder="Select a Country">
													<option value="">--Select Country--</option>
													<?php
														foreach($arrcountery as $count)
														{ 
													?>	
														<option value="<?php echo $count['id']; ?>" <?php if($count['id'] == $val['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
													<?php		
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="last">State</label>-->
												<!--<input type="text" class="form-control" name="currState[]" placeholder="State" value="<?php echo @$val['state']; ?>"/>-->
												<select class="form-control select2" name="currState[]" id="currState" data-placeholder="Select a State">
													<option value="">--Select State--</option>
													<?php
													$arrState=$objAdmin->get_state($val['country']);
														foreach($arrState as $k=>$value)
														{
															//foreach($arrStateId as $value)
															//{
															
													?>
														<option value="<?php echo $value['id'];?>" <?php if($value['id'] == $val['state']){echo "selected";}?>><?php echo $value['state_name'];?></option>
													<?php
															//}
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<!--<label for="middle">City</label>-->
												<!--<input type="text" class="form-control" name="currCity[]" placeholder="City" value="<?php echo @$val['city']; ?>"/>-->
												<select class="form-control select2" name="currCity[]" id="currCity" data-placeholder="Select a City">
													<option value="">--Select City--</option>
													<?php
														$newCityArr =$objAdmin->get_city($val['state']);
														foreach($newCityArr as $k=>$value)
														{
															
															//foreach($arrCityId as $value)
															//{
													?>
													<option value="<?php echo $value['id'];?>" <?php if($value['id'] == $val['city']){echo "selected";}?>><?php echo $value['city'];?></option>
													<?php
															//}
															
														}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-2">
											<div class="form-group">
												<!--<label for="last">Pin Code</label>-->
												<input type="text" class="form-control" name="currPin[]" placeholder="Code" value="<?php echo @$val['pin_code']; ?>"/>
											</div>
										</div>
									</div>
									<?php
									if($countDiv == 1){
									?>
									
								<?php
											}
									$countDiv++;
										}
									}else{
								?>
									<div id="address2_1" >
										<input type="hidden" name="currAddId[]" id="currAddId" value="0"/>
										<div class="col-md-6">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 1</label>-->
												<input type="text" class="form-control" name="currAdd1[]" id="currAdd1" placeholder="Address line 1" value=""/>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<!--<label for="userPhone">Address Line 2</label>-->
												<input type="text" class="form-control" name="currAdd2[]" id="currAdd2" placeholder="Address line 2" value=""/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												
												<select class="form-control select2" name="currCountry[]" id="currCountry" data-placeholder="Select a Country">
													<option value="">--Select Country--</option>
													<?php
														foreach($arrcountery as $count)
														{ 
													?>	
														<option value="<?php echo $count['id']; ?>"><?php echo $count['country_name']; ?></option>
													<?php		
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												
												<select class="form-control select2" name="currState[]" id="currState" data-placeholder="Select a State">
													<option value="">--Select State--</option>
													<?php
														foreach($arrAllState as $key=>$val)
														{
															
															
													?>
														<option value="<?php echo $val['id'];?>"><?php echo $val['state_name'];?></option>
													<?php
															
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												
												<select class="form-control select2" name="currCity[]" id="currCity" data-placeholder="Select a City">
													<option value="">--Select City--</option>
													<?php
														
														foreach($arrAllCity as $key=>$val)
														{
															$city_name = $val['city'];
															$cityId = $val['id'];
															
													?>
													<option value="<?php echo $cityId;?>"><?php echo $city_name;?></option>
													<?php
															
															
														}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-2">
											<div class="form-group">
												<!--<label for="last">Pin Code</label>-->
												<input type="text" class="form-control" name="currPin[]" id="currPin" placeholder="Code" value=""/>
											</div>
										</div>
									</div>
									
									<?php
									}
									?>
								</div>
								</div>
								<div class="clearfix"></div>
								<!--End Tenth Line-->
								<?php
									if(@$usrData['admin_id']==''){
								?>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-2"></div>
										<div class="form-group col-md-9">
											<input type="checkbox" id="sameAsPrmntBtn"/>Same as Permanent
										</div>
									</div>
								</div>
								<?php
									}
								?>
							</div>
							
						</div>
						<div class="box-footer">
							
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
						</div>
					</form>
				</div>
				<!--Personal Detail End Here-->
				<!--Official Detail Starts Here-->
				<div id="menu1" class="tab-pane fade <?php if($tab == 2){ echo 'in active';}?>">
					<form method="POST" name="official_detailfrm" id="official_detailfrm">
						<input type="hidden" name="userId" value="<?php echo @$usrData['admin_id']; ?>" />
									<div class="box-body">
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Employee ID</b><span style="color:red;">*</span></h4>
									</div>
								</div>
							
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">Employee ID</label>-->
										<input type="text" class="form-control " name="empId" id="empId" placeholder="Employee ID" value="<?php echo $autoempId; ?>" readonly />
									</div>
								</div>
								</div>
								<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Password</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Password</label>-->
										<input type="text" class="form-control" name="userPass" id="userPass" placeholder="Password" value="<?php echo @$usrData['user_password']; ?>"/>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Designation</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label>Designation</label>-->
										<select class="form-control" name="designation" id="designation">
											<option value="">-----SELECT-----</option>
											<?php
												foreach($arrDesignation as $key=>$val){
											?>
											<option value="<?php echo $val['designation_id'];?>" <?php if(@$usrData['designation'] == @$val['designation_id']){echo "selected";}?>><?php echo $val['designation_name'];?></option>
											<?php
												}
											?>
											<option value="Add New">Add New</option>
										</select>
									</div>
								</div><!-- /.form-group -->
								</div>


								<div class="col-md-12"  id="desigDiv" style="display:none;">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
											
											</div>
										</div>
										<div class="col-md-3 form-group" >
											
											<input type="text" class="form-control" name="newDesignation" id="newDesignation" value="" placeholder="Add New Designation"/>
											
										</div>
										<div class="form-group col-md-3">
											<button type="button" class="btn btn-primary" name="submitDesignation" id="submitDesignation">Add</button>
										</div>
										<div class="form-group col-md-3">
											<div id="designStatus"></div>
										</div>
									</div>
								</div>
								
								<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Department</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Department</label>-->
										<select class="form-control" name="department" id="department">
										<option value="">-----SELECT-----</option>
										<?php
											foreach($arrDepartment as $key=>$val){
										?>
										<option value="<?php echo @$val['department_id'];?>" <?php if(@$usrData['department'] == @$val['department_id']){echo "selected";}?>><?php echo @$val['department_name'];?></option>
										<?php
											}
										?>
										<option value="Add New">Add New</option>
										</select>
									</div>
								</div><!-- /.form-group -->
								</div>

								<div class="col-md-12"  id="departDiv" style="display:none;">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												
											</div>
										</div>
										
										<div class="col-md-3 form-group">
											<input type="text" class="form-control" name="newDepart" id="newDepart" value="" placeholder="Add New Department" />
										</div>
										<div class="form-group col-md-3">
											<button type="button" class="btn btn-primary" name="submitDepartment" id="submitDepartment">Add</button>
										</div>
										<div class="form-group col-md-3">
											<div id="departStatus"></div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Joining Date</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
											<div class='input-group date' >
											<input type='text' class="form-control emp_datePicker" name="joingDate" id="joingDate" value="<?php if(isset($usrData['joining_date'])){echo date('j M Y',strtotime($usrData['joining_date']));}?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
											</div>
										</div>
									</div>
								</div>
								</div>
								<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Termination Date</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
											
											<div class='input-group date' >
												<input type='text' class="form-control emp_datePicker" name="terminationDate" id="terminationDate" value="<?php if($usrData['termination_date'] != '0000-00-00' && isset($clientData['anniversary_date'])){echo date('j M Y',strtotime($usrData['termination_date']));}?>"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Employee Type</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Department</label>-->
										<select class="form-control" name="empType" id="empType">
										<option value="">--Select--</option>
										<option value="1">Internal</option>
										<option value="0">External</option>
										
										</select>
									</div>
								</div><!-- /.form-group -->
							</div>
							</div>
						</div>
						<div class="box-footer">
							<?php if($showPrevBtn){?>
							<a href="<?php echo $tabUrl.base64_encode($tab-1); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
							<?php } ?>
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
						</div>
					</form>
				</div>
				<!--Official Detail End Here-->
				<!--Banking Detail Starts Here-->
				<div id="menu2" class="tab-pane fade <?php if($tab == 3){ echo 'in active';}?>">
					<form role="form" method="POST" name="banking_detailFrm" id="banking_detailFrm">
						<input type="hidden" name="userId" value="<?php echo @$usrData['admin_id']; ?>" />
						<div class="box-body">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">PAN No.</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">PAN No.</label>-->
										<input type="text" class="form-control " name="panNum" id="panNum" placeholder="PAN No." value="<?php echo @$usrData['pan_number'];?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Account No.</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">Account No.</label>-->
										<input type="text" class="form-control " name="accNumber" id="accNumber" placeholder="Account No." value="<?php echo @$usrData['account_number'];?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Account Name</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">Account Name</label>-->
										<input type="text" class="form-control " name="accName" id="accName" placeholder="Account Name" value="<?php echo @$usrData['account_name'];?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Bank</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">Bank</label>-->
										<input type="text" class="form-control " name="bank" id="bank" placeholder="Bank" value="<?php echo @$usrData['bank'];?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Branch</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">Branch</label>-->
										<input type="text" class="form-control " name="branch" id="branch" placeholder="Branch" value="<?php echo @$usrData['branch'];?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">IFSC</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">IFSC</label>-->
										<input type="text" class="form-control " name="ifsc" id="ifsc" placeholder="IFSC" value="<?php echo @$usrData['ifsc'];?>"/>
									</div>
								</div>
							</div>
						</div>
						<div class="box-footer">
							<?php if($showPrevBtn){?>
							<a href="<?php echo $tabUrl.base64_encode($tab-1); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
							<?php } ?>
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
						</div>
					</form>
				</div>
				<!--Banking Detail End Here-->
				<!-- Attached Document Section Starts Here-->
				<div id="menu3" class="tab-pane fade <?php if($tab == 4){ echo 'in active';}?>">
				<div style="display:none;" id="me1"><img src="tenor.gif" style="position:absolute; top:70px; opacity:1; "/></div>
					<form role="form" method="POST" name="attach_doc" id="attach_doc" enctype = "multipart/form-data">
						<input type="hidden" name="userId" value="<?php echo @$usrData['admin_id']; ?>" />
						<?php if($_SESSION['added_emp_id']!="")
						{
							$hotel_id=$_SESSION['added_emp_id'];

						}else{
							$hotel_id=$_GET['id'];

						}
						?>
						<input type="hidden" id="" name="hotl_id" value="<?php echo $hotel_id ?>"> 
						<?php
							$custDocs = count($docsCustArr);
							if($custDocs > 0){
								$conter = $custDocs+9;
							}
							else
							{
								$conter = 9;
							}
							
							//print_r($docsStaticArr);
							//print_r($docsArr);
						?>
						<input type="hidden" name="totalFld" id="totalFld" value="<?php echo $conter; ?>"/>
						
						
					<div class="box-body">
						<div class="row">
							<div class="myattch">
							<div id="attch_4">
								<input type="hidden" class="attfileId_4" name="attachEdId[]" id="pancardId" value="<?php echo @$docsArr['PAN Card']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	PAN Card </b></h4>
									<input type="hidden" name="docFileName[]" id="panfileName" value="PAN Card"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="pan_card_copy" name="file_upload[]" type="file" value="" multiple>
										<input type="hidden" id="pan_card" name="upldFileName[]" class="attfileId_4" value="<?php echo @$docsArr['PAN Card']['doc'];?>">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div><!-- /.form-group -->
							
								<div class="col-md-4">
									<div id="panCardDocName" class="attfile_4"><?php echo @$docsArr['PAN Card']['doc'];?></div>
									<div id="panDocs"></div>
								</div>
								<?php if($docsArr['PAN Card']['doc'] == ''){?>
									<div class="col-md-2 attach_new" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(1)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['PAN Card']['doc'] != ''){?>
								<div class="col-md-2">
									<div class="form-group attach_newed">
										<a class="delete" relid="<?php echo @$docsArr['PAN Card']['id'];?>" rel="1" href="javascript:void(0)" onclick="remove_attach(1,'<?php echo @$docsArr['PAN Card']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_5">
								<input type="hidden" class="attfileId_5" name="attachEdId[]" id="photoId" value="<?php echo @$docsArr['Photo']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
									<input type="hidden" name="docFileName[]" id="photofileName" value="Photo"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="photo_copy" name="file_upload1[]" type="file" multiple>
										<input type="hidden" class="attfileId_5" id="photoDoc" name="upldFileName[]" value="<?php echo @$docsArr['Photo']['doc'];?>"> 
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div id="photoDocName" class="attfile_5"><?php echo @$docsArr['Photo']['doc'];?></div>
									<div id="photoDocs"></div>
								</div>
								<?php if($docsArr['Photo']['doc'] == ''){?>
									<div class="col-md-2 attach_new1" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(2)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Photo']['doc'] != ''){?>
								<div class="col-md-2 attach_newed1">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Photo']['id'];?>" rel="2" href="javascript:void(0)" onclick="remove_attach(2,'<?php echo @$docsArr['Photo']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_6">
								<input type="hidden" class="attfileId_6" name="attachEdId[]" id="addProofId" value="<?php echo @$docsArr['Address Proof']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Address Proof</b></h4>
									<input type="hidden" name="docFileName[]" id="addrprooffileName" value="Address Proof"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="address_prof_copy" name="file_upload2[]" type="file" multiple>
										<input type="hidden" class="attfileId_6" id="addrProofDoc" name="upldFileName[]" value="<?php echo @$docsArr['Address Proof']['doc'];?>">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div id="addrProofDocName" class="attfile_6"><?php echo @$docsArr['Address Proof']['doc'];?></div>
									<div id="addrProofDocs"></div>
								</div>
									<?php if($docsArr['Address Proof']['doc'] == ''){?>
								<div class="col-md-2 attach_new2" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(3)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Address Proof']['doc'] != ''){?>
								<div class="col-md-2 attach_newed2">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Address Proof']['id'];?>" rel="3" href="javascript:void(0)" onclick="remove_attach(3,'<?php echo @$docsArr['Address Proof']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_7">
								<input type="hidden" class="attfileId_7" name="attachEdId[]" id="aadharCardId" value="<?php echo @$docsArr['Adhaar Card']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Adhaar Card </b></h4>
									<input type="hidden" name="docFileName[]" id="adhaarfileName" value="Adhaar Card"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="adhaar_copy" name="file_upload3[]" type="file" multiple>
										<input type="hidden" id="aadharCardDoc" name="upldFileName[]" class="attfileId_7" value="<?php echo @$docsArr['Adhaar Card']['doc'];?>"> 
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div id="aadharCardDocName" class="attfile_7"><?php echo @$docsArr['Adhaar Card']['doc'];?></div>
									<div id="aadharCardDocs"></div>
								</div>
								<?php if($docsArr['Adhaar Card']['doc'] == ''){?>
								<div class="col-md-2 attach_new3" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(4)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Adhaar Card']['doc'] != ''){?>
								<div class="col-md-2 attach_newed3">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Adhaar Card']['id'];?>" rel="4" href="javascript:void(0)" onclick="remove_attach(4,'<?php echo @$docsArr['Adhaar Card']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_8">
								<input type="hidden" class="attfileId_8" name="attachEdId[]" id="passprtId" value="<?php echo @$docsArr['Passport']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Passport </b></h4>
									<input type="hidden" name="docFileName[]" id="passportfileName" value="Passport"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="passport_copy" name="file_upload4[]" type="file" multiple>
										<input type="hidden" class="attfileId_8" id="passportDoc" name="upldFileName[]" value="<?php echo @$docsArr['Passport']['doc'];?>">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div id="passportDocName" class="attfile_8"><?php echo @$docsArr['Passport']['doc'];?></div>
									<div id="passportDocs"></div>
								</div>
								<?php if($docsArr['Passport']['doc'] == ''){?>
								<div class="col-md-2 attach_new4" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(5)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Passport']['doc'] != ''){?>
								<div class="col-md-2 attach_newed4">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Passport']['id'];?>" rel="5" href="javascript:void(0)" onclick="remove_attach(5,'<?php echo @$docsArr['Passport']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_1">
								<input type="hidden" class="attfileId_1" name="attachEdId[]" id="bioDataId" value="<?php echo @$docsArr['Biodata']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Biodata </b></h4>
										<input type="hidden" name="docFileName[]" id="biofileName" value="Biodata"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="biodata_copy" name="file_upload5[]" type="file" multiple>
										<input type="hidden" class="attfileId_1" id="biodataDoc" name="upldFileName[]" value="<?php echo @$docsArr['Biodata']['doc'];?>">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-4">
									<div id="biodataDocName" class="attfile_1"><?php echo @$docsArr['Biodata']['doc'];?></div>
									<div id="biodataDocs"></div>
								</div>
									<?php if($docsArr['Biodata']['doc'] == ''){?>
								<div class="col-md-2 attach_new5" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(6)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Biodata']['doc'] != ''){?>
								<div class="col-md-2 attach_newed5">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Biodata']['id'];?>" rel="6" href="javascript:void(0)" onclick="remove_attach(6,'<?php echo @$docsArr['Biodata']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_2">
								<input type="hidden" class="attfileId_2" name="attachEdId[]" id="eduProofId" value="<?php echo @$docsArr['Educational Proof']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<h4 class="box-title"><b style="font-size: 17px;">	Educational Proof </b></h4>
									<input type="hidden" name="docFileName[]" id="upldFileName[]" class="attfileId_2" value="Educational Proof"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="eduproof_copy" name="file_upload6[]" type="file" multiple>
										<input type="hidden" id="eduproofDoc" name="upldFileName[]" value="<?php echo @$docsArr['Educational Proof']['doc'];?>">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-4">
									<div id="eduproofDocName" class="attfile_2"><?php echo @$docsArr['Educational Proof']['doc'];?></div>
									<div id="eduproofDocs"></div>
								</div>
								<?php if($docsArr['Educational Proof']['doc'] == ''){?>
								<div class="col-md-2 attach_new6" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(7)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Educational Proof']['doc'] != ''){?>
								<div class="col-md-2 attach_newed6">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Educational Proof']['id'];?>" rel="7" href="javascript:void(0)" onclick="remove_attach(7,'<?php echo @$docsArr['Educational Proof']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<div id="attch_3">
								<input type="hidden" class="attfileId_3" name="attachEdId[]" id="appointletterId" value="<?php echo @$docsArr['Appointment Letter']['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	Appointment Letter </b></h4>
										<input type="hidden" name="docFileName[]" id="appointfileName" value="Appointment Letter"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="file_upload" id="appointmentletter_copy" name="file_upload7[]" type="file" multiple>
										<input type="hidden" id="appointmentletterDoc" name="upldFileName[]" class="attfileId_3" value="<?php echo @$docsArr['Appointment Letter']['doc'];?>">
										</label> 
										<p class="help-block text-danger"></p>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-4">
									<div id="appointmentletterDocName" class="attfile_3"><?php echo @$docsArr['Appointment Letter']['doc'];?></div>
									<div id="appointmentletterDocs"></div>
								</div>
								<?php if($docsArr['Appointment Letter']['doc'] == ''){?>
								<div class="col-md-2 attach_new7" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(8)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
								<?php if($docsArr['Appointment Letter']['doc'] != ''){?>
								<div class="col-md-2 attach_newed7">
									<div class="form-group">
										<a class="delete" relid="<?php echo @$docsArr['Appointment Letter']['id'];?>" rel="8" href="javascript:void(0)" onclick="remove_attach(8,'<?php echo @$docsArr['Appointment Letter']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php } ?>
							</div>
							<div style="clear:both;"></div>
							<?php
								//echo $countAllTotal = $attachdoc+;
								//print_r($docsCustArr);
								
								if($custDocs > 0)
								{
									//echo 'ajjjjjj';
									$countAttach=9;
									for($i=0; $i < $custDocs; $i++){
										//echo 'asdfads';
							?>
							<div id="attch_<?php echo $countAttach;?>">
								<input type="hidden" name="attachEdId[]" id="addmoreId" value="<?php echo @$docsCustArr[$i]['id'];?>"/>
								<div class="col-md-2">
									<div class="form-group">
									<!--<h4  class="box-title"><b style="font-size: 17px;">Passport</b></h4>-->
									<input type="text" class="form-control" name="docFileName[]" id="addmorefilename_<?php echo $countAttach;?>" placeholder="File Name" value="<?php echo @$docsCustArr[$i]['name'];?>"/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="form-control" id="add_more_file_<?php echo $countAttach;?>" name="file_upload8[]" type="file" multiple>
										<input type="hidden" id="addmore_<?php echo $countAttach;?>" name="upldFileName[]" value="<?php echo @$docsCustArr[$i]['doc'];?>">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div id="add_more_uploaded_<?php echo $countAttach;?>"><?php echo @$docsCustArr[$i]['doc'];?></div>
								</div>
								
								<?php
									if($i == 8){
								?>
								<div class="col-md-2 pull-right">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="addMoreDoc" id="addMoreDoc" title="Add field" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php
									}else{
								?>
								<div class="col-md-2">
									<div class="form-group">
										<a class="delete" relId="<?php echo @$docsCustArr[$i]['id'];?>" rel="<?php echo $countAttach;?>" href="javascript:void(0)" onclick="remove_attach('<?php echo $countAttach;?>','<?php echo @$docsCustArr[$i]['id'];?>','dynamic')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								<?php
									}
								?>
							</div>
							<div style="clear:both;"></div>
							<?php
							$countAttach++;
									}
								}else{
							?>
							
							<div style="clear:both;"></div>
							<?php
								}
							?>
							<div id="attch_<?php echo $conter; ?>">
								<input type="hidden" name="attachEdId[]" id="addmoreId" value=""/>
								<div class="col-md-2">
									<div class="form-group">
									<!--<h4  class="box-title"><b style="font-size: 17px;">Passport</b></h4>-->
									<input type="text" class="form-control" name="docFileName[]" id="addmorefilename_<?php echo $conter; ?>" placeholder="File Name" value=""/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="btn-bs-file btn btn-md btn-primary">Choose File
										<input class="form-control" id="add_more_file_<?php echo $conter; ?>" name="file_upload8[]" type="file" multiple>
										<input type="hidden" id="addmore_<?php echo $conter; ?>" name="upldFileName[]" value="">
									</label>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div id="add_more_uploaded_<?php echo $conter; ?>"></div>
								</div>

								<div class="col-md-2 attach_new8" style="display:none;">
									<div class="form-group">
										<a class="delete" href="javascript:void(0)" onclick="remove_attach1(9)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
									</div> 
								</div>
								
								<div class="col-md-2 pull-right">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="addMoreDoc" id="addMoreDoc" title="Add field" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					</form>
					<div class="status"></div>
					<div class="box-footer">
						<?php if($showPrevBtn){?>
						<a href="<?php echo $tabUrl.base64_encode($tab-1); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
						<?php } ?>
						<button type="button" class="btn btn-primary" name="submitDocs" id="submitDocs">Submit</button>
					</div>
				</div>
				<!--Attached Document Section End Here-->
				
			</div>
		</div>
	</section>
</div>


<script src="uploadify/jquery.uploadify.js"></script>			
<script>
	
		$(document).ready(function(){
			$(".nav-tabs a[data-toggle=tab]").on("click", function(e) {
			  if ($(this).hasClass("disabled")) {
				e.preventDefault();
				return false;
			  }
			});
			$( "#dob" ).datepicker({
			  format: "dd MM yyyy"
			});
			$(".select2").select2();
			$( ".emp_datePicker" ).datepicker({
			  format: "dd MM yyyy"
			});
			$("#pramCountry").change(function()
			{
				//alert("punamsaini");
				var id=$(this).val();
				
				var dataString = 'id='+ id;
				$("#pramState").find('option').remove();
				$("#pramCity").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#pramState").html(html);			
					} 
				});
			});
			$("#pramState").change(function()
			{
				
				var id=$(this).val();
				//alert(id);
				var dataString = 'id='+ id;
			
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#pramCity").html(html);
					} 
				});
			});
			$("#currCountry").change(function()
			{
				//alert("punamsaini");
				var id=$(this).val();
				
				var dataString = 'id='+ id;
				$("#currState").find('option').remove();
				$("#currCity").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#currState").html(html);			
					} 
				});
			});
	
			$("#currState").change(function()
			{
				
				var id=$(this).val();
				//alert(id);
				var dataString = 'id='+ id;
			
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#currCity").html(html);
					} 
				});
			});
			
			$("#add_more_currAdd").click(function(){
		
				var count = $("#currAddCount").val();
				//alert(count);
				count++;
				$(".items1").append('<div id="address2_'+count+'"> <div class="col-md-2"> <div class="form-group"> </div> </div><input type="hidden" name="currAddId[]" id="currAddId" value="0"/> <div class="col-md-2"> <div class="form-group"><input type="text" class="form-control" name="currAdd1[]" placeholder="Address line 1" value=""/> </div> </div> <div class="col-md-2"> <div class="form-group"><input type="text" class="form-control" name="currAdd2[]" placeholder="Address line 2" value=""/> </div> </div> <div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="currCountry[]" placeholder="Country" value=""/></div></div><div class="col-md-1"> <div class="form-group"><input type="text" class="form-control" name="currCity[]" placeholder="City" value=""/> </div> </div> <div class="col-md-1"> <div class="form-group"><input type="text" class="form-control" name="currState[]" placeholder="State" value=""/> </div> </div> <div class="col-md-1"> <div class="form-group"><input type="text" class="form-control" name="currPin[]" placeholder="Code" value=""/> </div> </div> <div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item4('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div> </div></div>');
				
				$("#currAddCount").val(count);
				//alert()
			});
		var totalFld = $("#totalFld").val();
			for(var i=9; i<=totalFld; i++)
			{
				uplodifyMore(i);
			}
		$("#addMoreDoc").click(function(){
			var count=$("#totalFld").val();
			count++;
			var attachId=0;
			$('<div id="attch_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="docFileName[]" id="addmorefilename_'+count+'" placeholder="File Name" value=""/></div></div><div class="col-md-4"><div class="form-group"><label class="btn-bs-file btn btn-md btn-primary">Choose File<input class="file_upload" id="add_more_file_'+count+'" name="file_upload8[]" type="file" multiple><input type="hidden" id="addmore_'+count+'" name="upldFileName[]" value=""></label><p class="help-block text-danger"></p></div></div><div class="col-md-4"><div id="add_more_uploaded_'+count+'" style="height:60px;"></div></div><div class="col-md-2"><div class="form-group"><a class="delete delAttach" relId="" rel="'+count+'" href="javascript:void(0)" onclick="remove_attach('+count+','+attachId+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div> </div></div><div style="clear:both;"></div>').insertAfter($(this).parent().parent().prev());
				
			$("#totalFld").val(count);
			uplodifyMore(count);
		});
		
		$("#add_Morepram_add").click(function(){
		
				var count = $("#permAddCount").val();
				//alert(count);
				count++;
				$(".items").append('<div id="address_'+count+'"> <div class="col-md-2"> <div class="form-group"></div> </div><input type="hidden" name="prmntAddrId[]" id="prmntAddrId" value="0"/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="pramAdd1[]" placeholder="Address line 1" value=""/></div> </div><div class="col-md-2"> <div class="form-group"><input type="text" class="form-control" name="pramAdd2[]" placeholder="Address line 2" value=""/> </div> </div> <div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="pramCountry[]" placeholder="Country" value=""/></div></div><div class="col-md-1"> <div class="form-group"><input type="text" class="form-control" name="pramCity[]" placeholder="City" value=""/></div></div><div class="col-md-1"> <div class="form-group"><input type="text" class="form-control" name="pramState[]" placeholder="State" value=""/> </div> </div> <div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="pramPin[]" placeholder="Code" value=""/></div></div><div class="col-md-1"><div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div> </div></div>');
				
				$("#permAddCount").val(count);
				//alert()
			});
			
			$("#Emnumbbr").click(function(){
		
				var count = $("#emNumbrCount").val();
				//alert(count);
				count++;
				$('<div id="EmNumber_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="emergNumId[]" id="emergNumId" value="0"/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="EmergencyMObNum[]" placeholder="Mobile Number" value=""/></div></div> <div class="col-md-3"><div class="form-group"><select class="form-control" name="EmrCode[]" placeholder="Code" value=""><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item5('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>').insertAfter($(this).parent().parent().prev());
				
				$("#emNumbrCount").val(count);
				//alert()
			});
			
			$("#Mnumbbr").click(function(){
		
				var count = $("#contactNumCount").val();
				//alert(count);
				count++;
				$('<div id="Mobnumbbr_'+count+'"><div class="clearfix"></div><input type="hidden" name="contactNumId[]" id="contactNumId" value="0"/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userMobile[]" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control" name="code[]" placeholder="Code" value=""><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+', 0)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>').insertAfter($(this).parent().parent().prev());
				
				$("#contactNumCount").val(count);
				//alert()
			});
			
			$("#emails").click(function(){
		
				var count = $("#PerEmailCount").val();
				//alert(count);
				count++;
				$('<div id="Email_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-5"><div class="form-group"><input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item1('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div>').insertAfter($(this).parent().parent().prev());
				
				$("#PerEmailCount").val(count);
				//alert()
			});
			
			$("#sameAsPrmntBtn").click(function(){
				
				if($(this).is(':checked')){
				//alert("working");
				var addr1=$("#pramAdd1").val();
				//alert(addr1);
				var addr2=$("#pramAdd2").val();
				//alert(addr2);
				var country=$("#pramCountry").val();
				//alert(country);
				var city=$("#pramCity").val();
				//alert(city);
				var state=$("#pramState").val();
				//alert(state);
				var pincode=$("#pramPin").val();
				//alert(pincode);
				//alert(country);
				//alert(state);
				//alert(city);
				$("#currAdd1").val(addr1);
				$("#currAdd2").val(addr2);
				$("#currCountry").val(country).trigger('change.select2');
				$("#currCity").val(city).trigger('change.select2');
				$("#currState").val(state).trigger('change.select2');
				$("#currPin").val(pincode);
			}
			else{
				$("#currAdd1").val("");
				$("#currAdd2").val("");
				$("#currCountry").val("").trigger('change.select2');
				$("#currCity").val("").trigger('change.select2');
				$("#currState").val("").trigger('change.select2');
				$("#currPin").val("");
			}
			});
			
			//alert("gdfgd");
			$("#add_User").validate({
			rules:{
				name_prefix:"required",
				firstname:"required",
				lastname:"required",
				userName:"required",
				'userEmail[]':{
					required:true,
					email:true
				},
				dob:"required",
				'pramAdd1[]':{
					required:true
				},
				'pramAdd2[]':{
					required:true
				},
				'pramCountry[]':{
					required:true
				},
				'pramCity[]':{
					required:true
				},
				'pramState[]':{
					required:true
				},
				'pramPin[]':{
					required:true
				},
				'currAdd1[]':{
					required:true
				},
				'currAdd2[]':{
					required:true
				},
				'currCountry[]':{
					required:true
				},
				'currCity[]':{
					required:true
				},
				'currState[]':{
					required:true
				},
				'currPin[]':{
					required:true
				}
			},
			messages:{
				name_prefix:"Please Select Title",
				firstname:"Please Select First Name",
				middle:"Please Enter Middle Name",
				lastname:"Please Enter Last Name",
				'userEmail[]':{
					required:"Please Enter email",
					email:"Enter valid email"
				},
				dob:"Please enter your D.O.B",
				'pramAdd1[]':{
					required:"Please input address 1"
				},
				'pramAdd2[]':{
					required:"Please input address 2"
				},
				'pramCountry[]':{
					required:"Please input your parmanent country"
				},
				'pramCity[]':{
					required:"Please input your parmanent city"
				},
				'pramState[]':{
					required:"Please input your parmanent state"
				},
				'pramPin[]':{
					required:"Please input your parmanent pincode"
				},
				'currAdd1[]':{
					required:"Please input your cuurent address 1"
				},
				'currAdd2[]':{
					required:"Please input your cuurent address 2"
				},
				'currCountry[]':{
					required:"Please input your current country"
				},
				'currCity[]':{
					required:"Please input your current city"
				},
				'currState[]':{
					required:"Please input your current state"
				},
				'currPin[]':{
					required:"Please input your cuurent pincode"
				}
			},
			submitHandler:function(form){
				var action = $('#action').val();
				$.ajax({
					type: "POST",  
					url: "_ajax_user_authentication.php?action="+action,
					data: $("#add_User").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						//alert(msg);
						if(msg === '1')
						{
						$("#status").show().html('<div class="alert alert-success">Personal Detail Saved Sucessfully</div>');
								//window.location.href = 'addUser.php?id=<?=$_SESSION['added_emp_id'];?>&t=2';
							 
							//$("#official_detail").click();
							window.location.href='<?php echo $tabUrl.base64_encode(2); ?>';
						}
						else
						{
							$("#status").show().html('<div class="alert alert-dangersss">Sorry, there is some problem</div>');
							
						}
					} 
				});
			}
			});
			
			$("#official_detailfrm").validate({
			rules:{
				userPass:"required",
				designation:"required",
				department:"required",
				empType:"required",
				joingDate:"required"
			},
			messages:{
				userPass:"Please enter your password",
				designation:"Please Select Designation",
				department:"Please Select Department",
				empType:"Please Select Employee Type",
				joingDate:"Please Select Joining Date"
			},
			submitHandler:function(form){
				$.ajax({
					type: "POST",  
					url: "_ajax_user_authentication.php?action=official_detail",
					data: $("#official_detailfrm").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						//alert(msg);
						if(msg === '1')
						{
						$("#status").show().html('<div class="alert alert-success">Official Detail Saved Sucessfully</div>');
							 //$("#candidate_Details")[0].reset();
							 //location.reload(true);
								//window.location.href = 'addUser.php?t=3';
							 
							 //$("#banking_detail").click();
							 window.location.href='<?php echo $tabUrl.base64_encode(3); ?>';
						}
						else
						{
							$("#status").show().html('<div class="alert alert-dangersss">Sorry, there is some problem</div>');
							
						}
					} 
				});
			}
			});
			
			$("#banking_detailFrm").validate({
			rules:{
				
			},
			messages:{
				
			},
			submitHandler:function(form){
				$.ajax({
					type: "POST",  
					url: "_ajax_user_authentication.php?action=banking_detail",
					data: $("#banking_detailFrm").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						//alert(msg);
						if(msg === '1')
						{
							$("#status").show().html('<div class="alert alert-success">Banking Detail Saved Sucessfully</div>');
							 //$("#candidate_Details")[0].reset();
							 //location.reload(true);
								//window.location.href = 'addUser.php?t=4';
							 
							 //$("#attached_document").click();
							 window.location.href='<?php echo $tabUrl.base64_encode(4); ?>';
						}
						else
						{
							$("#status").show().html('<div class="alert alert-dangersss">Sorry, there is some problem</div>');
							
						}
					} 
				});
			}
			});
			
			$("#designation").change(function(){
				var designation=$(this).val();
				//alert(desi);
				if(designation == 'Add New')
				{
					$("#desigDiv").show();
				}
				else
				{
					$("#desigDiv").hide();
				}
			});
			
			$("#department").change(function(){
				var department=$(this).val();
				//alert(desi);
				if(department == 'Add New')
				{
					$("#departDiv").show();
				}
				else
				{
					$("#departDiv").hide();
				}
			});
			
			$("#submitDesignation").click(function(){
				var designationName=$("#newDesignation").val();
				var fieldName='designation_name';
				var tableName='designation';
				//alert(designationName);
				if(designationName ==''){
					alert("Please Enter Designation Name");
					return false;
				}else{
					//alert("not empty");
					$.ajax({
						type:"POST",
						url:"_ajax_user_authentication.php?action=addNewOption",
						data:{table:tableName,field:fieldName,value:designationName},
						beforeSend:function(){
							
						},
						success:function(msg){
							if(msg == 1)
							{
								$("#designStatus").show().html('<div class="alert alert-success">Designation Added Succefully</div>');
								window.setTimeout(function() {
									window.location.reload();
								}, 2000);
							}else{
								$("#designStatus").show().html('<div class="alert alert-danger">Problem in Adding Designation.</div>');
							}
						}
					});
				} 
			});
			
			$("#submitDepartment").click(function(){
				var departName=$("#newDepart").val();
				var fieldName='department_name';
				var tableName='department';
				//alert(designationName);
				if(departName ==''){
					alert("Please Enter Department Name");
					return false;
				}else{
					//alert("not empty");
					$.ajax({
						type:"POST",
						url:"_ajax_user_authentication.php?action=addNewOption",
						data:{table:tableName,field:fieldName,value:departName},
						beforeSend:function(){
							
						},
						success:function(msg){
							if(msg == 1)
							{
								$("#departStatus").show().html('<div class="alert alert-success">Department Added Succefully</div>');
								window.setTimeout(function() {
									window.location.reload();
								}, 2000);
								
							}else{
								$("#departStatus").show().html('<div class="alert alert-danger">Problem in Adding Department.</div>');
							}
						}
					});
				} 
			});
			
			$("#submitDocs").click(function(){
				$.ajax({
					type: "POST",  
					url: "_ajax_user_authentication.php?action=documents",
					data: $("#attach_doc").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						//alert(msg);
						if(msg.status == 1)
						{
							$(".status").show().html('<div class="alert alert-success">Personal Detail Saved Sucessfully</div>');
							window.setTimeout(function(){
								window.location.href='userlist.php';
							},2000);
						}
						else
						{
							$(".status").show().html('<div class="alert alert-dangersss">Sorry, there is some problem</div>');
							
						}
					} 
				});
			});
			
		});

        function remove_attach1(counter)
		{
				//alert(counter);
				if(confirm("Do you want to delete?")){
				if(counter == '1')
					{
						$("#pan_card").val('');
						$('#panDocs').html('');
						$(".attach_new").css({"display": "none"});
			          
					}
					if(counter == '2')
					{
						$("#photoDoc").val('');
						$('#photoDocs').html('');
						$(".attach_new1").css({"display": "none"});
					}
					if(counter == '3')
					{
						$("#addrProofDoc").val('');
						$('#addrProofDocs').html('');
						$(".attach_new2").css({"display": "none"});
					
					}
					if(counter == '4')
					{
						$("#aadharCardDoc").val('');
						$('#aadharCardDocs').html('');
						$(".attach_new3").css({"display": "none"});
			          
					}
					if(counter == '5')
					{
						$("#passportDoc").val('');
						$('#passportDocs').html('');
						$(".attach_new4").css({"display": "none"});
						
					}
					if(counter == '6')
					{
						$("#biodataDoc").val('');
						$('#biodataDocs').html('');
						$(".attach_new5").css({"display": "none"});	
						
					}
					if(counter == '7')
					{
						$("#eduproofDoc").val('');
						$('#eduproofDocs').html('');
						$(".attach_new6").css({"display": "none"});
					}
					if(counter == '8')
					{
						$("#appointmentletterDoc").val('');
						$('#appointmentletterDocs').html('');
						$(".attach_new7").css({"display": "none"});
					}
					if(counter == '9')
					{
						$("#addmore_9").val('');
						$('#add_more_uploaded_9').html('');
						$(".attach_new8").css({"display": "none"});
					}
					}else{
						return false;
					}
			}
			function remove_attach(counter,relId, type)
			{
				
				if(relId == 0){
					$('#attch_'+counter).remove();
					$(".delAttach"+counter).css({"display": "none"});
				}else{
					//alert(relId);
					if(confirm("Do you want to delete?")){
						$.ajax({
							type:"POST",
							url:"_ajax_hotel_prsnl_detail?action=delAttach",
							data:{attachId:relId},
							success:function(data){
								if(data.status == 1){
									if(type == 'dynamic')
									{
										$('#attch_'+counter).remove();
									}
									else
									{
									if(counter == 1)
									{
									$("#pan_card").val('');
									$('#panDocs').html('');
									$('.attfile_4').html('');
									$(".attach_newed").css({"display": "none"});
                                    }
									if(counter == '2')
									{
									$("#photoDoc").val('');
									$('#photoDocs').html('');
									$('.attfile_5').html('');
									$(".attach_newed1").css({"display": "none"});
									}
									if(counter == '3')
									{
									$("#addrProofDoc").val('');
									$('#addrProofDocs').html('');
									$('.attfile_6').html('');
									$(".attach_newed2").css({"display": "none"});

									}
									if(counter == '4')
									{
									$("#aadharCardDoc").val('');
									$('#aadharCardDocs').html('');
									$('.attfile_7').html('');
									$(".attach_newed3").css({"display": "none"});

									}
									if(counter == '5')
									{
									$("#passportDoc").val('');
									$('#passportDocs').html('')
									$('.attfile_8').html('');;
									$(".attach_newed4").css({"display": "none"});

									}
									if(counter == '6')
									{
									$("#biodataDoc").val('');
									$('#biodataDocs').html('');
									$('.attfile_1').html('');
									$(".attach_newed5").css({"display": "none"});	

									}
									if(counter == '7')
									{
									$("#eduproofDoc").val('');
									$('#eduproofDocs').html('');
									$('.attfile_2').html('');
									$(".attach_newed6").css({"display": "none"});
									}
									if(counter == '8')
									{
									$("#appointmentletterDoc").val('');
									$('#appointmentletterDocs').html('');
									$('.attfile_3').html('');
									$(".attach_newed7").css({"display": "none"});
									}
						            $("#attdoc_"+counter).remove('');
						            $(".Uplddoc_"+counter).val('');
										
									}
								}else{
									alert("Problem in deleting");
								}
							}
						});
					}else{
						return false;
					}
				}
			}

		function remove_item1(counter)
		{
			$('#Email_'+counter).remove();
		}
		function remove_item2(counter, delId, type)
		{
			//$('#Mobnumbbr_'+counter).remove();
			if(delId == 0){
				$('#Mobnumbbr_'+counter).remove();
			}else{
				if(confirm("Do you want to delete?")){
					var data = 'id='+delId+'&itemType=contactNumbers';
					$.ajax({
						type:"POST",
						url:"_ajax_user_authentication.php?action=delete_items",
						data:data,
						success:function(data){
							if(data.status == 1){
								//$('#attch_'+counter).remove();
								if(type == 'emergency')
								{
									$('#EmNumber_'+counter).remove();
								}
								else
								{
									$('#Mobnumbbr_'+counter).remove();
								}
							}else{
								alert("Problem in deleting");
							}
						}
					});
				}else{
					return false;
				}
			}	
		}
		function remove_item3(counter)
		{
			$('#address_'+counter).remove();
		}
		function remove_item4(counter)
		{		
			$('#address2_'+counter).remove();	
		}
		function remove_item5(counter)
		{		
			$('#EmNumber_'+counter).remove();		
			
		}
		


		function uplodifyMore(number)
		{
			//alert(number);
			$('#add_more_file_'+number).change(function(){
					var formData = new FormData($("#attach_doc")[0]);
					var str='';
			$.ajax({  
                url :"upload_more_doc_emp.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,  
                beforeSend: function() {
          $("#me1").css({"display": "block"});
                },
                success:function(data){
				var a=$.parseJSON(data);
				$.each(a, function(i,e ) {
				var imgName=e;
				var preImg = $('#addmore_'+number).val();
				if(imgName != null){
				if(preImg == '')
				{
					
					str += imgName+',';
				}
				else
				{
					
					str = preImg+imgName+',';
				}
				 $('#add_more_uploaded_'+number).append('<div>'+imgName+'</div>');
				$("#addmore_"+number).val(str);
					
				}
				});
			     
				 $('#add_more_file_'+number).val("");
				 $("#me1").css({"display": "none"});
				 $(".attach_new8").css({"display": "block"});
			     $(".attach_newed8").css({"display": "block"});
					
                }  
              }) 
						
			});
		}

				$(document).on('click', ".del_add_img", function(){
				//alert("sdgs");
			var imgid = $(this).attr('relId');
			var num=$(this).attr('relNum');
			//alert(imgid);
			$(this).prev().remove();
			$(this).remove();
			var roomImg=$("#roomImg_"+num).val();
			//alert(roomImg);
			var arrroomImg=roomImg.split(',');
			//alert(arrroomImg);
			var index = arrroomImg.indexOf(imgid);
			if (index > -1) {
				arrroomImg.splice(index, 1);
			}
			//alert(arrroomImg);
			$("#roomImg_"+num).val(arrroomImg);
			
		});
		$(".remove_img").click(function(){
				var imageId=$(this).attr('relId');
				var relNum=$(this).attr('relImgNum');
				var relImgId=$(this).attr('relImgId');
				
				$.ajax({
					type:"POST",
					url:"_ajax_hotel_prsnl_detail.php?action=deleteRoomImg",
					data:{imageId:imageId},
					beforeSend:function(){
						
					},
					success:function(msg){
						if(msg == 1)
						{	
							$("#delete_img_"+imageId).remove();
							$("#delete_full_img_"+imageId).remove();
							var roomImg=$("#roomImg_"+relNum).val();
							var arrroomImg=roomImg.split(',');
							var index = arrroomImg.indexOf(relImgId);
							if (index > -1) {
								arrroomImg.splice(index, 1);
							}
							//alert(arrroomImg);
							$("#roomImg_"+relNum).val(arrroomImg);
						}
					}
				}); 
			}); 
			



		$('#pan_card_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);
	    $.ajax({  
                url :"upload_pancard.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false, 
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                }, 
                success:function(data){
				var a=$.parseJSON(data);
				$.each(a, function(i,e ) {
				var imgName=e;
				$('#panDocs').append('<div>'+imgName+'</div>');
				var already = $("#pan_card").val();
				var newFile = already+','+imgName;
				$("#pan_card").val(newFile);
				}); 
				$("#me1").css({"display": "none"}); 
				$(".attach_new").css({"display": "block"});
			    $(".attach_newed").css({"display": "block"});   
                }  
           })   	
      });

		$('#photo_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_photo.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,  
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                },
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#photoDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#photoDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#photoDoc").val(newFile1);
				}); 
				$("#me1").css({"display": "none"});
				$(".attach_new1").css({"display": "block"});
				$(".attach_newed1").css({"display": "block"});     
                }  
           })  	
      }); 
		

		$('#address_prof_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_address_proof.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false, 
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                }, 
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#addrProofDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#addrProofDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#addrProofDoc").val(newFile1);
				});
				$("#me1").css({"display": "none"});
				$(".attach_new2").css({"display": "block"});
				$(".attach_newed2").css({"display": "block"});      
                }  
           })  	
      });
		

		$('#adhaar_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_adhaar.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,  
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                },
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#aadharCardDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#aadharCardDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#aadharCardDoc").val(newFile1);
				}); 
				$("#me1").css({"display": "none"});
				$(".attach_new3").css({"display": "block"});
				$(".attach_newed3").css({"display": "block"});     
                }  
           })  	
      }); 
           

        $('#passport_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_passport.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false, 
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                }, 
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#passportDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#passportDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#passportDoc").val(newFile1);
				}); 
				$("#me1").css({"display": "none"});
				$(".attach_new4").css({"display": "block"});
				$(".attach_newed4").css({"display": "block"});     
                }  
           })  	
      }); 


        $('#biodata_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_biodata.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,  
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                },
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#biodataDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#biodataDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#biodataDoc").val(newFile1);
				}); 
				$("#me1").css({"display": "none"});
				$(".attach_new5").css({"display": "block"});
				$(".attach_newed5").css({"display": "block"});     
                }  
           })  	
      }); 


        $('#eduproof_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_educational_proof.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                },  
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#eduproofDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#eduproofDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#eduproofDoc").val(newFile1);
				}); 
				$("#me1").css({"display": "none"}); 
				$(".attach_new6").css({"display": "block"});
				$(".attach_newed6").css({"display": "block"});    
                }  
           })  	
      }); 
             
        $('#appointmentletter_copy').change(function(){ 
	    var formData = new FormData($("#attach_doc")[0]);		  
        $.ajax({  
                url :"upload_appointment_letter.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false, 
                 beforeSend: function() {
       $("#me1").css({"display": "block"});
                }, 
                success:function(data){
			    var b=$.parseJSON(data);
				$.each(b, function(i,e ) {
				var imgName1=e;
				$('#appointmentletterDocs').append('<div>'+imgName1+'</div>');
				var already1 = $("#appointmentletterDoc").val();
				var newFile1 = already1+','+imgName1;
				$("#appointmentletterDoc").val(newFile1);
				});  
				$("#me1").css({"display": "none"}); 
				$(".attach_new7").css({"display": "block"});
				$(".attach_newed7").css({"display": "block"});   
                }  
           })  	
      }); 

	
	</script>
	    <script src="asset/bootstrap-datepicker.js"></script>
<?php  include('footer.php');?> 