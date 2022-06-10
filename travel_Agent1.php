<?php
include('header.php');
include('sidebar.php');
$travelId = $_SESSION['travelId'];

if($_GET['action']=='edit')
{
	$editUserId=$_GET['id'];
	$usrData = $objAdmin->getUsrById($editUserId);

	//print_r($usrData);
}

if(isset($_POST['travel_doc_detail']))
{

if(isset($_FILES['travel_pan_card_copy'])){
	
	mkdir('document/travel_doc/'.$travelId, 0777);
      $errors= array();
      $pan_file_name = $_FILES['travel_pan_card_copy']['name'];
      $pan_file_size = $_FILES['travel_pan_card_copy']['size'];
      $pan_file_tmp = $_FILES['travel_pan_card_copy']['tmp_name'];
      $pan_file_type = $_FILES['travel_pan_card_copy']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['travel_pan_card_copy']['name'])));
      
      $expensions= array("docx","pdf");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a Doc or Pdf file.";
      }
      
      if($pan_file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($pan_file_tmp,'document/travel_doc/'.$travelId.'/'.$pan_file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }

if(isset($_FILES['travel_photo_copy'])){
	
	mkdir('document/travel_doc/'.$travelId, 0700);
      $errors= array();
      $photo_file_name = $_FILES['travel_photo_copy']['name'];
      $photo_file_size = $_FILES['travel_photo_copy']['size'];
      $photo_file_tmp = $_FILES['travel_photo_copy']['tmp_name'];
      $photo_file_type = $_FILES['travel_photo_copy']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['travel_photo_copy']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a Jpeg or Png file.";
      }
      
      if($photo_file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($photo_file_tmp,'document/travel_doc/'.$travelId.'/'.$photo_file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }

if(isset($_FILES['travel_Contract_copy'])){
	
	mkdir('document/travel_doc/'.$travelId, 0700);
      $errors= array();
      $password_file_name = $_FILES['travel_Contract_copy']['name'];
      $password_file_size = $_FILES['travel_Contract_copy']['size'];
      $password_file_tmp = $_FILES['travel_Contract_copy']['tmp_name'];
      $password_file_type = $_FILES['travel_Contract_copy']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['travel_Contract_copy']['name'])));
      
      $expensions= array("jpeg","jpg","png","docx","pdf");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a Jpeg or Png file.";
      }
      
      if($password_file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($password_file_tmp,'document/travel_doc/'.$travelId.'/'.$password_file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }


 
 $prsnl_detail = $objtravel->travel_doc_detail($pan_file_name,$photo_file_name,$password_file_name ,$travelId);
}

?>
?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Travel Agent
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Add Travel Agent</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">
				<div class="box-header with-border">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>CLIENT DETAILS</b></h3></a></li>
				  <li><a data-toggle="tab" href="#menu1"><h3 class="box-title"><b>QUERY DETAILS</b></h3> </a></li>
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
				<form role="form" method="POST" name="travel_client_detail" id="travel_client_detail">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1">  
				 <input type="hidden" id="item_count5" name="item_count5" value="1">  
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<input type="hidden" name="type" value="add_travel_client_detail" />
					<div class="box-body">
						<div class="row">
							<!--<div class="col-md-6">
							  <div class="form-group">
								<label for="userType">User Type</label>
								<select class="form-control select2" name="userType" id="userType" data-placeholder="User Type" style="width: 100%;">
									<option value="">Select</option>
									<option value="Admin" <?php if($usrData['user_type'] == 'Admin'){echo 'selected';} ?>>Admin</option>
									<option value="User" <?php if($usrData['user_type'] == 'User'){echo 'selected';} ?>>User</option>
								</select>
							  </div>
							</div>-->
							
							
							<!-- Frist Line -->
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;" >	 Hotal Name </b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<label for="name">Hotal Name</label>
									<input type="text" class="form-control" name="travel_hotel_name" id="travel_hotel_name"  placeholder="Hotal Name" value=""/>
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
									<input type="text" class="form-control" name="addressl_1" id="address" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/>
								</div>
							</div>
							
								<div class="col-md-2">
								<div class="form-group">
									<label for="userPhone">Address Line 2</label>
									<input type="text" class="form-control" name="addressline_1" id="addressline" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="middle">City</label>
									<input type="text" class="form-control" name="city_1" id="city" placeholder="City" value=""/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="last">State</label>
									<input type="text" class="form-control" name="state_1" id="state" placeholder="State" value=""/>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<label for="last">Pin Code</label>
									<input type="text" class="form-control" name="pincode_1" id="pincode" placeholder="Code" value=""/>
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
							<h4  class="box-title"><b style="font-size: 17px;">		Contact Nos </b></h4>
								</div>
							</div>
							<div class="items3">
							<div id="Mobnumbbr_1">
							<div class="col-md-3">
								<div class="form-group">
									<label for="userPhone">Mobile</label>
									<input type="number" class="form-control" name="userPhone_1" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="middle">Code</label>
									<input type="text" class="form-control" name="code_1" id="code" placeholder="Code" value=""/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="last">Enter valid Number</label>
									<input type="text" class="form-control" name="last_1" id="last" placeholder="Enter Valid Number" value=""/>
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
							<h4  class="box-title"><b style="font-size: 17px;">Services</b></h4>
								</div>
							</div>
							<div class="items1">
							<div id="address2_1">
							<div class="col-md-2">
								<div class="form-group">
									<label for="roomstype">Service Type</label>
									<input type="text" class="form-control" name="stype_1" id="roomstype" placeholder="Service Type" value="<?php echo $usrData['mobileno']; ?>"/>
								</div>
							</div>
							
								<div class="col-md-2">
								<div class="form-group">
									<label for="RDescription">Service Description</label>
									<input type="text" class="form-control" name="sDescription_1" id="RDescription" placeholder="Service Description" value="<?php echo $usrData['mobileno']; ?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="AminitiesF">Aminities & Facilities</label>
									<input type="text" class="form-control" name="AminitiesF_1" id="AminitiesF" placeholder="Aminities & Facilities" value=""/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="Units">Units</label>
									<input type="text" class="form-control" name="Units_1" id="Units" placeholder="Units" value=""/>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<label for="Pics">Pics</label>
									<input type="text" class="form-control" name="Pics_1" id="Pics" placeholder="Pics" value=""/>
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
							
						
							<!-- /.third line -->
							
							
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Base Currency</b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Base Currency</label>
									<select class="form-control" name="travel_base_currency" id="travel_base_currency">
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
								<h4  class="box-title"><b style="font-size: 17px;">Description</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
									
									<textarea type='text' class="form-control"  name="travel_description" id="travel_description"></textarea>
									
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
			<form role="form" method="POST" name="travel_query_detail" id="travel_query_detail">
				 <input type="hidden" id="servicetype4" name="servicetype4" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
				<input type="hidden" name="type" value="add_travel_query_detail" />
				<input type="hidden" name="travelId" value="<?php echo $travelId; ?>" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Travel Agent ID </b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<label for="name"> Travel Agent ID</label>
									<input type="text" class="form-control" name="travel_id" id="travel_id" placeholder="Travel Agent ID" value="LiDTA00001"/>
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
									<select class="form-control">
									<option >Mr.</option>
									<option >Miss.</option>
									<option >Mrs.</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="firstname">First Name</label>
									<input type="text" class="form-control" name="firstname_1" id="firstname" placeholder="First Name" value=""/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<label for="middle">Middle Name</label>
									<input type="text" class="form-control" name="middle_1" id="middle" placeholder="Middle Name" value=""/>
								</div>
							</div><!-- /.form-group -->
							<div class="col-md-2">
								<div class="form-group">
									<label for="last">Last Name</label>
									<input type="text" class="form-control" name="lastname_1" id="last" placeholder="Last Name" value=""/>
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
							<h4  class="box-title"><b style="font-size: 17px;">		Contact Nos </b></h4>
								</div>
							</div>
							<div class="cont">
							<div id="connumbbr_1">
							<div class="col-md-3">
								<div class="form-group">
									<label for="userPhone">Mobile</label>
									<input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="middle">Code</label>
									<input type="text" class="form-control" name="code" id="code" placeholder="Code" value=""/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="last">Enter valid Number</label>
									<input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/>
								</div>
							</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<label for="last">Add More</label>
									<a href="javascript:void(0);" class="Mnumbr"  id="contumbbr" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
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
									<input type="email" class="form-control" name="userEmail" id="userEmail" placeholder="Email" value="<?php echo $usrData['email']; ?>" />
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
									<label for="namme">User ID</label>
									<input type="text" class="form-control" name="travel_userId" id="travel_userId" placeholder="User ID" value=""/>
								</div>
							</div>
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Password</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="name">Password</label>
									<input type="text" class="form-control" name="travel_pass" id="userPhone" placeholder="travel_pass" value=""/>
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
				<form role="form" method="POST" name="travel_bank_detail" id="travel_bank_detail">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="type" value="add_travel_bank_detail" />
					<input type="hidden" name="travelId" value="<?php echo $travelId; ?>" />
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
									<input type="text" class="form-control " name="travel_pan_no" id="travel_pan_no" placeholder="PAN No." value=""/>
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
									<input type="text" class="form-control " name="travel_account_no" id="travel_account_no" placeholder="Account No." value=""/>
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
									<input type="text" class="form-control " name="travel_account_name" id="travel_account_name" placeholder="Account Name" value=""/>
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
									<input type="text" class="form-control " name="travel_bank" id="travel_bank" placeholder="Bank" value=""/>
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
									<input type="text" class="form-control " name="travel_branch" id="travel_branch" placeholder="Branch" value=""/>
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
									<input type="text" class="form-control " name="travel_ifsc" id="travel_ifsc" placeholder="IFSC" value=""/>
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
				<form role="form" method="POST" name="travel_doc_detail" id="travel_doc_detail" enctype = "multipart/form-data"> 
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
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
									<input type="file" class="form-control" name="travel_pan_card_copy" id="travel_pan_card_copy"  value=""/>
								</div>
							</div><!-- /.form-group -->
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Photo </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="query_no">Photo</label>
									<input type="file" class="form-control" name="travel_photo_copy" id="travel_photo_copy"  value=""/>
								</div>
							</div><!-- /.form-group -->
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Contract</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="query_no">Contract</label>
									<input type="file" class="form-control" name="travel_Contract_copy" id="travel_Contract_copy"  value=""/>
								</div>
							</div><!-- /.form-group -->
							
							
					</div>
						</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="travel_doc_detail" id="submit">Submit</button>
					</div>
				</form>		
				</div>
				<div id="menu4" class="tab-pane fade">
					
				<form role="form" method="POST" name="add_User" id="add_User">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
				 <input type="hidden" id="item_count9" name="item_count9" value="1"> 
				 <input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="8"> 
				 <input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
				 <input type="hidden" name="type" value="travel_agent_rates_detail" />				
				<input type="hidden" name="travel_agent_id" value="<?php echo $hotelId; ?>" />
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
							<th style="width: 40px;" >Service 1</th>		
							<th style="width: 40px;">Service 2</th>								  
							<th style="width: 30px;">Service 3</th>
						  </tr>
						</thead>
					<tbody border="1px">  
						  <tr>
							<td>LiDI000001<input type="hidden" name="LidID_1_1_1" value="LiDI000001"></td>
							<td><input type="text" name="Innova_1_1_2" value="3000"></td>		
							<td><input type="text" name="Indigo_1_1_3"></td>
							<td><input type="text" name="Traveller_1_1_4"></td>
							<td rowspan="8"><textarea name="description_1" rows="17" cols="21"> Description  </textarea> </td>
						  </tr>
						  <tr>
							<td>LiDI000002<input type="hidden" name="LidID_1_2_1" value="LiDI000002"></td>
							<td><input type="text" name="Innova_1_2_2" value="3500"></td>		
							<td><input type="text" name="Indigo_1_2_3" ></td>
							<td><input type="text" name="Traveller_1_2_4" ></td>
							
						  </tr>
						<tr>
							<td>LiDI000003<input type="hidden" name="LidID_1_3_1" value="LiDI000003"></td>
							<td><input type="text" name="Innova_1_3_2" value="1200"></td>		
							<td><input type="text" name="Indigo_1_3_3"></td>
							<td><input type="text" name="Traveller_1_3_4"></td>
							
						  </tr>
							<tr>
							<td>LiDI000004<input type="hidden" name="LidID_1_4_1" value="LiDI000004"></td>
							<td><input type="text" name="Innova_1_4_2" value="800"></td>		
							<td><input type="text" name="Indigo_1_4_3"></td>
							<td><input type="text" name="Traveller_1_4_4"></td>
							
						  </tr>
							<tr>
							<td>LiDI000005<input type="hidden" name="LidID_1_5_1" value="LiDI000005"></td>
							<td><input type="text" name="Innova_1_5_2" value="1000"></td>		
							<td><input type="text" name="Indigo_1_5_3"></td>
							<td><input type="text" name="Traveller_1_5_4"></td>
							
						  </tr>
							<tr>
							<td>LiDI000006<input type="hidden" name="LidID_1_6_1" value="LiDI000006"></td>
							<td><input type="text" name="Innova_1_6_2" value="250"></td>		
							<td><input type="text" name="Indigo_1_6_3"></td>
							<td><input type="text" name="Traveller_1_6_4"></td>
							
						  </tr>
							<tr>
							<td>LiDI000007<input type="hidden" name="LidID_1_7_1" value="LiDI000007"></td>
							<td><input type="text" name="Innova_1_7_2" value="350"></td>		
							<td><input type="text" name="Indigo_1_7_3"></td>
							<td><input type="text" name="Traveller_1_7_4"></td>
							
						  </tr>
						 <tr id="rows_1" >
							<td style="display:none;"><div class="row"> </td>
							<td>LiDI000008<input type="hidden" name="LidID_1_8_1" value="LiDI000008"></td>
							<td><input type="text" name="Innova_1_8_2" value="450"></td>		
							<td><input type="text" name="Indigo_1_8_3"></td>
							<td><input type="text" name="Traveller_1_8_4"></td>
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
				
						<div class="form-group">
									<label for="last">Add More table</label>
									<a href="javascript:void(0);" class="add_more_items" id="add_more_rate" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a>
						</div>
						</div>
						</div>
			<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
					</div>
				</form>	
			
				</div>
			
			</div>
				</div>	
			</div>
		</section>
	</div>

	<script>
	
		$(document).ready(function(){
			$('#depData').timepicker();
			$( "#anvsryData" ).datepicker({			
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
		
				var count = $("#servicetype4").val();
				//alert(count);
				count++;
				$(".ite").append('<div id="person_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><label for="title">Title</label><select class="form-control"><option >Mr.</option>	<option >Miss.</option><option >Mrs.</option></select></div></div><div class="col-md-2"><div class="form-group"><label for="firstname">First Name</label><input type="text" class="form-control" name="firstname_'+count+'" id="firstname" placeholder="First Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="middle">Middle Name</label><input type="text" class="form-control" name="middle_'+count+'" id="middle" placeholder="Middle Name" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="last">Last Name</label><input type="text" class="form-control" name="lastaname_'+count+'" id="last" placeholder="Last Name" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item6('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#servicetype4").val(count);
				//alert()
			});
		$("#contumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$(".cont").append('<div id="connumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><label for="userPhone" >Mobile</label><input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-3"><div class="form-group"><label for="middle" >Code</label><input type="text" class="form-control" name="code" id="code" placeholder="Code" value=""/>	</div></div>	<div class="col-md-3">	<div class="form-group"><label for="last">Enter valid Number</label><input type="text" class="form-control" name="last" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item5('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count3").val(count);
				//alert()
			});	
		
	$("#add_more_items2").click(function(){
		
				var count = $("#item_count5").val();
				//alert(count);
				count++;
				$(".items6").append('<div id="Aminities_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><label for="Aminities" >Aminities & Facilities</label><input type="text" class="form-control" name="Aminities" id="Aminities" placeholder= "Aminities & Facilities" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count5").val(count);
				//alert()
			});
		
	$("#add_more_items1").click(function(){
		
				var count = $("#item_count1").val();
				//alert(count);
				count++;
				$(".items1").append('<div id="address2_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"><label for="roomstype">Service Type</label><input type="text" class="form-control" name="stype_'+count+'" id="roomstype" placeholder="Service Type" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-2">	<div class="form-group"><label for="Description">Service Description</label><input type="text" class="form-control" name="sDescription_'+count+'" id="RDescription" placeholder="Service Description" value="<?php echo $usrData['mobileno']; ?>"/></div> </div><div class="col-md-2"><div class="form-group">	<label for="AminitiesF">Aminities & Facilities</label><input type="text" class="form-control" name="AminitiesF_'+count+'" id="AminitiesF" placeholder="Aminities & Facilities" value=""/> </div> </div><div class="col-md-2"><div class="form-group"><label for="Units">Units</label><input type="text" class="form-control" name="Units_'+count+'" id="Units" placeholder="Units" value=""/></div></div><div class="col-md-1"><div class="form-group">			<label for="Pics">Pics</label><input type="text" class="form-control" name="Pics_'+count+'" id="Pics" placeholder="Pics" value=""/>	</div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item4('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count1").val(count);
				//alert()
			});
		
	
		/* $("#add_more_items").click(function(){
		
				var count = $("#item_count5").val();
				//alert(count);
				count++;
				$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 1</label><input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 2</label><input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="Address" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-2"><div class="form-group"><label for="middle">City</label><input type="text" class="form-control" name="code" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="last">State</label><input type="text" class="form-control" name="last" id="last" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group">	<label for="last">Pin Code</label>	<input type="text" class="form-control" name="last" id="last" placeholder="Code" value=""/>	</div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count5").val(count);
				//alert()
			}); */
			
			$("#add_more_items").click(function(){
		
				var count = $("#item_count5").val();
				//alert(count);
				count++;
				$(".items").append('<div id="address_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 1</label><input type="text" class="form-control" name="addressl_'+count+'" id="address" placeholder="Address" value="Address"/></div></div><div class="col-md-2"><div class="form-group"><label for="userPhone">Address Line 2</label><input type="number" class="form-control" name="addressline_'+count+'" id="userPhone" placeholder="Address" value="Address"/></div></div><div class="col-md-2"><div class="form-group"><label for="middle">City</label><input type="text" class="form-control" name="city_'+count+'" id="code" placeholder="City" value=""/></div></div><div class="col-md-2"><div class="form-group"><label for="last">State</label><input type="text" class="form-control" name="state_'+count+'" id="last" placeholder="State" value=""/></div></div><div class="col-md-1"><div class="form-group">	<label for="last">Pin Code</label>	<input type="number" class="form-control" name="pincode_'+count+'" " id="pincode" placeholder="Code" value=""/>	</div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item3('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count5").val(count);
				//alert()
			});
		
			$("#Mnumbbr").click(function(){
		
				var count = $("#item_count3").val();
				//alert(count);
				count++;
				$(".items3").append('<div id="Mobnumbbr_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-3"><div class="form-group"><label for="userPhone" >Mobile</label><input type="number" class="form-control" name="userPhone_'+count+'" id="userPhone" placeholder="Mobile Number" value="<?php echo $usrData['mobileno']; ?>"/></div></div><div class="col-md-3"><div class="form-group"><label for="middle" >Code</label><input type="text" class="form-control" name="code_'+count+'" id="code" placeholder="Code" value=""/>	</div></div>	<div class="col-md-3">	<div class="form-group"><label for="last">Enter valid Number</label><input type="text" class="form-control" name="last_'+count+'" id="last" placeholder="Enter Valid Number" value=""/></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item2('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count3").val(count);
				//alert()
			});
			
			$("#emails").click(function(){
		
				var count = $("#item_count4").val();
				//alert(count);
				count++;
				$(".items4").append('<div id="Email_'+count+'"><div class="col-md-2"><div class="form-group"></div></div><div class="col-md-9"><div class="form-group"><label for="userEmail" >Email</label><input type="email" class="form-control" name="userEmail" id="userEmail" placeholder="Email" value="<?php echo $usrData['email']; ?>" /></div></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_item1('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div></div> ');
				
				$("#item_count4").val(count);
				//alert()
			});
		
			//alert("gdfgd");
			$("#add_more_rate").click(function(){

		
				var count = $("#item_count9").val();
				//alert(count);
				count++;
				$(".rate").append('<div id="rates_'+count+'"><div class="col-md-2"><div class="form-group"><h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4></div></div><div class="col-md-4"><div class="form-group" ><label for="search">From:Calender</label><input type="text" class="form-control " name="fromdate_'+count+'" id="fromdate_'+count+'" placeholder="Name"  value="Date"/></div></div><div class="col-md-4"><div class="form-group"> <label for="search">To:Calender</label><input type="text" class="form-control"  name="todate_'+count+'" id="todate_'+count+'" placeholder="Name" value="Date"/></div></div><div class="col-md-1" ></div> <div class= "bs-example col-md-11" ><table class="table" ><thead><tr ><th ></th><th style="width: 40px;" >Innova</th><th style="width: 40px;">Indigo</th>	<th style="width: 30px;"> Tempo Traveller </th></tr>	 </thead><tbody border="1px" ><tr><td>LiDI000001<input type="hidden" name="LidID_'+count+'_1_1" value="LiDI000001"></td> <td><input type="text" value="3000" name="Innova_'+count+'_1_2"> </td><td><input type="text" name="Indigo_'+count+'_1_3"></td><td><input type="text"name="Traveller_'+count+'_1_4"></td><td rowspan="8"><textarea  rows="17" cols="21" name="description_'+count+'"> Description </textarea> </td></tr><tr><td>LiDI000002<input type="hidden" name="LidID_'+count+'_2_1" value="LiDI000002"></td><td><input type="text" value="3500" name="Innova_'+count+'_2_2"></td><td><input type="text" name="Indigo_'+count+'_2_3"></td><td><input type="text" name="Traveller_'+count+'_2_4"> </td> </tr><tr><td>LiDI000003<input type="hidden" name="LidID_'+count+'_3_1" value="LiDI000003"></td><td><input type="text" value="1200" name="Innova_'+count+'_3_2"></td><td><input type="text" name="Indigo_'+count+'_3_3"></td><td><input type="text" name="Traveller_'+count+'_3_4"> </td> </tr><tr><td>LiDI000004<input type="hidden" name="LidID_'+count+'_4_1" value="LiDI000004"></td><td><input type="text" value="800" name="Innova_'+count+'_4_2"></td>	<td><input type="text" name="Indigo_'+count+'_4_3"></td><td><input type="text" name="Traveller_'+count+'_4_4">	</td></tr><tr><td>LiDI000005<input type="hidden" name="LidID_'+count+'_5_1" value="LiDI000005"></td><td><input type="text" value="1000" name="Innova_'+count+'_5_2"></td><td><input type="text" name="Indigo_'+count+'_5_3"></td><td><input type="text" name="Traveller_'+count+'_5_4"></td></tr><tr><td>LiDI000006<input type="hidden" name="LidID_'+count+'_6_1" value="LiDI000006"></td><td><input type="text" value="250" name="Innova_'+count+'_6_2"></td><td><input type="text" name="Indigo_'+count+'_6_3"></td><td><input type="text" name="Traveller_'+count+'_6_4"></td></tr><tr><td>LiDI000007<input type="hidden" name="LidID_'+count+'_7_1" value="LiDI000007"></td><td><input type="text" value="350" name="Innova_'+count+'_7_2"></td><td><input type="text" name="Indigo_'+count+'_7_3"></td><td><input type="text" name="Traveller_'+count+'_7_4"></td></tr><tr><td>LiDI000008<input type="hidden" name="LidID_'+count+'_8_1" value="LiDI000008"></td><td><input type="text" value="450" name="Innova_'+count+'_8_2"></td><td><input type="text" name="Indigo_'+count+'_8_3"></td><td><input type="text" name="Traveller_'+count+'_8_4"></td></tr> </tbody></table></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_rate('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');
				
				$("#item_count9").val(count);
				$( "#fromdate_"+count).datepicker({
				format: "dd MM yyyy"
				});
				$( "#todate_"+count ).datepicker({
				format: "dd MM yyyy"
				});
				//alert()
			});
		});
			
		$("#add_more_row").click(function(){
		
				var count = $("#item_count10").val();
				//alert(count);
				count++;
				$("#rows_1").after(' <tr id="row_'+count+'"><td><input type="text" placeholder="LiDI000009"></td> <td><input type="text" ></td><td><input type="text" > </td><td><input type="text"></td><td><a class="delete_row" rel="'+count+'"  href="javascript:void(0)" ><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></td></tr> ');
				
				$("#item_count").val(count);
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
		function remove_item6(counter)
		{
			$('#person_'+counter).remove();
		}
		function remove_item5(counter)
		{
			$('#connumbbr_'+counter).remove();
		}
		function remove_rate(counter)
		{
			$('#rates_'+counter).remove();
		}
		

	</script>
	 

 <script>
	
	$("#travel_client_detail").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_travel_agent.php",
					data: $("#travel_client_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//window.location.reload();
					alert(html);
						
					}
				}); 
			}
		});
	</script> 
	<script>
	
	$("#travel_query_detail").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_travel_agent.php",
					data: $("#travel_query_detail").serialize(),
					cache: false,
					beforeSend:function() {
					},
					success: function(html)
					{
						//window.location.reload();
					alert(html);
						
					}
				}); 
			}
		});
	</script> 
<script>
	
	$("#travel_bank_detail").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_travel_agent.php",
					data: $("#travel_bank_detail").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//window.location.reload();
					alert(html);
						
					}
				}); 
			}
		});
	</script> 	
		 <script>
	
	$("#add_User").validate({

			rules: {
				hotel_name: "required"				
			},
			messages: {
				hotel_name: "Please Enter Name"
			},
			submitHandler: function() { 
			
				//alert("punam");
				$.ajax({
					type: "POST",
					url: "_ajax_travel_agent.php",
					data: $("#add_User").serialize(),
					cache: false,
					beforeSend:function() {
						//$("#searchinput").css('background','url("images/lightbox-ico-loading.gif") no-repeat scroll right center rgba(0, 0, 0, 0)');
					},
					success: function(html)
					{
						//window.location.reload();
					alert(html);
						
					}
				}); 
			}
		});
	</script> 
	<script src="asset/bootstrap-datetimepicker.js"></script>
	    <script src="asset/jquery.timepicker.js"></script>
	    <script src="asset/bootstrap/css/jquery.timepicker.css"></script>
<?php  include('footer.php');?> 