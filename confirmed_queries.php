<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deleteQueryById($id);
		header("location:confirmed_queries.php");
	} 
	//print_r($_SESSION);
	//Array ( [admin_Id] => 104 [user_type] => Employee [employee_type] => 0 [employee_Id] => LiDE0104 [admin_Email] => LiDE0104 ) asdfasldfklasdhfsadhkfhkasdfhlsahdflsahdfdashfhasdha::::104::::Employee::::0:::1SELECT * FROM query WHERE employeeId = 104 AND query_type = 1 ORDER BY id DESC


	//Array ( [admin_Id] => 136 [user_type] => Employee [employee_type] => 0 [admin_Email] => LiDE0136 )
	//Array ( [admin_Id] => 136 [user_type] => Employee [admin_Email] => LiDE0136 )
	//Array ( [admin_Id] => 73 [user_type] => admin [employee_type] => 1 [admin_Email] => admin@gmail.com )
	
	$userType = $_SESSION['user_type'];
	$empType = $queryType = $_SESSION['employee_type'];
	$user_id = @$_SESSION['admin_Email'];

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

	$arrQuery=$objAdmin->getAllConfirmedQuery($user_type, $empType, $queryType,$start_from,$record_per_page,$user_id);
	//print_r($arrItinerary);
	
	
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Confirmed Query 
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Confirmed Query List</li>
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
                        <th>Query Number</th>
						<th>Query Date</th>
                        <th>Person Name</th>
						<th>Contact Number</th>
						<th>Email</th>
						<th>Message</th>
						<th>Detail</th>
						<th>Status</th>
						<th>Source</th>
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
                        <td><?php echo $val['query_no'];?></td>
						<td><?php echo date('j M Y',strtotime($val['query_date']));?></td>
                        <td><?php echo $val['person_name'];?></td>
						<td><?php echo $val['contact_no'];?></td>
                        <td><?php echo $val['email'];?></td>
                        <td><?php echo $val['message'];?></td> 
                        <td>
							<div id="detal_<?php echo $val['query_no'];?>" style="display:none;"><?php echo $val['details'];?></div>
							
							<button type="button" rel="<?php echo $val['query_no'];?>" class="btn btn-info btn-sm viewDetail"><i class="fa fa-eye"></i></button>
							
							
						
						</td> 
                        <td>
							<?php 
								$text = 'Reply Pending';
								$color = 'orange';
								if($val['status'] == 1)
								{
									$text = 'Replied & Ongoing';
									$color = 'blue';
								}
								if($val['status'] == 2)
								{
									$text = 'Confirmed';
									$color = 'green';
								}
								if($val['status'] == 3)
								{
									$text = 'Cancelled';
									$color = 'red';
								}
							?>
							<span style="color:<?php echo $color; ?>"><b><?php echo $text; ?></b></span>
						</td> 
						<td><?php echo $val['source'];?></td> 
						<!--<td>
							<div class="btn-group btn-group-xs">
								<a href="query.php?qn=<?php echo $val['query_no'];?>" class="btn btn-info"><i class="fa fa-check"></i> Workout Panel</a>
							</div>
						</td> -->                   
						<td>
							<!-- <div class="btn-group btn-group-xs">
								<a href="query.php?qn=<?php //echo $val['query_no'];?>" class="btn btn-info" title="Workout" data-toggle="tooltip"><i class="fa fa-check"></i></a>
								<a href="add_query.php?action=edit&id=<?php //echo $val['id'];?>" class="btn btn-info" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
								<?php
								//if($userType != 'Employee')
								{
								?>
								<a href="?action=delete&id=<?php //echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
								<?php
								}
								?>
							</div> -->
							<a href="#" class="btn btn-info btn btn-primary btn-xs" style="background-color: red;">TC</a>
								<a class="btn btn-info btn btn-primary btn-xs" title="Undo Confirmed" data-toggle="tooltip" style="background-color: #0f557d;" onclick="undoConfirm('<?php echo $val['id'];?>');"><i class="fa fa-undo" aria-hidden="true"></i></i></a>
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
			    $page_result=$objAdmin->getAllConfirmedQueryResult($user_type, $empType, $queryType,$user_id);
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
			    
			     echo "<li class='queryPage'><a href='confirmed_queries.php?page=1'>First</a></li>";
			     echo "<li class='queryPage'><a href='confirmed_queries.php?page=".($page - 1)."'><<</a></li>";
			    }
			    for($i=$start_loop; $i<=$end_loop; $i++)
			    {
			    	if ($_GET['page'] == $i) {
			    		$class = 'active';
			    	}else{
			    		$class = '';
			    	}
			     echo "<li class='queryPage ".$class."'><a href='confirmed_queries.php?page=".$i."'>".$i."</a></li>";
			    }
			    if($page <= $end_loop)
			    {
			     echo "<li class='queryPage'><a href='confirmed_queries.php?page=".($page + 1)."'>>></a></li>";
			     echo "<li class='queryPage'><a href='confirmed_queries.php?page=".$total_pages."'>Last</a></li>";
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
        <h4 class="modal-title" id="modalHead">Qyery Detail</h4>
      </div>
      <div class="modal-body" id="mdetail">
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
					window.location.href='confirmed_queries.php';
				
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

</script>