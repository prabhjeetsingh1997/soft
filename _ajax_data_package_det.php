<?php
include('config/init.php');
$action=$_GET['action'];
if($action == 'add_hotel_tour_card')
{	
$hotel_id=$_GET['hotel_id'];
$frm_dt=$_GET['frm_dt'];
//echo $_GET['bkg_date2'];exit;
if(empty($_GET['bkg_date2']))
{
$bkg_date2=$_GET['frm_dt'];	
}
else
{
$bkg_date2=$_GET['bkg_date2'];	
}
//echo $bkg_date2;exit;
$to_dt=$_GET['to_dt'];
$breakfast=$_GET['breakfast'];
$room_type_id_new=$_GET['room_type_id_new'];
$room_type=$_GET['room_type'];
$meal_plan_name=$_GET['meal_plan_name'];
$city_name=$_GET['city_name'];
$hotel_name=$_GET['hotel_name'];
$country=$_GET['country'];
$arrcountery1=$objAdmin->get_countery_aj($country);
//print_r($room_type_id_new);
// print_r($breakfast);exit;
$id=$_GET['tour_id'];
$partner_url_name=$objAdmin->get_partner_url_name($id);
$markup=$objAdmin->get_partner($partner_url_name['partner_url']);
$hotel_markup=$markup['hotel_markup'];
$package_markup=$markup['package_markup'];
$queryType='Package';
$arr_query=$objAdmin->getAllTourcard_info($id,$queryType);
$arr_query_room_rates=$objhotel->getAlldate_id_room_rates($hotel_id,$frm_dt,$to_dt,$breakfast);
//print_r($arr_query_room_rates);exit;
$arr_query_room_rates1=$objhotel->get1Allhotel_room_rates($arr_query_room_rates['id'],$room_type_id_new);

//print_r($arr_query_room_rates1);exit;
$room=$_GET['room'];
$date_id=$_GET['date_id'];
$date_search=$_GET['date_search'];
$margin_percent=$_GET['margin_percent'];
//echo $margin_percent;exit;
$ut = 'e';
	$user_type=$_SESSION['user_type'];
	if($user_type == 'admin')
	{
		$ut = 'a';
	}

		
		//$data_id = explode('&',$date_id);
		//print_r($data_id);exit;
		$editItiId = $date_id;
		$searchData =  $date_search;
		
		
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
		
		//<!--package price start-->//
	
		//$searchDataStr = base64_decode($searchDataStr);
        //print_r($searchDataStr);exit;
		   

		

		

		

		$hotelIds = array();

		//print_r($selectedHotel);exit;
		//$selectedHotel1=array(0,235,0);
		//print_r($selectedHotel1);exit;
		//$selectedHotel=array(434,0,0);
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

		//print_r($hotelIds);exit;

		
			//echo $h.'<br/>';

			//$hotelId = $hotelIds[$h];

			$roomTypeId = $room_type_id_new;

			$userSelectedMealPlan = $breakfast;

		//print_r($hotelId);

			//$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
             $hotelId1=$hotel_id;
			 //print_r($hotelId1);exit;
			//$date_rates_detail=$objhotel->calculate_price_dateData($hotelId1, $startdate, $enddate);
			$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId1, $startdate, $enddate);
            //print_r($date_rates_detail);exit;
			$hotelDateId = $date_rates_detail[0]['id'];

		

			//echo '<br/>'.$hotelMealPlanId = $date_rates_detail[0]['meal_plan'];

			

			$dateMealPlanArr = array();

			$dateIdStr = '';

			foreach($date_rates_detail as $dataData)

			{

				$dateMealPlanArr[$dataData['id']] = $dataData['meal_plan'];

				$dateIdStr .= $dataData['id'].',';

			}

			$dateIdStr = rtrim($dateIdStr,',');

			//print_r($dateIdStr);exit;

			//echo '<br/>::::Date_rates::'.print_r($dateMealPlanArr);

			

			$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId1,$dateIdStr);
            //print_r($hotel_rates_detail); exit;
			//echo 'Room_Rates::'.print_r($hotel_rates_detail);exit;

			//die;

			$roomPriceArr = array();	
			
			//$price_arr=array(2000,3000,4000,5000);
            // $i=0;
			foreach($hotel_rates_detail as $rooms)

			{
                 
				$dateId = $rooms['date_id'];

				$rtId = $rooms['room_type_id']; // Room Type Id

				$rnId = $rooms['room_name_id']; // Room Name Id

				
				$mealPlan = $dateMealPlanArr[$dateId];
                  
				
				$roomPriceArr[$rtId][$mealPlan][$rnId] = $rooms['price'];
				
				
             
			}
           //echo "<pre>!!!!!";
			//print_r($roomPriceArr);

			$roomPrices = array();

			$roomPriceByType = array();

			

			$countRooms=count($paramArr['adults']);
			 //echo "<pre>@@@@";
              // print_r($countRooms);exit;
			//echo '<br>'.$countRooms=$itineryDuration;

			//echo '<br>';

			for($j=0; $j<$countRooms; $j++)

			{

				//Array ( [0] => 140 [1] => 140 )

				$userSelectedTypes = $roomTypeId;

				//print_r($userSelectedTypes);exit;
               // $roomPriceByType = array(8500,8500,1600,1000,1600);
				$roomPriceByType = $roomPriceArr[$userSelectedTypes][$userSelectedMealPlan];
                //$roomPriceByType = array("1"=>"2500","2"=>"2700","3"=>"650","4"=>"350","6"=>"650");
				//print_r($roomPriceByType);exit;

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

			
       // $roomPrices1=$roomPrices*$margin_percent/100;
		//$roomPrices2=$roomPrices+$roomPrices1;
		
		$dayPriceArr[] = $roomPrices;
//echo json_encode($dayPriceArr);exit;
		//print_r($roomPrices);exit;

		$dayPriceArr1=implode(",",$roomPrices);
		//$dayPriceArr2=explode(",",$dayPriceArr1);
         //print_r($dayPriceArr2);exit;
		$sumArray = 0;



		foreach ($dayPriceArr as $k=>$subArray) {
			
			//print_r($subArray);exit;
		  foreach ($subArray as $value) {

			$sumArray+=$value;

		  }

		}
		
		$sumArray1=$sumArray*$margin_percent/100;
		$sumArray2=$sumArray+$sumArray1;
		$pack=$sumArray2*$package_markup/100;
		$pack1=$sumArray2+$pack;
		$gst=$pack1*5/100;
		$total_profit=$pack1+$gst;
		$profit=$sumArray2-$sumArray;
		//print_r($sumArray);exit;
		//json_encode($sumArray);	

			//echo '<br/>';

	

	
		//end package price//
		
}
?>
<div class="">
					
</div>
<div class="form-group">
	
	    
		<div class="col-md-12 padbo">
		<div class="col-md-9 padbo">
		<form method="POST" id="hotel_cost_data">
			<table width="100%;" cellspacing="3" cellpadding="3">
				<tr>
			       
					
					<th>Costing</th>
					<?php
                     $room_name_array=array();					
					foreach($arr_query_room_rates1 as $arr_query_room_rates2)
					{
						$room_name_array1=explode(",",$arr_query_room_rates2['room_name']);
						foreach($room_name_array1 as $room_name_array2)
					    {
							$room_name_array[]=$room_name_array2;
						}
					?>
					
					<td><?php echo $arr_query_room_rates2['room_name'] ?></td>
					<?php 
					}
					?>
					
					<input type="hidden" name="costing" value="<?php echo implode(",",$room_name_array) ?>" />
					
				</tr>
				<tr>
				    <th><?php echo $_GET['room_type'] ?></th>
					<?php 
					$i=1;
					$room_price_array=array();	
					foreach($arr_query_room_rates1 as $arr_query_room_rates2)
					{
						$arr_query_room_rates3=explode(",",$arr_query_room_rates2['price']);
						foreach($arr_query_room_rates3 as $arr_query_room_rates4)
					    {
							$room_price_array[]=$arr_query_room_rates4;
						}
						//$room_price_array .=$arr_query_room_rates2['price'];
						//$arr_query_room_rates_price=implode(",",$arr_query_room_rates2['price']);
					?>
				
					<td>
					<input type="hidden" rel="" value="<?php echo $arr_query_room_rates2['room_name_id'] ?>" name="" class="form-control" id="edit_room<?php echo $i ?>"/>
					<input type="hidden" rel="" value="<?php echo $arr_query_room_rates2['room_name'] ?>" name="" class="form-control" id="edit_room_name<?php echo $i ?>"/>
					<input type="text" rel="<?php echo $arr_query_room_rates2['price']; ?>" value="<?php echo $arr_query_room_rates2['price'] ?>" name="hotel" class="form-control" id="edit_price<?php echo $i ?>" onkeyup=""/></td>
					<?php
					$i++;					
					}
					?>
					<input type="hidden" name="price_rate" value="<?php echo  implode(",",$room_price_array) ?>" />
					<input type="hidden" name="room_count" id="room_count" value="<?php echo $i-1; ?>"/>
					
				</tr>
			</table>
		</form>
			</div>
			<div class="col-md-3 padbo">
			
               <button type="button" class="btn btn-primary btn-lg" rel="<?php echo $frm_dt ?>,<?php echo $bkg_date2 ?>,<?php echo $breakfast ?>,<?php echo $room_type_id_new ?>,<?php echo $room_type ?>,<?php echo $meal_plan_name ?>,<?php echo $city_name ?>,<?php echo $hotel_name ?>,<?php echo $country ?>,<?php echo $_GET['hotel_id']; ?>" id="cal_price_rates" style="margin-top:53px;">Calculate Pric</button>
			   </div>
		</div>
		<div class="col-md-12 data_tour_cost">		
							<h3>Tour Cost</h3>	
							<div class="table-responsive">
							<form method="POST" id="tour_cost_data">
							<table class="table table-bordered" cellspacing="0" width="100%">
								<tr><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Room</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Adult</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren)</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren) Age</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Price</th></tr>
								<?php
									//print_r($adults);exit;
									//echo count($adults);
									$j = 1;
									for($i=0; $i<$room; $i++)
									{
										$adultP = $adults[$i];
										$adultP1=implode(",",$adults);
										$childp = $child[$i];
										$childp1=implode(",",$child);
										if(is_array($child_age))
										{
											$childp_age = $child_age[$i];
											$childp_age1=explode(",",$child_age[$i]);
											//$childp_age2=implode(",",$childp_age1);
											
											
										}
										else
										{
											$childp_age = $child_age;	
										}
									?>
									<tr>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $i+1; ?></td>
										<input type="hidden" name="adultP" value="<?php echo $adultP1; ?>" />
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-male" aria-hidden="true"></i></span> <?php echo $adultP; ?></td>
										<input type="hidden" name="childp" value="<?php echo $childp1; ?>" />
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-child" aria-hidden="true"></i></span> <?php echo $childp ; ?></td>
										<?php for($r1=0; $r1<$room; $r1++)
									         {?>
										<input type="hidden" name="childp_age<?php echo $r1 ?>" value="<?php echo $child_age[$r1]; ?>" />
										<?php }?>
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $childp_age; ?></td>
										<input type="hidden" name="room_price" value="<?php echo $dayPriceArr1; ?>" />
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="roomPrice2_<?php echo $i+1; ?>"><?php
										print_r($dayPriceArr[0][$i+1]);
										//$price_new=$arr_query_tour_card_room_dt[$i]['price']* $arr_query_tour_card_det['margin_percent']/100;
								        //echo $price_new1=$arr_query_tour_card_room_dt[$i]['price']+$price_new;
										
										?></span></td>
									</tr>
									<?php	
									$j++;}
								?>
								<tr>
								<input type="hidden" name="oc" value="<?php echo $sumArray; ?>" />
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">OC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice5"><?php echo $sumArray; ?></span></td>
								</tr>
								<tr>
								<input type="hidden" name="pc" value="<?php echo $sumArray2; ?>" />
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice5"><?php echo $sumArray2; ?></span></td>
								</tr>
								<tr>
								<input type="hidden" name="gst" value="<?php echo $gst; ?>" />
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span> <?php echo $rupeeSymbol; ?> <span id="serviceTax3"><?php echo $gst; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
								<input type="hidden" name="total_pc" value="<?php echo $total_profit; ?>" />
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Total PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal3"><?php echo $total_profit; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
								<input type="hidden" name="profit" value="<?php echo $profit; ?>" />
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Profit</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="profit3"><?php echo $profit; ?></span></td>
								</tr>
					</table>
					</form>
			</div>	
			
		</div>
		 <div class="modal-footer">
		 <form method="POST" id="hotel_conf_data">
 <input type="hidden" name="searchData" id="date_search" value="<?php echo $date_search; ?>"/> 
                     <input type="hidden" name="tour_id" id="tour_id" value="<?php echo $id; ?>"/>  
					<input type="hidden" name="editItiId" id="editItiId" value="<?php echo $editItiId; ?>"/>
					<input type="hidden" name="room" id="room" value="<?php echo $room; ?>"/>
					<input type="hidden" name="margin_percent" id="margin_percent" value="<?php echo $margin_percent; ?>"/>
					<input type="hidden" readonly class="form-control" value="<?php echo $arr_query['tc_no'] ?>" name="tc_no1" id="tc_no">
					<input type="hidden" readonly value="<?php echo $arr_query['pax_name'] ?>" name="pax_name1" class="form-control" id="">
					<input class="form-control" readonly type="hidden" name="bkg_date1" id="bkg_date1" value="<?php echo $frm_dt ?>" />
					<input class="form-control" readonly type="hidden" name="bkg_date2" id="bkg_date2"  value="<?php echo $bkg_date2 ?>" />
					<input class="form-control" readonly name="nights" id="bkg_by" type="hidden" value="1"/>
					<input readonly type="hidden" name="hotel1" class="form-control" id="hotel_name" value="<?php echo $hotel_name ?>"/>
					<input readonly type="hidden"  name="city1" class="form-control" id="city_name" value="<?php echo $city_name ?>" />
					<input readonly type="hidden"  name="room_type1" class="form-control" id="room_type_name" value="<?php echo $room_type;?>"/>
					<input readonly type="hidden"  name="meal_plan1" class="form-control" id="meal_plan_name" value="<?php echo $meal_plan_name; ?>" />
					<input readonly type="hidden"  name="country1" class="form-control" id="country1" value="<?php echo $arrcountery1['country_name']; ?>" />
					<input readonly type="hidden"  name="hotel_id" class="form-control" id="hotel_id" value="<?php echo $_GET['hotel_id']; ?>" />
					<input readonly type="hidden"  name="room_rate_price2" class="form-control" id="room_rate_price2" value=<?php echo json_encode($roomPriceByType); ?> />
					
					 <button type="button" class="btn btn-success data_btn_success" id="hotel_confiramtion">Send Confirmation</button>
</form>
	     
      
       </div>
   
</div>

<script>
$(document).on('click','#hotel_confiramtion',function(){
		
			
				//var fd = new FormData("#hotel_conf_data")[0];
			
				//alert('hello');
		$.ajax({
        	url: "_ajax_hotel_confrimation_send.php?action=hotel_confirmation_add",
			type: "POST",
			data:$("#hotel_conf_data,#hotel_cost_data,#tour_cost_data").serialize(), 
			success: function(data)
		     {
			     if(data == 1)
							{
								alert('Hotel Confirmation Send Successfully');
								location.reload();
							}
							else
							{
								alert('There is some error in sending email');
							}
			
			 }
		  	 	        
	   });
				// $.ajax({
					// type: "POST",		
					// url:"_ajax_hotel_confrimation_send.php?action=hotel_confirmation_add",
					// data:$("#hotel_conf_data").serialize(), 
                    // contentType: false,
					// processData: false,			
					// beforeSend:function(){	
					// },
					// success:function(html){
						
						
					// }
				// });
			});
</script>
