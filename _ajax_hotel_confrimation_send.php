<?php
include('config/init.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$action=$_GET['action'];

extract($_POST);

if($action == 'hotel_confirmation_add')
{
	//print_r($_POST);exit;
	
//
$hotel_confirm = $objhotel->hotel_confrm_add($_POST);

//print_r($hotel_confirm);exit;
if($hotel_confirm==1)
{
	
	$hotel_confirm1 = $objhotel->hotel_update_pack_add($bkg_date1,$tour_id);
	//sendMail($_POST);
	if($hotel_confirm1==1)
	{
		sendMail($_POST);
	   echo '1';
		
	}
}
	
	
}
if($action == 'hotel_confirmation_add1')
{
	//print_r($_POST);exit;
	//print_r($room_rate_price2);exit;
	sendMail($_POST);exit;
	$hotel_confirm = $objhotel->hotel_confrm_add($_POST);
//print_r($hotel_confirm);exit;
if($hotel_confirm==1)
{
	$hotel_confirm1 = $objhotel->hotel_update_pack_add($bkg_date1,$tour_id);
	
	
		
		 echo '1';
		
	
	
}
}
function sendMail($data)
{
    extract($_POST);
//print_r($_POST);exit;
	
	$room_rate1=json_decode($room_rate_price2,true);
	
	//print_r($room_rate1);exit;
	//$room_rate1=arrayjson_decode($room_rate_price2);
	//print_r($room_rate1);exit;
	//print_r($room_rate1);exit;
	$costing1=explode(",",$costing);
	$costing3='<th>Costing</th>';
	foreach($costing1 as $costing2)
{
	$costing3 .='<td>'.$costing2.'</td>';
	
}
$price_rate1=explode(",",$price_rate);
$price_rate3='<th>Garden View Suite</th>';	
foreach($price_rate1 as $price_rate2)
{
	$price_rate3 .='<td>'.$price_rate2.'</td>';
	
}
$queryNumber = '';
		
		$searchDataStr = base64_decode($searchData);
		//print_r($searchDataStr);exit;
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
		
		/*************************PrintPdf code End***************/
		//$startdate=$paramArr['startdate'];
		//$enddate=$paramArr['enddate'];
		
		$searchrooms=$paramArr['searchrooms'];
		
		$stayDuration=$paramArr['stayDuration'];
		$adults=$paramArr['adults'];
		$child=$paramArr['child'];
		$child_age=$paramArr['child_age'];
		//print_r($adults);exit;
		
		
		
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
		
		

		
		
		//package price //
		
		$roomPrices = array();

			$roomPriceByType = array();

			//print_r($paramArr);exit;

			$countRooms=count($adults);
			//echo $countRooms;exit;
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
				//echo "<pre>!!!!";
				//print_r($roomPriceByType['1']);
				//echo "<pre>@@@@@@";
                //$roomPriceByType1 = array("1"=>"2500","2"=>"2700","3"=>"650","4"=>"350","6"=>"650");
				//print_r($roomPriceByType1['1']);exit;
				//echo $roomPriceByType[1];exit;
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
					//print_r($RoomPriceCalculation);

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
		$profit=$sumArray2-$sumArray;
$adultP1=explode(",",$adultP);
$childp1=explode(",",$childp);
$j=1;
$k=0;
$s=0;
$data1='';
for($i=1; $i<=$room; $i++)
{
	$adultP = $adults[$k];
										$adultP1=implode(",",$adults);
										$childp = $child[$k];
										$childp1=implode(",",$child);
										if(is_array($child_age))
										{
											$childp_age = $child_age[$k];
											//$child_age2=$child_age[$i];
											//print_r($child_age2);
											//$childp_age1=explode(",",$child_age[$i]);
											//$childp_age2=implode(",",$child_age);
											
											
										}
										else
										{
											$childp_age = $child_age;	
										}
	
	//$romm_id=$i+1;
	$data1 .= '<tr>
				<td style="border: 1px solid #f4f4f4;padding: 8px;">'.$i.'</td>
				
				<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-male" aria-hidden="true"></i></span> '.$adultP.'</td>
				
				<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-child" aria-hidden="true"></i></span> '.$childp.'</td>
				
				
				<td style="border: 1px solid #f4f4f4;padding: 8px;">'.$childp_age.'</td>
				
				<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="roomPrice2_1">'.$dayPriceArr[0][$s+1].'</span></td>
			</tr>';
$j++;
$k++;
$s++;
}
	
$data='<div class="col-md-12">		
							<h3>Tour Cost</h3>	
							<div class="table-responsive">
							<form method="POST" id="tour_cost_data">
							<table class="table table-bordered" cellspacing="0" width="100%">
								<tbody>
								<tr><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Room</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Adult</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren)</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Child(ren) Age</th><th style="background:#4F80BD; color:#FFF;border: 1px solid #f4f4f4;">Price</th>
								</tr>
								
							    '.$data1.'
								
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">OC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice5">'.$sumArray.' </span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="totalHotelPrice5">'.$sumArray2.'</span></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">GST @ 5%</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span> <?php echo $rupeeSymbol; ?> <span id="serviceTax3">'.$gst.' </span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Total PC</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="grandTotal3">'.$total_profit.'</span></td>
								</tr>
								<tr style="font-size: 18px;font-weight: 600;">
									<td colspan="4" style="text-align:center;border: 1px solid #f4f4f4;padding: 8px;">Profit</td>
									<td style="border: 1px solid #f4f4f4;padding: 8px;"><span><i class="fa fa-inr" aria-hidden="true"></i></span><?php echo $rupeeSymbol; ?> <span id="profit3">'.$profit.' </span></td>
								</tr>
																	
					</tbody></table>
					</form>
			</div>	
			
		</div>';
//print_r($data);exit;
	//echo $costing3;exit;
    $template = "<html>";
	$template .='<div style="font:Tahoma, Geneva, sans-serif;  width:80%;">
<style>
.tab1{
	
	font-size:16px;
	font-family: "CALIFR", serif;

	text-align:right;
	width:50%;
	padding:5px;
	font-weight:bold;
	
	
}
.tab2{
	
	font-size:16px;

	text-align:left;
	width:50%;
	padding:5px;
	font-family: "CALIFR", serif;
	
	
}
.tr2{
	padding:20px;background:#f2f2f2;
}
</style>
	 <div>
	 <div style="padding:10px; margin-bottom:4px; height:30px;background:#4F80BD; box-shadow:2px 2px #F3F3F3; border:1px solid #F3F3F3; font-size:18px;"><strong style="color:#fff;">Hotel Confirmation Details for : '.$hotel1.'</strong></div>
	 
	 
      <table width="100%" style=""  cellpadding:5px; cellspacing="5px" >
      <tbody>
    <tr class="tr2">
      <td width="49%" class="tab1">Tour Card No :</td><td width="51%" class="tab2">'. $tc_no1.'</td>
      
      </tr>
   <tr class="tr2">
      <td class="tab1">Check In Date :</td><td class="tab2">'. $bkg_date1 .'</td>
      
      </tr>
    <tr class="tr2">
      <td class="tab1">Check Out Date :</td><td class="tab2">'. $bkg_date2.'</td>
      
      </tr>
	  <tr class="tr2">
      <td class="tab1">Nts :</td><td class="tab2">'. $nights.'</td>
      
      </tr>
	  
	   <tr class="tr2">
      <td class="tab1">Lead Pax Name :</td><td class="tab2">'. $pax_name1.'</td>
      
      </tr>
	   <tr class="tr2">
      <td class="tab1">Country :</td><td class="tab2">'. $country1.'</td>
      
      </tr>
	   <tr class="tr2">
      <td class="tab1">City :</td><td class="tab2">'. $city1.'</td>
      
      </tr>
	  <tr class="tr2">
      <td class="tab1">Room Type :</td><td class="tab2">'. $room_type1.'</td>
      
      </tr>
	  <tr class="tr2">
      <td class="tab1">Meal Plan :</td><td class="tab2">'. $meal_plan1.'</td>
      
      </tr>
	  
      </tbody>
      </table>
      
	 
	 
	 </div>';
	$template .='<table width="100%;"  border="1" cellspacing="3" cellpadding="3">
				<tbody><tr>
			     	'.$costing3.'
				
				</tr>
				<tr>
				'.$price_rate3.'
				</tr>
			</tbody></table>';
	$template .=$data;		
	$template .='<h3> Confirmation Link : </h3><a style="background:#0070DF; text-decoration:none; border-radius:5px; padding:10px; color:#fff;" href="https://software.lidtravel.com/hotel/">Link to Confirm</a>';		
    $template .="</html>";
    $mail = new PHPMailer(true);
    $mail->setFrom('admin@lidtravel.com', 'Hotel Confirmation Details');
    //$mail->addAddress('aman.bluethink@gmail.com', 'Aman Verma');
    //$mail->addAddress('management@lightsindark.in', 'New Hotel Registeration');
	$mail->addAddress('management@lightsindark.in', 'Hotel Confirmation Details');
	//$mail->addCC('sachin.bluethink@gmail.com'); 
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Hotel Confirmation Details';
    $mail->Body    = $template;
    if($mail->send()){
		return 1;
    }
}
?>