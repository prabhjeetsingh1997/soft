<?php 
include('header.php');
include('sidebar.php');

?>
		<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
	   <section class="content-header">
          <h1>
            User Profile Pic
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">User Details</li>
          </ol>
        </section>
		       <!-- Main content -->
			   <section class="content">
			   <div class="row">
			   <div class="col-md-12">
			   <div class="box box-primary">
			    <div class="box-header with-border">
                  <h3 class="box-title">Candidates Image</h3>
                </div>
				<div id="status"></div>
				<form role="form" method="POST" name="user_Image" id="user_Image" enctype="multipart/form-data">
				<div class="box-body">
				 <div class="col-sm-6">
						<div class="form-group">
						  <label for="ca_Image">Candidate Image</label>
						  <input type="file" class="form-control" id="ca_Image" name="ca_Image" placeholder="Candidate Name">
						</div>
					</div>
					
				<div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                  </div>
				  
				</div>
				</form>
				
			   </div>
			   </div>
			   </div>
			   
			   </section><!--Main Content Close-->
	  
	  </div><!--content Wrapper close-->
	  <script>
	  $(document).ready(function(){
	  $("#user_Image").validate({
		   rules:{
		ca_Image:"required"
		 },
		messages:{
				ca_Image:"Please upload your Image"
				}
								
		
		  });
	});
	  </script>
	  <?php  include('footer.php');?> 