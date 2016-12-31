jQuery(function($) {
  "use strict";

    if(email !== ''){
		//alert(email);
		var adminurl = dynamicPath.adminUrl;
		//alert(adminurl);
		//jQuery('#mc-embedded-subscribe-form').submit();
		jQuery.ajax({
		    type: "POST",
		    url: adminurl,
		    data: { 
			 action: "submit_email",
			email: email },
		   
		    success: function (data){
			jQuery('.errorbox').hide();
			if(data == 000){ jQuery('.subs_done').show(); }
			else if(data == 001){ jQuery('.subs_error').show(); }
			else if(data == 002){ jQuery('.subs_emailerror').show(); }
			else if(data == 214){ jQuery('.subs_oldemailerror').show(); }
			else if(data == 502){ jQuery('.subs_emailerror').show(); }
			else{ jQuery('.wrongerror').show(); }
				if(data == 000 && redirect != ''){
					window.location.href = redirect;				
				}
			 },
		    error: function (err)
		      { jQuery('.subs_error').show();
			}
		  });
	}else{
		return false;	
	}
});