<?php
include('header.php');
include('sidebar.php');
if($_GET['action'] == 'view'){
  $userType = $_SESSION['user_type'];
  $empType = $queryType = $_SESSION['employee_type'];
  
    $id = $_GET['id'];
    //$arrQuery=$objAdmin->getALLmrsCapitalEvent();
    $arrQuery = $objAdmin->getmrsCapitalLeadDetail($id);
    $queryId = $arrQuery[0]['id'];
	$prsnName = $arrQuery[0]['first_name'];
	$lastName = $arrQuery[0]['last_name'];
	$prsnEmail = $arrQuery[0]['email'];
	$contactNum = $arrQuery[0]['contact'];
	//$queryDate=$arrQuery[0]['date_time'];
	$age = $arrQuery[0]['age'];
	$maritial_status = $arrQuery[0]['maritial_status'];
	$address_line_1 = $arrQuery[0]['address_line_1'];
	$address_line_2 = $arrQuery[0]['address_line_2'];
	$city = $arrQuery[0]['city'];
	$state = $arrQuery[0]['state'];
	$postal_code = $arrQuery[0]['postal_code'];
	$height = $arrQuery[0]['height'];
	$bust   = $arrQuery[0]['bust'];
	$waist  = $arrQuery[0]['waist'];
	$hips   = $arrQuery[0]['hips'];
	$weight = $arrQuery[0]['weight'];
	$photo1 = $arrQuery[0]['photo_1'];
	$photo2 = $arrQuery[0]['photo_2'];
	$photo3 = $arrQuery[0]['photo_3'];

}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            REGISTRATION DETAIL
        </h1>
        <div id="status"></div>
          
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Lead Detail</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" id="boxcontent">
                    <div class="box-body" style="padding:30px;">
                <p style="background-color: crimson; color: white; font-size:18px;">PHOTOS</p>
                <div class="row">
                    <div class="col-sm-4">
                       <img src="images/mrscapitalimages/<?php echo $photo1;?>" style="width:300px;">
                    </div>
                    <div class="col-sm-4">
                        <img src="images/mrscapitalimages/<?php echo $photo2;?>" style="width:300px;">
                    </div>
                    <div class="col-sm-4">
                        <img src="images/mrscapitalimages/<?php echo $photo3;?>" style="width:300px;">
                    </div>
                </div><br>
                <p style="background-color: crimson; color: white; font-size:18px;">PERSONAL INFORMATION</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" id="name" placeholder="First Name" value="<?php echo $prsnName; ?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo $lastName; ?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" name="age" id="age" placeholder="Age*" class="form-control" value="<?php echo $age; ?>" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Martial Status</label>
                            <select name="martialstatus" id="martialstatus" placeHolder="Martial Status" class="form-control" required/>
                                <option value="">Select Martial Status</option>
                                <option value="MARRIED" <?php if($maritial_status == "MARRIED"){echo "selected";}?>>Married</option>
                                <option value="SEPARATED" <?php if($maritial_status == "SEPARATED"){echo "selected";}?>>Separated</option>
                                <option value="SINGLE_PARENT" <?php if($maritial_status == "SINGLE_PARENT"){echo "selected";}?>>Single Parent</option>
                                <option value="DIVORCED" <?php if($maritial_status == "DIVORCED"){echo "selected";}?>>Divorced</option>
                                <option value="WIDOW" <?php if($maritial_status == "WIDOW"){echo "selected";}?>>Widow</option>
                            </select>
                        </div>
                    </div>
                </div><br>
                <p style="background-color: crimson; color: white; font-size:18px;">CONTACT DETAILS</p>
                 <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Contact</label>
                           <input type="text" class="form-control" value="<?php echo $contactNum; ?>" name="mobilenumber" id="mobilenumber" class="form-control" placeholder="Contact Number" required/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                           <input type="email" class="form-control" value="<?php echo $prsnEmail; ?>" name="email" id="email" placeholder="Your Email ID" class="form-control" required/>
                        </div>
                    </div>
                 </div><br>
                 <p style="background-color: crimson; color: white; font-size:18px;">COMMUNICATION ADDRESS</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label>Address</label>
                             <input type="text" name="address" id="address" value="<?php echo $address_line_1; ?>" placeholder="Address Line 1*" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label>Address Line 2</label>
                             <input type="text" name="address1" id="address1" class="form-control" value="<?php echo $address_line_2; ?>" placeholder="Address Line 2">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" id="city" placeholder="City*" value="<?php echo $city; ?>" class="form-control" data-validation="required" data-validation-error-msg="City cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" id="state" placeholder="State*" value="<?php echo $state;?>" class="form-control" data-validation="required" data-validation-error-msg="State cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Pin Code</label>
                                <input type="text" name="pincode" id="pincode" placeholder="Postal Code*" value="<?php echo $postal_code; ?>" class="form-control" data-validation="required" data-validation-error-msg="Postal Code cannot be blank.">
                            </div>
                        </div>
                    </div><br>
                    <p style="background-color: crimson; color: white; font-size:18px;">PHYSICAL ATTRIBUTES</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Height</label>
                                <select name="height" id="height" class="form-control">
                                    <option value="">Select Your Height</option>
                                    <option value="5.1" <?php if($height == '5.1'){echo "selected";}?>>5.1 Ft</option>
                                    <option value="5.2" <?php if($height == '5.2'){echo "selected";}?>>5.2 Ft</option>
                                    <option value="5.3" <?php if($height == '5.3'){echo "selected";}?>>5.3 Ft</option>
                                    <option value="5.4" <?php if($height == '5.4'){echo "selected";}?>>5.4 Ft</option>
                                    <option value="5.5" <?php if($height == '5.5'){echo "selected";}?>>5.5 Ft</option>
                                    <option value="5.6" <?php if($height == '5.6'){echo "selected";}?>>5.6 Ft</option>
                                    <option value="5.7" <?php if($height == '5.7'){echo "selected";}?>>5.7 Ft</option>
                                    <option value="5.8" <?php if($height == '5.8'){echo "selected";}?>>5.8 Ft</option>
                                    <option value="5.9" <?php if($height == '5.9'){echo "selected";}?>>5.9 Ft</option>
                                    <option value="5.10" <?php if($height == '5.10'){echo "selected";}?>>5.10 Ft</option>
                                    <option value="5.11" <?php if($height == '5.11'){echo "selected";}?>>5.11 Ft</option>
                                    <option value="6Ft & Above" <?php if($height == '6Ft & Above'){echo "selected";}?>>6 Ft & Above</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Weight</label>
                                <input type="text" name="weight" id="weight" placeholder="Weight (in KGs)*" value="<?php echo $weight;?>" class="form-control">
                            </div>
                        </div>
                    </div><br>
                    <p style="background-color: crimson; color: white; font-size:18px;">VITAL STATS (IN INCHES)</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bust</label>
                               <input type="text" name="bust" id="bust" placeholder="Bust*" value="<?php echo $bust; ?>" class="form-control" data-validation="required" data-validation-error-msg="Bust cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Waist</label>
                               <input type="text" name="waist" id="waist" placeholder="Waist*" value="<?php echo $waist; ?>"  class="form-control" data-validation="required" data-validation-error-msg="waist cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Hips</label>
                               <input type="text" name="hips" id="hips" placeholder="Hips*" value="<?php echo $hips; ?>"  class="form-control" data-validation="required" data-validation-error-msg="Hips cannot be blank.">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="mrs_capital_gen_Pdf.php?action=download&id=<?php echo $id;?>" target="_blank" class="pull-right btn btn-lg" style="color:white; border-radius:50px; background-color:crimson;" >Download</a>
                        </div>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('footer.php');?>
<script>

function download_detail(action){
    
    //var data = $("#boxcontent").html();
    var name = $("#name").val();
    var lastname = $("#lastname").val();
    var age = $("#age").val();
    var martialstatus = $("#martialstatus").val();
    var mobilenumber = $("#mobilenumber").val();
    var email = $("#email").val();
    var address = $("#address").val();
    var address1 = $("#address1").val();
    var city = $("#city").val();
    var state = $("#state").val();
    var pincode = $("#pincode").val();
    var height = $("#height").val();
    var weight = $("#weight").val();
    var bust = $("#bust").val();
    var waist = $("#waist").val();
    var hips = $("#hips").val();
    var data = "name="+name+'&lastname='+lastname+'&age='+age+'&martialstatus='+martialstatus+'&mobilenumber='+mobilenumber+'&email='+email+'&address='+address+'&address1='+address1+'&city='+city+'&state='+state+'&pincode='+pincode+'&height='+height+'&weight='+weight+'bust='+bust+'waist='+waist+'&hips='+hips;
    $.ajax({
        type:'POST',
        url:'mrs_capital_gen_Pdf.php',
        data: data,
        // {name:name, lastname:lastname, age:age, martialstatus:martialstatus, mobilenumber:mobilenumber, email:email, address:address, address1:address1, city:city, state:state, pincode:pincode, height:height, weight:weight, bust:bust, waist:waist, hips:hips},
        beforeSend:function(){
            
        },
        success:function(html){
            return false;
            if(action == 'download'){
                
                //console.log("success");
                window.open(
				  'download_gen_pdf.php?f='+html,
				  '_blank' // <- This is what makes it open in a new window.
				);
                
            }
        }
    });
    
    
}
    
</script>