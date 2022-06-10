<?php 
	include('header.php');
	include('sidebar.php');
	if($_GET['action']=='delete')
	{
		$id=$_GET['id'];
		$objAdmin->deleteItineraryById($id);
		header("location:itienarylist.php");
	} 
	$arrItinerary=$objAdmin->getAllItinerary();
	//print_r($arrItinerary);
	
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
                        <th>Title</th>
						<th>Country</th>
						<th>State</th>
						<th>City</th>
						<th>Duration (Night & Days)</th>
						<th style="width: 46px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					$count=1;
					
					foreach($arrItinerary as $key=>$val)
					{
						$i=0;
						$j=0;
						$k=0;
						$state='';
						$city='';
						$newArr = array();
						$newArrCity=array();
						
						$countryId=$val['country'];
						$arrState=explode(',',$val['state']);
						$arrCity=explode(',',$val['city']);
						foreach($arrState as $value)
						{
							$state=$objAdmin->getStateNameById($value);
							$newArr[$j]=$state;
							$j++;
						}
						foreach($arrCity as $valueCity)
						{
							$cityName=$objAdmin->getCityById($valueCity);
							$newArrCity[$k]=$cityName;
							$k++;
						}
						$country=$objAdmin->getCountryNameById($countryId);
						
						$duration = $val['duration'];
						?>
                      <tr>
                        <td><?php echo $val['title'];?></td>
                        <td><?php echo $country[$i]['country_name'];?></td>
                        <td><?php foreach($newArr as $stateName){echo $stateName[0]['state_name'].", ";}?></td>
                        <td><?php foreach($newArrCity as $cityName){echo $cityName[0]['city'].", ";}?></td>
						<td><?php echo ($duration-1). ' Nights & '.$duration.' Days';?></td>                   
						<td>
							<div class="btn-group btn-group-xs">
								<a href="itienary.php?action=edit&id=<?php echo $val['id'];?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
								
								<a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								
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