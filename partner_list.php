<?php 
    include('header.php');
	include('sidebar.php');
	 if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deletePartnerById($id);
		header("Location:partner_list.php");
	}
	$arrUsers=$objAdmin->partner_list();
	//print_r($_SESSION);
	/*print_r($arrUsers);
	exit;*/

 /* function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
   //$_SERVER['REQUEST_URI']
  );
}*/

?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Partner Data 
		</h1>
		 
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Partner List</li>
          </ol>
		  
		  <div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<a href="exportEmp.php" target="_blank" class="btn btn-primary" name="tableToExcelBtn" id="tableToExcelBtn" value="" style=" margin-top: 25px;">ExportToExcel</a>
				</div>
			</div>
		</div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
		  <!--<form action="export.php" method="post" name="export_excel">
			<div class="col-sm-2">
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="tableToExcelBtn" id="tableToExcelBtn" value="" style=" margin-top: 25px;">ExportToExcel</button>
				</div>
			</div>
			</form>-->
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
                        <th>Partner Names</th>
                        <th>Contact Numbers</th>
                        <th>Email</th>
                        <th>User Name</th>
                        <th>Password</th>
						<th>Address</th>
						<th>URL Link</th>
						<th>Hotel Markup</th>
						<th>Package Markup</th>
						<th>Logo</th>
						<th style="width: 46px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					foreach($arrUsers as $key=>$val){
						
						//print_r($attachdoc);
					?>
                      <tr>
                        <td><?php echo $val['partner_name'] ?></td>
                        <td><?php echo $val['contact_no'] ?></td>
                        <td><?php echo $val['email'] ?></td>
                        <td><?php echo $val['user_name'] ?></td>
                        <td><?php echo $val['password'] ?></td>
                        <td><?php echo $val['address'] ?></td>
                        <td><?php echo $val['url_link'] ?></td>
                        <td><?php echo $val['hotel_markup'] ?></td>
                        <td><?php echo $val['package_markup'] ?></td>
                        <td><img src="http://<?php echo $val['url_link'] ?>/<?php echo $val['logo'] ?>" style="width:50px; height:50px;"/></td> 
 
                        <td>
							<div class="btn-group btn-group-xs">
								<a href="partner_register.php?action=edit&id=<?php echo $val['id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
			
								<a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								
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