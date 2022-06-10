<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objclient->deleteClientById($id);
		header("location:clientlist.php");
	} 
	$arrUsers=$objclient->client_list();
	//print_r($arrUsers);
	//print_r($_SESSION);
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
		  
		  <div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<a href="exportClient.php" target="_blank" class="btn btn-primary" name="tableToExcelBtn" id="tableToExcelBtn" value="" style=" margin-top: 25px;">ExportToExcel</a>
				</div>
			</div>
		</div>
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
                        <th>Name </th>
                        <th>Contact Number </th>
                        <th>Email</th>
                        <th>Organization</th>
						<th>Client Id</th>
						<th>Password</th>
						<th>Documents</th>
						<th style="width: 46px;">Action</th>
						<!--<th>view </th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php foreach($arrUsers as $key=>$val){
						//$clientPrsnlNum=$objclient->getClientNumberByid($val['client_id'],'client_personal');
						
						$clientPrsnlNum=$objAdmin->getPhoneNumbers($val['client_id'], 'client', 'client_personal');
						
						$pHn = '';
						foreach($clientPrsnlNum as $numbers)
						{
							$pHn .= $numbers['contact_no'].', ';
						}
						$pHn = rtrim($pHn,', ');
					?>
                      <tr>
                        <td><?php echo $val['name_perfix'].' '.$val['first_name'].' '.$val['middle_name'].' '.$val['last_name'];?></td>
                        <td><?php echo $pHn;?></td>
                        <td><?php echo $val['primary_email'];?></td>
                        <td><?php echo $val['organization'];?></td>
                        <td><?php echo $val['client_login_id'];?></td>
                        <td><?php echo $val['client_login_password'];?></td>
						<td>
							<?php 
								$attachdoc = $objAdmin->getdocumentbyid($val['client_id'],'Client');
								//print_r($attachdoc);
								foreach($attachdoc as $files)
								{
								$filesDocArr = explode(',',trim($files['doc'],','));
								foreach($filesDocArr as $docs)
								{
									if($files['name']=='PAN Card' || $files['name']=='Photo')
									{
										$filePath = APP_URL.'/document/hotel_doc/'.$val['client_id'].'/'.$docs;
									}
									else
									{
									$filePath = APP_URL.'/document/client_doc/'.$val['client_id'].'/'.$docs;
									}
							?>
								<a target="_blank" href="<?php echo $filePath; ?>" title="<?php echo ucfirst($files['name'])?>"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php	
								}
								}
							?>		
						</td>
                        <td>
							<div class="btn-group btn-group-xs">
								<a href="client.php?action=edit&id=<?php echo $val['client_id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
								<!--<a href="profile.php?action=view&id=<?php echo $val['client_id'];?>" class="btn btn-success" ><i class="fa fa-eye"></i></a>-->
								
								<a href="?action=delete&id=<?php echo $val['client_id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								
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