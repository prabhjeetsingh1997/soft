<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deleteQueryById($id);
		header("location:view_query.php");
	} 
	//print_r($_SESSION);
	//Array ( [admin_Id] => 104 [user_type] => Employee [employee_type] => 0 [employee_Id] => LiDE0104 [admin_Email] => LiDE0104 ) asdfasldfklasdhfsadhkfhkasdfhlsahdflsahdfdashfhasdha::::104::::Employee::::0:::1SELECT * FROM query WHERE employeeId = 104 AND query_type = 1 ORDER BY id DESC


	//Array ( [admin_Id] => 136 [user_type] => Employee [employee_type] => 0 [admin_Email] => LiDE0136 )
	//Array ( [admin_Id] => 136 [user_type] => Employee [admin_Email] => LiDE0136 )
	//Array ( [admin_Id] => 73 [user_type] => admin [employee_type] => 1 [admin_Email] => admin@gmail.com )
	
	$userType = $_SESSION['user_type'];
	$empType = $queryType = $_SESSION['employee_type'];

	$arrQuery=$objAdmin->getAllQuery($admin_Id, $user_type, $empType, 0);
	//print_r($arrItinerary);
	
	
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Query Data 
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Query List</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box">
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
							<div class="btn-group btn-group-xs">
								<a href="query.php?qn=<?php echo $val['query_no'];?>" class="btn btn-info" title="Workout" data-toggle="tooltip"><i class="fa fa-check"></i></a>
								<a href="add_query.php?action=edit&id=<?php echo $val['id'];?>" class="btn btn-info" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
								<?php
								if($userType != 'Employee')
								{
								?>
								<a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
								<?php
								}
								?>
							</div>
						</td>
                      </tr>
                     <?php
					 $i++;
					 } 
					 ?>
					 </tbody>
					 
                  </table>
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
          "paging"      : true,
          "lengthChange": true,
          "searching"   : true,
          "info"        : true,
          "autoWidth"   : false,
		  "bSort"       : false,
		  
        });
		
		$(".viewDetail").click(function(){
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