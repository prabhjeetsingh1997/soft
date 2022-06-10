<?php
include('header.php');
include('sidebar.php');
$transporterId = $_SESSION['transporterId'];
$editTransId     ='';
$countClntAddr   ='';
$countClntNum    ='';
$countFleet      ='';
$countConcPrsn   ='';
$countDateRate   ='';
$countConcPrsnNum='';
$countDiv='';
$i='';
$j='';
$pancardDocName = '';
$pancardAttach  = '';
$pancardId      = '';
$photoDocName   = '';
$photoAttach    = '';
$photoDocId     = '';
$contDocName    = '';
$contAttach     = ''; 
$contDocId      = ''; 
$otherDocName   = '';
$otherDocAttach = '';
$otherDocId     = '';
$firstLidId='';
$secondLidId='';
$thirdLidId='';
$fourthLidId='';
$fifthLidId='';
$sixthLidId='';
$seventhLidId='';
$eigthLidId='';
$firstLidName='';
$secondLidName='';
$thirdLidName='';
$fourthLidName='';
$fifthLidName='';
$sixthLidName='';
$seventhLidName='';
$eigthLidName='';

if($_GET['action'] == 'edit')
{
	$editTransId=$_GET['id'];
	$transpData = $objtransporter->getTransporterById($editTransId);
	//print_r($transpData);
	$arrEmail=explode(',',$transpData['additional_email_address']);
	$countEmail=count($arrEmail);
  	$transp_clnt_address_details = $objtransporter->getTransporterClientAddressById($editTransId,'trans_clnt_prmnt_add');
	//$trans_clnt_contact_numbers = $objtransporter->getTransClntNumByid($editTransId,'trans_clnt_num');
	
	$trans_clnt_contact_numbers=$objAdmin->getPhoneNumbers($editTransId, 'transporter', 'trans_clnt_num');
	
	$fleet_vehicle_details=$objtransporter->getFleetVehicleByid($editTransId);
	$concern_prsn_detail=$objtransporter->getConcPrsnByid($editTransId,'Transporter');
	//$concern_prsn_contact_numbers = $objtransporter->getTransClntNumByid($editTransId,'trans_query_num');
	$concern_prsn_contact_numbers=$objAdmin->getPhoneNumbers($editTransId, 'transporter', 'trans_query_num');
	
	$date_rates_detail=$objtransporter->getDateRatesByid($editTransId);
	$attachdoc = $objtransporter->getdocumentbyid($editTransId,'Transporter');
	$ttlDoc=count($attachdoc);
	$countClntAddr=count($transp_clnt_address_details);
	$countClntNum=count($trans_clnt_contact_numbers);
	$countFleet=count($fleet_vehicle_details);
	$countConcPrsn=count($concern_prsn_detail);
	$countConcPrsnNum=count($concern_prsn_contact_numbers);
	$countDateRate=count($date_rates_detail);
	$pancardDocName=$attachdoc[0]['name'];
	$pancardAttach=$attachdoc[0]['doc'];
	$pancardId =$attachdoc[0]['id'];
	$photoDocName=$attachdoc[1]['name'];
	$photoAttach=$attachdoc[1]['doc'];
	$photoDocId=$attachdoc[1]['id'];
	$contDocName=$attachdoc[2]['name'];
	$contAttach=$attachdoc[2]['doc'];
	$contDocId=$attachdoc[2]['id'];
	$otherDocName=$attachdoc[3]['name'];
	$otherDocAttach=$attachdoc[3]['doc'];
	$otherDocId=$attachdoc[3]['id'];
	$editallFleet=$objtransporter->getAllFleet();
	$countAllFleetName=count($editallFleet);
}
$allFleet=$objtransporter->getAllFleet();
$countFleetName=count($allFleet);

$firstLidId=$allFleet[0]['id'];
$firstLidName=$allFleet[0]['fleet_name'];
$secondLidId=$allFleet[1]['id'];
$secondLidName=$allFleet[1]['fleet_name'];
$thirdLidId=$allFleet[2]['id'];
$thirdLidName=$allFleet[2]['fleet_name'];
$fourthLidId=$allFleet[3]['id'];
$fourthLidName=$allFleet[3]['fleet_name'];
$fifthLidId=$allFleet[4]['id'];
$fifthLidName=$allFleet[4]['fleet_name'];
$sixthLidId=$allFleet[5]['id'];
$sixthLidName=$allFleet[5]['fleet_name'];
$seventhLidId=$allFleet[6]['id'];
$seventhLidName=$allFleet[6]['fleet_name'];
$eigthLidId=$allFleet[7]['id'];
$eigthLidName=$allFleet[7]['fleet_name'];

$tab = 1;
if(isset($_GET['t']))
{
	$tab = base64_decode($_GET['t']);
}
$tabUrl = 'transporter.php?t=';
if(isset($_GET['action']))
{
	$tabUrl = 'transporter.php?action=edit&id='.$_GET['id'].'&t=';
}
$arrFleetTrans=$objtransporter->getFleetVehicleByid($_SESSION['transporterId']);
//print_r($arrFleetTrans);
$countFleets=count($arrFleetTrans);
$arrcountery=$objAdmin->get_countery();
?>
<link href="uploadify/uploadify.css" rel="stylesheet">
<link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet">
<style>
.v_hidden{visibility:hidden !important}
.remove_img {
    width: 15px;
    border: none;
    height: 15px;
    margin-left: -8px;
    margin-bottom: 72px;
    cursor: pointer;
}
</style>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Transporter Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Add Transporter</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">			
				<div class="box-header with-border">
				<ul class="nav nav-tabs">
				  <li <?php if($tab == 1){ echo 'class="active"';}?>><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>TRANSPORTER DETAILS</b></h3></a></li>
				  <li <?php if($tab == 2){ echo 'class="active"';}?>><a data-toggle="tab" href="#menu1"><h3 class="box-title"><b>MORE DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 3){ echo 'class="active"';}?>><a data-toggle="tab" href="#menu2"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 4){ echo 'class="active"';}?>><a data-toggle="tab" href="#menu3"><h3 class="box-title"><b>ATTACHED DOCUMENTS</b></h3> </a></li>
				   <li <?php if($tab == 5){ echo 'class="active"';}?>><a data-toggle="tab" href="#menu4"><h3 class="box-title"><b>RATES</b></h3> </a></li>
				 
				</ul>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
				<div id="home" class="tab-pane fade <?php if($tab == 1){ echo 'in active';}?>">
				<form role="form" method="POST" name="transporter_client_detail" id="transporter_client_detail">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="<?php if($countFleet){echo $countFleet;}else{echo 1; } ?>"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				 <input type="hidden" id="editTransporterId" name="editTransporterId" value="<?php echo @$transpData['id'];?>"> 
				<input type="hidden" name="type" value="add_transport_client_detail" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Company Name</b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="name">Hotal Name</label>-->
									<input type="text" class="form-control" name="transporter_hotel_name" id="transporter_hotel_name" placeholder="Company Name" value="<?php echo @$transpData['hotal_name'];?>"/>
								</div>
							</div><!-- /.form-group -->
							
							<!-- /.first line -->
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Address </b></h4>
								</div>
							</div>
							<div class="items">
							<?php
								if($countClntAddr>0)
								{
									$countDiv=1;
									foreach($transp_clnt_address_details as $key=>$val)
									{
										//print_r($val);
							?>
							<div id="address_<?php echo $countDiv;?>">
							<?php
								if($countDiv > 1)
								{
							?>
									<div class="col-md-2"><div class="form-group"></div></div>
							<?php	
								}	
							?>
							<input type="hidden" name="transClntAddrId[]" id="transClntAddrId" value="<?php echo $val['id'];?>"/>
							<div class="col-md-5">
								<div class="form-group">
									<!--<label for="userPhone">Address Line 1</label>-->
									<input type="text" class="form-control" name="transporter_address1[]" id="transporter_address1" placeholder="Address line 1" value="<?php echo $val['address1'];?>"/>
								</div>
							</div>
							
								<div class="col-md-5">
								<div class="form-group">
									<!--<label for="userPhone">Address Line 2</label>-->
									<input type="text" class="form-control" name="transporter_address2[]" id="transporter_address2" placeholder="Address line 2" value="<?php echo $val['address2'];?>"/>
								</div>
							</div>
							<div class="col-md-2"><div class="form-group"></div></div>
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="middle">City</label>-->
									<!--<input type="text" class="form-control" name="trans_country[]" id="trans_country" placeholder="Country" value="<?php echo $val['country']; ?>"/>-->
									<select class="form-control select2" name="trans_country[]" id="trans_country" data-placeholder="Select a Country">
										<option value="">--Select Country--</option>
										<?php
											foreach($arrcountery as $count)
											{ 
										?>	
											<option value="<?php echo $count['id']; ?>" <?php if($count['id'] == '119'){echo "selected";}?>><?php echo $count['country_name']; ?></option>
										<?php		
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="last">State</label>-->
									<!--<input type="text" class="form-control" name="trans_state[]" id="trans_state" placeholder="State" value="<?php echo $val['state'];?>"/>-->
									<select class="form-control select2" name="trans_state[]" id="trans_state" data-placeholder="Select a State">
										<option value="">--Select State--</option>
										<?php
											
										$arrState=$objAdmin->get_state(119);
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
									<!--<input type="text" class="form-control" name="transp_city[]" id="transp_city" placeholder="City" value="<?php echo $val['city'];?>"/>-->
									<select class="form-control select2" name="transp_city[]" id="transp_city" data-placeholder="Select a City">
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
							
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Pin Code</label>-->
									<input type="text" class="form-control" name="trans_pincode[]" id="trans_pincode" placeholder="Code" value="<?php echo $val['pin_code'];?>"/>
								</div>
							</div>
							</div>
							<?php
								if($countDiv == 1)
								{
							?>
							<!--<div class="col-md-1">
								<div class="form-group">
									
									<a href="javascript:void(0);" class="add_more_items" id="add_more_items" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>-->
							<?php
								}
								$countDiv++;
									}
								}
								else
								{
							?>
							<div id="address_1">
							<input type="hidden" name="transClntAddrId[]" id="transClntAddrId" value=""/>
							<div class="col-md-5">
								<div class="form-group">
									<!--<label for="userPhone">Address Line 1</label>-->
									<input type="text" class="form-control" name="transporter_address1[]" id="transporter_address1" placeholder="Address line 1" value=""/>
								</div>
							</div>
							
								<div class="col-md-5">
								<div class="form-group">
									<!--<label for="userPhone">Address Line 2</label>-->
									<input type="text" class="form-control" name="transporter_address2[]" id="transporter_address2" placeholder="Address line 2" value=""/>
								</div>
							</div>
							<div class="col-md-2"><div class="form-group"></div></div>
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="middle">City</label>-->
									<!--<input type="text" class="form-control" name="trans_country[]" id="trans_country" placeholder="Country" value="<?php echo $val['country']; ?>"/>-->
									<select class="form-control select2" name="trans_country[]" id="trans_country" data-placeholder="Select a Country">
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
									<!--<input type="text" class="form-control" name="trans_state[]" id="trans_state" placeholder="State" value=""/>-->
									<select class="form-control select2" name="trans_state[]" id="trans_state" data-placeholder="Select a State">
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
									<!--<input type="text" class="form-control" name="transp_city[]" id="transp_city" placeholder="City" value=""/>-->
									<select class="form-control select2" name="transp_city[]" id="transp_city" data-placeholder="Select a City">
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
							
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Pin Code</label>-->
									<input type="text" class="form-control" name="trans_pincode[]" id="trans_pincode" placeholder="Code" value=""/>
								</div>
							</div>
							</div>
							
							
							<!--<div class="col-md-1">
								<div class="form-group">
								
									<a href="javascript:void(0);" class="add_more_items" id="add_more_items" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>-->
							<?php
								}
							?>
						</div>
							
							<!-- /.second line -->
							
						
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Contact Nos </b></h4>
								</div>
							</div>
							<div class="items3">
							<?php
								if($countClntNum>0)
								{
									$countDiv=1;
									foreach($trans_clnt_contact_numbers as $key=>$val)
									{
							?>
							<div id="Mobnumbbr_<?php echo $countDiv;?>">
							<?php
								if($countDiv > 1)
								{
							?>
									<div class="col-md-2"><div class="form-group"></div></div>
							<?php	
								}	
							?>
							<input type="hidden" name="transClientNumId[]" id="transClientNumId" value="<?php echo $val['id'];?>"/>
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
							<div class="col-md-3 v_hidden">
								<div class="form-group">
									<!--<label for="last">Enter valid Number</label>-->
									<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
								</div>
							</div>
							</div>
							<?php
								if($countDiv == 1)
								{
							?>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<?php
									}
							$countDiv++;
									}
								}
								else
								{
							?>
							<div id="Mobnumbbr_1">
							<input type="hidden" name="transClientNumId[]" id="transClientNumId" value=""/>
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
							<div class="col-md-3 v_hidden">
								<div class="form-group">
									<!--<label for="last">Enter valid Number</label>-->
									<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
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
							
							<!-- /.second line -->
							
							<div class="items1">
							<?php
								if($countFleet>0)
								{
									$i=0;
									$countDiv=0;
									foreach($fleet_vehicle_details as $key=>$val)
									{
										$i++;
										$countDiv++;
										$fleetId=$val['id'];
										$transid=$transpData['id'];
										$fleetImages=$objtransporter->getImagesById($fleetId,$transid);
							?>
							<div id="address2_<?php echo $countDiv;?>">
							<?php
								if($countDiv == 1)
								{
							?>
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	Fleet </b></h4>
									</div>
								</div>
							<?php
								}
								if($countDiv > 1)
								{
							?>
									<div class="col-md-2"><div class="form-group"></div></div>
							<?php	
								}	
							?>
							<input type="hidden" name="fleetVehicId[]" id="fleetVehicId" value="<?php echo $val['id'];?>"/>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="vehitype">Vehicle Type</label>-->
									<input type="text" class="form-control" name="vehitype[]" id="roomstype[]" placeholder="Vehicle Type" value="<?php echo $val['vehicle_type'];?>"/>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="VDescription">Vehicle Description</label>-->
									<input type="text" class="form-control" name="VDescription[]" id="VDescription" placeholder="Vehicle Description" value="<?php echo $val['vehicle_desc'];?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="AminitiesF">Aminities & Facilities</label>-->
									<input type="text" class="form-control" name="AminitiesF[]" id="AminitiesF" placeholder="Amenities & Facilities" value="<?php echo $val['aminities_facilites'];?>"/>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="Units">Units</label>-->
									<input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value="<?php echo $val['units'];?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="Pics">Pics</label>-->
									<input type="file" class="form-control fleetPics" name="Pics[]" id="Pics_<?php echo $countDiv;?>" rel="1" placeholder="Pics" value=""/>
									
								</div>
							</div>
							</div>
							<?php
								if($countDiv > 1)
								{
							?>
								<div style="clear:both;"></div>
							<?php	
								}	
							?>
							<?php
								if($countDiv == 1)
								{
							?>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<div style="clear:both;"></div>
							<?php
								}
								?>
							<div class="col-sm-10 col-md-offset-2">
									<div class="pull-left">
										<div id="fleet_images_<?php echo $i;?>" class="pull-left">
								<?php
									$editImgSrt = '';
									$editImgId  = '';
									foreach($fleetImages as $k=>$value)
									{
										$editImgSrt .= $value['image'].',';
										$editImgId .= $value['id'].',';
								?>
										<img src="document/transporter_doc/trans_fleet_pic/<?php echo $value['image']; ?>" id="delete_full_img_<?php echo $value['id']; ?>" data-img="document/transporter_doc/trans_fleet_pic/<?php ?>" alt="" class="superbox-img images" style="width:85px;height:85px;margin:10px;">
										<img class="remove_img" id="delete_img_<?php echo $value['id'];?>" src="document/transporter_doc/trans_fleet_pic/x.png" relId="<?php echo $value['id'];?>" alt="delete" relImgId="<?php echo $value['image'];?>" relImgNum="<?php echo $countDiv;?>"/>
										
								<?php
									
									}
									?>
									</div>
									<input type="hidden" name="fleetImg[]" id="fleetImg_<?php echo $countDiv;?>" value="<?php echo $editImgSrt;?>"/>
									<input type="hidden" name="fleetPicId[]" id="fleetPicId_<?php echo $countDiv;?>" value="<?php echo $editImgId;?>"/>
									</div>
								</div>
								<?php
								}
								}
								else
								{
							?>
							<div style="clear:both;"></div>	
							<div id="address2_1">
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Fleet </b></h4>
								</div>
							</div>
							<input type="hidden" name="fleetVehicId[]" id="fleetVehicId" value=""/>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="vehitype">Vehicle Type</label>-->
									<input type="text" class="form-control" name="vehitype[]" id="roomstype[]" placeholder="Vehicle Type" value=""/>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="VDescription">Vehicle Description</label>-->
									<input type="text" class="form-control" name="VDescription[]" id="VDescription" placeholder="Vehicle Description" value=""/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="AminitiesF">Aminities & Facilities</label>-->
									<input type="text" class="form-control" name="AminitiesF[]" id="AminitiesF" placeholder="Amenities & Facilities" value=""/>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="Units">Units</label>-->
									<input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value=""/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="Pics">Pics</label>-->
									<input type="file" class="form-control fleetPics" name="Pics[]" id="Pics_1" rel="1" placeholder="Pics" value=""/>
									<input type="hidden" name="fleetImg[]" id="fleetImg_1" value=""/>
								</div>
							</div>
							</div>
							
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<div class="col-sm-10 col-md-offset-2">
								<div class="pull-left">
									<div id="fleet_images_1" class="pull-left">
										
									</div>
								</div>
							</div>
							<?php
								}
							?>
						</div>
							
						
							<!-- /.third line -->
							
							
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Base Currency</b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="userPhone">Base Currency</label>-->
									<select class="form-control" name="transporter_base_currency" id="transporter_base_currency">
									<option>Select</option>
									<option value="USD" <?php if(@$transpData['base_currency'] == 'USD'){echo "selected";}?>>USD </option>
									<option value="INR" <?php if(@$transpData['base_currency'] == 'INR'){echo "selected";}?>>INR </option>
									<option value="EUR" <?php if(@$transpData['base_currency'] == 'EUR'){echo "selected";}?>>EUR </option>
									<option value="JPY" <?php if(@$transpData['base_currency'] == 'JPY'){echo "selected";}?>>JPY </option>
									<option value="GBP" <?php if(@$transpData['base_currency'] == 'GBP'){echo "selected";}?>>GBP</option>
									<option value="AUD" <?php if(@$transpData['base_currency'] == 'AUD'){echo "selected";}?>>AUD</option>
									<option value="CHF" <?php if(@$transpData['base_currency'] == 'CHF'){echo "selected";}?>>CHF</option>
									<option value="CAD" <?php if(@$transpData['base_currency'] == 'CAD'){echo "selected";}?>>CAD</option>
									<option value="MXN" <?php if(@$transpData['base_currency'] == 'MXN'){echo "selected";}?>>MXN</option>
									<option value="CNY" <?php if(@$transpData['base_currency'] == 'CNY'){echo "selected";}?>>CNY</option>
									<option value="NZD" <?php if(@$transpData['base_currency'] == 'NZD'){echo "selected";}?>>NZD</option>
									<option value="SEK" <?php if(@$transpData['base_currency'] == 'SEK'){echo "selected";}?>>SEK</option>
									<option value="RUB" <?php if(@$transpData['base_currency'] == 'RUB'){echo "selected";}?>>RUB</option>
									<option value="HKD" <?php if(@$transpData['base_currency'] == 'HKD'){echo "selected";}?>>HKD</option>
									
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Description</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
									
									<textarea type='text' class="form-control" name="transporter_description" id="transporter_description"><?php echo @$transpData['description'];?></textarea>
									
								</div>
								</div>
							</div>
						
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
					</div>
				</form>
			
			</div>
				<div id="menu1" class="tab-pane fade <?php if($tab == 2){ echo 'in active';}?>">
				<form role="form" method="POST" name="transport_query_detail" id="transport_query_detail">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				 <input type="hidden" id="editTransporterId" name="editTransporterId" value="<?php echo @$transpData['id'];?>"> 
					<input type="hidden" name="transporterID" value="<?php echo $transporterId; ?>" />
					<input type="hidden" name="type" value="add_transport_query_detail" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	 Transporter ID </b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="name"> Transporter ID</label>-->
									<input type="text" class="form-control" name="transporter_id" id="transporter_id" placeholder="Transporter ID" value="<?php if(isset($transpData['transporter_id'])){echo $transpData['transporter_id'];}else{echo $_SESSION['transporterId'];}?>" readonly />
								</div>
							</div><!-- /.form-group -->
							
							<!-- /.first line -->
						<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;"> Concerned Person </b></h4>
								</div>
							</div>
							<div class="ite">
							<?php
								if($countConcPrsn>0)
								{
									$countDiv=1;
									foreach($concern_prsn_detail as $key=>$val)
									{
							?>
							<div id="person_<?php echo $countDiv;?>">
							<?php
								if($countDiv > 1)
								{
							?>
									<div class="col-md-2"><div class="form-group"></div></div>
							<?php	
								}	
							?>
							<input type="hidden" name="concernPrsnId[]" id="concernPrsnId" value="<?php echo $val['id'];?>"/>
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="title">Title</label>-->
									<select class="form-control" name="title[]" id="title">
									<option>--</option>
									<option value="Mr." <?php if($val['title'] == 'Mr.'){echo "selected";}?> >Mr.</option>
									<option value="Miss." <?php if($val['title'] == 'Miss.'){echo "selected";}?> >Miss.</option>
									<option value="Mrs." <?php if($val['title'] == 'Mrs.'){echo "selected";}?> >Mrs.</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="firstname">First Name</label>-->
									<input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value="<?php echo $val['first_name'];?>"/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="middle">Middle Name</label>-->
									<input type="text" class="form-control" name="middlename[]" id="middlename" placeholder="Middle Name" value="<?php echo $val['middlename'];?>"/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="last">Last Name</label>-->
									<input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value="<?php echo $val['lastname'];?>"/>
								</div>
							</div>
							</div>
							<?php
								if($countDiv == 1)
								{
							?>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="add_more_item" id="add_more_item" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<?php
								}
								$countDiv++;
									}
								}
								else
								{
							?>
							<div id="person_1">
							<input type="hidden" name="concernPrsnId[]" id="concernPrsnId" value=""/>
							<div class="col-md-3">
								<div class="form-group">
									<!--<label for="title">Title</label>-->
									<select class="form-control" name="title[]" id="title">
									<option>--</option>
									<option value="Mr.">Mr.</option>
									<option value="Miss.">Miss.</option>
									<option value="Mrs.">Mrs.</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="firstname">First Name</label>-->
									<input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value=""/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="middle">Middle Name</label>-->
									<input type="text" class="form-control" name="middlename[]" id="middlename" placeholder="Middle Name" value=""/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<!--<label for="last">Last Name</label>-->
									<input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value=""/>
								</div>
							</div>
							</div>
							
							
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="add_more_item" id="add_more_item" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<?php
								}
							?>
						</div>
						<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	Contact Nos </b></h4>
								</div>
							</div>
							<div class="cont">
							<?php
								if($countConcPrsnNum>0)
								{
									$countDiv=1;
									foreach($concern_prsn_contact_numbers as $key=>$val)
									{
							?>
							<div id="connumbbr_<?php echo $countDiv;?>">
							<?php
								if($countDiv > 1)
								{
							?>
									<div class="col-md-2"><div class="form-group"></div></div>
							<?php	
								}	
							?>
							<input type="hidden" name="concPrsnQryNumId[]" id="concPrsnQryNumId" value="<?php echo $val['id'];?>"/>
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
										<option value="Mobile" <?php if($val['code'] == 'Mobile'){echo "selected";}?> >Mobile</option>
										<option value="Home" <?php if($val['code'] == 'Home'){echo "selected";}?> >Home</option>
										<option value="Work" <?php if($val['code'] == 'Work'){echo "selected";}?> >Work</option>
										<option value="Main" <?php if($val['code'] == 'Main'){echo "selected";}?> >Main</option>
										<option value="WorkFax" <?php if($val['code'] == 'WorkFax'){echo "selected";}?> >Work Fax</option>
										<option value="HomeFax" <?php if($val['code'] == 'HomeFax'){echo "selected";}?> >Home Fax</option>
										<option value="Pager" <?php if($val['code'] == 'Pager'){echo "selected";}?> >Pager</option>
										<option value="Other" <?php if($val['code'] == 'Other'){echo "selected";}?> >Other</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-3 v_hidden">
								<div class="form-group">
									<!--<label for="last">Enter valid Number</label>-->
									<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
								</div>
							</div>
							</div>
							<?php
								if($countDiv == 1)
								{
							?>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<?php
								}
							$countDiv++;
									}
								}
								else
								{
							?>
							<div id="connumbbr_1">
							<input type="hidden" name="concPrsnQryNumId[]" id="concPrsnQryNumId" value=""/>
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
									<input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/>
								</div>
							</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<?php
								}
							?>
							</div>
						<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Email </b></h4>
								</div>
							</div>
							<div class="items4">
							<?php
								if($countEmail>0)
								{
									$countDiv=1;
									for($i=0;$i<$countEmail;$i++)
									{
							?>
							<div id="Email_<?php echo $countDiv;?>" >
							<?php
								if($countDiv > 1)
								{
							?>
								<div class="col-md-2"><div class="form-group"></div></div>
							<?php	
								}
							?>
							<div class="col-md-9">
								<div class="form-group">
									<!--<label for="userEmail" >Email</label>-->
									<input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="<?php echo $arrEmail[$i];?>" />
								</div>
							</div>
							</div>
							<?php
								if($countDiv==1)
								{
							?>
							<div class="col-md-1">
								<div class="form-group">
									<!--<label for="last">Add More</label>-->
									<a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							</div>
							<?php
								}
								$countDiv++;
									}
								}
								else
								{
							?>
							<div id="Email_1" >
							<div class="col-md-9">
								<div class="form-group">
									<!--<label for="userEmail" >Email</label>-->
									<input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="<?php echo $usrData['email']; ?>" />
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
						
							<!--<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">User ID</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="userPhone">User ID</label>
									<input type="text" class="form-control" name="transporter_userId" id="transporter_userId" placeholder="User ID" value="<?php echo @$transpData['transporter_user_id'];?>"/>
								</div>
							</div>-->
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Password</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="userPhone">Password</label>-->
									<input type="text" class="form-control" name="transporter_pass" id="transporter_pass" placeholder="Password" value="<?php echo @$transpData['transporter_password'];?>"/>
								</div>
							</div>	
							
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
					</div>
				</form>
			
			
			</div>
			<div id="menu2" class="tab-pane fade <?php if($tab == 3){ echo 'in active';}?>">
			<form role="form" method="POST" name="transport_bank_detail" id="transport_bank_detail">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				 <input type="hidden" id="editTransporterId" name="editTransporterId" value="<?php echo @$transpData['id'];?>"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="transporterID" value="<?php echo $transporterId; ?>" />
					<input type="hidden" name="type" value="add_transporter_bank_detail" />
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
									<input type="text" class="form-control " name="transporter_pan_no" id="transporter_pan_no" placeholder="PAN No." value="<?php echo @$transpData['pan_no'];?>"/>
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
									<input type="text" class="form-control " name="transporter_account_no" id="transporter_account_no" placeholder="Account No." value="<?php echo @$transpData['account_no'];?>"/>
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
									<input type="text" class="form-control " name="transporter_account_name" id="transporter_account_name" placeholder="Account Name" value="<?php echo @$transpData['account_name'];?>"/>
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
									<input type="text" class="form-control " name="transporter_bank" id="transporter_bank" placeholder="Bank" value="<?php echo @$transpData['bank_name'];?>"/>
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
									<input type="text" class="form-control " name="transporter_branch" id="transporter_branch" placeholder="Branch" value="<?php echo @$transpData['branch_name'];?>"/>
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
									<input type="text" class="form-control " name="transporter_ifsc" id="transporter_ifsc" placeholder="IFSC" value="<?php echo @$transpData['ifsc'];?>"/>
								</div>
							</div>
						</div>
						</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
					</div>
				</form>
			</div>
			<div id="menu3" class="tab-pane fade <?php if($tab == 4){ echo 'in active';}?>">
			<form role="form" method="POST" id="transporter_doc_detail" name="transporter_doc_detail"  enctype = "multipart/form-data">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="totalFld" id="totalFld" value="<?php if(isset($ttlDoc)&&!empty($ttlDoc)){echo $ttlDoc;}else{echo 4;}?>"/>
					<input type="hidden" name="type" value="add_transporter_doc_detail" />
					<input type="hidden" name="transporter_id" value="<?php echo $hotelId; ?>" />
					<input type="hidden" id="editTransporterId" name="editTransporterId" value="<?php echo $transpData['id'];?>"> 
					
						<div class="box-body">
							<div class="row">
								<div class="myattch">
									<div id="attch_1">
										<input type="hidden" name="attachEdId[]" id="panCardId" value="<?php echo $pancardId;?>"/>
										<div class="col-md-2">
											<div class="form-group">
												<h4  class="box-title"><b style="font-size: 17px;">	PAN Card </b></h4>
												<input type="hidden" name="docFileName[]" id="panCardFileName" value="PAN Card"/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="query_no">PAN Card</label>-->
												<input type="file" class="form-control" name="file_upload[]" id="transporter_pan_card_copy"  value=""/>
												<input type="hidden" name="upldFileName[]" id="panCardDoc" value="<?php echo $pancardAttach; ?>"/>
												<p class="help-block text-danger"></p>
											</div>
										</div><!-- /.form-group -->
										<div class="col-md-4">
											<div id="panCardDocName" style="height:60px;"><?php echo $pancardAttach;?></div>
										</div>
									</div>
									<div style="clear:both;"></div>
									<div id="attch_2">
										<input type="hidden" name="attachEdId[]" id="photoId" value="<?php echo $photoDocId; ?>"/>
										<div class="col-md-2">
											<div class="form-group">
												<h4  class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
												<input type="hidden" name="docFileName[]" id="photoFileName" value="Photo"/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="query_no">Photo</label>-->
												<input type="file" class="form-control" name="file_upload[]" id="transporter_photo_copy"  value=""/>
												<input type="hidden" name="upldFileName[]" id="photoDoc" value="<?php echo $photoAttach; ?>"/>
											</div>
										</div><!-- /.form-group -->
										<div class="col-md-4">
											<div id="photoDocName"><?php echo $photoAttach; ?></div>
										</div>
									</div>
									<div style="clear:both;"></div>
									<div id="attch_3">
										<input type="hidden" name="attachEdId[]" id="contCopyId" value="<?php echo $contDocId; ?>"/>
										<div class="col-md-2">
											<div class="form-group">
												<h4  class="box-title"><b style="font-size: 17px;">Contract</b></h4>
												<input type="hidden" name="docFileName[]" id="contractFileName" value="Contract"/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<!--<label for="query_no">Contract</label>-->
												<input type="file" class="form-control" name="file_upload[]" id="transporter_Contract_copy"  value=""/>
												<input type="hidden" name="upldFileName[]" id="contCopyDoc" value="<?php echo $contAttach; ?>"/>
											</div>
										</div><!-- /.form-group -->
										<div class="col-md-4">
											<div id="contCopyDocName"><?php echo $contAttach; ?></div>
										</div>
									</div>
									<div style="clear:both;"></div>
									<?php
										if($ttlDoc>4){
											$countAttach=4;
											for($i=3;$i<$ttlDoc;$i++){
									?>
									<div id="attch_<?php echo $countAttach;?>">
										<input type="hidden" name="attachEdId[]" id="addMoreId" value="<?php echo $attachdoc[$i]['id'];?>"/>
										<div class="col-md-2">
											<div class="form-group">
												<input type="text" class="form-control" name="docFileName[]" id="addmorefilename_<?php echo $countAttach;?>" placeholder="File Name" value="<?php echo $attachdoc[$i]['name'];?>"/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input class="file_upload" id="add_more_file_<?php echo $countAttach;?>" name="file_upload[]" type="file">
												<input type="hidden" name="upldFileName[]" id="addMoreDoc_<?php echo $countAttach;?>" value="<?php echo $attachdoc[$i]['doc'];?>" />
												<p class="help-block text-danger"></p>
											</div>
										</div>
										<div class="col-md-4">
											<div id="add_more_uploaded_<?php echo $countAttach;?>" style="height:60px;"><?php echo $attachdoc[$i]['doc'];?></div>
										</div>
										<?php
										if($countAttach == 4){
										?>
										<div class="col-md-2">
											<div class="form-group">
												<!--<label for="last">Add More</label>-->
												<a href="javascript:void(0);" class="addMoreDocument" id="addMoreDocument" title="Add field" ><img src="add-icon.png" style="width:28px;"/></a>
											</div>
										</div>
										<?php
										}else{
										?>
										<div class="col-md-2">
											<div class="form-group">
												<a class="delete" relId="<?php echo @$attachdoc[$i]['id'];?>" rel="<?php echo $countAttach;?>" href="javascript:void(0)" onclick="remove_attach('<?php echo $countAttach;?>','<?php echo @$attachdoc[$i]['id'];?>')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
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
									<div id="attch_4">
										<input type="hidden" name="attachEdId[]" id="addMoreId" value="<?php echo $otherDocId; ?>"/>
										<div class="col-md-2">
											<div class="form-group">
												<input type="text" class="form-control" name="docFileName[]" id="addmorefilename_4" placeholder="File Name" value="<?php echo $otherDocName;?>"/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input class="file_upload" id="add_more_file_4" name="file_upload[]" type="file">
												<input type="hidden" name="upldFileName[]" id="addMoreDoc_4" value="<?php echo $otherDocAttach;?>" />
												<p class="help-block text-danger"></p>
											</div>
										</div>
										<div class="col-md-4">
											<div id="add_more_uploaded_4" style="height:60px;"><?php echo $otherDocAttach;?></div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<!--<label for="last">Add More</label>-->
												<a href="javascript:void(0);" class="addMoreDocument" id="addMoreDocument" title="Add field" ><img src="add-icon.png" style="width:28px;"/></a>
											</div>
										</div>
									</div>
									<div style="clear:both;"></div>
									<?php
										}
									?>
									
								</div>
							</div>
						</div>
						<div class="box-footer">
							<button type="button" class="btn btn-primary" name="transporter_doc_detail_btn" id="transporter_doc_detail_btn">Next</button>
						</div>
					</form>		
				</div>
			<div id="menu4" class="tab-pane fade <?php if($tab == 5){ echo 'in active';}?>">
					
				<form role="form" method="POST" name="transporter_rate" id="transporter_rate">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				 <input type="hidden" id="fleet_count" name="fleet_count" value="<?php if($_GET['action'] == 'edit'){echo $countAllFleetName;}else{echo $countFleetName;}?>"> 
				 <input type="hidden" id="editTransporterId" name="editTransporterId" value="<?php echo @$transpData['id'];?>"> 
				 <input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countFleet;}else{echo $countFleets;}?>">
				<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
				<input type="hidden" name="type" value="add_transporter_rates_detail" />
				<input type="hidden" name="transporter_id" value="<?php echo $hotelId; ?>" />
				
					<div class="box-body">					
						<div class="row">	
							<div class="rate">
							<?php
								if($countDateRate>0)
								{
									$countDiv=1;
									
									for($i=1;$i<=$countDateRate;$i++)
									{
										$dateId=$date_rates_detail[$i-1]['id'];
										
							?>
							<div id="rates_<?php echo $countDiv;?>">
								<input type="hidden" name="dateRateId[]" id="dateRateId" value="<?php echo $date_rates_detail[$i-1]['id'];?>"/>
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="search">From:Calender</label>
											<input type="text" class="form-control fromdate"  name="fromdate_<?php echo $i;?>" id="fromdate" placeholder="Name" value="<?php echo date('j M Y',strtotime(@$date_rates_detail[$i-1]['from_date']));?>"/>
										</div>						
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="search">To:Calender</label>
											<input type="text" class="form-control todate" name="todate_<?php echo $i;?>" id="todate" placeholder="Name" value="<?php echo date('j M Y',strtotime(@$date_rates_detail[$i-1]['to_date']));?>"/>
										</div>						
									</div>
									<div class="col-md-1" >
										
									</div>
							
									<div class="bs-example col-md-12" >
										<table class="table"  >
											<thead>											
												<tr>
													<?php
													if($countFleet>0)
													{
													?>
													<th></th>
													<?php
														foreach($fleet_vehicle_details as $key=>$val)
														{
													?>
													<th style="width: 40px;"><?php echo $val['vehicle_type'];?></th>
													<?php
														}
													
													?>
												</tr>
											</thead>
											<tbody border="1px"> 
												<?php
													for($k=1;$k<=$countAllFleetName;$k++)
													{
														$edCountFleet=1;
														
												?>
												<tr style="height:20px;">
													
													
													<td><?php echo $editallFleet[$k-1]['fleet_name'];?><input type="hidden" name="fleetNameId_1_<?php echo $k;?>_<?php echo $edCountFleet;?>" value="<?php echo $editallFleet[$k-1]['id'];?>"></td>
													<?php
														
														foreach($fleet_vehicle_details as $key=>$val)
														{
															$edCountFleet++;
															$fleetvehiId=$val['id'];
															$transporter_rates_detail=$objtransporter->getTransporterRatesByid(@$transpData['id'],$dateId,$fleetvehiId);
															$countTransporterRates=count($transporter_rates_detail);
															//$hotel_room_id=$val['id'];
															//$hotel_rates_detail=$objhotel->getHotelRatesByid($hotelData['hotel_id'],$dateId,$hotel_room_id);
															//$countHotelRates=count($hotel_rates_detail);
															
													?>
													<td>
														<input type="text" name="fleetPrice_1_<?php echo $k;?>_<?php echo $edCountFleet;?>" value="<?php echo $transporter_rates_detail[$k-1]['price'];?>">
														<input type="hidden" name="fleetTypeId_1_<?php echo $k;?>_<?php echo $edCountFleet;?>" value="<?php echo $val['id'];?>">
														<input type="hidden" name="fleetRateId_1_<?php echo $k;?>_<?php echo $edCountFleet;?>" value="<?php echo $transporter_rates_detail[$k-1]['id'];?>"/>
														
													</td>
													
														<?php
														}
													?>
													<?php
														if($k == 1)
														{
														?>
														<td rowspan="8"> <textarea name="description_1" rows="17" cols="21"> <?php echo $date_rates_detail[$i-1]['description'];?> </textarea>  </td>
														<?php
														}
													?>
												</tr>
												<?php
													}
													}
												?>		  
											</tbody>
										</table>
									</div>				
								</div>
								<?php
									if($countDiv==1)
									{
								?>
								<div class="form-group">
									<label for="last">Add More table</label>
									<a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
							<?php
									}
								$k++;
								$countDiv++;
									}
								}
								else
								{
							?>
								<div id="rates_1">
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
										</div>
									</div>
									<input type="hidden" name="dateRateId[]" id="dateRateId" value=""/>
									<input type="hidden" name="transpRateId[]" id="transpRateId" value=""/>
									<div class="col-md-4">
										<div class="form-group">
											<label for="search">From:Calender</label>
											<input type="text" class="form-control fromdate"  name="fromdate_1" id="fromdate" placeholder="Name" value="Date"/>
										</div>						
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="search">To:Calender</label>
											<input type="text" class="form-control todate" name="todate_1" id="todate" placeholder="Name" value="Date"/>
										</div>						
									</div>
									<div class="col-md-1" >
										
									</div>
							
									<div class="bs-example col-md-12" >
										<table class="table"  >
											<thead>											
												<tr>
													<?php
													if($countFleets>0)
													{
													?>
												<th></th>
												<?php
														foreach($arrFleetTrans as $key=>$val)
														{
												?>
													
													<th style="width: 40px;"><?php echo $val['vehicle_type'];?></th>
												<?php
														}
												?>
												</tr>
											</thead>
											<tbody border="1px">  

											<tr>
											<?php
												$fleetCount1=1;
											?>
												<td><?php echo $firstLidName;?><input type="hidden" name="fleetNameId_1_1_<?php echo $fleetCount1;?>" value="<?php echo $firstLidId;?>"></td>
											<?php
														
											foreach($arrFleetTrans as $key1=>$val1)
											{
											$fleetCount1++;	
											?>
												<td>
													<input type="text" name="fleetPrice_1_1_<?php echo $fleetCount1;?>" value="">
													<input type="hidden" name="fleetTypeId_1_1_<?php echo $fleetCount1;?>" value="<?php echo $val1['id'];?>">
													<input type="hidden" name="fleetRateId_1_1_<?php echo $fleetCount1;?>" value=""/>
													</td>
												
												</td>	
												
											<?php
												}
											?>
												<td rowspan="8"><textarea name="description_1" rows="17" cols="21"> Description  </textarea> </td>
												
											</tr>
											<tr>
											<?php
												$fleetCount2=1;
											?>
												<td><?php echo $secondLidName;?><input type="hidden" name="fleetNameId_1_2_<?php echo $fleetCount2;?>" value="<?php echo $secondLidId;?>"></td>
											<?php
														
												foreach($arrFleetTrans as $key2=>$val2)
												{
													$fleetCount2++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_2_<?php echo $fleetCount2;?>" value="">
													<input type="hidden" name="fleetTypeId_1_2_<?php echo $fleetCount2;?>" value="<?php echo $val2['id'];?>">
													<input type="hidden" name="fleetRateId_1_2_<?php echo $fleetCount2;?>" value=""/>
													
												</td>		
											<?php
												}
											?>
											</tr>
											<tr>
											<?php
													
													$fleetCount3=1;
											?>
												<td><?php echo $thirdLidName;?><input type="hidden" name="fleetNameId_1_3_<?php echo $fleetCount3;?>" value="<?php echo $thirdLidId;?>"></td>
											<?php
														
												foreach($arrFleetTrans as $key3=>$val3)
												{
													$fleetCount3++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_3_<?php echo $fleetCount3;?>" value="">
													<input type="hidden" name="fleetTypeId_1_3_<?php echo $fleetCount3;?>" value="<?php echo $val3['id'];?>">
													<input type="hidden" name="fleetRateId_1_3_<?php echo $fleetCount3;?>" value=""/>
												</td>		
											<?php
												}
											?>
											</tr>
											<tr>
											<?php
												
												$fleetCount4=1;
											?>
												<td><?php echo $fourthLidName;?><input type="hidden" name="fleetNameId_1_4_<?php echo $fleetCount4;?>" value="<?php echo $fourthLidId;?>"></td>
											<?php
													
												foreach($arrFleetTrans as $key4=>$val4)
												{
													$fleetCount4++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_4_<?php echo $fleetCount4;?>" value="800">
													<input type="hidden" name="fleetTypeId_1_4_<?php echo $fleetCount4;?>" value="<?php echo $val4['id'];?>">
													<input type="hidden" name="fleetRateId_1_4_<?php echo $fleetCount4;?>" value=""/>
												</td>		
											<?php
												}
											?>
											</tr>
											<tr>
											<?php
												
												$fleetCount5=1;
											?>
												<td><?php echo $fifthLidName;?><input type="hidden" name="fleetNameId_1_5_<?php echo $fleetCount5;?>" value="<?php echo $fifthLidId;?>"></td>
											<?php
													
												foreach($arrFleetTrans as $key5=>$val5)
												{
													$fleetCount5++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_5_<?php echo $fleetCount5;?>" value="">
													<input type="hidden" name="fleetTypeId_1_5_<?php echo $fleetCount5;?>" value="<?php echo $val5['id'];?>">
													<input type="hidden" name="fleetRateId_1_5_<?php echo $fleetCount5;?>" value=""/>
												</td>		
											<?php
												}
											?>
											</tr>
											<tr>
											<?php
												
												$fleetCount6=1;
											?>
												<td><?php echo $sixthLidName;?><input type="hidden" name="fleetNameId_1_6_<?php echo $fleetCount6;?>" value="<?php echo $sixthLidId;?>"></td>
											<?php
													
												foreach($arrFleetTrans as $key6=>$val6)
												{
													$fleetCount6++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_6_<?php echo $fleetCount6;?>" value="">
													<input type="hidden" name="fleetTypeId_1_6_<?php echo $fleetCount6;?>" value="<?php echo $val6['id'];?>">
													<input type="hidden" name="fleetRateId_1_6_<?php echo $fleetCount6;?>" value=""/>
													
												</td>		
											<?php
												}
											?>
											</tr>
											<tr>
											<?php
												$fleetCount7=1;
											?>
												<td><?php echo $seventhLidName;?><input type="hidden" name="fleetNameId_1_7_<?php echo $fleetCount7;?>" value="<?php echo $seventhLidId;?>"></td>
											<?php
													
												foreach($arrFleetTrans as $key7=>$val7)
												{
													$fleetCount7++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_7_<?php echo $fleetCount7;?>" value="">
													<input type="hidden" name="fleetTypeId_1_7_<?php echo $fleetCount7;?>" value="<?php echo $val7['id'];?>">
													<input type="hidden" name="fleetRateId_1_7_<?php echo $fleetCount7;?>" value=""/>
												</td>
												
											<?php
												}
											?>
											</tr>
											<tr>
											<?php
												
												$fleetCount8=1;
											?>
												<td class="fleetCol"><?php echo $eigthLidName;?><input type="hidden" name="fleetNameId_1_8_<?php echo $fleetCount8;?>" value="<?php echo $eigthLidId;?>"><input type="hidden" name="fleet_name_1_8_<?php echo $fleetCount8;?>" id="fleet_name_1_8_<?php echo $fleetCount8;?>" value="LiDI000008"/></td>
											<?php
													
												foreach($arrFleetTrans as $key8=>$val8)
												{
													$fleetCount8++;
											?>
												<td>
													<input type="text" name="fleetPrice_1_8_<?php echo $fleetCount8;?>" value="">
													<input type="hidden" name="fleetTypeId_1_8_<?php echo $fleetCount8;?>" value="<?php echo $val8['id'];?>">
													<input type="hidden" name="fleetRateId_1_8_<?php echo $fleetCount8;?>" value=""/>
												</td>		
												<?php
												}
											}
												?>
											</tr>
											<!--<tr>
												<td><label for="last">Add More Row</label>
												<a href="javascript:void(0);" class="add_more_row" id="add_more_row" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a></td>
												<td></td>
											</tr>-->
											</tbody>
										</table>
									</div>				
								</div>
								<div class="form-group">
									<label for="last">Add More table</label>
									<a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
								</div>
								<?php
								}
								?>
								<input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRate>0){echo $countDateRate;}else{echo 1;}?>">
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
					</div>
				</form>	
			</div>
			</div>
			</div>
		</section>
	</div>
	<?php
$arrCompSugg=$objtransporter->get_company_name();
//echo "<pre>";print_r($arrHotelSugg);
$compSugg=array();
$cnt=0;
foreach($arrCompSugg as $value){
	
	$compSugg[$cnt]=$value['hotal_name']." (".$value['city'].")";
	$cnt++;
}
$strCompany =json_encode($compSugg);
?>
<script src="uploadify/jquery.uploadify.js"></script>
<script src="asset/plugins/jquery-superbox/js/superbox.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
	
		$(document).ready(function(){
			$("#transporter_hotel_name").autocomplete({
				source: <?php echo $strCompany;?>
			});
			var totalFleet = $("#item_count1").val();
			for(var i=1; i<=totalFleet; i++)
			{
				uplodifyImg(i);
			}
			$('#depData').timepicker();
			$( "#anvsryData" ).datepicker({			
			format: "dd MM yyyy"
		});
		$(".select2").select2();
		$("#trans_country").change(function()
		{
			//alert("punamsaini");
			var id=$(this).val();
			
			var dataString = 'id='+ id;
			$("#trans_state").find('option').remove();
			$("#transp_city").find('option').remove();
			
			$.ajax
			({
				
				type: "POST",
				url: "_ajax_get_state.php",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#trans_state").html(html);			
				} 
			});
		});
		var totalFld = $("#totalFld").val();
		for(var i=4; i<=totalFld; i++)
		{
			uplodifyMore(i);
		}
		$("#addMoreDocument").click(function(){
			var count=$("#totalFld").val();
			count++;
			var attachId=0;
			$(".myattch").append('<div id="attch_'+count+'"><input type="hidden" name="attachEdId[]" id="addMoreId" value=""/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="docFileName[]" id="addmorefilename_'+count+'" placeholder="File Name" value=""/></div></div><div class="col-md-4"><div class="form-group"><input class="file_upload" id="add_more_file_'+count+'" name="file_upload[]" type="file"><input type="hidden" name="upldFileName[]" id="addMoreDoc_'+count+'" value="" /><p class="help-block text-danger"></p></div></div><div class="col-md-4"><div id="add_more_uploaded_'+count+'" style="height:60px;"></div></div><div class="col-md-2"><div class="form-group"><a class="delete delAttach" relId="" rel="'+count+'" href="javascript:void(0)" onclick="remove_attach('+count+','+attachId+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div><div style="clear:both;"></div>');
				
			$("#totalFld").val(count);
			uplodifyMore(count);
		});
		$("#trans_state").change(function()
		{
			
			var id=$(this).val();
			//alert(id);
			var dataString = 'id='+ id;
			$("#transp_city").find('option').remove();
			$.ajax
			({
				type: "POST",
				url: "_ajax_get_city.php",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#transp_city").html(html);
				} 
			});
		});
		$( ".fromdate" ).datepicker({

			format: "dd MM yyyy"
			});
		$( ".todate" ).datepicker({

			format: "dd MM yyyy"
			});
		$(document).on('click','.delete_row',function(){
			$(this).parent().parent().remove();
		});
	$("#add_more_items2").click(function(){
		
				var count = $("#item_count5").val();
				//alert(count);
				count++;
				$(".items6").append('<div id="Aminities_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><input type="text" class="form-control" name="Aminities" id="Aminities" placeholder= "Amenities & Facilities" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count5").val(count);
				//alert()
			});
		
	$("#add_more_items1").click(function(){
		
				var count = $("#item_count1").val();
				//alert(count);
				count++;
				$(".items1").append('<div style="clear:both;"></div><div id="address2_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="fleetVehicId[]" id="fleetVehicId" value=""/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="vehitype[]" id="vehitype" placeholder="Vehicle Type" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="VDescription[]" id="VDescription" placeholder="Vehicle Description" value=""/></div> </div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="AminitiesF[]" id="AminitiesF" placeholder="Amenities & Facilities" value=""/> </div> </div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="file" class="form-control fleetPics" name="Pics[]" id="Pics_'+count+'" rel="'+count+'" placeholder="Pics" value="" multiple="true"/><input type="hidden" name="fleetImg[]" id="fleetImg_'+count+'" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item4('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div><div class="col-sm-10 col-md-offset-2"><div class="form-group"><div id="fleet_images_'+count+'" class=""></div></div></div> </div>');
				
				$("#item_count1").val(count);
				uplodifyImg(count);
				//alert()
			});
		
		function uplodifyImg(number)
			{
				var str='';
				
				$("#Pics_"+number).uploadify({
				'formData'     : {
					'flag'  : 'hotel_image',
					'direc'	: 'transporter_fleet_pic',
					'id'	: '<?php echo $transporterId;?>',
					'name'  : 'fleet_pic_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response){
					var extension = file.name.replace(/^.*\./, '');
					var a=$.parseJSON(data);
					//alert(a.imagename);
					var imgName=a.imagename;
					$('#fleet_images_'+number).append('<img alt="Restaurant Logo" class="superbox-img" src="document/transporter_doc/trans_fleet_pic/'+imgName+'" id="add_full_img_'+imgName+'" style="width:85px;height:85px;margin:10px;"><img class="remove_img del_add_img" id="add_img_'+imgName+'" src="document/transporter_doc/trans_fleet_pic/x.png" relId="'+imgName+'" relNum="'+number+'" alt="delete"/>');
					
					var preImg = $('#fleetImg_'+number).val();
					//alert(str);
					if(preImg == '')
					{
						str += imgName+',';
					}
					else
					{
						str = preImg+imgName+',';
					}
					//preImg = preImg.replace(/,\s*$/, "");
					
					//$('#add_more_uploaded').html('<label>'+imgName+'</label>');
					$("#fleetImg_"+number).val(str);
				}		
			});
			}
			
		$(document).on('click', ".del_add_img", function(){
				//alert("sdgs");
			var imgid = $(this).attr('relId');
			var num=$(this).attr('relNum');
			//alert(imgid);
			$(this).prev().remove();
			$(this).remove();
			var fleetImg=$("#fleetImg_"+num).val();
			//alert(roomImg);
			var arrfleetImg=fleetImg.split(',');
			//alert(arrroomImg);
			var index = arrfleetImg.indexOf(imgid);
			if (index > -1) {
				arrfleetImg.splice(index, 1);
			}
			//alert(arrroomImg);
			$("#fleetImg_"+num).val(arrfleetImg);
			
		});
		
		$(".remove_img").click(function(){
				var imageId=$(this).attr('relId');
				var relNum=$(this).attr('relImgNum');
				var relImgId=$(this).attr('relImgId');
				
				$.ajax({
					type:"POST",
					url:"_ajax_transporter_detail.php?action=deleteTransImg",
					data:{imageId:imageId},
					beforeSend:function(){
						
					},
					success:function(msg){
						if(msg == 1)
						{	
							$("#delete_img_"+imageId).remove();
							$("#delete_full_img_"+imageId).remove();
							var fleetImg=$("#fleetImg_"+relNum).val();
							var arrFleetImg=fleetImg.split(',');
							var index = arrFleetImg.indexOf(relImgId);
							if (index > -1) {
								arrFleetImg.splice(index, 1);
							}
							//alert(arrroomImg);
							$("#fleetImg_"+relNum).val(arrFleetImg);
						}
					}
				}); 
			}); 
	
		$("#add_more_item").click(function(){
		
				var count = $("#item_count").val();
				//alert(count);
				count++;
				$(".ite").append('<div id="person_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="concernPrsnId[]" id="concernPrsnId" value=""/><div class="col-md-3"><div class="form-group"><select class="form-control" name="title[]" id="title><option>--</option><option value="Mr.">Mr.</option><option value="Miss." >Miss.</option><option value="Mrs.">Mrs.</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="middlename[]" id="middlename[]" placeholder="Middle Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item6('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count").val(count);
				//alert()
			});
		
			$("#add_more_items").click(function(){
		
				var count = $("#item_count").val();
				//alert(count);
				count++;
				
				$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="transClntAddrId[]" id="transClntAddrId" value=""/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="transporter_address1[]" id="transporter_address1" placeholder="Address line 1" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="transporter_address2[]" id="transporter_address2" placeholder="Address line 2" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="transp_city[]" id="transp_city" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="trans_state[]" id="trans_state" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="trans_pincode[]" id="trans_pincode" placeholder="Code" value=""/></div></div><div class="col-md-1"><div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				
				$("#item_count").val(count);
				//alert()
			});
		
			$("#Mnumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$(".items3").append('<div id="Mobnumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="transClientNumId[]" id="transClientNumId" value=""/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div>	<div class="col-md-3 v_hidden">	<div class="form-group"><input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item5('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count3").val(count);
				//alert()
			});
			$("#contumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$(".cont").append('<div id="connumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="concPrsnQryNumId[]" id="concPrsnQryNumId" value=""/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false"><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-3 v_hidden">	<div class="form-group"><input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count3").val(count);
				//alert()
			});
			
			$("#emails").click(function(){
		
				var count = $("#item_count4").val();
				//alert(count);
				count++;
				$(".items4").append('<div id="Email_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="" /></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item1('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div> ');
				
				$("#item_count4").val(count);
				//alert()
			});
			function uplodifyMore(number){
				$('#add_more_file_'+number).uploadify({
					'formData'     : {
						'flag'  : 'upload_file',
						'direc'	: 'transporter_doc',
						'id'	: '<?php echo $transporterId;?>',
						'name'  : 'pan_card_copy'
					},
					'onSelect' : function(file) {
					  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
					 },
					'buttonImage' : 'uploadify/browse-btn.png',
					'buttonText' : 'Add Category Pic',
					'multi': false,
					'swf'      : 'uploadify/uploadify.swf',
					'uploader' : '_ajax_document_upload.php',
					'onUploadSuccess': function (file, data, response) {
						var extension = file.name.replace(/^.*\./, '');
						var a=$.parseJSON(data);
						//alert(a.imagename);
						var imgName=a.imagename;
						$('#add_more_uploaded_'+number).html('<label>'+imgName+'</label>');
						$("#addMoreDoc_"+number).val(imgName);
					}		
				});
			}
			
			//alert("gdfgd");
			/* $("#add_User").validate({
			rules:{
				userType:"required",
				userName:"required",
				userEmail:{
					required:true,
					email:true
				},
				userPhone:{
					required:true,
					minlength:10,
					maxlength:10,
					number:true
				},
				userAddress:"required"
			},
			messages:{
				userType:"Please Select User Type",
				userName:"Please Enter User Name",
				userEmail:{
					required:"Please Enter email",
					email:"Enter valid email"
				},
				userPhone:{
					required:"Please Enter your Mobile Number",
					minlength:"Minimum Length Should be 10 digits",
					maxlength:"Maximum Length Should be 10 digits",
					number:"Please Enter only Number"
				},
				userAddress:"Please Enter Your Address"
			},
			submitHandler:function(form){
				$.ajax({
					type: "POST",  
					url: "_ajax_user_authentication.php?action=addUser",
					data: $("#add_User").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						if(msg === '1')
						{
							$("#status").show().html('<div class="alert alert-success">sucessfully Added</div>');
							 //$("#candidate_Details")[0].reset();
							 location.reload(true);
						}
						else
						{
							$("#status").show().html('<div class="alert alert-dangersss">Sorry, there is some problem</div>');
							
						}
					} 
				});
			}
			}); */
		$("#add_more_rate").click(function(){
		
				var count = $("#item_count9").val();
				//alert(count);
				count++;
				$(".rate").append('<div id="rates_'+count+'"><div class="col-md-2"><div class="form-group"><h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4></div></div><input type="hidden" name="dateRateId[]" id="dateRateId" value=""/><input type="hidden" name="transpRateId[]" id="transpRateId" value=""/><div class="col-md-4"><div class="form-group" ><label for="search">From:Calender</label><input type="text" class="form-control fromdate" name="fromdate_'+count+'" id="fromdate_'+count+'" placeholder="Name"  value="Date"/></div></div><div class="col-md-4"><div class="form-group"> <label for="search">To:Calender</label><input type="text" class="form-control todate"  name="todate_'+count+'" id="todate_'+count+'" placeholder="Name" value="Date"/></div></div><div class="col-md-1" ></div> <div class= "bs-example col-md-11" ><table class="table" ><thead><tr ><th ></th><th style="width: 40px;" >Innova</th><th style="width: 40px;">Indigo</th>	<th style="width: 30px;"> Tempo Traveller </th></tr>	 </thead><tbody border="1px" ><tr><td>LiDI000001<input type="hidden" name="LidID_'+count+'_1_1" value="LiDI000001"></td> <td><input type="text" value="3000" name="Innova_'+count+'_1_2"> </td><td><input type="text" name="Indigo_'+count+'_1_3"></td><td><input type="text"name="Traveller_'+count+'_1_4"></td><td rowspan="8"><textarea  rows="17" cols="21" name="description_'+count+'"> Description </textarea> </td></tr><tr><td>LiDI000002<input type="hidden" name="LidID_'+count+'_2_1" value="LiDI000002"></td><td><input type="text" value="3500" name="Innova_'+count+'_2_2"></td><td><input type="text" name="Indigo_'+count+'_2_3"></td><td><input type="text" name="Traveller_'+count+'_2_4"> </td> </tr><tr><td>LiDI000003<input type="hidden" name="LidID_'+count+'_3_1" value="LiDI000003"></td><td><input type="text" value="1200" name="Innova_'+count+'_3_2"></td><td><input type="text" name="Indigo_'+count+'_3_3"></td><td><input type="text" name="Traveller_'+count+'_3_4"> </td> </tr><tr><td>LiDI000004<input type="hidden" name="LidID_'+count+'_4_1" value="LiDI000004"></td><td><input type="text" value="800" name="Innova_'+count+'_4_2"></td>	<td><input type="text" name="Indigo_'+count+'_4_3"></td><td><input type="text" name="Traveller_'+count+'_4_4">	</td></tr><tr><td>LiDI000005<input type="hidden" name="LidID_'+count+'_5_1" value="LiDI000005"></td><td><input type="text" value="1000" name="Innova_'+count+'_5_2"></td><td><input type="text" name="Indigo_'+count+'_5_3"></td><td><input type="text" name="Traveller_'+count+'_5_4"></td></tr><tr><td>LiDI000006<input type="hidden" name="LidID_'+count+'_6_1" value="LiDI000006"></td><td><input type="text" value="250" name="Innova_'+count+'_6_2"></td><td><input type="text" name="Indigo_'+count+'_6_3"></td><td><input type="text" name="Traveller_'+count+'_6_4"></td></tr><tr><td>LiDI000007<input type="hidden" name="LidID_'+count+'_7_1" value="LiDI000007"></td><td><input type="text" value="350" name="Innova_'+count+'_7_2"></td><td><input type="text" name="Indigo_'+count+'_7_3"></td><td><input type="text" name="Traveller_'+count+'_7_4"></td></tr><tr><td>LiDI000008<input type="hidden" name="LidID_'+count+'_8_1" value="LiDI000008"></td><td><input type="text" value="450" name="Innova_'+count+'_8_2"></td><td><input type="text" name="Indigo_'+count+'_8_3"></td><td><input type="text" name="Traveller_'+count+'_8_4"></td></tr> </tbody></table></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_rate('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count9").val(count);
				$( "#fromdate_"+count).datepicker({
				format: "dd MM yyyy"
				});
				$( "#todate_"+count ).datepicker({
				format: "dd MM yyyy"
				});
				//alert()
			});		
			
			$('#transporter_pan_card_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'transporter_doc',
					'id'	: '<?php echo $transporterId;?>',
					'name'		: 'pan_card_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'multi': false,
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response) {
				var extension = file.name.replace(/^.*\./, '');
				var a=$.parseJSON(data);
				var imgName=a.imagename;	
				//alert(imgName);
				$('#panCardDocName').html('<label>'+imgName+'</label>');
				$("#panCardDoc").val(imgName);
				}		
			});
			
			$('#transporter_photo_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'transporter_doc',
					'id'	: '<?php echo $transporterId;?>',
					'name'		: 'photo_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'multi': false,
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response) {
					 var extension = file.name.replace(/^.*\./, '');
					 var a=$.parseJSON(data);
						var imgName=a.imagename;
						$('#photoDocName').html('<label>'+imgName+'</label>');
						//$("#bioData").val(imgName);
						$("#photoDoc").val(imgName);
				}		
			});
			
			$('#transporter_Contract_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'transporter_doc',
					'id'	: '<?php echo $transporterId;?>',
					'name'		: 'contract_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'multi': false,
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response) {
					 var extension = file.name.replace(/^.*\./, '');
					 var a=$.parseJSON(data);
						var imgName=a.imagename;
						$('#contCopyDocName').html('<label>'+imgName+'</label>');
						//$("#bioData").val(imgName);
						$("#contCopyDoc").val(imgName);
				}		
			});	
			
			$("#transporter_doc_detail_btn").click(function(){
				//alert("sdfdsf");
				$.ajax({
					type: "POST",
					url: "_ajax_transporter_detail.php",
					data: $("#transporter_doc_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(msg)
					{
						window.location.href='<?php echo $tabUrl.base64_encode(5); ?>';
					}
				}); 
			});
			
		});
		$(".add_more_row").click(function(){
				var row=1;
				var count = $("#item_count10").val();
				var total__rates_itmes = $("#total__rates_itmes").val();
				var ttlroom=$("#ttlRoomService").val();
				var i=2;
				ttlroom=parseInt(ttlroom)+parseInt(i);
				//alert(ttlroom);
				//alert(count);ttlRoomService
				count++;
				total__rates_itmes++;
				
				//console.log($(this).parent().parent().parent().prev());
				var prev = $(this).parent().parent().prev().clone();
				
				$(prev).find('.fleetCol').html('<input type="text" name="roomType_1_'+count+'_1" value="" onblur="add_fleet_name('+count+',$(this).val())" /><input type="hidden" name="roomName_1_'+count+'_1" value="0"><input type="hidden" name="room_name_1_'+count+'_1" id="room_name_1_'+count+'_1" value=""/>');
				for(i=2;i<ttlroom;i++){
					var roomtype='roomType_1_'+count+'_'+i;
					$(prev).find('.roomType_'+i).attr({id:roomtype,name:roomtype});
					var roomtypeId='roomTypeId_1_'+count+'_'+i;
					$(prev).find('.roomTypeId_'+i).attr({id:roomtypeId,name:roomtypeId});
					var hotelRateId='hotelRateId_1_'+count+'_'+i;
					$(prev).find('.hotelRateId_'+i).attr({id:hotelRateId,name:hotelRateId,value:0});
				}
				
				
				
				$(prev).insertBefore($(this).parent().parent());
				
				$("#item_count").val(count);
				$("#item_count10").val(count);
				$("#total__rates_itmes").val(total__rates_itmes);
			});	
			
		/* $("#add_more_row").click(function(){
		
				var count = $("#item_count10").val();
				var total__rates_itmes = $("#total__rates_itmes").val();
				//alert(count);
				count++;
				total__rates_itmes++;
				$("#rows_1").after(' <tr id="row_'+count+'"><td><input type="text" name="LidID_'+total__rates_itmes+'_1" placeholder="LiDI000009"></td> <td><input type="text"  ></td><td><input type="text" > </td><td><input type="text"></td><td><a class="delete_row" rel="'+count+'"  href="javascript:void(0)" ><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></td></tr> ');
				
				$("#item_count10").val(count);
				$("#total__rates_itmes").val(total__rates_itmes);
				//alert()
			
			}); */	
		function remove_attach(counter,relId)
		{
			
			if(relId == 0){
				$('#attch_'+counter).remove();
			}else{
				if(confirm("Do you want to delete?")){
					$.ajax({
						type:"POST",
						url:"_ajax_transporter_detail.php?action=delAttach",
						data:{attachId:relId},
						success:function(data){
							if(data.status == 1){
								$('#attch_'+counter).remove();
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
		function remove_item2(counter)
		{
			$('#connumbbr_'+counter).remove();
		}
		function remove_item5(counter)
		{
			$('#Mobnumbbr_'+counter).remove();
		}
		function remove_item6(counter)
		{
			$('#person_'+counter).remove();
		}
		function remove_item3(counter)
		{		
			$('#address_'+counter).remove();	
		}
		function remove_item4(counter)
		{		
			$('#address2_'+counter).remove();	
		}
		function remove_rate(counter)
		{
			$('#rates_'+counter).remove();
		}

	</script>
	 
	 <script>
	
	$("#transporter_client_detail").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_transporter_detail.php",
					data: $("#transporter_client_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						window.location.href='<?php echo $tabUrl.base64_encode(2); ?>';
					}
				}); 
			}
		});
	</script> 
 <script>
	
	$("#transport_query_detail").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_transporter_detail.php",
					data: $("#transport_query_detail").serialize(),
					cache: false,
					beforeSend:function() {
					},
					success: function(html)
					{
					
						window.location.href='<?php echo $tabUrl.base64_encode(3); ?>';
					}
				}); 
			}
		});
	</script> 
<script>
	
	$("#transport_bank_detail").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_transporter_detail.php",
					data: $("#transport_bank_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						window.location.href='<?php echo $tabUrl.base64_encode(4); ?>';
					}
				}); 
			}
		});
	</script> 
		 <script>
	
	$("#transporter_rate").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_transporter_detail.php",
					data: $("#transporter_rate").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						window.location.href='transporterlist.php';
						
					}
				}); 
			}
		});
	</script> 

	 <script src="asset/bootstrap-datepicker.js"></script>
	<!-- <script src="asset/jquery.timepicker.js"></script>
	 <script src="asset/bootstrap/css/jquery.timepicker.css"></script>-->
<?php  include('footer.php');?> 