<?php
include('config/init.php');
	extract($_POST);
	
	$ut = 'e';
	$user_type=$_SESSION['user_type'];
	if($user_type == 'admin')
	{
		$ut = 'a';
	}
if($_REQUEST['action'] == 'getPackageId')
{
		
		$data_id = explode('&',$_POST['data']);
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
					<input type="hidden" name="hotelId" id="hotelId" value='<?php echo $editHotelId; ?>'>
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
											
											$day = '+'.($i-1).' day';
											$date = date('d, F Y',strtotime($startdate . $day));
											//echo "<pre>!!!!";
											//print_r($day);
											//echo "<pre>!!!!!";
											//print_r($date);
											//exit;
											$dateSearch = date('Y-m-d',strtotime($startdate . $day));
											
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
											$hotelStr = '<option value="">Select Hotel</option><option value="">Travelling</option><option value="">Departure</option>';
											//$ragingStr = '<option>Select Rating</option>';
											
											$mealPlanStr = '<option value="">Select Meal Plan</option>';
											
											foreach($hotelDetails as $hotel)
											{
												$hotelId = $hotel['hotel_id'];
												$hotelName = $hotel['hotel_name'];
												$star_rating=$hotel['star_rating'];
												$hotelStr .= '<option value="'.$hotelId.'">'.$hotelName.' ('.$star_rating.' Star)</option>';
											}
											//echo $hotelStr;
											//$hotelStr .= '<option value="">Departure</option>';
											
											
											$k = $i-1;	
									?>
									<tr>
										<th style="border: 1px solid #f4f4f4;"><?php echo $i; ?></th>
										<th style="border: 1px solid #f4f4f4;"><?php echo $cityArr[0]['city'];?></th>
										<th style="border: 1px solid #f4f4f4;"><?php echo $date;?></th>
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
												<option value="0">Select Meal Plan</option>
											</select>
											<?php
												}
											?>
											
										</th>
										<!--<th><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="dayPrice_<?php echo $i; ?>">0</span></th>-->
									</tr>
									<?php
									}
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
											$vehName = $vehCost['vehicle_name'];
											$vehPrice = $vehCost['cost'];
											$vehCleStr .= '<option value="'.$vehPrice.'">'.$vehName.'</option>';
                                            											
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
											<input type="hidden" value="0" id="selectedVehcleCost" />
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
											<select class="form-control col-md-6" name="no_of_vehicle" id="no_of_vehicle">
												<?php
												for($i=1; $i<=10; $i++)
												{
													echo '<option value="'.$i.'">'.$i.'</option>';
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
											<input type="number" id="priceMargin1" value="0" onkeyup="calculate_priceWith_margin1(this.value)" maxlength="2" />
											
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
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $childp_age; ?></td>
										
										<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="roomPrice_<?php echo $i+1; ?>"><?php echo $pArr[$i]; ?></span></td>
									</tr>
									<?php	
									}
								?>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">OC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice1"><?php echo $subTotal; ?></span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice2"><?php //echo $subTotal; ?></span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span> <?php echo $rupeeSymbol; ?> <span id="serviceTax1"><?php echo $serviceTax; ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Total PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal1"><?php echo number_format(floor($grandTot)); ?></span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Profit</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="profit"><?php echo number_format(floor($grandTot)); ?></span></td>
								</tr>
						</table>
						</div>	
					</div>	
					<div style="clear:both"></div>
					<div class="col-md-12">
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
					</div>
					<div class="col-md-12">
						
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
					</div> 
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
				<input type="hidden" id="calculated_prices" value="" />
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
<?php 
}
?>