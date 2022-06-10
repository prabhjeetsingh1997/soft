<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objhotel->deleteHotelById($id);
		header("location:hotel_list.php");
	}  
	$arrUsers=$objhotel->getAllHotel();
	//print_r($arrUsers);
	//print_r($_SESSION);
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Hotels
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Hotels List</li>
          </ol>
		  
		 <div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<a href="exportHotel.php" target="_blank" class="btn btn-primary" name="tableToExcelBtn" id="tableToExcelBtn" value="" style=" margin-top: 25px;">ExportToExcel</a>
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
                        <th>Hotel Name</th>
                        <th>Location</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Star Rating</th>
						<th>Hotel Id</th>
						<th>Concerned Person Name</th>
						<th>Concerned Person Contact Nos</th>
						<th>Email</th>
						<th>Password</th>
						<th>Documents</th>
						<th style="width: 46px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php foreach($arrUsers as $key=>$val){
						$hotel_address_details = $objhotel->getHotelAddressById($val['hotel_id'],'hotel_permanent_addr');
						//print_r($hotel_address_details);
						$city = '';
						$country = '';
						$state = '';
						$location = '';
						foreach($hotel_address_details as $hd)
						{
							$arrState=$objAdmin->getStateNameById($hd['state']);
							$arrCity=$objAdmin->getCityById($hd['city']);
							$arrCountry=$objAdmin->getCountryNameById($hd['country']);
							$city = $arrCity[0]['city'];
							$country = $arrCountry[0]['country_name'];
							$state = $arrState[0]['state_name'];
							$location = $hd['address2'];
						}
						
						$concern_prsn=$objhotel->getConcPrsnByid($val['hotel_id']);
						//print_r($concern_prsn_detail);
					
						$conPerName = $concern_prsn[0]['title'].' '.$concern_prsn[0]['first_name'].' '.$concern_prsn[0]['middlename'].' '.$concern_prsn[0]['lastname'];
						
						//$concern_person_numbers = $objhotel->getNumberByid($val['hotel_id'],'hotel_concern_person');
						
						$concern_person_numbers=$objAdmin->getPhoneNumbers($val['hotel_id'], 'hotel', 'hotel_concern_person');
						
						$pHn = '';
						foreach($concern_person_numbers as $numbers)
						{
							$pHn .= $numbers['contact_no'].', ';
						}
						$pHn = rtrim($pHn,', ');
						
						$attachdoc = $objAdmin->getdocumentbyid($val['hotel_id'],'Hotel');
					?>
                      <tr>
                        <td><?php echo $val['hotel_name'];?></td>
						<td><?php echo $location;?></td>
                        <td><?php echo $city;?></td>
                        <td><?php echo $state;?></td>
                        <td><?php echo $country;?></td>
						<td><?php echo $val['star_rating'];?></td>
                        <td><?php echo $val['hotel_user_id'];?></td>
                        <td><?php echo $conPerName;?></td>
                        <td><?php echo $pHn;?></td>
                        <td><?php echo $val['primary_email'];?></td>
                        <td><?php echo $val['hotel_user_pass'];?></td>
                        <td>
							<?php 
								//print_r($attachdoc);
								foreach($attachdoc as $files)
								{
									//echo $files;
									$filesDocArr = explode(',',trim($files['doc'],','));
									//$filesDocArr = explode(',',$files['doc']);
									//print_r($filesDocArr);
									foreach($filesDocArr as $docs)
									{
										if($docs!="")
										{
										$filePath = APP_URL.'/document/hotel_doc/'.$val['hotel_id'].'/'.$docs;
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
								<a href="hotel.php?action=edit&id=<?php echo $val['hotel_id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
								<!--<a href="profile.php?action=view&id=<?php echo $val['hotel_id'];?>" class="btn btn-success" ><i class="fa fa-eye"></i></a>-->
								
								<a href="?action=delete&id=<?php echo $val['hotel_id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								
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