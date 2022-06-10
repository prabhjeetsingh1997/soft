<?php 
	error_reporting(0);
	include('header.php');
	include('sidebar.php');
	include('view_hotel_data.php');
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
	  //CKEDITOR.replace('email_body');	
	 /*  CKEDITOR.replace('email_body',{
		customConfig: 'config2.js'
	}); */
	
	var titleEditor = CKEDITOR.replace( 'email_body', {
		width:'auto',
		height:200,
		startupFocus : false,
		customConfig: 'ckeditor_customconfig/ckeditor_config2.js'
	});
	  
	$('#example1').DataTable({
	  "paging"      : true,
	  "lengthChange": true,
	  "searching"   : true,
	  "info"        : true,
	  "autoWidth"   : false,
	  "bSort"       : false,
	  
	});
	
	//alert(userRooms);
	selected_mealTypes();
	selected_roomTypes();
	calculate_price();
	
	$(".userRoomTypes").change(function(){
		selected_roomTypes();
		calculate_price();
	});
	
	$(".mealTypes").change(function(){
		selected_mealTypes();
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
			var data = 'query='+query+'&qT=Hotel';
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

function selected_mealTypes()
{
	var userMeals = '';
	var i=0;
	$(".mealTypes").each(function(){
		//alert($(this).val());
		i++;
		var val = $(this).val();
		userMeals += val+',';
	});
	//alert(userMeals);
	$("#userSelectMealTypes").val(userMeals);
}	

function calculate_price()
{
	var priceMargin = $("#priceMargin").val()
	$.ajax({
		type:"POST",
		url:"_ajax_search_data.php?action=getPrice",
		data:$("#formData").serialize(),
		beforeSend:function(){
			
		},
		success:function(html){
			//var calP = html.splice(-1,1);
			var response = html;
			
			//alert(response);
			var priceArr = response.split(',"description"');
			var calPrice = priceArr[0]+'}';
			$("#calculated_prices").val(calPrice);
			
			var obj = JSON.parse(html);
			//console.log(obj.description);
			var desc = obj.description;
			calculate_priceWith_margin(priceMargin);
			
			if(desc != '')
			{
				$("#mealDescriptions").html(desc);
				$("#mealDesBox").show();
			}
			else
			{
				$("#mealDesBox").hide();
				$("#mealDescriptions").html('');
			}
			/* var totalRooms = $(".userRoomTypes").length;
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
			$("#calculated_prices").val(html);
			
			var optVal = '';
			$(".userRoomTypes").each(function(){
				optVal += $(this).find("option:selected").text()+',';
				
				//$(".userRoomTypes option:selected").text()+', ';
			});
			//alert(optVal);
			$("#selected_rooms").val(optVal); */
		}
	});
}

function calculate_priceWith_margin(margin_val)
{
	var roomPrices = $("#calculated_prices").val();
	//alert(margin_val);
	
	var obj = JSON.parse(roomPrices);
	//console.log(obj);
	
	var totalRooms = $(".userRoomTypes").length;
	var totPrice = 0;
	var roomprice = 0;

	for(var i=1; i<=totalRooms; i++)
	{
		//alert(obj[i]);
		roomprice = obj[i];
		roompriceWithmargin = roomprice + (roomprice*parseInt(margin_val)/100);
		$("#roomPrice_"+i).html(roompriceWithmargin);
		totPrice += parseInt(roompriceWithmargin);
	}
	$("#totalHotelPrice").html(totPrice);
	var serviceTax = (totPrice*5)/100;
	$("#serviceTax").html(serviceTax);
	var grandTotal = parseInt(totPrice) + parseInt(serviceTax);
	$("#grandTotal").html(grandTotal);
	//$("#calculated_prices").val(html);
	
	var optVal = '';
	$(".userRoomTypes").each(function(){
		optVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	//alert(optVal);
	$("#selected_rooms").val(optVal);
	
	var MealoptVal = '';
	$(".mealTypes").each(function(){
		MealoptVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	$("#selected_mealPlans").val(MealoptVal);
}

function downlaod_pdf(param, action)
{
	var prices = $("#calculated_prices").val();
	var selc_prices = $("#selected_rooms").val();
	var selc_meal_plans = $("#selected_mealPlans").val();
	var queryNumber = $("#queryNumber").val();
	var priceMargin = $("#priceMargin").val();
	var data = "pdfType=hotel&prices="+prices+'&selRooms='+selc_prices+'&qNo='+queryNumber+'&pMargin='+priceMargin+'&selMealPlans='+selc_meal_plans;
	$.ajax({
		type:"POST",
		url:'generate_pdf.php?'+param,
		data:data,
		beforeSend:function(){
			
		},
		success:function(html){
			return false;
			//alert(html);
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

/* function send_email(param, action)
{
	var checkDownlaod = downlaod_pdf(param, action);
	alert(checkDownlaod);
} */



</script>
<?php include('footer.php');?>