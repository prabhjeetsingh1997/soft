<?php include('header.php');
	include('sidebar.php');
	 if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deleteUserById($id);
		header("location:addedUser.php");
	}
	$arrUsers=$objAdmin->user_list();
	//print_r($arrUsers);
	//print_r($_SESSION);
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             User Data 
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Super User List</li>
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
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User Type</th>
                        <th>User Name</th>
						<th>User Phone</th>
						<th>User Address</th>
						<th style="width: 46px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php foreach($arrUsers as $key=>$val){?>
                      <tr>
                        <td><?php echo $val['user_type'];?></td>
                        <td><?php echo $val['username'];?></td>
                        <td><?php echo $val['mobileno'];?></td>
                        <td><?php echo $val['parmanent_address'];?></td>
                      
						<td>
							<div class="btn-group btn-group-xs">
								<a href="addUser.php?action=edit&id=<?php echo $val['admin_id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
								<!--<a href="profile.php?action=view&id=<?php echo $val['admin_id'];?>" class="btn btn-success" ><i class="fa fa-eye"></i></a>-->
								<?php if($user_type == 'Admin') 
								{
								?>
								<a href="?action=delete&id=<?php echo $val['admin_id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								<?php }
								else{
									?>
									
								<?php }?>
							</div>
						</td>
                      </tr>
                     <?php } ?>
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