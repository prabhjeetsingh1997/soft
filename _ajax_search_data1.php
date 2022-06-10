<?php
	include('config/init.php');
	extract($_POST);
	
	$ut = 'e';
	$user_type=$_SESSION['user_type'];
	if($user_type == 'admin')
	{
		$ut = 'a';
	}
	if($_REQUEST['action'] == 'tour_card')
	{
	   $tour_card_details=$objAdmin->save_tc_details($_POST);
	   if($tour_card_details)
		{
		echo 1;
		}
		else
		{
		echo 0;
		}
	}
	if($_REQUEST['action'] == 'tour_card_edit')
	{
	   $tour_card_details1=$objAdmin->save_tc_edit_details($_POST);
	   if($tour_card_details1)
		{
		echo 1;
		}
		else
		{
		echo 0;
		}
	}

	if ($_REQUEST['action'] == 'other_tour_card') {
		$result = $objAdmin->other_tour_card_details($_POST);
		if ($result) {
			echo 1;
		}else{
			echo 0;
		}
	}
	if ($_REQUEST['action'] == 'other_edit_tour_card') {
		$result = $objAdmin->other_edit_tour_card_details($_POST);
		if ($result) {
			echo 1;
		}else{
			echo 0;
		}
	}
	
	if($_REQUEST['action'] == 'lead_pax_name')
	{
		$per_id=$_REQUEST['per_id'];
		$cli_id=$_REQUEST['cli_id'];
		$person_name1=$objAdmin->get_person_name($per_id);
		$person_name2=$objAdmin->get_person_other_name($per_id);
		$person_cli_id=$objAdmin->get_person_client_name($cli_id);
		//print_r($person_name1);
		//print_r($person_name2);exit;
		$per3=$person_cli_id['organization'];
		$person_name_show = $person_name1['person_name'];
		$per_name = "<option>Select</option>";
	   $per_name1 = $per_name."<option value='$person_name_show'>".$person_name_show."</option>";
		foreach($person_name2 as $person_name3)
		{
			$per2=$person_name3['first_name'].' '.$person_name3['middle_name'].' '.$person_name3['last_name'];
			if($per2!="")
			{
			$per_name1 .= "<option value='$per2'>".$per2."</option>";
			}
		}
		if($per3!="")
		{
		    $per_name1 .= "<option value='$per3'>".$per3."</option>";
		}
		echo $per_name1;
	}
	if($_REQUEST['action'] == 'getHotelId')
	{
		// echo "<pre>!!!!!!!";
		// print_r($_POST);
		// exit;
		$data_id = explode('&',$_POST['data']);
		//echo "<pre>";
		//print_r($data_id);
		//exit;
		$hotel_id = $data_id['0'];
		$search_data = base64_decode($data_id['1']);
		//echo '<pre>@@@@@';
		//print_r($search_data);exit;
		
		//Array ( [searchrooms] => 2 [queryType] => Hotel [destination] => New Delhi [startdate] => 07/28/2016 [enddate] => 07/29/2016 [stayDuration] => 1 [adults] => Array ( [0] => 1 [1] => 2 ) [child] => Array ( [0] => 1 [1] => 2 ) [child_age] => Array ( [0] => 5 [1] => 5,9 ) [] => )

		$searchDataArr = explode('S$S',$search_data);
		
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
		$editHotelId=$hotel_id;
		$arrRoomType=$objhotel->getHotelRoomTypeByid($editHotelId);
		//print_r($arrRoomType);
		$priceMargin = base64_decode($_GET['pMargin']);
		$calculatedprices=$_GET['prices'];
		if($calculatedprices != '')
		{
			$calculatedprices = base64_decode($calculatedprices);
			$priceArr = json_decode($calculatedprices);
			//print_r($priceArr);
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
		$roomTypeStr = '';
		$roomTypesPriceArr = array();
		$i=0;
		foreach($arrRoomType as $roomType)
		{
			$i++;
			$roomId = $roomType['id'];
			$room_type = $roomType['room_type'];
			$roomTypeStr .= '<option value="'.$roomId.'">'.$room_type.'</option>';
			
			$hotel_rates_detail=$objhotel->getHotelRatesByid($editHotelId,$hotelDateId,$roomId);
			$roomTypesPriceArr['roomprices_'.$roomId] = $hotel_rates_detail;
		}
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
		//print_r($date_rates_detail);
		
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
				
			$mealStr .= '<option value="'.$mP.'">'.$mealTxt.'</option>';
		}
		
		//echo $mealStr;
		
		$hotelDateIdStr = rtrim($hotelDateIdStr,',');
		
		$hotelDateId = $date_rates_detail[0]['id'];
		
		$arrRoomType=$objhotel->getHotelRoomTypeByid($editHotelId);
		//print_r($arrRoomType);
		
		$roomTypeStr = '';
		$roomTypesPriceArr = array();
		$i=0;
		foreach($arrRoomType as $roomType)
		{
			$i++;
			$roomId = $roomType['id'];
			$room_type = $roomType['room_type'];
			$roomTypeStr .= '<option value="'.$roomId.'">'.$room_type.'</option>';
			
			$hotel_rates_detail=$objhotel->getHotelRatesByid($editHotelId,$hotelDateId,$roomId);
			$roomTypesPriceArr['roomprices_'.$roomId] = $hotel_rates_detail;
		}
		$arrMasterRooms=$objhotel->getMasterRoomNames();
		$masterRooms = array();
		foreach($arrMasterRooms as $mrooms)
		{
			$masterRooms[$mrooms['id']] = $mrooms['room_name'];
		}
		?>
		<?php 
				$rupeeSymbol = '<img src="'.APP_URL.'images/rupee.png" alt="" style="margin-top:3px;" />';
				if($type != 'pdf')
				{
					$border = 'border: 1px solid #DDD;';
					$rupeeSymbol = '';
			?>
         
		 <?php
				}
				else
				{
					
				}
		 ?> 
          <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Query List</li>
          </ol>-->
		  <?php 
									if($type != 'pdf')
									{
								?>
								<div class="">
								<h3>Add Margin(%)</h3>
								<div class="hotelDetail">
									<table class="table table-bordered" cellspacing="0">
										<tr>
											<td>Entery your percentage</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;">
												<input type="number" id="priceMargin" value="0" onkeyup="calculate_priceWith_margin(this.value)" maxlength="2" />
											</td>
											
										</tr>
									</table>
								</div>
								</div>
								<?php
									}
								?>
		  <form id="formData">
			<input type="hidden" name="hotelId" id="hotelId" value='<?php echo $editHotelId; ?>'>
			<input type="hidden" name="hotelDateId" id="hotelDateId" value='<?php echo $hotelDateIdStr; ?>'>
			<input type="hidden" name="masterRoomArr" id="masterRoomArr" value='<?php echo serialize($arrMasterRooms); ?>'>
			<input type="hidden" name="arrRoomType" id="arrRoomType" value='<?php echo serialize($arrRoomType); ?>'>
			<input type="hidden" name="roomTypesPriceArr" id="roomTypesPriceArr" value='<?php echo serialize($roomTypesPriceArr); ?>'>
			<input type="hidden" name="searchDataStr" id="searchDataStr" value='<?php echo base64_encode($search_data); ?>'>
			<input type="hidden" name="userSelectRoomTypes" id="userSelectRoomTypes" value=''>
			<input type="hidden" name="userSelectMealTypes" id="userSelectMealTypes" value=''>
		  </form>
		  <input type="hidden" id="calculated_prices" value="" />
				<input type="hidden" id="selected_rooms" value="" />
				<input type="hidden" id="selected_mealPlans" value="" />
		<h3> Costing </h3>
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
												<select class="form-control userRoomTypes" onchange="getHotelPrice();" id="class<?php echo $i+1; ?>">
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
												<select onchange="getHotelMeal();" class="form-control mealTypes" id="class<?php echo $i+1; ?>">
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
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice"><?php echo $subTotal; ?></span></td>
									</tr>
									<tr>
										<td colspan="6" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="serviceTax"><?php echo $serviceTax; ?></span></td>
									</tr>
									<tr style="font-size: 18px;font-weight: 600;">
										<td colspan="6" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Grand Total</td>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal"><?php echo number_format(floor($grandTot)); ?></span></td>
									</tr>
							</table>
							</div>
		<?php
	}
		
	
				
		
	if($_REQUEST['action'] == 'searchData')
	{
		/* print_r($_POST);
		die; */
		//Array ( [searchrooms] => 2 [queryType] => Hotel [destination] => New Delhi [startdate] => 07/28/2016 [enddate] => 07/29/2016 [stayDuration] => 1 [adults] => Array ( [0] => 1 [1] => 2 ) [child] => Array ( [0] => 1 [1] => 2 ) [child_age] => Array ( [0] => 5 [1] => 5,9 ) )
		
		//Array ( [searchrooms] => 3 [queryType] => Package [country] => Array ( [0] => 119 ) [state] => Array ( [0] => 187 ) [city] => Array ( [0] => 1993 ) [destination] => [startdate] => 24/03/2017 [enddate] => 27/03/2017 [stayDuration] => 3 [adults] => Array ( [0] => 2 [1] => 2 [2] => 1 ) [child] => Array ( [0] => 2 [1] => 2 [2] => 0 ) [child_age] => Array ( [0] => 5,9 [1] => 9,11 [2] => ) ) 
		//die;
		//echo print_r($_POST);
		$dataStr = '';
		foreach($_POST as $key=>$val)
		{
			if(is_array($val))
			{
				$val = implode($val,'#');
				//$val = rtrim($val, '#');
			}
			$dataStr .= $key.'='.$val.'S$S';
		}
		//echo '<br/>';
		$dataStr = rtrim($dataStr,',');
		//$_SESSION['searchCriteArea'] = $_POST;
		
		$extraBedText='';
		$roomcatId='';
		$extraChWBed='';
		$childWBedId='';
		$extraChWOBed='';
		$childWoBedId='';
		$numRoom='';
		$stDuration='';
		$star_ratingArr = '<option value="all">All</option>';
		$hotelNames = '<option value="">Select</option>';
		
		
		if(!empty($numOfRoom)){
			$numRoom=$numOfRoom;
		}else{
			$numRoom=1;
		}
		
		if(!empty($stayDuration)){
			$stDuration=$stayDuration;
		}else{
			$stDuration=1;
		}
		if($queryType == 'Other'){
			$arrHotelSugg=$objhotel->get_All_hotel_name($domain);
		   $packageNames1 = '<option value="">Select</option>';
		   foreach($arrHotelSugg as $arrHotelSugg1){
		    $packageNames1 .= '<option value="'.$arrHotelSugg1['hotel_id'].'">'.$arrHotelSugg1['hotel_name'].'</option>';
		   }
			echo  $packageNames1;
		}
		if($queryType == 'Hotel'){
			
			$hotelSearchedData=$objhotel->search_hotel($_POST);
			//echo $countData=count($searchData);
			
			$searchData = array();
			$hotelIdArr = array();
			foreach($hotelSearchedData as $dataArr)
			{
				if(!in_array($dataArr['hotel_id'], $hotelIdArr))
				{
					$hotelIdArr[] = $dataArr['hotel_id'];
					$searchData[] = $dataArr;
				}
				
				//$hoelDataArr [$dataArr[]] = 
			}
			//print_r($dataArr['hotel_id']);
			$countData=count($searchData);
			
			$arrRoomType=$objhotel->getRoomTypeById($roomCategory);
			$roomCatName=$arrRoomType[0]['room_name'];
			$arrRoomCategory=array();
			$arrRoom=$objhotel->getAllHotelRoom();
			foreach($arrRoom as $val)
			{
				$arrRoomCategory[$val['id']]=$val['room_name'];
			}
			
			$roomNameId=$roomCategory;
			
			if(!empty($numOfExtrBed)){
				$extraBedText = $extraAdult;
				$roomcatId = array_search($extraBedText, $arrRoomCategory);
			}
			if(!empty($childWithBed)){
				$extraChWBed=$chWBed;
				$childWBedId = array_search($extraChWBed, $arrRoomCategory);
			}
			if(!empty($childWOutBed)){
				$extraChWOBed=$chWoBed;
				$childWoBedId = array_search($extraChWOBed, $arrRoomCategory);
			}
			
			if($countData>0){
				
				$ragingArr = Array();
				foreach($searchData as $key=>$val){
					$arrextraAdultPrice='';
					$extAdltPrice='';
					$arrextchilWitouBedPrice='';
					$chWoBedPrice='';
					$arrextchilWitBedPrice='';
					$chWithBedPrice='';
					$hotelId=$val['hotel_id'];
					$hotel_name=$val['hotel_name'];
					$star_rating=$val['star_rating'];
				
					if(!in_array($star_rating,$ragingArr))
					{
						$ragingArr[] = $star_rating;
						$star_ratingArr = $star_ratingArr.'<option value="'.$star_rating.'">'.$star_rating.' Star</option>';
					}
					$sel='';
					if($hotelId==$hotel_name1)
					{
						$sel="selected";
					}
					else
					{
						$sel='';
					}
					$hotelNames = $hotelNames .'<option '.$sel.' value="'.$hotelId.'&'.base64_encode($dataStr).'">'.$hotel_name.'</option>';
					
					
					$roomTypeId=$val['id'];
					//Hotel Price calculation of extra bed 
					if(!empty($roomcatId)){
						$arrextraAdultPrice=$objhotel->getPriceByroomCategory($hotelId,$roomcatId,$roomTypeId);
						$extAdltPrice=$arrextraAdultPrice[0]['price']*$numOfExtrBed;
					}
					//Hotel Price calculation of child without bed 
					if(!empty($childWoBedId)){
						$arrextchilWitouBedPrice=$objhotel->getPriceByroomCategory($hotelId,$childWoBedId,$roomTypeId);
						$chWoBedPrice=$arrextchilWitouBedPrice[0]['price']*$childWOutBed;
					}
					//Hotel Price calculation of child with bed 
					if(!empty($childWBedId)){
						$arrextchilWitBedPrice=$objhotel->getPriceByroomCategory($hotelId,$childWBedId,$roomTypeId);
						$chWithBedPrice=$arrextchilWitBedPrice[0]['price']*$childWithBed;
					}
					$arractualPrice=$objhotel->getPriceByroomCategory($hotelId,$roomNameId,$roomTypeId);
					$actualPrice=$arractualPrice[0]['price'];
					//Hotel actual price calculation
					$actPrice=(($actualPrice*$numRoom)*$stDuration)+$extAdltPrice+$chWoBedPrice+$chWithBedPrice;
					
					$hotel_address_details = $objhotel->getHotelAddressById($hotelId,'hotel_permanent_addr');
					//print_r($hotel_address_details);
					$city = '';
					$country = '';
					$state = '';
					$location = '';
					foreach($hotel_address_details as $hd)
					{
						$arrState=$objAdmin->getStateNameById($hd['state']);
						$arrCity=$objAdmin->getCityById($hd['city']);
						$arrCountry=$objAdmin->getCountryNameById($hd['country']);
						$city = $arrCity[0]['city'];
						$country = $arrCountry[0]['country_name'];
						$state = $arrState[0]['state_name'];
						$location = $hd['address2'];
					}
					
					$hPhotos = json_decode($val['hotel_photos']);
					$countHPhotos = count($hPhotos);
					//print_r($hPhotos);
					//$cityArr = $objhotel->getCitiesById($val['city']);
?>
		
<?php
				}
				?>
				
				
				<?php
			}else{
				?>
				<div style="border: 1px solid #DDD;padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
					<div class="col-md-9">
					<p>Note: Sorry, not exist in our database.</p>
					</div>
				</div>
				<?php
				
			}
			
			echo '$abc#$'.$star_ratingArr.'$abc#$'.$hotelNames;
			
		}
		else if($queryType == 'Package')
		{
			//print_r($_POST);
			//echo 'asdfada::::'.$city;
			$packageNames = '<option value="">Select</option>';
			$searchData=$objhotel->search_package($_POST);
			 //print_r($searchData);exit;
			//echo count($searchData).':::::'.$searchData; */
			//die;
			//Array ( [searchrooms] => 1 [queryType] => Package [country] => Array ( [0] => 119 ) [state] => Array ( [0] => 187 ) [city] => Array ( [0] => 1998 ) [destination] => [startdate] => 24/08/2016 [enddate] => 25/08/2016 [stayDuration] => 1 [adults] => Array ( [0] => 1 ) [child] => Array ( [0] => 0 ) [child_age] => Array ( [0] => ) )
			
			if(count($searchData) > 0)
			{
				foreach($searchData as $pakageData)	
				{
					$sel='';
					if($package_id==$pakageData['id'])
					{
						$sel .="selected";
					}
					else
					{
						$sel .='';
					}
					//print_r($pakageData);
					$itenryId = $pakageData['id'];
					$packageNames = $packageNames .'<option '.$sel.' value="'.$pakageData['id'].'&'.base64_encode($dataStr).'">'.$pakageData['title'].'</option>';
					
					
					
		?>
		
			<!--<div id="package_<?php echo $itenryId; ?>" class="hotelBox" style="border: 1px solid #DDD;padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
				<div class="col-md-9">
					<h4><b style="color:#3C8DBC;"><?php echo $pakageData['title'];?></b></h4>
					<p>City: <?php 
						//echo $cityStr;
						$citiesArr = $objhotel->getCitiesById($pakageData['city']);
						$cityName = '';
						foreach($citiesArr as $cityNames)
						{
							$cityName .= $cityNames['city'].', ';
						}
						echo rtrim($cityName,', ');
					?></p>
					<p><?php 
						//echo $cityStr
						echo $pakageData['duration_detail'];
					?></p>
					<?php 
					if(!empty($numOfRoom)){
						?>
					<p>No of Room: <?php echo $numOfRoom;?></p>
					<?php  
					}if(!empty($stayDuration)){
					?>
					<p>Stay Duration: <?php echo ($pakageData['duration']-1).' Nights '.$pakageData['duration'].' Days';?></p>
					<?php
					}
					?>
					<a href="view_package_detail.php?action=view&id=<?php echo $itenryId;?>&searchData=<?php echo base64_encode($dataStr);?>&qn=<?php echo $queryNumber; ?>&ut=<?php echo $ut; ?>" target="_blank" class="btn btn-success">view Detail</a>
				</div>
			</div>-->
		<?php
				}
			}
			else{
			?>
				<div style="border: 1px solid #DDD;padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
					<div class="col-md-9">
					<p>Note: Sorry, not exist in our database.</p>
					</div>
				</div>
			<?php
				
			}
			echo $packageNames;
		}
	}
	
	if($_REQUEST['action'] == 'getPrice')
	{
		$hotelId = $hotelId;
		$searchDataStr = base64_decode($searchDataStr);
		
		//print_r($_POST);
		
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
		
		
		$sDate = explode('/',$paramArr['startdate']);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$paramArr['enddate']);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		
		$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
		
		//die;
		
		
		$hotelDateId = $hotelDateId;
		$arrMasterRoom = unserialize($masterRoomArr);
		$roomTypeArr = unserialize($arrRoomType);
		$arrRoomTypesPrice = unserialize($roomTypesPriceArr);
		$userSelectRoomTypesArr = explode(',',rtrim($userSelectRoomTypes,','));
		$userSelectMealTypesArr = explode(',',rtrim($userSelectMealTypes,','));
		
		$getRateDescription = $objhotel->getDateRatesDesc($hotelId, $startdate, $enddate, rtrim($userSelectMealTypes,','));
		
		$descArr = array();
		foreach($getRateDescription as $mealDesc)
		{
			$descArr[$mealDesc['meal_plan']] = $mealDesc['description'];
			$descArrString = $mealDesc['description'];
		}
		//print_r($descArr);
		//$roomPeopleArr;
		//print_r($descArr);
		//die;
		/*
		echo '<br/><br/><br/>';
		print_r($roomTypeArr);
		echo '<br/><br/><br/>';
		print_r($arrRoomTypesPrice);
		echo '<br/><br/><br/>';
		print_r($roomPeopleArr);
		echo '<br/><br/><br/>';
		print_r($userSelectRoomTypesArr); 
		die; */
		//print_r($date_rates_detail);
		$dateMealPlanArr = array();
		$dateIdStr = '';
		foreach($date_rates_detail as $dataData)
		{
			$dateMealPlanArr[$dataData['id']] = $dataData['meal_plan'];
			$dateIdStr .= $dataData['id'].',';
		}
		$dateIdStr = rtrim($dateIdStr,',');
		$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId,$dateIdStr);
		//print_r($dateMealPlanArr);
		//print_r($hotel_rates_detail);
		
		$roomPriceArr = array();	
		foreach($hotel_rates_detail as $rooms)
		{
			$dateId = $rooms['date_id'];
			$mealPlan = $dateMealPlanArr[$dateId];  //meal plan
			$rtId = $rooms['room_type_id']; // Room Type Id
			$rnId = $rooms['room_name_id']; // Room Name Id
			$roomPriceArr[$rtId][$mealPlan][$rnId] = $rooms['price'];
		}
		
		//print_r($roomPriceArr);
		/* print_r($roomPriceArr);
		//Array ( [140] => Array ( [1] => 3000 [2] => 3500 [3] => 700 [4] => 500 [6] => 700 [7] => 250 [8] => 350 [9] => 350 ) [141] => Array ( [1] => 3500 [2] => 4000 [3] => 800 [4] => 600 [6] => 800 [7] => 250 [8] => 350 [9] => 350 ) [142] => Array ( [1] => 4000 [2] => 4500 [3] => 900 [4] => 700 [6] => 900 [7] => 250 [8] => 350 [9] => 350 ) )
		
		die; */
		
		
		//Array ( [room_1] => Array ( [adult] => 2 [child] => 2 [child_age] => 5 ) [room_2] => Array ( [adult] => 3 [child] => 1 [child_age] => 12 ) )
		
		//Array ( [searchrooms] => 2 [queryType] => Hotel [destination] => New Delhi [startdate] => 07/28/2016 [enddate] => 07/29/2016 [stayDuration] => 1 [adults] => Array ( [0] => 1 [1] => 2 ) [child] => Array ( [0] => 1 [1] => 2 ) [child_age] => Array ( [0] => 5 [1] => 5,9 ) [] => )
		
		$roomPrices = array();
		$roomPriceByType = array();
		//echo 'sadfasd';
		$countRooms=count($paramArr['adults']);
		for($j=0; $j<$countRooms; $j++)
		{
			//Array ( [0] => 140 [1] => 140 )
			$userSelectedMealPlan = $userSelectMealTypesArr[$j];
			$userSelectedTypes = $userSelectRoomTypesArr[$j];
			
			$roomPriceByType = $roomPriceArr[$userSelectedTypes][$userSelectedMealPlan];
			//print_r($roomPriceByType);
			
			$adultVal = $paramArr['adults'][$j];
			$childVal = $paramArr['child'][$j];
			if(is_array($paramArr['child_age']))
			{
				$child_ageVal = $paramArr['child_age'][$j];
			}
			else
			{
				$child_ageVal = $paramArr['child_age'];
			}
			
			
			$RoomPriceCalculation = 0;
			$chilePriceCalculation = 0;
			
			if($adultVal == 1)
			{
				$RoomPriceCalculation += $roomPriceByType[1];
			}
			else if($adultVal == 2)
			{
				$RoomPriceCalculation += $roomPriceByType[2];
			}
			else
			{
				$restAdult = $adultVal-2;
				$otherPrice = $roomPriceByType[2] + ($restAdult*$roomPriceByType[3]);
				$RoomPriceCalculation += $otherPrice;
			}
			
			if (strpos($child_ageVal, ',') !== false)
			{
				$childAgeArr = explode(',', $child_ageVal);
				//print_r($childAgeArr);
				foreach($childAgeArr as $age)
				{
					if($age>5)
					{
						if($age>5 && $age<=8)
						{
							
							$chilePriceCalculation += $roomPriceByType[4];
						}
						else{
							$chilePriceCalculation += $roomPriceByType[6];
						}
					}
				}
			}
			else
			{
				if($child_ageVal>5)
				{
					if($child_ageVal>5 && $child_ageVal<=8)
					{
						
						$chilePriceCalculation += $roomPriceByType[4];
					}
					else{
						$chilePriceCalculation += $roomPriceByType[6];
					}
				}
			}	
			//echo $chilePriceCalculation;
			//echo '<br/><br/>';
			$roomPrices[$j+1] = ($RoomPriceCalculation+$chilePriceCalculation)*$paramArr['stayDuration'];
			//$roomPrices[$j+1] = $RoomPriceCalculation;
		}
		$roomPrices['description'] = $descArrString;
		//stayDuration
		//print_r($roomPrices);
		echo json_encode($roomPrices);
	}
	if($_REQUEST['action'] == 'getpakageHotelPrice')
	{
		error_reporting(E_All);
		
		$selctedDate = $_GET['selDate'];	
		$hotelId = $userSelectHotel;
		$searchDataStr = base64_decode($searchDataStr);
		
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
		//die;
		
		//Array ( [searchrooms] => 1 [queryType] => Package [country] => 119 [state] => 187 [city] => 1998 [destination] => [startdate] => 24/08/2016 [enddate] => 25/08/2016 [stayDuration] => 1 [adults] => 1 [child] => 0 [child_age] => [] => )
		
		$sDate = explode('/',$paramArr['startdate']);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$paramArr['enddate']);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		
		//$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
		$date_rates_detail=$objhotel->getDateRatesByDatenid_calculate($hotelId, $startdate, $enddate, $selctedDate);
		$hotelDateId = $date_rates_detail[0]['id'];
		//print_r($date_rates_detail);
		$hotelDateId = $hotelDateId;
		$arrMasterRoom = unserialize($masterRoomArr);
		$roomTypeArr = unserialize($arrRoomType);
		$arrRoomTypesPrice = unserialize($roomTypesPriceArr);
		$userSelectRoomTypesArr = explode(',',rtrim($userSelectRoomTypes,','));
		//$roomPeopleArr;
		//print_r($roomPeopleArr);
		//die;
		
		$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId,$hotelDateId);
		//print_r($hotel_rates_detail);
		
		$roomPriceArr = array();	
		foreach($hotel_rates_detail as $rooms)
		{
			$rtId = $rooms['room_type_id']; // Room Type Id
			$rnId = $rooms['room_name_id']; // Room Name Id
			$roomPriceArr[$rtId][$rnId] = $rooms['price'];
		}
		
		$roomPrices = array();
		$roomPriceByType = array();
		//echo $itineryDuration;
		//$countRooms=count($paramArr['adults']);
		$countRooms=$itineryDuration; //count($paramArr['adults']);
		for($j=0; $j<$countRooms; $j++)
		{
			//Array ( [0] => 140 [1] => 140 )
			$userSelectedTypes = $userSelectRoomTypesArr[$j];
			
			$roomPriceByType = $roomPriceArr[$userSelectedTypes];
			
			$adultVal = $paramArr['adults'][$j];
			$childVal = $paramArr['child'][$j];
			if(is_array($paramArr['child_age']))
			{
				$child_ageVal = $paramArr['child_age'][$j];
			}
			else
			{
				$child_ageVal = $paramArr['child_age'];
			}
			//Array ( [1] => 3000 [2] => 3500 [3] => 700 [4] => 500 [6] => 700 [7] => 250 [8] => 350 [9] => 350 ) 
			
			$RoomPriceCalculation = 0;
			$chilePriceCalculation = 0;
			
			if($adultVal == 1)
			{
				$RoomPriceCalculation += $roomPriceByType[1];
			}
			else if($adultVal == 2)
			{
				$RoomPriceCalculation += $roomPriceByType[2];
			}
			else
			{
				$restAdult = $adultVal-2;
				$otherPrice = $roomPriceByType[2] + ($restAdult*$roomPriceByType[3]);
				$RoomPriceCalculation += $otherPrice;
			}
			
			if (strpos($child_ageVal, ',') !== false)
			{
				$childAgeArr = explode(',', $child_ageVal);
				//print_r($childAgeArr);
				foreach($childAgeArr as $age)
				{
					if($age>5)
					{
						if($age>5 && $age<=8)
						{
							/* if($childVal == 1)
							{
								
							} */
							$chilePriceCalculation += $roomPriceByType[4];
						}
						else{
							$chilePriceCalculation += $roomPriceByType[6];
						}
					}
				}
			}
			else
			{
				if($child_ageVal>5)
				{
					if($child_ageVal>5 && $child_ageVal<=8)
					{
						/* if($childVal == 1)
						{
							$chilePriceCalculation += $roomPriceByType[4];
						} */
						$chilePriceCalculation += $roomPriceByType[4];
					}
					else{
						$chilePriceCalculation += $roomPriceByType[6];
					}
				}
			}	
			//echo $chilePriceCalculation;
			//echo '<br/><br/>';
			$roomPrices[$j+1] = $RoomPriceCalculation+$chilePriceCalculation;
			//$roomPrices[$j+1] = $RoomPriceCalculation;
		}
		//echo 'asdfads';
		//print_r($roomPrices);
		echo json_encode($roomPrices);
	}
	if($_REQUEST['action'] == 'getpakageHotelPrice2')
	{
		/*print_r($_POST);
		die;
		Array ( [hotelId] => [hotelDateId] => [searchDataStr] => c2VhcmNocm9vbXM9MVMkU3F1ZXJ5TnVtYmVyPVMkU3F1ZXJ5VHlwZT1QYWNrYWdlUyRTY291bnRyeT0xMTlTJFNzdGF0ZT0xODRTJFNkZXN0aW5hdGlvbj1TJFNzdGFydGRhdGU9MzEvMDUvMjAxN1MkU2VuZGRhdGU9MDQvMDYvMjAxN1MkU3N0YXlEdXJhdGlvbj00UyRTYWR1bHRzPTFTJFNjaGlsZD0wUyRTY2hpbGRfYWdlPVMkUw== [userSelectRoomTypes] => 499,340,334,337,0, [userSelectHotel] => 148 [userSelectedMealPlans] => 1,1,2,1,0, [totalBookingRooms] => 1 [itineryDuration] => 5 [queryNumber] => [selectedHotel] => Array ( [0] => 215 [1] => 150 [2] => 148 [3] => 149 [4] => ) [selectedRoom] => Array ( [0] => 499 [1] => 340 [2] => 334 [3] => 337 [4] => 0 ) [selectedMealPlans] => Array ( [0] => 1 [1] => 1 [2] => 2 [3] => 1 [4] => 0 ) [selectedVehcle] => Array ( [0] => 0 ) [no_of_vehicle] => 1 ) */
		
		$searchDataStr = base64_decode($searchDataStr);
			
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
		$sDate = explode('/',$paramArr['startdate']);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$paramArr['enddate']);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		
		$hotelIds = array();
		foreach($selectedHotel as $val)
		{
			if($val != '')
			{
				$hotelIds[] = $val;
			}
			else
			{
				$hotelIds[] = 0;
			}
		}
		$totalRoomWisePrice = array();
		$dayPriceArr = array();
		
		for($h=0; $h<count($hotelIds); $h++)
		{
			//echo $h.'<br/>';
			$hotelId = $hotelIds[$h];
			$roomTypeId = $selectedRoom[$h];
			$userSelectedMealPlan = $selectedMealPlans[$h];
			
			//$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
			$date_rates_detail=$objhotel->calculate_price_dateData($hotelId, $startdate, $enddate);
			$hotelDateId = $date_rates_detail[0]['id'];
			//print_r($date_rates_detail);
			//echo '<br/>'.$hotelMealPlanId = $date_rates_detail[0]['meal_plan'];
			
			$dateMealPlanArr = array();
			$dateIdStr = '';
			foreach($date_rates_detail as $dataData)
			{
				$dateMealPlanArr[$dataData['id']] = $dataData['meal_plan'];
				$dateIdStr .= $dataData['id'].',';
			}
			$dateIdStr = rtrim($dateIdStr,',');
			
			//echo '<br/>::::Date_rates::'.print_r($dateMealPlanArr);
			
			$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId,$dateIdStr);
			//echo 'Room_Rates::'.print_r($hotel_rates_detail);
			//die;
			$roomPriceArr = array();	
			foreach($hotel_rates_detail as $rooms)
			{
				$dateId = $rooms['date_id'];
				$rtId = $rooms['room_type_id']; // Room Type Id
				$rnId = $rooms['room_name_id']; // Room Name Id
				$mealPlan = $dateMealPlanArr[$dateId];
				$roomPriceArr[$rtId][$mealPlan][$rnId] = $rooms['price'];
			}
			//print_r($roomPriceArr);
			$roomPrices = array();
			$roomPriceByType = array();
			
			$countRooms=count($paramArr['adults']);
			//echo '<br>'.$countRooms=$itineryDuration;
			//echo '<br>';
			for($j=0; $j<$countRooms; $j++)
			{
				//Array ( [0] => 140 [1] => 140 )
				$userSelectedTypes = $roomTypeId;
				
				$roomPriceByType = $roomPriceArr[$userSelectedTypes][$userSelectedMealPlan];
				//print_r($roomPriceByType);
				//die;
				$adultVal = $paramArr['adults'][$j];
				$childVal = $paramArr['child'][$j];
				if(is_array($paramArr['child_age']))
				{
					$child_ageVal = $paramArr['child_age'][$j];
				}
				else
				{
					$child_ageVal = $paramArr['child_age'];
				}
				//Array ( [1] => 3000 [2] => 3500 [3] => 700 [4] => 500 [6] => 700 [7] => 250 [8] => 350 [9] => 350 ) 
				
				$RoomPriceCalculation = 0;
				$chilePriceCalculation = 0;
				
				if($adultVal == 1)
				{
					$RoomPriceCalculation += $roomPriceByType[1];
				}
				else if($adultVal == 2)
				{
					$RoomPriceCalculation += $roomPriceByType[2];
				}
				else
				{
					$restAdult = $adultVal-2;
					$otherPrice = $roomPriceByType[2] + ($restAdult*$roomPriceByType[3]);
					$RoomPriceCalculation += $otherPrice;
				}
				
				if (strpos($child_ageVal, ',') !== false)
				{
					$childAgeArr = explode(',', $child_ageVal);
					//print_r($childAgeArr);
					foreach($childAgeArr as $age)
					{
						if($age>5)
						{
							if($age>5 && $age<=8)
							{
								/* if($childVal == 1)
								{
									
								} */
								$chilePriceCalculation += $roomPriceByType[4];
							}
							else{
								$chilePriceCalculation += $roomPriceByType[6];
							}
						}
					}
				}
				else
				{
					if($child_ageVal>5)
					{
						if($child_ageVal>5 && $child_ageVal<=8)
						{
							/* if($childVal == 1)
							{
								$chilePriceCalculation += $roomPriceByType[4];
							} */
							$chilePriceCalculation += $roomPriceByType[4];
						}
						else{
							$chilePriceCalculation += $roomPriceByType[6];
						}
					}
				}	
				//echo $chilePriceCalculation;
				//echo '<br/><br/>';
				$roomPrices[$j+1] = $RoomPriceCalculation+$chilePriceCalculation;
				//$roomPrices[$j+1] = $RoomPriceCalculation;
			}
			//print_r($roomPrices);
			$dayPriceArr[] = $roomPrices;
		}
		
		//print_r($dayPriceArr);
		
		$sumArray = array();

		foreach ($dayPriceArr as $k=>$subArray) {
		  foreach ($subArray as $id=>$value) {
			$sumArray[$id]+=$value;
		  }
		}
		//print_r($sumArray);
		echo json_encode($sumArray);	
			//echo '<br/>';
	}
	if($_REQUEST['action'] == 'getQueryDetail')
	{
		//print_r($_POST);
		$queryData=$objAdmin->getQueryByNumber($query);
		//print_r($queryData);
		//Array ( [id] => 2 [query_no] => LIDQ0002 [person_name] => Abhishek Anand [organisation] => LID [email] => abhishek@gmail.com [contact_no] => 9867686557 [query_date] => 2016-07-02 [reference] => hfgdjghjfg )
		
		$custEmail = $queryData['email'];
		$number = $queryData['query_no'];
		$query_date = date('d/m/Y', strtotime($queryData['query_date']));
		$query_type = $qT;
		$person_name = ucfirst($queryData['person_name']);
		
		$subject = 'Query Number: '.$number.' / Query Date: '.$query_date.' / Query Type: '.$query_type;
		
		echo '<div class="col-md-12"><strong>Sub: </strong>'.$subject.'</div><br/><br/><div class="col-md-12"><p>Dear '.$person_name.'</p></div>$#$'.$custEmail.'$#$'.$person_name.'$#$'.$subject;
	}
	if($_REQUEST['action'] == 'getHotelSuppCost')
	{
		$startdate = $hidStartDate;
		$enddate = $hidEndDate;
		
		$hotelArr = array_filter($selectedHotel); //array_filter();
		$hotelMastArr = array();
		$i = 0;
		foreach($hotelArr as $hotelId){
			$hotelMastArr[$hotelId][] = $selectedRoom[$i];
			$i++;
		}
		
		if($hotelId == '')
		{
			$hotelId = 0;
		}
		
		$date_rates_detail=$objhotel->calculate_price_dateData($hotelId, $startdate, $enddate);
		$hotelDateId = $date_rates_detail[0]['id'];
		
		$dateMealPlanArr = array();
		$dateIdStr = '';
		//print_r($date_rates_detail);
		foreach($date_rates_detail as $dataData)
		{
			$dateMealPlanArr[$dataData['id']] = $dataData['meal_plan'];
			$dateIdStr .= $dataData['id'].',';
		}
		$dateIdStr = rtrim($dateIdStr,',');
			
		$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId,$dateIdStr);
		//die;
		$searchDataStr = base64_decode($searchDataStr);
			
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
		$sDate = explode('/',$paramArr['startdate']);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$paramArr['enddate']);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		
		//print_r($hotelMastArr);
		
		foreach($hotelMastArr as $hotelid => $roomTypeId)
		{
			$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelid, $startdate, $enddate);
			$hotelDateId = $date_rates_detail[0]['id'];
			
			$hotel_rates_detail=$objhotel->getHotelRoomTypeRatesFilter($hotelid,$hotelDateId,$roomTypeId[0]);
			
			//print_r($hotel_rates_detail); 
			$totalCount = count($hotel_rates_detail);
			if($totalCount)
			{
		?>
		<h3>SUPPLEMENT COSTS – HOTEL <?php echo strtoupper($hotel_rates_detail[0]['hotel_name'])?></h3>
		<table class="table table-bordered">
			<tr>
				<td style="width:40%;"></td>
				<td><?php echo $hotel_rates_detail[0]['room_type']; ?></td>
			</tr>
		<?php	
			$col = '';
			$values = '';
			foreach($hotel_rates_detail as $hotelRates)
			{
				$col .= '<th>'.$hotelRates['room_name'].'</th>';
				$values .= '<td>'.$hotelRates['price'].'</td>';
			//}
				
		?>
			<tr>
				<td><?php echo $hotelRates['room_name']; ?></td>
				<td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $hotelRates['price']; ?></td>
			</tr>
			
		<?php
		}
		?>	
		</table>
		<?php	
		}
	}
		//die;
		
	}
?>

