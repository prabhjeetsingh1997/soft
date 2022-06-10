<?php
	include('config/init.php');
	extract($_POST);
	
	$ut = 'e';
	$user_type=$_SESSION['user_type'];
	if($user_type == 'admin')
	{
		$ut = 'a';
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
		$hotelNames = '<option value="all">All</option>';
		
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
					$hotelNames = $hotelNames .'<option value="'.$hotelId.'">'.$hotel_name.'</option>';
					
					
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
		<div id="hotel_<?php echo $hotelId; ?>" class="hotelBox hotelrating_<?php echo $star_rating; ?>" style="border: 1px solid #DDD;padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
			<div class="col-md-4" style="padding: 0;">
				<?php 
				$photo = '';
				if($countHPhotos)
				{
					$p = 0;
					foreach($hPhotos as $pkey=>$pval)
					{
						$p++;
						if($p == 1)
						{
							$photo = 'document/hotel_doc/hotel_pics/'.$pval;
						}
					}		
				}
				else if($val['image'] != ''){
					$photo = 'document/hotel_doc/hotel_room_pic/'.$val['image'];
				}
				else
				{
					$photo = 'images/pdf/travellogo.png';
				}
				if($photo != ''){
					
				?>
				<img src="<?php echo $photo; ?>" class="img-responsive" style="width:100%;padding: 2px;height: 130px;">
				<?php } ?>
			</div>
			<div class="col-md-8">
				<h4><b style="color:#3C8DBC;"><?php echo $val['hotel_name'];?> <span style="color:#F7C541;margin-left: 10px;font-size: 15px;">
				<?php 
					for($i=0; $i<$star_rating; $i++)
					{	
				?>	
				<i class="fa fa-star" aria-hidden="true"></i>
				<?php } ?>
				</span></b></h4>
				<p><?php echo ucfirst(strtolower($city)); ?>: <?php echo ucfirst($location);?></p>
				
				<?php 
				if(!empty($numOfRoom)){
					?>
				<p>No of Room: <?php echo $numOfRoom;?></p>
				<?php  
				}if(!empty($stayDuration)){
				?>
				<p><?php echo $stayDuration;?> Nights</p>
				<?php
				}
				if(!empty($numOfExtrBed)){
				?>
				<p>Extra Bed: <?php echo $numOfExtrBed;?></p>
				<?php
				}
				if(!empty($childWOutBed)){
				?>
				<p>Extra Child Without Bed: <?php echo $childWOutBed;?></p>
				<?php
				}
				if(!empty($childWithBed)){
				?>
				<p>Extra Child With Bed: <?php echo $childWithBed;?></p>
				<?php
				}
				?>
				<!--<p>Price: <strong>INR <?php echo $actPrice;?></strong> </p>
				<a href="view_hotel_detail.php?action=view&id=<?php echo $val['hotel_id'];?>&roomId=<?php echo $val['id'];?>&totalRoom=<?php echo $numOfRoom;?>&roomCat=<?php echo $roomCatName;?>&duration=<?php echo $stayDuration;?>&extraBed=<?php echo $numOfExtrBed;?>&childwobed=<?php echo $childWOutBed;?>&childwbed=<?php echo $childWithBed;?>&price=<?php echo $actPrice;?>" target="_blank" class="btn btn-success">view Detail</a>-->
				<a href="view_hotel_detail.php?action=view&id=<?php echo $val['hotel_id'];?>&searchData=<?php echo base64_encode($dataStr);?>&qn=<?php echo $queryNumber; ?>&ut=<?php echo $ut; ?>" target="_blank" class="btn btn-success">View Details</a>
			</div>
			
		</div>
<?php
				}
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
			$searchData=$objhotel->search_package($_POST);
			/* print_r($searchData);
			echo count($searchData).':::::'.$searchData; */
			//die;
			//Array ( [searchrooms] => 1 [queryType] => Package [country] => Array ( [0] => 119 ) [state] => Array ( [0] => 187 ) [city] => Array ( [0] => 1998 ) [destination] => [startdate] => 24/08/2016 [enddate] => 25/08/2016 [stayDuration] => 1 [adults] => Array ( [0] => 1 ) [child] => Array ( [0] => 0 ) [child_age] => Array ( [0] => ) )
			
			if(count($searchData) > 0)
			{
				foreach($searchData as $pakageData)	
				{
					//print_r($pakageData);
					$itenryId = $pakageData['id'];
		?>
			<div id="package_<?php echo $itenryId; ?>" class="hotelBox" style="border: 1px solid #DDD;padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
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
			</div>
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
		//$roomPeopleArr;
		//print_r($userSelectMealTypesArr);
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
		//stayDuration
		//print_r($roomPrices);
		echo json_encode($roomPrices);
	}
	if($_REQUEST['action'] == 'getpakageHotelPrice')
	{
		error_reporting(E_All);
		
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
		
		$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
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
			
			$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
			$hotelDateId = $date_rates_detail[0]['id'];
			
			//echo '::::Date_rates::'.print_r($date_rates_detail);
			
			$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId,$hotelDateId);
			//echo 'Room_Rates::'.print_r($hotel_rates_detail);
			
			$roomPriceArr = array();	
			foreach($hotel_rates_detail as $rooms)
			{
				$rtId = $rooms['room_type_id']; // Room Type Id
				$rnId = $rooms['room_name_id']; // Room Name Id
				$roomPriceArr[$rtId][$rnId] = $rooms['price'];
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
				
				$roomPriceByType = $roomPriceArr[$userSelectedTypes];
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
		$hotelArr = array_filter($selectedHotel); //array_filter();
		$hotelMastArr = array();
		$i = 0;
		foreach($hotelArr as $hotelId){
			$hotelMastArr[$hotelId][] = $selectedRoom[$i];
			$i++;
		}
		
		$date_rates_detail=$objhotel->getDateRatesByid_calculate($hotelId, $startdate, $enddate);
		$hotelDateId = $date_rates_detail[0]['id'];
			
		$hotel_rates_detail=$objhotel->getHotelRoomRatesFilter($hotelId,$hotelDateId);
		
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
				<td><?php echo $hotelRates['price']; ?></td>
			</tr>
			
		<?php
		}
		?>	
		</table>
		<?php	
		}
		
		die;
		
	}
?>