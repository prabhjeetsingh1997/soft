<?php
include('header.php');
include('sidebar.php');
$travelId = $_SESSION['travelId'];
$countDiv='';
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
$firstSerId='';
$firstSerName='';
$secondSerId='';
$secondSerName='';
$thirdSerId='';
$thirdSerName='';
$fourthSerId='';
$fourthSerName='';
$fifthSerId='';
$fifthSerName='';
$sixthSerId='';
$sixthSerName='';
$seventhSerId='';
$seventhSerName='';
$eigthSerId='';
$eigthSerName='';

$recordId=0;
if($_GET['action']=='edit')
{
	$recordId = $editTravelAgentId=$_GET['id'];
	$travelData = $objtravel->getTravelAgentById($editTravelAgentId);
	$arrEmail=explode(',',$travelData['additional_email_address']);
	$countEmail=count($arrEmail);
	$travel_clnt_address_details = $objtravel->getTravelAgentClientAddressById($editTravelAgentId,'travel_agent_client_address');
	$trav_clnt_contact_numbers = $objtravel->getTravelClntNumByid($editTravelAgentId,'travel_agent_num');
	$service_details=$objtravel->getServiceDetailByid($editTravelAgentId);
	$concern_prsn_detail=$objtravel->getConcPrsnByid($editTravelAgentId,'travel');
	$concern_prsn_contact_numbers = $objtravel->getTravelClntNumByid($editTravelAgentId,'travel_query_num');
	$date_rates_detail=$objtravel->getDateRatesByid($editTravelAgentId);
	$attachdoc = $objtravel->getdocumentbyid($editTravelAgentId,'Travel');
	$ttlDoc=count($attachdoc);
	//print_r($attachdoc);
	
	$countTravelClntAddr=count($travel_clnt_address_details);
	$countTravelClntNum=count($trav_clnt_contact_numbers);
	$countService=count($service_details);
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
	//print_r($date_rates_detail);
	$getAllService=$objtravel->getAllServiceName();
	$countAllServiceName=count($getAllService);
	//print_r($getAllService);
}
$allServiceName=$objtravel->getAllServiceName();
$countServiceName=count($allServiceName);

$firstSerId=$allServiceName[0]['id'];
$firstSerName=$allServiceName[0]['service_name'];
$secondSerId=$allServiceName[1]['id'];
$secondSerName=$allServiceName[1]['service_name'];
$thirdSerId=$allServiceName[2]['id'];
$thirdSerName=$allServiceName[2]['service_name'];
$fourthSerId=$allServiceName[3]['id'];
$fourthSerName=$allServiceName[3]['service_name'];
$fifthSerId=$allServiceName[4]['id'];
$fifthSerName=$allServiceName[4]['service_name'];
$sixthSerId=$allServiceName[5]['id'];
$sixthSerName=$allServiceName[5]['service_name'];
$seventhSerId=$allServiceName[6]['id'];
$seventhSerName=$allServiceName[6]['service_name'];
$eigthSerId=$allServiceName[7]['id'];
$eigthSerName=$allServiceName[7]['service_name'];

$tab = 1;
if(isset($_GET['t']))
{
	$tab = base64_decode($_GET['t']);
}
$tabUrl = 'travel_Agent.php?t=';
if(isset($_GET['action']))
{
	$tabUrl = 'travel_Agent.php?action=edit&id='.$_GET['id'].'&t=';
}

$autoTravelId = $objAdmin->autogenerate_id($_SESSION['travelId'], 'T');


$arrTravelService=$objtravel->getTravelServiceByid($_SESSION['travelId']);
$url= trim($_SERVER['HTTP_HOST'], '/');
    if (!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
//print_r($arrFleetTrans);
$countServices=count($arrTravelService);
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
<script src="asset/plugins/jquery-superbox/js/superbox.js" type="text/javascript"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Add Travel Agent
            <small>Preview</small>
          </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Add Travel Agent</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <ul class="nav nav-tabs">
                       <!--  <li <?php if($tab == 1){ echo 'class="active"';}?>>
                            <a data-toggle="tab" href="#home">
                            <h3 class="box-title"><b>TRAVEL AGENT DETAILS</b></h3></a>
                        </li>
                        <li <?php if($tab == 2){ echo 'class="active"';}?>><a data-toggle="tab" href="#menu1"><h3 class="box-title"><b>MORE DETAILS</b></h3> </a></li>
                        <li <?php if($tab == 3){ echo 'class="active"';}?>><a data-toggle="tab" href="#menu2"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li> -->
                         <li <?php if($tab == 1){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a style="pointer-events:none !important;"data-toggle="tab" <?php if($tab != 1){ echo 'class="disabled"';}?> href="#home" title="Click next to open"> <h3 class="box-title"><b>TRAVEL AGENT DETAILS</b></h3></a></li>
				  <li <?php if($tab == 2){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a style="pointer-events:none !important;"data-toggle="tab" <?php if($tab != 2){ echo 'class="disabled"';}?> id="hotel_more_detail_tab" href="#menu1" title="Click next to open"><h3 class="box-title"><b>MORE DETAILS</b></h3> </a></li>
				  <li <?php if($tab == 3){ echo 'class="active"';}else{echo 'class="disabled"';}?>><a style="pointer-events:none !important;"data-toggle="tab" <?php if($tab != 3){ echo 'class="disabled"';}?> id="banking_tab" href="#menu2" title="Click next to open"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li> 
                       
                    </ul>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div id="status"></div>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade <?php if($tab == 1){ echo 'in active';}?>">
                        <form role="form" method="POST" name="travel_client_detail" id="travel_client_detail">
							<input type="hidden" name="editTravelid" id="editTravelid" value="<?php echo @$travelData['id'];?>"/>
                            <input type="hidden" id="item_count" name="item_count" value="1">
                            <input type="hidden" id="item_count1" name="item_count1" value="<?php if($countService>0){echo $countService;}else{echo 1;}?>">
                            <input type="hidden" id="item_count2" name="item_count2" value="1">
                            <input type="hidden" id="item_count3" name="item_count3" value="<?php if($countTravelClntNum>0){echo $countTravelClntNum;}else{echo 1;}?>">
                            <input type="hidden" id="item_count4" name="item_count4" value="1">
                            <input type="hidden" id="item_count5" name="item_count5" value="<?php if($countTravelClntAddr>0){echo $countTravelClntAddr;}else{echo 1;}?>">
                            <input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
                            <input type="hidden" name="domain" value="<?php echo $domain; ?>" />
                            <input type="hidden" name="type" value="add_travel_client_detail" />
                            <div class="box-body">
                                <div class="row">

                                    <!-- Frist Line -->

                                 <div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Company Name</b><span style="color:red;">*</span></h4>
									</div>
								</div>

                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="name">Hotal Name</label>-->
                                            <input type="text" class="form-control" name="travel_hotel_name" id="travel_hotel_name" placeholder="Company Name" value="<?php echo @$travelData['hotal_name']?>" />
                                        </div>
                                    </div>
                                    <!-- /.form-group -->

                                    <!-- /.first line -->
                                   <div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">Address</b><span style="color:red;">*</span></h4>
									</div>
								</div>
                                    <div class="items">
									<?php
										if($countTravelClntAddr>0)
							{
											$countDiv=1;
											foreach($travel_clnt_address_details as $key=>$val)
									  {
									?>
									<div id="address_<?php echo $countDiv;?>">
									
											<input type="hidden" name="clntAddrid_<?php echo $countDiv;?>" id="" value="<?php echo $val['id']?>"/>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Address Line 1</label>-->
                                                    <input type="text" class="form-control" name="address_<?php echo $countDiv;?>" id="address" placeholder="Address line 1" value="<?php echo $val['address1']; ?>" />
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Address Line 2</label>-->
                                                    <input type="text" class="form-control" name="addressline_<?php echo $countDiv;?>" id="addressline" placeholder="Address line 2" value="<?php echo $val['address2']; ?>" />
                                                </div>
                                            </div>
											<div class="col-md-2"><div class="form-group"></div></div>
											<div class="col-md-3">
												<div class="form-group">
													
													<select class="form-control select2" name="country_<?php echo $countDiv;?>" id="pramCountry" data-placeholder="Select a Country">
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
                                                
													<select class="form-control select2" name="state_<?php echo $countDiv;?>" id="pramState" data-placeholder="Select a State">
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
                                                    <!--<input type="text" class="form-control" name="city_<?php echo $countDiv;?>" id="city" placeholder="City" value="<?php echo $val['city']; ?>" />-->
													<select class="form-control select2" name="city_<?php echo $countDiv;?>" id="pramCity" data-placeholder="Select a City">
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
                                                    <input type="text" class="form-control" name="pincode_<?php echo $countDiv;?>" id="pincode" placeholder="Code" value="<?php echo $val['pin_code']; ?>" />
                                                </div>
                                            </div>
                                        </div>
										
                                        
									<?php
											
									$countDiv++;
										}
							}
							else
							{
										
									?>
									<div id="address_1">
									
											<input type="hidden" name="clntAddrid_1" id="" value=""/>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Address Line 1</label>-->
                                                    <input type="text" class="form-control" name="address_1" id="address" placeholder="Address line 1" value="" />
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Address Line 2</label>-->
                                                    <input type="text" class="form-control" name="addressline_1" id="addressline" placeholder="Address line 2" value="" />
                                                </div>
                                            </div>
											<div class="col-md-2"><div class="form-group"></div></div>
											<div class="col-md-3">
												<div class="form-group">
													
											<select class="form-control select2" name="country_1" id="pramCountry" data-placeholder="Select a Country">
														<option value="">--Select Country--</option>
														<?php
															foreach($arrcountery as $count)
															{ 
														?>	
															<option value="<?php echo $count['id']; ?>" ><?php echo $count['country_name']; ?></option>
														<?php		
															}
														?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
                                                <div class="form-group">
                                                
													<select class="form-control select2" name="state_1" id="pramState" data-placeholder="Select a State">
														<option value="">--Select State--</option>
														
													</select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                   
													<select class="form-control select2" name="city_1" id="pramCity" data-placeholder="Select a City">
														<option value="">--Select City--</option>
														
													</select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <!--<label for="last">Pin Code</label>-->
                                                    <input type="text" class="form-control" name="pincode_1" id="pincode" placeholder="Code" value="" />
                                                </div>
                                            </div>
                                        </div>
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
                                    <div class="items3">
										<?php
										if($countTravelClntNum>0)
										{
											$countDiv=1;
											foreach($trav_clnt_contact_numbers as $key=>$val)
											{
										?>
										<div id="Mobnumbbr_<?php echo $countDiv;?>">
										<?php
											if($countDiv>1)
											{
										?>
										<div class="col-md-2"><div class="form-group"> </div></div>
										<?php
											}
										?>
											<input type="hidden" name="tra_clnt_num_id_<?php echo $countDiv;?>" id="tra_clnt_num_id_<?php echo $countDiv;?>" value="<?php echo $val['id'];?>"/>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Mobile</label>-->
                                                    <input type="number" class="form-control" name="userPhone_<?php echo $countDiv;?>" id="userPhone" placeholder="Mobile Number" value="<?php echo $val['contact_no']; ?>" />
                                                </div>
                                            </div>
                                           <div class="col-md-3">
												<div class="form-group">
													<!--<label for="middle">Code</label>-->
													<select class="form-control valid" name="code_<?php echo $countDiv;?>" placeholder="Code" value="" aria-invalid="false">
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
                                                    <input type="text" class="form-control" name="last_<?php echo $countDiv;?>" id="last" placeholder="Enter Valid Number" value="" />
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
                                                <a href="javascript:void(0);" class="Mnumbbr" id="Mnumbbr" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                            </div>
                                        </div>

										<?php
											}
											 if($countDiv > 1)
											 {
											 	?>
											 	<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_item10(<?php echo $countDiv;?>,<?php echo $val['id'];?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
											 	<?php 
											 }
											$countDiv++;

											}
											?>

											<?php
										}

										else
										{
										?>
                                        <div id="Mobnumbbr_1">
											<input type="hidden" name="tra_clnt_num_id_1" id="tra_clnt_num_id_1" value=""/>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Mobile</label>-->
                                                    <input type="number" class="form-control" name="userPhone_1" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>" />
                                                </div>
                                            </div>
                                           <div class="col-md-3">
												<div class="form-group">
													<!--<label for="middle">Code</label>-->
													<select class="form-control valid" name="code_1" placeholder="Code" value="" aria-invalid="false">
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
                                                    <input type="text" class="form-control" name="last_1" id="last" placeholder="Enter Valid Number" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <!--<label for="last">Add More</label>-->
                                                <a href="javascript:void(0);" class="Mnumbbr" id="Mnumbbr" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                            </div>
                                        </div>
										<?php
										}
										?>
                                    </div>

                                    <!-- /.second line -->
                                   
                                    <div class="items1">
										<?php
											if($countService>0)
											{
												$i=0;
												$countDiv=0;
												foreach($service_details as $key=>$val)
												{
													$i++;
													$countDiv++;
													$serviceId=$val['id'];
													$travelid=$travelData['id'];
													$travelServiceImages=$objtravel->getServiceImagesById($serviceId,$travelid);
										?>
										
							<!-- 			 <div id="address2_<?php echo $countDiv;?>">
										<?php
											if($countDiv == 1)
											{
										?>
										<div class="col-md-2">
											<div class="form-group">
												<h4 class="box-title"><b style="font-size: 17px;">Services</b></h4>
											</div>
										</div>
										<?php
											}
											if($countDiv>1)
											{
										?>
										<div class="col-md-2"><div class="form-group"></div></div>
										<?php
											}
										?>
										 <input type="hidden" name="servDetailId_<?php echo $countDiv;?>" id="servDetailId_<?php echo $countDiv;?>" value="<?php echo $val['id'];?>"/>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                  
                                                    <input type="text" class="form-control" name="stype_<?php echo $countDiv;?>" id="roomstype" placeholder="Service Type" value="<?php echo $val['stype']; ?>" />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                   
                                                    <input type="text" class="form-control" name="sDescription_<?php echo $countDiv;?>" id="RDescription" placeholder="Service Description" value="<?php echo $val['description']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                 
                                                    <input type="text" class="form-control" name="AminitiesF_<?php echo $countDiv;?>" id="AminitiesF" placeholder="Amenities & Facilities" value="<?php echo $val['aminities']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                   
                                                    <input type="text" class="form-control" name="Units_<?php echo $countDiv;?>" id="Units" placeholder="Units" value="<?php echo $val['units']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    
                                                    <input type="file" class="form-control" name="Pics_<?php echo $countDiv;?>" id="Pics_<?php echo $countDiv;?>" placeholder="Pics" value="<?php echo $val['pics']; ?>" multiple="true"/>
                                                </div>
                                            </div>
                                        </div> -->
										<?php
											if($countDiv>1)
											{
										?>
										<div style="clear:both;"></div>
										<?php
											}
											if($countDiv == 1)
											{
										?>
                                       <!--  <div class="col-md-1">
                                            <div class="form-group">
                                                
                                                <a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                            </div>
                                        </div> -->
										<div style="clear:both;"></div>
										<?php
											}
											?>
										<div class="col-sm-10 col-md-offset-2">
											<div class="pull-left">
												<div id="service_images_<?php echo $i;?>" class="pull-left">
										<?php
										$editImgSrt = '';
										$editImgId = '';
											foreach($travelServiceImages as $k=>$value)
											{
												//print_r($value);
												$editImgSrt .= $value['image'].',';
												$editImgId .= $value['id'].',';
										?>
											<img src="document/travel_doc/service_pic/<?php echo $value['image']; ?>" data-img="document/travel_doc/service_pic/<?php ?>" id="delete_full_img_<?php echo $value['id']; ?>" alt="" class="superbox-img images" style="width:85px;height:85px;margin:10px;">
											<img class="remove_img" id="delete_img_<?php echo $value['id'];?>" src="document/travel_doc/service_pic/x.png" relId="<?php echo $value['id'];?>" alt="delete" relImgId="<?php echo $value['image'];?>" relImgNum="<?php echo $countDiv;?>"/>
										<?php
											}
										?>
												</div>
										<input type="hidden" name="serviceImg_<?php echo $countDiv;?>" id="serviceImg_<?php echo $countDiv;?>" value="<?php echo $editImgSrt;?>"/>
										<input type="hidden" name="servicePicId_<?php echo $countDiv;?>" id="servicePicId_<?php echo $countDiv;?>" value="<?php echo $editImgId;?>"/>
											</div>
										</div>
											<?php
										
												}
											}
											else
											{
										?>
										<div style="clear:both;"></div>	
                                   <!--      <div id="address2_1">
										<div class="col-md-2">
											<div class="form-group">
												<h4 class="box-title"><b style="font-size: 17px;">Services</b></h4>
											</div>
										</div>
										 <input type="hidden" name="servDetailId_1" id="servDetailId_1" value="0"/>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                  
                                                    <input type="text" class="form-control" name="stype_1" id="roomstype" placeholder="Service Type" value="<?php echo $usrData['mobileno']; ?>" />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                   
                                                    <input type="text" class="form-control" name="sDescription_1" id="RDescription" placeholder="Service Description" value="<?php echo $usrData['mobileno']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                   
                                                    <input type="text" class="form-control" name="AminitiesF_1" id="AminitiesF" placeholder="Amenities & Facilities" value="" />
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    
                                                    <input type="text" class="form-control" name="Units_1" id="Units" placeholder="Units" value="" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                   
                                                    <input type="file" class="form-control" name="Pics_1" id="Pics_1" placeholder="Pics" value="" multiple="true"/>
													<input type="hidden" name="serviceImg_1" id="serviceImg_1" value=""/>
                                                </div>
                                            </div>
                                        </div> -->

                                      <!--   <div class="col-md-1">
                                            <div class="form-group">
                                              
                                                <a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                            </div>
                                        </div> -->
										<div class="col-sm-10 col-md-offset-2">
											<div class="pull-left">
												<div id="service_images_1" class="pull-left">
													
												</div>
											</div>
										</div>
										<?php
										}
										?>
                                    </div>
									<div style="clear:both;"></div>
                                    <!-- /.third line -->

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">Base Currency</b></h4>
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="userPhone">Base Currency</label>-->
                                            <select class="form-control" name="travel_base_currency" id="travel_base_currency">
                                                <option>Select</option>
                                                <option value="USD" <?php if(@$travelData['base_currency'] == 'USD'){echo "selected";}?> >USD </option>
                                                <option value="INR" <?php if(@$travelData['base_currency'] == 'INR'){echo "selected";}?>>INR </option>
                                                <option value="EUR" <?php if(@$travelData['base_currency'] == 'EUR'){echo "selected";}?>>EUR </option>
                                                <option value="JPY" <?php if(@$travelData['base_currency'] == 'JPY'){echo "selected";}?>>JPY </option>
                                                <option value="GBP" <?php if(@$travelData['base_currency'] == 'GBP'){echo "selected";}?>>GBP</option>
                                                <option value="AUD" <?php if(@$travelData['base_currency'] == 'AUD'){echo "selected";}?>>AUD</option>
                                                <option value="CHF" <?php if(@$travelData['base_currency'] == 'CHF'){echo "selected";}?>>CHF</option>
                                                <option value="CAD" <?php if(@$travelData['base_currency'] == 'CAD'){echo "selected";}?>>CAD</option>
                                                <option value="MXN" <?php if(@$travelData['base_currency'] == 'MXN'){echo "selected";}?>>MXN</option>
                                                <option value="CNY" <?php if(@$travelData['base_currency'] == 'CNY'){echo "selected";}?>>CNY</option>
                                                <option value="NZD" <?php if(@$travelData['base_currency'] == 'NZD'){echo "selected";}?>>NZD</option>
                                                <option value="SEK" <?php if(@$travelData['base_currency'] == 'SEK'){echo "selected";}?>>SEK</option>
                                                <option value="RUB" <?php if(@$travelData['base_currency'] == 'RUB'){echo "selected";}?>>RUB</option>
                                                <option value="HKD" <?php if(@$travelData['base_currency'] == 'HKD'){echo "selected";}?>>HKD</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">Description</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="form-group">

                                                <textarea type='text' class="form-control" name="travel_description" id="travel_description"><?php echo @$travelData['description'];?></textarea>

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
                        <form role="form" method="POST" name="travel_query_detail" id="travel_query_detail">
						<input type="hidden" name="editTravelid" id="editTravelid" value="<?php echo @$travelData['id'];?>"/>
                            <input type="hidden" id="concpeople4" name="concpeople4" value="<?php if($countConcPrsn>0){echo $countConcPrsn;}else{echo 1;}?>">
                            <input type="hidden" id="item_count1" name="item_count1" value="1">
                            <input type="hidden" id="item_count2" name="item_count2" value="1">
                            <input type="hidden" id="contact3" name="contact3" value="<?php if($countConcPrsnNum>0){echo $countConcPrsnNum;}else{echo 1;}?>">
                            <input type="hidden" id="email2" name="email2" value="1">
                            <input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
                            <input type="hidden" name="type" value="add_travel_query_detail" />
                            <input type="hidden" name="travelId" value="<?php echo $travelId; ?>" />
                            <div class="box-body">
                                <div class="row">

                                   <div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	 Travel Agent ID </b></h4>
									</div>
								</div>

                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="name"> Travel Agent ID</label>-->
                                           <!--  <input type="text" class="form-control" name="travel_id" id="travel_id" placeholder="Travel Agent ID" value="<?php if(isset($travelData['travel_agentr_id'])){echo $travelData['travel_agentr_id'];}else{echo $_SESSION['travelId'];}?>" readonly /> -->
                                           <input type="text" class="form-control " name="travel_id" id="travel_id" placeholder="Travel ID" value="<?php echo $autoTravelId; ?>" readonly/>
                                        </div>
                                    </div>
                                    <!-- /.form-group -->

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
										if($countDiv>1)
										{
										?>
										<!-- <div class="col-md-2"><div class="form-group"></div></div> -->
										<?php
										}
										?>
										<div class="clearfix"></div>
								        <input type="hidden" name="concPrsnId_<?php echo $countDiv;?>" id="concPrsnId_<?php echo $countDiv;?>" value="<?php echo $val['id'];?>"/>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!--<label for="title">Title</label>-->
                                                    <select class="form-control" name="title_<?php echo $countDiv;?>">
														<option>--</option>
                                                        <option value="Mr." <?php if($val['title'] == 'Mr.'){echo "selected";}?> >Mr.</option>
                                                        <option value="Miss." <?php if($val['title'] == 'Miss.'){echo "selected";}?>>Miss.</option>
                                                        <option value="Mrs." <?php if($val['title'] == 'Mrs.'){echo "selected";}?>>Mrs.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <!--<label for="firstname">First Name</label>-->
                                                    <input type="text" class="form-control" name="firstname_<?php echo $countDiv;?>" id="firstname" placeholder="First Name" value="<?php echo $val['first_name'];?>" />
                                                </div>
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <!--<label for="middle">Middle Name</label>-->
                                                    <input type="text" class="form-control" name="middle_<?php echo $countDiv;?>" id="middle" placeholder="Middle Name" value="<?php echo $val['middlename'];?>" />
                                                </div>
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <!--<label for="last">Last Name</label>-->
                                                    <input type="text" class="form-control" name="lastname_<?php echo $countDiv;?>" id="last" placeholder="Last Name" value="<?php echo $val['lastname'];?>" />
                                                </div>
                                            </div>
                                        
									<?php 
									if($countDiv==1)
									{									
									}
									else
									{
									?>
									<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_item9(<?php echo $countDiv;?>,<?php echo $val['id'];?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
										
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
										<input type="hidden" name="concPrsnId_1" id="concPrsnId_1" value="0"/>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!--<label for="title">Title</label>-->
                                                    <select class="form-control" name="title_1">
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
                                                    <input type="text" class="form-control" name="firstname_1" id="firstname" placeholder="First Name" value="" />
                                                </div>
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <!--<label for="middle">Middle Name</label>-->
                                                    <input type="text" class="form-control" name="middle_1" id="middle" placeholder="Middle Name" value="" />
                                                </div>
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <!--<label for="last">Last Name</label>-->
                                                    <input type="text" class="form-control" name="lastname_1" id="last" placeholder="Last Name" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <!--<label for="last">Add More</label>-->
                                                <a href="javascript:void(0);" class="add_more_item" id="add_more_item" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
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
                                            <h4 class="box-title"><b style="font-size: 17px;">Contact Nos</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10" style="padding:0">
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
									if($countDiv>1)
									{
									?>
									<!-- <div class="col-md-2"><div class="form-group"></div></div> -->
									<?php
									}
									?>
									<div class="clearfix"></div>
											<input type="hidden" name="concPrsnNumId_<?php echo $countDiv;?>" id="concPrsnNumId_<?php echo $countDiv;?>" value="<?php echo $val['id'];?>"/>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Mobile</label>-->
                                                    <input type="number" class="form-control" name="userPhone_<?php echo $countDiv;?>" id="userPhone" placeholder="Mobile Number" value="<?php echo $val['contact_no']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
												<div class="form-group">
													<!--<label for="middle">Code</label>-->
													<select class="form-control valid" name="code_<?php echo $countDiv;?>" placeholder="Code" value="" aria-invalid="false">
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
								<div class="col-md-1"> <div class="form-group"><a class="delete" rel="<?php echo $countDiv; ?>" href="javascript:void(0)" onclick="remove_item8(<?php echo $countDiv;?>,<?php echo $val['id'];?>)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div>
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
										<input type="hidden" name="concPrsnNumId_1" id="concPrsnNumId_1" value="0"/>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <!--<label for="userPhone">Mobile</label>-->
                                                    <input type="number" class="form-control" name="userPhone_1" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
												<div class="form-group">
													<!--<label for="middle">Code</label>-->
													<select class="form-control valid" name="code_1" placeholder="Code" value="" aria-invalid="false">
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
                                                    <input type="text" class="form-control" name="last_1" id="last" placeholder="Enter Valid Number" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <!--<label for="last">Add More</label>-->
                                                <a href="javascript:void(0);" class="Mnumbr" id="contumbbr" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
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
										<div id="Email_<?php echo $countDiv;?>">
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
                                                    <!--<label for="userEmail">Email</label>-->
                                                    <input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="<?php echo $arrEmail[$i]; ?>" />
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
                                        <div id="Email_1">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <!--<label for="userEmail">Email</label>-->
                                                    <input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="<?php echo $usrData['email']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <!--<label for="last">Add More</label>-->
                                                <a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                            </div>
                                        </div>
										<?php
										}
										?>
                                    </div>
                                </div>

                                    <!--<div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">User ID</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="namme">User ID</label>
                                            <input type="text" class="form-control" name="travel_userId" id="travel_userId" placeholder="User ID" value="<?php echo @$travelData['travel_agent_user_id'];?>" />
                                        </div>
                                    </div>-->
                                    <div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Password</b><span style="color:red;">*</span></h4>
									</div>
								</div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <!--<label for="name">Password</label>-->
                                            <input type="text" class="form-control" name="travel_pass" id="userPhone" placeholder="travel_pass" value="<?php echo @$travelData['travel_agent_password'];?>" />
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
                        <form role="form" method="POST" name="travel_bank_detail" id="travel_bank_detail">
						<input type="hidden" name="editTravelid" id="editTravelid" value="<?php echo @$travelData['id'];?>"/>
                            <input type="hidden" id="item_count" name="item_count" value="1">
                            <input type="hidden" id="item_count1" name="item_count1" value="1">
                            <input type="hidden" id="item_count2" name="item_count2" value="1">
                            <input type="hidden" id="item_count3" name="item_count3" value="1">
                            <input type="hidden" id="item_count4" name="item_count4" value="1">
                            <input type="hidden" name="type" value="add_travel_bank_detail" />
                            <input type="hidden" name="travelId" value="<?php echo $travelId; ?>" />
                            <div class="box-body">
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">PAN No.</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="search">PAN No.</label>-->
                                            <input type="text" class="form-control " name="travel_pan_no" id="travel_pan_no" placeholder="PAN No." value="<?php echo @$travelData['pan_no'];?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">Account No.</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="search">Account No.</label>-->
                                            <input type="text" class="form-control " name="travel_account_no" id="travel_account_no" placeholder="Account No." value="<?php echo @$travelData['account_no'];?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">Account Name</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="search">Account Name</label>-->
                                            <input type="text" class="form-control " name="travel_account_name" id="travel_account_name" placeholder="Account Name" value="<?php echo @$travelData['account_name'];?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">Bank</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="search">Bank</label>-->
                                            <input type="text" class="form-control " name="travel_bank" id="travel_bank" placeholder="Bank" value="<?php echo @$travelData['bank_name'];?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">Branch</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="search">Branch</label>-->
                                            <input type="text" class="form-control " name="travel_branch" id="travel_branch" placeholder="Branch" value="<?php echo @$travelData['branch_name'];?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h4 class="box-title"><b style="font-size: 17px;">IFSC</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <!--<label for="search">IFSC</label>-->
                                            <input type="text" class="form-control " name="travel_ifsc" id="travel_ifsc" placeholder="IFSC" value="<?php echo @$travelData['ifsc'];?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                           </div>
                        </form>
                    </div>
                     <!-- <div id="menu3" class="tab-pane fade <?php if($tab == 4){ echo 'in active';}?>">
                        <form role="form" method="POST" name="travel_doc_detail" id="travel_doc_detail" enctype="multipart/form-data">
						<input type="hidden" name="editTravelid" id="editTravelid" value="<?php echo @$travelData['id'];?>"/>
                            <input type="hidden" id="item_count" name="item_count" value="1">
                            <input type="hidden" id="item_count1" name="item_count1" value="1">
                            <input type="hidden" id="item_count2" name="item_count2" value="1">
                            <input type="hidden" id="item_count3" name="item_count3" value="1">
                            <input type="hidden" id="item_count4" name="item_count4" value="1">
                            <input type="hidden" id="type" name="type" value="add_travel_doc_detail">
							<input type="hidden" name="totalFld" id="totalFld" value="<?php if(isset($ttlDoc)&&!empty($ttlDoc)){echo $ttlDoc;}else{echo 4;}?>"/>
                            <input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
							
                            <div class="box-body">
                                <div class="row">
									<div class="myattch">
										<div id="attch_1">
											<input type="hidden" name="attachEdId[]" id="panCardId" value="<?php echo $pancardId; ?>"/>
											<div class="col-md-2">
												<div class="form-group">
													<h4 class="box-title"><b style="font-size: 17px;">	PAN Card </b></h4>
													<input type="hidden" name="docFileName[]" id="panCardFileName" value="PAN Card"/>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													
													<input type="file" class="form-control" name="file_upload[]" id="travel_pan_card_copy" value="" />
													<input type="hidden" name="upldFileName[]" id="panCardDoc" value="<?php echo $pancardAttach; ?>"/>
												</div>
											</div>
											<div class="col-md-4">
												<div id="panCardDocName" style="height:60px;"><?php echo $pancardAttach;?></div>
											</div>
										</div>
											<div style="clear:both;"></div>
											 
										<div id="attch_2">
											<input type="hidden" name="attachEdId[]" id="photoId" value="<?php echo $photoDocId; ?>"/>
											<div class="col-md-2">
												<div class="form-group">
													<h4 class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
													<input type="hidden" name="docFileName[]" id="photoFileName" value="Photo"/>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													
													<input type="file" class="form-control" name="file_upload[]" id="travel_photo_copy" value="" />
													<input type="hidden" name="upldFileName[]" id="photoDoc" value="<?php echo $photoAttach;?>"/>
												</div>
											</div>
											<div class="col-md-4">
												<div id="photoDocName"><?php echo $photoAttach; ?></div>
											</div>
										</div>
											<div style="clear:both;"></div>
											
										<div id="attch_3">
											<input type="hidden" name="attachEdId[]" id="contCopyId" value="<?php echo $contDocId; ?>"/>
											<div class="col-md-2">
												<div class="form-group">
													<h4 class="box-title"><b style="font-size: 17px;">Contract</b></h4>
													<input type="hidden" name="docFileName[]" id="contractFileName" value="Contract"/>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													
													<input type="file" class="form-control" name="file_upload[]" id="travel_Contract_copy" value="" />
													<input type="hidden" name="upldFileName[]" id="contCopyDoc" value="<?php echo $contAttach; ?>"/>
												</div>
											</div>
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
											<input type="hidden" name="attachEdId[]" id="addMoreId" value="<?php echo $attachdoc[$i]['id']; ?>"/>
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
                                <button type="button" class="btn btn-primary" name="travel_doc_detail_btn" id="travel_doc_detail_btn">Next</button>
                            </div>
                        </form>
                    </div> -->
<!--                     <div id="menu4" class="tab-pane fade <?php if($tab == 5){ echo 'in active';}?>">

                        <form role="form" method="POST" name="travel_rate" id="travel_rate">
							<input type="hidden" name="editTravelid" id="editTravelid" value="<?php echo @$travelData['id'];?>"/>
                            <input type="hidden" id="item_count" name="item_count" value="1">
                            <input type="hidden" id="item_count1" name="item_count1" value="1">
                            <input type="hidden" id="item_count2" name="item_count2" value="1">
                            <input type="hidden" id="item_count3" name="item_count3" value="1">
                            <input type="hidden" id="item_count4" name="item_count4" value="1">
                            <input type="hidden" id="item_count9" name="item_count9" value="<?php if($countDateRate>0){echo $countDateRate;}else{echo 1;}?>">
                            <input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countService;}else{ echo $countServices;}?>">
							<input type="hidden" id="service_count" name="service_count" value="<?php if($_GET['action'] == 'edit'){echo $countAllServiceName;}else{echo $countServiceName;}?>">
                            <input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
                            <input type="hidden" name="type" value="travel_agent_rates_detail" />
                            <input type="hidden" name="travel_agent_id" value="<?php echo $hotelId; ?>" />
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
										<div id="rates_<?php echo $i;?>">
										<input type="hidden" name="dateRateId_<?php echo $i;?>" id="dateRateId" value="<?php echo $date_rates_detail[$i-1]['id'];?>"/>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <h4 class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search">From:Calender</label>
                                                    <input type="text" class="form-control fromdate" name="fromdate_<?php echo $i;?>" id="fromdate" placeholder="Name" value="<?php echo date('j M Y',strtotime(@$date_rates_detail[$i-1]['from_date']));?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search">To:Calender</label>
                                                    <input type="text" class="form-control todate" name="todate_<?php echo $i;?>" id="todate" placeholder="Name" value="<?php echo date('j M Y',strtotime(@$date_rates_detail[$i-1]['to_date']));?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-1">

                                            </div>

                                            <div class="bs-example col-md-12">
                                                <table class="table">
                                                    <thead>											
												<tr>
													<?php
													if($countService>0)
													{
													?>
													<th></th>
													<?php
														foreach($service_details as $key=>$val)
														{
															//print_r($val);
													?>
													<th style="width: 40px;"><?php echo $val['stype'];?></th>
													<?php
														}
													
													?>
												</tr>
											</thead>
											<tbody border="1px"> 
												<?php
													for($k=1;$k<=$countAllServiceName;$k++)
													{
														$edCountService=1;
														//print_r($getAllService);
												?>
												<tr style="height:20px;">
													
													
													<td><?php echo $getAllService[$k-1]['service_name'];?><input type="hidden" name="serviceNameId_1_<?php echo $k;?>_<?php echo $edCountService;?>" value="<?php echo $getAllService[$k-1]['id'];?>"></td>
													<?php
														
														foreach($service_details as $key=>$val)
														{
															$edCountService++;
															//$fleetvehiId=$val['id'];
															//$transporter_rates_detail=$objtransporter->getTransporterRatesByid(@$transpData['id'],$dateId,$fleetvehiId);
															//$countTransporterRates=count($transporter_rates_detail);
															$travelServiceId=$val['id'];
															$travel_rates_detail=$objtravel->getTravelRatesByid(@$travelData['id'],$dateId,$travelServiceId);
															$countTravelRates=count($travel_rates_detail);
															
													?>
													<td>
														<input type="text" name="servicePrice_1_<?php echo $k;?>_<?php echo $edCountService;?>" value="<?php echo $travel_rates_detail[$k-1]['price'];?>">
														<input type="hidden" name="serviceTypeId_1_<?php echo $k;?>_<?php echo $edCountService;?>" value="<?php echo $val['id'];?>">
														<input type="hidden" name="serviceRateId_1_<?php echo $k;?>_<?php echo $edCountService;?>" value="<?php echo $travel_rates_detail[$k-1]['id'];?>"/>
														
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
										if($countDiv == 1)
										{
										?>
                                        <div class="form-group">
                                            <label for="last">Add More table</label>
                                            <a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                        </div>
										<?php
										}
										$countDiv++;
											}
										}
										else
										{
										?>
                                        <div id="rates_1">
										<input type="hidden" name="dateRateId_1" id="dateRateId" value="0"/>
										
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <h4 class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search">From:Calender</label>
                                                    <input type="text" class="form-control fromdate" name="fromdate_1" id="fromdate" placeholder="Name" value="Date" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search">To:Calender</label>
                                                    <input type="text" class="form-control todate" name="todate_1" id="todate" placeholder="Name" value="Date" />
                                                </div>
                                            </div>
                                            <div class="col-md-1">

                                            </div>

                                            <div class="bs-example col-md-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <?php
															if($countServices>0)
															{
															?>
																<th></th>
															<?php
																foreach($arrTravelService as $key=>$val)
																{
															?>
													
																<th style="width: 40px;"><?php echo $val['stype'];?></th>
																<?php
																}
																?>
                                                        </tr>
                                                    </thead>
                                                    <tbody border="1px">
													
                                                        <tr>
															<?php
																$serviceCount1=1;
															?>
                                                            <td><?php echo $firstSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_1_<?php echo $serviceCount1;?>" value="<?php echo $firstSerId;?>">
                                                            </td>
															<?php
														
															foreach($arrTravelService as $key1=>$val1)
															{
															$serviceCount1++;	
															?>
                                                            <td>
                                                                <input type="text" name="servicePrice_1_1_<?php echo $serviceCount1;?>" value="">
																<input type="hidden" name="serviceTypeId_1_1_<?php echo $serviceCount1;?>" value="<?php echo $val1['id'];?>">
																<input type="hidden" name="serviceRateId_1_1_<?php echo $serviceCount1;?>" value=""/>
													
                                                            </td>
                                                            
															<?php
															}
															?>
                                                            <td rowspan="8">
                                                                <textarea name="description_1" rows="17" cols="21"> Description </textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
															<?php
																$serviceCount2=1;
															?>
                                                            <td><?php echo $secondSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_2_<?php echo $serviceCount2;?>" value="<?php echo $secondSerId;?>">
                                                            </td>
															<?php
														
																foreach($arrTravelService as $key2=>$val2)
																{
																	$serviceCount2++;
															?>
                                                            <td>
                                                                 <input type="text" name="servicePrice_1_2_<?php echo $serviceCount2;?>" value="">
																<input type="hidden" name="serviceTypeId_1_2_<?php echo $serviceCount2;?>" value="<?php echo $val2['id'];?>">
																<input type="hidden" name="serviceRateId_1_2_<?php echo $serviceCount2;?>" value=""/>
                                                            </td>
															<?php
															}
															?>
                                                        </tr>
                                                        <tr>
														<?php
															$serviceCount3=1;
														?>
                                                            <td><?php echo $thirdSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_3_<?php echo $serviceCount3;?>" value="<?php echo $thirdSerId;?>">
                                                            </td>
														<?php
														
															foreach($arrTravelService as $key3=>$val3)
															{
																$serviceCount3++;
														?>
                                                            <td>
                                                                <input type="text" name="servicePrice_1_3_<?php echo $serviceCount3;?>" value="">
																<input type="hidden" name="serviceTypeId_1_3_<?php echo $serviceCount3;?>" value="<?php echo $val3['id'];?>">
																<input type="hidden" name="serviceRateId_1_3_<?php echo $serviceCount3;?>" value=""/>
                                                            </td>
                                                            
														<?php
															}
														?>
                                                        </tr>
                                                        <tr>
														<?php
												
															$serviceCount4=1;
														?>
                                                            <td><?php echo $fourthSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_4_<?php echo $serviceCount4;?>" value="<?php echo $fourthSerId;?>">
                                                            </td>
														<?php
													
															foreach($arrTravelService as $key4=>$val4)
															{
																$serviceCount4++;
														?>
                                                            <td>
                                                                <input type="text" name="servicePrice_1_4_<?php echo $serviceCount4;?>" value="">
																<input type="hidden" name="serviceTypeId_1_4_<?php echo $serviceCount4;?>" value="<?php echo $val4['id'];?>">
																<input type="hidden" name="serviceRateId_1_4_<?php echo $serviceCount4;?>" value=""/>
                                                            </td>
														<?php
															}
														?>
                                                        </tr>
                                                        <tr>
														<?php
															$serviceCount5=1;
														?>
                                                            <td><?php echo $fifthSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_5_<?php echo $serviceCount5;?>" value="<?php echo $fifthSerId;?>">
                                                            </td>
														<?php
													
															foreach($arrTravelService as $key5=>$val5)
															{
																$serviceCount5++;
														?>
                                                            <td>
                                                                <input type="text" name="servicePrice_1_5_<?php echo $serviceCount5;?>" value="">
																<input type="hidden" name="serviceTypeId_1_5_<?php echo $serviceCount5;?>" value="<?php echo $val5['id'];?>">
																<input type="hidden" name="serviceRateId_1_5_<?php echo $serviceCount5;?>" value=""/>
                                                            </td>
														<?php
															}
														?>
                                                        </tr>
                                                        <tr>
														<?php
												
															$serviceCount6=1;
														?>
                                                            <td><?php echo $sixthSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_6_<?php echo $serviceCount6;?>" value="<?php echo $sixthSerId;?>">
                                                            </td>
														<?php
													
															foreach($arrTravelService as $key6=>$val6)
															{
																$serviceCount6++;
														?>
                                                            <td>
                                                                <input type="text" name="servicePrice_1_6_<?php echo $serviceCount6;?>" value="">
																<input type="hidden" name="serviceTypeId_1_6_<?php echo $serviceCount6;?>" value="<?php echo $val6['id'];?>">
																<input type="hidden" name="serviceRateId_1_6_<?php echo $serviceCount6;?>" value=""/>
                                                            </td>
														<?php
															}
														?>
                                                        </tr>
                                                        <tr>
														<?php
															$serviceCount7=1;
														?>
                                                            <td><?php echo $seventhSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_7_<?php echo $serviceCount7;?>" value="<?php echo $seventhSerId;?>">
                                                            </td>
														<?php
													
															foreach($arrTravelService as $key7=>$val7)
															{
																$serviceCount7++;
														?>
                                                           <td>
                                                                <input type="text" name="servicePrice_1_7_<?php echo $serviceCount7;?>" value="">
																<input type="hidden" name="serviceTypeId_1_7_<?php echo $serviceCount7;?>" value="<?php echo $val7['id'];?>">
																<input type="hidden" name="serviceRateId_1_7_<?php echo $serviceCount7;?>" value=""/>
                                                            </td>
														<?php
															}
														?>
														<tr>
														<?php
												
															$serviceCount8=1;
														?>
															<td><?php echo $eigthSerName;?>
                                                                <input type="hidden" name="serviceNameId_1_8_<?php echo $serviceCount8;?>" value="<?php echo $eigthSerId;?>">
                                                            </td>
														<?php
													
															foreach($arrTravelService as $key8=>$val8)
															{
																$serviceCount8++;
														?>
                                                            <td>
                                                                <input type="text" name="servicePrice_1_8_<?php echo $serviceCount8;?>" value="">
																<input type="hidden" name="serviceTypeId_1_8_<?php echo $serviceCount8;?>" value="<?php echo $val8['id'];?>">
																<input type="hidden" name="serviceRateId_1_8_<?php echo $serviceCount8;?>" value=""/>
                                                            </td>
														<?php
															}
														}
														?>
														</tr>
														
                                                        </tr>
                                                       <tr id="rows_1">
                                                            <td style="display:none;">
                                                                <div class="row">
                                                            </td>
															<input type="hidden" name="rates_detail_id_1_8_5" id="travelRateId" value="0"/>
                                                            <td>LiDI000008
                                                                <input type="hidden" name="LidID_1_8_1" value="LiDI000008">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="Innova_1_8_2" value="450">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="Indigo_1_8_3">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="Traveller_1_8_4">
                                                            </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="last">Add More Row</label>
                                                                <a href="javascript:void(0);" class="add_more_row" id="add_more_row" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
														
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="last">Add More table</label>
                                            <a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;"><img src="add-icon.png" style="width:28px;" /></a>
                                        </div>
										<?php
										}
										?>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                                </div>
                        </form>

                        </div> -->

                    </div>
                </div>
            </div>
        </section>
    </div>
	<?php
		$arrCompSugg=$objtravel->get_company_name();
		//echo "<pre>";print_r($arrCompSugg);
		$compSugg=array();
		$cnt=0;
		foreach($arrCompSugg as $value){
			
			$compSugg[$cnt]=$value['hotal_name']." (".$value['city'].")";
			$cnt++;
		}
		$strCompany =json_encode($compSugg);
	?>
<script src="uploadify/jquery.uploadify.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
			$("#travel_hotel_name").autocomplete({
				source: <?php echo $strCompany;?>
			});
			var totalService = $("#item_count1").val();
			for(var i=1; i<=totalService; i++)
			{
				uplodifyImg(i);
			}
            $('#depData').timepicker();
            $("#anvsryData").datepicker({
                format: "dd MM yyyy"
            });
            $(".fromdate").datepicker({

                format: "dd MM yyyy"
            });
            $(".todate").datepicker({

                format: "dd MM yyyy"
            });

            $(document).on('click', '.delete_row', function() {
                $(this).parent().parent().remove();
            });
			$(".select2").select2();
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
				$("#pramCity").find('option').remove();
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
			var totalFld = $("#totalFld").val();
			for(var i=4; i<=totalFld; i++)
			{
				uplodifyMore(i);
			}
			$("#addMoreDocument").click(function(){
				var count=$("#totalFld").val();
				count++;
				var attachId=0;
				$(".myattch").append('<div id="attch_'+count+'"><input type="hidden" name="attachEdId[]" id="addMoreId" value=""/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="docFileName[]" id="addmorefilename_'+count+'" placeholder="File Name" value=""/></div></div><div class="col-md-8"><div class="form-group"><input class="file_upload" id="add_more_file_'+count+'" name="file_upload[]" type="file" multiple><input type="hidden" name="upldFileName[]" id="addMoreDoc_'+count+'" value=""/><p class="help-block text-danger"></p><div id="add_more_uploaded_'+count+'"></div></div></div><div class="col-md-2"><div class="form-group"><a class="delete delAttach" relId="" rel="'+count+'" href="javascript:void(0)" onclick="remove_attach('+count+','+attachId+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div> </div></div><div style="clear:both;"></div>');
					
				$("#totalFld").val(count);
				uplodifyMore(count);
			});
           $("#add_more_item").click(function() {

                var count = $("#concpeople4").val();
                //alert(count);
                count++;
                $('<div id="person_'+count+'"><div class="clearfix"></div><input type="hidden" name="concPrsnid_'+count+'" value=""/><div class="col-md-3"><div class="form-group"><select class="form-control" name="title_'+count+'"><option value="">--</option><option value="Mr.">Mr.</option><option value="Miss.">Miss.</option><option value="Mrs">Mrs.</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="firstname_'+count+'" id="firstname" placeholder="First Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="middle_'+count+'" id="middlename" placeholder="Middle Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="lastname_'+count+'" id="lastname" placeholder="Last Name" value=""/></div></div><div class="col-md-1"><div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item6('+count+', 0)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div>').insertAfter($(this).parent().parent().prev());

                $("#concpeople4").val(count);
                
            });

  
            $("#contumbbr").click(function() {

                var count = $("#contact3").val();
                //alert(count);
                count++;
                $('<div id="connumbbr_'+count+'"><div class="clearfix"></div><input type="hidden" name="concPrsnNumId_'+count+'" value=""/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone_'+count+'" id="userPhone" placeholder="Mobile Number" value=""/></div></div> <div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code_'+count+'" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-3 v_hidden"><div class="form-group"><input type="text" class="form-control" name="last_'+count+'" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item7('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div>').insertAfter($(this).parent().parent().prev());

                $("#contact3").val(count);
                //alert()
            });

            $("#add_more_items2").click(function() {

                var count = $("#item_count5").val();
                //alert(count);
                count++;
                $(".items6").append('<div id="Aminities_' + count + '"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><input type="text" class="form-control" name="Aminities" id="Aminities" placeholder= "Amenities & Facilities" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="' + count + '" href="javascript:void(0)" onclick="remove_item(' + count + ')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');

                $("#item_count5").val(count);
                //alert()
            });

 /*           $("#add_more_items1").click(function() {

                var count = $("#item_count1").val();
                //alert(count);
                count++;
                $(".items1").append('<div style="clear:both;"></div><div id="address2_' + count + '"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="servDetailId_' + count + '" id="servDetailId_' + count + '" value="0"/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="stype_' + count + '" id="roomstype" placeholder="Service Type" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="sDescription_' + count + '" id="RDescription" placeholder="Service Description" value=""/></div> </div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="AminitiesF_' + count + '" id="AminitiesF" placeholder="Amenities & Facilities" value=""/> </div> </div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="Units_' + count + '" id="Units" placeholder="Units" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="file" class="form-control" name="Pics_' + count + '" id="Pics_' + count + '" placeholder="Pics" value="" multiple="true"/><input type="hidden" name="serviceImg_'+count+'" id="serviceImg_'+count+'" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="' + count + '" href="javascript:void(0)" onclick="remove_item4(' + count + ')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div><div class="col-sm-10 col-md-offset-2"><div class="form-group"><div id="service_images_'+count+'" class=""></div></div></div> </div>');

                $("#item_count1").val(count);
				uplodifyImg(count);
                //alert()
            });*/
			function uplodifyImg(number)
			{
				var str='';
				
				$("#Pics_"+number).uploadify({
				'formData'     : {
					'flag'  : 'hotel_image',
					'direc'	: 'travel_service_pic',
					'id'	: '<?php echo $travelId;?>',
					'name'  : 'service_pic_copy',
					'recordId'      : '<?php echo $recordId; ?>'
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
					$('#service_images_'+number).append('<img alt="Restaurant Logo" class="superbox-img" src="document/travel_doc/service_pic/'+imgName+'" id="add_full_img_'+imgName+'" style="width:85px;height:85px;margin:10px;"><img class="remove_img del_add_img" id="add_img_'+imgName+'" src="document/travel_doc/service_pic/x.png" alt="delete" relId="'+imgName+'" relNum="'+number+'"/>');
					
					var preImg = $('#serviceImg_'+number).val();
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
					$("#serviceImg_"+number).val(str);
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
			var serviceImg=$("#serviceImg_"+num).val();
			//alert(roomImg);
			var arrServiceImg=serviceImg.split(',');
			//alert(arrroomImg);
			var index = arrServiceImg.indexOf(imgid);
			if (index > -1) {
				arrServiceImg.splice(index, 1);
			}
			//alert(arrroomImg);
			$("#serviceImg_"+num).val(arrServiceImg);
			
		});
		
		$(".remove_img").click(function(){
				var imageId=$(this).attr('relId');
				var relNum=$(this).attr('relImgNum');
				var relImgId=$(this).attr('relImgId');
				
				$.ajax({
					type:"POST",
					url:"_ajax_travel_agent.php?action=deleteTravelImg",
					data:{imageId:imageId},
					beforeSend:function(){
						
					},
					success:function(msg){
						if(msg == 1)
						{	
							$("#delete_img_"+imageId).remove();
							$("#delete_full_img_"+imageId).remove();
							var serviceImg=$("#serviceImg_"+relNum).val();
							var arrServiceImg=serviceImg.split(',');
							var index = arrServiceImg.indexOf(relImgId);
							if (index > -1) {
								arrServiceImg.splice(index, 1);
							}
							//alert(arrroomImg);
							$("#serviceImg_"+relNum).val(arrServiceImg);
						}
					}
				}); 
			}); 
            /* $("#add_more_items").click(function(){

            		var count = $("#item_count5").val();
            		//alert(count);
            		count++;
            		$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 1</label><input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 2</label><input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-2"><div class="form-group"><label for="middle">City</label><input type="text" class="form-control" name="code" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="last">State</label><input type="text" class="form-control" name="last" id="last" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group">	<label for="last">Pin Code</label>	<input type="text" class="form-control" name="last" id="last" placeholder="Code" value=""/>	</div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');

            		$("#item_count5").val(count);
            		//alert()
            	}); */

            $("#add_more_items").click(function() {

                var count = $("#item_count5").val();
                //alert(count);
                count++;
                $(".items").append('<div id="address_' + count + '"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="clntAddrid_' + count + '" id="" value="0"/><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="addressl_' + count + '" id="address" placeholder="Address line 1" value="Address"/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="addressline_' + count + '" id="userPhone" placeholder="Address line 2" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="city_' + count + '" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" name="state_' + count + '" id="last" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" name="pincode_' + count + '" " id="pincode" placeholder="Code" value=""/>	</div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="' + count + '" href="javascript:void(0)" onclick="remove_item3(' + count + ')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');

                $("#item_count5").val(count);
                //alert()
            });

            $("#Mnumbbr").click(function() {

                var count = $("#item_count3").val();
                //alert(count);
                count++;
                $(".items3").append('<div id="Mobnumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><input type="hidden" name="tra_clnt_num_id_'+count+'" id="tra_clnt_num_id_'+count+'" value=""/><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="userPhone_'+count+ '" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><select class="form-control valid" name="code_'+ count+'" placeholder="Code" value="" aria-invalid="false"><option value="">Select</option><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div>	<div class="col-md-3 v_hidden">	<div class="form-group"><input type="text" class="form-control" name="last_'+count+'" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');

                $("#item_count3").val(count);
                //alert()
            });

            $("#emails").click(function() {

                var count = $("#email2").val();
                //alert(count);
                count++;
                $(".items4").append('<div id="Email_' + count + '"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="" /></div></div><div class="col-md-1"> <div class="form-group"><a class="delete" rel="' + count + '" href="javascript:void(0)" onclick="remove_item1(' + count + ')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div> ');

                $("#email2").val(count);
                //alert()
            });

            //alert("gdfgd");
            $("#add_more_rate").click(function() {

                var count = $("#item_count9").val();
                //alert(count);
                count++;
                $(".rate").append('<div id="rates_' + count + '"><div class="col-md-2"><div class="form-group"><h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4></div></div><input type="hidden" name="dateRateId_' + count + '" id="dateRateId" value="0"/><div class="col-md-4"><div class="form-group" ><label for="search">From:Calender</label><input type="text" class="form-control fromdate" name="fromdate_' + count + '" id="fromdate_' + count + '" placeholder="Name"  value="Date"/></div></div><div class="col-md-4"><div class="form-group"> <label for="search">To:Calender</label><input type="text" class="form-control todate"  name="todate_' + count + '" id="todate_' + count + '" placeholder="Name" value="Date"/></div></div><div class="col-md-1" ></div> <div class= "bs-example col-md-11" ><table class="table" ><thead><tr ><th ></th><th style="width: 40px;" >Innova</th><th style="width: 40px;">Indigo</th>	<th style="width: 30px;"> Tempo Traveller </th></tr>	 </thead><tbody border="1px" ><tr><input type="hidden" name="rates_detail_id_' + count + '_1_5" id="travelRateId" value="0"/><td>LiDI000001<input type="hidden" name="LidID_' + count + '_1_1" value="LiDI000001"></td> <td><input type="text" value="3000" name="Innova_' + count + '_1_2"> </td><td><input type="text" name="Indigo_' + count + '_1_3"></td><td><input type="text"name="Traveller_' + count + '_1_4"></td><td rowspan="8"><textarea  rows="17" cols="21" name="description_' + count + '"> Description </textarea> </td></tr><tr><input type="hidden" name="rates_detail_id_' + count + '_2_5" id="travelRateId" value="0"/><td>LiDI000002<input type="hidden" name="LidID_' + count + '_2_1" value="LiDI000002"></td><td><input type="text" value="3500" name="Innova_' + count + '_2_2"></td><td><input type="text" name="Indigo_' + count + '_2_3"></td><td><input type="text" name="Traveller_' + count + '_2_4"> </td> </tr><tr><input type="hidden" name="rates_detail_id_' + count + '_3_5" id="travelRateId" value="0"/><td>LiDI000003<input type="hidden" name="LidID_' + count + '_3_1" value="LiDI000003"></td><td><input type="text" value="1200" name="Innova_' + count + '_3_2"></td><td><input type="text" name="Indigo_' + count + '_3_3"></td><td><input type="text" name="Traveller_' + count + '_3_4"> </td> </tr><tr><input type="hidden" name="rates_detail_id_' + count + '_4_5" id="travelRateId" value="0"/><td>LiDI000004<input type="hidden" name="LidID_' + count + '_4_1" value="LiDI000004"></td><td><input type="text" value="800" name="Innova_' + count + '_4_2"></td>	<td><input type="text" name="Indigo_' + count + '_4_3"></td><td><input type="text" name="Traveller_' + count + '_4_4">	</td></tr><tr><input type="hidden" name="rates_detail_id_' + count + '_5_5" id="travelRateId" value="0"/><td>LiDI000005<input type="hidden" name="LidID_' + count + '_5_1" value="LiDI000005"></td><td><input type="text" value="1000" name="Innova_' + count + '_5_2"></td><td><input type="text" name="Indigo_' + count + '_5_3"></td><td><input type="text" name="Traveller_' + count + '_5_4"></td></tr><tr><input type="hidden" name="rates_detail_id_' + count + '_6_5" id="travelRateId" value="0"/><td>LiDI000006<input type="hidden" name="LidID_' + count + '_6_1" value="LiDI000006"></td><td><input type="text" value="250" name="Innova_' + count + '_6_2"></td><td><input type="text" name="Indigo_' + count + '_6_3"></td><td><input type="text" name="Traveller_' + count + '_6_4"></td></tr><tr><input type="hidden" name="rates_detail_id_' + count + '_7_5" id="travelRateId" value="0"/><td>LiDI000007<input type="hidden" name="LidID_' + count + '_7_1" value="LiDI000007"></td><td><input type="text" value="350" name="Innova_' + count + '_7_2"></td><td><input type="text" name="Indigo_' + count + '_7_3"></td><td><input type="text" name="Traveller_' + count + '_7_4"></td></tr><tr><input type="hidden" name="rates_detail_id_' + count + '_8_5" id="travelRateId" value="0"/><td>LiDI000008<input type="hidden" name="LidID_' + count + '_8_1" value="LiDI000008"></td><td><input type="text" value="450" name="Innova_' + count + '_8_2"></td><td><input type="text" name="Indigo_' + count + '_8_3"></td><td><input type="text" name="Traveller_' + count + '_8_4"></td></tr> </tbody></table></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="' + count + '" href="javascript:void(0)" onclick="remove_rate(' + count + ')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');

                $("#item_count9").val(count);
                $(".fromdate").datepicker({
                    format: "dd MM yyyy"
                });
                $(".todate").datepicker({
                    format: "dd MM yyyy"
                });
                //alert()
            });
			function uplodifyMore(number)
			{
				var str='';
				$('#add_more_file_'+number).uploadify({
					'formData'     : {
						'flag'  : 'upload_file',
						'direc'	: 'travel_doc',
						'id'	: '<?php echo $travelId;?>',
						'name'  : 'pan_card_copy',
					'recordId'      : '<?php echo $recordId; ?>'
					},
					'onSelect' : function(file) {
					  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
					},
					'buttonImage' : 'uploadify/browse-btn.png',
					'buttonText' : 'Add Category Pic',
					'multi': false,
					'swf'      : 'uploadify/uploadify.swf',
					'uploader' : '_ajax_document_upload.php',
					'onUploadSuccess': function (file, data, response){
						var extension = file.name.replace(/^.*\./, '');
						var a=$.parseJSON(data);
						//alert(a.imagename);
						var imgName=a.imagename;
						$('#add_more_uploaded_'+number).html('<label>'+imgName+'</label>');
						$("#addMoreDoc_"+number).val(imgName);
					}		
				});
				
			}
			
			
			$('#travel_pan_card_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'travel_doc',
					'id'	: '<?php echo $travelId;?>',
					'name'		: 'pan_card_copy',
					'recordId'      : '<?php echo $recordId; ?>'
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
			
			$('#travel_photo_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'travel_doc',
					'id'	: '<?php echo $travelId;?>',
					'name'		: 'photo_copy',
					'recordId'      : '<?php echo $recordId; ?>'
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
			
			$('#travel_Contract_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'travel_doc',
					'id'	: '<?php echo $travelId;?>',
					'name'		: 'contract_copy',
					'recordId'      : '<?php echo $recordId; ?>'
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
			
			$("#travel_doc_detail_btn").click(function(){
				//alert("sdfdsf");
				$.ajax({
					type: "POST",
					url: "_ajax_travel_agent.php",
					data: $("#travel_doc_detail").serialize(),
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

        $("#add_more_row").click(function() {

            var count = $("#item_count10").val();
            //alert(count);
            count++;
            $("#rows_1").after(' <tr id="row_' + count + '"><td><input type="text" placeholder="LiDI000009"></td> <td><input type="text" ></td><td><input type="text" > </td><td><input type="text"></td><td><a class="delete_row" rel="' + count + '"  href="javascript:void(0)" ><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></td></tr> ');

            $("#item_count").val(count);
            //alert()

        });
		function remove_attach(counter,relId)
		{
			
			if(relId == 0){
				$('#attch_'+counter).remove();
			}else{
				if(confirm("Do you want to delete?")){
					$.ajax({
						type:"POST",
						url:"_ajax_travel_agent.php?action=delAttach",
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
        function remove_item1(counter) {
            $('#Email_' + counter).remove();
        }

        function remove_item2(counter) {
            $('#Mobnumbbr_' + counter).remove();
        }

         function remove_item10(counter,id)
		 {
			//alert(id);
				if(confirm("Do you want to delete table?")){
					var data = 'type=delete_travel_items2&id='+id;
					$.ajax({
						type: "POST",
						url: "_ajax_travel_agent.php",
						data: data,
						cache: false,
						beforeSend:function() {
							//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
						},
						success: function(html)
						{
							$('#Mobnumbbr_' + counter).remove();
							//counter--;
							//$("#item_count9").val(counter);
						}
					});
				}else{
					return false;
				}
				 
			
		}

        function remove_item3(counter) {
            $('#address_' + counter).remove();
        }

         function remove_item6(counter) {
             $('#person_' + counter).remove();
         }
         function remove_item9(counter,id)
		 {
			//alert(id);
				if(confirm("Do you want to delete table?")){
					var data = 'type=delete_travel_items1&id='+id;
					$.ajax({
						type: "POST",
						url: "_ajax_travel_agent.php",
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

        function remove_item7(counter)
		{
			$('#connumbbr_'+counter).remove();
		}
        function remove_item8(counter,id)
		{
			//alert(id);
				if(confirm("Do you want to delete table?")){
					var data = 'type=delete_travel_items&id='+id;
					$.ajax({
						type: "POST",
						url: "_ajax_travel_agent.php",
						data: data,
						cache: false,
						beforeSend:function() {
							//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
						},
						success: function(html)
						{
							$('#connumbbr_'+counter).remove();
							//counter--;
							//$("#item_count9").val(counter);
						}
					});
				}else{
					return false;
				}
				 
			
		}

      
    
        function remove_item5(counter) {
            $('#connumbbr_' + counter).remove();
        }
        

        function remove_rate(counter) {
            $('#rates_' + counter).remove();
        }
    </script>

    <script>
        $("#travel_client_detail").validate({
        rules: {
				travel_hotel_name: "required",				
				addressl_1: "required",				
				addressline_1: "required",				
				country_1: "required",				
				state_1: "required",				
				city_1: "required",				
				pincode_1: "required",				
				userPhone_1: "required",				
				code_1: "required"				
						
			},
			messages: {
				travel_hotel_name: "Please Enter Name"
			},
            submitHandler: function() {

                //alert("punam");
                $.ajax({
                    type: "POST",
                    url: "_ajax_travel_agent.php",
                    data: $("#travel_client_detail").serialize(),
                    cache: false,
                    beforeSend: function() {
                        //$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
                    },
                    success: function(html) {
                        window.location.href='<?php echo $tabUrl.base64_encode(2); ?>';
                    }
                });
            }
        });
    </script>
    <script>
        $("#travel_query_detail").validate({
	     rules: {
								
				'title_1': "required",				
				'firstname_1': "required",				
				'lastname_1': "required",				
				'userPhone_1': "required",				
				'code_1': "required",				
				'userEmail[]': "required",				
				'travel_pass': "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
            submitHandler: function() {

                //alert("punam");
                $.ajax({
                    type: "POST",
                    url: "_ajax_travel_agent.php",
                    data: $("#travel_query_detail").serialize(),
                    cache: false,
                    beforeSend: function() {},
                    success: function(html) {
                         window.location.href='<?php echo $tabUrl.base64_encode(3); ?>';

                    }
                });
            }
        });
    </script>
    <script>
        $("#travel_bank_detail").validate({

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
                    url: "_ajax_travel_agent.php",
                    data: $("#travel_bank_detail").serialize(),
                    cache: false,
                    beforeSend: function() {
                        //$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
                    },
                    success: function(html) {
                          window.location.href='travel_Agent_list.php';
                    }
                });
            }
        });
    </script>
<!--     <script>
        $("#travel_rate").validate({

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
                    url: "_ajax_travel_agent.php",
                    data: $("#travel_rate").serialize(),
                    cache: false,
                    beforeSend: function() {
                        //$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
                    },
                    success: function(html) {
						//alert(html);
                        window.location.href='travel_Agent_list.php';
                    }
                });
            }
        });
    </script> -->
    <script src="asset/bootstrap-datepicker.js"></script>
    <!--<script src="asset/jquery.timepicker.js"></script>
    <script src="asset/bootstrap/css/jquery.timepicker.css"></script>-->
    <?php  include('footer.php');?>