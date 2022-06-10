<?php
include('header.php');
include('sidebar.php');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-calendar" aria-hidden="true"></i></i> Mrs Capital
        <small>Add New Detail</small>
      </h1>
       <div id="status"></div>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Mrs Capital</a></li>
        <li class="active">ADD NEW</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body" style="padding:30px;">
                        <form class="has-validation-callback" action="" method="POST" name="" id="EnqryForm" enctype="multipart/form-data">
                
                <p style="background-color: crimson; color: white; font-size:18px;">PERSONAL INFORMATION</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" id="name" placeholder="First Name" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" id="lastname" placeholder="Last Name" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" name="age" id="age" placeholder="Age*" class="form-control" required/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Martial Status</label>
                            <select name="martialstatus" id="martialstatus" placeHolder="Martial Status" class="form-control" required/>
                                <option value="">Select Martial Status</option>
                                <option value="MARRIED">Married</option>
                                <option value="SEPARATED">Separated</option>
                                <option value="SINGLE_PARENT">Single Parent</option>
                                <option value="DIVORCED">Divorced</option>
                                <option value="WIDOW">Widow</option>
                            </select>
                        </div>
                    </div>
                </div><br>
                <p style="background-color: crimson; color: white; font-size:18px;">CONTACT DETAILS</p>
                 <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Contact</label>
                           <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" class="form-control" placeholder="Contact Number" required/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                           <input type="email" class="form-control" name="email" id="email" placeholder="Your Email ID" class="form-control" required/>
                        </div>
                    </div>
                 </div><br>
                 <p style="background-color: crimson; color: white; font-size:18px;">COMMUNICATION ADDRESS</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label>Address</label>
                             <input type="text" name="address" id="address" placeholder="Address Line 1*" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label>Address Line 2</label>
                             <input type="text" name="address1" class="form-control" placeholder="Address Line 2">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" id="city" placeholder="City*" class="form-control" data-validation="required" data-validation-error-msg="City cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" id="state" placeholder="State*" class="form-control" data-validation="required" data-validation-error-msg="State cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Pin Code</label>
                                <input type="text" name="pincode" id="pincode" placeholder="Postal Code*" class="form-control" data-validation="required" data-validation-error-msg="Postal Code cannot be blank.">
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
                                    <option value="5.1">5.1 Ft</option>
                                    <option value="5.2">5.2 Ft</option>
                                    <option value="5.3">5.3 Ft</option>
                                    <option value="5.4">5.4 Ft</option>
                                    <option value="5.5">5.5 Ft</option>
                                    <option value="5.6">5.6 Ft</option>
                                    <option value="5.7">5.7 Ft</option>
                                    <option value="5.8">5.8 Ft</option>
                                    <option value="5.9">5.9 Ft</option>
                                    <option value="5.10">5.10 Ft</option>
                                    <option value="5.11">5.11 Ft</option>
                                    <option value="6Ft & Above">6 Ft & Above</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Height</label>
                                <input type="text" name="weight" id="weight" placeholder="Weight (in KGs)*" class="form-control">
                            </div>
                        </div>
                    </div><br>
                    <p style="background-color: crimson; color: white; font-size:18px;">VITAL STATS (IN INCHES)</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bust</label>
                               <input type="text" name="bust" id="bust" placeholder="Bust*" class="form-control" data-validation="required" data-validation-error-msg="Bust cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Waist</label>
                               <input type="text" name="waist" id="waist" placeholder="Waist*" class="form-control" data-validation="required" data-validation-error-msg="waist cannot be blank.">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Hips</label>
                               <input type="text" name="hips" id="hips" placeholder="Hips*" class="form-control" data-validation="required" data-validation-error-msg="Hips cannot be blank.">
                            </div>
                        </div>
                        
                    </div>
                    <p style="background-color: crimson; color: white; font-size:18px;">PHOTOS</p>
                    <div class="row">
                        <div class="col-sm-4 imgUp">
                          <div class="imagePreview" style="background-image:url(images/upload-image-1.jpg)"></div>
                          <label class="btn" style="width:100%; color:white; background-color: crimson;">
                          Upload<input type="file" class="uploadFile img" name="photo_1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"/>
                          </label>
                        </div>
                        <div class="col-sm-4 imgUp">
                          <div class="imagePreview" style="background-image:url(images/upload-image-2.jpg)"></div>
                          <label class="btn" style="width:100%; color:white; background-color: crimson;">
                          Upload<input type="file" class="uploadFile img" name="photo_2" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"/>
                          </label>
                        </div>
                        <div class="col-sm-4 imgUp">
                          <div class="imagePreview" style="background-image:url(images/upload-image-3.jpg)"></div>
                          <label class="btn" style="width:100%; color:white; background-color: crimson;">
                          Upload<input type="file" class="uploadFile img" name="photo_3" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"/>
                          </label>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <input type="submit" id="SubForm" onclick="SubmitForm()" class="pull-right btn btn-lg" style="margin-top: 15px; color:white; border-radius:50px; background-color: crimson;" >
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('footer.php');?>
<style>
    .imagePreview {
    width: 100%;
    height: 180px;
    background-position: center center;
  /*background: url(../images/upload-image.jpg);*/
    background-color:#fff;
    background-size: contain;
    background-repeat:no-repeat;
    display: inline-block;
    box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
}
</style>
<script type="text/javascript">
    function SubmitForm(){
        var formData = $("#EnqryForm").serialize();
        $.ajax({
           type:'POST',
           url:'_ajax_add_new_event_detail.php?action=addnew',
           data: formData,
           beforeSend:function(){
               
           },
           success:function(result){
            if(result == '1')
            {
                $("#status").show().html('<div class="alert alert-success"> New record is inserted</div>');
                window.location.href='dskevent.php';

            }
           }
        });
        
    }
    // function AddNew() {
    //     var formData = new FormData($('#add')[0]);
    //     formData.append('photo', $('input[type=file]')[0].files[0]);
    //     $.ajax({
    //         type:'post',
    //         url: '_ajax_add_new_event_detail.php?action=addnew',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success:function(result) {
    //             if(result == '1')
    //             {
    //               $("#status").show().html('<div class="alert alert-success"> New record is inserted</div>');
    //               window.location.href='dskevent.php';

    //             }
    //             else if (result == '0' || result == '2' || result == '3')
    //             {
    //                 $("#status").show().html('<div class="alert alert-danger">Sorry, there is something problem please try again later</div>');     
    //             }
    //         }
    //     });
    // }
    
    $(document).on("change",".uploadFile", function(){
    	var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
      
    });
</script>