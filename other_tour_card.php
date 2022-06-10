<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deleteothertcardrById($id);
		header("location:other_tour_card.php");
	} 
	//print_r($_SESSION);
	//Array ( [admin_Id] => 104 [user_type] => Employee [employee_type] => 0 [employee_Id] => LiDE0104 [admin_Email] => LiDE0104 ) asdfasldfklasdhfsadhkfhkasdfhlsahdflsahdfdashfhasdha::::104::::Employee::::0:::1SELECT * FROM query WHERE employeeId = 104 AND query_type = 1 ORDER BY id DESC


	//Array ( [admin_Id] => 136 [user_type] => Employee [employee_type] => 0 [admin_Email] => LiDE0136 )
	//Array ( [admin_Id] => 136 [user_type] => Employee [admin_Email] => LiDE0136 )
	//Array ( [admin_Id] => 73 [user_type] => admin [employee_type] => 1 [admin_Email] => admin@gmail.com )
	
	$userType = $_SESSION['user_type'];
	$empType = $queryType = $_SESSION['employee_type'];
	$user_id = @$_SESSION['email'];

	$record=$objAdmin->getPerPageRecord();
	$record_per_page = $record['per_page_record'];
	$page = '';
	if(isset($_GET["page"]))
	{
		$page = $_GET["page"];
	}
	else
	{
		$page = 1;
	}

	$start_from = ($page-1)*$record_per_page;
    
	 $url= trim($_SERVER['HTTP_HOST'], '/');
    if (!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
	
	$arrQuery=$objAdmin->getAllOtherTourcard($start_from,$record_per_page);
	
	
	//print_r($arrQuery);exit;
	
	 



	
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Other Tour Card Details
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cancelled Query list</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box">
               	<div class="perpage" style="position: absolute;top: 13px;">
               	Show
               	<select id="perpage">
				  <option value="10" <?php if ($record['per_page_record'] == '10'){echo 'selected';} ?>>10</option>
				  <option value="25" <?php if ($record['per_page_record'] == '25'){echo 'selected';} ?>>25</option>
				  <option value="50" <?php if ($record['per_page_record'] == '50'){echo 'selected';} ?>>50</option>
				  <option value="100" <?php if ($record['per_page_record'] == '100'){echo 'selected';} ?>>100</option>
				  <option value="500" <?php if ($record['per_page_record'] == '500'){echo 'selected';} ?>>500</option>
				</select>
				entries
				</div>
               <!--  <div class="box-header">
                    <div class="pull-left"><a href="userDetail_Hin.php" class="btn btn-success">Add User Details(Hindi)</a></div>
			        <div class="pull-right"><a href="userDetail.php" class="btn btn-success">Add User Details(English)</a></div>
		         
                </div>/.box-header -->
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Tour card No</th>
						<th>Bkg Date</th>
                        <th>Bkg By</th>
						<th>Package type</th>
						<th>Pax Name</th>
						<th>Party</th>
						<th>file No</th>
						<th>Invoice No</th>
						
						<!--<th>Workout</th>-->
						<th style="width: 55px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					$count=1;
					
					foreach($arrQuery as $key=>$val)
					{
						
					?>
                      <tr>
                        <td><?php echo $val['tc_no'];?></td>
						<td><?php echo $val['bkg_date'];?></td>
                        <td><?php echo $val['bkg_by'];?></td>
						<td><?php echo $val['queryType'];?></td>
                        <td><?php echo $val['name_prefix'];?> <?php echo $val['pax_name'];?></td> 
						  <td><?php echo $val['party'];?></td> 
						  <td><?php echo $val['file_no'];?></td> 
						  <td><?php echo $val['invoice_no'];?></td> 
                       
						
						<!--<td>
							<div class="btn-group btn-group-xs">
								<a href="query.php?qn=<?php echo $val['query_no'];?>" class="btn btn-info"><i class="fa fa-check"></i> Workout Panel</a>
							</div>
						</td> -->                   
						<td>
							<div class="btn-group btn-group-xs">
								
								<a href="edit_other_tour_card.php?action=edit&id=<?php echo $val['id'];?>&queryType=<?php echo $val['queryType'] ?>" class="btn btn-info" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
								
								
							</div>
						</td>
                      </tr>
                     <?php
					 $i++;
					 } 
					 ?>
					 </tbody>
					 
                  </table>
                  <div align="center" class="pagenation">
    			<br />
    		<?php
			    $page_result=$objAdmin->getAllOthertourcardResult();
			    $total_records = count($page_result);
			   $total_pages = ceil($total_records/$record_per_page);
			    $start_loop = $page;
			    $difference = $total_pages - $page;
			    echo "<ul class='pagination'>";
			    if($difference <= 5)
			    {
			     //$start_loop = $total_pages - 5;
			    }
			     $end_loop = $start_loop + 4;
				
			    if($page > 1)
			    {
			    
			     echo "<li class='queryPage'><a href='other_tour_card.php?page=1'>First</a></li>";
			     echo "<li class='queryPage'><a href='other_tour_card.php?page=".($page - 1)."'><<</a></li>";
			    }
			    for($i=$start_loop; $i<=$end_loop; $i++)
			    {
			    	if ($_GET['page'] == $i) {
			    		$class = 'active';
			    	}else{
			    		$class = '';
			    	}
			     echo "<li class='queryPage ".$class."'><a href='other_tour_card.php?page=".$i."'>".$i."</a></li>";
			    }
			    if($page <= $end_loop)
			    {
			     echo "<li class='queryPage'><a href='other_tour_card.php?page=".($page + 1)."'>>></a></li>";
			     echo "<li class='queryPage'><a href='other_tour_card.php?page=".$total_pages."'>Last</a></li>";
			    }
			    echo "</ul>";
			    
			    
			    ?>
    		</div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  
<div id="qDetail" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Query Detail</h4>
      </div>
      <div class="modal-body" id="mdetail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="qDetail" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Query Detail</h4>
      </div>
      <div class="modal-body" id="mdetail">
      </div>
      <div class="modal-footer">
	    
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>	

<div id="cDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalcancelHead">Cancellation Detail</h4>
      </div>
      <div class="modal-body" id="cdetail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

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
			//var res = del_id.substring(6);
			

			//alert(del_id);
			$.ajax({
            type: 'GET',
            data: {per_id:del_id},
            url:"tour_card.php?action=tour_card_det",
            success: function(html)
            {
				
				//$("input[type=text], textarea, select").val("");
				// $("#name_qry").val("lidtc0"+res);
				// $("#search_data").hide();
				// $("#search_data1").hide();
				// $("#country").select2("val", "");
				// $("#state").select2("val", "");
				// $("#city").select2("val", "");
				// $(".package_new").hide();
				// $("#package_data1").hide();
				// $("#query_person_name").html(html);
				// $("#bkg_by").val(bkg_by);
				//alert(html);
                //alert(result);
               //$("#hotel_state").html(result);
            }
        });
			
			//alert(qn1);
			//$("#name_qry").val(qn1);
			
			//$("#modalHead").html('Query Detail: <strong>'+qn+'</strong>');
			//$("#mdetail1").html($("#detal_"+qn1).html());
			
		});
	function areyousure()
	{
		if(confirm('Are you sure.'))
		{
			//$('#myModal').modal('show');
			
		}else {
			
			return false;
		}
	}
    </script>
     <?php include('footer.php');?>

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

     <script type="text/javascript">
	function stateGet(id){
     	var id=$('#hotel_country').val();
        $.ajax({
            type: 'POST',
            data: {id:id},
            url:"_ajax_hotel_get_state.php",
            success: function(result)
            {
                //alert(result);
               $("#hotel_state").html(result);
            }
        });
    }

     function cityGet(id){
     	var id=$('#hotel_state').val();
        $.ajax({
            type: 'POST',
            data: {id:id},
            url:"_ajax_hotel_get_city.php",
            success: function(result)
            {
               $("#hotel_city").html(result);
            }
        });
    }
$('.queryPage').on('click', function(){
    $('.queryPage').removeClass('current');
    $(this).addClass('current');
});


function undoConfirm(query_id) {
		$.ajax({
			type:'post',
			url :'_ajax_query_undoconfirmed_request.php',
			data:{id:query_id},
			beforeSend:function() {
			},
			success:function(result) {
				if(result === '1')
				{
					window.location.href='query_in_hand.php';
				
				}
				else if (result == 0)
				{
					$("#status").show().html('<div class="alert alert-danger">Sorry, pull request no generated</div>');
					
				}else{
					$("#status").show().html('<div class="alert alert-danger">Sorry, there is something problem please try again later!</div>');
				}
			}

		});
	}

	$("#perpage").change(function() {
		var perpage = $("#perpage").val();
		$.ajax({
			type:'post',
			url :'_ajax_update_record_per_page.php',
			data:{record:perpage},
			beforeSend:function() {
			},
			success:function(result) {
				if(result === '1')
				{
					window.location.href='other_tour_card.php';
				
				}
				else if (result == 0)
				{
					$("#status").show().html('<div class="alert alert-danger">Sorry, pull request no generated</div>');
					
				}else{
					$("#status").show().html('<div class="alert alert-danger">Sorry, there is something problem please try again later!</div>');
				}
			}
		});
	});
   
   function my_fun()
{
	var query_data=document.getElementById("queryType").value;
	//alert(query_data);
	if(query_data=='Hotel')
{
	$("#search_data").show();
	$("#search_data1").show();
	$("#searchpack").hide();
	$("#package_data1").hide();
	$(".package_new").hide();
	$("#startdate").val('');
	$("#enddate").val('');
	$("#stayDuration").val('');
	$("#adults_1").val(1);
	$("#child_1").val('');
	$("#child_age_1").val('');
}
else if(query_data=='Package')
{
	
    $("#search_data").show();
    $("#searchpack").show();
	$("#search_data1").hide();
	$("#startdate").val('');
	$("#enddate").val('');
	$("#stayDuration").val('');
	$("#adults_1").val(1);
	$("#child_1").val('');
	$("#child_age_1").val('');
}
else
{
	
	
$("#searchpack").hide();
	$("#search_data1").hide();
	 $("#search_data").hide();
}

}
</script>
<script>
$("#search_data").hide();


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
				//alert(qtype);
				if(qtype == 'Package'){
					$("#hotel_rating").hide();
					$("#hotelnameFilter").hide();
					$(".packageField").show();
					$(".hotelField").hide();
					$("#queryType1").val(qtype);
					$("#searchType span:first").html('Package');
					$("#searchDataBtn").html('Search Package');
				}else{
					$(".package_new_hotel").hide();
					$("#search_data1").hide();
					$("#hotel_rating").show();
					$("#hotelnameFilter").show();
					$(".packageField").hide();
					$(".hotelField").show();
					$("#queryType1").val(qtype);
					$("#searchType span:first").html('');
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
					url:"_ajax_search_data1.php?action=searchData",
					data:$("#search_data").serialize(),
					beforeSend:function(){
					//$(".loader").css('display','block');
					$("#me1").css({"display": "block"});
					$(".package_new").css({"display": "none"});
					$(".package_new_hotel").css({"display": "none"});
					$("#package_data1").css({"display": "none"});
					$("#search_data1").css({"display": "none"});
					},
					success:function(html){
						
						var htmlArr = html.split('$abc#$');
						//alert(htmArr);
						$("#searchData").html(htmlArr[0]);
						//$("#searchpack").html(htmlArr[0]);
						//$("#ratingFilter").html(htmlArr[1]);
						$("#nameSearch").html(htmlArr[2]);
						$("#package_search").html(html);
						$("#me1").css({"display": "none"});
						//$("#package_data1").css({"display": "block"});
						if($("#queryType").val()=="Package")
						{
							
						$(".package_new").css({"display": "block"});
						$(".package_new_hotel").css({"display": "none"});
						}
						if($("#queryType").val()=="Hotel")
						{
						$(".package_new_hotel").css({"display": "block"});
						$(".package_new").css({"display": "none"});
						}
					}
				});
			});
			
			$(document).on('change','#package_search',function(){
				var package_id = $(this).val();
				if(package_id=='')
				{
					//alert('Select an option');
					//$("#nameSearch").val(hotel_id);
					$("#package_data1").hide();
					return false;
				}
				else
				{
				//var res = hotel_id.split("&");
				//var hotel_id1 = $(this).val(1);
				//alert(res);exit;
				//lert(hotel_id1);exit;
				//var info = 'name=' + hotel_id;
				$.ajax({
		    type: "POST",
            url: 'ajax_data_package_list.php?action=getPackageId', //This is the current doc
            data:{data:package_id},
			cache: false,
			beforeSend:function(){
				$("#me3").css({"display": "block"});
			},
            success: function(html){
				//alert(html);
				$("#me3").css({"display": "none"});
				$("#package_data1").show();
				$("#package_data1").html(html);
				//$("#search_data1").html();
                // Why were you reloading the page? This is probably your bug
                // location.reload();

                // Replace the content of the clicked paragraph
                // with the result from the ajax call
                //$("#raaagh").html(data);
				//selected_mealTypes();
				//selected_roomTypes1();
				//calculate_price1();
            }
        });  
				}
				//alert(val);
				// if(val == 'all')
				// {
					//$(".hotelBox").show();	
				// }
				// else{
					// $(".hotelBox").hide();
					// $("#hotel_"+val).show();
				// }
			});
			
			$(document).on('change','#nameSearch',function(){
				var hotel_id = $(this).val();
				if(hotel_id=='')
				{
					//alert('Select an option');
					//$("#nameSearch").val(hotel_id);
					$("#search_data1").hide();
					return false;
				}
				else
				{
				//var res = hotel_id.split("&");
				//var hotel_id1 = $(this).val(1);
				//alert(res);exit;
				//lert(hotel_id1);exit;
				//var info = 'name=' + hotel_id;
				$.ajax({
		    type: "POST",
            url: '_ajax_search_data1.php?action=getHotelId', //This is the current doc
            data:{data:hotel_id},
			cache: false,
			beforeSend:function(){
				$("#me2").css({"display": "block"});
			},
            success: function(html){
				// var grand_total= $('#grandTotal span').text();
				// alert(grand_total);
				// return false;
				$("#search_data1").show();
				$("#search_data1").html(html);
				// var grand_total= $('#grandTotal span').text();
				// alert(grand_total);
				//$("#search_data1").html();
                // Why were you reloading the page? This is probably your bug
                // location.reload();

                // Replace the content of the clicked paragraph
                // with the result from the ajax call
                //$("#raaagh").html(data);
				$("#me2").css({"display": "none"});
				$('#viewDetail1').scrollTop(0 ,200);
				selected_mealTypes();
				selected_roomTypes();
				calculate_price();
				
            }
        }); 
				}		
				//alert(val);
				// if(val == 'all')
				// {
					//$(".hotelBox").show();	
				// }
				// else{
					// $(".hotelBox").hide();
					// $("#hotel_"+val).show();
				// }
			});
			
			// $(document).on('change','#ratingFilter',function(){
				// var val = $(this).val();
				//alert(val);
				// if(val == 'all')
				// {
					// $(".hotelBox").show();	
				// }
				// else{
					// $(".hotelBox").hide();
					// $(".hotelrating_"+val).show();
				// }
				
			// });
			
			
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
		
		function getHotelPrice(){
			selected_roomTypes();
		    calculate_price();
		}
		function getHotelMeal(){
			selected_mealTypes()
		    calculate_price();
		}
		</script>
<script>
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
	var priceMargin = $("#priceMargin").val();
	
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
			//alert(calPrice);
			$("#calculated_prices").val(calPrice);
			$("#calculated_hotel_prices").val(calPrice);
			
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
	$("#pricemargin_hotel").val(margin_val);
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
	$("#grand_total_hotel").val(grandTotal);
	//$("#calculated_prices").val(html);
	
	var optVal = '';
	$(".userRoomTypes").each(function(){
		optVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	//alert(optVal);
	$("#selected_rooms").val(optVal);
	$("#hotel_selected_rooms").val(optVal);
	
	var MealoptVal = '';
	$(".mealTypes").each(function(){
		MealoptVal += $(this).find("option:selected").text()+',';
		
		//$(".userRoomTypes option:selected").text()+', ';
	});
	$("#selected_mealPlans").val(MealoptVal);
	$("#hotel_meal_plans").val(MealoptVal);
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


</script>

<!--package ajax-->

<script>
    $(function () {
		
		
		//alert(userRooms);
		//selected_roomTypes();
		//calculate_price();
		
		$(document).on('change','.userRoomTypes1',function(){
			//alert('yes');
			$("#userSelectHotel").val($('#hotel_'+$(this).attr('rel')).val());
			selected_roomTypes1();
			calculate_price1($(this).attr('rel'), $(this).attr('selDate'));
		});
		
		$(document).on('change','.mealTypes1',function(){
			//alert('yes');
			//$("#userSelectHotel").val($('#hotel_'+$(this).attr('rel')).val());
			selected_roomTypes1();
			calculate_price1($(this).attr('rel'), $(this).attr('selDate'));
		});
		
		$(document).on('change','#vehCleCost',function(){
			var cost = $(this).val();
			$("#vehPrice").html(cost);
			$("#selectedVehcleCost").val(cost);
			$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val());
			$("#vehicle_package_cost").val(cost);
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
					selected_roomTypes1();
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
	  
	function selected_roomTypes1()
	{
		var userRooms1 = '';
		var i=0;
		$(".userRoomTypes1").each(function(){
			//alert($(this).val());
			i++;
			var val = $(this).val();
			userRooms1 += val+',';
		});
		$("#userSelectRoomTypes1").val(userRooms1);
		
		var userSelctedMeals = '';
		$(".mealTypes").each(function(){
			//alert($(this).val());
			i++;
			var val = $(this).val();
			userSelctedMeals += val+',';
		});
		$("#userSelectedMealPlans1").val(userSelctedMeals);
		
	}	
	
	function calculate_price1(number, selDate)
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getpakageHotelPrice&selDate="+selDate,
			data:$("#formData1").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				//alert(html);
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
	
	function calc_fun()
	{
		var priceMargin1 = $("#priceMargin1").val();
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getpakageHotelPrice2",
			data:$("#formData1").serialize(),
			beforeSend:function(){
				
			},
			success:function(html){
				//alert(html);
				//var obj2=json_encode()
				//return false;
				$("#calculated_prices").val(html);
				
				calculate_priceWith_margin1(priceMargin1);
				
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
	}
	 
	
	function calculate_priceWith_margin1(margin_val1)
	{
		$("#pricemargin_package").val(margin_val1);
		var roomPrices1 = $("#calculated_prices").val();
		  $("#calculate_package_price").val(roomPrices1);
		  
		if(roomPrices1 == '')
		{
			return false;
		}
		
		var obj = JSON.parse(roomPrices1);
		//console.log(obj);
		
		var totalRooms = $("#totalBookingRooms").val();
		var totPrice1 = 0;
		var totPrice2 =0 ;
		//alert(totalRooms);
		var vehicleCost = $("#selectedVehcleCost").val();
		var no_of_vehicle = $("#no_of_vehicle").val();
		$("#no_of_package_vehicle").val(no_of_vehicle);
		var prRoomVehCost = parseInt(vehicleCost)*(parseInt(no_of_vehicle))/parseInt(totalRooms);	
	
		
		for(var i=1; i<=totalRooms; i++)
		{
			var roomPrice1 = parseInt(obj[i])+parseInt(prRoomVehCost);
			roomPrice1 = roomPrice1;
			roomPrice2 = roomPrice1+(roomPrice1*parseInt(margin_val1)/100);
			//alert($roomPrice);
			$("#roomPrice_"+i).html(roomPrice1);
			totPrice1 += parseInt(roomPrice1);
			totPrice2 += parseInt(roomPrice2);
		}
		//alert(totPrice);
		$("#totalHotelPrice1").html(totPrice1);
		$("#totalHotelPrice2").html(totPrice2);
		var profit=totPrice2-totPrice1;
		$("#profit").html(profit);
		var serviceTax1 = (totPrice2*5)/100;
		$("#serviceTax1").html(serviceTax1);
		var grandTotal1 = parseInt(totPrice2) + parseInt(serviceTax1);
		$("#grandTotal1").html(grandTotal1);
		$("#grandPackageTotal1").val(grandTotal1);
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
		$("#selected_package_hotels").val(optVal+'$#$'+hotelIds);
		
		var optValRooms = '';
		var SelRoomIds = '';
		$(".userRoomTypes1").each(function(){
			optValRooms += $(this).find("option:selected").text()+',';
			if($(this).val() != '')
			{
				SelRoomIds += $(this).val()+',';
			}
		});
		$("#selected_rooms1").val(optValRooms+'$#$'+SelRoomIds);
		$("#selected_package_rooms1").val(optValRooms+'$#$'+SelRoomIds);
		$("#selectedVehicle").val($('#vehCleCost').val()+'__'+$('#vehCleCost').find("option:selected").text()+'__'+$('#no_of_vehicle').val());
		var vehicle_name= $('#vehCleCost').find("option:selected").text();
		$("#vehicle_name").val(vehicle_name);
		var MealoptVal = '';
		$(".mealTypes1").each(function(){
			MealoptVal += $(this).find("option:selected").text()+',';
			
			//$(".userRoomTypes option:selected").text()+', ';
		});
		$("#selected_mealPlans1").val(MealoptVal);
		$("#selected_package_mealPlans1").val(MealoptVal);
	}
	
	function get_hotel_suppl_cost()
	{
		$.ajax({
			type:"POST",
			url:"_ajax_search_data.php?action=getHotelSuppCost",
			data:$("#formData1").serialize(),
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
		var selc_rooms = $("#selected_rooms1").val();
		var selc_mealPlans = $("#selected_mealPlans1").val();
		var selc_vehicle = $("#selectedVehicle").val();
		var queryNumber = $("#queryNumber").val();
		var priceMargin = $("#priceMargin1").val();
		
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
	$(document).on('click','#tc_submit',function(){
				
			
				//alert('hello');
				$.ajax({
					type:"POST",
					url:"_ajax_search_data1.php?action=tour_card",
					data:$("#tour_card_data,#search_data").serialize(),
					    
					beforeSend:function(){
						
					},
					success:function(html){
						
						alert('Data submitted');
						
					}
				});
			});
    </script>
	<!--end package ajax-->
		<script src="asset/bootstrap-datepicker.js"></script>