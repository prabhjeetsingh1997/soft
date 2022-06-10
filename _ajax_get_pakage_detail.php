<?php
include('config/init.php');
$action = $_GET['action'];

extract($_POST);

if($action == 'getDurationTable')
{
	$stateIds = $states;
	$cityName=$objAdmin->get_cityAll($stateIds);
	//print_r($cityName);
	$cities = '<option value="0">Select City</option>';
	foreach($cityName as $newCity)
	{
		//print_r($newCity);
		$cities .= '<option value="'.$newCity['id'].'">'.$newCity['city'].'</option>';
	}
	
	?>
	<table class="table table-bordered">
		<thead>
		  <tr>
			<th>Day</th>
			<th>City</th>
		  </tr>
		</thead>
		<tbody>
	<?php
	for($i=1; $i<=$num; $i++)
	{
	?>		
	  <tr>
		<td><?php echo $i; ?></td>
		<td>
			<select id="tblCity_<?php echo $i; ?>" name="tblCity[]" class="durationDrop"><?php echo $cities; ?></select>
		</td>
	  </tr>
	<?php	
	}
	?>
		</tbody>
	</table>
<?php
}
if($action == 'getHotelRooms')
{
	//Array ( [hotId] => 88 )
	//print_r($_POST);
	
	$selectedDate = $selDate;
	
	//$arrMealType=$objhotel->getHotelMealTypeByid($hotId, $startDate, $endDate);
	$date_rates_detail=$objhotel->getMealPlanByhotelId($hotId, $startDate, $endDate, $searchType, $selectedDate);
	
		//print_r($date_rates_detail);
	//die;   
	$arrRoomType=$objhotel->getHotelRoomTypeByid($hotId);
	//print_r($arrRoomType);
	
	$roomTypeStr = '<option value="0">Select Room Type</option>';
	$roomTypesPriceArr = array();
	$i=0;
	foreach($arrRoomType as $roomType)
	{
		$i++;
		$roomId = $roomType['id'];
		$room_type = $roomType['room_type'];
		//echo $room_type_id;
		$room_type_id=explode(",",$room_type_id);
		//echo $room_type_id[0];exit;
		$sel_room_type ='';
		if($room_type_id[$i-1]==$roomId)
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
	
	$mealTypeStr = '<option value="0">Select Meal Plan</option>';
	foreach($date_rates_detail as $mealData)
	{
		$meal_plan = $mealData['meal_plan'];
		
		$mealTxt = 'CP (Breakfast)';
		if($mealData['meal_plan'] == 2)
		{
			$mealTxt = 'MAP (Breakfast+Dinner)';
		}
		if($mealData['meal_plan'] == 3)
		{
			$mealTxt = 'AP (Breakfast+Lunch+Dinner)';
		}
		if($mealData['meal_plan'] == 4)
		{
			$mealTxt = 'EP (Room Only)';
		}
		if($mealData['meal_plan'] == 5)
		{
			$mealTxt = 'CP Package';
		}
		if($mealData['meal_plan'] == 6)
		{
			$mealTxt = 'MAP Package';
		}
		if($meal['meal_plan'] == 7)
		{
			$mealTxt = 'AP Package';
		}
		if($mealData['meal_plan'] == 8)
		{
			$mealTxt = 'EP Package';
		}
		$mealTypeStr .= '<option value="'.$meal_plan.'">'.$mealTxt.'</option>';
	}
	echo $roomTypeStr.'$##$'.$mealTypeStr;
}
/* if($_POST['id'])
{
	$id=$_POST['id'];

	$intCatId=$objAdmin->get_state($id);
	//print_r($intCatId);
	//

	$optStr = '<option value="" >Select</option>';
	foreach($intCatId as $val)
	{
		$state_name = $val['state_name'];
		$stateId = $val['id'];
		$optStr = $optStr.'<option value="'.$stateId.'" '.$sel.'>'.$state_name.'</option>';
	}
	echo $optStr;
	
} */
	
?>