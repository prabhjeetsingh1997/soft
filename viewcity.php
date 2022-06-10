<?php include('header.php');
	include('sidebar.php');
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             View Cities
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cities List</li>
          </ol>
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
                  <table id="example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
						<th>City</th>
						  <th>State</th>
						  <th>Country</th>
						<th class="hidden-phone">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						$city = $objAdmin->get_city_list_full();
						//print_r($country);
					  $i=1;
					   foreach($city as $stateData)
					  {
						  //$getstate = $objAdmin->get_StateBystateId($stateData['statemasterid']);
					?>
                      <tr>
						<td><?php echo $stateData['city'];?></td>
						<td><?php echo $stateData['state'];?></td>
						<td><?php echo $stateData['country'];?></td>
						<td class="hidden-phone"> 
							<a href="edit_master.php?action=city&id=<?php echo $stateData['id'];?>&stateId=<?php echo $stateData['stateId'];?>" title="Edit" class="btn btn-primary" style="margin-left:12px;"><i class="fa fa-pencil"></i> Edit</a>
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
        $('#example').DataTable({
          "paging"      : true,
          "lengthChange": true,
          "searching"   : true,
          "info"        : true,
          "autoWidth"   : false,
		  "bSort"       : false,
		  
        });
      });
    </script>
<?php include('footer.php');?>