$(document).ready(function(){
	$('#sandbox-container .input-group.date').datepicker();
			$("#add_Reporting").validate({
			rules:{
				vanNumber:"required",
				visitedDate:"required",
				nameOfVillVisited:"required",
				patienRegisterd:{
					required:true,
					number:true
				},
				femPatients :{
					required:true,
					number:true
				},
				infantsChild:{
					required:true,
					number:true
				},
				infWithLowBirWeight:{
					required:true,
					number:true
				},
				bplScStObcPatients:{
					required:true,
					number:true
				},
				patienAvailAnyDignosService:{
					required:true,
					number:true
				},
				PatienReferToHighCenter:{
					required:true,
					number:true
				},
				womenAvailAncService:{
					required:true,
					number:true
				},
				bplScStObcWomAvailAncService:{
					required:true,
					number:true
				},
				womForANCChecAvalDigoSer:{
					required:true,
					number:true
				},
				womANCWhRecTTInjec:{
					required:true,
					number:true
				},
				ANCWiHighRisk:{
					required:true,
					number:true
				},
				womAvalPNCService:{
					required:true,
					number:true
				},
				PNCRefHighCenter:{
					required:true,
					number:true
				},
				prsnReceiveCond:{
					required:true,
					number:true
				},
				prsnReceivOraPills:{
					required:true,
					number:true
				},
				prsnCounselFp:{
					required:true,
					number:true
				}
			},
			messages:{
				vanNumber:"Please Select Van Number",
				visitedDate:"Please Select Visited Date",
				nameOfVillVisited:"Plaese Enter the Village Visited",
				patienRegisterd:{
					required:"Please Enter No. Of Patient Registerd",
					number:"Please Enter Only Digits"
				},
				femPatients :{
					required:"Please Enter No. of female patients",
					number:"Please Enter Only Digits"
				},
				infantsChild:{
					required:"No. of infants (below 5 years)",
					number:"Please Enter Only Digits"
				},
				infWithLowBirWeight:{
					required:"No. of infants with low birth weight",
					number:"Please Enter Only Digits"
				},
				bplScStObcPatients:{
					required:"No. of BPL / SC / ST/ OBC patients",
					number:"Please Enter Only Digits"
				},
				patienAvailAnyDignosService:{
					required:"patients who availed any of diagnostic services",
					number:"Please Enter Only Digits"
				},
				PatienReferToHighCenter:{
					required:"patients who were referred to higher centers",
					number:"Please Enter Only Digits"
				},
				womenAvailAncService:{
					required:"women who availed ANC services",
					number:"Please Enter Only Digits"
				},
				bplScStObcWomAvailAncService:{
					required:"BPL / SC/ ST/ OBC women who availed ANC service",
					number:"Please Enter Only Digits"
				},
				womForANCChecAvalDigoSer:{
					required:"Women for ANC checkups, availed diagnostic services",
					number:"Please Enter Only Digits"
				},
				womANCWhRecTTInjec:{
					required:"Women's for ANC checkups who received TT injections",
					number:"Please Enter Only Digits"
				},
				ANCWiHighRisk:{
					required:"ANC with high risk (examined / referred)",
					number:"Please Enter Only Digits"
				},
				womAvalPNCService:{
					required:"women who availed PNC services",
					number:"Please Enter Only Digits"
				},
				PNCRefHighCenter:{
					required:"PNC referred to higher centers",
					number:"Please Enter Only Digits"
				},
				prsnReceiveCond:{
					required:"Persons who received condoms",
					number:"Please Enter Only Digits"
				},
				prsnReceivOraPills:{
					required:"persons who received oral pills (strips)",
					number:"Please Enter Only Digits"
				},
				prsnCounselFp:{
					required:"persons who were counseled for FP",
					number:"Please Enter Only Digits"
				}
			},
			submitHandler:function(form){
				$.ajax({
					type:"POST",
					url:"_ajax_user_authentication.php?action=addReport",
					data:$("#add_Reporting").serialize(),
					beforeSend:function(){
						
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
							
						}
					} 
					
				});
			}
		});
	});