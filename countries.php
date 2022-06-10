<?php include('header.php');
	include('sidebar.php');
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Countries
			</h1>
		  
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Countries</li>
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
				<div class="col-md-4" style="border-right:1px solid red;">
					  <h3>Add Country</h3>
					  <div class="panel-body">
						
					  <form class="form-horizontal" role="form" id="add_country">
						<input type="hidden" name="type" value="country" />
						  <div class="form-group">
							  
							  <input type="text" placeholder="Write Country Name" id="inputcountry" name="inputcountry" class="form-control">
							  <label class="error" id="country_exists"></div>
						  </div>
						  <div class="form-group">
							  <button type="submit" class="btn btn-danger">Add</button>
						  </div>
					  </form>
				  </div>
                  <div class="col-md-8">
					  <form name="frm" method="post" action="agent-del.php" enctype="multipart/form-data">
							<div class="adv-table">
								<table  class="display table table-bordered table-striped" id="example">
								  <thead>
								  <tr>
									  <th>Country</th>
									  <th class="hidden-phone">Action</th>
								  </tr>
								  </thead>
								  <tbody>
								  <?php
									$country = $users->get_country_list();
									//print_r($country);
								  $i=1;
								   foreach($country as $countryData)
								  {
									 // print_r($countryData);
									  //die;
									  //$getsuplier = $agent->get_supplier_from_id($countryData['supplier_id']);
								?>
								  <tr class="gradeX">
									<td><?php echo $countryData['country_name'];?></td>
									<td class="hidden-phone"> 
										<a href="edit_master.php?action=country&id=<?php echo $countryData['id'];?>" title="Edit" class="btn btn-primary" style="margin-left:12px;"><i class="fa fa-pencil"></i> Edit</a>
									</td>
								  </tr>
								  <?php $i++;}?>
								  </tbody>
								</table>
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
	  
	  $("#add_country").validate({
            rules: {
				inputcountry: "required"
            },
            messages: {
                inputcountry: "Please enter country name"
            },
			submitHandler: function() { 
				$.ajax({
					type: "POST",
					url: "_ajax_manage_countries.php",
					data: $("#add_country").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						alert(html);
						if(html == 'N')
						{
							$("#country_exists").show().html('This country is already exists');
							$("#inputcountry").focus();
						}
						else
						{
							if(confirm ("Your country added succesfully! Do you want to reload"))
							{
								location.reload();
								
							}
						}		
						
					}
				}); 
			}
        });	
    </script>
<?php include('footer.php');?>