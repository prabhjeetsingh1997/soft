<?php
include('header.php');
include('sidebar.php');

$qn = '';
if(isset($_GET['qn']))
{
	$qn = $_GET['qn'];
}

if($_GET['action']=='edit')
{
	$editUserId=$_GET['id'];
	$usrData = $objAdmin->getUsrById($editUserId);

	//print_r($usrData);
}
$arrRoomType=$objhotel->getAllRoomType();
$arrRoom=$objhotel->getAllHotelRoom();
$arrItinerary=$objAdmin->getAllItinerary();
//print_r($arrRoomType);
?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Query Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Search Query</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="row">
			<div class="col-md-4">
			<div class="box box-default">
				
				<div id="status"></div>
				<div class="tab-content">
					<form role="form" method="POST" name="search_data" id="search_data">
					<!--<input type="hidden" name="extraAdult" id="extraAdult" value=""/>
					<input type="hidden" name="chWoBed" id="chWoBed" value=""/>
					<input type="hidden" name="chWBed" id="chWBed" value=""/>-->
					<input type="hidden" name="searchrooms" id="searchrooms" value="1"/>
					<input type="hidden" name="queryNumber" id="queryNumber" value="<?php echo $qn; ?>" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-12">
								<div class="form-group">
									<label for="userPhone">Query type</label>
									<select class="form-control" name="queryType" id="queryType">
										<option value="">Select</option>
										<option value="Hotel">Hotel</option>
										<option value="Package">Package</option>
										<option value="Other">Other</option>
										<!--<option value="Client">Client</option>
										<option value="Transporter">Transporter</option>
										<option value="Travel Agent">Travel Agent</option>-->
									</select>
								</div>
							</div>
							
							<div class="col-md-12 packageField">
								<div class="form-group">
									<label for="search">Country</label>
									<select class="form-control select2" name="country[]" id="country" multiple="multiple"> 
										<option value="">--Select Country--</option>
										
										<?php
											$arrcountery=$objAdmin->get_countery();
											foreach($arrcountery as $count)
											{ 
										?>	
											<option value="<?php echo $count['id']; ?>" <?php if($count['id'] == @$itineraryData[0]['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
										<?php		
											}
										?>	
													
									</select>
								</div>
							</div>
							<div class="col-md-12 packageField">
								<div class="form-group">
									<label for="search">State</label>
									<select class="form-control select2" name="state[]" id="state" multiple="multiple" data-placeholder="Select a State">
										<option value="">--Select State--</option>
										
									</select>
								</div>
							</div>
							
							<div class="col-md-12 packageField">
								<div class="form-group">
									<label for="search">City</label>
									<select class="form-control select2" name="city[]" id="city" multiple="multiple" data-placeholder="Select a City">
										<option value="">--Select City--</option>
									
										</select>
								</div>
							</div>
							
							
							<div class="col-md-12 hotelField" id="destinationDiv">
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
										<option value="<?php echo $cityArr[0]['id']; ?>"><?php echo ucfirst($cityArr[0]['city']); ?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-12" id="startdateDiv">
								<div class="form-group">
									<div class="form-group">
									<label for="query_no">Check-in</label>
									<div class='input-group date' >
									<input type='text' class="form-control" name="startdate" id="startdate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
							
							<div class="col-md-12" id="enddateDiv">
								<div class="form-group">
									<div class="form-group">
									<label for="query_no">Check-out</label>
									<div class='input-group date' >
									<input type='text' class="form-control" name="enddate" id="enddate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
						
							
							<div class="col-md-12" id="stayDurationDiv">
								<div class="form-group">
									<label for="userPhone">Nights</label>
									<select class="form-control" name="stayDuration" id="stayDuration">
										<option value="">Select</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
									</select>
								</div>
							</div>
							
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
									
									<div class="col-md-3" id="childAgeBox_1" style="display:none; padding-left:0">
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
										foreach($arrItinerary as $key=>$val){
										?>
										<option value="<?php echo $val['title'];?>"><?php echo $val['title'];?></option>
										<?php
										}
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
							<!-- forth Line -->
							
						</div>
					</div>
					<div class="box-footer">
						<button type="button" class="btn btn-primary" name="searchDataBtn" id="searchDataBtn">Search Hotel</button>
					</div>
				</form>
				
				
		
			</div>
		</div>
		</div>
		<div id="resultData">
		<div class="col-md-8">
			<div class="box box-default">
				<div class="box-header with-border">
					<div id="status1"></div>
					<div id="searchType" style="font-size:20px;border-bottom: 1px solid #EEE;padding-bottom: 5px;">
					<span>Hotel</span>
					
					<span id="hotel_rating" style="font-size:15px; float:right;">
						<div class="form-group form-inline">
							<label for="userPhone">Sort By Rating: </label>
							<select class="form-control" name="ratingFilter" id="ratingFilter">
							</select>
						</div>
					</span>
					<span id="hotelnameFilter" style="font-size:15px;float:right;margin-right: 20px;">
						<div class="form-group form-inline">
							<label for="userPhone">Search By Hotel Name: </label>
							<select class="form-control select2" name="nameSearch" id="nameSearch" data-placeholder="Search By Hotel Name">
								<option value="">--Select City--</option>
								<?php
									
									foreach($newCityArr as $key=>$val)
									{
										$city_name = $val['city'];
										$cityId = $val['id'];
										//print_r($val);
										foreach($arrCityId as $value)
										{
								?>
								<option value="<?php echo $cityId;?>" <?php if($value == $cityId){echo "selected";}?>><?php echo $city_name;?></option>
								<?php
										}
										
									}
								?>
							</select>
						</div>
						</span>
						
					</div>

					<div id="searchData" style="padding:15px 0;">
						
					</div>
				</div>
			</div>
		</div>
		</div>
			</div>
		</section>
	</div>
	<script>
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
			
			$("#queryType").change(function(){
				//alert("working");
				var qtype=$(this).val();
				//alert(qtype);
				if(qtype == 'Package'){
					$("#hotel_rating").hide();
					$("#hotelnameFilter").hide();
					$(".packageField").show();
					$(".hotelField").hide();
					$("#searchType span:first").html('Package');
					$("#searchDataBtn").html('Search Package');
				}else{
					$("#hotel_rating").show();
					$("#hotelnameFilter").show();
					$(".packageField").hide();
					$(".hotelField").show();
					$("#searchType span:first").html('Hotel');
					$("#searchDataBtn").html('Search Hotel');
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
					url:"_ajax_search_data.php?action=searchData",
					data:$("#search_data").serialize(),
					beforeSend:function(){
						
					},
					success:function(html){
						
						var htmlArr = html.split('$abc#$');
						
						$("#searchData").html(htmlArr[0]);
						$("#ratingFilter").html(htmlArr[1]);
						$("#nameSearch").html(htmlArr[2]);
					}
				});
			});
			
			$(document).on('change','#nameSearch',function(){
				var val = $(this).val();
				//alert(val);
				if(val == 'all')
				{
					$(".hotelBox").show();	
				}
				else{
					$(".hotelBox").hide();
					$("#hotel_"+val).show();
				}
			});
			
			$(document).on('change','#ratingFilter',function(){
				var val = $(this).val();
				//alert(val);
				if(val == 'all')
				{
					$(".hotelBox").show();	
				}
				else{
					$(".hotelBox").hide();
					$(".hotelrating_"+val).show();
				}
				
			});
			
			
			$("#country").change(function()
			{
				//alert("punamsaini");
				var id=$(this).val();
				
				var dataString = 'id='+ id;
				$("#state").find('option').remove();
				$("#city").find('option').remove();
				
				$.ajax
				({
					
					type: "POST",
					url: "_ajax_get_state.php",
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
				var dataString = 'id='+ id;
			
				$.ajax
				({
					type: "POST",
					url: "_ajax_get_city.php",
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
		<script src="asset/bootstrap-datepicker.js"></script>
<?php  include('footer.php');?> 