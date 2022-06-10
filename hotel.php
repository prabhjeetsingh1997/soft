<?php
include('header.php');
include('sidebar.php');

@$hotelId =  $_SESSION['hotelId'];
$countDiv='';
$i='';
$dateId='';
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
$singleRoomId='';
$doubRoomId='';
$extAdltRoomId='';
$extChldWoBedRoomId='';
$extChldWBedRoomId='';
$extBrkFastRoomId='';
$lunchRoomId='';
$dinnRoomId='';

$recordId=0;

if(!isset($_GET['t']) || $_GET['t'] == 1)
{
	$_SESSION['hotelId'] = '';
}

$hotelIdProcess = $_SESSION['hotelId'];
$showPrevBtn = 0;
if($_GET['action']=='edit')
{
	$showPrevBtn = 1;
	$hotelIdProcess = $recordId = $editHotelId=$_GET['id'];
	$hotelData = $objhotel->getHotelById($editHotelId);
	$checkin_time = $hotelData['checkin_time'];
	$checkout_time = $hotelData['checkout_time'];
	$arrEmail=explode(',',$hotelData['additional_email_address']);
	$countEmail=count($arrEmail);
	$hotel_address_details = $objhotel->getHotelAddressById($editHotelId,'hotel_permanent_addr');
	//print_r($hotel_address_details);
	//$hotel_contact_numbers = $objhotel->getNumberByid($editHotelId,'hotel_phone');
	//$concern_person_numbers = $objhotel->getNumberByid($editHotelId,'hotel_concern_person');
	
	$hotel_contact_numbers=$objAdmin->getPhoneNumbers($editHotelId, 'hotel', 'hotel_phone');
	$concern_person_numbers=$objAdmin->getPhoneNumbers($editHotelId, 'hotel', 'hotel_concern_person');
	
	
	$room_service_details=$objhotel->getHotelRoomServicesByid($editHotelId);
	$aminities_facilites=$objhotel->getAminitFacilityByid($editHotelId);
	//print_r($room_service_details);
	$concern_prsn_detail=$objhotel->getConcPrsnByid($editHotelId);
	$editArrRooms=$objhotel->getHotelRoomServicesByid($editHotelId);
	$date_rates_detail=$objhotel->getDateRatesByid($editHotelId);
	//print_r($date_rates_detail);
	$attachdoc = @$objhotel->getdocumentbyid($editHotelId,'Hotel');
	$attachdoc1 = @$objhotel->getdocumentbyid1($editHotelId,'Hotel','PAN Card');
	$attachdoc2 = @$objhotel->getdocumentbyid2($editHotelId,'Hotel','Photo');
	$attachdoc3 = @$objhotel->getdocumentbyid3($editHotelId,'Hotel','Contract');
	$ttlDoc=count($attachdoc);
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
	$countPrmntAddr=count($hotel_address_details);
	$countHotelPhone=count($hotel_contact_numbers);
	$countRoomDetail=count($room_service_details);
	$countAmntiFacility=count($aminities_facilites);
	$countConcPrsn=count($concern_prsn_detail);
	$countConcPrsnNum=count($concern_person_numbers);
	$countDateRates=count($date_rates_detail);
	$countEditRooms=count($editArrRooms);
	$editallRoom=$objhotel->getAllHotelRoom();
	$countRoomName=count($editallRoom);
	$editsingleRoomId=$editallRoom[0]['id'];
	$editdoubRoomId=$editallRoom[1]['id'];
	$editextAdltRoomId=$editallRoom[2]['id'];
	$editextChldWoBedRoomId=$editallRoom[3]['id'];
	$editextChldWBedRoomId=$editallRoom[4]['id'];
	$editextBrkFastRoomId=$editallRoom[5]['id'];
	$editlunchRoomId=$editallRoom[6]['id'];
	$editdinnRoomId=$editallRoom[7]['id'];
	//print_r($date_rates_detail);
	
	//$arrTotalRoom=$objhotel->getAllHotelRoom_edit($editHotelId);
	//$countTtlRoom=count($arrTotalRoom);
	//print_r($arrTotalRoom);
	//die;
} 
$getallRoom=$objhotel->getAllHotelRoom();

$countRoomNameId=count($getallRoom);
//print_r($getallRoom);
$singleRoomId=$getallRoom[0]['id'];
$doubRoomId=$getallRoom[1]['id'];
$extAdltRoomId=$getallRoom[2]['id'];
$extChldWoBedRoomId=$getallRoom[3]['id'];
$extChldWBedRoomId=$getallRoom[4]['id'];
$extBrkFastRoomId=$getallRoom[5]['id'];
$lunchRoomId=$getallRoom[6]['id'];
$dinnRoomId=$getallRoom[7]['id'];
$arrAmenties=array('Board Room','Confrence Room','Ball Room','Business Center','Garden','Swimming Pool','Restaurant','Bar','Discotheque','Casino','Amphitheatre','Airport Transfers/Cab Facilities','Lift/Elevator','Front Desk','Laundry Services','Power Backup','Cloak Room','Welcome Drinks','Shuttle Service to nearby Market','Rest Room for Drivers','Travel Desk','Banquet Facilities','Kids Play Zone','Lobby','Spa','Saloon','Car Parking','Bus Parking','Gym','Jacuzzi','Coffee Shop');
$arrRoomAmen=array('Tea Kettle','Mini Bar','Wi fi','Mini Fridge','Iron & Iron Board','Locker','LED TV','Air Conditioner','Hair Dryer','Bath Tub','Mineral Water','Personal Butler','Fruit Basket','Attached Living Room','Music System','Breakfast','Lunch','Dinner','Evening Tea/Coffee','Welcome Drinks (non Alcoholic)','Cocktail Happy Hours','Flowers on Arrival','Champagne Bottle','Wine Bottle','Chocolates on arrival');
$arrRooms=$objhotel->getHotelRoomServicesByid($hotelIdProcess);
$countRooms=count($arrRooms);
//echo 'ppp::'; print_r($arrRooms);
//print_r($_SESSION);
/****** used for tab navigagation *******/
$tab = 1;
if(isset($_GET['t']))
{
	$tab = base64_decode($_GET['t']);
}


$tabUrl = 'hotel.php?action=edit&t=';
if(isset($_GET['action']))
{
	$tabUrl = 'hotel.php?action=edit&id='.$_GET['id'].'&t=';
}

$arrcountery=$objAdmin->get_countery();
$j=0;
/* print_r($hotelData);
if(isset($hotelData['transport_id'])){
	echo 'aaaaa:hId:::';
	$hoidshow = $hotelData['transport_id'];
}else{
	echo 'aaaaa:hId2:::';
	
} */
$hoidshow = $hotelIdProcess;
$autohotelId = $objAdmin->autogenerate_id($hoidshow, 'H');

$staticArr = array('PAN Card','Photo','Contract');
//$attachdoc
$docsStaticArr = array();
$docsCustArr = array();
foreach($attachdoc as $docs)
{
	if(in_array($docs['name'], $staticArr))
	{
		$docsStaticArr[] = $docs;
	}
	else
	{
		$docsCustArr[] = $docs;
	}
}

?>
<link href="<?php echo APP_URL; ?>uploadify/uploadify.css" rel="stylesheet">


<style>
.v_hidden{visibility:hidden !important}
.remove_img, .delHotelImg {
    width: 15px;
    border: none;
    height: 15px;
    margin-left: -8px;
    margin-bottom: 72px;
    cursor: pointer;
}
.delPhotoImg {
        width: 15px;
    border: none;
    height: 15px;
    top: 6px;
    position: absolute;
    cursor: pointer;
}
.hpBox{
	border: 1px solid #EEE;
    border-radius: 7px;
	margin:5px;
	position:relative;
	padding:0;
}
.rateRow{
	float: left;
    width: 100%;
    border-top: 1px solid #3c8dbc;
    padding-top: 20px;
}
</style>

<!--<script src="asset/plugins/jquery-superbox/js/superbox.js" type="text/javascript"></script>-->
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<input type="hidden" id="checkEdit" value="<?php echo $_GET['action']; ?>" />
        <section class="content-header">
          <h1>
            Add Hotel Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Add Hotel</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">
				<div class="box-header with-border">
				 <ul class="nav nav-tabs">
					
				  <li <?php if($tab == 1){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 1){ echo 'class="disabled"';}?> href="#home" title="Click next to open"> <h3 class="box-title"><b>HOTEL DETAILS</b></h3></a></li>
				  <li <?php if($tab == 2){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 2){ echo 'class="disabled"';}?> id="hotel_more_detail_tab" href="#menu1" title="Click next to open"><h3 class="box-title"><b>MORE DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 3){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 3){ echo 'class="disabled"';}?> id="banking_tab" href="#menu2" title="Click next to open"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 4){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 4){ echo 'class="disabled"';}?> id="attach_doc_tab" href="#menu3" title="Click next to open"><h3 class="box-title"><b>ATTACHED DOCUMENTS</b></h3> </a></li>
				  <li <?php if($tab == 6){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 6){ echo 'class="disabled"';}?> id="hotel_photos_tab" href="#menu5" title="Click next to open"><h3 class="box-title"><b>HOTEL PHOTOS</b></h3> </a></li>
				   <li <?php if($tab == 5){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a data-toggle="tab" <?php if($tab != 5){ echo 'class="disabled"';}?> id="hotel_rate_tab" href="#menu4" title="Click next to open"><h3 class="box-title"><b>RATES</b></h3> </a></li>
				</ul>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
					<div id="home" class="tab-pane fade <?php if($tab == 1){ echo 'in active';}?>">
					<div style="display:none;" id="me3"><img src="tenor.gif" style="position:absolute; top:140px; opacity:1; "/></div>	
					<form role="form" method="POST" name="hotal_personl_detail" id="hotal_personl_detail" enctype="multipart/form-data">
					 <input type="hidden" id="address1" name="address1" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="<?php if($countRoomDetail){echo $countRoomDetail;}else{echo 1; } ?>"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="<?php if($countHotelPhone>1){echo $countHotelPhone; }else{ echo 1;}?>"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="hotel_id" value="<?php echo $hotelData['hotel_id']; ?>" />
					<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
						<input type="hidden" name="type" value="add_hotel_prsnl_detail" />
						<div class="box-body">
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Hotel Name</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="name">Hotal Name</label>-->
										<input type="text" class="form-control" name="hotel_name" id="hotel_name" placeholder="Hotel Name" value="<?php echo @$hotelData['hotel_name'];?>"/>
									</div>
								</div><!-- /.form-group -->
								
								<!-- /.first line -->
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Address</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="items">
								<?php 
									if($countPrmntAddr>0)
									{
										$countDiv=1;
										$i=0;
										foreach($hotel_address_details as $key=>$val)
										{
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
									<input type="hidden" name="hotelPerAddrId[]" value="<?php echo @$val['id']?>"/>
									<div class="col-md-5">
										<div class="form-group">
											<!--<label for="userPhone">Address Line 1</label>-->
											<input type="text" class="form-control" name="hotel_address1[]" id="hotel_address1" placeholder="Address" value="<?php echo $val['address1']; ?>"/>
										</div>
									</div>
									
									<div class="col-md-5">
										<div class="form-group">
											<!--<label for="userPhone">Address Line 2</label>-->
											<input type="text" class="form-control" name="hotel_address2[]" id="hotel_address2" placeholder="Location/Area" value="<?php echo $val['address2']; ?>"/>
										</div>
									</div>
									<div class="col-md-2"><div class="form-group"></div></div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="middle">City</label>
											<input type="text" class="form-control" name="hotel_country[]" id="hotel_country" placeholder="Country" value="<?php echo $val['country']; ?>"/>-->
											<?php
											//$editCountry = $objAdmin->getCountryNameById($hotel_address_details[0]['country']);
											?>
											<select class="form-control select2" name="hotel_country[]" id="hotel_country" data-placeholder="Select a Country"> 
											<option value="">--Select Country--</option>
											
											<?php
											
												foreach($arrcountery as $count)
												{ 
													
													$slectedCount = '';
													if($count['id'] == $hotel_address_details[0]['country'])
													{
														$slectedCount = 'selected';
													}
											?>	
												<option value="<?php echo $count['id']; ?>" <?php echo $slectedCount; ?>><?php echo $count['country_name']; ?></option>
											<?php		
												}
											?>	
														
											</select>
										
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="last">State</label>
											<input type="text" class="form-control" name="hotel_state[]" id="hotel_state" placeholder="State" value="<?php echo $val['state']; ?>"/>-->
											<?php
												//$arrState=$objAdmin->get_state($hotel_address_details[0]['country']);
												//print_r($arrState);
											?>	
											<select class="form-control select2" name="hotel_state[]" id="hotel_state" data-placeholder="Select a State">
											<option value="">--Select State--</option>
											<?php
												$arrState=$objAdmin->get_state($hotel_address_details[0]['country']);
												foreach($arrState as $sval)
												{
													$slectedState = '';
													if($sval['id'] == $hotel_address_details[0]['state'])
													{
														$slectedState = 'selected';
													}
														
											?>
												<option value="<?php echo $sval['id'];?>" <?php echo $slectedState; ?>><?php echo $sval['state_name'];?></option>
											<?php
												}
											?>
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="middle">City</label>
											<input type="text" class="form-control" name="hotel_city[]" id="hotel_city" placeholder="City" value="<?php echo $val['city']; ?>"/>-->
											<select class="form-control select2" name="hotel_city[]" id="hotel_city" data-placeholder="Select a City">
											<option value="">--Select City--</option>
											<?php
												$newCityArr =$objAdmin->get_city($hotel_address_details[0]['state']);
												foreach($newCityArr as $cval)
												{
													
													$city_name = $cval['city'];
													$cityId = $cval['id'];
													
													$slectedCity = '';
													if($cval['id'] == $hotel_address_details[0]['city'])
													{
														$slectedCity = 'selected';
													}
													
											?>
											<option value="<?php echo $cityId;?>" <?php echo $slectedCity; ?>><?php echo $city_name;?></option>
											<?php
												}
											?>
											</select>
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="last">Pin Code</label>-->
											<input type="text" class="form-control" name="hotel_pincode[]" id="hotel_pincode" placeholder="Code" value="<?php echo $val['pin_code']; ?>"/>
										</div>
									</div>
								</div>
								
								<?php
									if($countDiv == 1)
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
									$i++;
									$countDiv++;
										}
									}
									else
									{
								?>
								<div id="address_1">
								<input type="hidden" name="hotelPerAddrId[]" value="0"/>
								<div class="col-md-5">
									<div class="form-group">
										<!--<label for="userPhone">Address Line 1</label>-->
										<input type="text" class="form-control" name="hotel_address1[]" id="hotel_address1" placeholder="Address" value=""/>
									</div>
								</div>
								
								<div class="col-md-5">
									<div class="form-group">
										<!--<label for="userPhone">Address Line 2</label>-->
										<input type="text" class="form-control" name="hotel_address2[]" id="hotel_address2" placeholder="Location/Area" value=""/>
									</div>
								</div>
								<div class="col-md-2"><div class="form-group"></div></div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="middle">City</label>
										<input type="text" class="form-control" name="hotel_country[]" id="hotel_country" placeholder="Country" value="<?php echo $val['country']; ?>"/>-->
										<select class="form-control select2" name="hotel_country[]" id="hotel_country" data-placeholder="Select a Country"> 
											<option value="">--Select Country--</option>
										
											<?php
												foreach($arrcountery as $count)
												{ 
											?>	
												<option value="<?php echo $count['id']; ?>" <?php if($count['id'] == @$itineraryData[0]['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
											<?php		
												}
											?>	
														
											</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="last">State</label>
										<input type="text" class="form-control" name="hotel_state[]" id="hotel_state" placeholder="State" value=""/>-->
										<select class="form-control select2" name="hotel_state[]" id="hotel_state" data-placeholder="Select a State">
											<option value="">--Select State--</option>
											<?php
												foreach($arrState as $key=>$val)
												{
													foreach($arrStateId as $value)
													{
													
											?>
												<option value="<?php echo $val['id'];?>" <?php if($value == $val['id']){echo "selected";}?>><?php echo $val['state_name'];?></option>
											<?php
													}
												}
											?>
											</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="middle">City</label>
										<input type="text" class="form-control" name="hotel_city[]" id="hotel_city" placeholder="City" value=""/>-->
										<select class="form-control select2" name="hotel_city[]" id="hotel_city" data-placeholder="Select a City">
											<option value="">--Select City--</option>
											<?php
												
												foreach($newCityArr as $key=>$val)
												{
													$city_name = $val['city'];
													$cityId = $val['id'];
													//print_r($val);
													foreach($arrCityId as $value)
													{
											?>
											<option value="<?php echo $cityId;?>" <?php if($value == $cityId){echo "selected";}?>><?php echo $city_name;?></option>
											<?php
													}
													
												}
											?>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="last">Pin Code</label>-->
										<input type="text" class="form-control" name="hotel_pincode[]" id="hotel_pincode" placeholder="Code" value=""/>
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
								
								<!-- /.second line -->
								
							
								<!-- /.second line -->
								<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Contact Nos </b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="items3 phoneNumber1">
								<?php
									//echo $countHotelPhone;
									if($countHotelPhone>0)
									{
										$countDiv=1;
										foreach($hotel_contact_numbers as $key=>$val)
										{
								?>
								
								<div id="Mobnumbbr_<?php echo $countDiv;?>">
									
								<?php
									if($countDiv > 1)
									{
										echo '<div class="clearfix"></div>';
								?>
									<div class="col-md-2"><div class="form-group"></div></div>
								<?php	
									}	
								?>
								<input type="hidden" name="hotelPerNumId[]" value="<?php echo @$val['id'];?>"/>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="userPhone">Mobile</label>-->
										<input type="number" class="form-control" name="hotelPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo @$val['contact_no']; ?>"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="middle">Code</label>-->
										<select class="form-control valid" name="hotelCode[]" placeholder="Code" value="" aria-invalid="false">
											<option value="">Select</option>
											<option value="Mobile" <?php if(@$val['code'] == 'Mobile'){echo "selected";}?>>Mobile</option>
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
										<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
									</div>
								</div>-->
								
								</div>
								
								
								<?php
									if($countDiv == 1)
									{
								?>
								
								
								<?php
									}
									else
									{
								?>
								<div class="col-md-1"> <div class="form-group"><a id="hotelPhone_<?php echo $val['id']; ?>" class="delete_<?php echo $countDiv;?>" rel="<?php echo $val['id']; ?>" href="javascript:void(0)" onclick="remove_hotelitems(<?php echo $val['id']; ?>, 'hotelPhone', <?php echo $countDiv;?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
								<?php	
									}
									$countDiv++;
								}
								?>
									<div class="col-md-1">
										<div class="form-group">
											<!--<label for="last">Add More</label>-->
											<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add More Contact Nos." style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
										</div>
									</div>
								<div class="clearfix"></div>	
								<?php	
									}
									else
									{
								?>
								<div id="Mobnumbbr_1">
								<input type="hidden" name="hotelPerNumId[]" value="0"/>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="userPhone">Mobile</label>-->
										<input type="number" class="form-control" name="hotelPhone[]" id="userPhone" placeholder="Mobile Number" value=""/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="middle">Code</label>-->
										<select class="form-control valid" name="hotelCode[]" placeholder="Code" value="" aria-invalid="false">
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
										<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
									</div>
								</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add More Contact Nos." style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php 
									}
								?>
								</div>
								
								<!-- /.second line -->
								
								<div class="items1">
								<?php
									if($countRoomDetail>0)
									{
										$i=0;
										$countDiv=0;
										foreach($room_service_details as $key=>$val)
										{
											$i++;
											$countDiv++;
											$roomId=$val['id'];
											$hotelid=$hotelData['hotel_id'];
											$roomImages=$objhotel->getImagesById($roomId,$hotelid);
											//echo "<pre>";print_r($roomImages);
								?>
								
								<div id="address2_<?php echo $countDiv;?>">
								<?php
									if($countDiv == 1)
									{
								?>
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	Rooms </b><span style="color:red;">*</span></h4>
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
								<input type="hidden" name="hotelRoomSerDetail[]" value="<?php echo @$val['id']?>"/>
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="roomstype">Room Type</label>-->
											<input type="text" class="form-control" name="roomstype[]"id="hotel_roomstype" placeholder="Room Type" value="<?php echo $val['room_type'];?>"/>
										</div>
									</div>
								
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="RDescription">Room Description</label>-->
											<input type="text" class="form-control" name="RDescription[]" id="RDescription" placeholder="Room Description" value="<?php echo $val['room_description']; ?>"/>
										</div>
									</div>
									<div class="col-md-1">
										<button type="button" class="btn btn-primary roomAmenities" name="roomAmenities[]" id="roomAmenities" onclick="room_modal('<?php echo $countDiv;?>');">Select</button>
									</div>
									<!--<div class="col-md-2">
										<div class="form-group">
											
											<input type="text" class="form-control AminitiesF" name="AminitiesF[]" id="AminitiesF" placeholder="Amenities & Facilities" value="<?php echo $val['aminities_facilites']; ?>"/>
										</div>
									</div>-->
									<div class="col-md-2">
									<div class="form-group">
										<!--<label for="AminitiesF">Aminities & Facilities</label>-->
										<input type="text" class="form-control AminitiesF_1" name="AminitiesF[]" id="AminitiesF_<?php echo $countDiv;?>" placeholder="Amenities & Facilities" value="<?php echo $val['aminities_facilites']; ?>"/>
									</div>
								</div>
									<div class="col-md-1">
										<div class="form-group">
											<!--<label for="Units">Units</label>-->
											<input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value="<?php echo $val['units']; ?>"/>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="Pics">Pics</label>-->
											<label class="btn-bs-file btn btn-md btn-primary">
									Choose File
											<input type="file" class="form-control roomPics" name="Pics[]" id="Pics_<?php echo $countDiv;?>" rel="1" placeholder="Pics" value="" multiple />
										</label>
										</div>
									</div>
								</div>
								<?php
									if($countDiv > 1)
									{
								?>

								<?php	
									}	
								?>
								<?php
									if($countDiv == 1)
									{
								?>
								
								
								<div style="clear:both;"></div>
								<?php
									}
									else
									{
								?>
								<div class="col-md-1"> <div class="form-group"><a id="hotelRoom_<?php echo $val['id']; ?>" class="delete_<?php echo $countDiv;?>" rel="<?php echo $val['id']; ?>" href="javascript:void(0)" onclick="remove_hotelitems(<?php echo $val['id']?>, 'hotelRoom', <?php echo $countDiv;?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
								<?php	
									}
										
								?>
								<div class="col-sm-10 col-md-offset-2">
									<div class="pull-left">
										<div id="hotel_images_<?php echo $i;?>" class="pull-left">
								<?php
									$editImgSrt = '';
									$editImgId  = '';
									foreach($roomImages as $k=>$value)
									{
										$editImgSrt .= $value['image'].',';
										$editImgId .= $value['id'].',';
										
										if($value['image'] != '')
										{
								?>	
								
										<img src="document/hotel_doc/hotel_room_pic/<?php echo $value['image']; ?>" data-img="document/hotel_doc/hotel_room_pic/<?php ?>" alt="" class="superbox-img images" style="width:85px;height:85px;margin:10px;" id="delete_full_img_<?php echo $value['id']; ?>">
										<img class="remove_img" id="delete_img_<?php echo $value['id'];?>" src="document/hotel_doc/hotel_room_pic/x.png" relId="<?php echo $value['id'];?>" relImgId="<?php echo $value['image'];?>" relImgNum="<?php echo $countDiv;?>" alt="delete"/>
											
								<?php
										}
									}
									?>
									</div>
									<input type="hidden" name="roomImg[]" id="roomImg_<?php echo $countDiv;?>" value="<?php echo $editImgSrt;?>"/>
									<input type="hidden" name="roomPicId[]" id="roomPicId_<?php echo $countDiv;?>" value="<?php echo $editImgId;?>"/>
									</div>
								</div>
									<?php
									}
								?>
								<div class="col-md-1 pull-right">
									<div class="form-group text-right">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add More Rooms" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>	
								<?php	
									}
									else
									{
								?>
										
								<div style="clear:both;"></div>	
								<div id="address2_1">
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	Rooms </b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<input type="hidden" name="hotelRoomSerDetail[]" value="0"/>
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="roomstype">Room Type</label>-->
										<input type="text" class="form-control" name="roomstype[]"id="hotel_roomstype" placeholder="Room Type" value=""/>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="RDescription">Room Description</label>-->
										<input type="text" class="form-control" name="RDescription[]" id="RDescription" placeholder="Room Description" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								<div class="col-md-1">
										<button type="button" class="btn btn-primary roomAmenities" name="roomAmenities[]" id="roomAmenities" onclick="room_modal('1');">
								Select</button>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<!--<label for="AminitiesF">Aminities & Facilities</label>-->
										<input type="text" class="form-control AminitiesF_1" name="AminitiesF[]" id="AminitiesF_1" placeholder="Amenities & Facilities" value=""/>
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
										<label class="btn-bs-file btn btn-md btn-primary">
									Choose File
										<input type="file" class="form-control roomPics" name="Pics[]" id="Pics_1" rel="1" placeholder="Pics" value="" multiple />
										<input type="hidden" name="roomImg[]" id="roomImg_1" value=""/>
									</label>
										
									</div>
								</div>
								<div class="col-sm-10 col-md-offset-2">
									<div class="pull-left">
										<div id="hotel_images_1" class="pull-left">
											
										</div>
									</div>
								</div>
								</div>
						
								<div class="col-md-1 pull-right">
									<div class="form-group text-right">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add More Rooms" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								
								<?php
									}
								?>
							</div>
							<div style="clear:both;"></div>	
							<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Hotel Type</b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Hotel type</label>-->
										<select class="form-control" name="hotel_type" id="hotel_type">
										<option value="">Select</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Hotel'){echo "selected";}?>>Hotel</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Resort'){echo "selected";}?>>Resort</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Motel'){echo "selected";}?>> Motel</option>
										<option <?php if(@$hotelData['hotel_type'] == 'BnB'){echo "selected";}?>>BnB</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Homestay'){echo "selected";}?>>Homestay</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Tent'){echo "selected";}?>>Tent</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Service Apartment'){echo "selected";}?>>Service Apartment</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Bungalow'){echo "selected";}?>>Bungalow</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Lodge'){echo "selected";}?>>Lodge</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Guest House'){echo "selected";}?>>Guest House</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Hostel'){echo "selected";}?>>Hostel</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Cottage'){echo "selected";}?>>Cottage</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Houseboat'){echo "selected";}?>>Houseboat</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Villa'){echo "selected";}?>> Villa</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Palace'){echo "selected";}?>>Palace</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Beach Hut'){echo "selected";}?>>Beach Hut</option>
										<option <?php if(@$hotelData['hotel_type'] == 'Farm'){echo "selected";}?>> Farm</option>
										</select>
									</div>
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
										<select class="form-control" name="hotel_currency" id="hotel_currency">
										<option value="">Select</option>
										<option <?php if(@$hotelData['base_currency'] == 'USD'){echo "selected";}?>>USD </option>
										<option <?php if(@$hotelData['base_currency'] == 'INR'){echo "selected";}?>>INR </option>
										<option <?php if(@$hotelData['base_currency'] == 'EUR'){echo "selected";}?>>EUR </option>
										<option <?php if(@$hotelData['base_currency'] == 'JPY'){echo "selected";}?>>JPY </option>
										<option <?php if(@$hotelData['base_currency'] == 'GBP'){echo "selected";}?>>GBP</option>
										<option <?php if(@$hotelData['base_currency'] == 'AUD'){echo "selected";}?>>AUD</option>
										<option <?php if(@$hotelData['base_currency'] == 'CHF'){echo "selected";}?>>CHF</option>
										<option <?php if(@$hotelData['base_currency'] == 'CAD'){echo "selected";}?>>CAD</option>
										<option <?php if(@$hotelData['base_currency'] == 'MXN'){echo "selected";}?>>MXN</option>
										<option <?php if(@$hotelData['base_currency'] == 'CNY'){echo "selected";}?>>CNY</option>
										<option <?php if(@$hotelData['base_currency'] == 'NZD'){echo "selected";}?>>NZD</option>
										<option <?php if(@$hotelData['base_currency'] == 'SEK'){echo "selected";}?>>SEK</option>
										<option <?php if(@$hotelData['base_currency'] == 'RUB'){echo "selected";}?>>RUB</option>
										<option <?php if(@$hotelData['base_currency'] == 'HKD'){echo "selected";}?>>HKD</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Star Rating</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="userPhone">Star Rating </label>-->
										<select class="form-control" name="hotel_star" id="hotel_star">
										<option value="">No Star</option>
										<option <?php if(@$hotelData['star_rating'] == '1'){echo "selected";}?>>1</option>
										<option <?php if(@$hotelData['star_rating'] == '2'){echo "selected";}?>>2</option>
										<option <?php if(@$hotelData['star_rating'] == '3'){echo "selected";}?>>3</option>
										<option <?php if(@$hotelData['star_rating'] == '4'){echo "selected";}?>>4</option>
										<option <?php if(@$hotelData['star_rating'] == '5'){echo "selected";}?>>5</option>
										
										</select>
									</div>
								</div>
								
								
										
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Check in Time </b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<!--<div class="form-group">
										<div class="form-group">
										<div class='input-group date' >
										<input type='text' class="form-control" name="checkInDate" id="checkInDate" value="<?php echo date('j M Y',strtotime(@$hotelData['checkin_time']));?>"/>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										</div>
									</div>
									</div>-->
									<div class="bootstrap-timepicker">
										<div class="form-group">
										  <div class="input-group">
											<input type="text" name="checkInTime" id="checkInTime" class="form-control timepicker htimepicker" value="<?php if(!@$checkin_time){echo '12:00 PM'; }else{echo $checkin_time;} ?>"/>
											<div class="input-group-addon">
											  <i class="fa fa-clock-o"></i>
											</div>
										  </div><!-- /.input group-->
										</div>
									</div>
								</div>
							
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Check out time </b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<!--<div class="form-group">
										<div class="form-group">
										<div class='input-group date' >
										<input type='text' class="form-control"  name="checkOutdate" id="checkOutdate" value="<?php echo date('j M Y',strtotime(@$hotelData['checkout_time']));?>"/>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										</div>
									</div>
									</div>-->
									<div class="bootstrap-timepicker">
										<div class="form-group">
										  <div class="input-group">
											<input type="text" name="checkOutTime" id="checkOutTime" class="form-control timepicker htimepicker" value="<?php if(!@$checkout_time){echo '10:00 AM'; }else{echo $checkout_time;} ?>"/>
											<div class="input-group-addon">
											  <i class="fa fa-clock-o"></i>
											</div>
										  </div><!-- /.input group-->
										</div>
									</div>
								</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Amenity & Facility</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="row">
										<div class="col-md-2">
											<button type="button" class="btn btn-primary" name="hotelAmenities" id="hotelAmenities" onclick="hotel_amenity_modal();"/>
									Hotel Amenities</button>
										</div>
										<div class="col-md-10">
											<input type="text" class="form-control" name="Aminities" id="Aminities" placeholder="Amenities & Facilities" value="<?php echo $hotelData['hotel_amenity'];?>"/>
										</div>
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
							<!--<div class="items6">
								<?php
									if($countAmntiFacility>0)
									{
										$countDiv=1;
										foreach($aminities_facilites as $key=>$val)
										{
								?>
								<div id="Aminities_<?php echo $countDiv;?>">
								<?php
									if($countDiv > 1)
									{
								?>
									<div class="col-md-2"><div class="form-group"></div></div>
								<?php	
									}	
								?>
								<input type="hidden" name="amiFacility[]" value="<?php echo @$val['id'];?>"/>
									<div class="col-md-9">
										<div class="form-group">
											
											<input type="text" class="form-control" name="Aminities[]" id="Aminities" placeholder="Amenities & Facilities" value="<?php echo $val['aminities_facilites']; ?>"/>
										</div>
									</div>
								</div>
								<?php
									if($countDiv == 1)
									{
								?>
								<div class="col-md-1">
									<div class="form-group">
										
										<a href="javascript:void(0);" class="add_more_items2" id="add_more_items2" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
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
								<div id="Aminities_1">
								<input type="hidden" name="amiFacility[]" value="0"/>
								<div class="col-md-9">
									<div class="form-group">
										
										<input type="text" class="form-control" name="Aminities[]" id="Aminities" placeholder="Amenities & Facilities" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								</div>
								
									
								<div class="col-md-1">
									<div class="form-group">
										
										<a href="javascript:void(0);" class="add_more_items2" id="add_more_items2" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php
									}
								?>
							</div>-->
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Description</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
										
										<textarea type='text' class="form-control"  name="hotel_description" id="hotel_description"><?php echo @$hotelData['description'];?></textarea>
										
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

					<form role="form" method="POST" name="hotel_more_detail" id="hotel_more_detail">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
						<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
						<input type="hidden" name="type" value="add_hotel_more_detail" />
						<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
						<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
						<div class="box-body">
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	 Hotel ID </b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="name"> Transporter ID</label>-->
										<input type="text" class="form-control" name="transporter_id" id="transporter_id" placeholder="Hotel ID" value="<?php echo $autohotelId; ?>" readonly />
									</div>
								</div><!-- /.form-group -->
								
								<!-- /.first line -->
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Concerned Person</b><span style="color:red;">*</span></h4>
									</div>
								</div>
							<div class="col-md-10" style="padding:0;">	
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
									
								<?php	
								}	
								?>
								<div class="clearfix"></div>
								<input type="hidden" name="concPrsnid[]" value="<?php echo @$val['id'];?>"/>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="title">Title</label>-->
											<select class="form-control" name="title[]">
											<option value="">Select</option>
											<option value="Mr." <?php if($val['title'] == 'Mr.'){echo "selected";}?>>Mr.</option>
											<option value="Miss." <?php if($val['title'] == 'Miss.'){echo "selected";}?>>Miss.</option>
											<option value="Mrs." <?php if($val['title'] == 'Mrs.'){echo "selected";}?>>Mrs.</option>
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="firstname">First Name</label>-->
											<input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value="<?php echo @$val['first_name'];?>"/>
										</div>
									</div><!-- /.form-group -->
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="middle">Middle Name</label>-->
											<input type="text" class="form-control" name="middlename[]" id="middlename" placeholder="Middle Name" value="<?php echo @$val['middlename'];?>"/>
										</div>
									</div><!-- /.form-group -->
									<div class="col-md-2">
										<div class="form-group">
											<!--<label for="last">Last Name</label>-->
											<input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value="<?php echo @$val['lastname'];?>"/>
										</div>
									</div>
									<?php 
									if($countDiv==1)
									{									
									}
									else
									{
									?>
										<div class="col-md-1"> <div class="form-group"><a class="delete" rel="2" href="javascript:void(0)" onclick="remove_item6(<?php echo $countDiv; ?>, <?php echo @$val['id'];?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
									<?php	
									}
									?>
								</div>
								<?php
									//echo '';
								$countDiv++;
									}
								?>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="add_more_item" id="add_more_item" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php	
								}
								else
								{
								?>
								<div id="person_1">
								<input type="hidden" name="concPrsnid[]" value="0"/>
									<div class="col-md-3">
										<div class="form-group">
											<!--<label for="title">Title</label>-->
											<select class="form-control" name="title[]">
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
							</div>
							<div style="clear:both"></div>
							<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Contact Nos</b><span style="color:red;">*</span></h4>
									</div>
							</div>
							<div class="col-md-10" style="padding:0">
								<div class="cont">
								<?php
									if($countConcPrsnNum>0)
									{
										$countDiv=1;
										foreach($concern_person_numbers as $key=>$val)
										{
								?>
								
								<div id="connumbbr_<?php echo $countDiv;?>">
								<?php
								if($countDiv > 1)
								{
								?>
									<!--<div class="col-md-2"><div class="form-group"></div></div>-->
								<?php	
								}	
								?>
								<div class="clearfix"></div>
								<input type="hidden" name="concPrsnNumId[]" value="<?php echo @$val['id'];?>"/>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="userPhone">Mobile</label>-->
										<input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo @$val['contact_no']; ?>"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<!--<label for="middle">Code</label>-->
										<select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false">
											<option value="">Select</option>
											<option value="Mobile" <?php if(@$val['code'] == 'Mobile'){echo "selected";}?>>Mobile</option>
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
								
								<div class="col-md-3 v_hidden">
									<div class="form-group">
										<!--<label for="last">Enter valid Number</label>-->
										<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
									</div>
								</div>
								<?php 
									if($countDiv==1)
									{
								?>
								
								<?php
									}
									else
									{
								?>
								<div class="col-md-1"> <div class="form-group"><a id="hotel_concern_person_<?php echo @$val['id'];?>" class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_hotelitems(<?php echo @$val['id'];?>, 'hotel_concern_person', <?php echo $countDiv; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
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
										<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add More Contact Nos." style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<div class="clearfix"></div>	
								<?php	
									}
									else
									{
								?>
								<div id="connumbbr_1">
								<input type="hidden" name="concPrsnNumId[]" value="0"/>
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
										<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
									</div>
								</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<!--<label for="last">Add More</label>-->
										<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add More Contact Nos." style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php
									}
								?>
								</div>
								</div>
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Email </b><span style="color:red;">*</span></h4>
								</div>
							</div>
							<div class="col-md-10" style="padding:0">
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
										<input type="email" class="form-control" name="userEmail[]" id="" placeholder="Email" value="<?php echo $arrEmail[$i];?>" />
									</div>
								</div>
								<?php
									if($countDiv==1)
									{
									}
									else
									{
								?>
								<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_item1(<?php echo $countDiv; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
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
										<a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								<?php	
									}
									else
									{
								?>
								<div id="Email_1" >
								<div class="col-md-9">
									<div class="form-group">
										<!--<label for="userEmail" >Email</label>-->
										<input type="email" class="form-control" name="userEmail[]" id="" placeholder="Email" value="" />
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
								</div>
							
							<!--<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">User ID</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="userPhone">User ID</label>
										<input type="text" class="form-control" name="hote_user_id" id="hote_user_id" placeholder="User ID" value="<?php echo @$hotelData['hotel_user_id'];?>"/>
									</div>
								</div>-->
							   <div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Password</b><span style="color:red;">*</span></h4>
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<!--<label for="userPhone">Password</label>-->
										<input type="text" class="form-control" name="hotel_pass" id="hotel_pass" placeholder="Password" value="<?php echo @$hotelData['hotel_user_pass'];?>"/>
									</div>
								</div>	
								
							</div>
						</div>
						<div class="box-footer">
							<?php if($showPrevBtn){?>
							<a href="<?php echo $tabUrl.base64_encode($tab-1); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
							<?php
							}
							?>
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Next</button>
						</div>
					</form>
				
				
				</div>
					<div id="menu2" class="tab-pane fade <?php if($tab == 3){ echo 'in active';}?>">
					<form role="form" method="POST" name="hotel_bank_detail" id="hotel_bank_detail">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
						<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
						<input type="hidden" name="type" value="add_hotel_bank_detail" />
						<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
						<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
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
										<input type="text" class="form-control " name="hotel_pan_no" id="hotel_pan_no" placeholder="PAN No." value="<?php echo @$hotelData['pancard_no'];?>"/>
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
										<input type="text" class="form-control " name="hotel_account_no" id="hotel_account_no" placeholder="Account No." value="<?php echo @$hotelData['account_no'];?>"/>
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
										<input type="text" class="form-control " name="hotel_account_name" id="hotel_account_name" placeholder="Account Name" value="<?php echo @$hotelData['account_name'];?>"/>
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
										<input type="text" class="form-control " name="hotel_bank" id="hotel_bank" placeholder="Bank" value="<?php echo @$hotelData['bank_name'];?>"/>
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
										<input type="text" class="form-control " name="hotel_branch" id="hotel_branch" placeholder="Branch" value="<?php echo @$hotelData['branch_name'];?>"/>
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
										<input type="text" class="form-control " name="hotel_ifsc" id="hotel_ifsc" placeholder="IFSC" value="<?php echo @$hotelData['ifsc_code'];?>"/>
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
					<div id="menu3" class="tab-pane fade <?php if($tab == 4){ echo 'in active';}?>">
					  <div style="display:none;" id="me1"><img src="tenor.gif" style="position:absolute; top:70px; opacity:1; "/></div>
					<form role="form" method="POST" id="hotel_doc_detail" name="hotel_doc_detail" enctype = "multipart/form-data">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					  <input type="hidden" id="" name="hotl_id" value="<?php echo @$_GET['id'] ?>"> 
					 
					 
					 <?php
						$custDocs = count($docsCustArr);
						if($custDocs > 0){
							$conter = $custDocs+4;
						}
						else
						{
							$conter = 4;
						}
					 ?>
					 
					 <input type="hidden" name="totalFld" id="totalFld" value="<?php echo $conter; ?>"/>
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_hotel_doc_detail" />
					<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
						<div class="box-body">
							<div class="row">
								<div class="myattch">
									<div id="attch_1">
										<div style="clear:both;"></div>
										<input type="hidden" name="attachEdId[]" id="panCardId" value="<?php echo $attachdoc1[0]['id'];?>"/>
										<div class="col-md-2">
											<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	PAN Card </b></h4>
											<input type="hidden" name="docFileName[]" id="panCardFileName" value="PAN Card"/>
											</div>
										</div>
										<div class="col-md-10">
											<div class="col-md-4">
												<div class="form-group">
													<!--<label for="query_no">PAN Card</label>-->
													<label class="btn-bs-file btn btn-md btn-primary">
									                Choose File
													<input type="file" class="form-control" name="file_upload[]" id="hotel_pan_card_copy"  value="" multiple/>
													<input type="hidden" name="upldFileName[]" id="panCardDoc" class="Uplddoc_1" value="<?php echo $attachdoc1[0]['doc'];?>" />
												</label>
												</div>
											</div>
											<div class="col-md-5">
												<div id="panCardDocName"><span id="attdoc_1"><?php echo $attachdoc1[0]['doc'];?></span>
												
												<div id="panDocs"></div>
												</div>
											</div>
											<?php if($attachdoc1[0]['doc'] == ''){?>
											<div class="col-md-2 attach_new" style="display:none;">
												<div class="form-group">
													<a class="delete" href="javascript:void(0)" onclick="remove_attach1(1)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
												</div> 
											</div>
											<?php } ?>
											<?php if($attachdoc1[0]['doc'] != ''){?>
											<div class="col-md-2">
												<div class="form-group attach_newed">
													<a class="delete" relId="<?php echo @$attachdoc1[0]['id'];?>" rel="<?php echo $attachdoc1[0]['id'];?>" href="javascript:void(0)" onclick="remove_attach(1,'<?php echo @$attachdoc1[0]['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
												</div> 
											</div>
											<?php } ?>
										</div><!-- /.form-group -->
									</div>
									<div id="attch_2">
										<div style="clear:both;"></div>
										<input type="hidden" name="attachEdId[]" id="photoId" value="<?php echo $attachdoc2[0]['id'];?>"/>
										<div class="col-md-2">
											<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
											<input type="hidden" name="docFileName[]" id="photoFileName" value="Photo"/>
											</div>
										</div>
										<div class="col-md-10">
											<div class="col-md-4">
												<div class="form-group">
													<!--<label for="query_no">Photo</label>-->
													<label class="btn-bs-file btn btn-md btn-primary">
									                Choose File
													<input type="file" class="form-control" name="file_upload1[]" id="hote_photo_copy"  value="" multiple />
													<input type="hidden" name="upldFileName[]" id="photoDoc" class="Uplddoc_2" value="<?php echo $attachdoc2[0]['doc'];?>" />
												</label>
												</div>
											</div>
											<div class="col-md-5">
												<div id="photoDocName"><span id="attdoc_2"><?php echo $attachdoc2[0]['doc'];?></span>
												<div id="photoDocs"></div>
												</div>
											</div>
												<?php if($attachdoc2[0]['doc'] == ''){?>
											<div class="col-md-2 attach_new1" style="display:none;">
												<div class="form-group">
													<a class="delete" href="javascript:void(0)" onclick="remove_attach1(2)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
												</div> 
											</div>
											<?php } ?>
											<?php if($attachdoc2[0]['doc'] != ''){?>
											<div class="col-md-2 attach_newed1">
												<div class="form-group">
													<a class="delete" relId="<?php echo @$attachdoc2[0]['id'];?>" rel="<?php echo $attachdoc2[0]['id'];?>" href="javascript:void(0)" onclick="remove_attach(2,'<?php echo @$attachdoc2[0]['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
												</div> 
											</div>
											<?php } ?>
										</div><!-- /.form-group -->
									</div>
									
									<div id="attch_3">
										<div style="clear:both;"></div>
										<input type="hidden" name="attachEdId[]" id="addrProofId" value="<?php echo $attachdoc3[0]['id'];?>"/>
										<div class="col-md-2">
											<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">Contract</b></h4>
											<input type="hidden" name="docFileName[]" id="contractFileName" value="Contract"/>
											</div>
										</div>
										<div class="col-md-10">
											<div class="col-md-4">
											<div class="form-group">
												<!--<label for="query_no">Contract</label>-->
												<label class="btn-bs-file btn btn-md btn-primary">
									            Choose File
												<input type="file" class="form-control" name="file_upload2[]" id="hotel_Contract_copy" multiple  value=""/>
												<input type="hidden" name="upldFileName[]" id="contCopyDoc" class="Uplddoc_3" value="<?php echo $attachdoc3[0]['doc'];?>" />
											</label>
											</div>
											</div>
											<div class="col-md-5">
											<div id="contCopyDocName"><span id="attdoc_3"><?php echo $attachdoc3[0]['doc'];?></span>
												<div id="contactDocs"></div>
											</div>
											</div>
											<?php if($attachdoc3[0]['doc'] == ''){?>
											<div class="col-md-2 attach_new2" style="display:none;">
												<div class="form-group">
													<a class="delete"  onclick="remove_attach1(3)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
												</div> 
											</div>
											<?php } ?>
											<?php if($attachdoc3[0]['doc'] != ''){?>
											<div class="col-md-2">
												<div class="form-group attach_newed2">
													<a class="delete" relId="<?php echo @$attachdoc3[0]['id'];?>" rel="<?php echo $attachdoc3[0]['id'];?>" href="javascript:void(0)" onclick="remove_attach(3,'<?php echo @$attachdoc3[0]['id'];?>','static')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
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
											$countAttach=4;
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
												<input class="file_upload" id="add_more_file_<?php echo $countAttach;?>" name="file_upload3[]" type="file" multiple>
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
						<div class="box-footer">
							<?php if($showPrevBtn){?>
							<a href="<?php echo $tabUrl.base64_encode($tab-1); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
							<?php } ?>
							<button type="button" class="btn btn-primary" name="hotel_doc_detail_btn" id="hotel_doc_detail_btn" id="submit">Next</button>
						</div>
					</form>		
					</div>
				
			    <div id="menu5" class="tab-pane fade <?php if($tab == 6){ echo 'in active';}?>">
			   
				<form role="form" method="POST" id="hotel_photos_frm" name="hotel_photos_frm" enctype = "multipart/form-data">
				
				<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
				<input type="hidden" name="type" value="add_hotel_photos" />
				<input type="hidden" name="hotel_id" value="<?php echo $hotelIdProcess; ?>" />
				
                        
                         
                   
					  
					<div class="box-body">
						<div class="row">
							<div class="myattch">
								<div id="attch_2">
									<div class="col-md-2">
										<div class="form-group" id="hotelPhotosHidden">
											<h4  class="box-title"><b style="font-size: 17px;">	Photos</b></h4>
											 <div style="display:none;" id="me2"><img src="tenor.gif" style="position:absolute; top:70px; opacity:1;"/></div>
										<?php
											$photosData = json_decode($hotelData['hotel_photos']);
											//print_r($photosData);
											if(count($photosData))
											{
												$pics = '';
												foreach($photosData as $key=>$photos)
												{
													$keyArr = explode('_',$key);
													$caption = $key;
													if($keyArr[0] == 'not')
													{
														$caption = '';
													}
													
													$nameArr = explode('.',$photos);
													$name = $nameArr[0];
													
												$pics .= '<div class="col-md-3 hpBox" id="hpicsmain_'.$name.'"><img alt="Hotel Image" class="superbox-img" src="document/hotel_doc/hotel_pics/'.$photos.'" id="hpic_'.$name.'" rel="'.$name.'" style="width:81%;height:85px;margin:10px;padding: 10px"><img class="delHotelImg delPhotoImg" id="p_'.$name.'" src="document/hotel_doc/hotel_room_pic/x.png" relid="'.$name.'" alt="delete"><input type="text" name="hImage[]" value="'.$caption.'" placeholder="Image Caption" style="width: 100%;"></div>';	
												
											?>
												<input id="hid_<?php echo $name; ?>" type="hidden" name="hPhotos[]" value="<?php echo $photos; ?>">
											<?php	
												}	
											}
										?>
										</div>
									</div>
									 
									<div class="col-md-10">
										<div class="col-md-3">
											<div class="form-group">
												<label class="btn-bs-file btn btn-md btn-primary">
									            Choose File
												
												  <input type="file" name="images[]" id="select_image" multiple /> 
												</label>
												  
												<!--<input type="file" class="form-control" name="file_upload[]" id="hote_photos"  value=""/>
												<input type="hidden" name="upldFileName[]" id="hUplodedPhotos" value="<?php echo $photoAttach;?>" />-->
											</div>
										</div>
										<div class="col-md-9">
											<div id="viewHotelPics">
											
											<div id="currentUploaded"></div>
											
											<?php echo $pics; ?>
											</div>
										</div>
									</div><!-- /.form-group -->
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<?php if($showPrevBtn){?>
						<a href="<?php echo $tabUrl.base64_encode(4); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
						<?php } ?>
						<button type="button" class="btn btn-primary" name="hotel_photos_btn" id="hotel_photos_btn" id="submit">Next</button>
					</div>
				</form>		
			</div>
				
<?php
			$t1=base64_decode($_GET['t']);
			if($t1==5)
			{
				//echo $countRoomDetail;exit;
			?>
			 
			<div class="col-md-12 col-sm-12" style="padding-left:0px; padding-right:0px;">
					
					
					<?php
						if(isset($countRoomDetail) && !empty($countRoomDetail)){ $rd = $countRoomDetail;}else{$rd = $countRooms;}
						$hidden .= '<input type="hidden" name="ttlRoomService" id="ttlRoomService" value="'.$rd.'"/>';
						
						if($_GET['action'] == 'edit'){$rn = $countRoomName;}else{$rn = $countRoomNameId;}
						$hidden .= '<input type="hidden" id="room_count" name="room_count" value="'.$rn.'">';
						
						echo $hidden;
					?>
					
					
                    					
					<input type="hidden" id="room_count" name="room_count" value="<?php if($_GET['action'] == 'edit'){echo $countRoomName;}else{echo $countRoomNameId;}?>"> 
					<input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countEditRooms;}else{echo $countRooms;}?>"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_hotel_rates_detail" />
					<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					
					<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
	<div class="box-body">					
		<div class="" >	
			<div class="rate">
				<?php
				$item=1;
				//echo $countDateRates;
					$roomNamesMaster = array('Single', 'Double', 'Extra Adult', 'Extra Child w/o Bed', 'Extra Child with Bed', 'Extra Breakfast', 'Lunch', 'Dinner');
					if($countDateRates>0)
					{
						for($j=1;$j<=$countDateRates;$j++)
						{
							$dateId=$date_rates_detail[$j-1]['id'];
							$arrTotalRoom=$objhotel->getAllHotelRoom_edit($editHotelId,$dateId);
							//echo 'ppppppppp:'; print_r($arrTotalRoom);
							$countTtlRoom = count($arrTotalRoom);
							
							$rClass = '';
							if($j > 1)
							{
								$rClass = 'rateRow';
							}
				?> 
				<form role="form" method="POST" name="hotel_rate" id="hotel_rate1_<?php echo $j;?>">
					<input type="hidden" id="item_count10" name="item_count10" value="<?php if(isset($countTtlRoom)&& !empty($countTtlRoom)){echo $countTtlRoom;}else{echo 8;}?>">
					<div class="hiddenFields">
						
					</div>
				   <input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					<input type="hidden" name="type" value="add_hotel_rates_detail" />	
					<input type="hidden" name="update" value="1" />	
				<div id="rates_<?php echo $j;?>" class="<?php echo $rClass; ?>">
					
					<div class="col-md-1">
						<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
						</div>
					</div>
					<div class="col-md-3" >
						<div class="form-group">
							<label for="search">Meal Plan</label>
							<input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countEditRooms;}else{echo $countRooms;}?>">
							<input type="hidden" name="editid" value="<?php echo $j; ?>" >
							<select class="form-control" name="mealPlan_<?php echo $j; ?>" readonly>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 1){?>
								 <option value="1" <?php if($date_rates_detail[$j-1]['meal_plan'] == 1){echo 'selected';}?>>CP (Breakfast)</option>
						       <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 2){?>
								<option value="2" <?php if($date_rates_detail[$j-1]['meal_plan'] == 2){echo 'selected';}?>>MAP (Breakfast+Dinner)</option>
							   <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 3){?>
								<option value="3" <?php if($date_rates_detail[$j-1]['meal_plan'] == 3){echo 'selected';}?>>AP (Breakfast+Lunch+Dinner)</option>
							   <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 4){?>
								<option value="4" <?php if($date_rates_detail[$j-1]['meal_plan'] == 4){echo 'selected';}?>>EP (Room Only)</option>
							   <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 5){?>
								<option value="5" <?php if($date_rates_detail[$j-1]['meal_plan'] == 5){echo 'selected';}?>>CP Package</option>
							   <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 6){?>
								<option value="6" <?php if($date_rates_detail[$j-1]['meal_plan'] == 6){echo 'selected';}?>>MAP Package</option>
							   <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 7){?>
								<option value="7" <?php if($date_rates_detail[$j-1]['meal_plan'] == 7){echo 'selected';}?>>AP Package</option>
							   <?php } ?>
							   <?php if($date_rates_detail[$j-1]['meal_plan'] == 8){?>
								<option value="8" <?php if($date_rates_detail[$j-1]['meal_plan'] == 8){echo 'selected';}?>>EP Package</option>
							   <?php } ?>
							</select>
						</div>						
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="search">From:Date</label>
							<input type="text" class="form-control fromdate" name="fromdate_<?php echo $j;?>" id="fromdate" placeholder="Name" readonly  value="<?php echo date('j M Y',strtotime($date_rates_detail[$j-1]['from_date'])); ?>"/>
						</div>						
					</div>
					<input type="hidden" name="date_id_<?php echo $j;?>" value="<?php echo $date_rates_detail[$j-1]['id'];?>"/>
					<div class="col-md-3">
						<div class="form-group">
							<label for="search">To:Date</label>
							<input readonly type="text" class="form-control todate" name="todate_<?php echo $j;?>" id="todate" placeholder="Name" value="<?php echo date('j M Y',strtotime($date_rates_detail[$j-1]['to_date'])); ?>"/>
							
						</div>						
					</div>
					
					<div class="col-md-2">
						<div class="form-group">
							<label for="search">&nbsp;</label><br/>
							<button type="button" class="btn btn-md btn-primary showRtable" rel="<?php echo $j;?>">Show</button>
						</div>
					</div>
					<?php
					if($item > 1){
					?>
					<!--<div class="col-md-2 text-right"> <div class="form-group" style="margin: 28px 0 10px;"><label for="last">Remove</label>  <a class="delete" rel="<?php echo $item; ?>" href="javascript:void(0)" onclick="remove_rate(<?php echo $item; ?>,<?php echo $dateId; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>-->
					<?php } ?>
					<div class="bs-example col-md-12" >
					<div class="table-responsive rateTables" id="tblR_<?php echo $j;?>">
						<table class="table">
							<?php
							$totalRows = 8;
							//echo $countEditRooms;
							if($countEditRooms>0)
							{
							?>
							<thead>											
								<tr>
									
									<th></th>
									<?php
										//print_r($arrRooms);
										//echo '<br/><br/><br/>';
										//echo 'dit:::'; print_r($editArrRooms);
										$ratesArr = array();
										$ratesArrExtra = array();
										$extraRoomName = array();
										foreach($editArrRooms as $key=>$val)
										{
											
											$hotel_room_id=$val['id'];
											$hotel_rates_detail=$objhotel->getHotelRatesByid($hotelData['hotel_id'],$dateId,$hotel_room_id);
											$countHotelRates=count($hotel_rates_detail);
											//echo '<br/><br/><br/>';
											//echo 'rates:::'; print_r($hotel_rates_detail);
											
											foreach($hotel_rates_detail as $rates)
											{
												if(in_array($rates['room_name'], $roomNamesMaster))
												{
													$ratesArr[$rates['date_id']][$rates['room_type_id']][$rates['room_name']][] = $rates['price'];
													$ratesArr[$rates['date_id']][$rates['room_type_id']][$rates['room_name']][] = $rates['id'];
												}
												else
												{
													$ratesArrExtra[$rates['date_id']][$rates['room_type_id']][$rates['room_name']][] = $rates['price'];
													$ratesArrExtra[$rates['date_id']][$rates['room_type_id']][$rates['room_name']][] = $rates['id'];
													
													$extraRoomName[] = $rates['room_name'];
												}
												//$ratesArr[$rates['date_id']][$rates['room_type_id']][$rates['room_name'].'_rateId'] = $rates['id'];
											}
										$extraRoomName = array_unique($extraRoomName);
										
										/* echo '<br/><br/><br/>';	
										echo 'ratesCust:::'; print_r($ratesArr);	
										echo 'ratesCustOther:::'; print_r($ratesArrExtra);	
										echo '<br/>extraNames:::'; print_r($extraRoomName); */	
										
										
										
									?>
									<th style="width: 40px;"><?php echo $val['room_type'];?></th>
									<?php
										}
									
									?>
								</tr>
							</thead>
							
							<tbody border="1px">
							
								<tr>
								<?php
										$roomCount1=1;
								?>
									<td>Single <input type="hidden" name="roomName_<?php echo $j;?>_1_<?php echo $roomCount1;?>" value="<?php echo $singleRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_1_<?php echo $roomCount1;?>" value="Single"/></td>
								<?php
										
										//echo '<br/><br/><br/>';	
										//echo 'ratesCust:::'; print_r($ratesArr);
										//echo 'roomArr:::'; print_r($arrRooms);
										$hotelRmRate = '';
										foreach($arrRooms as $key1=>$val1)
										{
											$roomCount1++;	
											
											$hotelRmRate = $ratesArr[$dateId][$val1['id']]['Single'][0];
											$hotelRmRateId = $ratesArr[$dateId][$val1['id']]['Single'][1];
											
											//$hotelRmRate = $ratesArr[$dateId][$val1['id']]['Single_rateId']
								?>
									<td>
									
									<input type="text" name="roomType_<?php echo $j;?>_1_<?php echo $roomCount1;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_1_<?php echo $roomCount1;?>" value="<?php echo $val1['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_1_<?php echo $roomCount1;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
									
								<?php
										}
									?>
									<td rowspan="8"> <textarea class="rateDesc" name="description_<?php echo $item; ?>" rows="17" cols="21"><?php echo $date_rates_detail[$j-1]['description'];?></textarea>  </td>
								</tr>
								<tr>
									<?php
										$roomCount2=1;
									?>
										<td>Double <input type="hidden" name="roomName_<?php echo $j;?>_2_<?php echo $roomCount2;?>" value="<?php echo $doubRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_2_<?php echo $roomCount2;?>" value="Double"/></td>
									<?php
										$hotelRmRate = 0;
										foreach($arrRooms as $key2=>$val2)
										{
											$roomCount2++;
											$hotelRmRate = $ratesArr[$dateId][$val2['id']]['Double'][0];
											$hotelRmRateId = $ratesArr[$dateId][$val2['id']]['Double'][1];
									?>
									<td>
									<input type="text"  name ="roomType_<?php echo $j;?>_2_<?php echo $roomCount2;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_2_<?php echo $roomCount2;?>" value="<?php echo $val2['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_2_<?php echo $roomCount2;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>		
									<?php
										}
									?>
								</tr>
								<tr>
								<?php
									
										$roomCount3=1;
								?>
									<td>Extra Adult  <input type="hidden" name="roomName_<?php echo $j;?>_3_<?php echo $roomCount3;?>" value="<?php echo $extAdltRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_3_<?php echo $roomCount3;?>" value="Extra Adult"/></td>
								<?php
										$hotelRmRate = 0;
										foreach($arrRooms as $key3=>$val3)
										{
											$roomCount3++;
											
											$hotelRmRate = $ratesArr[$dateId][$val3['id']]['Extra Adult'][0];
											$hotelRmRateId = $ratesArr[$dateId][$val3['id']]['Extra Adult'][1];
									?>
									
									<td>
									<input type="text" name ="roomType_<?php echo $j;?>_3_<?php echo $roomCount3;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_3_<?php echo $roomCount3;?>" value="<?php echo $val3['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_3_<?php echo $roomCount3;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
								<?php
										}
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount4=1;
								?>
									<td>Extra Child w/o Bed  <input type="hidden" name="roomName_<?php echo $j;?>_4_<?php echo $roomCount4;?>" value="<?php echo $extChldWoBedRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_4_<?php echo $roomCount4;?>" value="Extra Child w/o Bed"/></td>
								<?php
									$hotelRmRate = 0;
									foreach($arrRooms as $key4=>$val4)
									{
										$roomCount4++;
										$hotelRmRate = $ratesArr[$dateId][$val4['id']]['Extra Child w/o Bed'][0];
										$hotelRmRateId = $ratesArr[$dateId][$val4['id']]['Extra Child w/o Bed'][1];
								?>
									
									<td>
									<input type="text" name="roomType_<?php echo $j;?>_4_<?php echo $roomCount4;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_4_<?php echo $roomCount4;?>" value="<?php echo $val4['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_4_<?php echo $roomCount4;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
								<?php
									}
								
								
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount5=1;
								?>
									<td>Extra Child with Bed <input type="hidden" name="roomName_<?php echo $j;?>_5_<?php echo $roomCount5;?>" value="<?php echo $extChldWBedRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_5_<?php echo $roomCount5;?>" value="Extra Child with Bed"/></td>
								<?php
									$hotelRmRate = 0;
									foreach($arrRooms as $key5=>$val5)
									{
										$roomCount5++;
										
										$hotelRmRate = $ratesArr[$dateId][$val5['id']]['Extra Child with Bed'][0];
										$hotelRmRateId = $ratesArr[$dateId][$val5['id']]['Extra Child with Bed'][1];
								?>
									
									<td>
									<input type="text" name="roomType_<?php echo $j;?>_5_<?php echo $roomCount5;?>"  value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_5_<?php echo $roomCount5;?>" value="<?php echo $val5['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_5_<?php echo $roomCount5;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount6=1;
								?>
									<td>Extra Breakfast <input type="hidden" name="roomName_<?php echo $j;?>_6_<?php echo $roomCount6;?>" value="<?php echo $extBrkFastRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_6_<?php echo $roomCount6;?>" value="Extra Breakfast"/></td>
								<?php
									$hotelRmRate = 0;
									foreach($arrRooms as $key6=>$val6)
									{
										$roomCount6++;
										
										$hotelRmRate = $ratesArr[$dateId][$val6['id']]['Extra Breakfast'][0];
										$hotelRmRateId = $ratesArr[$dateId][$val6['id']]['Extra Breakfast'][1];
								?>
									
									<td>
									<input type="text" name="roomType_<?php echo $j;?>_6_<?php echo $roomCount6;?>"  value="<?php echo $hotelRmRate; ?>" >
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_6_<?php echo $roomCount6;?>" value="<?php echo $val6['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_6_<?php echo $roomCount6;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
									$roomCount7=1;
								?>
									<td>Lunch <input type="hidden" name="roomName_<?php echo $j;?>_7_<?php echo $roomCount7;?>" value="<?php echo $lunchRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_7_<?php echo $roomCount7;?>" value="Lunch"/></td>
								<?php
									$hotelRmRate = 0;
									foreach($arrRooms as $key7=>$val7)
									{
										$roomCount7++;
										
										$hotelRmRate = $ratesArr[$dateId][$val7['id']]['Lunch'][0];
										$hotelRmRateId = $ratesArr[$dateId][$val7['id']]['Lunch'][1];
								?>
									
									<td>
									<input type="text" name="roomType_<?php echo $j;?>_7_<?php echo $roomCount7;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" name="roomTypeId_<?php echo $j;?>_7_<?php echo $roomCount7;?>" value="<?php echo $val7['id'];?>">
									<input type="hidden" name="hotelRateId_<?php echo $j;?>_7_<?php echo $roomCount7;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
								<?php
									}
								
								?>
								
								</tr>
								<tr>
								<?php
								
									$roomCount8=1;
								?>
									<td class="dinnerCol">Dinner <input type="hidden" name="roomName_<?php echo $j;?>_8_<?php echo $roomCount8;?>" value="<?php echo $dinnRoomId;?>"><input type="hidden" name="room_name_<?php echo $j;?>_8_<?php echo $roomCount8;?>" id="room_name_<?php echo $j;?>_8_<?php echo $roomCount8;?>" value="Dinner"/></td>
								<?php
									$hotelRmRate = 0;
									foreach($arrRooms as $key8=>$val8)
									{
										$roomCount8++;
										
										$hotelRmRate = $ratesArr[$dateId][$val8['id']]['Dinner'][0];
										$hotelRmRateId = $ratesArr[$dateId][$val8['id']]['Dinner'][1];
								?>
									
									<td>
									<input type="text" class="roomType_<?php echo $j;?>_<?php echo $roomCount8;?>" name="roomType_<?php echo $j;?>_8_<?php echo $roomCount8;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" class="roomTypeId_<?php echo $j;?>_<?php echo $roomCount8;?>" name="roomTypeId_<?php echo $j;?>_8_<?php echo $roomCount8;?>" value="<?php echo $val8['id'];?>">
									<input type="hidden" class="hotelRateId_<?php echo $j;?>_<?php echo $roomCount8;?>" name="hotelRateId_<?php echo $j;?>_8_<?php echo $roomCount8;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
								<?php
									}
								}
								
								?>
								</tr>
								
								<?php
									$countExtra = count($extraRoomName);
									$totalRows = $totalRows+$countExtra;
									//print_r($ratesArrExtra);
									//echo '</td></tr>';	
									if($countExtra)
									{
										$extraCount = 8;
										$e = 0;
										foreach($extraRoomName as $others)
										{	
											$extraCount++;
											$EroomName = $others;
											$e++;
											
											
								?>
								
								<tr id="r_<?php echo $j;?>_<?php echo $extraCount; ?>">
								<?php
									//print_r($ratesArrExtra);
									$roomCount8=1;
								?>
									<!--<td class="dinnerCol">Dinner <input type="hidden" name="roomName_1_8_<?php echo $roomCount8;?>" value="<?php echo $dinnRoomId;?>"><input type="hidden" name="room_name_1_8_<?php echo $roomCount8;?>" id="room_name_1_8_<?php echo $roomCount8;?>" value="Dinner"/></td>-->
									
									<td class="dinnerCol">
									
									<input type="text" name="roomType_<?php echo $j;?>_<?php echo $extraCount; ?>_1" value="<?php echo $EroomName; ?>" onblur="add_room_name(<?php echo $extraCount; ?>,$(this).val(),<?php echo $j;?>)"><input type="hidden" name="roomName_<?php echo $j;?>_<?php echo $extraCount; ?>_1" value="<?php echo $extraCount; ?>"><input type="hidden" name="room_name_<?php echo $j;?>_<?php echo $extraCount; ?>_1" id="room_name_<?php echo $j;?>_<?php echo $extraCount; ?>_1" value="<?php echo $EroomName; ?>"></td>
									
								<?php
									//print_r($arrRooms);
									$hotelRmRate = 0;
									$hotelRmRateId = 0;
									$hRAteIds = '';
									foreach($arrRooms as $otherKey=>$otherVal)
									{
										$roomCount8++;
										//echo $dateId.'=='.$otherVal['id'];
										$hotelRmRate = $ratesArrExtra[$dateId][$otherVal['id']][$others][0]; 
										$hotelRmRateId = $ratesArrExtra[$dateId][$otherVal['id']][$others][1]; 
										
										$hRAteIds .= $hotelRmRateId.',';
										
										/* print_r($extraRateArr);
										echo '<br/>';
										$extraName = key($extraRateArr);
										
										$rateArr = current($extraRateArr); */
										
										//$hotelRmRate = $extraRateArr[0];
										//$hotelRmRateId = $extraRateArr[1];
										
								?>
									<td>
									<input type="text" class="roomType_<?php echo $j;?>_<?php echo $roomCount8;?>" name="roomType_<?php echo $j;?>_<?php echo $extraCount; ?>_<?php echo $roomCount8;?>" value="<?php echo $hotelRmRate; ?>">
									<input type="hidden" class="roomTypeId_<?php echo $j;?>_<?php echo $roomCount8;?>" name="roomTypeId_<?php echo $j;?>_<?php echo $extraCount; ?>_<?php echo $roomCount8;?>" value="<?php echo $otherVal['id'];?>">
									<input type="hidden" class="hotelRateId_<?php echo $j;?>_<?php echo $roomCount8;?>" name="hotelRateId_<?php echo $j;?>_<?php echo $extraCount; ?>_<?php echo $roomCount8;?>" value="<?php echo $hotelRmRateId; ?>"/>
									</td>
									
								<?php
									}
								
								?>
								<td class="delRow">
									<a class="delete" rel="<?php echo rtrim($hRAteIds, ',');?>" href="javascript:void(0)" onclick="remove_rate_items('<?php echo rtrim($hRAteIds, ',');?>', '<?php echo $j;?>_<?php echo $extraCount; ?>')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a>
								</td>
								</tr>
								<?php
									}
									}
								?>
								
								<tr>
									<input type="hidden" id="tbl_<?php echo $j;?>_item_count10" name="tbl_<?php echo $j;?>_item_count10" value="<?php if($totalRows>8){echo $totalRows;}else{echo 8;}?>">

									<td><label for="last">Add More Rows</label>
									<a href="javascript:void(0);" class="add_more_row" id="add_more_row" relTbl="<?php echo $j;?>" rel="<?php echo $j; ?>" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a></td>
									<td></td>
								</tr>
								<?php
								if($item >= 1){
								?>
								<tr>
									<td colspan="15">
									<div class="col-md-12 text-right"> <div class="form-group"><label for="last">Remove Table</label>  <a class="delete" rel="<?php echo $item; ?>" href="javascript:void(0)" onclick="remove_rate(<?php echo $item; ?>,<?php echo $dateId; ?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							
						</table>
						<div class="footer" style="padding:10px 0 17px 0;">
							<!-- <?php if($showPrevBtn){?>
							<a href="<?php echo $tabUrl.base64_encode(6); ?>" class="btn btn-default" name="bottom"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a>
							<?php } ?> -->
							<input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRates>0){echo $countDateRates;}else{echo 1;}?>">
							<input type="hidden" name="editHotelId" id="editid" value="<?php echo $hotelData['hotel_id']; ?>"/>
							<button type="submit" class="btn btn-md btn-primary submit_rate_form1" name="hotel_rate1_<?php echo $j; ?>" id="submit" rel="<?php echo $j;?>">Save</button>
						</div>
						</div>
					</div>
				</div>
					
				</form>
				
				<?php
					$item++;	
						}	
					?>
					
					<?php	
					}
					else
					{
				?>
			<!-- 	<form role="form" method="POST" name="hotel_rate_1" id="hotel_rate_1">
					<input type="hidden" name="ttlRoomService" id="ttlRoomService" value="<?php if(isset($countRoomDetail) && !empty($countRoomDetail)){echo $countRoomDetail;}else{echo $countRooms;}?>"/>
					<input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRates>0){echo $countDateRates;}else{echo 1;}?>">
					<input type="hidden" id="item_count10" name="item_count10" value="<?php if(isset($countTtlRoom)&& !empty($countTtlRoom)){echo $countTtlRoom;}else{echo 8;}?>"> 	
					<input type="hidden" id="room_count" name="room_count" value="<?php if($_GET['action'] == 'edit'){echo $countRoomName;}else{echo $countRoomNameId;}?>"> 
					<input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countEditRooms;}else{echo $countRooms;}?>"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_hotel_rates_detail" />
					<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
				<div id="rates_1">
					<input type="hidden" id="tbl_1_item_count10" name="tbl_1_item_count10" value="1">
					<div class="col-md-2">
						<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="search">From:Date</label>
							<input type="text" class="form-control fromdate" name="fromdate_1" id="" placeholder="Name" value="<?php echo date('d F Y');?>"/>
						</div>						
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="search">To:Date</label>
							<input type="text" class="form-control todate" name="todate_1" id="" placeholder="Name" value="<?php echo date('d F Y');?>"/>
						</div>						
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="search">Meal Plan</label>
							<select class="form-control" name="mealPlan_1">
								<option value="1">CP (Breakfast)</option>
								<option value="2">MAP (Breakfast+Dinner)</option>
								<option value="3">AP (Breakfast+Lunch+Dinner)</option>
								<option value="4">EP (Room Only)</option>
								<option value="5">CP Package</option>
								<option value="6">MAP Package</option>
								<option value="7">AP Package</option>
								<option value="8">EP Package</option>
							</select>
						</div>						
					</div>
					<div class="col-md-1">
				
					</div>
			
					<div class="bs-example col-md-12" >
						<div class="table-responsive">
						<table class="table">
							<thead>											
								<tr>
								<?php
									if($countRooms>0)
									{
								?>
								<th></th>
								<?php
										foreach($arrRooms as $key=>$val)
										{
								?>
									
									<th style="width: 40px;"><?php echo $val['room_type'];?></th>
								<?php
										}
									
								?>
								</tr>
							</thead>
							<tbody border="1px">
							
								<tr>
								<?php
										$roomCount1=1;
								?>
									<td>Single <input type="hidden" name="roomName_1_1_<?php echo $roomCount1;?>" value="<?php echo $singleRoomId;?>"><input type="hidden" name="room_name_1_1_<?php echo $roomCount1;?>" value="Single"/></td>
								<?php
										
										foreach($arrRooms as $key1=>$val1)
										{
										$roomCount1++;	
								?>
									<td>
									<input type="text" name="roomType_1_1_<?php echo $roomCount1;?>" value="">
									<input type="hidden" name="roomTypeId_1_1_<?php echo $roomCount1;?>" value="<?php echo $val1['id'];?>">
									<input type="hidden" name="hotelRateId_1_1_<?php echo $roomCount1;?>" value=""/>
									</td>
									
								<?php
										}
									?>
									<td rowspan="8"> <textarea class="rateDesc" name="description_1" rows="17" cols="21"> Description  </textarea>  </td>
								</tr>
								<tr>
									<?php
										$roomCount2=1;
									?>
										<td>Double <input type="hidden" name="roomName_1_2_<?php echo $roomCount2;?>" value="<?php echo $doubRoomId;?>"><input type="hidden" name="room_name_1_2_<?php echo $roomCount2;?>" value="Double"/></td>
									<?php
										
										foreach($arrRooms as $key2=>$val2)
										{
											$roomCount2++;
									?>
									<td>
									<input type="text"  name ="roomType_1_2_<?php echo $roomCount2;?>" value="">
									<input type="hidden" name="roomTypeId_1_2_<?php echo $roomCount2;?>" value="<?php echo $val2['id'];?>">
									<input type="hidden" name="hotelRateId_1_2_<?php echo $roomCount2;?>" value=""/>
									</td>		
									<?php
										}
									?>
								</tr>
								<tr>
								<?php
									
										$roomCount3=1;
								?>
									<td>Extra Adult  <input type="hidden" name="roomName_1_3_<?php echo $roomCount3;?>" value="<?php echo $extAdltRoomId;?>"><input type="hidden" name="room_name_1_3_<?php echo $roomCount3;?>" value="Extra Adult"/></td>
								<?php
										
										foreach($arrRooms as $key3=>$val3)
										{
											$roomCount3++;
									?>
									
									<td>
									<input type="text" name ="roomType_1_3_<?php echo $roomCount3;?>" value="">
									<input type="hidden" name="roomTypeId_1_3_<?php echo $roomCount3;?>" value="<?php echo $val3['id'];?>">
									<input type="hidden" name="hotelRateId_1_3_<?php echo $roomCount3;?>" value=""/>
									</td>
								<?php
										}
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount4=1;
								?>
									<td>Extra Child w/o Bed  <input type="hidden" name="roomName_1_4_<?php echo $roomCount4;?>" value="<?php echo $extChldWoBedRoomId;?>"><input type="hidden" name="room_name_1_4_<?php echo $roomCount4;?>" value="Extra Child w/o Bed"/></td>
								<?php
									
									foreach($arrRooms as $key4=>$val4)
									{
										$roomCount4++;
								?>
									
									<td>
									<input type="text" name="roomType_1_4_<?php echo $roomCount4;?>" value="">
									<input type="hidden" name="roomTypeId_1_4_<?php echo $roomCount4;?>" value="<?php echo $val4['id'];?>">
									<input type="hidden" name="hotelRateId_1_4_<?php echo $roomCount4;?>" value=""/>
									</td>
								<?php
									}
								
								
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount5=1;
								?>
									<td>Extra Child with Bed <input type="hidden" name="roomName_1_5_<?php echo $roomCount5;?>" value="<?php echo $extChldWBedRoomId;?>"><input type="hidden" name="room_name_1_5_<?php echo $roomCount5;?>" value="Extra Child with Bed"/></td>
								<?php
									
									foreach($arrRooms as $key5=>$val5)
									{
										$roomCount5++;
								?>
									
									<td>
									<input type="text" name="roomType_1_5_<?php echo $roomCount5;?>"  value="">
									<input type="hidden" name="roomTypeId_1_5_<?php echo $roomCount5;?>" value="<?php echo $val5['id'];?>">
									<input type="hidden" name="hotelRateId_1_5_<?php echo $roomCount5;?>" value=""/>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount6=1;
								?>
									<td>Extra Breakfast <input type="hidden" name="roomName_1_6_<?php echo $roomCount6;?>" value="<?php echo $extBrkFastRoomId;?>"><input type="hidden" name="room_name_1_6_<?php echo $roomCount6;?>" value="Extra Breakfast"/></td>
								<?php
									
									foreach($arrRooms as $key6=>$val6)
									{
										$roomCount6++;
								?>
									
									<td>
									<input type="text" name="roomType_1_6_<?php echo $roomCount6;?>"  value="" >
									<input type="hidden" name="roomTypeId_1_6_<?php echo $roomCount6;?>" value="<?php echo $val6['id'];?>">
									<input type="hidden" name="hotelRateId_1_6_<?php echo $roomCount6;?>" value=""/>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
									$roomCount7=1;
								?>
									<td>Lunch <input type="hidden" name="roomName_1_7_<?php echo $roomCount7;?>" value="<?php echo $lunchRoomId;?>"><input type="hidden" name="room_name_1_7_<?php echo $roomCount7;?>" value="Lunch"/></td>
								<?php
									
									foreach($arrRooms as $key7=>$val7)
									{
										$roomCount7++;
								?>
									
									<td>
									<input type="text" name="roomType_1_7_<?php echo $roomCount7;?>" value="">
									<input type="hidden" name="roomTypeId_1_7_<?php echo $roomCount7;?>" value="<?php echo $val7['id'];?>">
									<input type="hidden" name="hotelRateId_1_7_<?php echo $roomCount7;?>" value=""/>
									</td>
								<?php
									}
								
								?>
								
								</tr>
								<tr>
								<?php
								
									$roomCount8=1;
								?>
									<td class="dinnerCol">Dinner <input type="hidden" name="roomName_1_8_<?php echo $roomCount8;?>" value="<?php echo $dinnRoomId;?>"><input type="hidden" name="room_name_1_8_<?php echo $roomCount8;?>" id="room_name_1_8_<?php echo $roomCount8;?>" value="Dinner"/></td>
								<?php
									
									foreach($arrRooms as $key8=>$val8)
									{
										$roomCount8++;
								?>
									
									<td>
									<input type="text" class="roomType_1_<?php echo $roomCount8;?>" name="roomType_1_8_<?php echo $roomCount8;?>" value="">
									<input type="hidden" class="roomTypeId_1_<?php echo $roomCount8;?>" name="roomTypeId_1_8_<?php echo $roomCount8;?>" value="<?php echo $val8['id'];?>">
									<input type="hidden" class="hotelRateId_1_<?php echo $roomCount8;?>" name="hotelRateId_1_8_<?php echo $roomCount8;?>" value=""/>
									</td>
								<?php
									}
								}
								
								?>
								</tr>
								
								<tr>
									<td><label for="last">Add More Row</label>
									<a href="javascript:void(0);" class="add_more_row" id="add_more_row" relTbl="1" rel="1" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						</div>				
					</div>				
				</div>
				<div class="clearfix"></div>
			   <div class="box-footer">
					<?php if($showPrevBtn){?>
					<a href="<?php echo $tabUrl.base64_encode(6); ?>" class="btn btn-md btn-warning" name="bottom"><i aria-hidden="true"></i> Previous</a>
					<?php } ?>
					<button type="submit" class="btn btn-md btn-warning submit_rate_form" name="hotel_rate_1" rel="1" id="submit">Save</button>
				</div>
				</form> -->
				<?php
					}
				?>
				<input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRates>0){echo $countDateRates;}else{echo 1;}?>"> 
			</div>
			<div class="clearfix"></div>
			<!--<div class="col-md-12">
			<div class="form-group pull-right">
				<label for="last">Add More table</label>
				<a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
			</div>
			</div>-->
			
			
		</div>
	</div>	
	            <div class="clearfix"></div>
				<!--<div class="box-footer">
					<?php if($showPrevBtn){?>
					<a href="<?php echo $tabUrl.base64_encode(6); ?>" class="btn btn-md btn-warning" name="bottom"><i aria-hidden="true"></i> Previous</a>
					<?php } ?>
					<a href="hotel_list.php" class="btn btn-md btn-warning" name="bottom">Submit</a>
				</div>	-->	
</div>


			<?php } ?>



			
			<!--div2 -->
			
			<!--div2 end -->
<?php
						$t1=base64_decode($_GET['t']);
						if($t1==5)
						{
						?>
  <div class="">
                     <div class="" style="padding-left:0px; padding-right:0px; background:#ecf0f5;">
                     <div id="menu4" class="tab-pane fade <?php if($tab == 5){ echo 'in active';}?>">
					
					
					<?php
						// if(isset($countRoomDetail) && !empty($countRoomDetail)){ $rd = $countRoomDetail;}else{$rd = $countRooms;}
						// $hidden .= '<input type="hidden" name="ttlRoomService" id="ttlRoomService" value="'.$rd.'"/>';
						
						// if($_GET['action'] == 'edit'){$rn = $countRoomName;}else{$rn = $countRoomNameId;}
						// $hidden .= '<input type="hidden" id="room_count" name="room_count" value="'.$rn.'">';
						
						// echo $hidden;
					?>
					
					
                    					
					<input type="hidden" id="room_count" name="room_count" value="<?php if($_GET['action'] == 'edit'){echo $countRoomName;}else{echo $countRoomNameId;}?>"> 
					<input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countEditRooms;}else{echo $countRooms;}?>"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_hotel_rates_detail" />
					<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					
					<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
	<div class="">					
		<div class="" >	
			<div class="rate">
				<?php
				$item=1;
				//echo $countDateRates;
					$roomNamesMaster = array('Single', 'Double', 'Extra Adult', 'Extra Child w/o Bed', 'Extra Child with Bed', 'Extra Breakfast', 'Lunch', 'Dinner');
					?>
				<form role="form" method="POST" name="hotel_rate_1" id="hotel_rate_1">
					<input type="hidden" name="ttlRoomService" id="ttlRoomService" value="<?php if(isset($countRoomDetail) && !empty($countRoomDetail)){echo $countRoomDetail;}else{echo $countRooms;}?>"/>
					<input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRates>0){echo $countDateRates;}else{echo 1;}?>">
					<input type="hidden" id="item_count10" name="item_count10" value="<?php if(isset($countTtlRoom)&& !empty($countTtlRoom)){echo $countTtlRoom;}else{echo 8;}?>"> 	
					<input type="hidden" id="room_count" name="room_count" value="<?php if($_GET['action'] == 'edit'){echo $countRoomName;}else{echo $countRoomNameId;}?>"> 
					<input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countEditRooms;}else{echo $countRooms;}?>"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_hotel_rates_detail" />
					<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					<input type="hidden" name="editHotelId" id="editHotelId" value="<?php echo $hotelData['hotel_id']; ?>"/>
					<input type="hidden" name="update" value="0" />	
				<div id="rates_1">
					<input type="hidden" id="tbl_1_item_count10" name="tbl_1_item_count10" value="1">
					<div class="">
						<div class="form-group text-center">
							<h4  class="box-title" style="margin-bottom:30px; margin-top:20px;"><b style="font-size: 27px; text-align:center;  color:#007DFB; text-shadow:1px 1px #ccc; ">ADD NEW	RATES </b></h4>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="search">Meal Plan</label>
							<select class="form-control" name="mealPlan_1"  id="meal_plan_new" onchange="meal_plan_func('<?php echo $_GET['id'] ?>')" required>
							<option value="">Select</option>
								<option value="1">CP (Breakfast)</option>
								<option value="2">MAP (Breakfast+Dinner)</option>
								<option value="3">AP (Breakfast+Lunch+Dinner)</option>
								<option value="4">EP (Room Only)</option>
								<option value="5">CP Package</option>
								<option value="6">MAP Package</option>
								<option value="7">AP Package</option>
								<option value="8">EP Package</option>
							</select>
						</div>						
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="search">From:Calender</label>
							<input type="text" class="form-control fromdate" disabled name="fromdate_1" id="" placeholder="Name" value="<?php echo date('d F Y');?>"/>
						</div>						
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="search">To:Calender</label>
							<input type="text" class="form-control todate" disabled name="todate_1" id="" placeholder="Name" value="<?php echo date('d F Y');?>"/>
						</div>						
					</div>
					
					<div class="col-md-1">
				
					</div>
			
					<div class="bs-example col-md-12" >
						<div class="table-responsive">
						<table class="table rate_table">
							<thead>											
								<tr>
								<?php
									if($countRooms>0)
									{
								?>
								<th></th>
								<?php
										foreach($arrRooms as $key=>$val)
										{
								?>
									
									<th style="width: 40px;"><?php echo $val['room_type'];?></th>
								<?php
										}
									
								?>
								</tr>
							</thead>
							<tbody border="1px">
							
								<tr>
								<?php
										$roomCount1=1;
								?>
									<td>Single <input type="hidden" name="roomName_1_1_<?php echo $roomCount1;?>" value="<?php echo $singleRoomId;?>"><input type="hidden" name="room_name_1_1_<?php echo $roomCount1;?>" value="Single"/></td>
								<?php
										
										foreach($arrRooms as $key1=>$val1)
										{
										$roomCount1++;	
								?>
									<td>
									<input type="text" name="roomType_1_1_<?php echo $roomCount1;?>" value="">
									<input type="hidden" name="roomTypeId_1_1_<?php echo $roomCount1;?>" value="<?php echo $val1['id'];?>">
									<input type="hidden" name="hotelRateId_1_1_<?php echo $roomCount1;?>" value=""/>
									</td>
									
								<?php
										}
									?>
									<td rowspan="8"> <textarea class="rateDesc" name="description_1" rows="17" cols="21"> Description  </textarea>  </td>
								</tr>
								<tr>
									<?php
										$roomCount2=1;
									?>
										<td>Double <input type="hidden" name="roomName_1_2_<?php echo $roomCount2;?>" value="<?php echo $doubRoomId;?>"><input type="hidden" name="room_name_1_2_<?php echo $roomCount2;?>" value="Double"/></td>
									<?php
										
										foreach($arrRooms as $key2=>$val2)
										{
											$roomCount2++;
									?>
									<td>
									<input type="text"  name ="roomType_1_2_<?php echo $roomCount2;?>" value="">
									<input type="hidden" name="roomTypeId_1_2_<?php echo $roomCount2;?>" value="<?php echo $val2['id'];?>">
									<input type="hidden" name="hotelRateId_1_2_<?php echo $roomCount2;?>" value=""/>
									</td>		
									<?php
										}
									?>
								</tr>
								<tr>
								<?php
									
										$roomCount3=1;
								?>
									<td>Extra Adult  <input type="hidden" name="roomName_1_3_<?php echo $roomCount3;?>" value="<?php echo $extAdltRoomId;?>"><input type="hidden" name="room_name_1_3_<?php echo $roomCount3;?>" value="Extra Adult"/></td>
								<?php
										
										foreach($arrRooms as $key3=>$val3)
										{
											$roomCount3++;
									?>
									
									<td>
									<input type="text" name ="roomType_1_3_<?php echo $roomCount3;?>" value="">
									<input type="hidden" name="roomTypeId_1_3_<?php echo $roomCount3;?>" value="<?php echo $val3['id'];?>">
									<input type="hidden" name="hotelRateId_1_3_<?php echo $roomCount3;?>" value=""/>
									</td>
								<?php
										}
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount4=1;
								?>
									<td>Extra Child w/o Bed  <input type="hidden" name="roomName_1_4_<?php echo $roomCount4;?>" value="<?php echo $extChldWoBedRoomId;?>"><input type="hidden" name="room_name_1_4_<?php echo $roomCount4;?>" value="Extra Child w/o Bed"/></td>
								<?php
									
									foreach($arrRooms as $key4=>$val4)
									{
										$roomCount4++;
								?>
									
									<td>
									<input type="text" name="roomType_1_4_<?php echo $roomCount4;?>" value="">
									<input type="hidden" name="roomTypeId_1_4_<?php echo $roomCount4;?>" value="<?php echo $val4['id'];?>">
									<input type="hidden" name="hotelRateId_1_4_<?php echo $roomCount4;?>" value=""/>
									</td>
								<?php
									}
								
								
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount5=1;
								?>
									<td>Extra Child with Bed <input type="hidden" name="roomName_1_5_<?php echo $roomCount5;?>" value="<?php echo $extChldWBedRoomId;?>"><input type="hidden" name="room_name_1_5_<?php echo $roomCount5;?>" value="Extra Child with Bed"/></td>
								<?php
									
									foreach($arrRooms as $key5=>$val5)
									{
										$roomCount5++;
								?>
									
									<td>
									<input type="text" name="roomType_1_5_<?php echo $roomCount5;?>"  value="">
									<input type="hidden" name="roomTypeId_1_5_<?php echo $roomCount5;?>" value="<?php echo $val5['id'];?>">
									<input type="hidden" name="hotelRateId_1_5_<?php echo $roomCount5;?>" value=""/>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
								
									$roomCount6=1;
								?>
									<td>Extra Breakfast <input type="hidden" name="roomName_1_6_<?php echo $roomCount6;?>" value="<?php echo $extBrkFastRoomId;?>"><input type="hidden" name="room_name_1_6_<?php echo $roomCount6;?>" value="Extra Breakfast"/></td>
								<?php
									
									foreach($arrRooms as $key6=>$val6)
									{
										$roomCount6++;
								?>
									
									<td>
									<input type="text" name="roomType_1_6_<?php echo $roomCount6;?>"  value="" >
									<input type="hidden" name="roomTypeId_1_6_<?php echo $roomCount6;?>" value="<?php echo $val6['id'];?>">
									<input type="hidden" name="hotelRateId_1_6_<?php echo $roomCount6;?>" value=""/>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
									$roomCount7=1;
								?>
									<td>Lunch <input type="hidden" name="roomName_1_7_<?php echo $roomCount7;?>" value="<?php echo $lunchRoomId;?>"><input type="hidden" name="room_name_1_7_<?php echo $roomCount7;?>" value="Lunch"/></td>
								<?php
									
									foreach($arrRooms as $key7=>$val7)
									{
										$roomCount7++;
								?>
									
									<td>
									<input type="text" name="roomType_1_7_<?php echo $roomCount7;?>" value="">
									<input type="hidden" name="roomTypeId_1_7_<?php echo $roomCount7;?>" value="<?php echo $val7['id'];?>">
									<input type="hidden" name="hotelRateId_1_7_<?php echo $roomCount7;?>" value=""/>
									</td>
								<?php
									}
								
								?>
								
								</tr>
								<tr>
								<?php
								
									$roomCount8=1;
								?>
									<td class="dinnerCol">Dinner <input type="hidden" name="roomName_1_8_<?php echo $roomCount8;?>" value="<?php echo $dinnRoomId;?>"><input type="hidden" name="room_name_1_8_<?php echo $roomCount8;?>" id="room_name_1_8_<?php echo $roomCount8;?>" value="Dinner"/></td>
								<?php
									
									foreach($arrRooms as $key8=>$val8)
									{
										$roomCount8++;
								?>
									
									<td>
									<input type="text" class="roomType_1_<?php echo $roomCount8;?>" name="roomType_1_8_<?php echo $roomCount8;?>" value="">
									<input type="hidden" class="roomTypeId_1_<?php echo $roomCount8;?>" name="roomTypeId_1_8_<?php echo $roomCount8;?>" value="<?php echo $val8['id'];?>">
									<input type="hidden" class="hotelRateId_1_<?php echo $roomCount8;?>" name="hotelRateId_1_8_<?php echo $roomCount8;?>" value=""/>
									</td>
								<?php
									}
								}
						
								?>
								</tr>
								
								<tr>
									<td><label for="last">Add More Row</label>
									<a href="javascript:void(0);" class="add_more_row" id="add_more_row" relTbl="1" rel="1" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						</div>				
					</div>				
				</div>
				<div class="clearfix"></div>
				<div class="box-footer" style="background:#ecf0f5;">
					<!-- <?php if($showPrevBtn){?>
					<a href="<?php echo $tabUrl.base64_encode(6); ?>" class="btn btn-md btn-warning" name="bottom"><i aria-hidden="true"></i> Previous</a>
					<?php } ?> -->
					<button type="submit" class="btn btn-md btn-primary submit_rate_form" name="hotel_rate_1" rel="1" id="submit">Save</button><br></br>
				</div>
				</form>
				
				<input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRates>0){echo $countDateRates;}else{echo 1;}?>"> 
			</div>
			<div class="clearfix"></div>
			<!--<div class="col-md-12">
			<div class="form-group pull-right">
				<label for="last">Add More table</label>
				<a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
			</div>
			</div>-->
			
			
		</div>
	</div>	
	            <div class="clearfix"></div>
				<div class="box-footer" style="background:#ecf0f5;">
					<?php if($showPrevBtn){?>
					<a href="<?php echo $tabUrl.base64_encode(6); ?>" class="btn btn-md btn-primary" name="bottom"><i aria-hidden="true"></i> Previous</a>
					<?php } ?>
					<a href="hotel_list.php" class="btn btn-md btn-primary" name="bottom">Submit</a>
				</div>		
</div>

</div>

										
			<!--div2 -->
			
			<!--div2 end -->



     
    </div>
	<?php } ?>


     
    </div>
			
			
			
		</div>
	</div>
   </section>
	
	<!-- Modal -->
  <div class = "modal" id = "hotelAmen" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Hotel Amenities & Facilities
            </h4>
         </div>
         
         <div class ="modal-body">
		 <div class="row">
			<?php
										 
				foreach($arrAmenties as $value){
					
			?>
			<div class="col-md-4">
            <label class="checkbox-inline"><input class="modalAminities" type="checkbox" id="modalAminities" name="modAmen[]" value="<?php echo $value;?>"><?php echo $value;?></label>
			</div>
			<?php
				}
			?>
         </div>
         </div>
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Close
            </button>
            
            <button type = "button" id="submodalAmen" name="submodalAmen" class = "btn btn-primary">
               Select
            </button>
         </div>
         
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
  </div><!-- /.modal -->

<!-- Modal -->
  <div class = "modal" id = "roomAmen" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Room Amenities & Facilities
            </h4>
         </div>
         
         <div class ="modal-body">
		 <div class="row">
			<input type="hidden" name="currentItem" id="currentItem" value="1"/>
			<?php
										 
				foreach($arrRoomAmen as $value){
					/* $checked="";
					if(count($aminities_facilites)>0){
						foreach($aminities_facilites as $key=>$val){
						//$relAmId=$val['id'];
						
							if(in_array($value, $val)){
								$checked="checked";
								echo '<input type="hidden" name="amiFacility[]" value="'.$val['id'].'"/>';
							}
						}
					} */
			?>
			<div class="col-md-4">
				<label class="checkbox-inline"><input class="modalRoomAminities" type="checkbox" id="modalRoomAminities" name="modRoomAmen[]" value="<?php echo $value;?>"><?php echo $value;?></label>
			</div>
			<?php
				}
			?>
         </div>
         </div>
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Close
            </button>
            
            <button type = "button" id="submodalRoomAmen" name="submodalRoomAmen" class = "btn btn-primary">
               Select
            </button>
         </div>
         
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
  </div><!-- /.modal -->
	


<?php
$arrHotelSugg=$objhotel->get_hotel_name();
//echo "<pre>";print_r($arrHotelSugg);
$hotelSugg=array();
$cnt=0;
foreach($arrHotelSugg as $value){
	
	$hotelSugg[$cnt]=$value['hotel_name']." (".$value['city'].")";
	$cnt++;
}
$strHotel =json_encode($hotelSugg);
?>
<script src="ckeditor_4.4.5_full/ckeditor/ckeditor.js" type="text/javascript"></script>	
<script src="asset/bootstrap-datetimepicker.js"></script>
<!-- bootstrap time picker -->
	<script src="asset/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="uploadify/jquery.uploadify.js"></script>
	<!--<script>
$(document).ready(function(){
	$('#select_image').change(function(){
	$('#hotel_photos_btn').submit();
	});
	$('#hotel_photos_btn').on('submit', function(e){
		e.preventDefault();
	    $.ajax({
			url : "upload.php",
			method : "POST",
			data: new FormData(this),
			contentType:false,
			processData:false,
			success: function(data){
				 $('#img_select').val('');  
                $('#src_img_upload').modal('hide');  
                $('#gallery').html(data); 
			}
		})
	});
});
</script>-->
	<script>  

 $(document).ready(function(){  
      $('#select_image').change(function(){ 
	 
		var formData = new FormData($('#hotel_photos_frm')[0]);
         
		 
				  
           $.ajax({  
                url :"upload.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,
                beforeSend: function() {
            $("#me2").css({"display": "block"});
			
                },  
                success:function(data){ 
						//alert(data);
						 
						
						
						
						 var a=$.parseJSON(data);
						//alert(a);
						// return false;
						// var imgName=a.imagename;
						// alert(imgName);
						// return false;
						// var picName = imgName.split('.');
						// var uniqueName = picName[0];
						//alert(uniqueName);
						$.each(a, function(i,e ) {
							var imgName=e;
						//alert(imgName);
						//return false;
						var picName = imgName.split('.');
						var uniqueName = picName[0];
                       
						$('#currentUploaded').append('<div class="col-md-3 hpBox" id="hpicsmain_'+uniqueName+'"><img alt="Hotel Img" class="superbox-img" src="document/hotel_doc/hotel_pics/'+imgName+'" id="hpic_'+uniqueName+'" rel="'+uniqueName+'" style="width: 81%;height:85px;margin:10px;padding: 10px;"><img class="delHotelImg delPhotoImg" id="p_'+uniqueName+'" src="document/hotel_doc/hotel_room_pic/x.png" relId="'+uniqueName+'" alt="delete"/><input type="text" name="hImage[]" value="" placeholder="Image Caption" style="width: 100%;"></div>');
						
						$('#hotelPhotosHidden').append('<input id="hid_'+uniqueName+'" type="hidden" name="hPhotos[]" value="'+imgName+'"/>');
						});
						
						$("#me2").css({"display": "none"});
						return false;

                     
                }  
           }) 
		 
		  	
      }); 
	   
      
 });  
 </script> 
	<script>
	
$(document).ready(function(){
	//CKEDITOR.replace('description_1');
	$('.rateDesc').each(function(e){
        var titleEditor = CKEDITOR.replace(this, {customConfig: 'ckeditor_customconfig/ckeditor_config2.js'});
    });
	
	
	
	$(".rateTables").hide();
	
	$(".nav-tabs a[data-toggle=tab]").on("click", function(e) {
	  if ($(this).hasClass("disabled")) {
		e.preventDefault();
		return false;
	  }
	});
	
	$("#hotel_name").autocomplete({
		//source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
		source: <?php echo $strHotel;?>
	});
	
	$(document).on('click','.showRtable',function(){
		var number = $(this).attr('rel');
		//alert(number);	
		
		$("#tblR_"+number).fadeToggle(1000);
	});
	/* if($("#checkEdit").val() == 'edit')
	{
		var dataString = 'id='+ <?php echo $hotel_address_details[0]['country']; ?>;
		$("#hotel_state").find('option').remove();
		$("#hotel_city").find('option').remove();
		
		$.ajax
		({
			
			type: "POST",
			url: "_ajax_get_state.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#hotel_state").html(html);
			} 
		});
		$("#hotel_state").select2("<?php echo $hotel_address_details[0]['state']; ?>");	
	} */
	$("#submodalRoomAmen").click(function(){
		//alert("sdfs");
		var count = $("#currentItem").val();
		var str='';
		$(".modalRoomAminities").each(function(){
			if($(this).is(':checked')){
				str += $(this).val()+', ';
			}
		});
		//var newStr=rtrim(str,', ');
		var newStr = str.replace(/,\s*$/, "");
		$("#AminitiesF_"+count).val(newStr);
		$("#roomAmen").modal('hide');
	});
	$("#submodalAmen").click(function(){
		//alert("sdfs");
		var str='';
		$(".modalAminities").each(function(){
			if($(this).is(':checked')){
				str += $(this).val()+', ';
			}
		});
		//var newStr=rtrim(str,', ');
		var newStr = str.replace(/,\s*$/, "");
		$("#Aminities").val(newStr);
		$("#hotelAmen").modal('hide');
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
		$('<div id="attch_'+count+'"><div class="clearfix"></div><input type="hidden" name="attachEdId[]" id="addMoreId" value=""/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="docFileName[]" id="addmorefilename_'+count+'" placeholder="File Name" value=""/></div></div><div class="col-md-10"><div class="col-md-4"><div class="form-group"><label class="btn-bs-file btn btn-md btn-primary">Choose File<input class="file_upload" id="add_more_file_'+count+'" name="file_upload3[]" type="file" multiple><input type="hidden" name="upldFileName[]" id="addMoreDoc_'+count+'" value=""/></label></div><p class="help-block text-danger"></p></div><div class="col-md-5"><div id="add_more_uploaded_'+count+'"></div></div><div class="col-md-2"><div class="form-group"><a class="delete delAttach" relId="" rel="'+count+'" href="javascript:void(0)" onclick="remove_attach('+count+','+attachId+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div><div style="clear:both;"></div>').insertAfter($(this).parent().parent().prev());
			
		$("#totalFld").val(count);
		uplodifyMore(count);
	});
	$(".select2").select2();
	$("#hotel_country").change(function()
	{
		//alert("punamsaini");
		var id=$(this).val();
		
		var dataString = 'id='+ id;
		$("#hotel_state").find('option').remove();
		$("#hotel_city").find('option').remove();
		
		$.ajax
		({
			
			type: "POST",
			url: "_ajax_get_state.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#hotel_state").html(html);			
			} 
		});
	});
	
	$("#hotel_state").change(function()
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
				$("#hotel_city").html(html);
			} 
		});
	});	
	
			var totalRooms = $("#item_count1").val();
			for(var i=1; i<=totalRooms; i++)
			{
				uplodifyImg(i);
			}
			$("#checkInTime").timepicker({
				showInputs: false,
				showSeconds: false,
				showMeridian: true,
				defaultValue : '<?php echo $checkin_time;?>'
			});
			
			$("#checkOutTime").timepicker({
				showInputs: false,
				showSeconds: false,
				showMeridian: true,
				defaultValue : '<?php echo $checkout_time;?>'
			});
			
			$('.htimepicker').on('keydown', function(e) {
				if(e.keyCode == 9) {
					$(this).timepicker('hideWidget');
				}
			});
			
			//$('#timepicker').timepicker('setTime', '12:45 AM');
			
			$( "#checkOutdate" ).datepicker({	
				format: "dd MM yyyy"
			});
			$( "#checkInDate" ).datepicker({	
				format: "dd MM yyyy"
			});
			
			// $( ".fromdate" ).datepicker({

			// format: "dd MM yyyy"
			// });
		// $( ".todate" ).datepicker({

			// format: "dd MM yyyy"
			// });
		$(document).on('click','.delete_row',function(){
			$(this).parent().parent().remove();
			/* var tblNum = $(this).attr('tblNo');
			//alert(tblNum);
			var valAl = $("#tbl_"+tblNum+"_item_count10").val();
			
			$("#tbl_"+tblNum+"_item_count10").val(valAl-1); */
		});
		$("#add_more_item").click(function(){
		
				var count = $("#item_count").val();
				//alert(count);
				count++;
				$('<div id="person_'+count+'"><div class="clearfix"></div><input type="hidden" name="concPrsnid[]" value="0"/><div class="col-md-3"><div class="form-group"><select class="form-control" name="title[]"><option value="">--</option><option value="Mr.">Mr.</option><option value="Miss.">Miss.</option><option value="Mrs">Mrs.</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="middlename[]" id="middlename" placeholder="Middle Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item6('+count+', 0)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>').insertAfter($(this).parent().parent().prev());
				
				$("#item_count").val(count);
				//alert()
			});
		$("#contumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$('<div id="connumbbr_'+count+'"><div class="clearfix"></div><input type="hidden" name="concPrsnNumId[]" value="0"/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div> <div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-3 v_hidden"><div class="form-group"><input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item7('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div>').insertAfter($(this).parent().parent().prev());;
				
				$("#item_count3").val(count);
				//alert()
			});	
		
	$("#add_more_items2").click(function(){
		
				var count = $("#item_count5").val();
				//alert(count);
				count++;
				$(".items6").append('<div id="Aminities_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="amiFacility[]" value="0"/><div class="col-md-9"><div class="form-group"><input type="text" class="form-control" name="Aminities[]" id="Aminities" placeholder= "Amenities & Facilities" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item5('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count5").val(count);
				//alert()
			});
		
	$("#add_more_items1").click(function(){
		
				var count = $("#item_count1").val();
				//alert(count);
				count++;
				if(count==6)
				{
					alert("No More Fields can be added");
					return false;
				}
				//var mycnt=count.toString();;
				$('<div style="clear:both;"></div><div id="address2_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="hotelRoomSerDetail[]" value="0"/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="roomstype[]" id="roomstype" placeholder="Room Type" value=""/></div></div><div class="col-md-2">	<div class="form-group"><input type="text" class="form-control" name="RDescription[]" id="RDescription" placeholder="Room Description" value=""/></div> </div><div class="col-md-1"><button type="button" class="btn btn-primary roomAmenities" name="roomAmenities[]" id="roomAmenities" onclick="room_modal(\''+count+'\');">Select</button></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control AminitiesF" name="AminitiesF[]" id="AminitiesF_'+count+'" placeholder="Amenities & Facilities" value=""/></div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value=""/></div></div><div class="col-md-2"><div class="form-group"><label class="btn-bs-file btn btn-md btn-primary">Choose File<input type="file" class="form-control roomPics" name="Pics[]" id="Pics_'+count+'" rel="'+count+'" placeholder="Pics" value="" multiple="true"/><input type="hidden" name="roomImg[]" id="roomImg_'+count+'" value=""/></label></div></div><div class="col-md-1"><div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item4('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div><div class="col-sm-10 col-md-offset-2"><div class="form-group"><div id="hotel_images_'+count+'" class=""></div><div style="clear:both;"></div></div></div></div>').insertAfter($(this).parent().parent().prev());
				
				$("#item_count1").val(count);
				uplodifyImg(count);
			});
				
			function rtrim(str, ch)
			{
				for (i = str.length - 1; i >= 0; i--)
				{
					if (ch != str.charAt(i))
					{
						str = str.substring(0, i + 1);
						break;
					}
				} 
				return str;
			}
			function uplodifyImg(number)
		{
			//alert(number);
			$('#Pics_'+number).change(function(){
				var str='';
				
					var formData = new FormData($("#hotal_personl_detail")[0]);
			$.ajax({  
                url :"upload_hotel_pics.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,  
				beforeSend: function() {
       $("#me3").css({"display": "block"});
                },
                success:function(data){
					
					//alert(data);
					 //return false;
					//console.log(data);
					//return false;
					
					var a=$.parseJSON(data);
					
					
					
					
					$.each(a, function(i,e ) {
					
					
					var imgName=e;
					var preImg = $('#roomImg_'+number).val();
					if(imgName != null){
					
					$('#hotel_images_'+number).append('<img alt="Restaurant Logo" class="superbox-img" src="document/hotel_doc/hotel_room_pic/'+imgName+'" id="add_full_img_'+imgName+'" style="width:85px;height:85px;margin:10px;"><img class="remove_img del_add_img" id="add_img_'+imgName+'" src="document/hotel_doc/hotel_room_pic/x.png" relId="'+imgName+'" relNum="'+number+'" alt="delete"/>');
					
					
					if(preImg == '')
					{
						
						str += imgName+',';
					}
					else
					{
						
						str = preImg+imgName+',';
					}
					$("#roomImg_"+number).val(str);
					
				}
					
				
					
				
				
				
					});
					
					
						//alert(data);
						 
						
						// $.each(a, function(i,e ) {
							// var imgName=e;
						// if(imgName != null){
						// $('#hotel_images_'+number).append('<img alt="Restaurant Logo" class="superbox-img" src="document/hotel_doc/hotel_room_pic/'+imgName+'" id="add_full_img_'+imgName+'" style="width:85px;height:85px;margin:10px;"><img class="remove_img del_add_img" id="add_img_'+imgName+'" src="document/hotel_doc/hotel_room_pic/x.png" relId="'+imgName+'" relNum="'+number+'" alt="delete"/>');
						// }
						
						$('#Pics_'+number).val("");
						$("#me3").css({"display": "none"});
						
						// var preImg = $('#roomImg_'+number).val();
					
					// if(preImg == '')
					// {
						// str += imgName+',';
					// }
					// else
					// {
						// str = preImg+imgName+',';
					// }
				
					// $("#roomImg_"+number).val(imgName);
						
						// });
						
						 // var a=$.parseJSON(data);
						
						// $.each(a, function(i,e ) {
							// var imgName=e;
						
					
						// var already = $("#addMoreDoc_"+number).val();
					// var newFile = already+','+imgName;
						
					// $("#addMoreDoc_"+number).val(newFile);
						
						// });
						
						
						//return false;
                     
                }  
           }) 
					
					
						
			});
		}
			
			// function uplodifyImg(number)
			// {
				// var str='';
				
				// $("#Pics_"+number).uploadify({
				// 'formData'     : {
					// 'flag'  : 'hotel_image',
					// 'direc'	: 'hotel_room_pic',
					// 'id'	: '<?php echo $hotelId;?>',
					// 'name'  : 'room_pic_copy',
					// 'recordId'      : '<?php echo $recordId; ?>'
				// },
				// 'onSelect' : function(file) {
				  
				 // },
				// 'buttonImage' : '<?php echo APP_URL;?>uploadify/browse-btn.png',
				// 'buttonText' : 'Add Category Pic',
				// 'swf'      : '<?php echo APP_URL;?>uploadify/uploadify.swf',
				// 'uploader' : '_ajax_document_upload.php',
				// 'onUploadSuccess': function (file, data, response){
					// var extension = file.name.replace(/^.*\./, '');
					// var a=$.parseJSON(data);
					
					// var imgName=a.imagename;
					// $('#hotel_images_'+number).append('<img alt="Restaurant Logo" class="superbox-img" src="document/hotel_doc/hotel_room_pic/'+imgName+'" id="add_full_img_'+imgName+'" style="width:85px;height:85px;margin:10px;"><img class="remove_img del_add_img" id="add_img_'+imgName+'" src="document/hotel_doc/hotel_room_pic/x.png" relId="'+imgName+'" relNum="'+number+'" alt="delete"/>');
					
					// var preImg = $('#roomImg_'+number).val();
					
					// if(preImg == '')
					// {
						// str += imgName+',';
					// }
					// else
					// {
						// str = preImg+imgName+',';
					// }
				
					// $("#roomImg_"+number).val(str);
				// }		
			// });
			// }
			
			
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
			
	$("#add_more_items").click(function(){
		
				var count = $("#address1").val();
				//alert(count);
				count++;
				$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="hotelPerAddrId[]" value="0"/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="hotel_address1[]" id="userPhone" placeholder="Address" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="hotel_address2[]" id="userPhone" placeholder="Location/Area" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="hotel_city[]" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="hotel_state[]" id="hotel_state" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="hotel_pincode[]" id="last" placeholder="Code" value=""/></div></div><div class="col-md-1"><div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#address1").val(count);
				//alert()
			});
		
			$("#Mnumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$('<div id="Mobnumbbr_'+count+'"><div class="clearfix"></div><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="hotelPerNumId[]" value="0"/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="hotelPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control valid" name="hotelCode[]" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>').insertAfter($(this).parent().parent().prev());
				//alert($(this).parent().parent().prev().attr('id'));
				
				$("#item_count3").val(count);
				//alert()
			});
			
			$("#emails").click(function(){
		
				var count = $("#item_count4").val();
				//alert(count);
				count++;
				$('<div id="Email_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="" /></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item1('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div> ').insertAfter($(this).parent().parent().prev());
				
				$("#item_count4").val(count);
			});
		
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
							
						}contCopyDocName,panCardDocName,photoDocName
					} 
				});hotel_pan_card_copy
			}
			}); */
/*		function uplodifyMore(number)
		{
			//alert(number);
			$('#add_more_file_'+number).change(function(){
					var formData = new FormData($("#hotel_doc_detail")[0]);
			$.ajax({  
                url :"upload_more_doc.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,  
				beforeSend: function() {
       $("#me1").css({"display": "block"});
                },	
                success:function(data){
					
						//alert(data);
						 
						
						
						
						 var a=$.parseJSON(data);
						//alert(a);
						// return false;
						// var imgName=a.imagename;
						// alert(imgName);
						// return false;
						// var picName = imgName.split('.');
						// var uniqueName = picName[0];
						//alert(uniqueName);
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
						//return false;
                     
                }  
           }) 
					
					
						
			});
		}*/

		function uplodifyMore(number)
		{
			//alert(number);
			$('#add_more_file_'+number).change(function(){
					var formData = new FormData($("#hotel_doc_detail")[0]);
			$.ajax({  
                url :"upload_more_doc.php", 			
                method:"POST",  
                data:formData,  
                contentType:false,  
                processData:false,
                beforeSend: function() {
       $("#me1").css({"display": "block"});
                },  
                success:function(data){
					
						//alert(data);
						 
						
						
						
						 var a=$.parseJSON(data);
						//alert(a);
						// return false;
						// var imgName=a.imagename;
						// alert(imgName);
						// return false;
						// var picName = imgName.split('.');
						// var uniqueName = picName[0];
						//alert(uniqueName);
						$.each(a, function(i,e ) {
							var imgName=e;
						//alert(imgName);
						//return false;
					  if(imgName!=null)
					  {
						var already = $("#addMoreDoc_"+number).val();
					var newFile = already+','+imgName;
						$('#add_more_uploaded_'+number).append('<div>'+imgName+'</div>');
						//$('#add_more_uploaded_'+number).html('<label>'+imgName+'</label>');
					$("#addMoreDoc_"+number).val(newFile);
				      }
						
						});
						
						$('#add_more_file_'+number).val("");
						$("#me1").css({"display": "none"});
						//return false;
                     
                }  
           }) 
					
					
						
			});
		}

			$('#hotel_pan_card_copy').change(function(){ 
	 
		var formData = new FormData($("#hotel_doc_detail")[0]);
		//var file = $('#hotel_pan_card_copy')[0].files[0];
		//console.log(file);
		//return false;
		
		 
				  
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
					
						//alert(data);
						 
						
						
						
						 var a=$.parseJSON(data);
						//alert(a);
						// return false;
						// var imgName=a.imagename;
						// alert(imgName);
						// return false;
						// var picName = imgName.split('.');
						// var uniqueName = picName[0];
						//alert(uniqueName);
						$.each(a, function(i,e ) {
							var imgName=e;
						//alert(imgName);
						//return false;
						$('#panDocs').append('<div>'+imgName+'</div>');
					
					var already = $("#panCardDoc").val();
					var newFile = already+','+imgName;
					
					$("#panCardDoc").val(newFile);
						
						});
						
						
						//return false;
                     $("#me1").css({"display": "none"});
					 $(".attach_new").css({"display": "block"});
					  $(".attach_newed").css({"display": "block"});
                }  
           }) 
		 
		  	
      }); 
	  
	 
	  $('#hote_photo_copy').change(function(){ 
	 
		var formData = new FormData($("#hotel_doc_detail")[0]);
		//var file = $('#hotel_pan_card_copy')[0].files[0];
		//console.log(file);
		//return false;
		
		 
				  
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
			 
	$('#hotel_Contract_copy').change(function(){ 
	 
		var formData = new FormData($("#hotel_doc_detail")[0]);
		//var file = $('#hotel_pan_card_copy')[0].files[0];
		//console.log(file);
		//return false;
		
		 
				  
           $.ajax({  
                url :"upload_contract.php", 			
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
							var imgName=e;
						$('#contactDocs').append('<div>'+imgName+'</div>');
						
						var already = $("#contCopyDoc").val();
						var newFile = already+','+imgName;
						$("#contCopyDoc").val(newFile);
						
						});
						
					   $("#me1").css({"display": "none"});	
					   $(".attach_new2").css({"display": "block"});	
                       $(".attach_newed2").css({"display": "block"});		
                     
                }  
           }) 
		 
		  	
      }); 
			// $('#hotel_pan_card_copy').uploadify({
				// 'formData'     : {
					// 'flag'      : 'upload_file',
					// 'direc'	: 'hotel_doc',
					// 'id'	: '<?php echo $hotelId;?>',
					// 'name'		: 'pan_card_copy',
					// 'recordId'      : '<?php echo $recordId; ?>'
				// },
				// 'onSelect' : function(file) {
				  
				 // },
				// 'buttonImage' : 'uploadify/browse-btn.png',
				// 'buttonText' : 'Add Category Pic',
				// 'multi': true,
				// 'swf'      : 'uploadify/uploadify.swf',
				// 'uploader' : '_ajax_document_upload.php',
				// 'onUploadSuccess': function (file, data, response) {
					// var extension = file.name.replace(/^.*\./, '');
					// var a=$.parseJSON(data);
					// var imgName=a.imagename;	
					
					// $('#panDocs').append('<div>'+imgName+'</div>');
					
					// var already = $("#panCardDoc").val();
					// var newFile = already+','+imgName;
					
					// $("#panCardDoc").val(newFile);
				// }		
			// });
			
			// $('#hote_photo_copy').uploadify({
				// 'formData'     : {
					// 'flag'      : 'upload_file',
					// 'direc'	: 'hotel_doc',
					// 'id'	: '<?php echo $hotelId;?>',
					// 'name'		: 'photo_copy',
					// 'recordId'      : '<?php echo $recordId; ?>'
				// },
				// 'onSelect' : function(file) {
				 
				 // },
				// 'buttonImage' : 'uploadify/browse-btn.png',
				// 'buttonText' : 'Add Category Pic',
				// 'multi': true,
				// 'swf'      : 'uploadify/uploadify.swf',
				// 'uploader' : '_ajax_document_upload.php',
				// 'onUploadSuccess': function (file, data, response) {
					 // var extension = file.name.replace(/^.*\./, '');
					 // var a=$.parseJSON(data);
						// var imgName=a.imagename;
						// $('#photoDocs').append('<div>'+imgName+'</div>');
					
						// var already = $("#photoDoc").val();
						// var newFile = already+','+imgName;
						// $("#photoDoc").val(newFile);
				// }		
			// });
			
			
			
			// $('#hote_photos').uploadify({
				// 'formData'     : {
					// 'flag'      : 'upload_file',
					// 'direc'	: 'hotel_pics',
					// 'id'	: '<?php echo $hotelId;?>',
					// 'name'		: 'photo_copy',
					// 'recordId'      : '<?php echo $recordId; ?>'
				// },
				// 'onSelect' : function(file) {
				  
				 // },
				// 'buttonImage' : 'uploadify/browse-btn.png',
				// 'buttonText' : 'Add Category Pic',
				// 'multi': true,
				// 'swf'      : 'uploadify/uploadify.swf',
				// 'uploader' : '_ajax_document_upload.php',
				// 'onUploadSuccess': function (file, data, response) {
					 // var extension = file.name.replace(/^.*\./, '');
					 // var a=$.parseJSON(data);
						// var imgName=a.imagename;
						
						// var picName = imgName.split('.');
						// var uniqueName = picName[0];
						// $('#currentUploaded').append('<div class="col-md-3 hpBox" id="hpicsmain_'+uniqueName+'"><img alt="Hotel Img" class="superbox-img" src="document/hotel_doc/hotel_pics/'+imgName+'" id="hpic_'+uniqueName+'" rel="'+uniqueName+'" style="width: 81%;height:85px;margin:10px;padding: 10px;"><img class="delHotelImg delPhotoImg" id="p_'+uniqueName+'" src="document/hotel_doc/hotel_room_pic/x.png" relId="'+uniqueName+'" alt="delete"/><input type="text" name="hImage[]" value="" placeholder="Image Caption" style="width: 100%;"></div>');
						
						// $('#hotelPhotosHidden').append('<input id="hid_'+uniqueName+'" type="hidden" name="hPhotos[]" value="'+imgName+'"/>'); 
				// }		
			// });
			
			$(document).on('click','.delHotelImg', function(){
				var id = $(this).attr('relId');
				
				alert(id);
				$("#hpicsmain_"+id).remove();
				$("#hid_"+id).remove();
				
			});
			
			// $('#hotel_Contract_copy').uploadify({
				// 'formData'     : {
					// 'flag'      : 'upload_file',
					// 'direc'	: 'hotel_doc',
					// 'id'	: '<?php echo $hotelId;?>',
					// 'name'		: 'contract_copy',
					// 'recordId'      : '<?php echo $recordId; ?>'
				// },
				// 'onSelect' : function(file) {
				 
				 // },
				// 'buttonImage' : 'uploadify/browse-btn.png',
				// 'buttonText' : 'Add Category Pic',
				// 'multi': true,
				// 'swf'      : 'uploadify/uploadify.swf',
				// 'uploader' : '_ajax_document_upload.php',
				// 'onUploadSuccess': function (file, data, response) {
					 // var extension = file.name.replace(/^.*\./, '');
					 // var a=$.parseJSON(data);
						// var imgName=a.imagename;
						// $('#contactDocs').append('<div>'+imgName+'</div>');
						
						// var already = $("#contCopyDoc").val();
						// var newFile = already+','+imgName;
						// $("#contCopyDoc").val(newFile);
						
				// }		
			// });
			
			$("#hotel_doc_detail_btn").click(function(){
				//alert("sdfdsf");
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_doc_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(msg)
					{
						//$("#hotel_rate_tab").click();
						window.location.href='<?php echo $tabUrl.base64_encode(6); ?>';
						//window.location.href='clientlist.php';
						/* var newUrl = '<?php echo $tabUrl.base64_encode(6); ?>';
						
						var separator = (newUrl.indexOf("?")===-1)?"?":"&";
						//console.log(newUrl + separator + "id="+html);
						window.location.href = newUrl + separator + "id=<?php echo $editHotelId; ?>"; */
					}
				}); 
			});
			
			$("#hotel_photos_btn").click(function(){
				//alert("sdfdsf");
				
				
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_photos_frm").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(msg)
					{
						//$("#hotel_rate_tab").click();
						window.location.href='<?php echo $tabUrl.base64_encode(5); ?>';
						/* var newUrl = '<?php echo $tabUrl.base64_encode(5); ?>';
						
						var separator = (newUrl.indexOf("?")===-1)?"?":"&";
						//console.log(newUrl + separator + "id="+html);
						window.location.href = newUrl + separator + "id=<?php echo $editHotelId; ?>"; */
						//window.location.href='clientlist.php';
					}
				}); 
			});
			
			
		});
		
		$(document).on('click','#add_more_rate',function(){
	
			var count = $("#item_count9").val();
			count++;
			alert(count);
			var data = 'type=add_more_rates&count='+count+'&hId=<?php echo $hotelIdProcess; ?>';
			$.ajax({
				type: "POST",
				url: "_ajax_hotel_prsnl_detail.php",
				data: data,
				cache: false,
				beforeSend:function() {
					//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
				},
				success: function(html)
				{
					//alert(html);
					$(".rate").append(html);
					$("#item_count9").val(count);
			
					$( ".fromdate").datepicker({
						format: "dd MM yyyy"
					});
					$( ".todate").datepicker({
						format: "dd MM yyyy"
					});
					
					CKEDITOR.replace('description_'+count, {customConfig: 'ckeditor_customconfig/ckeditor_config2.js'});
				}
			}); 
			
		});				
			$(document).on('click','.add_more_row',function(){
				var row=1;
				var ttlTbl = $(this).attr('relTbl');
				var tblno= $(this).attr('rel');
				//alert("#tbl_"+ttlTbl+"_item_count10");
				var count = $("#tbl_"+ttlTbl+"_item_count10").val()
				var total__rates_itmes = $("#total__rates_itmes").val();
				var ttlroom=$("#ttlRoomService").val();
				var i=2;
				ttlroom=parseInt(ttlroom)+parseInt(i);
				//alert("#tbl_"+ttlTbl+"_item_count10::::"+count);
				count++;
				total__rates_itmes++;
				
				//alert(count);
				/* if(count<=10)
				{ */		
				//console.log($(this).parent().parent().parent().prev());
				var prev = $(this).parent().parent().prev().clone();
				
				$(prev).find('.dinnerCol').html('<input type="text" name="roomType_'+tblno+'_'+count+'_1" value="" onblur="add_room_name('+count+',$(this).val(),'+tblno+')" /><input type="hidden" name="roomName_'+tblno+'_'+count+'_1" value=""><input type="hidden" name="room_name_'+tblno+'_'+count+'_1" id="room_name_'+tblno+'_'+count+'_1" value=""/>');
				for(i=2;i<ttlroom;i++){
					var roomtype='roomType_'+tblno+'_'+count+'_'+i;
					//alert(roomtype);
					//alert('.roomType_'+tblno+'_'+i);
					$(prev).find('.roomType_'+tblno+'_'+i).attr({id:roomtype,name:roomtype});
					var roomtypeId='roomTypeId_'+tblno+'_'+count+'_'+i;
					$(prev).find('.roomTypeId_'+tblno+'_'+i).attr({id:roomtypeId,name:roomtypeId});
					var hotelRateId='hotelRateId_'+tblno+'_'+count+'_'+i;
					$(prev).find('.hotelRateId_'+tblno+'_'+i).attr({id:hotelRateId,name:hotelRateId,value:0});
				}
				$(prev).find('.delRow').remove();
				$(prev).find('.dinnerCol').parent().append('<td class="delRow"><a class="delete_row" tblNo="'+tblno+'" rel="'+count+'"  href="javascript:void(0)" ><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></td>');
				$(prev).insertBefore($(this).parent().parent());
				//$("#rows_1").after(' <tr id="row_'+count+'"><td><input type="text" name="roomType[]" placeholder="LiDI000009"></td> <td><input type="text" name="deluxe[]"  ></td><td><input type="text" name="premium[]"> </td><td><input type="text" name="metroview[]"></td><td><a class="delete_row" rel="'+count+'"  href="javascript:void(0)" ><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></td></tr> ');
				
				$("#item_count").val(count);			
				$("#tbl_"+tblno+"_item_count10").val(count);				
				//$("#total__rates_itmes").val(total__rates_itmes);
				/* }
				else
				{
					alert('You can not add more than 10 Items');
				} */
			});	
			function remove_attach1(counter)
			{
				//alert(counter);
				if(confirm("Do you want to delete?")){
				if(counter == '1')
					{
						$("#panCardDoc").val('');
						$('#panDocs').html('');
						$(".attach_new").css({"display": "none"});
			          
					}
					if(counter == '2')
					{
						$("#photoDoc").val('');
						$(".attach_new1").css({"display": "none"});
						$('#photoDocs').html('');
					}
					if(counter == '3')
					{
						$("#contCopyDoc").val('');
						$(".attach_new2").css({"display": "none"});
						$('#contactDocs').html('');
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
										if(counter == '1')
										{
											$("#panCardId").val('');
											$("#panCardDoc").val('');
											//$("#panDocs").css({"display": "none"});
											$(".attach_newed").css({"display": "none"});
											//$(".attach_new1").css({"display": "none"});
											//location.reload();
										}
										if(counter == '2')
										{
											$("#photoId").val('');
											$(".attach_newed1").css({"display": "none"});
											//location.reload();
										}
										if(counter == '3')
										{
											$("#addrProofId").val('');
											$(".attach_newed2").css({"display": "none"});
											//location.reload();
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

		function add_room_name(counter,value,tblCnt){
			//alert('#room_name_'+tblCnt+'_'+counter+'_1');
			$('#room_name_'+tblCnt+'_'+counter+'_1').val(value);
		}
		function remove_item1(counter)
		{
			$('#Email_'+counter).remove();
		}
		function remove_item2(counter)
		{
			$('#Mobnumbbr_'+counter).remove();
		}
		function remove_item3(counter)
		{
			$('#address_'+counter).remove();
		}
		function remove_item4(counter)
		{		
			if(counter > 1)
			{
			var count = $("#item_count1").val();
			
			var count1=	count-1;
			$("#item_count1").val(count1);
			}
			$('#address2_'+counter).remove();		
		}
		function remove_item5(counter)
		{		
			$('#Aminities_'+counter).remove();		
		}
		function remove_item6(counter, deleteId)
		{
			if(deleteId == '0')
			{
				$('#person_'+counter).remove();
			}
			else
			{
				if(confirm("Do you want to delete table?")){
					var data = 'type=delete_hotel_items&id='+deleteId+'&itemType=hConcernedPerson';
					$.ajax({
						type: "POST",
						url: "_ajax_hotel_prsnl_detail.php",
						data: data,
						cache: false,
						beforeSend:function() {
							//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
						},
						success: function(html)
						{
							$('#person_'+counter).remove();
							//counter--;
							//$("#item_count9").val(counter);
						}
					});
				}else{
					return false;
				}
				 
			}
		}
		function remove_item7(counter)
		{
			$('#connumbbr_'+counter).remove();
		}
		function remove_rate(counter, dateId)
		{
			if(dateId == '0')
			{
				$('#rates_'+counter).remove();
				counter--;
				$("#item_count9").val(counter);
			}
			else
			{
				if(confirm("Do you want to delete table?")){
					var data = 'type=delete_rates&dateId='+dateId;
					$.ajax({
						type: "POST",
						url: "_ajax_hotel_prsnl_detail.php",
						data: data,
						cache: false,
						beforeSend:function() {
							//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
						},
						success: function(html)
						{
							$('#rates_'+counter).remove();
							counter--;
							$("#item_count9").val(counter);
						}
					});
				}else{
					return false;
				}
				 
			}
		}
		function room_modal(count){
			
			
			$('#roomAmen').modal();
			$("#currentItem").val(count);
			var selected=$("#AminitiesF_"+count).val();
			var arrroomAmenty=selected.split(', ');
			
			$('.modalRoomAminities').each(function(){			
				if($.inArray($(this).val(), arrroomAmenty) !== -1)
				{
					//alert('he isme::'+$(this).val());
					$(this).attr('checked',true);
				}
				else
				{
					//alert('nhi he isme::'+$(this).val());
					$(this).removeAttr('checked');
				}
				
			});
		}
		function hotel_amenity_modal(){
			var selected=$("#Aminities").val();
			//alert(selected);
			var arrHotelAmenty=selected.split(', ');
			
			$('.modalAminities').each(function(){			
				if($.inArray($(this).val(), arrHotelAmenty) !== -1)
				{
					$(this).attr('checked',true);
				}
				
			});
			$('#hotelAmen').modal();
		}
	</script>
	  
	 <script>
	
	$("#hotal_personl_detail").validate({
	
			rules: {
				hotel_name: "required",				
				hotel_address1: "required",				
				hotel_star: "required",				
				'hotel_address1[]': "required",				
				'hotel_address2[]': "required",				
				'hotel_country[]': "required",				
				'hotel_state[]': "required",				
				'hotel_city[]': "required",				
				'hotel_pincode[]': "required",				
				'hotelPhone[]': "required",				
				'roomstype[]': "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
             
			submitHandler: function() { 
			var formData = new FormData($('#hotal_personl_detail')[0]);
			$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: formData,
					contentType: false,
                    cache: false,
                    processData:false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						
						//alert(html);
						//$("#hotel_more_detail_tab").click();
						
						var newUrl = '<?php echo $tabUrl.base64_encode(2); ?>';
						
						var separator = (newUrl.indexOf("?")===-1)?"?":"&";
						//console.log(newUrl + separator + "id="+html);
						window.location.href = newUrl + separator + "id="+html;	
						
						//window.location.href='<?php echo $tabUrl.base64_encode(2); ?>';
						
					}
				}); 
			//alert("submitted!");
		
			
		}
		});
	</script> 
<script>
	
	$("#hotel_bank_detail").validate({
	
			rules: {
				tcountry: "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
			
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_bank_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//$("#attach_doc_tab").click();
						window.location.href='<?php echo $tabUrl.base64_encode(4); ?>';
						/* var newUrl = '<?php echo $tabUrl.base64_encode(4); ?>';
						
						var separator = (newUrl.indexOf("?")===-1)?"?":"&";
						//console.log(newUrl + separator + "id="+html);
						window.location.href = newUrl + separator + "id=<?php echo $editHotelId; ?>";	 */
					}
				}); 
			}
		});
	</script>
<script>
	
	$("#hotel_more_detail").validate({
	
			rules: {
				tcountry: "required",				
				'title[]': "required",				
				'firstname[]': "required",							
				'userPhone[]': "required",				
				'code[]': "required",				
				'userEmail[]': "required",				
				'hotel_pass': "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
			
			
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_more_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//$("#banking_tab").click();
						//alert(html);
						//window.location.reload();
						window.location.href='<?php echo $tabUrl.base64_encode(3); ?>';
						/* var newUrl = '<?php echo $tabUrl.base64_encode(3); ?>';
						
						var separator = (newUrl.indexOf("?")===-1)?"?":"&";
						//console.log(newUrl + separator + "id="+html);
						window.location.href = newUrl + separator + "id=<?php echo $editHotelId; ?>"; */
					}
				}); 
			}
		});
	</script>
<script>
$(document).on('click', ".submit_rate_form", function(event){
		 	//alert("@@@@@");exit;
			//event.preventDefault();
			var id=$(this).attr('rel');
			//alert(id);
			$("#hotel_rate_"+id).validate({
			rules: {
				tcountry: "required"				
			},			
			
			messages: {
				tcountry: "Please select country"
				
			},
			submitHandler: function() { 
				for (instance in CKEDITOR.instances) {
					CKEDITOR.instances[instance].updateElement();
				}
			 
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail",
					data: $("#hotel_rate_"+id).serialize(),
					cache: false,
					beforeSend:function() {
						
					},
					success: function(data)
					{
						//alert(data);
			          //alert(html);
					  //return false;
					 location.reload();
					 if(data == 0)
					 {
						 alert('Data Already Exists'); 
					 }
					 else
					 {
						 alert('Data Saved Successfully'); 
					 }
					 //alert(data);
					 
					  //$("#tblR_"+id).toggle();
					  
						//alert(html);
						//window.location.href= 'hotel_list.php';
					}
				}); 
			}
		});
		
})


	   		$(document).on('click', ".submit_rate_form1", function(event){
		 	//alert("@@@@@");exit;
			//event.preventDefault();
			var id=$(this).attr('rel');
			//alert(id);
			$("#hotel_rate1_"+id).validate({
			rules: {
				tcountry: "required"				
			},			
			
			messages: {
				tcountry: "Please select country"
				
			},
			submitHandler: function() { 
				for (instance in CKEDITOR.instances) {
					CKEDITOR.instances[instance].updateElement();
				}
			 
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail",
					data: $("#hotel_rate1_"+id).serialize(),
					cache: false,
					beforeSend:function() {
						
					},
					success: function(html)
					{
						 if(html == 1)
					 {
						 //alert('Data Already Exists'); 
						 alert('Data Saved Successfully'); 
					 }
					 else
					 {
						 alert('Data Already Exists'); 
					 }
			          //alert(html);
					  //return false;
					  location.reload();
					 // alert('Data Saved Scuccessfully');
					  //$("#tblR_"+id).toggle();
					  
						//alert(html);
						//window.location.href= 'hotel_list.php';
					}
				}); 
			}
		});
		
})
	/* $("#hotel_rate").validate({
			rules: {
				tcountry: "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
				for (instance in CKEDITOR.instances) {
					CKEDITOR.instances[instance].updateElement();
				}
			 
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_rate").serialize(),
					cache: false,
					beforeSend:function() {
						
					},
					success: function(html)
					{
			          alert(html);
					  return false;
					  
						alert(html);
						window.location.href= 'hotel_list.php';
					}
				}); 
			}
		}); */
		 
		function remove_rate_items(rateId, row)
		{
			if(confirm("Do you want to delete?")){
				var data = 'type=delete_rate_items&rateId='+rateId;
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: data,
					cache: false,
					beforeSend:function() {
						
					},
					success: function(html)
					{
						//alert(html);
						if(html == true)
						{
							$("#r_"+row).remove();
						}
						//window.location.href= 'hotel_list.php';
					}
				}); 
			}
		}
		
		// function remove_rate_items(rateId, row)
		// {
			// if(confirm("Do you want to delete?")){
				// var data = 'type=delete_rate_items&rateId='+rateId;
				// $.ajax({
					// type: "POST",
					// url: "_ajax_hotel_prsnl_detail.php",
					// data: data,
					// cache: false,
					// beforeSend:function() {
						
					// },
					// success: function(html)
					// {
						//alert(html);
						// if(html == true)
						// {
							// $("#r_"+row).remove();
						// }
						//window.location.href= 'hotel_list.php';
					// }
				// }); 
			// }
		// }
		
		function remove_hotelitems(id, type, number)
		{
			if(confirm("Do you want to delete?")){
				var data = 'type=delete_hotel_items&id='+id+'&itemType='+type;
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: data,
					cache: false,
					beforeSend:function() {
						
					},
					success: function(html)
					{
						//alert(html);
						if(html == true)
						{
							if(type == 'hotelPhone')
							{
								$("#Mobnumbbr_"+number).remove();
							}
							else if(type == 'hotelRoom')
							{
								$("#address2_"+number).remove();
							}
							else if(type == 'hotel_concern_person')
							{
								$("#connumbbr_"+number).remove();
							}
							$("#"+type+'_'+id).remove();
						}
						//window.location.href= 'hotel_list.php';
					}
				}); 
			}
		}
	</script>
	<script>
	function meal_plan_func(id)
		{
			var hotel_id=id;
			var mealId= $("#meal_plan_new").val();
			$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail?action=get_meal_plan_date&id="+id+"&meal_id="+mealId,
					cache: false,
					beforeSend:function() {
						
					},
					success: function(data)
					{
						dateRange = [];
						var b=$.parseJSON(data);
						$.each(b, function(i,e ) {
							var start_date = e.from_date;
							var end_date = e.to_date;
							for (var d = new Date(start_date); d <= new Date(end_date); d.setDate(d.getDate() + 1)) {
								dateRange.push($.datepicker.formatDate('yy-mm-dd', d));
							}
						});
						$('.fromdate').datepicker({
							minDate:0,
							beforeShowDay: function (date) {
								var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
								return [dateRange.indexOf(dateString) == -1];
							}
						});
						$('.todate').datepicker({
							minDate:0,
							beforeShowDay: function (date) {
								var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
								return [dateRange.indexOf(dateString) == -1];
							}
						});
						
						
						$(".fromdate").attr("disabled",false);
						$(".todate").attr("disabled",false);
						
						//console.log(html);
					}
				});
			
		}
	</script>
		
	 <script src="asset/bootstrap-datepicker.js"></script>
	    <!--<script src="asset/jquery.timepicker.js"></script>
	    <script src="asset/bootstrap/css/jquery.timepicker.css"></script>-->
<?php  include('footer.php');?> 