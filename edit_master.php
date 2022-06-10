<?php include('header.php');
	include('sidebar.php');
	
	//print_r($_GET);
	
	$editId = $_GET['id'];
	$type = $_GET['action'];
	$countryId = $_GET['countryId'];
	
	if($type == 'state')
	{
		$stateData = $objAdmin->get_stateByItsId($editId);
		$name = $stateData['state_name'];
	}
	else if($type == 'city')
	{
		$cityData = $objAdmin->getCityById($editId);
		//print_r($cityData);
		$name = $cityData[0]['city'];
	}
	else
	{
		$countryData = $objAdmin->getCountryNameById($editId);
		//print_r($countryData);
		$name = $countryData[0]['country_name'];
	}


?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
             Edit <?php echo ucfirst($type); ?>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Edit <?php echo ucfirst($type); ?></li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">		
            <div class="col-xs-12">
               <div class="box">
             
                <div class="box-body table-responsive">
					<div class="col-md-6">
						<form class="form-horizontal" role="form" id="edit_master" novalidate="novalidate">
							<input type="hidden" name="type" value="<?php echo $type; ?>">
							<input type="hidden" name="id" value="<?php echo $editId; ?>">
							<input type="hidden" name="countryId" value="<?php echo $countryId; ?>">
							<div class="form-group">
							  <label for="exampleInputEmail1"><?php echo $type; ?> Name</label>
							  <input type="text" placeholder="<?php echo $type; ?> Name" id="editItem" name="editItem" value="<?php echo $name; ?>" class="form-control">
							</div>
							  
							<div class="form-group">
							  <button type="submit" class="btn btn-danger">Edit</button>
							</div>  
						</form>
					</div>
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
	  
	  $("#edit_master").validate({
            rules: {
				editItem: "required"
            },
            messages: {
                editItem: "Please enter any name"
            },
			submitHandler: function() { 
				$.ajax({
					type: "POST",
					url: "_ajax_manage_masters.php",
					data: $("#edit_master").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//alert(html);
						if(html == '1')
						{
							alert('Data updated succesfully.');
							//location.reload();
						}
						else
						{
							alert('There is some problem with updating the data.');
						}		
						
					}
				}); 
			}
        });	
    </script>
<?php include('footer.php');?>