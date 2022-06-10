<?php 
    include('header.php');
	include('sidebar.php');
	 if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deleteUserById($id);
		header("Location:userlist.php");
	}
	
	$url= trim($_SERVER['HTTP_HOST'], '/');
    if (!preg_match('#^http(s)?://#', $url)) 
    {
    $url = 'http://' . $url;
    }
    $urlParts = parse_url($url);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
	$arrUsers=$objAdmin->user_list($domain);
	//print_r($arrUsers);exit;
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Employee Data 
		</h1>
		 
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Employee List</li>
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
                        <th>Name </th>
                        <th>Contact Numbers </th>
                        <th>Employee ID </th>
                        <th>Password </th>
						<th>Designation</th>
						<th>Department</th>
						<th>Documents</th>
						<th>Employee Type</th>
						<th style="width: 46px;">Action</th>
						<th style="width: 46px;">View</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					foreach($arrUsers as $key=>$val){
						$designId=$val['designation'];
						$departId=$val['department'];
						$userp = $val['password'];
						$arrDesignation=$objAdmin->getDesignationById($designId);
						$arrDepartment=$objAdmin->getDepartmentById($departId);
						
						$phones=$objAdmin->getPhoneNumbers($val['admin_id'], 'employee', 'personal');
						//print_r($phones);
						$pHn = '';
						foreach($phones as $numbers)
						{
							$pHn .= $numbers['contact_no'].', ';
						}
						$pHn = rtrim($pHn,', ');
						
						$attachdoc = $objAdmin->getdocumentbyid($val['admin_id'],'Employee');
						//print_r($attachdoc);
					?>
                      <tr>
                        <td><?php echo $val['name_perfix'].' '.$val['first_name'].' '.$val['middle_name'].' '.$val['last_name'];?></td>
                        <td><?php echo $pHn;?></td>
                        <td><?php echo $val['user_id'];?></td>
                        <td><?php echo base64_decode($userp);?></td>
						<td><?php echo $arrDesignation[0]['designation_name'];?></td>
						<td><?php echo $arrDepartment[0]['department_name'];?></td>
						<td>
							<?php 
								

								foreach($attachdoc as $files)
								{
								$filesDocArr = explode(',',trim($files['doc'],','));
								foreach($filesDocArr as $docs)
								{
									if($files['name']=='PAN Card' || $files['name']=='Photo')
									{
									 $filePath = APP_URL.'/document/hotel_doc/'.$val['admin_id'].'/'.$docs;
									}
									else if($files['name']=='Address Proof' || $files['name']=='Adhaar Card' || $files['name']=='Passport')
									{
									$filePath = APP_URL.'/document/client_doc/'.$val['admin_id'].'/'.$docs;
									}
									else
									{
									 $filePath = APP_URL.'/document/emp_doc/'.$val['admin_id'].'/'.$docs;	
									}
							?>
								<a target="_blank" href="<?php echo $filePath; ?>" title="<?php echo ucfirst($files['name'])?>"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php	
								}
								}
							?>		
						</td>
						<td><?php 
							$arrDepartment[0]['department_name'];
							if($val['employee_type'])
							{
								echo 'Internal';
							}
							else
							{
								echo '<span class="error">External</span>';
							}
						?></td>
						<td>
							<div class="btn-group btn-group-xs">
								<a href="addUser.php?action=edit&id=<?php echo $val['admin_id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
								<!--<a href="profile.php?action=view&id=<?php echo $val['admin_id'];?>" class="btn btn-success" ><i class="fa fa-eye"></i></a>-->
								
								<a href="?action=delete&id=<?php echo $val['admin_id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								
							</div>
						</td>
						<td>
							<a href="addressView.php?action=addrView&id=<?php echo $val['admin_id'];?>" class="btn btn-success" ><i class="fa fa-eye"></i></a>
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