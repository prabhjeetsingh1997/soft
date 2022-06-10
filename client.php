<?php
include('header.php');
include('sidebar.php');

$clientId         = '';
$countEmail       = '';
$countCompnum     = '';
$pancardDocName   = '';
$pancardAttach    = '';
$photoDocName     = '';
$photoAttach      = '';
$addrProofName    = '';
$addrProofAttach  = '';
$aadharCardName   = '';
$aadharCardAttach = '';
$passportName     = '';
$passportAttach   = '';
$otherDocName     = '';
$otherDocAttach   = '';
$pancardId        = '';
$photoDocId       = '';
$addrProofId      = '';
$aadharCardId     = '';
$passportId       = '';
$otherDocId       = '';

$clientId =  $_SESSION['clientId'];

$editUserId='';
$showPrevBtn = 0;
if($_GET['action']=='edit')
{
	$showPrevBtn = 1;
	$editUserId=$_GET['id'];
	$clientData = $objclient->getClientById($editUserId);
	
	$clientPrsnlNum=$objAdmin->getPhoneNumbers($editUserId, 'client', 'client_personal');
	$clientCompNum=$objAdmin->getPhoneNumbers($editUserId, 'client', 'client_company');
	
	$address_details = $objclient->getClientAddressById($editUserId,'client_personal');
	$comp_address_details = $objclient->getClientAddressById($editUserId,'client_company');
	$attachdoc = $objclient->getdocumentbyid($editUserId,'Client');
	$ttlDoc=count($attachdoc);
	//echo "<pre>";print_r($attachdoc);
	$pancardDocName=$attachdoc[0]['name'];
	$pancardAttach=$attachdoc[0]['doc'];
	$photoDocName=$attachdoc[1]['name'];
	$photoAttach=$attachdoc[1]['doc'];
	$addrProofName=$attachdoc[2]['name'];
	$addrProofAttach=$attachdoc[2]['doc'];
	$aadharCardName=$attachdoc[3]['name'];
	$aadharCardAttach=$attachdoc[3]['doc'];
	$passportName=$attachdoc[4]['name'];
	$passportAttach=$attachdoc[4]['doc'];
	$otherDocName=$attachdoc[5]['name'];
	$otherDocAttach=$attachdoc[5]['doc'];
	$otherDocId    =$attachdoc[5]['id'];
	$pancardId     =$attachdoc[0]['id'];
	$photoDocId    =$attachdoc[1]['id'];
	$addrProofId   =$attachdoc[2]['id'];
	$aadharCardId  =$attachdoc[3]['id'];
	$passportId    =$attachdoc[4]['id'];
	
	
	$arrEmail=explode(',',$clientData['additional_email_address']);
	$arrCompEmail=explode(',',$clientData['company_email_address']);
	$countEmail=count($arrEmail);
	$countCompEmail=count($arrCompEmail);
	$countPrsnlAddr=count($address_details);
	$countCompAddr=count($comp_address_details);
	$countCompnum=count($clientCompNum);
}
$tab = 1;
if(isset($_GET['t']))
{
	$tab = base64_decode($_GET['t']);
}


$tabUrl = 'client.php?t=';
if(isset($_GET['action']))
{
	$tabUrl = 'client.php?action=edit&id='.$_GET['id'].'&t=';
}
$arrcountery=$objAdmin->get_countery();

$autoClientId = $objAdmin->autogenerate_id($_SESSION['clientId'], 'C');

$staticArr = array('PAN Card','Photo','Address Proof','Adhaar Card','Passport');
//$attachdoc
$docsArr = array();
$docsStaticArr = array();
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

$countPhone=count($clientPrsnlNum);
?>
<link href="uploadify/uploadify.css" rel="stylesheet">
<style>
	.v_hidden{ visibility:hidden !important}
</style>
<script src="uploadify/jquery.uploadify.js"></script>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Client Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Add Client</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">
				<div class="box-header with-border">
				 <ul class="nav nav-tabs">
				  <li <?php if($tab == 1){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 1){ echo 'class="disabled"';}?> href="#home" title="Click next to open"> <h3 class="box-title"><b>PERSONAL DETAILS</b></h3></a></li>
				  <li <?php if($tab == 2){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 2){ echo 'class="disabled"';}?> id='client_company_detail' href="#menu1" title="Click next to open"><h3 class="box-title"><b>COMPANY DETAILS</b></h3> </a></li>
				   <li <?php if($tab == 3){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 3){ echo 'class="disabled"';}?> id='client_official_detail' href="#menu2" title="Click next to open"><h3 class="box-title"><b>OFFICIAL DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 4){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 4){ echo 'class="disabled"';}?> id='client_banking_detail' href="#menu3" title="Click next to open"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 5){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 5){ echo 'class="disabled"';}?> id='client_attached_document' href="#menu4" title="Click next to open"><h3 class="box-title"><b>ATTACHED DOCUMENTS</b></h3> </a></li>
				</ul>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
				<div id="home" class="tab-pane fade <?php if($tab == 1){ echo 'in active';}?>">
				<form role="form" method="POST" name="client_prsnl_detail" id="client_prsnl_detail">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="<?php if($countPhone>1){echo $countPhone;}else{echo '1';}?>"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="<?php if($countEmail>1){echo $countEmail;}else{echo '1';}?>"> 
					<input type="hidden" name="userId" value="<?php echo $clientId;?>" />
					<input type="hidden" name="editId" value="<?php echo $editUserId;?>" />
					<input type="hidden" name="type" value="add_client_prsnl_detail" />
					<div class="box-body">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Name </b><span style="color:red;">*</span></h4>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="title" >Title</label>-->
									<select class="form-control" id="client_title" name="client_title">
										<option>--</option>
										<option value="Mr." <?php if(@$clientData['name_perfix'] == 'Mr.'){echo "selected";}?>>Mr.</option>
										<option value="Miss." <?php if(@$clientData['name_perfix'] == 'Miss.'){echo "selected";}?>>Miss.</option>
										<option value="Mrs." <?php if(@$clientData['name_perfix'] == 'Mrs.'){echo "selected";}?>>Mrs.</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="name">First Name</label>-->
									<input type="text" class="form-control" name="f_name" id="f_name" placeholder="First Name" value="<?php echo @$clientData['first_name'];?>"/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="middle">Middle Name</label>-->
									<input type="text" class="form-control" name="m_name" id="m_name" placeholder="Middle Name" value="<?php echo @$clientData['middle_name'];?>"/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="last">Last Name</label>-->
									<input type="text" class="form-control" name="l_name" id="l_name" placeholder="Last Name" value="<?php echo @$clientData['last_name'];?>"/>
								</div>
							</div>
						</div>	
							<!-- /.first line -->
						<div class="clearfix" style="clear:both;"></div>
						<div class="row">	
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
									<h4 class="box-title"><b style="font-size: 17px;">Contact Nos</b><span style="color:red;">*</span></h4>
								</div>
							</div>
							<div class="items3">
							
								<?php
								$i=1;
								$j=0;
								
								if($countPhone>0)
								{
									foreach($clientPrsnlNum as $key=>$val)
									{
										//print_r($val);
								?>
								
								<div id="Mobnumbbr_<?php echo $i;?>">
								
								<?php
									if($i > 1)
									{
								?>
									<div class="clearfix"></div>
									<div class="col-md-2"><div class="form-group"></div></div>
								<?php	
									}	
								?>	
								<input type="hidden" name="clientPerNumId[]" value="<?php echo $clientPrsnlNum[$j]['id'];?>" />
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Mobile</label>-->
											<input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo $clientPrsnlNum[$j]['contact_no']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">Code</label>-->
											<select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false">
												<option value="">Select</option>
												<option value="Mobile" <?php if($clientPrsnlNum[$j]['code'] == 'Mobile'){echo "selected";}?>>Mobile</option>
												<option value="Home" <?php if($clientPrsnlNum[$j]['code'] == 'Home'){echo "selected";}?>>Home</option>
												<option value="Work" <?php if($clientPrsnlNum[$j]['code'] == 'Work'){echo "selected";}?>>Work</option>
												<option value="Main" <?php if($clientPrsnlNum[$j]['code'] == 'Main'){echo "selected";}?>>Main</option>
												<option value="WorkFax" <?php if($clientPrsnlNum[$j]['code'] == 'WorkFax'){echo "selected";}?>>Work Fax</option>
												<option value="HomeFax" <?php if($clientPrsnlNum[$j]['code'] == 'HomeFax'){echo "selected";}?>>Home Fax</option>
												<option value="Pager" <?php if($clientPrsnlNum[$j]['code'] == 'Pager'){echo "selected";}?>>Pager</option>
												<option value="Other" <?php if($clientPrsnlNum[$j]['code'] == 'Other'){echo "selected";}?>>Other</option>
											</select>
										</div>
									</div>
									<!--<div class="col-md-3 v_hidden">
										<div class="form-group">
											<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
										</div>
									</div>-->
									<?php
									if($i > 1)
									{
									?>
									<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $i; ?>" href="javascript:void(0)" onclick="remove_item2(<?php echo $i; ?>, <?php echo $clientPrsnlNum[$j]['id'];?>, 'personal')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
									<?php } ?>
								</div>
								<?php
									$i++;
									$j++;
									}
								?>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add More Contact Nos" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php	
								}
								else{
								?>
								<div id="Mobnumbbr_1">
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Mobile</label>-->
											<input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">Code</label>-->
											<select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false">
												<option value="">Select</option>
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
									<!--<div class="col-md-3 v_hidden">
										<div class="form-group">
											<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
										</div>
									</div>-->
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add More Contact Nos" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php }?>
								
							</div>
							
							<!-- /.second line -->
							<!-- /.third line -->
							<div class="clearfix" style="clear:both;"></div>
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Email </b><span style="color:red;">*</span></h4>
								</div>
							</div>
							<div class="items4">
								<?php
								$k=1;
								if($countEmail>0)
								{
									for($k=1;$k<=$countEmail;$k++)
									{
										//print_r($arrEmail);
								?>
								<div id="Email_<?php echo $k;?>">
								
								<?php
									if($k > 1)
									{
								?>
									<div class="clearfix"></div>
									<div class="col-md-2"><div class="form-group"></div></div>
								<?php	
									}	
								?>	
								<div class="col-md-6">
									<div class="form-group">
										<!--<label for="userEmail" >Email</label>-->
										<input type="email" class="form-control" name="client_prsnl_email[]" id="userEmail" placeholder="Email" value="<?php echo $arrEmail[$k-1]; ?>" />
									</div>
								</div>
								<?php
								if($k > 1){
								?>
								<div class="col-md-1"> <div class="form-group"><a class="delete" rel="2" href="javascript:void(0)" onclick="remove_item1(<?php echo $k; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
								<?php
								}
								?>
								</div>
								
								<?php
								
									}
								?>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php	
								}
								else{
								?>
								<div id="Email_1">
									<div class="col-md-6">
										<div class="form-group">
											<!--<label for="userEmail" >Email</label>-->
											<input type="email" class="form-control" name="client_prsnl_email[]" id="userEmail" placeholder="Email" value="<?php echo $usrData['email']; ?>" />
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php }?>
								<div class="clearfix"></div>
							</div>
							
									<!-- forth Line -->
						
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Home Address </b></h4>
								</div>
							</div>
							<div class="col-md-10" style="padding:0">
							<div class="items">
							
								<?php
									$prsnlj=0;
									$prsnlAddrDivInitVal=1;
									//echo $countPrsnlAddr;
									if($countPrsnlAddr>0)
									{
										foreach($address_details as $key=>$val)
										{
											//print_r($val);
								?>
								<div id="address_<?php echo $prsnlAddrDivInitVal;?>">
								
									<input type="hidden" name="clntPrsnlAddrId[]" value="<?php if($val['id']){echo $val['id'];}else{echo 0;}?>"/>
									<div class="col-md-6">
										<div class="form-group">
											<!--<label for="userAddline1">Address Line 1</label>-->
											<input type="text" class="form-control" name="userAddline1[]" id="" placeholder="Address line 1" value="<?php echo $val['address1']; ?>"/>
										</div>
									</div>
								
									<div class="col-md-5">
										<div class="form-group">
											<!--<label for="userAddline2">Address Line 2</label>-->
											<input type="text" class="form-control" name="userAddline2[]" id="" placeholder="Address line 2" value="<?php echo $val['address2']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Country</label>-->
											<!--<input type="text" class="form-control" name="userCountry[]" placeholder="Country" value="<?php echo @$val['country']; ?>"/>-->
											
											<select class="form-control select2" name="userCountry[]" id="userCountry" data-placeholder="Select a Country">
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
										<!--<label for="userState">State</label>-->
										<!--<input type="text" class="form-control" name="userState[]" id="last" placeholder="State" value="<?php echo $val['state']; ?>"/>-->
										<select class="form-control select2" name="userState[]" id="userState" data-placeholder="Select a State">
											<option value="">--Select State--</option>
											<?php
											if(!empty($val['country']))
											{
												$arrState=$objAdmin->get_state($val['country']);
												//print_r($arrState);
											}
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
										<!--<label for="usercity">City</label>-->
										<!--<input type="text" class="form-control" name="usercity[]" id="code" placeholder="City" value="<?php echo $val['city']; ?>"/>-->
										<select class="form-control select2" name="usercity[]" id="usercity" data-placeholder="Select a City">
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
										<!--<label for="userPinCode">Pin Code</label>-->
										<input type="text" class="form-control" name="userPinCode[]" id="last" placeholder="Code" value="<?php echo $val['pin_code']; ?>"/>
									</div>
								</div>
								</div>
								<?php
									if($prsnlAddrDivInitVal==1)
									{
								?>
								<!--<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="add_more_items" id="add_more_items" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>-->
								<?php
									}
										$prsnlAddrDivInitVal++;
										$prsnlj++;
										}
									}
									else
									{
								?>
								<div id="address_1">
									<div class="col-md-6">
										<div class="form-group">
											<!--<label for="userAddline1">Address Line 1</label>-->
											<input type="text" class="form-control" name="userAddline1[]" id="userPhone" placeholder="Address line 1" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
								
									<div class="col-md-5">
										<div class="form-group">
											<!--<label for="userAddline2">Address Line 2</label>-->
											<input type="text" class="form-control" name="userAddline2[]" id="userPhone" placeholder="Address line 2" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<input type="text" class="form-control" name="userCountry[]" placeholder="Country" value="<?php echo @$val['country']; ?>"/>-->
											<select class="form-control select2" name="userCountry[]" id="userCountry" data-placeholder="Select a Country">
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
											<!--<label for="userState">State</label>-->
											<!--<input type="text" class="form-control" name="userState[]" id="last" placeholder="State" value=""/>-->
											<select class="form-control select2" name="userState[]" id="userState" data-placeholder="Select a State">
													<option value="">--Select State--</option>
													<?php
													
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
											<!--<label for="usercity">City</label>-->
											<!--<input type="text" class="form-control" name="usercity[]" id="code" placeholder="City" value=""/>-->
											<select class="form-control select2" name="usercity[]" id="usercity" data-placeholder="Select a City">
												<option value="">--Select City--</option>
												<?php
													
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
											<!--<label for="userPinCode">Pin Code</label>-->
											<input type="text" class="form-control" name="userPinCode[]" id="last" placeholder="Code" value=""/>
										</div>
									</div>
								</div>
								<!--<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="add_more_items" id="add_more_items" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>-->
								<?php
									}
								?>
								
							</div>
							</div>
											
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	D.O.B </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
									<div class='input-group date' >
									<input type='text' class="form-control"  id="dob_date" name="dob_date" value="<?php if($clientData['data_of_birth'] != '0000-00-00' && isset($clientData['anniversary_date'])){ echo date('j M Y',strtotime(@$clientData['data_of_birth']));}?>"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
						
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Anniversary </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
										<div class='input-group date' >
											<input type='text' class="form-control"  id="anvsryData" name="anvsryData" value="<?php if($clientData['anniversary_date'] != '0000-00-00' && isset($clientData['anniversary_date'])){echo date('j M Y',strtotime($clientData['anniversary_date']));} ?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="prsnl_detail_submit" id="prsnl_detail_submit">Next</button>
					</div>
				</form>
				</div>
				<div id="menu1" class="tab-pane fade <?php if($tab == 2){ echo 'in active';}?>">
				<form role="form" method="POST" name="client_company_details" id="client_company_details">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="companyNo_count" name="companyNo_count" value="<?php if($countCompnum > 1){echo $countCompnum;}else{echo 1;}?>"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="clientId" value="<?php echo $clientId;?>" />
					<input type="hidden" name="editId" value="<?php echo $editUserId;?>" />
					<input type="hidden" name="type" value="add_client_company_detail" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Organization</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="Organization">Organization</label>-->
									<input type="text" class="form-control" name="Organization" id="Organization" placeholder="Organization" value="<?php echo @$clientData['organization'];?>"/>
								</div>
							</div>
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Job Title</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="Job Title">Job Title</label>-->
									<input type="text" class="form-control" name="job_title" id="job_title" placeholder="Job Title" value="<?php echo @$clientData['job_title'];?>"/>
								</div>
							</div>
							<!-- /.first line -->
						
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Contact Nos </b></h4>
								</div>
							</div>
							<div class="cont">
								<?php
									$countCompNumDiv=1;
									$compNum=0;
									if($countCompnum>0)
									{
										foreach($clientCompNum as $key=>$val)
										{
								?>
								<div id="connumbbr_<?php echo $countCompNumDiv;?>">
								<?php
									if($countCompNumDiv > 1)
									{
								?>
									<div class="clearfix"></div>
									<div class="col-md-2"><div class="form-group"></div></div>
								<?php	
									}	
								?>
									<input type="hidden" name="clientCompNumId[]" value="<?php echo $val['id'];?>" />
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Mobile</label>-->
											<input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo $val['contact_no']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">Code</label>-->
											<select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false">
												<option value="">Select</option>
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
									<!--<div class="col-md-3 v_hidden">
										<div class="form-group">
											<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
										</div>
									</div>-->
									<?php
										if($countCompNumDiv>1){
									?>
									<div class="col-md-1"> <div class="form-group"><a class="delete" rel="5" href="javascript:void(0)" onclick="remove_item2(<?php echo $countCompNumDiv; ?>, <?php echo $val['id'];?>, 'company')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
									<?php } ?>
								</div>
								
								<?php
									if($countCompNumDiv==1)
									{
								?>
								
								<?php
									}
									$countCompNumDiv++;
									$compNum++;									
										}
									?>
									<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add More Contact Nos." style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
									<?php	
									}
									else
									{
								?>
								<div id="connumbbr_1">
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Mobile</label>-->
											<input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">Code</label>-->
											<select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false">
												<option value="">Select</option>
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
									<!--<div class="col-md-3 v_hidden">
										<div class="form-group">
											<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
										</div>
									</div>-->
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add More Contact Nos" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php
									}
								?>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Email </b></h4>
								</div>
							</div>
							<div class="emaills">
								<?php
									$comIntVal=1;
									if($countCompEmail>0)
									{
										for($comIntVal=1;$comIntVal<=$countCompEmail;$comIntVal++)
										{
								?>
								<div id="Emaill_<?php echo $comIntVal; ?>" >
								<?php
									if($comIntVal > 1)
									{
								?>
									<div class="clearfix"></div>
									<div class="col-md-2"><div class="form-group"></div></div>
								<?php	
									}	
								?>
								<div class="col-md-6">
									<div class="form-group">
										<!--<label for="userEmail" >Email</label>-->
										<input type="email" class="form-control" name="client_company_email[]" id="userEmail" placeholder="Email" value="<?php echo $arrCompEmail[$comIntVal-1]; ?>" />
									</div>
								</div>
								<?php
								if($comIntVal>1){
								?>
								<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $comIntVal; ?>" href="javascript:void(0)" onclick="remove_item7(<?php echo $comIntVal; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
								<?php } ?>
								</div>
								
								<?php
										}
								?>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="emaill" id="emaill" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php	
									}
									else
									{
								?>
								<div id="Emaill_1" >
								<div class="col-md-6">
									<div class="form-group">
										<!--<label for="userEmail" >Email</label>-->
										<input type="email" class="form-control" name="client_company_email[]" id="userEmail" placeholder="Email" value="<?php echo $usrData['email']; ?>" />
									</div>
								</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="emaill" id="emaill" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php
									}
								?>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Company Address</b></h4>
								</div>
							</div>
							<div class="col-md-10" style="padding:0;">
							<div class="ite">
								<?php
									$comAddr=0;
									$compAddInitVal=1;
									if($countCompAddr>0)
									{
										foreach($comp_address_details as $key=>$val)
										{
								?>
								<div id="person_<?php echo $compAddInitVal;?>">
								
									<input type="hidden" name="clntCompAddrId[]" value="<?php echo $val['id'];?>"/>
									<div class="col-md-6">
										<div class="form-group">
											<!--<label for="userPhone">Address Line 1</label>-->
											<input type="text" class="form-control" name="userAddline1[]" id="userPhone" placeholder="Address line 1" value="<?php echo $val['address1']; ?>"/>
										</div>
									</div>
								
									<div class="col-md-5">
										<div class="form-group">
											<!--<label for="userPhone">Address Line 2</label>-->
											<input type="text" class="form-control" name="userAddline2[]" id="userPhone" placeholder="Address line 2" value="<?php echo $val['address2']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Country</label>-->
											<!--<input type="text" class="form-control" name="userCountry[]" placeholder="Country" value="<?php echo @$val['country']; ?>"/>-->
											<select class="form-control select2" name="userCountry[]" id="compCountry" data-placeholder="Select a Country">
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
											<!--<input type="text" class="form-control" name="userState[]" id="last" placeholder="State" value="<?php echo $val['state']; ?>"/>-->
											<select class="form-control select2" name="userState[]" id="compState" data-placeholder="Select a State">
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
											<!--<input type="text" class="form-control" name="usercity[]" id="code" placeholder="City" value="<?php echo $val['city']; ?>"/>-->
											<select class="form-control select2" name="usercity[]" id="compcity" data-placeholder="Select a City">
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
											<input type="text" class="form-control" name="userPinCode[]" id="last" placeholder="Code" value="<?php echo $val['pin_code']; ?>"/>
										</div>
									</div>
								</div>
								<?php
									if($compAddInitVal==1)
									{
								?>
								<!--<div class="col-md-1">
									<div class="form-group">
										
										<a href="javascript:void(0);" class="add_more_item" id="add_more_item" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>-->
								<?php
									}
										$compAddInitVal++;
										}
									}
									else
									{
								?>
								<div id="person_1">
									<div class="col-md-6">
										<div class="form-group">
											<!--<label for="userPhone">Address Line 1</label>-->
											<input type="text" class="form-control" name="userAddline1[]" id="userPhone" placeholder="Address line 1" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
								
									<div class="col-md-5">
										<div class="form-group">
											<!--<label for="userPhone">Address Line 2</label>-->
											<input type="text" class="form-control" name="userAddline2[]" id="userPhone" placeholder="Address line 2" value="<?php echo $usrData['mobileno']; ?>"/>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="userPhone">Country</label>-->
											<!--<input type="text" class="form-control" name="userCountry[]" placeholder="Country" value="<?php echo @$val['country']; ?>"/>-->
											<select class="form-control select2" name="userCountry[]" id="compCountry" data-placeholder="Select a Country">
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
											<!--<label for="last">State</label>-->
											<!--<input type="text" class="form-control" name="userState[]" id="last" placeholder="State" value=""/>-->
											<select class="form-control select2" name="userState[]" id="compState" data-placeholder="Select a State">
												<option value="">--Select State--</option>
												<?php
												//$arrState=$objAdmin->get_state($val['country']);
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
											<!--<input type="text" class="form-control" name="usercity[]" id="code" placeholder="City" value=""/>-->
											<select class="form-control select2" name="usercity[]" id="compcity" data-placeholder="Select a City">
												<option value="">--Select City--</option>
												<?php
													//$newCityArr =$objAdmin->get_city($val['state']);
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
											<input type="text" class="form-control" name="userPinCode[]" id="last" placeholder="Code" value=""/>
										</div>
									</div>
								</div>
								
								<?php
									}
								?>
								
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
				<div id="menu2" class="tab-pane fade <?php if($tab == 3){ echo 'in active';}?>">
					<form role="form" method="POST" name="client_offical_detail" id="client_offical_detail">
						<input type="hidden" id="item_count" name="item_count" value="1"> 
						<input type="hidden" id="item_count1" name="item_count1" value="1"> 
						<input type="hidden" id="item_count2" name="item_count2" value="1"> 
						<input type="hidden" id="item_count3" name="item_count3" value="1"> 
						<input type="hidden" id="item_count4" name="item_count4" value="1"> 
						<input type="hidden" name="clientId" value="<?php echo $clientId;?>" />
						<input type="hidden" name="type" value="add_client_offical_detail" />
						<input type="hidden" name="editId" value="<?php echo $editUserId;?>" />
						<div class="box-body">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Client ID</b></h4>
									</div>
								</div>
							
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="search">Client ID</label>-->
										<input type="text" class="form-control " name="client_id" id="client_id" placeholder="Client ID" value="<?php echo $autoClientId; ?>" readonly/>
									</div>
								
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Refrence</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Reference</label>-->
										<input type="text" class="form-control" name="client_refrence" id="client_refrence" placeholder="Refrence" value="<?php echo $clientData['refrence'];?>"/>
									</div>
								</div><!-- /.form-group -->
								<input type="hidden" class="form-control" name="sale_representative" id="sale_representative" value="1"/>
								
								<!--<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Sales Rep.</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<select class="form-control" id="sale_representative" name="sale_representative" >
											<option value="">-----SELECT-----</option>
											<option value="Sales Representative One" <?php if(@$clientData['salse_reprenstive'] == 'Sales Representative One'){echo "selected";}?>>Sales Representative One</option>
											<option value="Sales Representative Two" <?php if(@$clientData['salse_reprenstive'] == 'Sales Representative Two'){echo "selected";}?>>Sales Representative Two</option>
											<option value="Sales Representative Three" <?php if(@$clientData['salse_reprenstive'] == 'Sales Representative Three'){echo "selected";}?>>Sales Representative Three</option>
											<option value="Sales Representative Four" <?php if(@$clientData['salse_reprenstive'] == 'Sales Representative Four'){echo "selected";}?>>Sales Representative Four</option>
											<option value="Sales Representative Five" <?php if(@$clientData['salse_reprenstive'] == 'Sales Representative Five'){echo "selected";}?>>Sales Representative Five</option>
										</select>
									</div>
								</div>--><!-- /.form-group -->
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Password</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Password</label>-->
										<input type="text" class="form-control" name="Client_user_pass" id="Client_user_pass" placeholder="Password" value="<?php echo @$clientData['client_login_password'];?>"/>
									</div>
								</div>
								<!-- forth Line -->						
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
				<div id="menu3" class="tab-pane fade <?php if($tab == 4){ echo 'in active';}?>">
					<form role="form" method="POST" name="client_banking_details" id="client_banking_details">
						 <input type="hidden" id="item_count" name="item_count" value="1"> 
						 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
						 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
						 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
						 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
							<input type="hidden" name="userId" value="<?php echo $clientData['client_id']; ?>" />
							<input type="hidden" name="clientId" value="<?php echo $clientId;?>" />
							<input type="hidden" name="type" value="add_client_bank_detail" />
							<input type="hidden" name="editId" value="<?php echo $editUserId;?>" />
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
											<input type="text" class="form-control " name="client_panNo" id="client_panNo" placeholder="PAN No." value="<?php echo @$clientData['pan_number'];?>"/>
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
											<input type="text" class="form-control " name="client_acc_no" id="client_acc_no" placeholder="Account No." value="<?php echo @$clientData['account_number'];?>"/>
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
											<input type="text" class="form-control " name="client_acc_name" id="client_acc_name" placeholder="Account Name" value="<?php echo @$clientData['account_name'];?>"/>
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
											<input type="text" class="form-control " name="client_bank" id="client_bank" placeholder="Bank" value="<?php echo @$clientData['bank'];?>"/>
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
											<input type="text" class="form-control " name="client_branch" id="client_branch" placeholder="Branch" value="<?php echo @$clientData['branch'];?>"/>
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
											<input type="text" class="form-control " name="client_ifsc" id="client_ifsc" placeholder="IFSC" value="<?php echo @$clientData['ifsc'];?>"/>
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
				<div id="menu4" class="tab-pane fade <?php if($tab == 5){ echo 'in active';}?>">
				<div style="display:none;" id="me1"><img src="tenor.gif" style="position:absolute; top:70px; opacity:1; "/></div>
				<form role="form" method="POST" name="client_doc_detail" id="client_doc_detail" enctype = "multipart/form-data">
					<input type="hidden" id="item_count" name="item_count" value="1"> 
					<input type="hidden" id="item_count1" name="item_count1" value="1"> 
					<input type="hidden" id="item_count2" name="item_count2" value="1"> 
					<input type="hidden" id="item_count3" name="item_count3" value="1"> 
					<input type="hidden" id="item_count4" name="item_count4" value="1">
					 <input type="hidden" id="" name="hotl_id" value="<?php echo @$_GET['id'] ?>"> 
					
					<?php
						/* if($ttlDoc >= 5){
							$conter = $ttlDoc+1;
						}
						else
						{
							$conter = 6;
						} */
						
						$custDocs = count($docsCustArr);
						if($custDocs > 0){
							$conter = $custDocs+6;
						}
						else
						{
							$conter = 6;
						}
					?>
					
					<input type="hidden" name="totalFld" id="totalFld" value="<?php echo $conter; ?>"/>
					<input type="hidden" name="userId" value="<?php echo $clientData['client_id']; ?>" />
					<input type="hidden" name="clientId" value="<?php echo $clientId;?>"/>
					<input type="hidden" name="type" value="add_client_doc_detail"/>
					<input type="hidden" name="editId" value="<?php echo $editUserId;?>"/>
					<div class="box-body">
						<div class="row">
							<div class="myattch">
								<div id="attch_1">
									<input type="hidden" name="attachEdId[]" class="attfileId_1" id="panCardId" value="<?php echo $docsArr['PAN Card']['id'];?>"/>
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	PAN Card </b></h4>
											<input type="hidden" name="docFileName[]" id="panCardFileName" value="PAN Card"/>
										</div>
									</div>
									<div class="col-md-10">
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="pan_card_copy">PAN Card</label>-->
												<label class="btn-bs-file btn btn-md btn-primary">Choose File
												<input type="file" class="form-control" name="file_upload[]" id="pan_card_copy"  value="" multiple />
												<input type="hidden" class="attfileId_1" name="upldFileName[]" id="panCardDoc" value="<?php echo $docsArr['PAN Card']['doc'];?>" />
											</label>
											</div>
										</div>
										<div class="col-md-5">
											<div id="panCardDocName" class="attfile_1"><?php echo $docsArr['PAN Card']['doc'];?></div>
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
												<a class="delete" relId="<?php echo @$docsArr['PAN Card']['id'];?>" rel="1" href="javascript:void(0)" onclick="remove_attach(1,'<?php echo @$docsArr['PAN Card']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
											</div> 
										</div>
										<?php } ?>
									</div><!-- /.form-group -->
								</div>
								<div style="clear:both;"></div>
								<div id="attch_2">
									<input type="hidden" name="attachEdId[]" class="attfileId_2" id="photoId" value="<?php echo $docsArr['Photo']['id'];?>"/>
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
											<input type="hidden" name="docFileName[]" id="photoFileName" value="Photo"/>
										</div>
									</div>
									<div class="col-md-10">
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="photo_copy">Photo</label>-->
												<label class="btn-bs-file btn btn-md btn-primary">Choose File
												<input type="file" class="form-control" name="file_upload1[]" id="photo_copy"  value="" multiple />
												<input type="hidden" class="attfileId_2" name="upldFileName[]" id="photoDoc" value="<?php echo $docsArr['Photo']['doc'];?>" />
											</label>
											</div>
										</div>
										<div class="col-md-5">	
											<div id="photoDocName" class="attfile_2"><?php echo $docsArr['Photo']['doc'];?></div>
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
												<a class="delete" relId="<?php echo @$docsArr['Photo']['id'];?>" rel="2" href="javascript:void(0)" onclick="remove_attach(2,'<?php echo @$docsArr['Photo']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
											</div> 
										</div>
										<?php } ?>
									</div><!-- /.form-group -->
								</div>
								<div style="clear:both;"></div>								
								<div id="attch_3">
									<input type="hidden" name="attachEdId[]" class="attfileId_3" id="addrProofId" value="<?php echo $docsArr['Address Proof']['id'];?>"/>
									<div class="col-md-2">
										<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Address Proof</b></h4>
										<input type="hidden" name="docFileName[]" id="addrProofFileName" value="Address Proof" multiple />
										</div>
									</div>
									<div class="col-md-10">
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="address_prof_copy">Address Proof</label>-->
												<label class="btn-bs-file btn btn-md btn-primary">Choose File
												<input type="file" class="form-control" name="file_upload2[]" id="address_prof_copy"  value="" multiple />
												<input type="hidden" class="attfileId_3" name="upldFileName[]" id="addrProofDoc" value="<?php echo $docsArr['Address Proof']['doc'];?>" />
											</label>
											</div>	
										</div>
										<div class="col-md-5">
											<div id="addrProofDocName" class="attfile_3"><?php echo $docsArr['Address Proof']['doc'];?></div>
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
												<a class="delete" relId="<?php echo @$docsArr['Address Proof']['id'];?>" rel="3" href="javascript:void(0)" onclick="remove_attach(3,'<?php echo @$docsArr['Address Proof']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
											</div> 
										</div>
										<?php } ?>
									</div><!-- /.form-group -->
								</div>
								<div style="clear:both;"></div>
								<div id="attch_4">
									<input type="hidden" name="attachEdId[]" class="attfileId_4" id="aadharCardId" value="<?php echo $docsArr['Adhaar Card']['id'];?>"/>
									<div class="col-md-2">
										<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Adhaar Card </b></h4>
										<input type="hidden" name="docFileName[]" id="aadharCardFileName" value="Adhaar Card" multiple />
										</div>
									</div>
									<div class="col-md-10">
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="adhaar_copy">Adhaar Card</label>-->
												<label class="btn-bs-file btn btn-md btn-primary">Choose File
												<input type="file" class="form-control" name="file_upload3[]" id="adhaar_copy"  value="" multiple />
												<input type="hidden" class="attfileId_4" name="upldFileName[]" id="aadharCardDoc" value="<?php echo $docsArr['Adhaar Card']['doc'];?>" />
											</label>
											</div>	
										</div>
										<div class="col-md-5">
											<div id="aadharCardDocName" class="attfile_4"><?php echo $docsArr['Adhaar Card']['doc'];?></div>
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
												<a class="delete" relId="<?php echo @$docsArr['Adhaar Card']['id'];?>" rel="4" href="javascript:void(0)" onclick="remove_attach(4,'<?php echo @$docsArr['Adhaar Card']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
											</div> 
										</div>
										<?php } ?>
									</div><!-- /.form-group -->
								</div>
								<div style="clear:both;"></div>
								<div id="attch_5">
									<input type="hidden" name="attachEdId[]" class="attfileId_5" id="passportId" value="<?php echo $docsArr['Passport']['id'];?>"/>
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">Passport </b></h4>
											<input type="hidden" name="docFileName[]" id="passPortFileName" value="Passport" multiple />
										</div>
									</div>
									<div class="col-md-10">
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="passport_copy">Passport</label>-->
												<label class="btn-bs-file btn btn-md btn-primary">Choose File
												<input type="file" class="form-control" name="file_upload4[]" id="passport_copy"  value="" multiple />
												<input type="hidden" class="attfileId_5" name="upldFileName[]" id="passportDoc" value="<?php echo $docsArr['Passport']['doc'];?>" />
											</label>
											</div>	
										</div>	
										<div class="col-md-5">	
											<div id="passportDocName" class="attfile_5"><?php echo $docsArr['Passport']['doc'];?></div>
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
												<a class="delete" relId="<?php echo @$docsArr['Passport']['id'];?>" rel="5" href="javascript:void(0)" onclick="remove_attach(5,'<?php echo @$docsArr['Passport']['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
											</div> 
										</div>
										<?php } ?>
									</div><!-- /.form-group -->
								</div>
								        <?php
										//echo $ttlDoc;
										if($custDocs > 0)
										{
										//if($ttlDoc>0){
											$countAttach=6;
											for($i=0;$i<$custDocs;$i++){
												//echo 'sdafasd';
									?>
									<div id="attch_<?php echo $countAttach;?>">
										<div style="clear:both;"></div>
										<input type="hidden" name="attachEdId[]" id="addMoreId" value="<?php echo $docsCustArr[$i]['id'];?>" />
										<div class="col-md-2">
											<div class="form-group">
												<input type="text" class="form-control" name="docFileName[]" id="addmorefilename_<?php echo $countAttach;?>" placeholder="File Name" value="<?php echo $docsCustArr[$i]['name'];?>"/>
											</div>
										</div>
										<div class="col-md-10">
											<div class="col-md-4">
											<div class="form-group">
												<label class="btn-bs-file btn btn-md btn-primary">
									            Choose File
												<input class="file_upload" id="add_more_file_<?php echo $countAttach;?>" name="file_upload5[]" type="file" multiple>
												<input type="hidden" name="upldFileName[]" id="addMoreDoc_<?php echo $countAttach;?>" value="<?php echo $docsCustArr[$i]['doc'];?>"/>
											</label>
												<p class="help-block text-danger"></p>
											</div>
											</div>
											<div class="col-md-5">
												<div id="add_more_uploaded_<?php echo $countAttach;?>"><?php echo $docsCustArr[$i]['doc'];?></div>
											</div>
										<!-- /.form-group -->
										<div class="col-md-2">
											<div class="form-group">
												<a class="delete" relId="<?php echo @$docsCustArr[$i]['id'];?>" rel="<?php echo $countAttach;?>" href="javascript:void(0)" onclick="remove_attach('<?php echo $countAttach;?>','<?php echo @$docsCustArr[$i]['id'];?>','dynamic')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
											</div> 
										</div>
									</div>
										
									</div>
								
									<?php
										$countAttach++;
											}
										}
									?>
									<div class="col-md-2 pull-right">
										<div class="form-group">
											<!--<label for="last">Add More</label>-->
											<a href="javascript:void(0);" class="addMoreDocument" id="addMoreDocument" title="Add More Documents" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>
									<div style="clear:both;"></div>
								
							</div>	
						</div>
					</div>
					
				</form>
				<div class="status"></div>
				<div class="box-footer">
					<?php if($showPrevBtn){?>
					<a href="<?php echo $tabUrl.base64_encode($tab-1); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
					<?php } ?>
					<button type="button" class="btn btn-primary" name="client_doc_detail_btn" id="client_doc_detail_btn">Submit</button>
				</div>
				</div>
				</div>
			
			</div>
		</section>
	</div>

	<script>
	
		$(document).ready(function(){
			
			$(".nav-tabs a[data-toggle=tab]").on("click", function(e) {
			  if ($(this).hasClass("disabled")) {
				e.preventDefault();
				return false;
			  }
			});
			
			$( "#dob_date" ).datepicker({
			  format: "dd MM yyyy"
			});
	$(".select2").select2();
	$( "#anvsryData" ).datepicker({
			
	  format: "dd MM yyyy"
	});
	var totalFld = $("#totalFld").val();
	for(var i=6; i<=totalFld; i++)
	{
		uplodifyMore(i);
	}
	$("#addMoreDocument").click(function(){
		var count=$("#totalFld").val();
		//alert(count);
		count++;
		var attachId=0;
		$('<div style="clear:both;"></div><div id="attch_'+count+'"><input type="hidden" name="attachEdId[]" id="addMoreId" value="" /><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="docFileName[]" id="addmorefilename_'+count+'" placeholder="File Name" value=""/></div></div><div class="col-md-10"><div class="col-md-4"><div class="form-group"><label class="btn-bs-file btn btn-md btn-primary">Choose File<input class="file_upload" id="add_more_file_'+count+'" name="file_upload5[]" type="file" multiple><input type="hidden" name="upldFileName[]" id="addMoreDoc_'+count+'" value="" /></label></div><p class="help-block text-danger"></p></div><div class="col-md-5"><div id="add_more_uploaded_'+count+'"></div></div><div class="col-md-2"><div class="form-group"><a class="delete delAttach" relId="" rel="'+count+'" href="javascript:void(0)" onclick="remove_attach('+count+','+attachId+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div> </div></div><div style="clear:both;"></div>').insertAfter($(this).parent().parent().prev());
			
		$("#totalFld").val(count);
		uplodifyMore(count);
	});
	$("#compCountry").change(function()
			{
				//alert("punamsaini");
				var id=$(this).val();
				
				var dataString = 'id='+ id;
				$("#compState").find('option').remove();
				$("#compcity").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#compState").html(html);			
					} 
				});
			});
	
			$("#compState").change(function()
			{
				
				var id=$(this).val();
				//alert(id);
				var dataString = 'id='+ id;
				$("#compcity").find('option').remove();
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#compcity").html(html);
					} 
				});
			});
	$("#userCountry").change(function()
			{
				//alert("punamsaini");
				var id=$(this).val();
				
				var dataString = 'id='+ id;
				$("#userState").find('option').remove();
				$("#usercity").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#userState").html(html);			
					} 
				});
			});
	
			$("#userState").change(function()
			{
				
				var id=$(this).val();
				//alert(id);
				var dataString = 'id='+ id;
				$("#usercity").find('option').remove();
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#usercity").html(html);
					} 
				});
			});
	$("#add_more_item").click(function(){
		
				var count = $("#item_count").val();
				//alert(count);
				count++;
				$(".ite").append('<div id="person_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="clntCompAddrId[]" value="0"/><div class="col-md-5"><div class="form-group"><input type="text" class="form-control" name="userAddline1[]" id="userPhone" placeholder="Address line 1" value=""/></div></div><div class="col-md-5"><div class="form-group"><input type="text" class="form-control" name="userAddline2[]" id="userPhone" placeholder="Address line 2" value=""/></div></div><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="userCountry[]" placeholder="Country" value=""/></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="usercity[]" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="userState[]" id="last" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="userPinCode[]" id="last" placeholder="Code" value=""/>	</div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item6('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count").val(count);
				//alert()
			});
		$("#contumbbr").click(function(){
		
				var count = $("#companyNo_count").val();
				//alert(count);
				count++;
				$('<div id="connumbbr_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="clientCompNumId[]" value="0" /><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item5('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>').insertAfter($(this).parent().parent().prev());
				
				$("#companyNo_count").val(count);
				//alert()
			});	
	
		$("#add_more_items").click(function(){
		
				var count = $("#item_count").val();
				//alert(count);
				count++;
				$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="clntPrsnlAddrId[]" value="0"/><div class="col-md-5"><div class="form-group"><input type="text" class="form-control" name="userAddline1[]" id="userPhone" placeholder="Address line 1" value=""/></div></div><div class="col-md-5"><div class="form-group"><input type="text" class="form-control" name="userAddline2[]" id="userPhone" placeholder="Address line 2" value=""/></div></div><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="userCountry[]" placeholder="Country" value=""/></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="usercity[]" id="code" placeholder="City" value=""/></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="userState[]" id="last" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="userPinCode[]" id="last" placeholder="Code" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count").val(count);
				//alert()
			});
		
			$("#Mnumbbr").click(function(){
			
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$('<div id="Mobnumbbr_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="clientPerNumId[]" value="0" /><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+', 0)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>').insertAfter($(this).parent().parent().prev());
				
				$("#item_count3").val(count);
				//alert()
			});
			
			$("#emails").click(function(){
		
				var count = $("#item_count4").val();
				//alert(count);
				count++;
				$('<div id="Email_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-6"><div class="form-group"><input type="email" class="form-control" name="client_prsnl_email[]" id="userEmail" placeholder="Email" value="" /></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item1('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div>').insertAfter($(this).parent().parent().prev());
				
				$("#item_count4").val(count);
				//alert()
			});
		
			$("#emaill").click(function(){
		
				var count = $("#item_count4").val();
				//alert(count);
				count++;
				$('<div id="Emaill_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-6"><div class="form-group"><input type="email" class="form-control" name="client_company_email[]" id="userEmail" placeholder="Email" value="" /></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item7('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div> ').insertAfter($(this).parent().parent().prev());
				
				$("#item_count4").val(count);
			});		
			
			$("#client_doc_detail_btn").click(function(){
				//alert("sdfdsf");
				$.ajax({
					type: "POST",
					url: "_ajax_client_prsnl_detail.php",
					data: $("#client_doc_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(msg)
					{
						if(msg.status == 1)
						{
							$(".status").show().html('<div class="alert alert-success">Client Detail Saved Sucessfully</div>');
							window.setTimeout(function(){
								window.location.href='clientlist.php';
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
						$("#addmore_6").val('');
						$('#add_more_uploaded_6').html('');
						$(".attach_new6").css({"display": "none"});
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
									$('.attfile_1').html('');
									$(".attach_newed").css({"display": "none"});
                                    }
									if(counter == '2')
									{
									$("#photoDoc").val('');
									$('#photoDocs').html('');
									$('.attfile_2').html('');
									$(".attach_newed1").css({"display": "none"});
									}
									if(counter == '3')
									{
									$("#addrProofDoc").val('');
									$('#addrProofDocs').html('');
									$('.attfile_3').html('');
									$(".attach_newed2").css({"display": "none"});

									}
									if(counter == '4')
									{
									$("#aadharCardDoc").val('');
									$('#aadharCardDocs').html('');
									$('.attfile_4').html('');
									$(".attach_newed3").css({"display": "none"});

									}
									if(counter == '5')
									{
									$("#passportDoc").val('');
									$('#passportDocs').html('')
									$('.attfile_5').html('');;
									$(".attach_newed4").css({"display": "none"});

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
								if(type == 'company')
								{
									$('#connumbbr_'+counter).remove();
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
		function remove_item6(counter)
		{
			$('#person_'+counter).remove();
		}
		function remove_item5(counter)
		{
			$('#connumbbr_'+counter).remove();
		}
		function remove_item7(counter)
		{
			$('#Emaill_'+counter).remove();
		}
		

	</script>
	<script>
	function uplodifyMore(number)
		{
		  $('#add_more_file_'+number).change(function(){
		  var formData = new FormData($("#client_doc_detail")[0]);
		  var str='';
			$.ajax({  
                url :"upload_more_doc_client.php", 			
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
					var preImg = $('#addMoreDoc_'+number).val();
					if(imgName != null){
					
					// $('#hotel_images_'+number).append('<img alt="Restaurant Logo" class="superbox-img" src="document/hotel_doc/hotel_room_pic/'+imgName+'" id="add_full_img_'+imgName+'" style="width:85px;height:85px;margin:10px;"><img class="remove_img del_add_img" id="add_img_'+imgName+'" src="document/hotel_doc/hotel_room_pic/x.png" relId="'+imgName+'" relNum="'+number+'" alt="delete"/>');
					
					
					if(preImg == '')
					{
						
						str += imgName+',';
					}
					else
					{
						
						str = preImg+imgName+',';
					}
					 $('#add_more_uploaded_'+number).append('<div>'+imgName+'</div>');
					$("#addMoreDoc_"+number).val(str);
					
				}
					
				
					
				
				
				
					});
					
					$('#add_more_file_'+number).val("");
					$("#me1").css({"display": "none"});
					
				
				}  
           }) 
		});
		}
	
	$("#client_prsnl_detail").validate({		
			rules: {
				client_title:"required",				
				f_name:"required",				
				l_name:"required",				
				'userPhone[]':{
					required:true
				},				
				'code[]':{
					required:true
				},				
				'client_prsnl_email[]':{
					required:true,
					email:true
				}				
			},
			messages: {
				client_title:"Please Select Title",				
				f_name:"Please Enter First Name",				
				l_name:"Please Enter Last Name",				
				'userPhone[]':{
					required:"Please Enter Contact Number"
				},				
				'code[]':{
					required:"Please Select Type/Code of Contact Number"
				},				
				'client_prsnl_email[]':{
					required:"Please Enter Email Address",
					email:"Please Enter Valid Email"
				}
			},
			submitHandler: function() { 
				$.ajax({
					type: "POST",
					url: "_ajax_client_prsnl_detail.php",
					data: $("#client_prsnl_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//$("#client_company_detail").click();
						window.location.href='<?php echo $tabUrl.base64_encode(2); ?>';
					}
				}); 
			}
		});
	</script>
	<script>
	
	$("#client_company_details").validate({	
			rules: {
				
			},
			messages: {
				
			},
			submitHandler: function(){ 			
				$.ajax({
					type: "POST",
					url: "_ajax_client_prsnl_detail.php",
					data: $("#client_company_details").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html){
						//$("#client_official_detail").click();
						window.location.href='<?php echo $tabUrl.base64_encode(3); ?>';
					}
				}); 
			}
		});
	</script>
	<script>
	
	$("#client_offical_detail").validate({		
			rules: {
				sale_representative:"required",
				Client_user_pass:"required"				
			},
			messages: {
				sale_representative:"Please Select Sales representative",
				Client_user_pass:"Please Enter Password"	
			},
			submitHandler: function(){ 
				$.ajax({
					type: "POST",
					url: "_ajax_client_prsnl_detail.php",
					data: $("#client_offical_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html){
						//$("#client_banking_detail").click();
						window.location.href='<?php echo $tabUrl.base64_encode(4); ?>';
					}
				}); 
			}
		});
	</script>
	
	<script>
	
	$("#client_banking_details").validate({
			rules: {
				tcountry: "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
				$.ajax({
					type: "POST",
					url: "_ajax_client_prsnl_detail.php",
					data: $("#client_banking_details").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//$("#client_attached_document").click();
						window.location.href='<?php echo $tabUrl.base64_encode(5); ?>';
					}
				}); 
			}
		});

		$('#pan_card_copy').change(function(){ 
	    var formData = new FormData($("#client_doc_detail")[0]);
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
				var already = $("#panCardDoc").val();
				var newFile = already+','+imgName;
				$("#panCardDoc").val(newFile);
				});     
				$("#me1").css({"display": "none"});
				$(".attach_new").css({"display": "block"});
			    $(".attach_newed").css({"display": "block"});
                }  
           })   	
      });
		
	  $('#photo_copy').change(function(){ 
	  var formData = new FormData($("#client_doc_detail")[0]);		  
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
	  var formData = new FormData($("#client_doc_detail")[0]);		  
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
	  var formData = new FormData($("#client_doc_detail")[0]);		  
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
	  var formData = new FormData($("#client_doc_detail")[0]);		  
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


		
		function update_client_upload_documents(doc_name, field){
			alert(doc_name, field);
		}
		
		$(document).ready(function(){
			setTimeout( function(){ 
				$(".select2").removeAttr('style').attr('style','width:100%');
				//alert($(".select2").attr('style'));
			}, 1000 );
		});
		
		
		</script>
	
	   <script src="asset/bootstrap-datepicker.js"></script>
<?php  include('footer.php');?> 