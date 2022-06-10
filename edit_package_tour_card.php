<?php 
include('header.php');
	include('sidebar.php');
	if($_GET['action']=='edit')
	{
	 $id=$_GET['id'];
	 $queryType=$_GET['queryType'];
	 $arr_query=$objAdmin->getAllTourcard_info($id,$queryType);
     $arr_query_tour_card_det=$objAdmin->getAlltour_card_details($arr_query['id']);	
     $arr_query_tour_card_package_dt=$objAdmin->getAlltour_card_pack_dt($arr_query['id']); 
     $arr_query_tour_card_room_dt=$objAdmin->getAlltour_card_room($arr_query['id']);		 
	 $country_all=explode(",",$arr_query_tour_card_det['country']);
	 $state_all=explode(",",$arr_query_tour_card_det['state']);
	 $city_all=explode(",",$arr_query_tour_card_det['city']);
	  $country_all1=implode(",",$country_all);
	   $state_all1=implode(",",$state_all);
	    $city_all1=implode(",",$city_all);
		
	//print_r($arr_query_tour_card_room_dt);exit;
	//print_r($state_all1);exit;
	//print_r($arr_query_tour_card_package_dt);
	$hotel_name=explode(",",$arr_query_tour_card_package_dt[0]['hotel']);
	
	$hotel_new_id=implode(",",$hotel_name);
	//print_r($hotel_new_id);
	$room_type_name=explode(",",$arr_query_tour_card_package_dt[0]['room_type']);
	$room_type_name1=implode(",",$room_type_name);
	$meal_plan_name=explode(",",$arr_query_tour_card_package_dt[0]['meal_paln']);
	$room=count($arr_query_tour_card_room_dt);
		$sum='';
		for($r=0;$r<$room;$r++)
		{
		$oc=$arr_query_tour_card_det['vehicle_package_cost']*$arr_query_tour_card_det['no_of_package_vehicle'];
		$sum=$arr_query_tour_card_room_dt[$r]['price']+$oc;
		//$sum=$sum1+$arr_query_tour_card_det['vehicle_package_cost']*$arr_query_tour_card_det['no_of_package_vehicle'];
		$vehicle=$arr_query_tour_card_det['vehicle_package_cost']*$arr_query_tour_card_det['no_of_package_vehicle'];
		//echo $vehicle;exit;
		$pc1=$vehicle+($vehicle* $arr_query_tour_card_det['margin_percent']/100);
		$pc2=$arr_query_tour_card_room_dt[$r]['price']+($arr_query_tour_card_room_dt[$r]['price']* $arr_query_tour_card_det['margin_percent']/100);
		$pc = ceil($pc1+$pc2);
		
		}
		//exit;
		
	
		
		$gst=floor($pc*(5/100));
		
		$profit1=$pc-$sum;
		//$profit1=$total_v_p-$profit-$gst;
		$url= trim($_SERVER['HTTP_HOST'], '/');
    if (!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
	$partner_url_name=$objAdmin->get_partner_url_name($_GET['id']);
		$markup=$objAdmin->get_partner($partner_url_name['partner_url']);
$hotel_markup=$markup['hotel_markup'];
$package_markup=$markup['package_markup'];
	}
	
	
?>
<style>
table tr td
{
padding:10px;	
border:1px solid #ccc;
}
table tr th
{
padding:10px;	
border:1px solid #ccc;
}
</style>
<div class="content-wrapper">
	<table class="table table-bordered">
		 <form method="POST" id="tour_card_data">
    <thead>
      <tr>
        <th>Tour Card No:</th>
		  <th><input type="text" value="<?php echo  $arr_query['tc_no'] ?>" name="tc_no" id="name_qry" />
		   <input type="hidden" name="query_no" id="query_no" value="<?php echo  $arr_query['query_no'] ?>" />
		  </th>
    
        <th>Bkg Date</th>
		<th><input class="form-control" name="bkg_date" type="date" value="<?php echo  $arr_query['bkg_date'] ?>" /></th>
		<th>Bkg. By</th>
		<th><input class="form-control" name="bkg_by" id="bkg_by" type="text" value="<?php echo  $arr_query['bkg_by'] ?>"/></th>
		<th>Bkg Type:</th>
		<th style="width:100px;"><select class="form-control" onchange="my_fun()" name="queryType" id="queryType">
										
										<option value="Package">Package</option>
										
										<!--<option value="Client">Client</option>
										<option value="Transporter">Transporter</option>
										<option value="Travel Agent">Travel Agent</option>-->
									</select></th>
		
      </tr>
	   <tr>
	   <th>Lead Pax Name:</th>
        <th style="width:100px;"><select name="name_prefix" class="form-control">
		<option>Mr.</option>
		<option>Mrs.</option>
		<option>Miss.</option>
		
	  </select></th>
        <th colspan="2"><input type="text" value="<?php echo $arr_query['pax_name'] ?>" name="pax_name" class="form-control" id="" /></th>

		<th colspan="1">Nationality</th>
		<th colspan="3"><select name="country1" class="form-control">
		<?php
											$arrcountery=$objAdmin->get_countery();
											foreach($arrcountery as $count)
											{ 
										?>	
											<option value="<?php echo $count['id']; ?>" <?php if($count['id']==$arr_query['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
										<?php		
											}
										?>	
		
	  </select></th>
		
	   </tr>
	   <tr>
	   <th>Party:</th>
        <th><select class="form-control" name="party" id="">
		         <option><?php echo $arr_query['party'] ?></option>
				
				
		
	  </select></th>
		<th></th>
		<th></th>
		<th>File No</th>
        <th><input type="text" name="file_no" value="<?php echo  $arr_query['file_no'] ?>" class="form-control" /></th>
		<th>Invoice No.</th>
		<th colspan="2"><input name="invoice_no" value="<?php echo  $arr_query['invoice_no'] ?>" class="form-control" type="text" disabled/></th>
		
		
	   </tr>
	   
	  <input type="hidden" name="grand_total_hotel" id="grand_total_hotel"/>
	  <input type="hidden" name="grandPackageTotal1" id="grandPackageTotal1" value="<?php echo $arr_query_tour_card_det['grand_total'] ?>"/>
	  <input type="hidden" name="hotel_selected_rooms" id="hotel_selected_rooms" />
	  <input type="hidden" name="hotel_meal_plans" id="hotel_meal_plans" />
	  <input type="hidden" name="calculated_hotel_prices" id="calculated_hotel_prices" />
	  <input type="hidden" name="pricemargin_hotel" id="pricemargin_hotel" />
	   <input type="hidden" name="pricemargin_package" id="pricemargin_package" value="<?php echo $arr_query_tour_card_det['margin_percent'] ?>"/>
	  <input type="hidden" name="calculate_package_price" id="calculate_package_price" />
	  <input type="hidden" name="selected_package_hotels" id="selected_package_hotels" />
	  <input type="hidden" name="selected_package_rooms1" id="selected_package_rooms1" /> 
	  <input type="hidden" name="selected_package_mealPlans1" id="selected_package_mealPlans1" /> 
	  <input type="hidden" name="selected_package_mealPlans1_name" id="selected_package_mealPlans1_name" /> 
	  <input type="hidden" name="vehicle_package_cost" id="vehicle_package_cost" value="<?php echo $arr_query_tour_card_det['vehicle_package_cost'] ?>" /> 
	  <input type="hidden" name="no_of_package_vehicle" id="no_of_package_vehicle" value="<?php echo $arr_query_tour_card_det['no_of_package_vehicle'] ?>" />
	  <input type="hidden" name="vehicle_name" id="vehicle_name" value="<?php echo $arr_query_tour_card_det['vehicle_name'] ?>" />
	  <input type="hidden" name="employee_id" value="<?php echo $_SESSION['admin_Email'] ?>"/> 
	  <input type="hidden" name="package_id_page" value="<?php echo $_GET['id'] ?>" />
	   <input type="hidden" value="<?php echo $hotel_markup; ?>" id="hotel_markup" />
	   <input type="hidden" value="<?php echo $package_markup; ?>" id="package_markup" />
	 
	     <input type="hidden" name="choosen_pack"  value="" />
	  
    </thead>
  </form>   
  </table>
 

	<form role="form" method="POST" name="search_data" id="search_data" style="display:block;">
					<!--<input type="hidden" name="extraAdult" id="extraAdult" value=""/>
					<input type="hidden" name="chWoBed" id="chWoBed" value=""/>
					<input type="hidden" name="chWBed" id="chWBed" value=""/>-->
					<input type="hidden" name="searchrooms" id="searchrooms" value="1"/>
					<input type="hidden" name="queryNumber" id="queryNumber" value="<?php echo $qn; ?>" />
					<input type="hidden" name="package_id" value="<?php echo $arr_query_tour_card_det['choosen_pack'] ?>" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-12">
								<div class="form-group">
									<!--<label for="userPhone">Query type</label>-->
									<!--<select class="form-control" name="queryType" id="queryType">
										<option value="">Select</option>
										<option value="Hotel">Hotel</option>
										<option value="Package">Package</option>
										<option value="Other">Other</option>
										<option value="Client">Client</option>
										<option value="Transporter">Transporter</option>
										<option value="Travel Agent">Travel Agent</option>
									</select>-->
									<th><input type="hidden" name="queryType" id="queryType1" value="Package" /></th>
								</div>
							
							
							<div class="col-md-4 packageField">
								<div class="form-group">
									<label for="search">Country</label>
									<select style="width:100%;" class="form-control select2" name="country[]" id="country" multiple="multiple"> 
										<!--<option value="">--Select Country--</option>-->
										
										<?php
										 
											$arrcountery=$objAdmin->get_countery();
											foreach($arrcountery as $count)
											{ 
											
										?>	
										<option value="<?php echo $count['id']; ?>" <?php if(in_array($count['id'],$country_all)){echo "selected";}?>><?php echo $count['country_name']; ?></option>
										<?php		
											}
										?>	
													
									</select>
								</div>
							</div>
							<div class="col-md-4 packageField">
								<div class="form-group">
									<label for="search">State</label>
									<input type="hidden" name="state_all1" id="state_all1" value="<?php echo $state_all1 ?>" />
									<select style="width:100%;" class="form-control select2" name="state[]" id="state" multiple="multiple">
										
										
										<?php
										 
											$arrstate=$objAdmin->get_state($country_all1);
											//print_r($arrstate);exit;
											foreach($arrstate as $state_count)
											{ 
											if(in_array($state_count['id'],$state_all))
											{
												$select="selected";
												
											}
											else
											{
												echo $select="";
											}
											//echo $state_count['id'];
										?>	
										<option value="<?php echo $state_count['id']; ?>" <?php if(in_array($state_count['id'],$state_all)){echo 'selected';}?>><?php echo $state_count['state_name']; ?></option>
										<?php		
											}
										?>
									</select>
								</div>
							</div>
						<div class="col-md-4 packageField">
								<div class="form-group">
									<label for="search">City</label>
									<input type="hidden" name="city_all1" id="city_all1" value="<?php echo $city_all1 ?>" />
									
									<select style="width:91%;" class="form-control select2" name="city[]" id="city" multiple="multiple" >
										<?php
										 
											$arrcity=$objAdmin->get_city1($state_all1);
											//print_r($arrstate);exit;
											foreach($arrcity as $city_count)
											{ 
											
											//echo $state_count['id'];
										?>	
										<option value="<?php echo $city_count['id']; ?>" <?php if(in_array($city_count['id'],$city_all)){echo 'selected';}?>><?php echo $city_count['city']; ?></option>
										<?php		
											}
										?>
									
										</select>
								</div>
					    </div>
							</div>
							<div class="col-md-12" >
							<div class="col-md-3 hotelField" id="destinationDiv">
								<div class="form-group">
									<label for="query_no">Destination</label>
									<?php
										$getHotelcities = $objhotel->getHotelCities();
										//print_r($getHotelcities);
									?>
									
									<select class="form-control" name="destination" id="destination">
										<option value="">Select</option>
										<?php
											foreach($getHotelcities as $hcity)
											{
												$cityArr = $objhotel->getCitiesById($hcity['city']);
												//print_r($cityArr);
										?>
										<option value="<?php echo $cityArr[0]['id']; ?>"><?php echo ucfirst($cityArr[0]['city']); ?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3" id="startdateDiv">
								<div class="form-group">
									<div class="form-group">
									<label for="query_no">Check-in</label>
									<div class='input-group date' >
									<input type='text' class="form-control" value="<?php echo $arr_query_tour_card_det['check_in'] ?>" name="startdate" id="startdate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
							
							<div class="col-md-3" id="enddateDiv">
								<div class="form-group">
									<div class="form-group">
									<label for="query_no">Check-out</label>
									<div class='input-group date' >
									<input type='text' class="form-control" value="<?php echo $arr_query_tour_card_det['check_out'] ?>" name="enddate" id="enddate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
						
							
							<div class="col-md-3" id="stayDurationDiv">
								<div class="form-group">
									<label for="userPhone">Nights</label>
									<select class="form-control" name="stayDuration" id="stayDuration">
										<option value="">Select</option>
										<option <?php if($arr_query_tour_card_det['nights']=='1' ) echo 'selected' ?> value="1">1</option>
										<option <?php if($arr_query_tour_card_det['nights']=='2' ) echo 'selected' ?> value="2">2</option>
										<option <?php if($arr_query_tour_card_det['nights']=='3' ) echo 'selected' ?> value="3">3</option>
										<option <?php if($arr_query_tour_card_det['nights']=='4' ) echo 'selected' ?> value="4">4</option>
										<option <?php if($arr_query_tour_card_det['nights']=='5' ) echo 'selected' ?> value="5">5</option>
										<option <?php if($arr_query_tour_card_det['nights']=='6' ) echo 'selected' ?> value="6">6</option>
										<option <?php if($arr_query_tour_card_det['nights']=='7' ) echo 'selected' ?> value="7">7</option>
										<option <?php if($arr_query_tour_card_det['nights']=='8' ) echo 'selected' ?> value="8">8</option>
										<option <?php if($arr_query_tour_card_det['nights']=='9' ) echo 'selected' ?> value="9">9</option>
										<option <?php if($arr_query_tour_card_det['nights']=='10' ) echo 'selected' ?> value="10">10</option>
										<option <?php if($arr_query_tour_card_det['nights']=='11' ) echo 'selected' ?> value="11">11</option>
										<option <?php if($arr_query_tour_card_det['nights']=='12' ) echo 'selected' ?> value="12">12</option>
										<option <?php if($arr_query_tour_card_det['nights']=='13' ) echo 'selected' ?> value="13">13</option>
										<option <?php if($arr_query_tour_card_det['nights']=='14' ) echo 'selected' ?> value="14">14</option>
										<option <?php if($arr_query_tour_card_det['nights']=='15' ) echo 'selected' ?> value="15">15</option>
										<option <?php if($arr_query_tour_card_det['nights']=='16' ) echo 'selected' ?> value="16">16</option>
										<option <?php if($arr_query_tour_card_det['nights']=='17' ) echo 'selected' ?> value="17">17</option>
									</select>
								</div>
							</div>
							</div>
							<div class="col-md-12" >
							<div id="prsnInfo">
								<div id="room1">
									<div class="col-md-12" id="numOfRoomDiv">
										<label for="userPhone">Room <span class="roomNumber">1</span></label>
									</div>
								
									<div class="col-md-4">
										<div class="form-group">
											<?php
												$alloptions = '';
												$childAge = '';
												for($i=0; $i<=60; $i++)
												{
													if($i<=12)
													{
														if($i>0)
														{
															if($i<6)
															{
																$alloptions .= '<option value="'.$i.'">'.$i.'</option>';
															}
															if($i<5)
															{
																$alloptionsCh .= '<option value="'.$i.'">'.$i.'</option>';
															}
														}
														$childAge .= '<option value="'.$i.'">'.$i.'</option>';
													}
												}
											?>
											<label for="userPhone">Adults(12+)</label>
											<select class="form-control" name="adults[]" id="adults_1">
												<?php echo $alloptions; ?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="userPhone">Child(0-12)</label>
											<select class="form-control selchild" rel="1" name="child[]" id="child_1">
												<option value="0">0</option>
												<?php echo $alloptionsCh; ?>
											</select>
										</div>
									</div>
									
									<div class="col-md-4" id="childAgeBox_1" style="display:none; padding-left:0">
										<div class="form-group">
											<label for="userPhone">Child Age</label>
											<input type="text" class="form-control" name="child_age[]" id="child_age_1" /> 
										</div>
									</div>
									<div class="col-md-1 removeRooms" style="font-size: 20px;padding: 0;margin-top: 27px;color: red;display: none;" id="rRoom_1">
										<i class="fa fa-minus-circle" aria-hidden="true"></i>
									</div>
								</div>
								
							</div>
							</div>
							<div class="col-md-12 text-right" style="font-size: 21px;cursor:pointer" id="add_more_rooms">
								<i class="fa fa-plus-circle" aria-hidden="true"></i>
							</div>
							
							
							
							<!--<div class="col-md-12" id="numOfRoomDiv">
								<div class="form-group">
									<label for="userPhone">No. of Rooms</label>
									<input type="text" class="form-control" name="numOfRoom" id="numOfRoom" placeholder="No. of Rooms" value=""/>
								</div>
							</div>
						  
							<div class="col-md-12" id="numOfExtrBedDiv">
								<div class="form-group">
									<label for="userPhone">No. of Extra Beds</label>
									<input type="text" class="form-control" name="numOfExtrBed" id="numOfExtrBed" placeholder="No. of Extra Beds" value=""/>
								</div>
							</div>
						   
							<div class="col-md-12" id="childWOutBedDiv">
								<div class="form-group">
									<label for="userPhone">Child Without Bed</label>
									<input type="text" class="form-control" name="childWOutBed" id="childWOutBed" placeholder="Child Without Bed" value=""/>
								</div>
							</div>
						   
							<div class="col-md-12" id="childWithBedDiv">
								<div class="form-group">
									<label for="userPhone">Child With Bed</label>
									<input type="text" class="form-control" name="childWithBed" id="childWithBed" placeholder="Child With Bed" value=""/>
								</div>
							</div>
						 
							<div class="col-md-12" id="hotelNameDiv">
								<div class="form-group">
									<label for="userPhone">Hotel Name</label>
									<input type="text" class="form-control" name="hotelName" id="hotelName" placeholder="Hotel Name" value=""/>
								</div>
							</div>-->
						   <!-- /.second line -->
						   
							<!--<div class="col-md-12">
								<div class="form-group">
									<label for="userPhone">Itinerary</label>
									<select class="form-control" name="itinerary" id="itinerary">
										<option>SELECT</option>
										<?php
										//foreach($arrItinerary as $key=>$val){
										?>
										<option value="<?php echo $val['title'];?>"><?php echo $val['title'];?></option>
										<?php
										
										?>
									</select>
								</div>
							</div>					
							
							<div class="col-md-12" id="noteDiv">
								<div class="form-group">
									<label for="userPhone">Note</label>
									<input type="text" class="form-control" name="note" id="note" placeholder="Note" value=""/>
								</div>
							</div>					
							 forth Line -->
							
						</div>
					</div>
					<div class="box-footer">
					<div class="col-md-3">
						<!--<button type="button" class="btn btn-primary" name="searchDataBtn" id="searchDataBtn">Search Hotel </button>-->
						<div style="display:none;" id="me1"><img src="progress_bar.gif" /></div>
					  
					</div>
					
					<!--<div class="col-md-3">
					<div class="loader"><img src="images/loader.gif" width="60" height="60" style="display:none"></div>
					</div>-->
					<div class="col-md-6 text-left" >
					<span id="hotelnameFilter">
						<div class="form-group form-inline package_new_hotel" style="display:none;">
							<label for="userPhone">Hotel Name: </label>
							<select class="form-control" style="width:30%;" name="nameSearch" id="nameSearch" data-placeholder="Search By Hotel Name">
								<option value="hotel names">Hotel Names</option>
							</select>
							
						</div>
						</span>
						<div style="display:none;" id="me2"><img src="progress_bar.gif" /></div>
					</div>
					
                    <div class="col-md-6 text-left" >
					<span id="hotelnameFilter">
						<div class="form-group form-inline package_new" style="display:none;">
							<label for="userPhone">Package Name: </label>
							<select class="form-control" style="width:30%;" name="package_search" id="package_search" data-placeholder="Search By Package Name">
								<option value="hotel names">Package Names</option>
							</select>
							
							
						</div>
						</span>
						<div style="display:none;" id="me3"><img src="progress_bar.gif" /></div>
					</div>
					
                     				
					</div>
				</form>
				
				<div id="resultData">
		<div class="col-md-12">
			<div class="">
				<div class="">
					<div id="status1"></div>
					<div id="search_data1">
					</div>
					<div id="package_data1">
					</div>

					<div id="searchData" style="padding:15px 0; display:none;">
						
					</div>
					<div id="searchpack"></div>
				</div>
			</div>
		</div>
		</div>
		<?php

	
	$ut = 'e';
	$user_type=$_SESSION['user_type'];
	if($user_type == 'admin')
	{
		$ut = 'a';
	}

		
		$data_id = explode('&',$arr_query_tour_card_det['choosen_pack']);
		//print_r($data_id);exit;
		$editItiId = $data_id['0'];
		$searchData = $data_id['1'];
		
		
		$queryNumber = '';
		
		$searchDataStr = base64_decode($searchData);
		
		//Array ( [searchrooms] => 1 [queryType] => Package [country] => 119 [state] => 187 [city] => 2007 [destination] => [startdate] => 25/08/2016 [enddate] => 28/08/2016 [stayDuration] => 3 [adults] => 1 [child] => 0 [child_age] => [] => ) asdfasdfa:::Array ( [0] => Array ( [hotel_id] => 86 [hotel_name] => The PGS Vedanta [hotel_type] => [star_rating] => 4 [from_date] => 2016-08-24 [to_date] => 2017-03-31 [city] => 2007 [image] => ) )

		$searchDataArr = explode('S$S',$searchDataStr);
		$paramArr = array();
		foreach($searchDataArr as $data)
		{
			$dataArr = explode('=',$data);
			$val = $dataArr[1];
			if (strpos($val, '#') !== false)
			{
				$val = explode('#', $val);	
			}
			$paramArr[$dataArr[0]] = $val;
		}
		
		//print_r($paramArr);exit;
		//Array ( [searchrooms] => 3 [queryNumber] => LIDQ0002 [queryType] => Package [country] => 119 [state] => 187 [destination] => 2007 [startdate] => 28/03/2017 [enddate] => 31/03/2017 [stayDuration] => 3 [adults] => Array ( [0] => 2 [1] => 2 [2] => 1 ) [child] => Array ( [0] => 2 [1] => 2 [2] => 0 ) [child_age] => Array ( [0] => 5,9 [1] => 9 [2] => ) [] => )
		//print_r($paramArr['adults']);
		//die;
		if(is_array($paramArr['adults']))
		{
			$totalAdults = array_sum($paramArr['adults']);
		}
		else
		{
			$totalAdults = $paramArr['adults'];
		}
		if(is_array($paramArr['child']))
		{
			$totalKids = array_sum($paramArr['child']);
		}
		else
		{
			$totalKids = $paramArr['child'];
		}
		
		$sDate = explode('/',$paramArr['startdate']);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		
		$eDate = explode('/',$paramArr['enddate']);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		
		/*************************PrintPdf code***************/
		$rupeeSymbol = '';
		if($type == 'pdf')
		{
			$rupeeSymbol = '<img src="'.APP_URL.'images/rupee.png" alt="" style="margin-top:3px;" />';
			$queryNo = base64_decode($_GET['qNo']);
			$quryDetail = '';
			if($queryNo != '')
			{
				$queryData=$objAdmin->getQueryByNumber($queryNo);
				$number = $queryData['query_no'];
				$query_date = date('d/m/Y', strtotime($queryData['query_date']));
				$query_type = 'Package';
				$person_name = $queryData['person_name'];
				
				$quryDetail = '<div class="col-md-12"><p>Dear '.$person_name.'</p></div>';
			}
			
			$selMealdata=$_GET['selMealPlans'];
			$selRoomsdata=$_GET['selRooms'];
			$selRData = explode('$#$', rtrim(base64_decode($selRoomsdata), ','));
			$selRoomsArr = explode(',', rtrim($selRData[0], ','));
			$selectedRoomIds = explode(',',$selRData[1]);
			
			$selMealArr = explode(',', rtrim(base64_decode($selMealdata), ','));
			//print_r($selMealArr);
			//print_r($selectedRoomIds);
			
			$selHoteldata=$_GET['selHotels'];
			$selHData = explode('$#$', rtrim(base64_decode($selHoteldata), ','));
			$selHotelArr = explode(',', rtrim($selHData[0], ','));
			$selectedHotelIdsArr = explode(',',$selHData[1]);
			
			
			$i = 0;
			$hotelMastArr = array();
			foreach($selectedHotelIdsArr as $hotelId){
				$hotelMastArr[$hotelId][] = $selectedRoomIds[$i];
				$i++;
			}
			//print_r($hotelMastArr);
			
			$htmlHotelSupplCost = '';
			foreach($hotelMastArr as $hotelid => $roomTypeId)
			{
				//echo $hotelid;
				$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelid, $startdate, $enddate);
				//print_r($date_rates_detail);
				$hotelDateId = $date_rates_detail[0]['id'];
				
				$hotel_rates_detail=$objhotel->getHotelRoomTypeRatesFilter($hotelid,$hotelDateId,$roomTypeId[0]);
				
				if(count($hotel_rates_detail))
				{
				$hN = $hotel_rates_detail[0]['hotel_name'];
				$rTN = $hotel_rates_detail[0]['room_type'];
				
				$htmlHotelSupplCost .= '<h3>SUPPLEMENT COSTS – HOTEL '.strtoupper($hN).'</h3><table class="table table-bordered" cellspacing="0" width="100%">
				<tr>
					<td style="border: 1px solid #f4f4f4;width:40%;"></td>
					<td style="border: 1px solid #f4f4f4;">'.$rTN.'</td>
				</tr>';
				
				$col = '';
				$values = '';
				foreach($hotel_rates_detail as $hotelRates)
				{
					$RoNA = $hotelRates['room_name'];
					$rPrice = $hotelRates['price'];
					
					$htmlHotelSupplCost .= '<tr>
						<td style="border: 1px solid #f4f4f4;">'.$RoNA.'</td>
						<td style="border: 1px solid #f4f4f4;">'.$rupeeSymbol.' '.$rPrice.'</td>
					</tr>';
				}
				
				$htmlHotelSupplCost .= '</table>';
				}
			}
			
			
			$selVehicledata=$_GET['selVehicle'];
			$selVehicleArr = explode('__', base64_decode($selVehicledata));
			$vehicleCostSel = $selVehicleArr[0];
			//print_r($selVehicleArr);
			
			$priceMargin = base64_decode($_GET['pMargin']);
			$calculatedprices=$_GET['prices'];
			$calculatedprices = base64_decode($calculatedprices);
			$priceArr = json_decode($calculatedprices);
			//print_r($priceArr);
			$countRooms = count((array) $priceArr);
			
			$prRoomVehicleCost = $vehicleCostSel*$selVehicleArr[2]/$countRooms;
			
			if($calculatedprices != '')
			{
				/* $calculatedprices = base64_decode($calculatedprices);
				$priceArr = json_decode($calculatedprices); */
				//print_r($priceArr);
				$pArr = array();
				foreach($priceArr as $val)
				{
					$valueData = $val + $prRoomVehicleCost;
					$pArr[] = $valueData + ($valueData*$priceMargin/100);
					//echo '<br>'.$val;
				}
				//print_r($pArr);
				//$priceArr->[0];
				$subTotal = array_sum($pArr);
				$serviceTax = $subTotal*5/100;
				$grandTot = $subTotal+$serviceTax;
			}
		}
		/*************************PrintPdf code End***************/
		//$startdate=$paramArr['startdate'];
		//$enddate=$paramArr['enddate'];
		
		$searchrooms=$paramArr['searchrooms'];
		
		$stayDuration=$paramArr['stayDuration'];
		$adults=$paramArr['adults'];
		$child=$paramArr['child'];
		$child_age=$paramArr['child_age'];
		
		
		$itineraryData = $objhotel->getIteneraryById($editItiId);
		//print_r($itineraryData); 
		$itiTitle=$itineraryData['title'];
		$Itiduration=$itineraryData['duration'];
		$itiCity=$itineraryData['city'];
		
		$vehcle_detail=$objhotel->getIteneraryVehicleCost($editItiId);
		//print_r($vehcle_detail);
		$ite_interest_detail=$objhotel->getIteneraryInterestCost($editItiId);
		//print_r($ite_interest_detail);
		//echo 'asdfasdfa';
		//die;
		
		/* $hotelDetails=$objhotel->getPackageHotels($paramArr);
		$hotelStr = '<option>Select Hotel</option>';
		//$ragingStr = '<option>Select Rating</option>';
		foreach($hotelDetails as $hotel)
		{
			$hotelId = $hotel['hotel_id'];
			$hotelName = $hotel['hotel_name'];
			$star_rating=$hotel['star_rating'];
			$hotelStr .= '<option value="'.$hotelId.'">'.$hotelName.' ('.$star_rating.' Star)</option>';
			
			
		} */
		//echo 'asdfasdfa:::'.$ragingStr;
		//echo 'roomType::'.$roomTypeStr;
		//print_r($hotelDetails);
		
		
		//print_r($roomTypesPriceArr); */
		
		$arrMasterRooms=$objhotel->getMasterRoomNames();
		$masterRooms = array();
		foreach($arrMasterRooms as $mrooms)
		{
			$masterRooms[$mrooms['id']] = $mrooms['room_name'];
		}
		
		?>
		<div class="">
	<!-- Content Header (Page header) -->
	<?php 
		if($type != 'pdf')
		{
	?>
	<section class="content-header">
		<h1></h1>
	</section>
	
	<?php
		}
	?>
	<!-- Main content -->
	<section class="">
	  <div class="row">
		<div class="col-md-12">
			<div class="">
			<form id="formData1">
				<input type="hidden" id="hidStartDate" name="hidStartDate" value="<?php echo $startdate;?>" />
				<input type="hidden" id="hidEndDate" name="hidEndDate" value="<?php echo $enddate;?>" />
				<input type="hidden" id="searchType" name="searchType" value="Package" />
			<?php 
				if($type != 'pdf')
				{
			?>
			<div class="">
				<div id="status1"></div>
				<div id="searchType" style="font-size:20px;padding-bottom: 5px;"><?php //echo $itiTitle;?></div>
					<input type="hidden" name="hotelId" id="hotelIds" value=<?php echo $hotel_new_id; ?>>
					<input type="hidden" name="hotelDateId" id="hotelDateId" value='<?php echo $hotelDateId; ?>'>
					<input type="hidden" name="searchDataStr" id="searchDataStr" value='<?php echo $searchData; ?>'>
					<input type="hidden" name="userSelectRoomTypes" id="userSelectRoomTypes1" value=''>
					<input type="hidden" name="userSelectHotel" id="userSelectHotel" value=''>
					<input type="hidden" name="userSelectedMealPlans" id="userSelectedMealPlans1" value=''>
					<input type="hidden" name="totalBookingRooms" id="totalBookingRooms" value="<?php echo $searchrooms; ?>">
					<input type="hidden" name="itineryDuration" id="itineryDuration" value="<?php echo $itineraryData['duration']; ?>">
					
				<div class="col-md-12" style="margin-top:10px; padding:0">
					<!--<div class="form-group form-inline">
						<label for="userPhone">Query Numebr: </label>
						<input type="input" name="queryNumber" id="queryNumber" class="form-control" placeholder="Query Number" value="<?php //echo $queryNumber; ?>" />
						<button type="button" class="btn btn-primary" name="searchQueryBtn" id="searchQueryBtn" style="margin-left: 10px;">Search</button>	
					</div>-->
				</div>	
			</div>	
			<?php
				}
			?>
			<div class="box-body">	
				<?php 
					if($type == 'pdf')
					{
				?>
				<div class="row">
					<div class="col-md-12" style="text-align:right;">
						<img src="images/pdf/travellogo.png" alt="" style="width:300px;" />
					</div>
				</div>
				<?php 
					}
				?>
				<div id="searchData1" style="">
					<div style="">
					
						<div class="col-md-12">
							<div class="row" id="showQueryDetail">
								<?php //echo $quryDetail; ?>
							</div>	
							
						</div>
					
						
						
						<div class="col-md-12">
							
							<div class="table-responsive">
							<table class="table table-bordered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									<?php
									$headTxt = '';
									if($type != 'pdf'){
										$headTxt = '';
									}
									?>
									<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Day</th>
									<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">City</th>
									<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Date</th>
									<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;"><?php echo $headTxt; ?>Hotel</th>
									<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;"><?php echo $headTxt; ?>Room Type</th>
									<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;"><?php echo $headTxt; ?>Meal Plan</th>
									<!--<th>Price</th>-->
								  </tr>
								</thead>
								<tbody>
									<?php
										$duration = $itineraryData['duration'];
										$duration_city = $itineraryData['duration_city'];
										$durationCityArr = explode(',',$duration_city);
										for($i=1; $i<=$duration; $i++)
										{	
											$cityId = $durationCityArr[$i-1];
											$cityArr = $objhotel->getCitiesById($cityId);
											
											$day1=$arr_query_tour_card_package_dt[$i-1]['pck_date'];
											//$date = date('d, F Y',strtotime($startdate . $day1));
											//echo "<pre>!!!!";
											//print_r($day);
											//echo "<pre>!!!!!";
											//print_r($date);
											//exit;
											$day1=$arr_query_tour_card_package_dt[$i-1]['pck_date'];
											$dateSearch = date('Y-m-d',strtotime($day1));
											
											//$hotelSearchData=$objhotel->getHotelsByCity($cityId, $startdate, $enddate);
											$hotelSearchData=$objhotel->getHotelsByCityDate($cityId, $dateSearch);
											//echo '<pre>';
											//print_r($hotelSearchData);
											
											$hotelDetails = array();
											$hotelIdArr = array();
											foreach($hotelSearchData as $hotelData)
											{
												if(!in_array($hotelData['hotel_id'], $hotelIdArr))
												{
													$hotelIdArr[] = $hotelData['hotel_id'];
													$hotelDetails[] = $hotelData;
												}
											}
											
											//print_r($hotelDetails);
											
											
											//echo '<br/><br/>';
											$hotel_name1=explode(",",$arr_query_tour_card_package_dt[$i-1]['hotel']);
											//echo '<br/><br/>';
											$sel_hotel1 ='';
											if($hotel_name1[$i-1]==1)
											{
													$sel_hotel1 .='selected';
											}
											else
											{
												$sel_hotel1 .='';
											}
											$sel_hotel2 ='';
											if($hotel_name1[$i-1]==2)
											{
													$sel_hotel2 .='selected';
											}
											else
											{
												$sel_hotel2 .='';
											}
											$hotelStr = '<option value="0">Select Hotel</option>
											<option '.$sel_hotel1.' value="1" >Travelling</option>
											<option '.$sel_hotel2.' value="2">Departure</option>';
											//$ragingStr = '<option>Select Rating</option>';
											
											$mealPlanStr = '<option value="0">Select Meal Plan</option>';
											
											$sel_hotel ='';
											//print_r($hotel_name1);
											foreach($hotelDetails as $hotel)
											{
												
												$hotelId = $hotel['hotel_id'];
												$hotelName = $hotel['hotel_name'];
												$star_rating=$hotel['star_rating'];
												//print_r($hotelId);
												
												
												if($hotel_name1[$i-1]==$hotelId)
												{
													$sel_hotel .='selected';
													$hotelStr .= '<option '.$sel_hotel.' value="'.$hotelId.'">'.$hotelName.' ('.$star_rating.' Star)</option>';
												}
												else
												{
													$sel_hotel .='';
												}
												
											   
											}
											$room_type_id1=explode(",",$arr_query_tour_card_package_dt[$i-1]['room_type']);
											//echo $hotelStr;
											//$hotelStr .= '<option value="">Departure</option>';
											$arrRoomType=$objhotel->getHotelRoomTypeByid($hotel_name1[$i-1]);
											//print_r($arrRoomType);
											
											$roomTypeStr = '<option value="0">Select Room Type</option>';
											$roomTypesPriceArr = array();
											
											foreach($arrRoomType as $roomType)
											{
												
												$roomId = $roomType['id'];
												$room_type = $roomType['room_type'];
												$sel_room_type ='';
												if($room_type_id1[$i-1]==$roomId)
													{
															$sel_room_type .='selected';
															}
															else
															{
															$sel_room_type .='';
															}
												$roomTypeStr .= '<option '.$sel_room_type.' value="'.$roomId.'">'.$room_type.'</option>';
												
												//$hotel_rates_detail=$objhotel->getHotelRatesByid($hotelId,$hotelDateId,$roomId);
												//$roomTypesPriceArr['roomprices_'.$roomId] = $hotel_rates_detail;
											}
											
											$k = $i-1;	
									?>
									<tr>
										<th style="border: 1px solid #f4f4f4;"><?php echo $i; ?></th>
										<th style="border: 1px solid #f4f4f4;"><?php echo $cityArr[0]['city'];?></th>
										<th style="border: 1px solid #f4f4f4;"><?php echo $day1;?></th>
										<th style="border: 1px solid #f4f4f4;">
											<?php
												if($calculatedprices != ''){
													echo $selHotelArr[$k];
												}
												else
												{
											?>
											<select class="form-control hoteltypes col-md-6" name="selectedHotel[]" rel="<?php echo $i; ?>" id="hotel_<?php echo $i; ?>" selectedDate="<?php echo $dateSearch; ?>">
												<?php
													echo $hotelStr;
												?>
											</select>
											<?php
												}
											?>
										</th>
										<th style="border: 1px solid #f4f4f4;">
											<?php
												if($calculatedprices != ''){
													$rooms = trim($selRoomsArr[$k]);
													if($rooms == 'Select Room Type')
													{
														$rooms = '--';
													}
													echo $rooms;
												}
												else
												{
											?>
											<select class="form-control userRoomTypes1" name="selectedRoom[]" rel="<?php echo $i; ?>" id="roomType_<?php echo $i; ?>" selDate="<?php echo $dateSearch; ?>">
											<?php 
											
											?>
											
											
												<?php echo $roomTypeStr; ?>
																				
											</select>
											<?php
											
												}
											?>
											
										</th>
										<th style="border: 1px solid #f4f4f4;">
											<?php
												if($calculatedprices != ''){
													$mealPlans = trim($selMealArr[$k]);
													if($mealPlans == 'Select Meal Plan')
													{
														$mealPlans = '--';
													}
													echo $mealPlans;
												}
												else
												{
											?>
											<select class="form-control mealTypes1" name="selectedMealPlans[]" rel="<?php echo $i; ?>" id="mealType_<?php echo $i; ?>" selDate="<?php echo $dateSearch; ?>">
												<option value="<?php echo $arr_query_tour_card_package_dt[$i-1]['meal_paln'] ?>"><?php echo $arr_query_tour_card_package_dt[$i-1]['meal_plan_name'] ?></option>
											</select>
											<?php
												}
											?>
											
										</th>
										<!--<th><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="dayPrice_<?php echo $i; ?>">0</span></th>-->
									</tr>
									<?php
									}
								//exit;
									?>
								</tbody>
							</table>
							</div>
						</div>
						<div class="col-md-12">
							<h3>Vehicle Detail</h3>
							<table class="table table-bordered" cellspacing="0" width="100%">
								
								<tbody>
									<?php
										$vehicleCost = $objhotel->getIteneraryVehicleCost($editItiId);
										//print_r($vehicleCost);
										
										$vehCleStr = '<option value="0">Select Vehicle</option>';
										foreach($vehicleCost as $vehCost)
										{
											$vehicle_name_show=$arr_query_tour_card_det['vehicle_name'];
											$vehName = $vehCost['vehicle_name'];
											$vehPrice = $vehCost['cost'];
											$sel='';
											if($vehicle_name_show==$vehCost['vehicle_name'])
											{
												$sel .="selected";
											}
											$vehCleStr .= '<option '.$sel.' value="'.$vehPrice.'">'.$vehName.'</option>';
                                            											
										}
									?>
									<tr>
										<td style="border: 1px solid #f4f4f4;padding: 8px;">
											
											<?php
												//print_r($selVehicleArr);
												if($calculatedprices != ''){
													if($selVehicleArr[1] == 'Select Vehicle')
													{
														echo '--';
													}
													else
													{
														echo $selVehicleArr[1];
													}
												}
												else
												{
											?>
											<select class="form-control vehCleCost col-md-6" name="selectedVehcle[]" id="vehCleCost">
												<?php
													echo $vehCleStr;
												?>
											</select>
											<input type="hidden" value="<?php echo $arr_query_tour_card_det['vehicle_package_cost'] ?>" id="selectedVehcleCost" />
											<?php
												}
											?>
											
										</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;">
											<?php
												if($calculatedprices != ''){
													if($selVehicleArr[1] == 'Select Vehicle')
													{
														echo '--';
													}
													else
													{
														echo $selVehicleArr[2];
													}
												}
												else
												{
											?>
											<select class="form-control col-md-6" name="no_of_vehicle" id="no_of_vehicle" readonly>
												<?php
												$vehicle_no_show=$arr_query_tour_card_det['no_of_package_vehicle'];
												for($i=1; $i<=10; $i++)
												{
													$sel='';
													if($vehicle_no_show==$i)
													{
														$sel .="selected";
													}
													echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
												}
												?>
											</select>
											<?php
												}
											?>
											
										</td>
										<!--<td><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="vehPrice">0</span></td>-->
									</tr>
									
								</tbody>
							</table>
						</div>
						<?php 
							if($type != 'pdf')
							{
						?>
						<div class="col-md-8">
							<h3>Add Margin(%)</h3>
							<div class="hotelDetail">
								<table class="table table-bordered" cellspacing="0">
									<tr>
										<td>Entery your percentage</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;">
											<input  type="number" id="priceMargin1" value="<?php echo $vehicle_no_show=$arr_query_tour_card_det['margin_percent']; ?>" onkeyup="calculate_priceWith_margin1(this.value)"  maxlength="2" />
											
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-4">
							<button type="button" class="btn btn-primary btn-lg" onclick="calc_fun()" id="calculate_prices" style="margin-top:53px;">Calculate Pric</button>
						</div>
						
						<?php
							}
						?>
						<br/><br/>
						<div class="col-md-12">		
							<h3>Tour Cost</h3>	
							<div class="table-responsive">
							<table class="table table-bordered" cellspacing="0" width="100%">
								<tr><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Room</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Adult</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren)</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren) Age</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Price</th></tr>
								<?php
									//print_r($paramArr);
									//echo count($adults);
									for($i=0; $i<$room; $i++)
									{
										$adultP = $adults[$i];
										$childp = $child[$i];
										if(is_array($child_age))
										{
											$childp_age = $child_age[$i];
										}
										else
										{
											$childp_age = $child_age;	
										}
									?>
									<tr>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $i+1; ?></td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-male" aria-hidden="true"></i></span> <?php echo $arr_query_tour_card_room_dt[$i]['adult']; ?></td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-child" aria-hidden="true"></i></span> <?php echo $arr_query_tour_card_room_dt[$i]['children']; ?></td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $arr_query_tour_card_room_dt[$i]['child_age']; ?></td>
										
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="roomPrice_<?php echo $i+1; ?>"><?php
										
										$price_new=$arr_query_tour_card_room_dt[$i]['price']* $arr_query_tour_card_det['margin_percent']/100;
								        echo $price_new1=$arr_query_tour_card_room_dt[$i]['price']+$price_new;
										
										?></span></td>
									</tr>
									<?php	
									}
								?>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">OC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice1"><?php echo $sum; ?></span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice2"><?php echo $pc; ?></span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span> <?php echo $rupeeSymbol; ?> <span id="serviceTax1"><?php echo $gst; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Total PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal1"><?php echo $arr_query_tour_card_det['grand_total']; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Profit</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="profit"><?php echo $profit1; ?></span></td>
								</tr>
						</table>
						</div>	
					</div>	
					<div class="col-md-12">
					
					<?php 
					
					//echo $arr_query_tour_card_package_dt[0]['hotel'];
					$qt_hotel1=explode(",",$arr_query_tour_card_package_dt[0]['hotel']);
					$i=0;
					foreach($qt_hotel1 as $qt_hotel)
					{
						$hotel_status=$arr_query_tour_card_package_dt[$i]['hotel_conf_status'];
						$romm_type_data=explode(",",$arr_query_tour_card_package_dt[$i]['room_type']);
						$arr_hotel_rooms=$objhotel->getAll_hotel_rooms($romm_type_data[$i]);
						//$romm_type_city=explode(",",$arr_query_tour_card_package_dt[0]['city']);
						
						//print_r($romm_type_data);exit;
						
					 $arr_hotel_tour_name=$objhotel->getAll_hotel_name($qt_hotel);	
					 
					 foreach($arr_hotel_tour_name as $arr_hotel_tour_name1)
					 {
						 
						 
					?>
					<div class="col-md-3">
					<button type="button" <?php if($hotel_status==1) echo 'disabled'; ?> rel="<?php echo $arr_hotel_rooms['room_type'];?>,<?php echo $arr_hotel_tour_name1['hotel_name'] ?>,<?php echo $arr_query_tour_card_package_dt[$i]['city'] ?>,<?php echo $arr_query_tour_card_package_dt[$i]['meal_plan_name'] ?>,<?php echo $arr_query_tour_card_package_dt[$i]['meal_paln'] ?>,<?php echo $arr_query_tour_card_package_dt[$i]['pck_date'] ?>,<?php echo $qt_hotel1[$i] ?>,<?php echo $romm_type_data[$i]; ?>,<?php echo $room; ?>,<?php echo $editItiId; ?>,<?php echo $searchData; ?>,<?php echo $arr_query_tour_card_det['margin_percent']; ?>,<?php echo $arr_query_tour_card_package_dt[$i+1]['pck_date'] ?>,<?php echo $arr_query['country'] ?>" class="btn btn-success btn-sm btn viewDetail1" title="" data-toggle="tooltip">
					
					<?php echo $arr_hotel_tour_name1['hotel_name'] ?>(<?php echo substr($arr_hotel_rooms['room_type'],0,10);?>)(<?php echo substr($arr_query_tour_card_package_dt[$i]['meal_plan_name'],0,3) ?>)</button></div>
					<?php
					
					 }
					 $i++;
					// exit;
					}					 
                    ?>					
					</div>
					<div id="qDetail1" class="modal fade " role="dialog">
  <div class="modal-dialog modal-lg" style="width:80%;">
      <div class="modal-content">
       <div class="modal-header modal_header1" style="padding: 5px; ">
          <div class="modal-header" style="border-bottom-color:#4F80BD;">
        <button type="button" class="close" data-dismiss="modal" style="color: #fff">&times;</button>
        <h4 class="modal-title modal-title1" style="">Hotel Confirmation Details</h4>
      </div>
		  
          
        </div>
        <div class="modal-body" style="overflow: hidden;">
         
		 <form method="POST" id="tour_card_data1">
    <thead>


<div class="form-group input_form">
	
		<div class="col-md-3 padbo">
			<label>Tour Card No:</label>
		
			<input type="text" readonly class="form-control" value="<?php echo $arr_query['tc_no'] ?>" name="tc_no1" id="tc_no" />
		</div>
		<div class="col-md-3 padbo">
			<label>Check In Date:</label>
			<?php 
			$date = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_in']);
			//$date1 = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_out']);
			
			?>
			<input class="form-control" readonly type="text" name="bkg_date1" id="bkg_date1"  />
		</div>
		<div class="col-md-3 padbo">
			<label>Check Out Date:</label>
			<?php 
			$date = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_in']);
			//$date1 = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_out']);
			
			?>
			<input class="form-control" readonly type="text" name="bkg_date2" id="bkg_date2"  />
		</div>
        <!--<div class="col-md-3 padbo">
			<label>Departure:</label>
			<input class="form-control" name="bkg_date" type="date" value="<?php  echo $date->format('Y-m-d');?>" />
		</div>-->
		<div class="col-md-3 padbo">
			<label>Nts:</label>
			<input class="form-control" readonly name="bkg_by1" id="bkg_by" type="text" value="1"/>
		</div>

		
	
</div>

<div class="form-group input_form">
	
		
		<div class="col-md-6 padbo">
			<label>Lead Pax Name:</label>
			<input type="text" readonly value="<?php echo $arr_query['pax_name'] ?>" name="pax_name1" class="form-control" id="" />
		</div>

		<div class="col-md-6 padbo">
			<label>Nationality:</label>
				<select name="country1" class="form-control" >
					<?php
					$arrcountery=$objAdmin->get_countery();
					foreach($arrcountery as $count)
					{ 
					?>	
					<option value="<?php echo $count['id']; ?>" <?php if($count['id']==$arr_query['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
					<?php		
					}
					?>	

				</select>
		</div>
  
</div>

<div class="form-group input_form">
	
		<div class="col-md-4 padbo">
			<label>Hotel:</label>
			<input readonly type="text" value="" name="hotel1" class="form-control" id="hotel_name" />

		</div>
		<div class="col-md-4 padbo">
			<label>City:</label>
			<input readonly type="text" value="" name="city1" class="form-control" id="city_name" />

		</div>
		<div class="col-md-4 padbo">
			<label>Room Type:</label>
			<input readonly type="text" value="" name="room_type1" class="form-control" id="room_type_name" />

		</div>
   
</div>
<div class="form-group input_form">
	
		<div class="col-md-12 padbo">
			<label>Meal Plan:</label>
			<input readonly type="text" value="" name="meal_plan1" class="form-control" id="meal_plan_name" />

		</div>
		
   
</div>

	   
	 <div id="result_data_price"></div>
	 <div id="result_data_price1"></div>
	  
	  	
    </thead>
	<input type="hidden" name="brakfast_id" id="brakfast_id" />
	<input type="hidden" name="frm_date" id="frm_date" />
	<input type="hidden" name="to_date" id="to_date" />
	<input type="hidden" name="hotel_tour_card" id="hotel_tour_card" />
	
	<input type="hidden" name="room_type_id_new" id="room_type_id_new" />
	
  </form>   

        </div>
        
      </div>
    </div>
  </div>
					<div style="clear:both"></div>
					<!--<div class="col-md-12">
						<h3>Tour Inclusions:</h3>
						<ul>
							<li>Welcome drinks on Arrival at hotel/resort. (Non alcoholic)</li>
							<li>Accommodation as per above details.</li>
							<li>Meals as above mentioned Meal Plan.</li>
							<li>Chauffeur Driven Vehicle as per the itinerary &amp; Vehicle Details.</li>
							<li>All kind of applicable hotel, transport, service &amp; govt. taxes.</li>
						</ul>
						<h3>Tour Exclusions:</h3>	
						<ul>
							<li>Bus/Air/Train tickets.</li>
							<li>Entry &amp; activities fees at monuments, tourist spots, etc. </li>
							<li>Tips to the guides / driver / restaurants / hotels etc.</li>
							<li>Any expenses of personal nature such as, drinks, laundry, telephone calls, insurance, camera fees, excess baggage, emergency/medical cost etc.</li>
						</ul>
						<h3>Tour Note:</h3>
						<ul>
							<li>Child Policy:
								<ul>
									<li>0 to 5 years child is complimentary sharing parent’s bed.</li>
									<li>6 to 8 years child will be charged as extra child without bed.</li>
									<li>9 to 12 years child will be charged as extra child with bed.</li>
								</ul>
							</li>
							<li>The cost is irrelevant of circumstances that are beyond our control. Situations such as road blockade due to strike or agitation, earthquake, natural calamity, sickness evacuation, delay or cancellation of train or flight etc. are beyond our control.</li>
							<li>Itinerary may vary depending upon the climate conditions and circumstances.</li>
							<li>We are not holding any booking.</li>
						</ul>
					</div>-->
					<!--<div class="col-md-12">
						
						<?php
							//print_r($ite_interest_detail);
							$showArr = array();
							foreach($ite_interest_detail as $val)
							{
								if($val['cost'] != '0')
								{
									$showArr[] = $val['cost'];
								}
							}
							$show = count($showArr);
							$countInt = count($ite_interest_detail);
							if($countInt && $show)
							{
						?>
						<h3>SUPPLEMENT ACTIVITIES COSTS:</h3>
						<?php	
							$col = '';
							$values = '';
							foreach($ite_interest_detail as $val)
							{
								$col .= '<th style="border: 1px solid #f4f4f4;">'.$val['interest_name'].'</th>';
								$values .= '<td style="border: 1px solid #f4f4f4;">'.$rupeeSymbol.' '.$val['cost'].'</td>';
							}
						?>
						<table class="table table-bordered text-center" cellspacing="0" width="100%">
							<tr>
								<?php echo $col;?>
							</tr>
							<tr>
								<?php echo $values;?>
							</tr>
						</table>
						<?php
							}
						?>
					</div>
					<div class="col-md-12" id="hot_supp_cost">
						<?php echo $htmlHotelSupplCost; ?>
					</div>--> 
					</div>
						
				</div>
				<?php 
					if($type == 'pdf')
					{
				?>
				<div class="row">
					<div class="col-md-12" style="text-align:right; position:relative;">
						<img src="images/pdf/footer.png" alt="" style="width:100%;" />
						<div style="position: absolute;top: 0px;right: 30px;padding: 10px;">
							<a href="https://www.facebook.com/LiD.TE/" target="_blank"><img src="images/pdf/fb.png" alt="" style="height:40px;" /></a>
							<a href="https://www.instagram.com/planetlid/?hl=en" target="_blank">
							<img src="images/pdf/instagram.png" alt="" style="height:40px;" /></a><br/>
							<a href="https://www.youtube.com/channel/UCXUSz7sEHs4_RisR-nENw9w" target="_blank">
							<img src="images/pdf/youtube.png" alt="" style="height:40px;" /></a>
							<a href="https://plus.google.com/+LightsinDarkTravelEventsPvtLtdNewDelhi" target="_blank">
							<img src="images/pdf/google+.png" alt="" style="height:40px;" /></a>
							
						</div>
						<div style="position: absolute;top: 60px;right: 150px;">
							<a href="http://www.lightsindark.in/" target="_blank"><img src="images/pdf/website.png" alt="" style="height: 20px;"></a>
							
						</div>
					</div>
				</div>
				<?php
					}
				?>
			</div>
			<div style="clear:both;"></div>
			<?php 
				if($type != 'pdf')
				{
			?>
			<div class="box-footer text-right">
				<!--<a href="<?php echo $downloadPdfUrl; ?>" class="btn btn-info" id="download">Download PDF</a>-->
				<input type="hidden" id="calculated_prices1" value="" />
				<input type="hidden" id="selected_hotels" value="" />
				<input type="hidden" id="selected_rooms1" value="" />
				<input type="hidden" id="selected_mealPlans1" value="" />
				<input type="hidden" id="selectedVehicle" value="" />
				<!--<button type="button" class="btn btn-info" id="download" onclick="downlaod_pdf('<?php echo $_SERVER['QUERY_STRING'].'&itiTitle='.base64_encode($itiTitle); ?>', 'downlaod')">Download PDF</button>&nbsp;&nbsp;&nbsp;
				<a class="btn btn-primary pull-right" href="#sendToCl" data-toggle="modal"><i class="fa fa-envelope-o"></i> Mail to Client</a>-->
				
			</div>
			<?php
				}
			?>	
			</form>	
		</div>
		</div>
	
	  </div>
	</section>
</div><!-- /.row --><!-- /.row -->

    
      <!--<div class="modal-footer">
	  <button type="button" class="btn btn-primary" id="tc_submit1">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>-->
	   </div>
	   <script>
      $(function () {
        $('#example1').DataTable({
          "paging"      : false,
          "lengthChange": true,
          "searching"   : true,
          "info"        : true,
          "autoWidth"   : false,
		  "bSort"       : false,
		  
        });
		
		$(document).on('click',".viewDetail",function(){
			$("#qDetail").modal();
			var qn = $(this).attr('rel');
			$("#modalHead").html('Query Detail: <strong>'+qn+'</strong>');
			$("#mdetail").html($("#detal_"+qn).html());
			
		});
		
		
      });
	
	
	$(document).on('click',".viewDetail1",function(){
			
			var element = $(this);
			//alert('hello');
			$("#qDetail1").modal();
			var del_id = element.attr("rel");
			//alert(del_id);
			
			
			var array = del_id.split(",");
			//alert(array[5]);
			//$("input[name='bkg_date']").val(array[1]);
            //$("#bkg_date1").val(txt);
			$("#hotel_name").val(array[1]);
			$("#city_name").val(array[2]);
			$("#room_type_name").val(array[0]);
			$("#meal_plan_name").val(array[3]);
			$("#brakfast_id").val(array[4]);
			$("#frm_date").val(array[5]);
			$("#to_date").val(array[5]);
			$("#hotel_tour_card").val(array[6]);
			$("#room_type_id_new").val(array[7]);
			$("#bkg_date1").val(array[5]);
			if(array[12]=='')
			{
			$("#bkg_date2").val(array[5]);
			}
			else
			{
			 $("#bkg_date2").val(array[12]);
			}
			//alert(array[5]);
			//alert(array[12]);
			//array[12];
			$.ajax({
            type: 'POST',
            url:"_ajax_data_package_det.php?action=add_hotel_tour_card&hotel_id="+array[6]+"&frm_dt="+array[5]+"&to_dt="+array[5]+"&breakfast="+array[4]+"&room_type_id_new="+array[7]+"&room="+array[8]+"&date_id="+array[9]+"&date_search="+array[10]+"&margin_percent="+array[11]+"&room_type="+array[0]+"&tour_id="+<?php echo $id ?>+"&bkg_date2="+array[12]+"&meal_plan_name="+array[3]+"&city_name="+array[2]+"&hotel_name="+array[1]+"&country="+array[13],
           
			//data:$("#tour_card_data1").serialize(),
			cache: false,
            success: function(html)
            {
				$("#result_data_price").html(html);
				
				
            }
        });
			
			
			
		});
	function areyousure()
	{
		if(confirm('Are you sure.'))
		{
			//$('#myModal').modal('show');
			
		}else {
			
			return false;
		}
	}
    </script>
    

     <style type="text/css">
    

ul.pagenili li {
    float: left;
        padding: 6px 12px;
        border: 1px solid #ddd;
}
ul.pagenili {
    list-style: none;
    padding: 0;
    display: inline-block;
}

ul.pagenili li:first-child {
    background: #337ab7;
    color: #fff;
    border-color: #337ab7;
}

ul.pagenili li:first-child a {
    color: #fff;
}
     </style>

     <script type="text/javascript">
	 if($("#queryType").val()=='Package')
	 {
		 $(".hotelField").hide();
		$(".packageField").show();
					$("#searchDataBtn").html('Search Package');
	 }
	 $("#queryType").change(function(){
				//alert("working");
				var qtype=$(this).val();
				//alert(qtype);
				//alert(qtype);
				if(qtype == 'Package'){
					$("#hotel_rating").hide();
					$("#hotelnameFilter").hide();
					$(".packageField").show();
					$(".hotelField").hide();
					$("#queryType1").val(qtype);
					$("#searchType span:first").html('Package');
					$("#searchDataBtn").html('Search Package');
				}else{
					$(".package_new_hotel").hide();
					$("#search_data1").hide();
					$("#hotel_rating").show();
					$("#hotelnameFilter").show();
					$(".packageField").hide();
					$(".hotelField").show();
					$("#queryType1").val(qtype);
					$("#searchType span:first").html('');
					$("#searchDataBtn").html('Search Hotel');
				}
			});
	  $("#search_data").show();
	function stateGet(id){
     	var id=$('#hotel_country').val();
        $.ajax({
            type: 'POST',
            data: {id:id},
            url:"_ajax_hotel_get_state.php",
            success: function(result)
            {
                //alert(result);
               $("#hotel_state").html(result);
            }
        });
    }

     function cityGet(id){
     	var id=$('#hotel_state').val();
        $.ajax({
            type: 'POST',
            data: {id:id},
            url:"_ajax_hotel_get_city.php",
            success: function(result)
            {
               $("#hotel_city").html(result);
            }
        });
    }
$('.queryPage').on('click', function(){
    $('.queryPage').removeClass('current');
    $(this).addClass('current');
});


function undoConfirm(query_id) {
		$.ajax({
			type:'post',
			url :'_ajax_query_undoconfirmed_request.php',
			data:{id:query_id},
			beforeSend:function() {
			},
			success:function(result) {
				if(result === '1')
				{
					window.location.href='query_in_hand.php';
				
				}
				else if (result == 0)
				{
					$("#status").show().html('<div class="alert alert-danger">Sorry, pull request no generated</div>');
					
				}else{
					$("#status").show().html('<div class="alert alert-danger">Sorry, there is something problem please try again later!</div>');
				}
			}

		});
	}

	$("#perpage").change(function() {
		var perpage = $("#perpage").val();
		$.ajax({
			type:'post',
			url :'_ajax_update_record_per_page.php',
			data:{record:perpage},
			beforeSend:function() {
			},
			success:function(result) {
				if(result === '1')
				{
					window.location.href='confirmed_queries.php';
				
				}
				else if (result == 0)
				{
					$("#status").show().html('<div class="alert alert-danger">Sorry, pull request no generated</div>');
					
				}else{
					$("#status").show().html('<div class="alert alert-danger">Sorry, there is something problem please try again later!</div>');
				}
			}
		});
	});
   
   
</script>
<script>
//$("#search_data").hide();


		$(".select2").select2();
		$("#add_more_rooms").click(function(){
			var totRooms = $("#searchrooms").val();
			totRooms++
			
			if(totRooms > 1)
			{
				$(this).attr('style','font-size: 21px;cursor:pointer');
			}
			
			var html = '<div id="room'+totRooms+'"><div class="col-md-12" id="numOfRoomDiv"><label for="userPhone">Room <span class="roomNumber">'+totRooms+'</span></label></div><div class="col-md-4"><div class="form-group"><select class="form-control" name="adults[]" id="adults_'+totRooms+'"><?php echo $alloptions; ?></select></div></div><div class="col-md-4"><div class="form-group"><select class="form-control selchild" rel="'+totRooms+'" name="child[]" id="child_'+totRooms+'"><option value="0">0</option><?php echo $alloptionsCh; ?></select></div></div><div class="col-md-3" id="childAgeBox_'+totRooms+'" style="display:none; padding-left:0;"><div class="form-group"><input type="text" class="form-control" name="child_age[]" id="child_age_'+totRooms+'" /></div></div><div class="col-md-1 removeRooms" style="font-size: 20px;padding: 0;margin-top: 4px;color: red; cursor:pointer;" id="rRoom_'+totRooms+'"><i class="fa fa-minus-circle" aria-hidden="true"></i></div></div>';
			$("#prsnInfo").append(html);
			$("#searchrooms").val(totRooms);
			
			var r=1;
			$(".roomNumber").each(function(){
				$(this).html(r);
				r++;
			});
			
		});
		
		$(document).ready(function(){
			$(".packageField").show();
			$(document).on('click','.removeRooms', function(){
				$(this).parent().remove();
				//var totRooms = $("#searchrooms").val();
				//$("#searchrooms").val(totRooms-1);
				var r=1;
				$(".roomNumber").each(function(){
					$(this).html(r);
					r++;
				});
			});
			
			$(document).on('change', ".selchild", function(){
				var number = $(this).attr('rel');
				if(parseInt($(this).val()) > 0)
				{
					$("#childAgeBox_"+number).show();
				}
			});
			
			
			$("#numOfExtrBed").keyup(function(){
				//alert("dfdfdsdf");
				var extrabed=$(this).val();
				//alert(childwithbed);
				if(extrabed == ''){
					$("#extraAdult").empty();
				}else{
					$("#extraAdult").val("Extra Adult");
				}
			});
			$("#childWOutBed").keyup(function(){
				//alert("dfdfdsdf");
				var childwoutbed=$(this).val();
				//alert(childwithbed);
				if(childwoutbed == ''){
					$("#chWoBed").empty();
				}else{
					$("#chWoBed").val("Extra Child w/o Bed");
				}
			});
			$("#childWithBed").keyup(function(){
				//alert("dfdfdsdf");
				var childwithbed=$(this).val();
				//alert(childwithbed);
				if(childwithbed == ''){
					$("#chWBed").empty();
				}else{
					$("#chWBed").val("Extra Child with Bed");
				}
			});
			/* $('#startdate').datepicker({
				format: "dd MM yyyy",
				onSelect: function() {
					var date = $(this).datepicker('getDate');
					var today = new Date();
					alert(date);
					var dayDiff = Math.ceil((today - date) / (1000 * 60 * 60 * 24));
					alert(dayDiff);
				}
				
			});
			$( "#enddate" ).datepicker({			
				format: "dd MM yyyy"
			}); */
			var newDate = '';
			var nextDate = '';
			var nextNewDate = '';
			var dateStart = $('#startdate')
			.datepicker({
				startDate: new Date(),
				format:'dd/mm/yyyy'
			})
			.on('changeDate', function(ev){
				nextNewDate = new Date(ev.date);
				nextNewDate.setDate(nextNewDate.getDate() + 1);
				//console.log(nextNewDate);
				dateEnd.datepicker('setStartDate', nextNewDate);
				dateStart.datepicker('hide');
				
				/////////////////////////
				newDate = new Date(ev.date)
				//newendDate = new Date(ev.date)
				nextDate = new Date(ev.date)
				
				
				//newendDate.setDate(newendDate.getDate() + 1);
				nextDate.setDate(nextDate.getDate() + 15);
				//alert(nextDate);
				var currDate1 = nextNewDate.getDate();
				var currDate15 = nextDate.getDate()+15;
				var currMonth = nextNewDate.getMonth()+1;
				var currYear = nextNewDate.getFullYear()
				
				currDate1 = currDate1 > 9 ? "" + currDate1: "0" + currDate1;
				currMonth = currMonth > 9 ? "" + currMonth: "0" + currMonth;
				//currDate15 = currDate15 > 9 ? "" + currDate15: "0" + currDate15;
				
				var dateStr = currDate1 + "/" + currMonth + "/" + currYear;
			
				$("#enddate").val(dateStr);  
				$("#enddate").parent().attr('data-date',dateStr);
				
				
				var date1 = newDate;
				var date2 = nextNewDate; //$('#enddate').val();
				
				//console.log(date1);
				//console.log(date2);
				
				//var date2 = new Date(ev.date);
				var timeDiff = Math.abs(date2.getTime() - date1.getTime());
				var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
				diffDays = diffDays;
				//alert(diffDays);
				$("#stayDuration").val(diffDays);
				//////////////////////////
				
				
				//dateEnd.focus();
			});

			var dateEnd = $('#enddate')
			.datepicker({
				format:'dd/mm/yyyy'
			})
			.on('changeDate', function(ev){
				dateStart.datepicker('setEndDate', ev.date);
				
				//var date1 = $('#startdate').val();
				var date1 = newDate; //new Date(date1);
				
				var date2 = new Date(ev.date);
				var timeDiff = Math.abs(date2.getTime() - date1.getTime());
				var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
				diffDays = diffDays;
				//alert(diffDays);
				$("#stayDuration").val(diffDays);
				
				dateEnd.datepicker('hide');
			});
			
			$("#stayDuration").change(function(){
				var val = $(this).val();
				
				var checkInDate = $('#startdate').val();
				var dateStr = checkInDate.split('/');
				var checkInDate = dateStr[1]+'/'+dateStr[0]+'/'+dateStr[2];
				//alert(checkInDate);
				
				var month = dateStr[1];
				
				var days = daysInMonth(month,dateStr[2]);
				//alert(days);
				
				var checkInDate = new Date(checkInDate);
				//alert(checkInDate);
				var currDate1 = checkInDate.getDate()+parseInt(val);
				//alert(currDate1);
				if(currDate1 > days)
				{
					var currDate1 = currDate1 - days;
					var currMonth = checkInDate.getMonth()+2;
				}
				else{
					var currMonth = checkInDate.getMonth()+1;
				}
				var currYear = checkInDate.getFullYear()
				
				currDate1 = currDate1 > 9 ? "" + currDate1: "0" + currDate1;
				currMonth = currMonth > 9 ? "" + currMonth: "0" + currMonth;
				//currDate15 = currDate15 > 9 ? "" + currDate15: "0" + currDate15;
				
				var dateStr = currDate1 + "/" + currMonth + "/" + currYear;
				//alert(dateStr);

				//checkout.val(newDate);
				$("#enddate").val(dateStr);
				$("#enddate").parent().attr('data-date',dateStr);
			});
			
			$(document).on('click','#searchDataBtn',function(){
				
				if($("#queryType").val() == '')
				{
					alert('Select Query Type');
					return false;
				}
				
				if($("#queryType").val() == 'Hotel')
				{
					if($("#destination").val() == '')
					{
						alert('Please Select Destination');
						return false;
					}
				}
				else if($("#queryType").val() == 'Package')
				{
					//alert($("#country").next().children().children().children().find('li').length);
					if($("#country").next().children().children().children().find('li').length <= 1)
					{
						alert('Please Select country');
						return false;
					}
					if($("#state").next().children().children().children().find('li').length <= 1)
					{
						alert('Please Select state');
						return false;
					}
				}
				if($("#startdate").val() == '')
				{
					alert('Please enter start date');
					return false;
				}
				
				$.ajax({
					type:"POST",
					url:"_ajax_search_data1.php?action=searchData",
					data:$("#search_data").serialize(),
					
					beforeSend:function(){
					//$(".loader").css('display','block');
					$("#me1").css({"display": "block"});
					$(".package_new").css({"display": "none"});
					$(".package_new_hotel").css({"display": "none"});
					//$("#package_data1").css({"display": "none"});
					$("#search_data1").css({"display": "none"});
					},
					success:function(html){
						//alert(html);
						var htmlArr = html.split('$abc#$');
						//alert(htmArr);
						$("#searchData").html(htmlArr[0]);
						//$("#searchpack").html(htmlArr[0]);
						//$("#ratingFilter").html(htmlArr[1]);
						$("#nameSearch").html(htmlArr[2]);
						$("#package_search").html(html);
						$("#me1").css({"display": "none"});
						$("#package_data1").css({"display": "block"});
						$(".package_new").css({"display": "block"});
						if($("#queryType").val()=="Package")
						{
                            //alert("hi");
							var optVal = '';
							var hotelIds = '';
							$(".hoteltypes").each(function(){
								optVal += $(this).find("option:selected").remove();
								if($(this).val() != '')
								{
									hotelIds += $(this).val('')
								}
							});
							    var optValRooms = '';
								var SelRoomIds = '';
								$(".userRoomTypes1").each(function(){
									optValRooms += $(this).find("option:selected").remove();
									if($(this).val() != '')
									{
										SelRoomIds += $(this).val('');
									}
								});
								var MealoptVal = '';
								var MealoptVal1='';
								$(".mealTypes1").each(function(){
									MealoptVal += $(this).find("option:selected").remove();
									MealoptVal1 += $(this).val('');
									
									//$(".userRoomTypes option:selected").text()+', ';
								});
						$("#selected_package_hotels").val('');	
						$("#selected_package_rooms1").val('');	
						$("#selected_package_mealPlans1").val('');	
						$("#selected_package_mealPlans1_name").val('');	
						$(".package_new").css({"display": "block"});
						$(".package_new_hotel").css({"display": "none"});
						}
						if($("#queryType").val()=="Hotel")
						{
						$(".package_new_hotel").css({"display": "block"});
						$(".package_new").css({"display": "none"});
						}
					}
				});
			});
			var package_name= $("#package_search").val();
			//alert(package_name);
			$(document).on('change','#package_search',function(){
				var package_id = $(this).val();
				//alert(package_id);
				if(package_id=='')
				{
					//alert('Select an option');
					//$("#nameSearch").val(hotel_id);
					//$("#package_data1").hide();
					//return false;
				}
				else
				{
				//var res = hotel_id.split("&");
				//var hotel_id1 = $(this).val(1);
				//alert(res);exit;
				//lert(hotel_id1);exit;
				//var info = 'name=' + hotel_id;
				$.ajax({
		    type: "POST",
            url: 'ajax_data_package_list.php?action=getPackageId', //This is the current doc
            data:{data:package_id},
			cache: false,
			beforeSend:function(){
				$("#me3").css({"display": "block"});
			},
            success: function(html){
				//alert(html);
				$("#me3").css({"display": "none"});
				$("#package_data1").show();
				$("#searchData1").hide();
				$("#package_data1").html(html);
				//$("#search_data1").html();
                // Why were you reloading the page? This is probably your bug
                // location.reload();

                // Replace the content of the clicked paragraph
                // with the result from the ajax call
                //$("#raaagh").html(data);
				//selected_mealTypes();
				//selected_roomTypes1();
				//calculate_price1();
            }
        });  
				}
				//alert(val);
				// if(val == 'all')
				// {
					//$(".hotelBox").show();	
				// }
				// else{
					// $(".hotelBox").hide();
					// $("#hotel_"+val).show();
				// }
			});
			
			$(document).on('change','#nameSearch',function(){
				var hotel_id = $(this).val();
				if(hotel_id=='')
				{
					//alert('Select an option');
					//$("#nameSearch").val(hotel_id);
					$("#search_data1").hide();
					return false;
				}
				else
				{
				//var res = hotel_id.split("&");
				//var hotel_id1 = $(this).val(1);
				//alert(res);exit;
				//lert(hotel_id1);exit;
				//var info = 'name=' + hotel_id;
				$.ajax({
		    type: "POST",
            url: '_ajax_search_data1.php?action=getHotelId', //This is the current doc
            data:{data:hotel_id},
			cache: false,
			beforeSend:function(){
				$("#me2").css({"display": "block"});
			},
            success: function(html){
				// var grand_total= $('#grandTotal span').text();
				// alert(grand_total);
				// return false;
				$("#search_data1").show();
				$("#search_data1").html(html);
				// var grand_total= $('#grandTotal span').text();
				// alert(grand_total);
				//$("#search_data1").html();
                // Why were you reloading the page? This is probably your bug
                // location.reload();

                // Replace the content of the clicked paragraph
                // with the result from the ajax call
                //$("#raaagh").html(data);
				$("#me2").css({"display": "none"});
				$('#viewDetail1').scrollTop(0 ,200);
				selected_mealTypes();
				selected_roomTypes();
				calculate_price();
				
            }
        }); 
				}		
				//alert(val);
				// if(val == 'all')
				// {
					//$(".hotelBox").show();	
				// }
				// else{
					// $(".hotelBox").hide();
					// $("#hotel_"+val).show();
				// }
			});
			
			// $(document).on('change','#ratingFilter',function(){
				// var val = $(this).val();
				//alert(val);
				// if(val == 'all')
				// {
					// $(".hotelBox").show();	
				// }
				// else{
					// $(".hotelBox").hide();
					// $(".hotelrating_"+val).show();
				// }
				
			// });
			
			var c_id= $("#country").val();
			if(c_id!="")
			{
			
				//alert(c_id);
				//var st_id=$("#state").val();
				var state_all1=$("#state_all1").val();
				//alert(state_all1);
				var dataString = 'id='+ c_id+"&"+'state_all='+state_all1;
				//var dataString .='st_id='+ st_id;
				
				//$("#state").find('option').remove();
				//$("#city").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state1.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#state").html(html);			
					} 
				});	
			}
			var sta_id= $("#state").val();
			//alert(sta_id);
			if(sta_id!="")
			{
			
				//alert(sta_id);
				var city_all1=$("#city_all1").val();
				var dataString = 'id='+ sta_id+"&"+'city_all1='+city_all1;
			
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city1.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#city").html(html);
					} 
				});
			}
			$("#country").change(function()
			{
				//alert("punamsaini");
				var id=$(this).val();
				
				var state_all1=$("#state_all1").val();
				//alert(state_all1);
				var dataString = 'id='+ id+"&"+'state_all='+state_all1;
				//$("#state").find('option').remove();
				//$("#city").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state1.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#state").html(html);			
					} 
				});
			});
			
			$("#state").change(function()
			{
				var id=$(this).val();
				//alert(id);
				var city_all1=$("#city_all1").val();
				var dataString = 'id='+ id+"&"+'city_all1='+city_all1;
				
			
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city1.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#city").html(html);
					} 
				});
			});
		
		});
		
		
		function daysInMonth(month,year) {
			return new Date(year, month, 0).getDate();
		}
		
		function getHotelPrice(){
			selected_roomTypes();
		    calculate_price();
		}
		function getHotelMeal(){
			selected_mealTypes()
		    calculate_price();
		}
		</script>
<script>
function selected_roomTypes()
{
	var userRooms = '';
	var i=0;
	$(".userRoomTypes").each(function(){
		//alert($(this).val());
		i++;
		var val = $(this).val();
		userRooms += val+',';
	});
	$("#userSelectRoomTypes").val(userRooms);
}

function selected_mealTypes()
{
	var userMeals = '';
	var i=0;
	$(".mealTypes").each(function(){
		//alert($(this).val());
		i++;
		var val = $(this).val();
		userMeals += val+',';
	});
	//alert(userMeals);
	$("#userSelectMealTypes").val(userMeals);
}	

function calculate_price()
{
	var priceMargin = $("#priceMargin").val();
	
	$.ajax({
		type:"POST",
		url:"_ajax_search_data.php?action=getPrice",
		data:$("#formData").serialize(),
		beforeSend:function(){
			
		},
		success:function(html){
			//var calP = html.splice(-1,1);
			var response = html;
			
			//alert(response);
			var priceArr = response.split(',"description"');
			var calPrice = priceArr[0]+'}';
			//alert(calPrice);
			$("#calculated_prices").val(calPrice);
			$("#calculated_hotel_prices").val(calPrice);
			
			var obj = JSON.parse(html);
			//console.log(obj.description);
			var desc = obj.description;
			calculate_priceWith_margin(priceMargin);
			
			if(desc != '')
			{
				$("#mealDescriptions").html(desc);
				$("#mealDesBox").show();
			}
			else
			{
				$("#mealDesBox").hide();
				$("#mealDescriptions").html('');
			}
			/* var totalRooms = $(".userRoomTypes").length;
			var totPrice = 0;
			for(var i=1; i<=totalRooms; i++)
			{
				$("#roomPrice_"+i).html(obj[i]);
				totPrice += parseInt(obj[i]);
			}
			$("#totalHotelPrice").html(totPrice);
			var serviceTax = (totPrice*9)/100;
			$("#serviceTax").html(serviceTax);
			var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
			$("#grandTotal").html(grandTotal);
			$("#calculated_prices").val(html);
			
			var optVal = '';
			$(".userRoomTypes").each(function(){
				optVal += $(this).find("option:selected").text()+',';
				
				//$(".userRoomTypes option:selected").text()+', ';
			});
			//alert(optVal);
			$("#selected_rooms").val(optVal); */
		}
	});
}

function calculate_priceWith_margin(margin_val)
{
	
	var roomPrices = $("#calculated_prices").val();
	//alert(margin_val);
	$("#pricemargin_hotel").val(margin_val);
	var obj = JSON.parse(roomPrices);
	//console.log(obj);
	
	var totalRooms = $(".userRoomTypes").length;
	//alert(totalRooms);
	var totPrice = 0;
	var roomprice = 0;

	for(var i=1; i<=totalRooms; i++)
	{
		//alert(obj[i]);
		roomprice = obj[i];
		roompriceWithmargin = roomprice + (roomprice*parseInt(margin_val)/100);
		$("#roomPrice_"+i).html(roompriceWithmargin);
		
		totPrice += parseInt(roompriceWithmargin);
	}
	$("#totalHotelPrice").html(totPrice);
	var serviceTax = (totPrice*5)/100;
	$("#serviceTax").html(serviceTax);
	var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
	$("#grandTotal").html(grandTotal);
	$("#grand_total_hotel").val(grandTotal);
	//$("#calculated_prices").val(html);
	
	var optVal = '';
	$(".userRoomTypes").each(function(){
		optVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	//alert(optVal);
	$("#selected_rooms").val(optVal);
	$("#hotel_selected_rooms").val(optVal);
	
	var MealoptVal = '';
	$(".mealTypes").each(function(){
		MealoptVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	$("#selected_mealPlans").val(MealoptVal);
	$("#hotel_meal_plans").val(MealoptVal);
}

function downlaod_pdf(param, action)
{
	var prices = $("#calculated_prices").val();
	var selc_prices = $("#selected_rooms").val();
	var selc_meal_plans = $("#selected_mealPlans").val();
	var queryNumber = $("#queryNumber").val();
	var priceMargin = $("#priceMargin").val();
	var data = "pdfType=hotel&prices="+prices+'&selRooms='+selc_prices+'&qNo='+queryNumber+'&pMargin='+priceMargin+'&selMealPlans='+selc_meal_plans;
	$.ajax({
		type:"POST",
		url:'generate_pdf.php?'+param,
		data:data,
		beforeSend:function(){
			
		},
		success:function(html){
			//alert(html);
			//e.preventDefault();  //stop the browser from following
			//window.location.href = 'download_pdf.php?f='+html
			if(action == 'downlaod')
			{
				window.open(
				  'download_pdf.php?f='+html,
				  '_blank' // <- This is what makes it open in a new window.
				);
			}
			else
			{
				for (instance in CKEDITOR.instances) {
					CKEDITOR.instances[instance].updateElement();
				}
				$("#mailFilePath").val(html);
				$.ajax({
					type: "POST",
					url: "send_email.php",
					data: $("#tour_mail").serialize(),
					cache: false,
					beforeSend:function() {
						$("#showLoaderEmail").show();
					},
					success: function(html)
					{
						//alert(html);	
						if(html == '1')
						{
							alert('Email Sent Successfully');
							$('#sendToCl').modal('hide');
							$("#showLoaderEmail").hide();
						}
						else
						{
							alert('There is some error in sending email');
						}
					}
				});
			}
		}
	});
}


</script>

<!--package ajax-->

<script>
    $(function () {
		
		
		//alert(userRooms);
		//selected_roomTypes();
		//calculate_price();
		
		//calculate_price();
		$(document).on('change','.userRoomTypes1',function(){
			//alert('yes');
			$("#userSelectHotel").val($('#hotel_'+$(this).attr('rel')).val());
			selected_roomTypes1();
			calculate_price1($(this).attr('rel'), $(this).attr('selDate'));
		});
		
		$(document).on('change','.mealTypes1',function(){
			//alert('yes');
			//$("#userSelectHotel").val($('#hotel_'+$(this).attr('rel')).val());
			selected_roomTypes1();
			calculate_price1($(this).attr('rel'), $(this).attr('selDate'));
		});
		
		$(document).on('change','#vehCleCost',function(){
			var cost = $(this).val();
			$("#vehPrice").html(cost);
			$("#selectedVehcleCost").val(cost);
			$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val());
			$("#vehicle_package_cost").val(cost);
		});
		
		//room new search //
		
		
		//end room search//
		$(document).on('change','.hoteltypes',function(){
			var searchType = $("#searchType").val();
			var startDate = $("#hidStartDate").val();
			var endDate = $("#hidEndDate").val();
			var selDate = $(this).attr('selectedDate');
			var room_type_id=$("#room_type_id").val();
			var data = 'hotId='+$(this).val()+'&startDate='+startDate+'&endDate='+endDate+'&selDate='+selDate+'&searchType='+searchType+'&room_type_id='+room_type_id;
			var number = $(this).attr('rel');
			
			//alert(room_type_id);
			//alert(number);
			$.ajax({
				type:"POST",
				url:"_ajax_get_pakage_detail.php?action=getHotelRooms",
				data:data,
				beforeSend:function(){
					
				},
				success:function(html){
					//alert(html);
					var dataArr = html.split('$##$');
					
					$("#roomType_"+number).html(dataArr[0]);
					$("#mealType_"+number).html(dataArr[1]);
					//alert(html);
					//$("#showQueryDetail").html(html);
					selected_roomTypes1();
					//calculate_price($(this).attr('rel'));
				}
			});
		});
		
		$("#searchQueryBtn").click(function(){
			var query = $("#queryNumber").val();
			if(query == '')
			{
				alert('Please Enter query first');
			}
			else
			{
				var data = 'query='+query+'&qT=Package';
				$.ajax({
					type:"POST",
					url:"_ajax_search_data.php?action=getQueryDetail",
					data:data,
					beforeSend:function(){
						
					},
					success:function(html){
						var dataArr = html.split('$#$');
						$("#showQueryDetail").html(dataArr[0]);
						$("#rescipent_emails").val(dataArr[1]);
						$("#tourSub").val(dataArr[3]);
						
						var ckeditorContent = 'Dear '+dataArr[2]+'<br/><br/>Greetings from <strong><span style="font-size: 19px;background: yellow; color:#00c0ef;">LiD – Travel </span>!!!</strong><br/><br/>Thank you for considering us for your forthcoming travel plan, in response please find attached tour proposal for your kind perusal as per the details provided by you.<br/><br/>We Hope all the above is in order and if you need any further clarification please call / write us.<br/><br/>Looking forward for a response/acknowledgment/confirmation on the same at the earliest.<br/><br/>Thanks and Regards !!!<br/>Gaurav<br/>Team LiD</br/>m.+91(0)9999614493<br/><br/>';
						CKEDITOR.instances['email_body'].setData(ckeditorContent);
					}
				});
			}
		});
		
		var queryNumb = '<?php echo $queryNumber; ?>';
		if(queryNumb != '')
		{
			//alert('yes');
			$("#searchQueryBtn").click();
		}
		
      });
	  
	function selected_roomTypes1()
	{
		var userRooms1 = '';
		var i=0;
		$(".userRoomTypes1").each(function(){
			//alert($(this).val());
			i++;
			var val = $(this).val();
			userRooms1 += val+',';
		});
		$("#userSelectRoomTypes1").val(userRooms1);
		
		var userSelctedMeals = '';
		$(".mealTypes").each(function(){
			//alert($(this).val());
			i++;
			var val = $(this).val();
			userSelctedMeals += val+',';
		});
		$("#userSelectedMealPlans1").val(userSelctedMeals);
		
	}	
	
	function calculate_price1(number, selDate)
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getpakageHotelPrice&selDate="+selDate,
			data:$("#formData1").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				//alert(html);
				var obj = JSON.parse(html);
				//console.log(obj);
				
				$("#dayPrice_"+number).html(obj[1]);
				
				/* var totalRooms = $(".userRoomTypes").length;
				var totPrice = 0;
				for(var i=1; i<=totalRooms; i++)
				{
					$("#roomPrice_"+i).html(obj[i]);
					totPrice += parseInt(obj[i]);
				}
				$("#totalHotelPrice").html(totPrice);
				var serviceTax = (totPrice*1.75)/100;
				$("#serviceTax").html(serviceTax);
				var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
				$("#grandTotal").html(grandTotal); */
			}
		});
	}
	calc_fun();
	function calc_fun()
	{
		var priceMargin1 = $("#priceMargin1").val();
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getpakageHotelPrice2",
			data:$("#formData1").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				//alert(html);
				//var obj2=json_encode()
				//return false;
				$("#calculated_prices1").val(html);
				
				calculate_priceWith_margin1(priceMargin1);
				
				/* var obj = JSON.parse(html);
				console.log(obj);
				
				var totalRooms = $("#totalBookingRooms").val();
				var totPrice = 0;
				//alert(totalRooms);
				var vehicleCost = $("#selectedVehcleCost").val();
				var no_of_vehicle = $("#no_of_vehicle").val();
				var prRoomVehCost = parseInt(vehicleCost)*(parseInt(no_of_vehicle))/parseInt(totalRooms);	
			
				
				for(var i=1; i<=totalRooms; i++)
				{
					var roomPrice = parseInt(obj[i])+parseInt(prRoomVehCost);
					//alert($roomPrice);
					$("#roomPrice_"+i).html(roomPrice);
					totPrice += parseInt(roomPrice);
				}
				
				$("#totalHotelPrice").html(totPrice);
				var serviceTax = (totPrice*9)/100;
				$("#serviceTax").html(serviceTax);
				var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
				$("#grandTotal").html(grandTotal);
				$("#hot_supp_cost").html('');
				get_hotel_suppl_cost(); 
				
				var optVal = '';
				var hotelIds = '';
				$(".hoteltypes").each(function(){
					optVal += $(this).find("option:selected").text()+',';
					if($(this).val() != '')
					{
						hotelIds += $(this).val()+',';
					}
				});
				//alert(optVal);
				$("#selected_hotels").val(optVal+'$#$'+hotelIds);
				
				var optValRooms = '';
				var SelRoomIds = '';
				$(".userRoomTypes").each(function(){
					optValRooms += $(this).find("option:selected").text()+',';
					if($(this).val() != '')
					{
						SelRoomIds += $(this).val()+',';
					}
				});
				$("#selected_rooms").val(optValRooms+'$#$'+SelRoomIds);
				$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val()); */
			}
		});
	}
	 
	
	function calculate_priceWith_margin1(margin_val1)
	{
		$("#pricemargin_package").val(margin_val1);
		var roomPrices1 = $("#calculated_prices1").val();
		  $("#calculate_package_price").val(roomPrices1);
		  
		if(roomPrices1 == '')
		{
			return false;
		}
		
		var obj = JSON.parse(roomPrices1);
		//console.log(obj);
		
		var totalRooms = $("#totalBookingRooms").val();
		var totPrice1 = 0;
		var totPrice2 =0 ;
		//alert(totalRooms);
		var vehicleCost = $("#selectedVehcleCost").val();
		var no_of_vehicle = $("#no_of_vehicle").val();
		$("#no_of_package_vehicle").val(no_of_vehicle);
		var prRoomVehCost = parseInt(vehicleCost)*(parseInt(no_of_vehicle))/parseInt(totalRooms);	
	
		
		for(var i=1; i<=totalRooms; i++)
		{
			var roomPrice1 = parseInt(obj[i])+parseInt(prRoomVehCost);
			roomPrice1 = roomPrice1;
			roomPrice2 = roomPrice1+(roomPrice1*parseInt(margin_val1)/100);
			//alert($roomPrice);
			$("#roomPrice_"+i).html(roomPrice1);
			$("#roomPrice1_"+i).html(roomPrice1);
			totPrice1 += parseInt(roomPrice1);
			totPrice2 += parseInt(roomPrice2);
		}
		//alert(totPrice);
		$("#totalHotelPrice1").html(totPrice1);
		$("#totalHotelPrice4").html(totPrice1);
		$("#totalHotelPrice2").html(totPrice2);
		$("#totalHotelPrice3").html(totPrice2);
		var profit=totPrice2-totPrice1;
		$("#profit").html(profit);
		$("#profit2").html(profit);
		$("#profit1").html(profit);
		var serviceTax1 = (totPrice2*5)/100;
		$("#serviceTax1").html(serviceTax1);
		$("#serviceTax2").html(serviceTax1);
		var pack_mark = $("#package_markup").val();
		var grandTotal1 = parseInt(totPrice2) + parseInt(serviceTax1);
		var grandTotal_p1 = grandTotal1+(grandTotal1*parseInt(pack_mark)/100);
		$("#grandTotal1").html(grandTotal_p1);
		$("#grandTotal2").html(grandTotal_p1);
		$("#grandPackageTotal1").val(grandTotal_p1);
		$("#hot_supp_cost").html('');
		get_hotel_suppl_cost(); 
		
		var optVal = '';
		var hotelIds = '';
		$(".hoteltypes").each(function(){
			optVal += $(this).find("option:selected").text()+',';
			if($(this).val() != '')
			{
				hotelIds += $(this).val()+',';
			}
		});
		//alert(optVal);
		$("#selected_hotels").val(optVal+'$#$'+hotelIds);
		$("#selected_package_hotels").val(optVal+'$#$'+hotelIds);
		
		var optValRooms = '';
		var SelRoomIds = '';
		$(".userRoomTypes1").each(function(){
			optValRooms += $(this).find("option:selected").text()+',';
			if($(this).val() != '')
			{
				SelRoomIds += $(this).val()+',';
			}
		});
		$("#selected_rooms1").val(optValRooms+'$#$'+SelRoomIds);
		$("#selected_package_rooms1").val(optValRooms+'$#$'+SelRoomIds);
		$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val());
		var vehicle_name= $('#vehCleCost').find("option:selected").text();
		$("#vehicle_name").val(vehicle_name);
		var MealoptVal = '';
		var MealoptVal1='';
		$(".mealTypes1").each(function(){
			MealoptVal += $(this).find("option:selected").text()+',';
			MealoptVal1 += $(this).val()+',';
			
			//$(".userRoomTypes option:selected").text()+', ';
		});
		$("#selected_mealPlans1").val(MealoptVal);
		$("#selected_package_mealPlans1").val(MealoptVal1);
		$("#selected_package_mealPlans1_name").val(MealoptVal);
	}
	
	function get_hotel_suppl_cost()
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getHotelSuppCost",
			data:$("#formData1").serialize(),
			beforeSend:function(){
				$("#hot_supp_cost").html('');
			},
			success:function(html){
				//alert(html);
				$("#hot_supp_cost").html(html);
			}
		});
	}
	
	function downlaod_pdf(param, action)
	{
		var prices = $("#calculated_prices1").val();
		var selc_hotels = $("#selected_hotels").val();
		var selc_rooms = $("#selected_rooms1").val();
		var selc_mealPlans = $("#selected_mealPlans1").val();
		var selc_vehicle = $("#selectedVehicle").val();
		var queryNumber = $("#queryNumber").val();
		var priceMargin = $("#priceMargin1").val();
		
		selc_hotels = btoa(selc_hotels);
		//console.log(selc_hotels);
		
		var data = "pdfType=package&prices="+prices+'&selRooms='+selc_rooms+'&selHotels='+selc_hotels+'&selVehicle='+selc_vehicle+'&qNo='+queryNumber+'&pMargin='+priceMargin+'&selMealPlans='+selc_mealPlans;
		$.ajax({
			type:"POST",
			url:'generate_pdf.php?'+param,
			data:data,
			beforeSend:function(){
				$("#showLoaderEmail").show();
			},
			success:function(html){
				//alert(html);
				$("#showLoaderEmail").hide();
				//e.preventDefault();  //stop the browser from following
				//window.location.href = 'download_pdf.php?f='+html
				if(action == 'downlaod')
				{
					window.open(
					  'download_pdf.php?f='+html,
					  '_blank' // <- This is what makes it open in a new window.
					);
				}
				else
				{
					for (instance in CKEDITOR.instances) {
						CKEDITOR.instances[instance].updateElement();
					}
					$("#mailFilePath").val(html);
					$.ajax({
						type: "POST",
						url: "send_email.php",
						data: $("#tour_mail").serialize(),
						cache: false,
						beforeSend:function() {
							$("#showLoaderEmail").show();
						},
						success: function(html)
						{
							//alert(html);	
							if(html == '1')
							{
								alert('Email Sent Successfully');
								$('#sendToCl').modal('hide');
								$("#showLoaderEmail").hide();
							}
							else
							{
								alert('There is some error in sending email');
							}
						}
					});
				}
			}
		});
	}
	$(document).on('click','#tc_submit1',function(){
				
			
				//alert('hello');
				$.ajax({
					type:"POST",
					url:"_ajax_search_data1.php?action=tour_card_edit",
					data:$("#tour_card_data,#search_data").serialize(),
					    
					beforeSend:function(){
						
					},
					success:function(html){
						
						alert('Data submitted');
						
					}
				});
			});
			var req=1;
			$(document).on('click','#cal_price_rates',function(){
				    var element = $(this);
					var del_id1 = element.attr("rel");
					var array1 = del_id1.split(",");
					var frm_dt=array1[0];
					//alert(frm_date);
					var bkg_date2=array1[1];
					var breakfast=array1[2];
					//alert(breakfast);
					var room_type_id_new=array1[3];
					var room_type=array1[4];
					var meal_plan_name=array1[5];
					var city_name=array1[6];
					var hotel_name=array1[7];
					var country=array1[8];
				
				var room_rates=[];
				var count=$("#room_count").val();
				
				var date_search=$("#date_search").val();
				var editItiId=$("#editItiId").val();
				var margin_percent=$("#margin_percent").val();
				var room=$("#room").val();
			   // alert(date_search);
				//alert(editId);
				var room_rates2=[];
				var room_name=[];
				for(var i=1; i<=count; i++)
				{
				$("#edit_room_name"+i).each(function()
				{
				   room_name[i] = $(this).attr('value');
				 });
				 $("#edit_price"+i).each(function()
				{
				   room_rates2[i] = $(this).attr('value');
				 });
				 var room_id = $("#edit_room"+i).val();
			     room_rates[room_id]=$("#edit_price"+i).val();
				 
				}
				//console.log(room_id);
				//console.log(room_rates2);
		
			
				
				//return false;
				  var room_rates1=JSON.stringify(room_rates);
				$.ajax({
					type:"POST",
					url:"_ajax_room_price_det.php?action=add_hotel_tour_card&room_rates="+room_rates1+"&searchData="+date_search+"&editItiId="+editItiId+"&room="+room+"&margin_percent="+margin_percent+"&room_name="+room_name+"&room_rates2="+room_rates2+"&tour_id="+<?php echo $id ?>+"&frm_dt="+frm_dt+"&bkg_date2="+bkg_date2+"&breakfast="+breakfast+"&room_type_id_new="+room_type_id_new+"&room_type="+room_type+"&meal_plan_name="+meal_plan_name+"&city_name="+city_name+"&hotel_name="+hotel_name+"&country="+country,
					beforeSend:function(html){
					$("#result_data_price1").html('');
					
					},
					success:function(response){
						//alert(response);
					$('.data_tour_cost').html('')
					$("#data_tour_cost").remove();	
					$('.data_btn_success').css("display", "none");
					
					//alert(req++);
				      //count(response);
					 //$("#result_data_price").html('');
					 
					 $("#result_data_price1").html(response);
						
					}
				});
				
			});
			function hotel_confiramtion(data)
			{
				alert("Hotel Confirmation Send Successfully");
				location.reload();
			}
    </script>
	
	
	<!--end package ajax-->
		<script src="asset/bootstrap-datepicker.js"></script>
<?php include('footer.php'); ?>