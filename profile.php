<?php include('header.php');
	  include('sidebar.php');
      $id=$_GET['id'];
	  $arrUserDetails=$objAdmin->getuserdetailsbyId($id);
	  $arrColor   = array('1'=>'fair','2'=>'wheatish','3'=>'dark');
	  $arrCast    = array('1'=>'Svetambara','2'=>'Digambara');
	  $arrBandhan = array('1'=>'Yes','2'=>'No');
	  $arrManglik = array('1'=>'Yes','2'=>'No');
	  
	  
	  
	  
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
             <h1>User Profile</h1>
			  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Examples</a></li>
				<li class="active">User profile</li>
			  </ol>
        </section>
<script src="asset/plugins/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="asset/plugins/uploadify/uploadify.css">
        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">
              <!-- Profile Image -->
                <div class="box box-primary">
					<div class="box-body box-profile">
					    <div id="imgProfile_upload" align="center">
<img style="width:100px;height:100px;" class="profile-user-img img-responsive img-circle"  src="upload/<?php echo $arrUserDetails[0]['profilePic'];?>" alt="User profile picture">
						</div>
						<div align="center">
							<form>
							   <div id="queue"></div>
							   <input id="profileimage_upload" name="profileimage_upload" type="file" multiple="true">
							</form>
						</div>
					    <h3 class="profile-username text-center"><?php echo $arrUserDetails[0]['username'];?></h3>
					    <p class="text-muted text-center"><?php echo $arrUserDetails[0]['user_prof'];?></p>

						<ul class="list-group list-group-unbordered" style="display:none;">
							<li class="list-group-item">
								 <b>Followers</b> <a class="pull-right">1,322</a>
							</li>
							<li class="list-group-item">
								 <b>Following</b> <a class="pull-right">543</a>
							</li>
							<li class="list-group-item">
								 <b>Friends</b> <a class="pull-right">13,287</a>
							</li>
						</ul>

					    <a href="#" class="btn btn-primary btn-block" style="display:none;"><b>Follow</b></a>
					</div><!-- /.box-body -->
                </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">About Me</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                  <p class="text-muted">
                   <?php echo $arrUserDetails[0]['user_edu'];?>
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                  <p class="text-muted"><?php echo $arrUserDetails[0]['user_curr_addr'];?></p>

                  <hr>

                  <strong style="display:none;"><i class="fa fa-pencil margin-r-5" ></i> Skills</strong>
                  <p style="display:none;">
                    <span class="label label-danger">UI Design</span>
                    <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span>
                  </p>

                  <hr>

                  <strong style="display:none;"><i class="fa fa-file-text-o margin-r-5" ></i> Notes</strong>
                  <p style="display:none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9" style="padding:0">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#candidates_details" data-toggle="tab">Personal Details</a></li>
                  <li><a href="#birth_Physical_description" data-toggle="tab">Birth & Physical Description</a></li>
                  <li><a href="#nakshtra_gotra_details" data-toggle="tab">Nakshtra & Gotra Details</a></li>
				  <li><a href="#family_details" data-toggle="tab">Family Details</a></li>
                  <li><a href="#siblings_details" data-toggle="tab">Siblings Details</a></li>
				  <li><a href="#Contact_details" data-toggle="tab">Contact Details</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="candidates_details">
					    <div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Candidate Name</a> <?php echo $arrUserDetails[0]['username'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Monthly Income</a> <?php echo $arrUserDetails[0]['user_mon_inc'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Candidate Address</a> <?php echo $arrUserDetails[0]['user_curr_addr'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Candidate Mobile</a> <?php echo $arrUserDetails[0]['user_mobile'];?></h5>
						</div>
				         				                    
				    </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="birth_Physical_description">
				
                       <div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Date of Birth</a> <?php echo $arrUserDetails[0]['date_of_birth'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Birth Time</a> <?php echo $arrUserDetails[0]['birth_time'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Place</a> <?php echo $arrUserDetails[0]['birth_place'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Height</a> 
								<?php 
									$height = $arrUserDetails[0]['height'];
									$height_new = rtrim($height,'0').'"';
									echo $height = str_replace(".","'",$height_new);
									//echo $arrUserDetails[0]['height'];
								?>
							</h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Weight</a> <?php echo $arrUserDetails[0]['weight'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Color</a> 
							<?php echo $arrColor[$arrUserDetails[0]['color']];?></h5>
						</div>
				  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="nakshtra_gotra_details">
                      
					    <div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Cast Details</a> <?php echo $arrCast[$arrUserDetails[0]['cast_detail']];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Gotra</a> <?php echo $arrUserDetails[0]['gotra'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Mama Gotra</a> <?php echo $arrUserDetails[0]['mama_gotra'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Bandhan</a> <?php echo $arrBandhan[$arrUserDetails[0]['bandhan']];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Manglik</a> <?php echo $arrManglik[$arrUserDetails[0]['manglik']];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Nakshtra</a> <?php echo $arrUserDetails[0]['nakshtra'];?></h5>
						</div>
						
				  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="family_details">
                  
					    <div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Father Name</a> <?php echo $arrUserDetails[0]['father_name'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Address</a> <?php echo $arrUserDetails[0]['father_addr'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Profession</a> <?php echo $arrUserDetails[0]['father_Prof'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Monthly Income</a> <?php echo $arrUserDetails[0]['father_mon_income'];?></h5>
						</div>
						<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Mobile Number</a> <?php echo $arrUserDetails[0]['father_mobile'];?></h5>
						</div>
				  </div><!-- /.tab-pane -->
				  <div class="tab-pane" id="siblings_details">        
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Married Brothers</a> <?php echo $arrUserDetails[0]['married_bro'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Unmarried Brothers</a> <?php echo $arrUserDetails[0]['unmarried_bro'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Married Sister</a> <?php echo $arrUserDetails[0]['married_sis'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Unmarried Sisters</a> <?php echo $arrUserDetails[0]['unmarried_sis'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">Residence type</a> <?php echo $arrUserDetails[0]['residence_type'];?></h5>
					</div>
				  </div><!-- /.tab-pane -->
				  
				  <div class="tab-pane" id="Contact_details">        
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">1<sup>st<sup> Contact Name</a> <?php echo $arrUserDetails[0]['contact_Name_One'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">1<sup>st<sup> Contact Address</a> <?php echo $arrUserDetails[0]['contact_Addr_One'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">1<sup>st<sup> Contact Number</a> <?php echo $arrUserDetails[0]['contact_Num_One'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">2<sup>nd<sup> Contact Name</a> <?php echo $arrUserDetails[0]['contact_Name_Sec'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">2<sup>nd<sup> Contact Address</a> <?php echo $arrUserDetails[0]['contact_Addr_Sec'];?></h5>
					</div>
					<div class="timeline-item">
							<h5 class="timeline-header no-border"><a href="#">2<sup>nd<sup> Contact Number</a> <?php echo $arrUserDetails[0]['contact_Num_Sec'];?></h5>
					</div>
				  </div><!-- /.tab-pane -->
				  
				</div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <script>
	    $(document ).ready(function() {
	     $('#profileimage_upload').uploadify({
				'formData'     : {
				    'flag'      : 'profile_image',
					'p_id'      : <?php echo $_GET['id'];?>
				},
				'onSelect' : function(file) {
                  $('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
                 },
				'buttonImage' : 'asset/plugins/uploadify/browse-btn.png',
				'buttonText' : 'Add Profile Pic',
				'multi': false,
				'swf'      : 'asset/plugins/uploadify/uploadify.swf',
				'uploader' : '_ajax_user_authentication.php',
				'onUploadSuccess': function (file, data, response) {
				   
				     var extension = file.name.replace(/^.*\./, '');
					 var a=$.parseJSON(data);
					 
					var imgName=a.imagename;
					$('#imgProfile_upload').html('<img alt="profile image" class="profile-user-img img-responsive img-circle" src="upload/'+imgName+'" >');
					
					}
				
			});
		});
	  </script>
  <?php include('footer.php');?>