<?php include('header.php');
	include('sidebar.php');
?>
 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             Add State and City
			</h1>
		  
         
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
				<div class="col-md-5" style="border-right:1px solid red;">
					  <h3>Add State</h3>
					  <div class="panel-body">
						
					  <form class="form-horizontal" role="form" id="add_state">
								<input type="hidden" name="type" value="state" />
								  <div class="form-group">
									  <select name="countryId" class="form-control">
											<option value="">Select Country</option>
											<?php
											$country = $users->get_country_list();
											foreach($country as $countryData)
											{
											//$getsuplier = $agent->get_supplier_from_id($countryData['supplier_id']);
											?>
												<option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country_name'];?></option>
											<?php
											}
											?>
									</select>
								  </div>
								  <div class="form-group">
										
										<input type="text" placeholder="Write State Name" id="stateName" name="stateName" class="form-control">
									  <label class="error" id="country_exists">
								  </div>
								  <div class="form-group">
									  <button type="submit" class="btn btn-danger">Add</button>
								  </div>
                              </form>
				  </div>
				  </div>
                  <div class="col-md-5 pull-right"> 
					 <h3>Add City</h3>
					  <form class="form-horizontal" role="form" id="add_city">
						<input type="hidden" name="type" value="city" />
						  <div class="form-group">
							  <select name="countryId" class="form-control" onchange="get_state(this.value)">
									<option value="">Select Country</option>
									<?php
									$country = $users->get_country_list();
									foreach($country as $countryData)
									{
									//$getsuplier = $agent->get_supplier_from_id($countryData['supplier_id']);
									?>
										<option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country_name'];?></option>
									<?php
									}
									?>
							</select>
						  </div>
						  <div class="form-group">
								<select name="stateId" id="fetchState" class="form-control">
									<option value="">Select State</option>
								</select>
						  </div>
						  <div class="form-group">
								<input type="text" placeholder="Write City Name" id="cityName" name="cityName" class="form-control">
							  <label class="error" id="city_exists">
						  </div>
						  <div class="form-group">
							  <button type="submit" class="btn btn-danger">Add City</button>
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
	  $("#add_state").validate({
            rules: {
				countryId: "required",
				stateName: "required"
            },
            messages: {
                countryId: "Please select country name",
                stateName: "Please enter state name"
            },
			submitHandler: function() { 
				$.ajax({
					type: "POST",
					url: "_ajax_manage_countries.php",
					data: $("#add_state").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						alert(html);
						if(html == 'N')
						{
							$("#country_exists").show().html('This state is already exists for this country');
							$("#inputcountry").focus();
						}
						else
						{
							if(confirm ("Your state added succesfully! Do you want to reload"))
							{
								location.reload();
								
							}
						}		
						//$("#country_exists")
						/* if(html === '1')
						{
							//window.location.href='dashboard.php';
							$(".msgst").html('<div class="alert alert-success fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Well done!</strong> Your password has been changed succesfully.</div>');
							setTimeout(function() {
							 // Do something after 5 seconds
							 $("#myModal").modal('hide');
							  }, 3000);
						}
						else
						{
							$(".msgst").html('<div class="alert alert-denger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>Well done!</strong> Your password has been changed succesfully.</div>');
							
						} */
					}
				}); 
			}
        });	
		
		$("#add_city").validate({
            rules: {
				countryId: "required",
				stateId: "required",
				cityName: "required"
            },
            messages: {
                countryId: "Please select country name",
                stateId: "Please select state name",
                cityName: "Please enter state name"
            },
			submitHandler: function() { 
				$.ajax({
					type: "POST",
					url: "_ajax_manage_countries.php",
					data: $("#add_city").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//alert(html);
						if(html == 'N')
						{
							$("#city_exists").show().html('This city is already exists for this state and country');
							$("#inputcity").focus();
						}
						else
						{
							if(confirm ("Your city added succesfully! Do you want to reload"))
							{
								location.reload();
								
							}
						}		
					}
				}); 
			}
        });

	function get_state(countryId)
	{
		var data = 'countryId='+countryId+'&type=getstate';
		$.ajax({
			type: "POST",
			url: "_ajax_manage_countries.php",
			data: data,
			cache: false,
			beforeSend:function() {
				//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
			},
			success: function(html)
			{
				//alert(html);
				$("#fetchState").html(html);
				
			}
		});
	}		
	  </script>
<?php include('footer.php');?>