<?php 
	include('header.php');
	include('sidebar.php');

	$editHotelId='';
	$countRoom='';
	$roomPrice='';
	$extraBedPrice='';
	if($_GET['action']=='view')
	{
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

?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             View Hotel
			</h1>
		  
          <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Query List</li>
          </ol>-->
		  <form id="formData">
			<input type="hidden" name="hotelId" id="hotelId" value='<?php echo $editHotelId; ?>'>
			<input type="hidden" name="hotelDateId" id="hotelDateId" value='<?php echo $hotelDateId; ?>'>
			<input type="hidden" name="masterRoomArr" id="masterRoomArr" value='<?php echo serialize($arrMasterRooms); ?>'>
			<input type="hidden" name="arrRoomType" id="arrRoomType" value='<?php echo serialize($arrRoomType); ?>'>
			<input type="hidden" name="roomTypesPriceArr" id="roomTypesPriceArr" value='<?php echo serialize($roomTypesPriceArr); ?>'>
			<input type="hidden" name="searchDataStr" id="searchDataStr" value='<?php echo $searchData; ?>'>
			<input type="hidden" name="userSelectRoomTypes" id="userSelectRoomTypes" value=''>
		  </form>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
			<div class="col-md-12">
			<div class="box box-default">
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
					<div id="searchData" style="padding:15px 0;">
						<div style="border: 1px solid #DDD;padding: 10px;border-radius: 5px;float: left;width: 100%; margin-bottom:10px;">
						
							<div class="col-md-12">
								<div class="row" id="showQueryDetail">
									
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
								<div class="hotelDetail">
									<table class="table table-bordered">
										<tr>
											<td style="background:#4F80BD; color:#FFF;">Hotel Name</td>
											<td><?php echo $hotelName;?></td>
											<td style="background:#4F80BD; color:#FFF;">Hotel Address</td>
											<td><?php echo $hotAddress;?></td>
										</tr>
										<tr>
											<td style="background:#4F80BD; color:#FFF;">Start Category</td>
											<td><?php echo $hotelstar_rating;?> Star</td>
											<td style="background:#4F80BD; color:#FFF;">No. of Passengers</td>
											<td>
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
											<td style="background:#4F80BD; color:#FFF;">Check-in</td>
											<td><?php echo date('d, F Y',strtotime($startdate));?></td>
											<td style="background:#4F80BD; color:#FFF;">Check-out</td>
											<td><?php echo date('d, F Y',strtotime($enddate));?></td>
										</tr>
										<tr>
											<td style="background:#4F80BD; color:#FFF;">Nights</td>
											<td><?php echo $stayDuration;?> Night(s)</td>
											<td style="background:#4F80BD; color:#FFF;"> Rooms Required</td>
											<td><?php echo count($adults);?></td>
										</tr>
									</table>
									<!--<p><strong>Hotel:</strong> <?php echo $hotelName;?></p>
									<p><strong>Destination:</strong> <?php echo $destination;?></p>
									<p><strong>Check-in:</strong> <?php echo date('d, F Y',strtotime($startdate));?></p>
									<p><strong>Check-out:</strong> <?php echo date('d, F Y',strtotime($enddate));?></p>
									<p><strong>Duration:</strong> <?php echo $stayDuration;?> Night(s)</p>
									<p><strong>No. of Passengers:</strong> 
										
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
									</p>
									<p><strong> Rooms Required:</strong> <?php echo count($adults);?></p>
								</div>
								<?php
									//print_r($hotelData);
									$hotelAddr = $objhotel->getHotelAddress($editHotelId);
									//print_r();
								?>
								<p><span style="font-size: 16px;font-weight: 600;">Hotel:</span> <?php echo $hotelName;?></p>
								<p><span style="font-size: 16px;font-weight: 600;">Hotel Location:</span> <?php echo $hotelAddr['address1'].' '.$hotelAddr['address2'];?></p>
								<p><span style="font-size: 16px;font-weight: 600;">Start Rating:</span> <?php echo $star_rating;?> Star</p>-->
								
								<h3>Costing </h3>	
								<table class="table table-bordered">
									<tr>
										<th style="background:#4F80BD; color:#FFF;">Room</th>
										<th style="background:#4F80BD; color:#FFF;">Adult</th>
										<th style="background:#4F80BD; color:#FFF;">Child(ren)</th>
										<th style="background:#4F80BD; color:#FFF;">Child(ren) Age</th>
										<th style="background:#4F80BD; color:#FFF;">Select Room Type</th>
										<th style="background:#4F80BD; color:#FFF;">Price</th></tr>
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
											<td><?php echo $i+1; ?></td>
											<td><span><i class="fa fa-male" aria-hidden="true"></i></span> <?php echo $adultP; ?></td>
											<td><span><i class="fa fa-child" aria-hidden="true"></i></span> <?php echo $childp; ?></td>
											<td><?php echo $childp_age; ?></td>
											<td>
												<select class="form-control userRoomTypes" id="class<?php echo $i+1; ?>">
													<?php echo $roomTypeStr; ?>
												</select>
											</td>
											<td><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="roomPrice_<?php echo $i+1; ?>"><?php echo $price; ?></span></td>
										</tr>
										<?php	
										}
									?>
									<tr>
										<td colspan="5" style="text-align:center;">Sub Total</td>
										<td><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="totalHotelPrice"></span></td>
									</tr>
									<tr>
										<td colspan="5" style="text-align:center;">Govt. Service Tax @ 9%</td>
										<td><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="serviceTax"></span></td>
									</tr>
									<tr style="font-size: 18px;font-weight: 600;">
										<td colspan="5" style="text-align:center;">Grand Total</td>
										<td><span><i class="fa fa-inr" aria-hidden="true"></i></span> <span id="grandTotal"></span></td>
									</tr>
							</table>
							<div style="clear:both"></div>
							<h3>Inclusions:</h3>
							<ul>
								<li>Welcome drinks on Arrival at hotel/resort. (Non alcoholic)</li>
								<li>Accommodation as per above details.</li>
								<li>Daily Breakfast. (except on the day of arrival)</li>
								<li>All kind of applicable hotel, transport, service &amp; govt. taxes.</li>
							</ul>
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
			</div>
		</div>
    </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
	  <script>
      $(function () {
        $('#example1').DataTable({
          "paging"      : true,
          "lengthChange": true,
          "searching"   : true,
          "info"        : true,
          "autoWidth"   : false,
		  "bSort"       : false,
		  
        });
		
		//alert(userRooms);
		selected_roomTypes();
		calculate_price();
		
		$(".userRoomTypes").change(function(){
			selected_roomTypes();
			calculate_price();
		});
		
		$("#searchQueryBtn").click(function(){
			var query = $("#queryNumber").val();
			if(query == '')
			{
				alert('Please Enter query first');
			}
			else
			{
				var data = 'query='+query;
				$.ajax({
					type:"POST",
					url:"_ajax_search_data.php?action=getQueryDetail",
					data:data,
					beforeSend:function(){
						
					},
					success:function(html){
						$("#showQueryDetail").html(html);
					}
				});
			}
		});
		
		
		var queryNumb = '<?php echo $queryNumber; ?>';
		if(queryNumb != '')
		{
			$("#searchQueryBtn").click();
		}
		
		
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
	}	
	
	function calculate_price()
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getPrice",
			data:$("#formData").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				
				var obj = JSON.parse(html);
				console.log(obj);
				
				var totalRooms = $(".userRoomTypes").length;
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
			}
		});
	}
	
	
    </script>
     <?php include('footer.php');?>