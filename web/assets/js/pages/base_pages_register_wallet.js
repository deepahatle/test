var BasePagesRegister = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationRegister = function(){
        jQuery('.js-validation-walletRegister').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'mobile': {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                'email': {
                    required: true,
                    email: true
                }
            },
            messages: {
                'email': 'Please enter a valid email address'
            },
            submitHandler: function(form){
            	$(form).find(':submit').prop('disabled', true).html('Registering..');
            	$.ajax({
            		url: TWIG.wallet_register,
            		type: 'post',
            		data: $(form).serialize(),
            		success: function (response) {
            			$(form).find(':submit').prop('disabled', false).html('<i class="fa fa-check push-5-r"></i> Register');
            			if(response)
            				$('#otpModal').modal('show');
            			else
            				notify('Some error occured!', 'error');
            		}
            	});
            }
        });
    };

    return {
        init: function () {
            // Init Register Form Validation
            initValidationRegister();
        }
    };
}();

function notify(msg, type){	
	$.notify({
		icon: type == 'success' ? "fa fa-check" : "fa fa-times",
		message: msg,
		url: ''
	},
	{
		element: 'body',
		type: type == 'success' ? "success" : "danger",
		allow_dismiss: true,
		newest_on_top: true,
		showProgressbar: false,
		placement: {
			from: 'top',
			align: 'right'
		},
		offset: 30,
		spacing: 10,
		z_index: 1033,
		delay: 5000,
		timer: 1000,
		animate: {
			enter: 'animated fadeIn',
			exit: 'animated fadeOutDown'
		}
	});
}

// Initialize when page loads
jQuery(function(){ 
	BasePagesRegister.init();
	$('#otpForm').on('submit', function(e){
		e.preventDefault();
		$('#otpForm :submit').prop('disabled', true).html('Submitting..');
		$.ajax({
			url: TWIG.verify_otp,
			type: 'post',
			data: $('.js-validation-walletRegister').serialize() + '&otp=' + $('#otp').val(),
			success: function (response) {
				$('#otpForm :submit').prop('disabled', false).html('<i class="fa fa-check"></i> Submit OTP');
				$('#otpError').text(response.msg);
                setTimeout(function(){
                    $('#otpError').text('');
                }, 5000);
				if(response.result){
					$('#otpModal').modal('show');
					swal({
						title: "Wallet Registered Successfully",
						text: "Click the below button to add payment to your wallet.",
						type: "success"
					}, function(){
                        if(TWIG.referer_url.substr(TWIG.referer_url.lastIndexOf('/') + 1) == 'patients-visit-list')
                            window.location = TWIG.referer_url;
                        else
                            window.location = TWIG.dashboard_render;
					});
				}					
			}
		});
	});
});