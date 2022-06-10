<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objtravel->deleteTravelAgentById($id);
		header("location:travel_Agent_list.php");
	}  
	$url= trim($_SERVER['HTTP_HOST'], '/');
    if (!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
    $arrTravelAgent=$objtravel->getAllTravelAgent($domain);
	
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Clients Data 
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Clients List</li>
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
                        <th>S.No</th>
                        <th>Hotel Name</th>
						<th>Travel Agent Id</th>
            <th>Password</th>
						<th>Currency</th>
						<th>Emails</th>
						<th>Description</th>
						<!-- <th>view</th> -->
						<th style="width: 46px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					$count=1;
					foreach($arrTravelAgent as $key=>$val)
					{
						?>
                      <tr>
                        <td><?php echo $count++;?></td>
                        <td><?php echo $val['hotal_name'];?></td>
                        <td><?php echo $val['travel_agentr_id'];?></td>
                        <td><?php echo $val['travel_agent_password'];?></td>
                        <td><?php echo $val['base_currency'];?></td>
                        <td>
							<?php 
								print_r($val['additional_email_address']);
								//echo $emailArr = $val['primary_email']; 
								//echo implode($emailArr,',');
							?>
						</td>
						<td><?php echo $val['description'];?></td>
                       <!--  <td><a href='#'>view</td>  -->                     
						<td>
							<div class="btn-group btn-group-xs">
								<a href="travel_Agent.php?action=edit&id=<?php echo $val['id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
								
								<a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								
							</div>
						</td>
                      </tr>
                     <?php
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