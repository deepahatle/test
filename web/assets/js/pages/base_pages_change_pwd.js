/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesRegister = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationRegister = function(){
        jQuery('.js-validation-change-pwd').validate({
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
                'change_password[oldPassword]': {
                    required: true,
                    remote: {
                        url: TWIG.check_pwd,
                        type: "post",
                        data: {
                            pass: function(){
                                return $('#change_password_oldPassword').val();   
                            },
                        }
                    }
                },
                'change_password[newPassword][first]': {
                    required: true,
                    minlength: 6
                },
                'change_password[newPassword][second]': {
                    required: true,
                    equalTo: '#change_password_newPassword_first'
                },
                'change_password_after_reset[newPassword][first]': {
                    required: true,
                    minlength: 6
                },
                'change_password_after_reset[newPassword][second]': {
                    required: true,
                    equalTo: '#change_password_after_reset_newPassword_first'
                }
            },
            messages: {
                'change_password[oldPassword]': {
                    required: "Please enter current password",
                    remote: "Your current password is incorrect",
                },
                'change_password[newPassword][first]': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                },
                'change_password[newPassword][second]': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long',
                    equalTo: 'Please enter the same password as above'
                },
                'change_password_after_reset[newPassword][first]': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                },
                'change_password_after_reset[newPassword][second]': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long',
                    equalTo: 'Please enter the same password as above'
                },
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

// Initialize when page loads
jQuery(function(){ BasePagesRegister.init(); });