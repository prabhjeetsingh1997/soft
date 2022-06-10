<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objHotel->deletehotelconfirmationById($id);
		header("location:hotel_confirmation.php");
	} 

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
	
	$arrQuery=$objAdmin->getAllHotelConfirmation($start_from,$record_per_page);

?>

<style>
table tr td{
	border:1px solid #eee;
	font-family: Arial, Helvetica, sans-serif;
	padding:5px;
	
}
table tr th{
	border:1px solid #eee;
	padding:5px;
	
}
</style>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Hotel Confirmation Details
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Hotel Confirmation list</li>
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
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	 <th>Tour Card Id</th>
                        <th>Tour Card No</th>
						<th>From Date</th>
                        <th>To Date</th>
						<th>Nights</th>
						<th>Pax Name</th>
						<th>Hotel</th>
						<th>City</th>
						<th>Room Type</th>
						<th>Meal Plan</th>
						<!-- <th>Costing</th> -->
						 <th style="width: 55px;">Action</th> 
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					$count=1;
					$i=1;
					foreach($arrQuery as $key=>$val)
					{
						
					?>
                    <tr>
                    	<td><?php echo $val['tour_card_id'];?></td>  
                        <td><?php echo $val['tour_card_no'];?></td>
						<td><?php echo $val['checkin_date'];?></td>
                        <td><?php echo $val['checkout_date'];?></td>
						<td><?php echo $val['nights'];?></td>
                        <td><?php echo $val['name_prefix'];?> <?php echo $val['pax_name'];?></td> 
						<td><?php echo $val['hotel'];?></td> 
						<td><?php echo $val['city'];?></td> 
						<td><?php echo $val['room_type'];?></td>
						<td><?php echo $val['meal_plan'];?></td> 
						<td>
                        <div id="detal_<?php echo $val['id'];?>" style="display:none; text-align: justify;">
						 <table width="100%;" cellspacing="3" cellpadding="3">
			              <tbody>
								
								<tr>
									<td>Tour Card No:</td>
									<td><?php echo $val['tour_card_no'];?></td>
								</tr>
								<tr>
									<td>From Date  :</td>
									<td><?php echo $val['checkin_date'];?></td>
								</tr>
								<tr>
									<td>To Date  :</td>
									<td><?php echo $val['checkout_date'];?></td>
								</tr>
								<tr>
									<td>Nights :</td>
									<td><?php echo $val['nights'];?></td>
								</tr>
								<tr>
									<td>Pax Name:</td>
									<td><?php echo $val['name_prefix'];?> <?php echo $val['pax_name'];?></td>
								</tr>
								
								<tr>
									<td>Hotel :</td>
									<td><?php echo $val['hotel'];?></td>
								</tr>
								<tr>
									<td>City :</td>
									<td><?php echo $val['city'];?></td>
								</tr>
								<tr>
									<td>Room Type :</td>
									<td><?php echo $val['room_type'];?></td>
								</tr>
								<tr>
									<td>Meal Plan :</td>
									<td><?php echo $val['meal_plan'];?></td>
								</tr>
                        </tbody>
	                   </table>
                         

                        <table width="100%;" border="1" cellspacing="3" cellpadding="3">
			              <tbody>
								<tr>
									<th>Costing</th>
									<?php 
									$costing=explode(",",$val['costing']);
									foreach($costing as $costing1)
									{
									?>
									<td><?php echo $costing1; ?></td>
									<?php 
									}
									?>
								</tr>
								<tr>
									<th><?php echo $val['room_type'] ?></th>
									<?php 

									$room_type_price=explode(",",$val['room_type_price']);
									foreach($room_type_price as $room_type_price1)
									{
									?>
									<td><?php echo $room_type_price1; ?></td>
									<?php 
									}
									?>
								</tr>
                        </tbody>
	                   </table>
					   <div class="result_data_price"></div>
                  </div>
                              
                               <input type="hidden" name="room_rate" class="room_rate<?php echo $val['id'];?>" value=<?php  echo $val['room_ratee_price']?> />

                              	<?php 
                              	if($val['status']==1)
								{
								?>
								<button type="button" rel="<?php echo $val['id'];?>"  class="btn btn-success btn-sm viewDetail" id="<?php echo $val['tour_card_id']?>,<?php echo $val['id'];?>"><i class="fa fa-eye"></i></button>
								
								<?php 
								}
								else
								{
								?>
								<button type="button" rel="<?php echo $val['id'];?>"  class="btn btn-info btn-sm viewDetail" id="<?php echo $val['tour_card_id']?>,<?php echo $val['id'];?>"><i class="fa fa-eye"></i></button>
								<?php 
								}
								?>
								
							
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
			    
			     echo "<li class='queryPage'><a href='hotel_confirmation.php?page=1'>First</a></li>";
			     echo "<li class='queryPage'><a href='hotel_confirmation.php?page=".($page - 1)."'><<</a></li>";
			    }
			    for($i=$start_loop; $i<=$end_loop; $i++)
			    {
			    	if ($_GET['page'] == $i) {
			    		$class = 'active';
			    	}else{
			    		$class = '';
			    	}
			     echo "<li class='queryPage ".$class."'><a href='hotel_confirmation.php?page=".$i."'>".$i."</a></li>";
			    }
			    if($page <= $end_loop)
			    {
			     echo "<li class='queryPage'><a href='hotel_confirmation.php?page=".($page + 1)."'>>></a></li>";
			     echo "<li class='queryPage'><a href='hotel_confirmation.php?page=".$total_pages."'>Last</a></li>";
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
        <h4 class="modal-title" id="modalHead">Hotel Confirmation Details</h4>
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
			//alert(count);
			var qn = $(this).attr('rel');
			$("#modalHead").html('Hotel Booking Details');
			$("#mdetail").html($("#detal_"+qn).html());
			//alert(qn);
			var element = $(this);
			var del_id = element.attr("id");
			var array = del_id.split(",");

			var tour_card_id=array[0];
			var tr_id = array[1];
			var room_rate=$(".room_rate"+tr_id).val();
			$.ajax({
            type: 'GET',
            url:"_ajax_hotel_booking.php?action=add_hotel_tour_card&tour_card_id="+tour_card_id+"&room_rate="+room_rate,
			cache: false,
            success: function(html)
            {
				$(".result_data_price").html(html);
			}
        });
	});
});
  </script>
 <?php include('footer.php');?>
