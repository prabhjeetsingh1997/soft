<?php
include('header.php');
include('sidebar.php');

@$hotelId =  $_SESSION['hotelId'];
/* if($_GET['action']=='edit')
{
	$editUserId=$_GET['id'];
	$usrData = $objAdmin->getUsrById($editUserId);

	//print_r($usrData);
} */


 
 //$prsnl_detail = $objhotel->hotel_doc_detail($pan_file_name,$photo_file_name,$password_file_name,$hotelId);


?>
<link href="uploadify/uploadify.css" rel="stylesheet">
<style>
.v_hidden{visibility:hidden !important}
</style>
<script src="uploadify/jquery.uploadify.js"></script>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Hotel Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Add Hotel</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">
				<div class="box-header with-border">
				 <ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>HOTEL DETAILS</b></h3></a></li>
				  <li><a data-toggle="tab" href="#menu1"><h3 class="box-title"><b>MORE DETAILS</b></h3> </a></li>
				    <li><a data-toggle="tab" href="#menu2"><h3 class="box-title"><b>BANKING DETAILS</b></h3> </a></li>
				  <li><a data-toggle="tab" href="#menu3"><h3 class="box-title"><b>ATTACHED DOCUMENTS</b></h3> </a></li>
				   <li><a data-toggle="tab" href="#menu4"><h3 class="box-title"><b>RATES</b></h3> </a></li>
				</ul>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
					<form role="form" method="POST" name="hotal_personl_detail" id="hotal_personl_detail">
					 <input type="hidden" id="address1" name="address1" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
						<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
						<input type="hidden" name="type" value="add_hotel_prsnl_detail" />
						<div class="box-body">
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	 Hotal Name </b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<label for="name">Hotal Name</label>
										<input type="text" class="form-control" name="hotel_name" id="hotel_name" placeholder="Hotal Name" value=""/>
									</div>
								</div><!-- /.form-group -->
								
								<!-- /.first line -->
						<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Permanent Address </b></h4>
									</div>
								</div>
								<div class="items">
								<div id="address_1">
								<div class="col-md-2">
									<div class="form-group">
										<label for="userPhone">Address Line 1</label>
										<input type="text" class="form-control" name="hotel_address1[]" id="hotel_address1" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								
									<div class="col-md-2">
									<div class="form-group">
										<label for="userPhone">Address Line 2</label>
										<input type="text" class="form-control" name="hotel_address2[]" id="hotel_address2" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="middle">City</label>
										<input type="text" class="form-control" name="hotel_city[]" id="hotel_city" placeholder="City" value=""/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="last">State</label>
										<input type="text" class="form-control" name="hotel_state[]" id="hotel_state" placeholder="State" value=""/>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Pin Code</label>
										<input type="text" class="form-control" name="hotel_pincode[]" id="hotel_pincode" placeholder="Code" value=""/>
									</div>
								</div>
								</div>
								
								
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="add_more_items" id="add_more_items" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								
							</div>
								
								<!-- /.second line -->
								
							
								<!-- /.second line -->
								<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Contact Nos </b></h4>
									</div>
								</div>
								<div class="items3">
								<div id="Mobnumbbr_1">
								<div class="col-md-3">
									<div class="form-group">
										<label for="userPhone">Mobile</label>
										<input type="number" class="form-control" name="hotelPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="middle">Code</label>
										<select class="form-control valid" name="hotelCode[]" placeholder="Code" value="" aria-invalid="false">
											<option value="Mobile">Mobile</option>
											<option value="Home">Home</option>
											<option value="Work">Work</option>
											<option value="Main">Main</option>
											<option value="WorkFax">Work Fax</option>
											<option value="HomeFax">Home Fax</option>
											<option value="Pager">Pager</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<!--<div class="col-md-3">
									<div class="form-group">
										<label for="middle">Code</label>
										<input type="text" class="form-control" name="code[]" id="code" placeholder="Code" value=""/>
									</div>
								</div>-->
								<div class="col-md-3 v_hidden">
									<div class="form-group">
										<label for="last">Enter valid Number</label>
										<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
									</div>
								</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="Mnumbbr"  id="Mnumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								</div>
								
								<!-- /.second line -->
								<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Rooms </b></h4>
									</div>
								</div>
								<div class="items1">
								<div id="address2_1">
								<div class="col-md-2">
									<div class="form-group">
										<label for="roomstype">Room Type</label>
										<input type="text" class="form-control" name="roomstype[]"id="hotel_roomstype" placeholder="Room Type" value=""/>
									</div>
								</div>
								
									<div class="col-md-2">
									<div class="form-group">
										<label for="RDescription">Room Description</label>
										<input type="text" class="form-control" name="RDescription[]" id="RDescription" placeholder="Room Description" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="AminitiesF">Aminities & Facilities</label>
										<input type="text" class="form-control" name="AminitiesF[]" id="AminitiesF" placeholder="Aminities & Facilities" value=""/>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="Units">Units</label>
										<input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value=""/>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="Pics">Pics</label>
										<input type="text" class="form-control" name="Pics[]" id="Pics" placeholder="Pics" value=""/>
									</div>
								</div>
								</div>
								
								
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="add_more_items1" id="add_more_items1" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								
							</div>
								
							<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Hotel Type</b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<label for="userPhone">Hotel type</label>
										<select class="form-control" name="hotel_type" id="hotel_type">
										<option>Hotel</option>
										<option>Resort</option>
										<option> Motel</option>
										<option>BnB</option>
										<option>Homestay</option>
										<option>Tent</option>
										<option>Service Apartment</option>
										<option>Bungalow</option>
										<option>Lodge</option>
										<option>Guest House</option>
										<option>Hostel</option>
										<option>Cottage</option>
										<option>Houseboat</option>
										<option> Villa</option>
										<option>Palace</option>
										<option>Beach Hut</option>
										<option> Farm</option>
										</select>
									</div>
								</div>
								
								
								
								<!-- /.third line -->
								<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Base Currency</b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<label for="userPhone">Base Currency</label>
										<select class="form-control" name="hotel_currency" id="hotel_currency">
										<option>Select</option>
										<option>USD </option>
										<option>INR </option>
										<option>EUR </option>
										<option>JPY </option>
										<option>GBP</option>
										<option>AUD</option>
										<option>CHF</option>
										<option>CAD</option>
										<option>MXN</option>
										<option>CNY</option>
										<option>NZD</option>
										<option>SEK</option>
										<option>RUB</option>
										<option>HKD</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Star Rating</b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<label for="userPhone">Star Rating </label>
										<select class="form-control" name="hotel_star" id="hotel_star">
										<option>No Star</option>
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										
										</select>
									</div>
								</div>
								
								
										
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Check in Time </b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
										<div class='input-group date' >
										<input type='text' class="form-control" name="checkInDate" id="checkInDate"/>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										</div>
									</div>
									</div>
								</div>
							
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Check out time </b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
										<div class='input-group date' >
										<input type='text' class="form-control"  name="checkOutdate" id="checkOutdate"/>
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										</div>
									</div>
									</div>
								</div>
							
							<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Aminities & Facilities</b></h4>
									</div>
								</div>
								<div class="items6">
								<div id="Aminities_1">
								<div class="col-md-9">
									<div class="form-group">
										<label for="Aminities">Aminities & Facilities</label>
										<input type="text" class="form-control" name="Aminities[]" id="Aminities" placeholder="Aminities & Facilities" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								</div>
								
									
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="add_more_items2" id="add_more_items2" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								
							</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Description</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<div class="form-group">
										
										<textarea type='text' class="form-control"  name="hotel_description" id="hotel_description"></textarea>
										
									</div>
									</div>
								</div>
							
							
						
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
						</div>
					</form>
					</div>
					<div id="menu1" class="tab-pane fade">
					<form role="form" method="POST" name="hotel_more_detail" id="hotel_more_detail">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
						<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
						<input type="hidden" name="type" value="add_hotel_more_detail" />
						<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
						<div class="box-body">
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	 Transporter ID </b></h4>
									</div>
								</div>
								
								<div class="col-md-10">
									<div class="form-group">
										<label for="name"> Transporter ID</label>
										<input type="text" class="form-control" name="transporter_id" id="transporter_id" placeholder="Transporter ID" value="LiDTR00001"/>
									</div>
								</div><!-- /.form-group -->
								
								<!-- /.first line -->
							<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Concerned Person </b></h4>
									</div>
								</div>
								<div class="ite">
								<div id="person_1">
								
								<div class="col-md-3">
									<div class="form-group">
										<label for="title">Title</label>
										<select class="form-control" name="title[]">
										<option value="Mr.">Mr.</option>
										<option value="Miss.">Miss.</option>
										<option value="Mrs.">Mrs.</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label for="firstname">First Name</label>
										<input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value=""/>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-2">
									<div class="form-group">
										<label for="middle">Middle Name</label>
										<input type="text" class="form-control" name="middlename[]" id="middlename" placeholder="Middle Name" value=""/>
									</div>
								</div><!-- /.form-group -->
								<div class="col-md-2">
									<div class="form-group">
										<label for="last">Last Name</label>
										<input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value=""/>
									</div>
								</div>
								</div>
								
								
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="add_more_item" id="add_more_item" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								
							</div>
							<div class="col-md-2">
									<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Contact Nos</b></h4>
									</div>
								</div>
								<div class="cont">
								<div id="connumbbr_1">
								<div class="col-md-3">
									<div class="form-group">
										<label for="userPhone">Mobile</label>
										<input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="middle">Code</label>
										<select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false">
											<option value="Mobile">Mobile</option>
											<option value="Home">Home</option>
											<option value="Work">Work</option>
											<option value="Main">Main</option>
											<option value="WorkFax">Work Fax</option>
											<option value="HomeFax">Home Fax</option>
											<option value="Pager">Pager</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-3 v_hidden">
									<div class="form-group">
										<label for="last">Enter valid Number</label>
										<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
									</div>
								</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="Mnumbbr"  id="contumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Email </b></h4>
									</div>
								</div>
								<div class="items4">
								<div id="Email_1" >
								<div class="col-md-9">
									<div class="form-group">
										<label for="userEmail" >Email</label>
										<input type="email" class="form-control" name="userEmail[]" id="" placeholder="Email" value="<?php echo $usrData['email']; ?>" />
									</div>
								</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="last">Add More</label>
										<a href="javascript:void(0);" class="emails" id="emails" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
									</div>
								</div>
								</div>
							
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">User ID</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="userPhone">User ID</label>
										<input type="text" class="form-control" name="hote_user_id" id="hote_user_id" placeholder="User ID" value=""/>
									</div>
								</div>
							   <div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Password</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="userPhone">Password</label>
										<input type="text" class="form-control" name="hotel_pass" id="hotel_pass" placeholder="Password" value=""/>
									</div>
								</div>	
								
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
						</div>
					</form>
				
				
				</div>
					<div id="menu2" class="tab-pane fade">
					<form role="form" method="POST" name="hotel_bank_detail" id="hotel_bank_detail">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
						<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
						<input type="hidden" name="type" value="add_hotel_bank_detail" />
						<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
						<div class="box-body">
							<div class="row">
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">PAN No.</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="search">PAN No.</label>
										<input type="text" class="form-control " name="hotel_pan_no" id="hotel_pan_no" placeholder="PAN No." value=""/>
									</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Account No.</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="search">Account No.</label>
										<input type="text" class="form-control " name="hotel_account_no" id="hotel_account_no" placeholder="Account No." value=""/>
									</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Account Name</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="search">Account Name</label>
										<input type="text" class="form-control " name="hotel_account_name" id="hotel_account_name" placeholder="Account Name" value=""/>
									</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Bank</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="search">Bank</label>
										<input type="text" class="form-control " name="hotel_bank" id="hotel_bank" placeholder="Bank" value=""/>
									</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Branch</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="search">Branch</label>
										<input type="text" class="form-control " name="hotel_branch" id="hotel_branch" placeholder="Branch" value=""/>
									</div>
								</div>
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">IFSC</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="search">IFSC</label>
										<input type="text" class="form-control " name="hotel_ifsc" id="hotel_ifsc" placeholder="IFSC" value=""/>
									</div>
								</div>
							</div>
							</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
						</div>
					</form>
				</div>
					<div id="menu3" class="tab-pane fade">
					<form role="form" method="POST" id="hotel_doc_detail" name="hotel_doc_detail" enctype = "multipart/form-data">
					 <input type="hidden" id="item_count" name="item_count" value="1"> 
					 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
					 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
					 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
					 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_hotel_doc_detail" />
					<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					<input type="hidden" name="photoDoc" id="photoDoc" value="0" />
					<input type="hidden" name="panCardDoc" id="panCardDoc" value="0" />
					<input type="hidden" name="contCopyDoc" id="contCopyDoc" value="0" />
						<div class="box-body">
							<div class="row">
							<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	PAN Card </b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="query_no">PAN Card</label>
										<input type="file" class="form-control" name="hotel_pan_card_copy" id="hotel_pan_card_copy"  value=""/>
									</div>
									<div id="panCardDocName"></div>
								</div><!-- /.form-group -->
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="query_no">Photo</label>
										<input type="file" class="form-control" name="hote_photo_copy" id="hote_photo_copy"  value=""/>
									</div>
									<div id="photoDocName"></div>
								</div><!-- /.form-group -->
								
								<div class="col-md-2">
									<div class="form-group">
									<h4  class="box-title"><b style="font-size: 17px;">Contract</b></h4>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label for="query_no">Contract</label>
										<input type="file" class="form-control" name="hotel_Contract_copy" id="hotel_Contract_copy"  value=""/>
									</div>
									<div id="contCopyDocName"></div>
								</div><!-- /.form-group -->
								
								
						</div>
							</div>
						<div class="box-footer">
							<button type="button" class="btn btn-primary" name="hotel_doc_detail_btn" id="hotel_doc_detail_btn" id="submit">Submit</button>
						</div>
					</form>		
					</div>
				
					<div id="menu4" class="tab-pane fade">
					
				<form role="form" method="POST" name="hotel_rate" id="hotel_rate">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				 <input type="hidden" id="item_count9" name="item_count9" value="1"> 
				 <input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="8"> 
				<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
				<input type="hidden" name="type" value="add_hotel_rates_detail" />
				<input type="hidden" name="hotel_id" value="<?php echo $hotelId; ?>" />
					<div class="box-body">					
						<div class="row" >	
						<div class="rate">  
								<div id="rates_1">
						<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
								</div>
								</div>
								<div class="col-md-4">
								<div class="form-group">
									<label for="search">From:Calender</label>
									<input type="text" class="form-control " name="fromdate_1" id="fromdate" placeholder="Name" value="Date"/>
								</div>						
								</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="search">To:Calender</label>
									<input type="text" class="form-control " name="todate_1" id="todate" placeholder="Name" value="Date"/>
								</div>						
								</div>
						<div class="col-md-1" >
							
				</div>
						
					<div class="bs-example col-md-12" >
				<table class="table"  >
					<thead>											
						  <tr >
							<th ></th>
							<th style="width: 40px;" >Deluxe</th>		
							<th style="width: 40px;">Premium</th>								  
							<th style="width: 30px;">Metro View</th>
						  </tr>
						</thead>
					<tbody border="1px">  
						  <tr>
							<td>Single <input type="hidden" name="roomType_1_1_1" value="Single"></td>
							<td><input type="text" name="deluxe_1_1_2" value="3000"></td>		
							<td><input type="text" name="premium_1_1_3" ></td>
							<td><input type="text" name="metroview_1_1_4"></td>
							<td rowspan="8"> <textarea name="description_1" rows="17" cols="21"> Description  </textarea>  </td>
						  </tr>
						  <tr>
							<td>Double <input type="hidden" name="roomType_1_2_1" value="Double"></td>
							<td><input type="text"  name ="deluxe_1_2_2" value="3500"></td>		
							<td><input type="text" name ="premium_1_2_3" ></td>
							<td><input type="text" name ="metroview_1_2_4" ></td>
							
						  </tr>
						<tr>
							<td>Extra Adult  <input type="hidden" name="roomType_1_3_1" value="Extra Adult"></td>
							<td><input type="text" name ="deluxe_1_3_2" value="1200"></td>		
							<td><input type="text" name ="premium_1_3_3"></td>
							<td><input type="text" name ="metroview_1_3_4"></td>
							
						  </tr>
							<tr>
							<td>Extra Child w/o Bed  <input type="hidden" name="roomType_1_4_1" value="Extra Child w/o Bed  "></td>
							<td><input type="text" name="deluxe_1_4_2" value="800"></td>		
							<td><input type="text" name="premium_1_4_3" ></td>
							<td><input type="text" name="metroview_1_4_4" ></td>
							
						  </tr>
							<tr>
							<td>Extra Child with Bed <input type="hidden" name="roomType_1_5_1" value="Extra Child with Bed"></td>
							<td><input type="text" name="deluxe_1_5_2"  value="1000"></td>		
							<td><input type="text" name="premium_1_5_3" ></td>
							<td><input type="text" name="metroview_1_5_4" ></td>
							
						  </tr>
							<tr>
							<td>Extra Breakfast <input type="hidden" name="roomType_1_6_1" value="Extra Breakfast"></td>
							<td><input type="text" name="deluxe_1_6_2"  value="250" ></td>		
							<td><input type="text" name="premium_1_6_3" ></td>
							<td><input type="text" name="metroview_1_6_4" ></td>
							
						  </tr>
							<tr>
							<td>Lunch  <input type="hidden" name="roomType_1_7_1" value="Lunch"></td>
							<td><input type="text" name="deluxe_1_7_2" value="350"></td>		
							<td><input type="text" name="premium_1_7_3" ></td>
							<td><input type="text" name="metroview_1_7_4" ></td>
							
						  </tr>
						<tr id="rows_1" >
							<td style="display:none;"><div class="row"> </td>
							<td>Dinner <input type="hidden" name="roomType_1_8_1" value="Dinner"></td>
							<td><input type="text"  name="deluxe_1_8_2" value="450"></td>		
							<td><input type="text" name="premium_1_8_3" ></td>
							<td><input type="text" name="metroview_1_8_4" ></td>
					 </div>
						  </tr> 
						  
							
							<tr>
									<td><label for="last">Add More Row</label>
									<a href="javascript:void(0);" class="add_more_row" id="add_more_row" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a></td>
									<td></td>
								</tr>		  
							</tbody>
						</table>
					</div>				
		
				</div>
				
						
						</div>
						<div class="form-group">
									<label for="last">Add More table</label>
									<a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
						</div>
						</div>
			
			
				</div>
			<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="hotel_rate_1" id="submit">Submit</button>
					</div>
				</form>	
			</div>
			</div>
			</div>
		</section>
	</div>

	<script>
	
		$(document).ready(function(){
			
			$( "#checkOutdate" ).datepicker({	
			format: "dd MM yyyy"
		});
		$( "#checkInDate" ).datepicker({	
			format: "dd MM yyyy"
		});
		$( "#fromdate" ).datepicker({

			format: "dd MM yyyy"
			});
		$( "#todate" ).datepicker({

			format: "dd MM yyyy"
			});
		$(document).on('click','.delete_row',function(){
			$(this).parent().parent().remove();
		});
		$("#add_more_item").click(function(){
		
				var count = $("#item_count").val();
				//alert(count);
				count++;
				$(".ite").append('<div id="person_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><label for="title">Title</label><select class="form-control" name="title[]"><option value="Mr.">Mr.</option>	<option value="Miss.">Miss.</option><option value="Mrs">Mrs.</option></select></div></div><div class="col-md-2"><div class="form-group"><label for="firstname">First Name</label><input type="text" class="form-control" name="firstname[]" id="firstname" placeholder="First Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="middle">Middle Name</label><input type="text" class="form-control" name="middlename[]" id="middlename" placeholder="Middle Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="last">Last Name</label><input type="text" class="form-control" name="lastname[]" id="lastname" placeholder="Last Name" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item6('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count").val(count);
				//alert()
			});
		$("#contumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$(".cont").append('<div id="connumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><label for="userPhone" >Mobile</label><input type="number" class="form-control" name="userPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div> <div class="col-md-3"><div class="form-group"><label for="middle">Code</label><select class="form-control valid" name="code[]" placeholder="Code" value="" aria-invalid="false"><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-3 v_hidden"><div class="form-group"><label for="last">Enter valid Number</label><input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item7('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count3").val(count);
				//alert()
			});	
		
	$("#add_more_items2").click(function(){
		
				var count = $("#item_count5").val();
				//alert(count);
				count++;
				$(".items6").append('<div id="Aminities_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><label for="Aminities" >Aminities & Facilities</label><input type="text" class="form-control" name="Aminities[]" id="Aminities" placeholder= "Aminities & Facilities" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item5('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count5").val(count);
				//alert()
			});
		
	$("#add_more_items1").click(function(){
		
				var count = $("#item_count1").val();
				//alert(count);
				count++;
				$(".items1").append('<div id="address2_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"><label for="roomstype">Room Type</label><input type="text" class="form-control" name="roomstype[]" id="roomstype" placeholder="Room Type" value=""/></div></div><div class="col-md-2">	<div class="form-group"><label for="RDescription">Room Description</label><input type="text" class="form-control" name="RDescription[]" id="RDescription" placeholder="Room Description" value=""/></div> </div><div class="col-md-2"><div class="form-group">	<label for="AminitiesF">Aminities & Facilities</label><input type="text" class="form-control" name="AminitiesF[]" id="AminitiesF" placeholder="Aminities & Facilities" value=""/> </div> </div><div class="col-md-2"><div class="form-group"><label for="Units">Units</label><input type="text" class="form-control" name="Units[]" id="Units" placeholder="Units" value=""/></div></div><div class="col-md-1"><div class="form-group"><label for="Pics">Pics</label><input type="text" class="form-control" name="Pics[]" id="Pics" placeholder="Pics" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item4('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count1").val(count);
				//alert()
			});
		
	$("#add_more_items").click(function(){
		
				var count = $("#address1").val();
				//alert(count);
				count++;
				$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"><label for="Address">Address Line 1</label><input type="text" class="form-control" name="hotel_address1[]" id="userPhone" placeholder="Address" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 2</label><input type="text" class="form-control" name="hotel_address2[]" id="userPhone" placeholder="Address" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="middle">City</label><input type="text" class="form-control" name="hotel_city[]" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="last">State</label><input type="text" class="form-control" name="hotel_state[]" id="hotel_state" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group">	<label for="last">Pin Code</label><input type="text" class="form-control" name="hotel_pincode[]" id="last" placeholder="Code" value=""/></div></div><div class="col-md-1"><div class="form-group"><label for="last">Remove</label><a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#address1").val(count);
				//alert()
			});
		
			$("#Mnumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$(".items3").append('<div id="Mobnumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><label for="userPhone" >Mobile</label><input type="number" class="form-control" name="hotelPhone[]" id="userPhone" placeholder="Mobile Number" value=""/></div></div><div class="col-md-3"><div class="form-group"><label for="middle">Code</label><select class="form-control valid" name="hotelCode[]" placeholder="Code" value="" aria-invalid="false"><option value="Mobile">Mobile</option><option value="Home">Home</option><option value="Work">Work</option><option value="Main">Main</option><option value="WorkFax">Work Fax</option><option value="HomeFax">Home Fax</option><option value="Pager">Pager</option><option value="Other">Other</option></select></div></div><div class="col-md-3 v_hidden"><div class="form-group"><label for="last">Enter valid Number</label><input type="text" class="form-control" name="last[]" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count3").val(count);
				//alert()
			});
			
			$("#emails").click(function(){
		
				var count = $("#item_count4").val();
				//alert(count);
				count++;
				$(".items4").append('<div id="Email_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><label for="userEmail" >Email</label><input type="email" class="form-control" name="userEmail[]" id="userEmail" placeholder="Email" value="0" /></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item1('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div> ');
				
				$("#item_count4").val(count);
				//alert()
			});
		
			//alert("gdfgd");
			/* $("#add_User").validate({
			rules:{
				userType:"required",
				userName:"required",
				userEmail:{
					required:true,
					email:true
				},
				userPhone:{
					required:true,
					minlength:10,
					maxlength:10,
					number:true
				},
				userAddress:"required"
			},
			messages:{
				userType:"Please Select User Type",
				userName:"Please Enter User Name",
				userEmail:{
					required:"Please Enter email",
					email:"Enter valid email"
				},
				userPhone:{
					required:"Please Enter your Mobile Number",
					minlength:"Minimum Length Should be 10 digits",
					maxlength:"Maximum Length Should be 10 digits",
					number:"Please Enter only Number"
				},
				userAddress:"Please Enter Your Address"
			},
			submitHandler:function(form){
				$.ajax({
					type: "POST",  
					url: "_ajax_user_authentication.php?action=addUser",
					data: $("#add_User").serialize(),
					beforeSend:function() {
					},
					success: function(msg)
					{  
						if(msg === '1')
						{
							$("#status").show().html('<div class="alert alert-success">sucessfully Added</div>');
							 //$("#candidate_Details")[0].reset();
							 location.reload(true);
						}
						else
						{
							$("#status").show().html('<div class="alert alert-dangersss">Sorry, there is some problem</div>');
							
						}contCopyDocName,panCardDocName,photoDocName
					} 
				});hotel_pan_card_copy
			}
			}); */
			
			$('#hotel_pan_card_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'hotel_doc',
					'id'	: '<?php echo $hotelId;?>',
					'name'		: 'pan_card_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'multi': false,
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response) {
				var extension = file.name.replace(/^.*\./, '');
				var a=$.parseJSON(data);
				var imgName=a.imagename;	
				//alert(imgName);
				$('#panCardDocName').html('<label>'+imgName+'</label>');
				$("#panCardDoc").val(imgName);
				}		
			});
			
			$('#hote_photo_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'hotel_doc',
					'id'	: '<?php echo $hotelId;?>',
					'name'		: 'photo_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'multi': false,
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response) {
					 var extension = file.name.replace(/^.*\./, '');
					 var a=$.parseJSON(data);
						var imgName=a.imagename;
						$('#photoDocName').html('<label>'+imgName+'</label>');
						//$("#bioData").val(imgName);
						$("#photoDoc").val(imgName);
				}		
			});
			
			$('#hotel_Contract_copy').uploadify({
				'formData'     : {
					'flag'      : 'upload_file',
					'direc'	: 'hotel_doc',
					'id'	: '<?php echo $hotelId;?>',
					'name'		: 'contract_copy'
				},
				'onSelect' : function(file) {
				  //$('#imgProfile_upload').html('<i class="fa fa-refresh fa-spin" style="font-size:34px;"></i>'); 
				 },
				'buttonImage' : 'uploadify/browse-btn.png',
				'buttonText' : 'Add Category Pic',
				'multi': false,
				'swf'      : 'uploadify/uploadify.swf',
				'uploader' : '_ajax_document_upload.php',
				'onUploadSuccess': function (file, data, response) {
					 var extension = file.name.replace(/^.*\./, '');
					 var a=$.parseJSON(data);
						var imgName=a.imagename;
						$('#contCopyDocName').html('<label>'+imgName+'</label>');
						//$("#bioData").val(imgName);
						$("#contCopyDoc").val(imgName);
				}		
			});
			
			$("#hotel_doc_detail_btn").click(function(){
				//alert("sdfdsf");
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_doc_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(msg)
					{
						//window.location.href='clientlist.php';
					}
				}); 
			});
			
		});
		
$("#add_more_rate").click(function(){
		
				var count = $("#item_count9").val();
				
				count++;
				
				$(".rate").append('<div id="rates_'+count+'"><div class="col-md-2"><div class="form-group"><h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4></div></div><div class="col-md-4"><div class="form-group" ><label for="search">From:Calender</label><input type="text" class="form-control " name="fromdate_'+count+'" id="fromdate" placeholder="Name"   value="Date"/></div></div><div class="col-md-4"><div class="form-group"> <label for="search">To:Calender</label><input type="text" class="form-control" name="todate_'+count+'" id="todate" placeholder="Name" value="Date"/></div></div><div class="col-md-1" ></div> <div class= "bs-example col-md-11" ><table class="table" ><thead><tr ><th ></th><th style="width: 40px;" >Deluxe</th><th style="width: 40px;">Premium</th>	<th style="width: 30px;"> Metro View </th></tr>	 </thead><tbody border="1px" ><tr><td>Single<input type="hidden" name="roomType_'+count+'_1_1" value="Single"></td> <td><input type="text" value="3000" name="deluxe_'+count+'_1_2"> </td><td><input type="text"  name="premium_'+count+'_1_3"></td><td><input type="text" name="metroview_'+count+'_1_4"></td><td rowspan="8"><textarea  rows="17" cols="21" name="description_'+count+'"> Description </textarea> </td></tr><tr><td> Double <input type="hidden" name="roomType_'+count+'_2_1" value="Double"></td><td><input type="text" name="deluxe_'+count+'_2_2" value="3500"></td><td><input type="text" name="premium_'+count+'_2_3"></td><td><input type="text" name="metroview_'+count+'_2_4"> </td> </tr><tr><td>Extra Adult <input type="hidden" name="roomType_'+count+'_3_1" value="Extra Adult"></td><td><input type="text" name="deluxe_'+count+'_3_2" value="1200"></td><td><input type="text" name="premium_'+count+'_3_3"></td><td><input type="text" name="metroview_'+count+'_3_4"> </td> </tr><tr><td>Extra Child w/o Bed<input type="hidden" name="roomType_'+count+'_4_1" value="Extra Child w/o Bed"></td><td><input type="text" name="deluxe_'+count+'_4_2" value="800"></td>	<td><input type="text" name="premium_'+count+'_4_3"></td><td><input type="text" name="metroview_'+count+'_4_4">	</td></tr><tr><td>Extra Child with Bed <input type="hidden" name="roomType_'+count+'_5_1" value="Extra Child with Bed"></td><td><input type="text" name="deluxe_'+count+'_5_2" value="1000"></td><td><input type="text" name="premium_'+count+'_5_3"> </td><td><input type="text" name="metroview_'+count+'_5_4"></td></tr><tr><td>Extra Breakfast <input type="hidden" name="roomType_'+count+'_6_1" value="Extra Breakfast"></td><td><input type="text" name="deluxe_'+count+'_6_2" value="250"></td><td><input type="text" name="premium_'+count+'_6_3"></td><td><input type="text" name="metroview_'+count+'_6_4"></td></tr><tr><td>Lunch<input type="hidden" name="roomType_'+count+'_7_1" value="Lunch"></td><td><input type="text" name="deluxe_'+count+'_7_2" value="350"></td><td><input type="text" name="premium_'+count+'_7_3"></td><td><input type="text" name="metroview_'+count+'_7_4"></td></tr><tr><td>Dinner<input type="hidden" name="roomType_'+count+'_8_1" value="Dinner"></td><td><input type="text" name="deluxe_'+count+'_8_2" value="450"></td><td><input type="text" name="premium_'+count+'_8_3"></td><td><input type="text" name="metroview_'+count+'_8_4"></td></tr> </tbody></table></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_rate('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count9").val(count);
				
				$( "#fromdate_"+count).datepicker({
				format: "dd MM yyyy"
				});
				$( "#todate_"+count ).datepicker({
				format: "dd MM yyyy"
				});
				
				//alert()
			});				
$("#add_more_row").click(function(){
				var row=1;
				var count = $("#item_count10").val();
				var total__rates_itmes = $("#total__rates_itmes").val();
				//alert(count);
				count++;
				total__rates_itmes++;
				$("#rows_1").after(' <tr id="row_'+count+'"><td><input type="text" name="roomType_'+row+'_'+total__rates_itmes+'_1" placeholder="LiDI000009"></td> <td><input type="text" name="deluxe_'+row+'_'+total__rates_itmes+'_2"  ></td><td><input type="text" name="premium_'+row+'_'+total__rates_itmes+'_3"> </td><td><input type="text" name="metroview_'+row+'_'+total__rates_itmes+'_4"></td><td><a class="delete_row" rel="'+count+'"  href="javascript:void(0)" ><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></td></tr> ');
				
				$("#item_count").val(count);
				$("#total__rates_itmes").val(total__rates_itmes);
				//alert()
			
			});	
function remove_item1(counter)
		{
			$('#Email_'+counter).remove();
		}
		function remove_item2(counter)
		{
			$('#Mobnumbbr_'+counter).remove();
		}
		function remove_item3(counter)
		{
			$('#address_'+counter).remove();
		}
		function remove_item4(counter)
		{		
			$('#address2_'+counter).remove();	
		}
		function remove_item5(counter)
		{		
			$('#Aminities_'+counter).remove();		
		}
		function remove_item6(counter)
		{
			$('#person_'+counter).remove();
		}
		function remove_item7(counter)
		{
			$('#connumbbr_'+counter).remove();
		}
		function remove_rate(counter)
		{
			$('#rates_'+counter).remove();
		}
			

	</script>
	  
	 <script>
	
	$("#hotal_personl_detail").validate({
	
			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
			
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotal_personl_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//alert(html);
						$("#hotel_more_detail").click();
					}
				}); 
			}
		});
	</script> 
<script>
	
	$("#hotel_bank_detail").validate({
	
			rules: {
				tcountry: "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
			
			
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_bank_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//alert(html);
						//window.location.reload();
					}
				}); 
			}
		});
	</script>
<script>
	
	$("#hotel_more_detail").validate({
	
			rules: {
				tcountry: "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
			
			
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_more_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//alert(html);
						//window.location.reload();
					}
				}); 
			}
		});
	</script>
<script>

	$("#hotel_rate").validate({
		
			rules: {
				tcountry: "required"				
			},
			messages: {
				tcountry: "Please select country"
			},
			submitHandler: function() { 
			
			
				$.ajax({
					type: "POST",
					url: "_ajax_hotel_prsnl_detail.php",
					data: $("#hotel_rate").serialize(),
					cache: false,
					beforeSend:function() {
						
					},
					success: function(html)
					{
						//alert(html);
						//window.location.reload();
					}
				}); 
			}
		});
	</script>
	  <script src="asset/bootstrap-datetimepicker.js"></script>
	    <script src="asset/jquery.timepicker.js"></script>
	    <script src="asset/bootstrap/css/jquery.timepicker.css"></script>
<?php  include('footer.php');?> 