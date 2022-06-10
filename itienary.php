<?php
include('header.php');
include('sidebar.php');

$newCityArr=array();
$j=0;
if($_GET['action']=='edit')
{
	$editItinId=$_GET['id'];
	
	$itineraryData=$objAdmin->getItineraryDataByid($editItinId);
	//print_r($itineraryData);
	$duration=$itineraryData[0]['duration'];
	$duration_city = $itineraryData[0]['duration_city'];
	$countryId=$itineraryData[0]['country'];
	$stateId=$itineraryData[0]['state'];
	$cityId=$itineraryData[0]['city'];
	$arrStateId=explode(',',$stateId);
	$arrCityId=explode(',',$cityId);
	//print_r($arrCityId);
	$arrState=$objAdmin->get_state($countryId);
	foreach($arrStateId as $value)
	{
		$cityName=$objAdmin->get_city($value);
		foreach($cityName as $newCity)
		{
			$newCityArr[$j] = $newCity;
			$j++;
		}
	}
	
	//print_r($arrCity);
}

$arrcountery=$objAdmin->get_countery();
//print_r($itineraryData);
$vehicleCost = $objhotel->getIteneraryVehicleCost($editItinId);
//print_r($vehicleCost);
?>
<style>
.vehicle_cost>td>input{width:65px;}
td{text-align:center;}
</style>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Itinerary Management 
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Itinerary Management </li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">			
				<div class="box-header with-border">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>Itinerary Management Form</b></h3></a></li>
				  
				</ul>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
				<form role="form" method="POST" name="itinerary_management" id="itinerary_management">
				<input type="hidden" name="type" value="add_itinerary_management" >
				<input type="hidden" name="editId" id="editId" value="<?php echo @$itineraryData[0]['id'];?>" >
				<div class="box-body">
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	 Country<span style="color:red;">*</span></b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="name">Country</label>-->
										
										<select class="form-control select2" name="country[]" id="country" multiple="multiple" data-placeholder="Select a Country"> 
										<option value="">--Select Country--</option>
									
										<?php
											foreach($arrcountery as $count)
											{ 
										?>	
											<option value="<?php echo $count['id']; ?>" <?php if($count['id'] == @$itineraryData[0]['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
										<?php		
											}
										?>	
													
										</select>
									</div>
								</div><!-- /.form-group -->
								<span id="loding1">
									<div class="col-md-2">
										<div class="form-group">
											<h4  class="box-title"><b style="font-size: 17px;">	 State<span style="color:red;">*</span></b></h4>
										</div>
									</div>
								
									<div class="col-md-10">
										<div class="form-group">
											<!--<label for="name">State</label>-->
											
											<select class="form-control select2" name="state[]" id="state" multiple="multiple" data-placeholder="Select a State">
											<option value="">--Select State--</option>
											<?php
												foreach($arrState as $key=>$val)
												{
													foreach($arrStateId as $value)
													{
													
											?>
												<option value="<?php echo $val['id'];?>" <?php if($value == $val['id']){echo "selected";}?>><?php echo $val['state_name'];?></option>
											<?php
													}
												}
											?>
											</select>
										</div>
									</div>
								</span><!-- /.form-group -->
							<span id="loding2" >
								<div class="col-md-2">
									<div class="form-group">
										<h4  class="box-title"><b style="font-size: 17px;">	 City<span style="color:red;">*</span></b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<!--<label for="name">City</label>-->
										<select class="form-control select2" name="city[]" id="city" multiple="multiple" data-placeholder="Select a City">
										<option value="">--Select City--</option>
										<?php
											
											foreach($newCityArr as $key=>$val)
											{
												$city_name = $val['city'];
												$cityId = $val['id'];
												//print_r($val);
												//foreach($arrCityId as $value)
												//{
													in_array($cityId, $arrCityId)
										?>
										<option value="<?php echo $cityId;?>" <?php if(in_array($cityId, $arrCityId)){ echo "selected"; } ?>><?php echo $city_name;?></option>
										<?php
												//}
												
											}
										?>
										</select>
									</div>
								</div><!-- /.form-group -->
							</span>
								<!--<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	 Region </b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
								
										<input type="text" class="form-control" name="region" id="region" placeholder="Region" value="<?php echo @$itineraryData[0]['region'];?>"/>
									</div>
								</div><!-- /.form-group -->
						<div class="col-md-2">
							<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	 Title<span style="color:red;">*</span></b></h4>
							</div>
						</div>
						
						<div class="col-md-10">
							<div class="form-group">
								<!--<label for="name">Title</label>-->
								<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo @$itineraryData[0]['title'];?>"/>
							</div>
						</div><!-- /.form-group -->
						<div class="col-md-2">
							<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	</b></h4>
							</div>
						</div>
						
						<div class="col-md-10">
							<div class="form-group">
								<!--<label for="name">Title</label>-->
								<input type="text" class="form-control" name="iteDurationDetail" id="iteDurationDetail" placeholder="Detail" value="<?php echo @$itineraryData[0]['duration_detail'];?>"/>
							</div>
						</div><!-- /.form-group -->
						<div class="col-md-2">
							<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	 Itinerary </b></h4>
							</div>
						</div>
						
						<div class="col-md-10">
							<div class="form-group">
								<!--<label for="name">Itinerary </label>-->
								<textarea class="form-control" name="itinerary" id="itinerary" rows="4" cols="50"><?php echo @$itineraryData[0]['itinerary'];?></textarea>
							</div>
						</div><!-- /.form-group -->
						<div class="col-md-2">
							<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	 Vehicle Cost</b></h4>
							</div>
						</div>
						
						<div class="col-md-10">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
										<tr>
											<?php
												$vehArr=$objAdmin->get_vehicleitinerary();
												foreach($vehArr as $vehiCle)
												{
											?>
											<td><?php echo $vehiCle['vehicle_name']; ?></td>
											<?php
												}
											?>
										</tr>
										<tr class="vehicle_cost">
											<?php
												$costArr = array();
												foreach($vehicleCost as $cost)
												{
													/* print_r($cost);
													echo '<br/>'; */
													$costArr[$cost['vehicle_id']][] = $cost['id']; 
													$costArr[$cost['vehicle_id']][] = $cost['cost']; 
													/* if($vehiCle['id'] == $cost['vehicle_id'])
													{
														$CostVal = $cost['cost'];
													} */
												}
												//print_r($costArr);	
												$vcostId = '';
												$cost = '';
												foreach($vehArr as $vehiCle)
												{
													/* foreach($vehicleCost as $cost)
													{
														if($vehiCle['id'] == $cost['vehicle_id'])
														{
															//$CostVal = $cost['cost'];
														}
													} */
													
													$vcostId = $costArr[$vehiCle['id']][0];
													$cost = $costArr[$vehiCle['id']][1];
													
											?>
												<td><input type="text" name="cost_<?php echo $vehiCle['id']; ?>" value="<?php echo $cost; ?>" />
												<input type="hidden" name="vehcostId_<?php echo $vehiCle['id']; ?>" value="<?php echo $vcostId; ?>" />
												</td>
											<?php
												}
											?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">	 Interests Cost</b></h4>
							</div>
						</div>
						
						<div class="col-md-10">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
										<tr class="vehicle_cost">
											<td>Interest Name</td>
											<?php
												$IteneryCost = $objhotel->getIteneraryInterestCost($editItinId);
												//print_r($IteneryCost);
												for($i=1; $i<10; $i++)
												{
													$j = $i-1;
											?>
											<td>
											<input type="text" name="intName_<?php echo $i; ?>" value="<?php echo $IteneryCost[$j]['interest_name']; ?>" />
											<input type="hidden" name="intrestCostid_<?php echo $i; ?>" value="<?php echo $IteneryCost[$j]['id']; ?>" />
											</td>
											<?php
												}
											?>
										</tr>
										<tr class="vehicle_cost">
											<td>Interest Cost</td>
											<?php
												for($i=1; $i<10; $i++)
												{
													$j = $i-1;
											?>
												<td><input type="text" name="intCost_<?php echo $i; ?>" value="<?php echo $IteneryCost[$j]['cost']; ?>" /></td>
											<?php
												}
											?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	 Duration</b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<!--<label for="name">Title</label>-->
									<input type="number" class="form-control" name="duration" id="duration" placeholder="Duration" value="<?php echo @$itineraryData[0]['duration'];?>"/>
								</div>
							</div>
							<div class="col-md-2" id="durationDays">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;"> Days</b></h4>
								</div>
							</div>
							<div class="col-md-10" id="durationTable">
								
							</div>	
								
						
						</div><!-- /.form-group -->
					</div><!-- /.form-group -->
					<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="itinerary_management" id="submit"><?php if(!empty($_GET['id'])){echo "UPDATE";}else{echo "SUBMIT";}?></button>
						</div>
					</form>			
						</div>
				</div>
				</div>	
			
		</section>
	</div>
	<script src="ckeditor_4.4.5_full/ckeditor/ckeditor.js" type="text/javascript"></script>	
<script src="asset/bootstrap-datetimepicker.js"></script>
	   <!-- <script src="asset/jquery.timepicker.js"></script>
	    <script src="asset/bootstrap/css/jquery.timepicker.css"></script>-->	
	<script>
	$(function(){
	CKEDITOR.replace('itinerary');	
	});
$(document).ready(function()
{
	showdurationTable(<?php echo $duration; ?>);
	
	var editDurationCity = '<?php echo $duration_city; ?>';
	var editCities = editDurationCity.split(',');
	//alert(editDurationCity+':::'+editCities);
	
	var i=1;
	$(".durationDrop").each(function(){
		//alert($(this).val());
		$("#tblCity_"+i).val(editCities[i-1]);
		i++;
	});
	
	$(".select2").select2();
	//alert("saini");
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
	
	$("#duration").keyup(function(){
		var val = $(this).val();
		showdurationTable(val);
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

function showdurationTable(number)
{
	var state = $("#state").val();
	var editId = $("#editId").val();
	//alert(number);
	if(number == '' || number == '0')
	{
		$("#durationDays").hide();	
		$("#durationTable").html('');	
	}
	else{
		var dataString = 'num='+ number+'&states='+state+'&iteneraryId='+editId;
		$.ajax
		({
			type: "POST",
			url: "_ajax_get_pakage_detail.php?action=getDurationTable",
			data: dataString,
			cache: false,
			async: false,
			success: function(html)
			{
				$("#durationTable").html(html);
				$("#durationDays").show();		
			} 
		});
	}
}

</script>
<script>

	$("#itinerary_management").validate({
		
			rules: {
				'country[]': "required",			
				'state[]': "required",			
				'city[]': "required",			
				title: "required",			
				title: "required"			
			},
			submitHandler: function() { 
				for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_itinerary_management.php",
					data: $("#itinerary_management").serialize(),
					cache: false,
					beforeSend:function(){
						
					},
					success: function(msg)
					{
						if(msg == 1){
							
							$("#status").show().html('<div class="alert alert-success">Saved Succefully</div>');
							
							window.setTimeout(function() {
								window.location.href = 'itienarylist.php';
							}, 2000); 
							
						}else{
							
							$("#status").show().html('<div class="alert alert-danger">Problem in Sending Data</div>');
							
						}
					}
				}); 
			}
		});
	</script>		    
		
		
		
<?php  include('footer.php');?> 