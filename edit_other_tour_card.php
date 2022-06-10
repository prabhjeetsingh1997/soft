<?php 
include('header.php');
	include('sidebar.php');
	if($_GET['action']=='edit')
	{
	 $id=$_GET['id'];
	 $queryType=$_GET['queryType'];
	 $arr_query=$objAdmin->getAllotherTourcard_info($id,$queryType);
	 $arr1=json_decode($arr_query['from_date']);
	 $arr2=json_decode($arr_query['to_date']);
    }

    $url= trim($_SERVER['HTTP_HOST'], '/');
    if (!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
	$partner_hotel = $objAdmin->getpartnerHotel($domain);
    $travel_hotel = $objAdmin->gettravel_name($domain);
    $part_travel_array=array_merge($partner_hotel,$travel_hotel);

?>
<style>
table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 1px solid #f4f4f4;
    width: 300px;
}
</style>
<div class="content-wrapper">
	<input type="hidden" id="room_type_id" value="<?php echo $room_type_name; ?>" />
		<table class="table table-bordered">
		 <form method="POST" id="tour_card_data">
    <thead>
      <tr>
        <th>Tour Card No:</th>
		  <th><input type="text" value="<?php echo  $arr_query['query_no'] ?>" name="tc_no" id="name_qry" />
		   <input type="hidden" name="query_no" id="query_no" value="<?php echo  $arr_query['query_no'] ?>" />
		  </th>
    
        <th>Bkg Date</th>
		<th><input class="form-control" name="bkg_date" type="date" value="<?php echo  $arr_query['bkg_date'] ?>" /></th>
		<th>Bkg. By</th>
		<th><input class="form-control" name="bkg_by" id="bkg_by" type="text" value="<?php echo $_SESSION['first_name'] ?> <?php echo $_SESSION['middle_name'] ?> <?php echo $_SESSION['last_name'] ?>"/></th>
		<th>Bkg Type:</th>
		<th style="width:100px;"><select class="form-control" onchange="my_fun()" name="queryType" id="queryType"><option value="Other">Other</option></select></th>
		
      </tr>
	   <tr>
	   <th>Lead Pax Name:</th>
        <th style="width:100px;"><select name="name_prefix" class="form-control">
		<option>Mr.</option>
		<option>Mrs.</option>
		<option>Miss.</option>
		
	  </select></th>
        <th colspan="2"><input type="text" value="<?php echo $arr_query['pax_name'] ?>" name="pax_name" class="form-control" id="" /></th>

		<th colspan="1">Nationality</th>
		<th colspan="3"><select name="country1" class="form-control">
		<?php
											$arrcountery=$objAdmin->get_countery();
											foreach($arrcountery as $count)
											{ 
										?>	
											<option value="<?php echo $count['id']; ?>" <?php if($count['id']==$arr_query['country']){echo "selected";}?>><?php echo $count['country_name']; ?></option>
										<?php		
											}
										?>	
		
	  </select></th>
		
	   </tr>
	   <tr>
	   <th>Party:</th>
        <th><select class="form-control" name="party" id="">
		         <option><?php echo $arr_query['party'] ?></option>
				
				
		
	  </select></th>
		<th></th>
		<th></th>
		<th>File No</th>
        <th><input type="text" name="file_no" value="<?php echo  $arr_query['file_no'] ?>" class="form-control" /></th>
		<th>Invoice No.</th>
		<th colspan="2"><input name="invoice_no" value="<?php echo  $arr_query['invoice_no'] ?>" class="form-control" type="text" disabled/></th>
		
		
	   </tr>
	   
	  <input type="hidden" name="grand_total_hotel" id="grand_total_hotel" value="<?php echo $arr_query_tour_card_det['grand_total'] ?>"/>
	 
	  <input type="hidden" name="hotel_selected_rooms" id="hotel_selected_rooms" />
	  <input type="hidden" name="hotel_meal_plans" id="hotel_meal_plans" />
	  <input type="hidden" name="calculated_hotel_prices" id="calculated_hotel_prices" value="<?php echo $room_sub_total_hotel_price1; ?>" />
	  <input type="hidden" name="pricemargin_hotel" id="pricemargin_hotel" value="<?php echo $arr_query_tour_card_det['margin_percent'] ?>"/>
	   
	  <input type="hidden" name="calculate_package_price" id="calculate_package_price"  />
	  <input type="hidden" name="selected_package_hotels" id="selected_package_hotels" />
	  <input type="hidden" name="selected_package_rooms1" id="selected_package_rooms1" /> 
	  <input type="hidden" name="selected_package_mealPlans1" id="selected_package_mealPlans1" /> 
	  <input type="hidden" name="selected_package_mealPlans1_name" id="selected_package_mealPlans1_name" /> 
	  <input type="hidden" name="vehicle_package_cost" id="vehicle_package_cost" value="<?php echo $arr_query_tour_card_det['vehicle_package_cost'] ?>" /> 
	  <input type="hidden" name="no_of_package_vehicle" id="no_of_package_vehicle" value="<?php echo $arr_query_tour_card_det['no_of_package_vehicle'] ?>" />
	  <input type="hidden" name="vehicle_name" id="vehicle_name" value="<?php echo $arr_query_tour_card_det['vehicle_name'] ?>" />
	  <input type="hidden" name="employee_id" value="<?php echo $_SESSION['admin_Email'] ?>"/> 
	  <input type="hidden" name="package_id_page" value="<?php echo $_GET['id'] ?>" />
	  <input type="hidden" name="userSelectRoomTypes1" id="userSelectRoomTypes1" value='<?php echo $room_type_id2 ?>'>
	  <input type="hidden" name="userSelectMealTypes1" id="userSelectMealTypes1" value='<?php echo $meal_plan_id2; ?>'> 
	  <input type="hidden" name="choosen_pack" id="choosen_pack" value='<?php echo  $arr_query_tour_card_det['choosen_pack']; ?>'> 
	   <input type="hidden" name="userSelectRoomTypes5" id="userSelectRoomTypes5" value=''>
	  <input type="hidden" name="userSelectMealTypes5" id="userSelectMealTypes5" value=''> 
	   <input type="hidden" value="<?php echo $hotel_markup; ?>" id="hotel_markup" />
	   <input type="hidden" value="<?php echo $package_markup; ?>" id="package_markup" />
    </thead>
  </form>   
  </table>
 

	<form role="form" method="POST" name="search_data" id="search_data">
					<input type="hidden" name="searchrooms" id="searchrooms" value="1"/>
					<input type="hidden" name="queryNumber" id="queryNumber" value="<?php echo $qn; ?>" />
					  <input type="hidden" value="<?php echo $domain; ?>" name="domain" />
					<div class="box-body">
						<div class="row">
					</div>
					</div>
					<div class="">
					<div class="col-md-6 text-left" >
					<span id="hotelnameFilter">
						<div class="form-group form-inline package_new_hotel" style="display:none;">
							<label for="userPhone">Hotel Name: </label>
							<select class="form-control" style="width:30%;" name="nameSearch" id="nameSearch" data-placeholder="Search By Hotel Name">
								<option value="hotel names">Hotel Names</option>
							</select>
							
						</div>
						</span>
						<div style="display:none;" id="me2"><img src="progress_bar.gif" /></div>
					</div>
					<div class="col-md-6 text-left" >
					<span id="hotelnameFilter">
						<div class="form-group form-inline package_new_hotel1" style="display:none;">
							<label for="userPhone">Hotel Name: </label>
							<select class="form-control" style="width:30%;" name="nameSearch1" id="nameSearch1" data-placeholder="Search By Hotel Name">
								<option value="hotel names">Hotel Names</option>
							</select>
							
						</div>
						</span>
						<div style="display:none;" id="me2"><img src="progress_bar.gif" /></div>
					</div>
					
					
                    <div class="col-md-6 text-left" >
					<span id="hotelnameFilter">
						<div class="form-group form-inline package_new" style="display:none;">
							<label for="userPhone">Package Name: </label>
							<select class="form-control" style="width:30%;" name="package_search" id="package_search" data-placeholder="Search By Package Name">
								<option value="hotel names">Package Names</option>
							</select>
							
						</div>
						</span>
						<div style="display:none;" id="me3"><img src="progress_bar.gif" /></div>
					</div>
                     				
					</div>
				</form>
				<form role="form" method="POST" name="other_hotel" id="other_hotel">
					<div class="col-md-12">
						<div class="col-md-3">
							<div class="form-group">
								<label for="adults">No. of Adults</label>
								<input type="hidden" name="page_id" value="<?php echo $id ?>" />
								<input type="text" class="form-control" value="<?php echo  $arr_query['adult'] ?>" name="adults" placeholder="Enter No of adults">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="kids">No. of kids</label>
								<input type="text" class="form-control" value="<?php echo  $arr_query['children'] ?>" name="kids" placeholder="Enter No. of kids">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="adults">Kids Age</label>
								<input type="text"  value="<?php echo  $arr_query['child_age'] ?>" class="form-control" name="kids_age" placeholder="Enter kids Age">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="adults">Add Margin (%)</label>
								<input type="text" class="form-control" value="<?php echo  $arr_query['margin'] ?>" name="other_margin" id="other_margin" placeholder="Enter margin">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="adults">GST (%)</label>
								<input type="text" class="form-control" value="<?php echo  $arr_query['gst'] ?>" name="gst" id="other_gst" placeholder="Enter value">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						 <div class="box-body table-responsive">
                  			<table id="other_table" class="table table-bordered table-striped">
								<tr style="background: #3c8dbc;">
									<th class="col-md-2">City</th>
									<th class="col-md-3">Particulars</th>
									<th  class="col-md-1">Hotel</th>
									<th class="col-md-1">Check In</th>
									<th class="col-md-1">Check Out</th>
									<th class="col-md-2">Vendor</th>
									<th class="col-md-1">Cost</th>
									<th class="col-md-1"><div class="col-md-6 text-right" style="font-size: 21px; cursor:pointer" id="add_more_other_details">
											<i class="fa fa-plus-circle" aria-hidden="true"></i>
										</div></th>
								</tr>
								<input type="hidden" name="count_row" value='1' id="count_row">
								<?php foreach ($getHotelcities as $hcity) {
									 $cityArr1[] = $objhotel->getCitiesById($hcity['city']);
								} ?>
								<tbody id="other_hotel_details">
									<?php 
									$k=0;
									$cities = json_decode($arr_query['city']);
									$particulars = json_decode($arr_query['particulars']);
									$hotel_filter = json_decode($arr_query['hotel_filter']);
									$hotel = json_decode($arr_query['hotel']);
									$price = json_decode($arr_query['price']);
									foreach($cities as $city) { 
									?>
									<tr>
									<td class="col-md-2">
									
										<select  class="form-control other_destination" name="other_destination[]" style="width:100%;">
											<option value="">Select City</option>
											<?php
											$cityArr4[] = $objhotel->getCitiesById1();
													$cityArr = $objhotel->getCitiesById1();
													foreach($cityArr as $cityArr3)
												{
												$sel='';
												if($city==$cityArr3['id'])
												{
													$sel='selected';
												}
												else
												{
													$sel='';
												}
												
											?>
											<option <?php echo $sel ?> value="<?php echo $cityArr3['id']; ?>"><?php echo ucfirst($cityArr3['city']); ?></option>
											<?php
												}
											?>
										</select>
									</td>
									<td class="col-md-3">
										<div class="form-group">
											<input type="text" class="form-control" name="other_particulars[]" placeholder="Enter particulars" value="<?php echo $particulars[$k] ?>">
										</div>
									</td>

						           	<td class="col-md-1">
									 	<select class="form-control hotel_filter" name="hotel_filter[]">
									 		<?php
									 
									 		$hotel_filter_name = $objAdmin->getHotelFilterName($cities[$k]);
                                             foreach ($hotel_filter_name as $hotel_filter_name1) {
                                             	$sel ='';
                                             	if($hotel_filter[$k]==$hotel_filter_name1['hotel_id'])
                                             	{
                                             		$sel .="selected";
                                             	}
                                             	else
                                             	{
                                             		$sel ='';
                                             	}
                                             ?>
                                             	<option <?php echo $sel; ?> value="<?php echo $hotel_filter_name1['hotel_id']; ?>"><?php echo $hotel_filter_name1['hotel_name'];  ?></option>
                                             	<?php	
                                             }
									 		?>
										</select>
								
									</td>


									<td class="col-md-1">
										
									<input type="date" class="form-control" name="from_date[]" value="<?php echo  $arr1[$k] ?>"/>
									
                                    </td>
                                    <td class="col-md-1">
                                    	
                                    <input type="date" class="form-control" name="to_date[]" value="<?php echo $arr2[$k] ?>" />
                                    
                                    </td>

									<td class="col-md-2">
										<select class="form-control" name="partner_hotel[]" id="partner_hotel">
											<option value="" selected>Select Vendor</option>
											<?php
											$i=0;
											//print_r($part_travel_array);exit;
											if (!empty($part_travel_array)) {
											 	foreach ($part_travel_array as $photel) { 
												
												if($photel['hotel_name']!="")
												{
												$sel1='';
												if($hotel[$k]==$photel['hotel_name'])
												{
													$sel1='selected';
												}
												else
												{
													$sel1='';
												}
												?>
											 	<option <?php echo $sel1; ?> value="<?php echo $photel['hotel_name']; ?>"><?php echo $photel['hotel_name'];  ?></option>	
												
											<?php 
												}
												
													$i++;
												}
											 } 
											?>
										</select>
									</td>
									<td class="col-md-1">
										<div class="form-group">
											<input type="text" class="form-control" name="other_cost[]" value="<?php echo $price[$k]; ?>" placeholder="Enter Cost" id="other_cost" onkeyup="calculate_other_price();">
										</div>
									</td>
									<td class="col-md-1">
										<div class="col-md-6" style="font-size: 21px; color: red;display: none; cursor:pointer" id="other_remove">
											<i class="fa fa-minus-circle" aria-hidden="true"></i>
										</div>
									</td>
									</tr>
									<?php
									$k++;
									}
									?>
									
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
						<label style="float: right;font-size: 18px;">CGST / SGST :</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="">
								<input type='radio' class='' name="cgst" id="" value="cgst" style="">
								<input type='hidden' class='' name="cgst1" id="cgst2" value="" style="">
								<span style="font-size:18px;" id="cgst1"></span>
								
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-10">
						<label style="float: right;font-size: 18px;">IGST :</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="total_oc_div">
								<input type='radio' class='' name="cgst" id="" value="igst" style="">
								<input type='hidden' class='' name="igst1" id="igst2" value="" style="">
								<span style="font-size:18px;" id="igst1"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
						<label style="float: right;font-size: 18px;">GST AMOUNT :</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="">
								<input type='text' class='from-control' name="gst_amount" id="gst_amount" value="" style="">
								
								
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
							<label style="float: right;font-size: 18px;">OC :</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="total_oc_div">
								<input type='text' readonly class='form-control' name="total_oc" id="total_oc" value="0" style="display: none;">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
							<label style="float: right;font-size: 18px;">PC :</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="total_pc_div">
								<input type='number'  class='form-control' name="total_pc" id="total_pc" value="0" >
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
							<label style="float: right;font-size: 18px;">GST @<span id="gts_percent"><?php echo  $arr_query['gst'] ?></span>% :</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="total_gst_div">
								<input type='text' readonly class='form-control' name="other_gst1" id="other_gst1" value="0" style="display: none;">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
							<label style="float: right;font-size: 18px;">Total PC:</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="total_gst_div">
								<input type='text' readonly class='form-control' name="total_all_pc" id="total_all_pc" value="0" style="display: none;">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-10">
							<label style="float: right;font-size: 18px;">Profit:</label>
						</div>
						<div class="col-md-2">
							<div class="form-group" id="total_gst_div">
								<input type='text' readonly class='form-control' name="profit" id="profit" value="0" style="display: none;">
							</div>
						</div>
					</div>
				</form>
			
				
				
				
				
		<div id="resultData">
		<div class="col-md-12">
			<div class="">
				<div class="">
					<div id="status1"></div>
					<div id="search_data1">
					</div>
					<div id="package_data1">
					</div>

					<div id="searchData" style="padding:15px 0; display:none;">
						
					</div>
					  
					
					<div id="searchpack"></div>
				</div>
			</div>
		</div>
		</div>
		
				
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
		
			<?php 
				if($type != 'pdf')
				{
			?>
			<div class="">
				<div id="status1"></div>
				<div id="searchType" style="font-size:20px;padding-bottom: 5px;"><?php //echo $itiTitle;?></div>
					
					<input type="hidden" name="userSelectRoomTypes" id="userSelectRoomTypes1" value=''>
					<input type="hidden" name="userSelectHotel" id="userSelectHotel" value=''>
					<input type="hidden" name="userSelectedMealPlans" id="userSelectedMealPlans1" value=''>
					<input type="hidden" name="totalBookingRooms" id="totalBookingRooms" value="<?php echo $searchrooms; ?>">
					<input type="hidden" name="itineryDuration" id="itineryDuration" value="<?php echo $itineraryData['duration']; ?>">
					
				<div class="col-md-12" style="margin-top:10px; padding:0">
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
			
			<div class=" text-right">
				<input type="hidden" id="calculated_prices1" value="" />
				<input type="hidden" id="selected_hotels" value="" />
				<input type="hidden" id="selected_rooms" value="" />
				<input type="hidden" id="selected_mealPlans" value="" />
				<input type="hidden" id="selectedVehicle" value="" />	
			</div>
			
			
		</div>
		</div>
	
	  </div>
	</section>
</div><!-- /.row --><!-- /.row -->

    
      <div class="modal-footer">
	  <button type="button" class="btn btn-primary" id="tc_submit">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
			//alert('hello');
			$("#qDetail1").modal();
			var del_id = element.attr("rel");
			//alert(del_id);
			var res = del_id.substring(6);
			var bkg_by=document.getElementById("bkg_by").value;
			var prnsl_client_id=document.getElementById("prnsl_client_id").value;
			$("#name_qry").val("lidtc0"+res);
			$("#query_no").val(del_id);
			
			$.ajax({
            type: 'POST',
            data: {per_id:del_id,cli_id:prnsl_client_id},
            url:"_ajax_search_data1.php?action=lead_pax_name",
            success: function(html)
            {
			
            }
        });
			
		});
	function areyousure()
	{
		if(confirm('Are you sure.'))
		{
			
		}else {
			
			return false;
		}
	}
    </script>
    

     <style type="text/css">
    

ul.pagenili li {
    float: left;
        padding: 6px 12px;
        border: 1px solid #ddd;
}
ul.pagenili {
    list-style: none;
    padding: 0;
    display: inline-block;
}

ul.pagenili li:first-child {
    background: #337ab7;
    color: #fff;
    border-color: #337ab7;
}

ul.pagenili li:first-child a {
    color: #fff;
}
     </style>

    <script>
	$(document).on('click','#tc_submit',function(){
				
			var type = $("#queryType").val();
			if (type != 'Other') {
				$.ajax({
					type:"POST",
					url:"_ajax_search_data1.php?action=tour_card",
					data:$("#tour_card_data,#search_data").serialize(),
					    
					beforeSend:function(){
						
					},
					success:function(html){
						
						alert('Data submitted');
						location.reload();
						
					}
				});
			}else{
				$.ajax({
					type:"POST",
					url:"_ajax_search_data1.php?action=other_edit_tour_card",
					data:$("#tour_card_data,#other_hotel").serialize(),
					    
					beforeSend:function(){
						
					},
					success:function(result){
						console.log("@@@@@@"+result);
						if (result == 1) {
							alert('Data submitted');
							location.reload();
						}else{
							alert('There is something problem! Please try again later');
							location.reload();
						}
						
						
					}
				});
			}
			});
	
		$(document).on('click','#other_remove', function(){
			$(this).closest('tr').remove();
			calculate_other_price();
		});
		
    
		calculate_other_price();
		
		function calculate_other_price() {
			var cost = [];
			var i = 0;
			$( "[id='other_cost']" ) .each(function(){
      			cost[i] = $(this).val();
      			i++;
			});
			var total = 0;
			for (var i = 0; i < cost.length; i++) {
    			total += cost[i] << 0;
			}
			$("#total_oc").val(total);
            
			var margin = $("#other_margin").val();
			 var gst1 = $("#other_gst").val();

			if (margin != '') {
				total5 = total;
				//alert(total5);
				total = total+(total*margin/100);
				var gst = total*gst1/100;
				
				$("#total_pc").val(total);
				$("#other_gst1").val(gst);
				var total1= total+gst;
				$("#total_all_pc").val(total1);
				var profit=total-total5;
				$("#profit").val(profit);
			}else{
				var gst = total*gst1/100;
				$("#total_pc").val(total);
				$("#other_gst1").val(gst);
				$("#total_all_pc").val(total1);
				$("#profit").val(profit);
			}
				$("#total_oc").css('display','block');
				$("#total_pc").css('display','block');
				$("#other_gst1").css('display','block');
				$("#total_all_pc").css('display','block');
				$("#profit").css('display','block');
		}

		//setup before functions
		var typingTimer;                //timer identifier
		var doneTypingInterval = 3000;  //time in ms, 3 second for example
		var $input = $('#other_margin');

		//on keyup, start the countdown
		$input.on('keyup', function () {
		  clearTimeout(typingTimer);
		  typingTimer = setTimeout(AddOtherMargin, doneTypingInterval);
		});

		//on keydown, clear the countdown 
		$input.on('keydown', function () {
		  clearTimeout(typingTimer);
		});
		
		
		var typingTimer1;                //timer identifier
		var doneTypingInterval1 = 3000;  //time in ms, 3 second for example
		var $input1 = $('#other_gst');

		//on keyup, start the countdown
		$input1.on('keyup', function () {
		  clearTimeout(typingTimer1);
		  typingTimer1 = setTimeout(GstDisplay, doneTypingInterval1);
		   var val = $(this).val();
		 // alert(val);
		   $("#gts_percent").text(val);
		});
		var $input_total = $('#total_pc');

		//on keyup, start the countdown
		$input_total.on('keyup', function () {
			
			
		 // clearTimeout(typingTimer1);
		  //typingTimer1 = setTimeout(GstDisplay, doneTypingInterval1);
		   var val = $(this).val();
		   //alert(val);
		   var total_oc=$("#total_oc").val();
		 // alert(val);
		var  val1 = val-total_oc;
		 var val2=parseInt(val1/total_oc*100);
		   $("#other_margin").val(val2);
		    $("#profit").val(val1);
			 var gst_total2 = $("#other_gst1").val();
			 var val2 =parseInt(val) + parseInt(gst_total2); 
			   $("#total_all_pc").val(val2);
		});

		//on keydown, clear the countdown 
		$input1.on('keydown', function () {
		  clearTimeout(typingTimer1);
		});
		
		//user is "finished typing," do something
		function AddOtherMargin () {
		 	var total_oc = $("#total_oc").val();
		 	console.log(total_oc);
			if (total_oc == '') {
				alert("Please Enter Cost First");
				$("#other_margin").val('0');
				return false;
			}else{
				var margin = $("#other_margin").val();
				var gst1 = $("#other_gst").val();
				console.log("margin:"+margin);
				var new_total_pc = parseInt(total_oc)+(total_oc*margin/100);
				console.log(new_total_pc);
				var new_gst = parseInt(new_total_pc)*gst1/100;
				$("#total_pc").val(new_total_pc);
				$("#other_gst1").val(new_gst);
				var total1= new_total_pc+new_gst;
				$("#total_all_pc").val(total1);
				var profit=new_total_pc-total_oc;
				$("#profit").val(profit);
			}
		}
		function GstDisplay () {
		 	var total_oc = $("#total_oc").val();
		 	console.log(total_oc);
			if (total_oc == '') {
				alert("Please Enter Cost First");
				$("#other_margin").val('0');
				return false;
			}else{
				var margin = $("#other_margin").val();
				var gst1 = $("#other_gst").val();
				console.log("margin:"+margin);
				var new_total_pc = parseInt(total_oc)+(total_oc*margin/100);
				console.log(new_total_pc);
				var new_gst = parseInt(new_total_pc)*gst1/100;
				$("#total_pc").val(new_total_pc);
				$("#other_gst1").val(new_gst);
				var total1= new_total_pc+new_gst;
				$("#total_all_pc").val(total1);
				var profit=new_total_pc-total_oc;
				$("#profit").val(profit);
			}
		}
		
	</script>
	 <script>
   $("#add_more_other_details").click(function() {

		var count = parseInt($("#count_row").val());
		var id = count+1;
		var cities = '<?php echo json_encode($cityArr4); ?>';
		var hotels = '<?php echo json_encode($part_travel_array); ?>';
		var td_id = 'other_rows_'+id;
		var new_rows = "<tr id='other_rows_"+id+"'><td class='col-md-2'><select class='form-control select2 other_destination1_"+id+"' onChange='otherdest()' name='other_destination[]' style='width:100%;' data-placeholder='Select a City' ><option value=''>Select City</option>";
		$.each(JSON.parse(cities), function(index, element) {
			$.each(this, function(k, v) {
			new_rows += "<option value="+v.id+">"+v.city+"</option>";
			});
        });
		new_rows +="</select></td><td class='col-md-3'><div class='form-group'><input type='text' class='form-control' name='other_particulars[]' placeholder='Enter particulars'></div></td>";

		new_rows +="<td class='col-md-1'><select class='form-control hotel_filter1' name='hotel_filter[]' id='hotel_filter_"+id+"'><option value=''>Select Hotel</option></select></td>";

		new_rows +="<td class='col-md-1'><input type='date' class='form-control' name='from_date[]'/></td>";
		new_rows +="<td class='col-md-1'><input type='date' class='form-control' name='to_date[]'/></td>";


		new_rows +="<td class='col-md-2'><select class='form-control' name='partner_hotel[]' id='partner_hotel_"+id+"'><option value=''>Select Vendor</option>";
		$.each(JSON.parse(hotels), function(index, element) {
			new_rows += "<option value="+element.hotel_name+">"+element.hotel_name+"</option>";
        });
		new_rows +="</select></td><td class='col-md-1'><div class='form-group'><input type='text' class='form-control' name='other_cost[]' id='other_cost' placeholder='Enter Cost' onkeyup='calculate_other_price();'></div></td>";
		new_rows +="<td class='col-md-1'><div class='col-md-6' style='font-size: 21px; color: red; cursor:pointer' id='other_remove'><i class='fa fa-minus-circle' aria-hidden='true'></i></div></td></tr>";
        
        //otherdest(count++);
		$("#other_hotel_details").append(new_rows);
		$("#count_row").val(id);
	});
    </script>
	   <script>

      $(".other_destination").change(function()
	 {
		
		var id=$(this).val();
		//alert(id);
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "_ajax_hotel_city_filter.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".hotel_filter").html(html);
			} 
		});
	});	

     function otherdest()
	 {
		var count = parseInt($("#count_row").val());
		//alert(count);
		var id=$(".other_destination1_"+count).val();
		alert(id);
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "_ajax_hotel_city_filter.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#hotel_filter_"+count).html(html);
				count++;
			} 
		});
	}
	
	
	$('#other_hotel input').on('change', function() {
   var val_gst = $('input[name=cgst]:checked', '#other_hotel').val();
    var gst= $("#other_gst").val();
if(val_gst=='cgst') 
{	
   
    var gst=gst/2;
    var gst2 = gst+"%";
	var gst3= gst+"%"+" , "+gst+"%";
	//var gst4= gst;
    $("#cgst1").html(gst3);
	$("#cgst2").val(gst);
	$("#igst1").html('');
	$("#igst2").val('');
}
if(val_gst=='igst') 
{
	 var gst3 = gst+"%";
    $("#igst1").html(gst3);
	$("#cgst1").text('');
	$("#cgst2").val('');
	 $("#igst2").val(gst);
}
});

var $gst_total = $('#gst_amount');

		//on keyup, start the countdown
		$gst_total.on('keyup', function () {
			
			
		 // clearTimeout(typingTimer1);
		  //typingTimer1 = setTimeout(GstDisplay, doneTypingInterval1);
		   var gst_total1 = $(this).val();
		    var pc =$("#total_pc").val();
		   //alert(val);
		   var other_gst=$("#other_gst").val();
		 // alert(val);
		   var gst_total2=parseInt(gst_total1*other_gst/100);
		 
		   var  val1 = gst_total2;
		   
		 var val2 =parseInt(pc) + parseInt(gst_total2); 
			   $("#total_all_pc").val(val2);
		// alert(pc);
			
			//alert(val2);
		   $("#other_gst1").val(val1);
		  //  $("#total_all_pc").val(val2);
		   //calcualte_total_price();
		});
		
		
			
			
			 
		

    </script>
	<!--end package ajax-->

<?php include('footer.php'); ?>
