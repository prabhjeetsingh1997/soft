<?php 
	include('header.php');
	include('sidebar.php');
	include('view_package_data.php');
?>
<style>
.modal-dialog{width:750px;}
</style>
<?php
include('email_data_to_client.php');
?>
<script src="ckeditor_4.4.5_full/ckeditor/ckeditor.js" type="text/javascript"></script>	
<script>
    $(function () {
		CKEDITOR.env.isCompatible = true;
		CKEDITOR.replace('email_body');	
		
        $('#example1').DataTable({
          "paging"      : true,
          "lengthChange": true,
          "searching"   : true,
          "info"        : true,
          "autoWidth"   : false,
		  "bSort"       : false,
		  
    });
		
		//alert(userRooms);
		//selected_roomTypes();
		//calculate_price();
		
		$(document).on('change','.userRoomTypes',function(){
			//alert('yes');
			$("#userSelectHotel").val($('#hotel_'+$(this).attr('rel')).val());
			selected_roomTypes();
			calculate_price($(this).attr('rel'), $(this).attr('selDate'));
		});
		
		$(document).on('change','.mealTypes',function(){
			//alert('yes');
			//$("#userSelectHotel").val($('#hotel_'+$(this).attr('rel')).val());
			selected_roomTypes();
			calculate_price($(this).attr('rel'), $(this).attr('selDate'));
		});
		
		$(document).on('change','#vehCleCost',function(){
			var cost = $(this).val();
			$("#vehPrice").html(cost);
			$("#selectedVehcleCost").val(cost);
			$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val());
		});
		
		$(document).on('change','.hoteltypes',function(){
			var searchType = $("#searchType").val();
			var startDate = $("#hidStartDate").val();
			var endDate = $("#hidEndDate").val();
			var selDate = $(this).attr('selectedDate');
			
			var data = 'hotId='+$(this).val()+'&startDate='+startDate+'&endDate='+endDate+'&selDate='+selDate+'&searchType='+searchType;
			var number = $(this).attr('rel');
			//alert(number);
			$.ajax({
				type:"POST",
				url:"_ajax_get_pakage_detail.php?action=getHotelRooms",
				data:data,
				beforeSend:function(){
					
				},
				success:function(html){
					
					var dataArr = html.split('$##$');
					
					$("#roomType_"+number).html(dataArr[0]);
					$("#mealType_"+number).html(dataArr[1]);
					//alert(html);
					//$("#showQueryDetail").html(html);
					selected_roomTypes();
					//calculate_price($(this).attr('rel'));
				}
			});
		});
		
		$("#searchQueryBtn").click(function(){
			var query = $("#queryNumber").val();
			if(query == '')
			{
				alert('Please Enter query first');
			}
			else
			{
				var data = 'query='+query+'&qT=Package';
				$.ajax({
					type:"POST",
					url:"_ajax_search_data.php?action=getQueryDetail",
					data:data,
					beforeSend:function(){
						
					},
					success:function(html){
						var dataArr = html.split('$#$');
						$("#showQueryDetail").html(dataArr[0]);
						$("#rescipent_emails").val(dataArr[1]);
						$("#tourSub").val(dataArr[3]);
						
						var ckeditorContent = 'Dear '+dataArr[2]+'<br/><br/>Greetings from <strong><span style="font-size: 19px;background: yellow; color:#00c0ef;">LiD – Travel </span>!!!</strong><br/><br/>Thank you for considering us for your forthcoming travel plan, in response please find attached tour proposal for your kind perusal as per the details provided by you.<br/><br/>We Hope all the above is in order and if you need any further clarification please call / write us.<br/><br/>Looking forward for a response/acknowledgment/confirmation on the same at the earliest.<br/><br/>Thanks and Regards !!!<br/>Gaurav<br/>Team LiD</br/>m.+91(0)9999614493<br/><br/>';
						CKEDITOR.instances['email_body'].setData(ckeditorContent);
					}
				});
			}
		});
		
		var queryNumb = '<?php echo $queryNumber; ?>';
		if(queryNumb != '')
		{
			//alert('yes');
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
		
		var userSelctedMeals = '';
		$(".mealTypes").each(function(){
			//alert($(this).val());
			i++;
			var val = $(this).val();
			userSelctedMeals += val+',';
		});
		$("#userSelectedMealPlans").val(userSelctedMeals);
		
	}	
	
	function calculate_price(number, selDate)
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getpakageHotelPrice&selDate="+selDate,
			data:$("#formData").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				
				var obj = JSON.parse(html);
				//console.log(obj);
				
				$("#dayPrice_"+number).html(obj[1]);
				
				/* var totalRooms = $(".userRoomTypes").length;
				var totPrice = 0;
				for(var i=1; i<=totalRooms; i++)
				{
					$("#roomPrice_"+i).html(obj[i]);
					totPrice += parseInt(obj[i]);
				}
				$("#totalHotelPrice").html(totPrice);
				var serviceTax = (totPrice*1.75)/100;
				$("#serviceTax").html(serviceTax);
				var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
				$("#grandTotal").html(grandTotal); */
			}
		});
	}
	
	
	$("#calculate_prices").click(function(){
		var priceMargin = $("#priceMargin").val();
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getpakageHotelPrice2",
			data:$("#formData").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				$("#calculated_prices").val(html);
				
				calculate_priceWith_margin(priceMargin);
				/* var obj = JSON.parse(html);
				console.log(obj);
				
				var totalRooms = $("#totalBookingRooms").val();
				var totPrice = 0;
				//alert(totalRooms);
				var vehicleCost = $("#selectedVehcleCost").val();
				var no_of_vehicle = $("#no_of_vehicle").val();
				var prRoomVehCost = parseInt(vehicleCost)*(parseInt(no_of_vehicle))/parseInt(totalRooms);	
			
				
				for(var i=1; i<=totalRooms; i++)
				{
					var roomPrice = parseInt(obj[i])+parseInt(prRoomVehCost);
					//alert($roomPrice);
					$("#roomPrice_"+i).html(roomPrice);
					totPrice += parseInt(roomPrice);
				}
				
				$("#totalHotelPrice").html(totPrice);
				var serviceTax = (totPrice*9)/100;
				$("#serviceTax").html(serviceTax);
				var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
				$("#grandTotal").html(grandTotal);
				$("#hot_supp_cost").html('');
				get_hotel_suppl_cost(); 
				
				var optVal = '';
				var hotelIds = '';
				$(".hoteltypes").each(function(){
					optVal += $(this).find("option:selected").text()+',';
					if($(this).val() != '')
					{
						hotelIds += $(this).val()+',';
					}
				});
				//alert(optVal);
				$("#selected_hotels").val(optVal+'$#$'+hotelIds);
				
				var optValRooms = '';
				var SelRoomIds = '';
				$(".userRoomTypes").each(function(){
					optValRooms += $(this).find("option:selected").text()+',';
					if($(this).val() != '')
					{
						SelRoomIds += $(this).val()+',';
					}
				});
				$("#selected_rooms").val(optValRooms+'$#$'+SelRoomIds);
				$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val()); */
			}
		});
		
	});
	
	function calculate_priceWith_margin(margin_val)
	{
		var roomPrices = $("#calculated_prices").val();
		if(roomPrices == '')
		{
			return false;
		}
		
		var obj = JSON.parse(roomPrices);
		//console.log(obj);
		
		var totalRooms = $("#totalBookingRooms").val();
		var totPrice = 0;
		//alert(totalRooms);
		var vehicleCost = $("#selectedVehcleCost").val();
		var no_of_vehicle = $("#no_of_vehicle").val();
		var prRoomVehCost = parseInt(vehicleCost)*(parseInt(no_of_vehicle))/parseInt(totalRooms);	
	
		
		for(var i=1; i<=totalRooms; i++)
		{
			var roomPrice = parseInt(obj[i])+parseInt(prRoomVehCost);
			roomPrice = roomPrice+(roomPrice*parseInt(margin_val)/100);
			//alert($roomPrice);
			$("#roomPrice_"+i).html(roomPrice);
			totPrice += parseInt(roomPrice);
		}
		//alert(totPrice);
		$("#totalHotelPrice").html(totPrice);
		var serviceTax = (totPrice*5)/100;
		$("#serviceTax").html(serviceTax);
		var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
		$("#grandTotal").html(grandTotal);
		$("#hot_supp_cost").html('');
		get_hotel_suppl_cost(); 
		
		var optVal = '';
		var hotelIds = '';
		$(".hoteltypes").each(function(){
			optVal += $(this).find("option:selected").text()+',';
			if($(this).val() != '')
			{
				hotelIds += $(this).val()+',';
			}
		});
		//alert(optVal);
		$("#selected_hotels").val(optVal+'$#$'+hotelIds);
		
		var optValRooms = '';
		var SelRoomIds = '';
		$(".userRoomTypes").each(function(){
			optValRooms += $(this).find("option:selected").text()+',';
			if($(this).val() != '')
			{
				SelRoomIds += $(this).val()+',';
			}
		});
		$("#selected_rooms").val(optValRooms+'$#$'+SelRoomIds);
		$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val());
		
		var MealoptVal = '';
		$(".mealTypes").each(function(){
			MealoptVal += $(this).find("option:selected").text()+',';
			
			//$(".userRoomTypes option:selected").text()+', ';
		});
		$("#selected_mealPlans").val(MealoptVal);
		
	}
	
	function get_hotel_suppl_cost()
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getHotelSuppCost",
			data:$("#formData").serialize(),
			beforeSend:function(){
				$("#hot_supp_cost").html('');
			},
			success:function(html){
				//alert(html);
				$("#hot_supp_cost").html(html);
			}
		});
	}
	
	function downlaod_pdf(param, action)
	{
		var prices = $("#calculated_prices").val();
		var selc_hotels = $("#selected_hotels").val();
		var selc_rooms = $("#selected_rooms").val();
		var selc_mealPlans = $("#selected_mealPlans").val();
		var selc_vehicle = $("#selectedVehicle").val();
		var queryNumber = $("#queryNumber").val();
		var priceMargin = $("#priceMargin").val();
		
		selc_hotels = btoa(selc_hotels);
		//console.log(selc_hotels);
		
		var data = "pdfType=package&prices="+prices+'&selRooms='+selc_rooms+'&selHotels='+selc_hotels+'&selVehicle='+selc_vehicle+'&qNo='+queryNumber+'&pMargin='+priceMargin+'&selMealPlans='+selc_mealPlans;
		$.ajax({
			type:"POST",
			url:'generate_pdf.php?'+param,
			data:data,
			beforeSend:function(){
				$("#showLoaderEmail").show();
			},
			success:function(html){
				//alert(html);
				$("#showLoaderEmail").hide();
				//e.preventDefault();  //stop the browser from following
				//window.location.href = 'download_pdf.php?f='+html
				if(action == 'downlaod')
				{
					window.open(
					  'download_pdf.php?f='+html,
					  '_blank' // <- This is what makes it open in a new window.
					);
				}
				else
				{
					for (instance in CKEDITOR.instances) {
						CKEDITOR.instances[instance].updateElement();
					}
					$("#mailFilePath").val(html);
					$.ajax({
						type: "POST",
						url: "send_email.php",
						data: $("#tour_mail").serialize(),
						cache: false,
						beforeSend:function() {
							$("#showLoaderEmail").show();
						},
						success: function(html)
						{
							//alert(html);	
							if(html == '1')
							{
								alert('Email Sent Successfully');
								$('#sendToCl').modal('hide');
								$("#showLoaderEmail").hide();
							}
							else
							{
								alert('There is some error in sending email');
							}
						}
					});
				}
			}
		});
	}
	
    </script>
     <?php include('footer.php');?>