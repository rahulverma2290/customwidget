/* jQuery(document).ready(function(){
jQuery("#submitnew").click(function(){
	//alert();
	//var ajaxUrl = "/wp-admin/admin-ajax.php";
	//var target = 'http://'  +  window.location.hostname  + '/wp-admin/admin-ajax.php';
    var name = jQuery("#name").val();
	var emailaddress = jQuery("#emailaddress").val();
	var subject = jQuery("#subject").val();
	var pnumber = jQuery("#pnumber").val();
	var website = jQuery("#website").val();
	var message = jQuery("#message").val();
jQuery.ajax({
type: 'POST',
dataType: 'json',
url: WPAS_Ajax.ajaxurl,
action: 'new_functioncu',
data: {"name":name,"emailaddress":emailaddress,"subject":subject,"pnumber":pnumber,"website":website,"message":message},
//data:jQuery('#custom_id').serialize(),
success: function(data){
console.log(data);
alert(data);
}
});
});
}); */

/* jQuery('#custom_id').submit(function(e){
	alert();
    var name = jQuery("#name").val();
	var emailaddress = jQuery("#emailaddress").val();
	var subject = jQuery("#subject").val();
	var pnumber = jQuery("#pnumber").val();
	var website = jQuery("#website").val();
	var message = jQuery("#message").val();

    jQuery.ajax({ 
         data: {"name="name+ "&emailaddress="emailaddress+ "&subject="subject+ "&subject="subject+ "&pnumber="pnumber,+ "&website="website,+ "&message="message},
         type: 'post',
         url: widget-user.php,
         success: function(data) {
              console.log(data); //should print out the name since you sent it along
			  alert("sucess");

        }
    });

}); */

/*     jQuery('#custom_id').submit(ajaxSubmit);

    function ajaxSubmit(){
        var BookingForm = jQuery(this).serialize();
		alert();
        jQuery.ajax({
            type   : "POST",
            url    : wpa_data.admin_ajax,
			dataType: "json",
            data   : BookingForm,
            success: function(data){
                jQuery("#feedback").html(data);
            }
        });
        return false;
    } */
	
	
	jQuery(document).ready(function($){
       jQuery("#InsertionForm").validate({
		 debug: false,
            rules: {
                name: {
					required: true,
					maxlength: 8
				},
                emailaddress: {
                    required: true,
                    email: true
                },
				subject: {
                    required: true,
                    minlength: 6,
					maxlength: 10
                },
				pnumber: {
					required: true,
					rangelength:[10, 15],
					number: true
				},
				website: {
					required: true,
					url: true
					//range: [13, 23]
				}
            },
            messages: {
                //name: "Please let us know who you are.",
                //emailaddress: "A valid email will help us get in touch with you.",
				//subject: "Please Fill Minimum 6 number",
            },
		submitHandler: function(form) {
			var name = jQuery("#name").val();
			var emailaddress = jQuery("#emailaddress").val();
			var subject = jQuery("#subject").val();
			var pnumber = jQuery("#pnumber").val();
			var website = jQuery("#website").val();
			var message = jQuery("#message").val();

			jQuery.ajax({
			type:"POST",
			dataType: 'html',
			url: ajax_object.ajax_url,
			data: {
					'action': 'get_my_option', //action calling to insert data in wordpress db...
					'name': name, 
					'emailaddress': emailaddress,
					'subject': subject,
					'pnumber': pnumber,
					'website': website,
					'message': message
				},
			success:function($data){
				 //do something if Success
				//alert($data);
				
				 //document.getElementById("InsertionForm").reset();
				 jQuery('#InsertionForm')[0].reset();

				console.log($data);
				jQuery("#users_data").html($data);
			},
			error: function(error) {
					//do something if fail
					console.log(error);
				}
			});
		}

		});
	});

/* jQuery('#submitnew').submit(ajaxSubmit);

    function ajaxSubmit(){
        var customform = jQuery(this).serialize();
        jQuery.ajax({
            action : 'new_functioncu',
            type   : "POST",
            url    : "/wp-admin/admin-ajax.php",
            data   : customform,
            success: function(data){
                //jQuery("#feedback").html(data);
				alert(data);
            }
        });
        return false;
    } */