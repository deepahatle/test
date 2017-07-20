/*
 *  Document   : base_pages_login.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Login Page
 */

var BasePagesLogin = function() {
    // Init Login Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationLogin = function(){
        if(jQuery('.js-validation-forgot-password').length > 0 ) {

            jQuery('.js-validation-forgot-password').validate({
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
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            url: TWIG.check_user,
                            type: 'post'
                        }
                    }
                },
                messages: {
                    'email': {
                        required: 'Please enter a registered email address.',
                        remote: 'No such SugarLogger account exist.'
                    }
                },
                submitHandler: function (form) {
                    $(form).find(':submit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin pull-right"></i> Sending');
                    $.ajax({
                        url: TWIG.send_reset_password_link,
                        type: 'post',
                        data: {
                            email: $('#email').val()
                        },
                        success: function (response) {
                            if(response) {
                                $('#forgotPasswordSubmit').html('<i class="si si-envelope-open pull-right"></i> Send Mail');
                                swal({
                                    title: "Great!",
                                    text: "We have sent you password reset link on your registered email address. Please check your mail for more details.",
                                    type: "success"
                                }, function(){ 
                                    window.history.back();
                                });
                            }
                        }
                    });
                }
            });
        }
    };

    return {
        init: function () {
            // Init Login Form Validation
            initValidationLogin();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BasePagesLogin.init(); });