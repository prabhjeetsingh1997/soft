<?php include('header.php');
	include('sidebar.php');
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             View states
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">States List</li>
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
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
						<th>State</th>
						<th>Country</th>
						<th class="hidden-phone">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						$state = $objAdmin->get_state_list_full();
						$i=1;
						foreach($state as $stateData)
						{
							$getcountry = $objAdmin->get_countryBystateId($stateData['countrymasterid']);
							//print_r($getcountry);
					?>
                      <tr>
						<td><?php echo $stateData['state_name'];?></td>
						<td><?php echo $getcountry;?></td>

						<td class="hidden-phone"> 
							<a href="edit_master.php?action=state&id=<?php echo $stateData['id'];?>&countryId=<?php echo $stateData['countrymasterid'];?>" title="Edit" class="btn btn-primary" style="margin-left:12px;"><i class="fa fa-pencil"></i> Edit</a>
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
    </script>
<?php include('footer.php');?>