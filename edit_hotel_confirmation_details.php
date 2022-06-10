<?php 
include('header.php');
include('sidebar.php');
error_reporting(0);

$arr_query=$objAdmin->editAllHotelConfirmation($_GET['id']);
$costing=explode(",",$arr_query['costing']);
$room_type_price=explode(",",$arr_query['room_type_price']);
$arr_query1=$objAdmin->editChoosenPack($arr_query['tour_card_id']);
$choosen_pack=explode("&",$arr_query1['choosen_pack']);
$room_rate1=json_decode($arr_query['room_ratee_price'],true);
$margin_percent=$arr_query1['margin_percent'];
$partner_url_name=$objAdmin->get_partner_url_name($arr_query['tour_card_id']);
$markup=$objAdmin->get_partner($partner_url_name['partner_url']);
$hotel_markup=$markup['hotel_markup'];
$package_markup=$markup['package_markup'];
//print_r($room_rate1);exit;
//echo $choosen_pack[1];exit;
	$ut = 'e';
	$user_type=$_SESSION['user_type'];
	if($user_type == 'admin')
	{
		$ut = 'a';
	}

		
		//$data_id = explode('&',$arr_query_tour_card_det['choosen_pack']);
		//print_r($data_id);exit;
		$editItiId = $choosen_pack[0];
		$searchData = $choosen_pack[1];
		
		
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
		
		//print_r($adults);exit;
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

				//$userSelectedTypes = $roomTypeId;

				//print_r($userSelectedTypes);exit;
               // $roomPriceByType = array(8500,8500,1600,1000,1600);
				//$roomPriceByType = $roomPriceArr[$userSelectedTypes][$userSelectedMealPlan];
				$roomPriceByType = $room_rate1;
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
		//print_r($dayPriceArr);exit;

		

		$sumArray = 0;



		foreach ($dayPriceArr as $k=>$subArray) {
			
			//print_r($subArray);exit;
		  foreach ($subArray as $value) {

			$sumArray+=$value;

		  }

		}
		
		$sumArray1=$sumArray*$margin_percent/100;
		$sumArray2=$sumArray+$sumArray1;
		
		$gst=$sumArray2*5/100;
		$total_profit=$sumArray2+$gst;
		$pack_total=$total_profit*$package_markup/100;
		$total_profit1=$total_profit+$pack_total;
		$profit=$sumArray2-$sumArray;
//print_r($arr)
?>

<style>
	table tr th {
    padding: 10px;
    border: 1px solid #ccc;
}

table tr td {
    padding: 10px;
    border: 1px solid #ccc;
}

.modal-title {
    margin-top: 10px;
    line-height: 2.42857143;
}
.padbo {
    padding-bottom: 15px;
}
</style>

  
<div class="content-wrapper">
  <div class="row">
  <div id="qDetail1" class="container" >
  <div class="" style="width:90%;">
  <div class="modal-1">
 <h2 class="modal-title" style=""></h2>
      
		  
<div class="modal-raj" style="overflow: hidden;">
<form method="POST" id="tour_card_data1">
    <thead>

 <div class="form-group input_form">
	<div class="col-md-3 padbo">
			<label>Tour Card No:</label>
		
			<input type="text" readonly class="form-control" value="<?php echo $arr_query['tour_card_no'] ?>" name="tc_no1" id="tc_no" />
	</div>
<div class="col-md-3 padbo">
			<label>Check In Date:</label>
			<?php 
			$date = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_in']);
			//$date1 = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_out']);
			
			?>
			<input class="form-control" readonly type="text" name="bkg_date1" id="bkg_date1"  value="<?php echo $arr_query['checkin_date'] ?>" />
		</div>
		<div class="col-md-3 padbo">
			<label>Check Out Date:</label>
			<?php 
			$date = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_in']);
			//$date1 = DateTime::createFromFormat('d/m/Y', $arr_query_tour_card_det['check_out']);
			
			?>
			<input class="form-control" readonly type="text" name="bkg_date2" id="bkg_date2" value="<?php echo $arr_query['checkout_date'] ?>" />
		</div>
		<div class="col-md-3 padbo">
			<label>Nts:</label>
			<input class="form-control" readonly name="bkg_by1" id="bkg_by" type="text" value="<?php echo $arr_query['nights'] ?>"/>
		</div>
</div>

<div class="form-group input_form">
	
		
		<div class="col-md-6 padbo">
			<label>Lead Pax Name:</label>
			<input type="text" readonly value="<?php echo $arr_query['pax_name'] ?>" name="pax_name1" class="form-control" id="" />
		</div>

		<div class="col-md-6 padbo">
			<label>Nationality:</label>
				<select name="country1" class="form-control" readonly>
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
			<input readonly type="text" value="<?php echo $arr_query['hotel'] ?>" name="hotel1" class="form-control" id="hotel_name" />

		</div>
		<div class="col-md-4 padbo">
			<label>City:</label>
			<input readonly type="text" value="<?php echo $arr_query['city'] ?>" name="city1" class="form-control" id="city_name" />

		</div>
		<div class="col-md-4 padbo">
			<label>Room Type:</label>
			<input readonly type="text" value="<?php echo $arr_query['room_type'] ?>" name="room_type1" class="form-control" id="room_type_name" />

		</div>
   
</div>
<div class="form-group input_form">
	
		<div class="col-md-12 padbo">
			<label>Meal Plan:</label>
			<input readonly type="text" value="<?php echo $arr_query['meal_plan'] ?>" name="meal_plan1" class="form-control" id="meal_plan_name" />

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
	 <input type="hidden" value="<?php echo $hotel_markup; ?>" id="hotel_markup" />
	   <input type="hidden" value="<?php echo $package_markup; ?>" id="package_markup" />
  </form>   

<div id="result_data_price">
<div class="form-group">
<div class="col-md-12 padbo">
	<div class="col-md-12 padbo">
	<form method="POST" id="hotel_cost_data">
		<table width="100%;" cellspacing="3" cellpadding="3">
			<tbody>
				<tr>
					<th>Costing</th>
					<?php 
					foreach($costing as $costing1)
					{
					?>
					<td><?php echo $costing1; ?></td>
					<?php 
					}
					?>
				</tr>
				<tr>
				    <th><?php echo $arr_query['room_type'] ?></th>
				    <?php 
					foreach($room_type_price as $room_type_price1)
					{
					?>
					<td><?php echo $room_type_price1; ?></td>
					<?php 
					}
					?>
				    
				</tr>
          </tbody>
	</table>
</form>
	</div>
	</div>
		<div class="col-md-12">		
							<h3>Tour Cost</h3>	
							<div class="table-responsive">
							<form method="POST" id="tour_cost_data1">
							<table class="table table-bordered" cellspacing="0" width="100%">
								<tr><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Room</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Adult</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren)</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren) Age</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Price</th></tr>
								<?php
									//print_r($adults);exit;
									//echo count($adults);
									$j = 1;
									for($i=0; $i<count($adults); $i++)
									{
										$adultP = $adults[$i];
										$adultP1=implode(",",$adults);
										$childp = $child[$i];
										$childp1=implode(",",$child);
										if(is_array($child_age))
										{
											$childp_age = $child_age[$i];
											//$child_age2=$child_age[$i];
											//print_r($child_age2);
											//$childp_age1=explode(",",$child_age[$i]);
											//$childp_age2=implode(",",$child_age);
											
											
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
										
										<input type="hidden" name="childp_age" value="<?php echo $childp_age; ?>" />
										
										<?php ?>
									   <td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-child" aria-hidden="true"></i></span> <?php echo $childp_age ; ?></td>
									
										
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
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">OC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice5"><?php echo $sumArray; ?></span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice5"><?php echo $sumArray2; ?></span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span> <?php echo $rupeeSymbol; ?> <span id="serviceTax3"><?php echo $gst; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Total PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal3"><?php echo $total_profit1; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Profit</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="profit3"><?php echo $profit; ?></span></td>
								</tr>
					</table>
					</form>
			</div>	
		</div>
		 <div class="modal-footer">
		 <form method="POST" id="hotel_conf_data">
                    <input type="hidden" name="date_search" id="date_search" value=""> 
                    <input type="hidden" name="tour_id" id="tour_id" value="">  
					<input type="hidden" name="editItiId" id="editItiId" value="">
					<input type="hidden" name="room" id="room" value="">
					<input type="hidden" name="margin_percent" id="margin_percent" value="">
					<input type="hidden" readonly="" class="form-control" value="" name="tc_no1" id="tc_no">
					<input type="hidden" readonly="" value="" name="pax_name1" class="form-control" id="">
					<input class="form-control" readonly="" type="hidden" name="bkg_date1" id="bkg_date1" value="">
					<input class="form-control" readonly="" type="hidden" name="bkg_date2" id="bkg_date2" value="">
					<input class="form-control" readonly="" name="nights" id="bkg_by" type="hidden" value="">
					<input readonly="" type="hidden" name="hotel1" class="form-control" id="hotel_name" value="">
					<input readonly="" type="hidden" name="city1" class="form-control" id="city_name" value="">
					<input readonly="" type="hidden" name="room_type1" class="form-control" id="room_type_name" value="">
					<input readonly="" type="hidden" name="meal_plan1" class="form-control" id="meal_plan_name" value="">
					<input readonly="" type="hidden" name="country1" class="form-control" id="country1" value="">
					<input readonly="" type="hidden" name="room_rate_price2" class="form-control" id="room_rate_price2" value="">
					
					
                </form>
            </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
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
			$("#qDetail1").modal();
			var del_id = element.attr("rel");
			var array = del_id.split(",");
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
</script>




<?php include('footer.php'); ?> 