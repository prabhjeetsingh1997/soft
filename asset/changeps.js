$(document).ready(function(){
$("#ps_City").change(function(){
			var city=$(this).val();
			var lang=$("#lang").val();
			//alert(lang);
			var data='city='+city+'&lang='+lang;
			$.ajax({  
			type: "POST",  
			url: "_ajax_user_authentication.php?action=change_val",
			data: data,
			beforeSend:function() {
			},
			success: function(msg)
			{  
				//alert(msg);
				$("#ps_Name").html(msg);
			} 
		});
       
      });
	});