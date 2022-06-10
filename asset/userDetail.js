$(document).ready(function(){
	  $("#user_Details").validate({
		   rules:{
		ca_Name:"required",
		ca_Edu:"required",
		ca_Prof_Type:"required",
		ca_Prof:"required",
		ca_Mon_Inc:{
		   required:true,
		   number: true
		},
		ca_Addr:"required",
		ca_Mobile:{
			required:true,
			minlength:10,
			maxlength:10,
			number: true
			},
		city:"required",
		ca_Category:"required",
		ps_Name:"required",
		ps_City:"required",
		dob:"required",
		age:{
		   required:true,
		   number: true
		},
		birth_Time:"required",
		birth_Place:"required",
		height:"required",
		weight:"required",
		color:"required",
		cast_Detail:"required",
		nakshtra:"required",
		gotra:"required",
		mama_Gotra:"required",
		bandhan:"required",
		manglik:"required",
		fa_Name:"required",
		fa_Addr:"required",
		fa_Prof:"required",
		fa_Mon_Income:{
		   required:true,
		   number: true
		},
		fa_Mobile:{
			required:true,
			minlength:10,
			maxlength:10,
			 number: true
		},
		married_Bro:"required",
		unmarried_Bro:"required",
		married_Sis:"required",
		unmarried_Sis:"required",
		residence_Type:"required",
		fir_cont_Name:"required",
		fir_cont_Addr:"required",
		fir_cont_Num:{
			required:true,
			minlength:10,
			maxlength:10
		},
		sec_cont_Name:"required",
		sec_cont_Addr:"required",
		sec_cont_Num:{
			required:true,
			minlength:10,
			maxlength:10
		}
		 },
		messages:{
				ca_Name:"Please enter your full name",
				ca_Edu:"Please enter your education",
				ca_Prof_Type:"Please Select Profession Type",
				ca_Prof:"Please enter your Profession",
				ca_Mon_Inc:{
				  required:"Please enter your Monthly Income",
				  
				},
				ca_Addr:"Please enter your current address",
				ca_Mobile:{
					required:"Please enter 10 Digits Mobile Number",
					minlength:"length should be 10 digits only",
					maxlength:"Length should be 10 digits only",
					number:"Please enter only Digits",
				},
				city:"Your City",
				ca_Category:"Please Select Your Category",
				ps_Name:"Your Parichay Sammelan Name",
				ps_City:"Enter Parichay Sammelan City",
				dob:"Please enter your Date of Birth",
				age:{
				  required:"Enter your age",
				  number:"Enter only digits"
				},
				birth_Time:"Enter your Birth Time",
				birth_Place:"Enter your Birth Place",
				height:"Enter your Height",
				weight:"Enter your Weight",
				color:"What is your color",
				cast_Detail:"Please enter your Cast",
				nakshtra:"Please enter your Nakhstra Detail",
				gotra:"Your Gotra",
				mama_Gotra:"Your Mama Gotra",
				bandhan:"enter any",
				manglik:"Select Yes or No",
				fa_Name:"Please enter your Father Name",
				fa_Addr:"Enter address",
				fa_Prof:"What is your father profession",
				fa_Mon_Income:{
				  required:"What is your father Monthly Income",
				  number:"Enter only digits"
				},
				fa_Mobile:{
					required:"Please enter 10 Digits Mobile Number",
					minlength:"length should be 10 digits only",
					maxlength:"Length should be 10 digits only",
					number:"Enter only digits"
				},
				married_Bro:"select the value from List",
				unmarried_Bro:"select the value from List",
				married_Sis:"select the value from List",
				unmarried_Sis:"select the value from List",
				residence_Type:"select Residence type from List",
				fir_cont_Name:"Please Enter First Contact Name",
				fir_cont_Addr:"Please Enter First Contact Address",
				fir_cont_Num:{
					required:"Please enter 10 Digits Mobile Number",
					minlength:"length should be 10 digits only",
					maxlength:"Length should be 10 digits only"
				},
				sec_cont_Name:"Please Enter First Contact Name",
				sec_cont_Addr:"Please Enter First Contact Address",
				sec_cont_Num:{
					required:"Please enter 10 Digits Mobile Number",
					minlength:"length should be 10 digits only",
					maxlength:"Length should be 10 digits only"
				}
				},
	  		
					submitHandler:function(form){
						 $.ajax({  
									type: "POST",  
									url: "_ajax_user_authentication.php?action=detail",
									data: $("#user_Details").serialize(),
									beforeSend:function() {
									},
									success: function(msg)
									{ 
										if(msg === '1')
										{
										$("#status").show().html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4> Succesfully Updated.</div>');  
										$("#user_Details")[0].reset();
										$('html, body').animate({scrollTop : 0},800);
										
										}
										else
										{
											$("#status").show().html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4> Sorry, there is some problem.</div>');
											$('html, body').animate({scrollTop : 0},800);
											
										}
									} 
								});
					}
								
		
		  });
		  
	});