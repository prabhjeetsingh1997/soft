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
	//print_r($arr_query_tour_card_room_dt);exit;
	//print_r($state_all1);exit;
	//print_r($arr_query_tour_card_package_dt);
	$hotel_name1=explode("&",$arr_query_tour_card_det['choosen_pack']);
	$hotel_name=explode(",",$arr_query_tour_card_package_dt[0]['hotel']);
	
	$hotel_new_id=implode(",",$hotel_name);
	//print_r($hotel_new_id);
	$room_type_name=explode(",",$arr_query_tour_card_package_dt[0]['room_type']);
	$room_type_name1=implode(",",$room_type_name);
	$meal_plan_name=explode(",",$arr_query_tour_card_package_dt[0]['meal_paln']);
	$room=count($arr_query_tour_card_room_dt);
		$sum='';
		$room_type_id1=array();
		$meal_plan_id1=array();
		$room_sub_total_price=array();
		$room_sub_total_hotel_price=array();
		for($r=0;$r<$room;$r++)
		{
			
			$room_type_price_new=explode(",",$arr_query_tour_card_room_dt[$r]['price']);
			foreach($room_type_price_new as $room_type_price_new4)
			{
				$room_sub_total_hotel_price[]=$room_type_price_new4;
			}
			$room_sub_total_price[]=implode(",",$room_type_price_new);
			//echo array_sum(explode(",",$arr_query_tour_card_room_dt[$r]['price']));
			//print_r($room_type_price_new1);
			$room_type_id=explode(",",$arr_query_tour_card_room_dt[$r]['room_type_id']);
			$room_type_id1[]=implode(",",$room_type_id);
			$meal_plan_id=explode(",",$arr_query_tour_card_room_dt[$r]['meal_plan_id']);
			$meal_plan_id1[]=implode(",",$meal_plan_id);
		$oc=$arr_query_tour_card_det['vehicle_package_cost']*$arr_query_tour_card_det['no_of_package_vehicle'];
		$sum=$arr_query_tour_card_room_dt[$r]['price']+$oc;
		//$sum=$sum1+$arr_query_tour_card_det['vehicle_package_cost']*$arr_query_tour_card_det['no_of_package_vehicle'];
		$vehicle=$arr_query_tour_card_det['vehicle_package_cost']*$arr_query_tour_card_det['no_of_package_vehicle'];
		//echo $vehicle;exit;
		$pc1=$vehicle+($vehicle* $arr_query_tour_card_det['margin_percent']/100);
		$pc2=$arr_query_tour_card_room_dt[$r]['price']+($arr_query_tour_card_room_dt[$r]['price']* $arr_query_tour_card_det['margin_percent']/100);
		$pc = ceil($pc1+$pc2);
		
		
		
			
			//print_r($room_type_price_calc3);
		}
		 $room_sub_total_hotel_price1=implode(",",$room_sub_total_hotel_price);
		 
	    
		  $room_sub_total_price1=array_sum($room_sub_total_price)*$arr_query_tour_card_det['margin_percent']/100;
		  $room_sub_total_price2= array_sum($room_sub_total_price)+$room_sub_total_price1;
		$room_type_id2=implode(",",$room_type_id1);
		$meal_plan_id2=implode(",",$meal_plan_id1);
		//print_r($room_type_id2);exit;
		//exit;
		
	
		
		$gst=floor($room_sub_total_price2*(5/100));
		
		$profit1=$pc-$sum;
		//$profit1=$total_v_p-$profit-$gst;
		
		//echo $room_type_id1[0];
		//echo $room_type_id1[1];
		//echo '<br />';
		 //print_r($room_type_id1);exit;
		
	}
	$romm_type_id=$arr_query_tour_card_room_dt[0]['room_type_id'];
	
	
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
?>
<div class="content-wrapper">
	<input type="hidden" id="room_type_id" value="<?php echo $room_type_name; ?>" />
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
	<th><input class="form-control" name="bkg_by" id="bkg_by" type="text" value="<?php echo $arr_query['bkg_by'] ?>"/></th>
		<th>Bkg Type:</th>
		<th style="width:100px;"><select class="form-control" onchange="my_fun()" name="queryType" id="queryType">
										
										<option value="Hotel">HOTEL</option>
										
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
		<th colspan="2"><input name="invoice_no" value="<?php echo  $arr_query['invoice_no'] ?>" class="form-control" type="text" /></th>
		
		
	   </tr>
	   
	  <input type="hidden" name="grand_total_hotel" id="grand_total_hotel" value="<?php echo $arr_query_tour_card_det['grand_total'] ?>"/>
	 
	  <input type="hidden" name="hotel_selected_rooms" id="hotel_selected_rooms" />
	  <input type="hidden" name="hotel_meal_plans" id="hotel_meal_plans" />
	  <input type="hidden" name="calculated_hotel_prices" id="calculated_hotel_prices" value="<?php echo $room_sub_total_hotel_price1; ?>" />
	  <input type="hidden" name="pricemargin_hotel" id="pricemargin_hotel" value="<?php echo $arr_query_tour_card_det['margin_percent'] ?>"/>
	   
	  <input type="hidden" name="calculate_package_price" id="calculate_package_price"  />
	  <input type="hidden" name="selected_package_hotels" id="selected_package_hotels" />
	  <input type="hidden" name="selected_package_rooms1" id="selected_package_rooms1" /> 
	  <input type="hidden" name="selected_package_mealPlans1" id="selected_package_mealPlans1" /> 
	  <input type="hidden" name="selected_package_mealPlans1_name" id="selected_package_mealPlans1_name" /> 
	  <input type="hidden" name="vehicle_package_cost" id="vehicle_package_cost" value="<?php echo $arr_query_tour_card_det['vehicle_package_cost'] ?>" /> 
	  <input type="hidden" name="no_of_package_vehicle" id="no_of_package_vehicle" value="<?php echo $arr_query_tour_card_det['no_of_package_vehicle'] ?>" />
	  <input type="hidden" name="vehicle_name" id="vehicle_name" value="<?php echo $arr_query_tour_card_det['vehicle_name'] ?>" />
	  <input type="hidden" name="employee_id" value="<?php echo $_SESSION['admin_Email'] ?>"/> 
	  <input type="hidden" name="package_id_page" value="<?php echo $_GET['id'] ?>" />
	  <input type="hidden" name="userSelectRoomTypes1" id="userSelectRoomTypes1" value='<?php echo $room_type_id2 ?>'>
	  <input type="hidden" name="userSelectMealTypes1" id="userSelectMealTypes1" value='<?php echo $meal_plan_id2; ?>'> 
	  <input type="hidden" name="choosen_pack" id="choosen_pack" value='<?php echo  $arr_query_tour_card_det['choosen_pack']; ?>'> 
	   <input type="hidden" name="userSelectRoomTypes5" id="userSelectRoomTypes5" value=''>
	  <input type="hidden" name="userSelectMealTypes5" id="userSelectMealTypes5" value=''> 
	   <input type="hidden" value="<?php echo $hotel_markup; ?>" id="hotel_markup" />
	   <input type="hidden" value="<?php echo $package_markup; ?>" id="package_markup" />
    </thead>
  </form>   
  </table>
 

	<form role="form" method="POST" name="search_data" id="search_data" style="display:block;">
					<!--<input type="hidden" name="extraAdult" id="extraAdult" value=""/>
					<input type="hidden" name="chWoBed" id="chWoBed" value=""/>
					<input type="hidden" name="chWBed" id="chWBed" value=""/>-->
					<input type="hidden" name="searchrooms" id="searchrooms" value="1"/>
					<input type="hidden" name="queryNumber" id="queryNumber" value="<?php echo $qn; ?>" />
					
					<input type="hidden" name="hotel_name1" value="<?php echo $hotel_name1[0]; ?>" />
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
									<th><input type="hidden" name="queryType" id="queryType1" value="Hotel" /></th>
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
										<option <?php if($arr_query_tour_card_det['destination']==$cityArr[0]['id']) echo 'selected'; ?> value="<?php echo $cityArr[0]['id']; ?>"><?php echo ucfirst($cityArr[0]['city']); ?></option>
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
						<button type="button" class="btn btn-primary" name="searchDataBtn" id="searchDataBtn">Search Hotel </button>
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
			$priceMargin = base64_decode($_GET['pMargin']);
		$calculatedprices=$_GET['prices'];
		if($calculatedprices != '')
		{
			$calculatedprices = base64_decode($calculatedprices);
			$priceArr = json_decode($calculatedprices);
			//print_r($priceArr);exit;
			$pArr = array();
			foreach($priceArr as $val)
			{
				$pArr[] = $val + ($val*$priceMargin/100);
				//echo '<br>'.$val;
			}
			//$priceArr->[0];
			$subTotal = array_sum($pArr);
			$serviceTax = $subTotal*5/100;
			$grandTot = $subTotal+$serviceTax;
			
			$selRoomsdata=$_GET['selRooms'];
			$selMPdata=$_GET['selMealPlans'];
			$selRoomsArr = explode(',', rtrim(base64_decode($selRoomsdata), ','));
			$selMealPlansArr = explode(',', rtrim(base64_decode($selMPdata), ','));
			//print_r($selMealPlansArr);
		}
		$queryNo = base64_decode($_GET['qNo']);
		$quryDetail = '';
		if($queryNo != '')
		{
			$queryData=$objAdmin->getQueryByNumber($queryNo);
			$number = $queryData['query_no'];
			$query_date = date('d/m/Y', strtotime($queryData['query_date']));
			$query_type = 'Hotel';
			$person_name = $queryData['person_name'];
			
			$quryDetail = '<div class="col-md-12"><p>Dear '.$person_name.'</p></div>';
		}
		$type=$_GET['type'];
		//echo $type;exit;
		$arr_query_tour_card_det1 = explode("&",$arr_query_tour_card_det['choosen_pack']);
		$editHotelId=$arr_query_tour_card_det1[0];
		$searchData=$arr_query_tour_card_det1[1];
		$queryNumber = $_GET['qn'];
		
		$searchDataStr = base64_decode($searchData);
		
		//Array ( [searchrooms] => 2 [queryType] => Hotel [destination] => New Delhi [startdate] => 07/28/2016 [enddate] => 07/29/2016 [stayDuration] => 1 [adults] => Array ( [0] => 1 [1] => 2 ) [child] => Array ( [0] => 1 [1] => 2 ) [child_age] => Array ( [0] => 5 [1] => 5,9 ) [] => )

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
		
		//print_r($paramArr);
		//Array ( [searchrooms] => 1 [queryType] => Hotel [destination] => New Delhi [startdate] => 02/08/2016 [enddate] => 03/08/2016 [stayDuration] => 1 [adults] => 1 [child] => 0 [child_age] => [] => )

		$sDate = explode('/',$paramArr['startdate']);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$paramArr['enddate']);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		
		//$startdate=$paramArr['startdate'];
		//$enddate=$paramArr['enddate'];
		
		$searchrooms=$paramArr['searchrooms'];
		$destination=$paramArr['destination'];
		
		$stayDuration=$paramArr['stayDuration'];
		$adults=$paramArr['adults'];
		$child=$paramArr['child'];
		$child_age=$paramArr['child_age'];
		
		
		
		$hotelData = $objhotel->getHotelById($editHotelId);
		$hotelName=$hotelData['hotel_name'];
		$hotelstar_rating=$hotelData['star_rating'];
		
		//print_r($hotelData);
		
		$hotelCity = $destination;
		
		$hAddress=$objhotel->getHotelAddress($editHotelId);
		//print_r($hAddress);
		$cityArr = $objhotel->getCitiesById($hAddress['city']);
		$hcity = $cityArr[0]['city'];
		
		$stateArr = $objhotel->getSatesById($hAddress['state']);
		$hstate = $stateArr[0]['state_name'];
		
		$countryArr = $objhotel->getSatesById($hAddress['state']);
		$hcountry = $countryArr[0]['country_name'];
		
		$hotAddress = $hAddress['address1'].' '.$hAddress['address2'].' '.$hcity.', '.$hstate.' '.$hcountry.', '.$hAddress['pin_code'];
		//print_r($stateArr);
		
		
		$picByRoom=$objhotel->getHotelImages($editHotelId);
		$image = $picByRoom[0]['image'];
		
		$date_rates_detail=$objhotel->getDateRatesByid_calculate($editHotelId, $startdate, $enddate);
		//print_r($date_rates_detail);exit;
		
		
		//echo $mealStr;
		
		$hotelDateIdStr = rtrim($hotelDateIdStr,',');
		
		$hotelDateId = $date_rates_detail[0]['id'];
		
		$arrRoomType=$objhotel->getHotelRoomTypeByid($editHotelId);
		//print_r($arrRoomType);
		
		
		
		// $i=0;
		// foreach($arrRoomType as $roomType)
		// {
			// $i++;
			// $roomId = $roomType['id'];
			// $room_type = $roomType['room_type'];
			// $roomTypeStr .= '<option value="'.$roomId.'">'.$room_type.'</option>';
			
			// $hotel_rates_detail=$objhotel->getHotelRatesByid($editHotelId,$hotelDateId,$roomId);
			// $roomTypesPriceArr['roomprices_'.$roomId] = $hotel_rates_detail;
		// }
		
		$arrMasterRooms=$objhotel->getMasterRoomNames();
		$masterRooms = array();
		foreach($arrMasterRooms as $mrooms)
		{
			$masterRooms[$mrooms['id']] = $mrooms['room_name'];
		}
			?>
				<div class="col-md-12 show_data" style="padding:0;">
						<form id="formData1">
			<input type="hidden" name="hotelId" id="hotelId" value='<?php echo $editHotelId; ?>'>
			<input type="hidden" name="hotelDateId" id="hotelDateId" value='<?php echo $hotelDateIdStr; ?>'>
			<input type="hidden" name="masterRoomArr" id="masterRoomArr" value='<?php echo serialize($arrMasterRooms); ?>'>
			<input type="hidden" name="arrRoomType" id="arrRoomType" value='<?php echo serialize($arrRoomType); ?>'>
			<input type="hidden" name="roomTypesPriceArr" id="roomTypesPriceArr" value='<?php echo serialize($roomTypesPriceArr); ?>'>
			<input type="hidden" name="searchDataStr" id="searchDataStr" value='<?php echo $searchData; ?>'>
			<input type="hidden" name="userSelectRoomTypes" id="userSelectRoomTypes" value=''>
			<input type="hidden" name="userSelectMealTypes" id="userSelectMealTypes" value=''>
		  </form>		
		  <div class="">
								<h3>Add Margin(%)</h3>
								<div class="hotelDetail">
									<table class="table table-bordered" cellspacing="0">
										<tr>
											<td>Entery your percentage</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;">
												<input type="number" id="priceMargin1" value="<?php echo $arr_query_tour_card_det['margin_percent']; ?>" onkeyup="calculate_priceWith_margin1(this.value)" maxlength="2" />
											</td>
											
										</tr>
									</table>
								</div>
								</div>
								<h3>Costing </h3>
								<div class="table-responsive">	
								<table class="table table-bordered" cellspacing="0" width="100%">
									<tr>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Room</th>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Adult</th>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Child(ren)</th>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Child(ren) Age</th>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Room Type</th>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Meal Plan</th>
										<th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Price</th></tr>
									<?php
										//print_r($paramArr);
										//echo count($adults);
										for($i=0; $i<count($adults); $i++)
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
					$roomTypeStr ='';	
$roomTypesPriceArr = array();					
		foreach($arrRoomType as $roomType)
		{
			
			$roomId = $roomType['id'];
			$room_type = $roomType['room_type'];
			$sel ='';
			if($arr_query_tour_card_room_dt[$i]['room_type_id']==$roomId)
	       {
			$sel .='selected';
           }
				else
			{
		   $sel .='';
			}
			$roomTypeStr .= '<option '.$sel.' value="'.$roomId.'">'.$room_type.'</option>';
			
			$hotel_rates_detail=$objhotel->getHotelRatesByid($editHotelId,$hotelDateId,$roomId);
			$roomTypesPriceArr['roomprices_'.$roomId] = $hotel_rates_detail;
		}
							
							
		$mealStr = '';
		$hotelDateIdStr = '';
		foreach($date_rates_detail as $meal)
		{
			$hotelDateIdStr .= $meal['id'].',';
			$mealTxt = 'CP (Breakfast)';
			if($meal['meal_plan'] == 2)
			{
				$mealTxt = 'MAP (Breakfast+Dinner)';
			}
			if($meal['meal_plan'] == 3)
			{
				$mealTxt = 'AP (Breakfast+Lunch+Dinner)';
			}
			if($meal['meal_plan'] == 4)
			{
				$mealTxt = 'EP (Room Only)';
			}
			if($meal['meal_plan'] == 5)
			{
				$mealTxt = 'CP Package';
			}
			if($meal['meal_plan'] == 6)
			{
				$mealTxt = 'MAP Package';
			}
			if($meal['meal_plan'] == 7)
			{
				$mealTxt = 'AP Package';
			}
			if($meal['meal_plan'] == 8)
			{
				$mealTxt = 'EP Package';
			}
			
			$mP = $meal['meal_plan'];
		
		$sel1 ='';
		if($arr_query_tour_card_room_dt[$i]['meal_plan_id']==$mP)
	       {
			$sel1 .='selected';
           }
				else
			{
		   $sel1 .='';
			}
			
			$mealStr .= '<option '.$sel1.' value="'.$mP.'">'.$mealTxt.'</option>';
		}				
										?>
										<tr>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $i+1; ?></td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-male" aria-hidden="true"></i></span> <?php echo $adultP; ?></td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-child" aria-hidden="true"></i></span> <?php echo $childp; ?></td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;">
												<?php 
													if($childp_age != '')
													{
														echo $childp_age; 
													}
													else
													{
														echo '--';
													}
												?>
											</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;">
												<?php
													if($calculatedprices != '')
													{
														echo $selRoomsArr[$i];
													}
													else
													{
												?>
												<select class="form-control userRoomTypes1" id="class<?php echo $i+1; ?>">
													<?php echo $roomTypeStr; ?>
												</select>
												<?php
													}
												?>
											</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;">
												<?php
													if($calculatedprices != '')
													{
														echo $selMealPlansArr[$i];
													}
													else
													{
												?>
												<select class="form-control mealTypes1" id="class<?php echo $i+1; ?>">
													<?php echo $mealStr; ?>
													
												</select>
												<?php
													}
												?>
												
											</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="roomPrice_<?php echo $i+1; ?>"><?php echo $pArr[$i]; ?></span></td>
										</tr>
										<?php	
										}
									?>
									<tr>
										<td colspan="6" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Sub Total</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice1"><?php echo $subTotal; ?></span></td>
									</tr>
									<tr>
										<td colspan="6" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="serviceTax1"><?php echo $serviceTax; ?></span></td>
									</tr>
									<tr style="font-size: 18px;font-weight: 600;">
										<td colspan="6" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Grand Total</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal1"><?php echo number_format(floor($grandTot)); ?></span></td>
									</tr>
							</table>
							</div>
							<div style="clear:both"></div>
							
							
				</div>
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
		
			<?php 
				if($type != 'pdf')
				{
			?>
			<div class="">
				<div id="status1"></div>
				<div id="searchType" style="font-size:20px;padding-bottom: 5px;"><?php //echo $itiTitle;?></div>
					
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
			
			<div class="box-footer text-right">
				<!--<a href="<?php echo $downloadPdfUrl; ?>" class="btn btn-info" id="download">Download PDF</a>-->
				<input type="hidden" id="calculated_prices1" value="" />
				<input type="hidden" id="selected_hotels" value="" />
				<input type="hidden" id="selected_rooms" value="" />
				<input type="hidden" id="selected_mealPlans" value="" />
				<input type="hidden" id="selectedVehicle" value="" />
				<!--<button type="button" class="btn btn-info" id="download" onclick="downlaod_pdf('<?php echo $_SERVER['QUERY_STRING'].'&itiTitle='.base64_encode($itiTitle); ?>', 'downlaod')">Download PDF</button>&nbsp;&nbsp;&nbsp;
				<a class="btn btn-primary pull-right" href="#sendToCl" data-toggle="modal"><i class="fa fa-envelope-o"></i> Mail to Client</a>-->
				
			</div>
			
			
		</div>
		</div>
	
	  </div>
	</section>
</div><!-- /.row --><!-- /.row -->

    
      <div class="modal-footer">
	  <button type="button" class="btn btn-primary" id="tc_submit1">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
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
			var res = del_id.substring(6);
			var bkg_by=document.getElementById("bkg_by").value;
			var prnsl_client_id=document.getElementById("prnsl_client_id").value;
			$("#name_qry").val("lidtc0"+res);
			$("#query_no").val(del_id);
			
			$.ajax({
            type: 'POST',
            data: {per_id:del_id,cli_id:prnsl_client_id},
            url:"_ajax_search_data1.php?action=lead_pax_name",
            success: function(html)
            {
				
				// $("input[type=text], textarea, select").val("");
				// $("#name_qry").val("lidtc0"+res);
				// $("#country").select2("val", "");
				// $("#state").select2("val", "");
				// $("#city").select2("val", "");
				// $(".package_new").hide();
				// $("#package_data1").hide();
				// $("#query_person_name").html(html);
				// $("#bkg_by").val(bkg_by);
				//alert(html);
                //alert(result);
               //$("#hotel_state").html(result);
            }
        });
			
			//alert(qn1);
			//$("#name_qry").val(qn1);
			
			//$("#modalHead").html('Query Detail: <strong>'+qn+'</strong>');
			//$("#mdetail1").html($("#detal_"+qn1).html());
			
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
		 $(".hotelField").show();
		$(".packageField").hide();
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
			$(".packageField").hide();
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
					
					},
					success:function(html){
						//alert(html);
						var htmlArr = html.split('$abc#$');
						//alert(htmArr);
						
						$("#searchData").html(htmlArr[0]);
						$("#searchpack").html(htmlArr[0]);
						$("#ratingFilter").html(htmlArr[1]);
						$("#nameSearch").html(htmlArr[2]);
						$(".show_data").css({"display": "none"});
						$("#me1").css({"display": "none"});
						if($("#queryType").val()=="Package")
						{
							
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
				$(".show_data").hide();
				$("#searchData1").hide();
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
				selected_mealTypes1();
				selected_roomTypes1();
				calculate_price1();
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
		
		
		</script>
<script>
selected_mealTypes1();
	selected_roomTypes1();
	calculate_price1();
$(".userRoomTypes1").change(function(){
		selected_roomTypes1();
		calculate_price1();
	});
	
	$(".mealTypes1").change(function(){
		selected_mealTypes1();
		calculate_price1();
	});
function selected_roomTypes1()
{
	var userRooms = '';
	var i=0;
	$(".userRoomTypes1").each(function(){
		//alert($(this).val());
		i++;
		var val = $(this).val();
		userRooms += val+',';
	});
	$("#userSelectRoomTypes").val(userRooms);
	$("#userSelectRoomTypes1").val(userRooms);
	$("#userSelectRoomTypes_hotel").val(userRooms);
}

function selected_mealTypes1()
{
	var userMeals = '';
	var i=0;
	$(".mealTypes1").each(function(){
		//alert($(this).val());
		i++;
		var val = $(this).val();
		userMeals += val+',';
	});
	//alert(userMeals);
	$("#userSelectMealTypes").val(userMeals);
	$("#userSelectMealTypes1").val(userMeals);
	$("#userSelectMealTypes_hotel").val(userMeals);
}	

function calculate_price1()
{
	var priceMargin = $("#priceMargin1").val();
	
	$.ajax({
		type:"POST",
		url:"_ajax_search_data.php?action=getPrice",
		data:$("#formData1").serialize(),
		beforeSend:function(){
			
		},
		success:function(html){
			//alert(html);
			//var calP = html.splice(-1,1);
			var response = html;
			
			//alert(response);
			var priceArr = response.split(',"description"');
			var calPrice = priceArr[0]+'}';
			//alert(calPrice);
			$("#calculated_prices1").val(calPrice);
			$("#calculated_hotel_prices").val(calPrice);
			
			var obj = JSON.parse(html);
			//console.log(obj.description);
			var desc = obj.description;
			calculate_priceWith_margin1(priceMargin);
			
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

function calculate_priceWith_margin1(margin_val1)
{
	
	//alert(margin_val);
	var roomPrices = $("#calculated_prices1").val();
	//alert(roomPrices);
	//alert(margin_val);
	$("#pricemargin_hotel").val(margin_val1);
	var obj = JSON.parse(roomPrices);
	//console.log(obj);
	
	var totalRooms = $(".userRoomTypes1").length;
	//alert(totalRooms);
	var totPrice = 0;
	var roomprice = 0;

	for(var i=1; i<=totalRooms; i++)
	{
		//alert(obj[i]);
		roomprice = obj[i];
		roompriceWithmargin = roomprice + (roomprice*parseInt(margin_val1)/100);
		$("#roomPrice_"+i).html(roompriceWithmargin);
		totPrice += parseInt(roompriceWithmargin);
	}
	//alert(totPrice);
	$("#totalHotelPrice1").html(totPrice);
	
	var serviceTax = (totPrice*5)/100;
	$("#serviceTax1").html(serviceTax);
	var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
	$("#grandTotal1").html(grandTotal);
	$("#grand_total_hotel").val(grandTotal);
	//$("#calculated_prices").val(html);
	
	var optVal = '';
	$(".userRoomTypes1").each(function(){
		optVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	//alert(optVal);
	$("#selected_rooms1").val(optVal);
	$("#hotel_selected_rooms").val(optVal);
	
	var MealoptVal = '';
	$(".mealTypes1").each(function(){
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
function getHotelPrice(){
			//alert('hello');
			selected_roomTypes();
		    calculate_price();
		}
		function getHotelMeal(){
			selected_mealTypes();
		    calculate_price();
		}

  $(function () {
	  
	//alert(userRooms);
	
	
	$(".userRoomTypes").change(function(){
		selected_roomTypes();
		calculate_price();
	});
	
	$(".mealTypes").change(function(){
		selected_mealTypes();
		calculate_price();
	});
	
	
	

	
	
  });
  
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
	$("#userSelectRoomTypes5").val(userRooms);
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
	$("#userSelectMealTypes5").val(userMeals);
}	

function calculate_price()
{
	var priceMargin = $("#priceMargin").val()
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
			$("#calculated_prices").val(calPrice);
			$("#calculated_hotel_prices").val(calPrice);
			//$("#calculated_hotel_prices").val(calPrice);
			
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
	
	var obj = JSON.parse(roomPrices);
	//console.log(obj);
	
	var totalRooms = $(".userRoomTypes").length;
	var totPrice = 0;
	var roomprice = 0;
//alert(totalRooms);
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
	var hotel_markup = $("#hotel_markup").val();
	var hotel_markup1 = (grandTotal*hotel_markup)/100;
	//alert(hotel_markup1);
	var grandTotal_p = grandTotal + parseInt(hotel_markup1);
	$("#grandTotal").html(grandTotal_p);
	//$("#calculated_prices").val(html);
	
	var optVal = '';
	$(".userRoomTypes").each(function(){
		optVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	//alert(optVal);
	$("#selected_rooms").val(optVal);
	
	var MealoptVal = '';
	$(".mealTypes").each(function(){
		MealoptVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	$("#selected_mealPlans").val(MealoptVal);
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

/* function send_email(param, action)
{
	var checkDownlaod = downlaod_pdf(param, action);
	alert(checkDownlaod);
} */

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

</script>

	<!--end package ajax-->
		<script src="asset/bootstrap-datepicker.js"></script>
<?php include('footer.php'); ?>