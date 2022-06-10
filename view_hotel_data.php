<?php
	include('config/init.php');
	$editHotelId='';
	$countRoom='';
	$roomPrice='';
	$extraBedPrice='';
	if($_GET['action']=='view')
	{
		//print_r($_SERVER);
		//$downloadPdfUrl = 'pdf.php?'.$_SERVER['QUERY_STRING'];
		
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
		$editHotelId=$_GET['id'];
		$searchData=$_GET['searchData'];
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
		
		//print_r($roomTypesPriceArr);
		
		$arrMasterRooms=$objhotel->getMasterRoomNames();
		$masterRooms = array();
		foreach($arrMasterRooms as $mrooms)
		{
			$masterRooms[$mrooms['id']] = $mrooms['room_name'];
		}
	} 

?><!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		<?php 
				$rupeeSymbol = '<img src="'.APP_URL.'images/rupee.png" alt="" style="margin-top:3px;" />';
				if($type != 'pdf')
				{
					$border = 'border: 1px solid #DDD;';
					$rupeeSymbol = '';
			?>
          <h3>
             View Hotel Detail
			</h3>
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
		  <form id="formData">
			<input type="hidden" name="hotelId" id="hotelId" value='<?php echo $editHotelId; ?>'>
			<input type="hidden" name="hotelDateId" id="hotelDateId" value='<?php echo $hotelDateIdStr; ?>'>
			<input type="hidden" name="masterRoomArr" id="masterRoomArr" value='<?php echo serialize($arrMasterRooms); ?>'>
			<input type="hidden" name="arrRoomType" id="arrRoomType" value='<?php echo serialize($arrRoomType); ?>'>
			<input type="hidden" name="roomTypesPriceArr" id="roomTypesPriceArr" value='<?php echo serialize($roomTypesPriceArr); ?>'>
			<input type="hidden" name="searchDataStr" id="searchDataStr" value='<?php echo $searchData; ?>'>
			<input type="hidden" name="userSelectRoomTypes" id="userSelectRoomTypes" value=''>
			<input type="hidden" name="userSelectMealTypes" id="userSelectMealTypes" value=''>
		  </form>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
			<div class="col-md-12">
			<div class="box box-default">
			<?php 
				if($type != 'pdf')
				{
			?>
				<div class="box-header with-border">
					<div id="status1"></div>
					<div id="searchType" style="font-size:20px;border-bottom: 1px solid #EEE;padding-bottom: 5px;"><?php echo $hotelName;?></div>
						
					<div class="col-md-12" style="margin-top:10px; padding:0">
						<div class="form-group form-inline">
							<label for="userPhone">Query Number: </label>
							<input type="input" name="queryNumber" id="queryNumber" class="form-control" placeholder="Query Number" value="<?php echo $queryNumber; ?>" />
							<button type="submit" class="btn btn-primary" name="searchQueryBtn" id="searchQueryBtn" style="margin-left: 10px;">Search</button>	
						</div>
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
							<img src="images/pdf/travellogo.png" style="width:300px;" />
						</div>
					</div>
					<?php 
						}
					?>
					<div id="searchData" style="padding:15px 0;">
						<div style="<?php echo $border;?>padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
						
							<div class="col-md-12">
								<div class="row" id="showQueryDetail">
									<?php echo $quryDetail; ?>
								</div>	
								<div class="row">
									<div class="col-md-12">
										<p>Greetings from <strong><span style="font-size: 19px;background: yellow; color:#00c0ef;">LiD – Travel </span>!!!</strong></p>
										<p>Thank you for considering us for your forthcoming travel plan, as per details provided by you we are pleased to quote the following:</p>
									</div>
								</div>
							</div>
						
							<div class="col-md-12">
								
								<h3>Details</h3>
								<div class="hotelDetail table-responsive">
									<table class="table table-bordered" cellspacing="0">
										<tr>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Hotel Name</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $hotelName;?></td>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Hotel Address</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $hotAddress;?></td>
										</tr>
										<tr>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Start Category</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $hotelstar_rating;?> Star</td>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">No. of Passengers</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;">
												<?php
													if(is_array($adults))
													{
														echo array_sum($adults);
													}
													else
													{
														echo $adults;
													}
												?> Adults + 
												<?php 
													if(is_array($child))
													{
														echo array_sum($child);
													}
													else
													{
														echo $child;
													}
													
												?> Kids 
											</td>
										</tr>
										<tr>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Check-in</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo date('d, F Y',strtotime($startdate));?></td>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Check-out</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo date('d, F Y',strtotime($enddate));?></td>
										</tr>
										<tr>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;">Nights</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo $stayDuration;?> Night(s)</td>
											<td style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;padding: 8px;"> Rooms Required</td>
											<td style="border: 1px solid #f4f4f4;padding: 8px;"><?php echo count($adults);?></td>
										</tr>
									</table>
								</div>
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
								<div class="col-md-12" style="padding:0;">
								
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
												<select class="form-control userRoomTypes" id="class<?php echo $i+1; ?>">
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
												<select class="form-control mealTypes" id="class<?php echo $i+1; ?>">
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
							<div style="clear:both"></div>
							<h3>Inclusions:</h3>
							<ul>
								<li>Welcome drinks on Arrival at hotel/resort. (Non alcoholic)</li>
								<li>Accommodation as per above details.</li>
								<li>Meals as above mentioned Meal Plan.</li>
								<li>All kind of applicable hotel, transport, service &amp; govt. taxes.</li>
							</ul>
							<?php
								$dispPckg = "display:none;";
								$desc= '';
								if($type == 'pdf')
								{
									//print_r($selMealPlansArr);
									$mArr = array();
									if(is_array($selMealPlansArr))
									{
										foreach($selMealPlansArr as $mVal)
										{
											if($mVal == 'CP (Breakfast)')
											{
												$mv = 1;
											}
											if($mVal == 'MAP (Breakfast+Dinner)')
											{
												$mv = 2;
											}
											if($mVal == 'AP (Breakfast+Lunch+Dinner)')
											{
												$mv = 3;
											}
											if($mVal == 'EP (Room Only)')
											{
												$mv = 4;
											}
											if($mVal == 'CP Package')
											{
												$mv = 5;
											}
											if($mVal == 'MAP Package')
											{
												$mv = 6;
											}
											if($mVal == 'AP Package')
											{
												$mv = 7;
											}
											if($mVal == 'EP Package')
											{
												$mv = 8;
											}
											$mArr[] = $mv;
										}
									}
									$mArr = array_filter($mArr);
									//print_r($mArr);
									//echo 'asdfads::::';
									$getRateDescription = $objhotel->getDateRatesDesc($editHotelId, $startdate, $enddate, implode($mArr,','));
									//print_r($getRateDescription);
									$desc = $getRateDescription[0]['description'];
									$dispPckg = "display:block;";
								}
								
							?>
							<div id="mealDesBox" style="<?php echo $dispPckg; ?>">
								<h3>Package Description:</h3>
								<div id="mealDescriptions">
									<?php echo $desc; ?>
								</div>
							</div>
							<h3>Exclusions:</h3>	
							<ul>
								<li>Tips to the guide / driver / restaurants / airport / hotels etc.</li>
								<li>Any expenses of personal nature such as, drinks, laundry, telephone calls, insurance, camera fees, excess baggage, emergency/medical cost etc.</li>
								<li>Any expenses/services not mentioned or not covered under above inclusions header are extras and to be paid off by guest directly.</li>
							</ul>
							<h3>Note:</h3>
							<ul>
								<li>Child Policy:
									<ul>
										<li>0 to 5 years child is complimentary sharing parent’s bed.</li>
										<li>6 to 8 years child will be charged as extra child without bed.</li>
										<li>9 to 12 years child will be charged as extra child with bed.</li>
									</ul>
								</li>
								<li>The cost is irrelevant of circumstances that are beyond our control. Situations such as road blockade due to strike or agitation, earthquake, natural calamity, sickness evacuation, delay or cancellation of train or flight etc. are beyond our control.</li>
								<li>We are not holding any booking, so room(s) availability may vary at the time of booking.</li>
								
							</ul>
							
							</div>
							<!--<div class="col-md-3" style="padding: 0;">
								<img src="document/hotel_doc/hotel_room_pic/<?php echo $image;?>" style="width:100%;padding: 2px;height: 158px;border: 1px solid #EEE;">
							</div>-->
						</div>
					</div>
					
					<div style="clear:both;"></div>
					
					
				</div>
				<?php 
					if($type == 'pdf')
					{
				?>
				<div class="row">
					<div class="col-md-12" style="text-align:right; position:relative;">
						<img src="images/pdf/footer.png" style="width:100%;" />
						<div style="position: absolute;top: 0px;right: 30px;padding: 10px;">
							<a href="https://www.facebook.com/LiD.TE/" target="_blank"><img src="images/pdf/fb.png" style="height:40px;" /></a>
							<a href="https://www.instagram.com/planetlid/?hl=en" target="_blank">
							<img src="images/pdf/instagram.png" style="height:40px;" /></a><br/>
							<a href="https://www.youtube.com/channel/UCXUSz7sEHs4_RisR-nENw9w" target="_blank">
							<img src="images/pdf/youtube.png" style="height:40px;" /></a>
							<a href="https://plus.google.com/+LightsinDarkTravelEventsPvtLtdNewDelhi" target="_blank">
							<img src="images/pdf/google+.png" style="height:40px;" /></a>
							
						</div>
						<div style="position: absolute;top: 60px;right: 150px;">
							<a href="http://lidtravel.com/" target="_blank"><img src="images/pdf/website.png" style="height: 20px;"></a>
							
						</div>
					</div>
				</div>
				<?php
					}
				?>
			</div>
			<?php 
				if($type != 'pdf')
				{
			?>
			<div class="box-footer text-right">
				<!--<a href="<?php echo $downloadPdfUrl; ?>" class="btn btn-info" id="download">Download PDF</a>-->
				<input type="hidden" id="calculated_prices" value="" />
				<input type="hidden" id="selected_rooms" value="" />
				<input type="hidden" id="selected_mealPlans" value="" />
				<button type="button" class="btn btn-info" id="download" onclick="downlaod_pdf('<?php echo $_SERVER['QUERY_STRING'].'&hotel='.base64_encode($hotelName); ?>', 'downlaod')">Download PDF</button>&nbsp;&nbsp;&nbsp;
				<a class="btn btn-primary pull-right" href="#sendToCl" data-toggle="modal"><i class="fa fa-envelope-o"></i> Mail to Client</a>
				
			</div>
			<?php
				}
			?>
			</div>
		</div>
    </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->