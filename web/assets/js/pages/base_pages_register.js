/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesRegister = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationRegister = function(){
        jQuery('.js-validation-register').validate({
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
                'user_create[name]': {
                    required: true,
                    minlength: 3
                },
                'user_create[username]': {
                    required: true,
                    email: true
                },
                'user_create[mobileNo]': {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                'user_create[plainPassword][first]': {
                    required: true,
                    minlength: 5
                },
                'user_create[plainPassword][second]': {
                    required: true,
                    equalTo: '#user_create_plainPassword_first'
                }
            },
            messages: {
                'user_create[name]': {
                    required: 'Please enter a username',
                    minlength: 'Your username must consist of at least 3 characters'
                },
                'user_create[username]': 'Please enter a valid email address',
                'user_create[plainPassword][first]': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                },
                'user_create[plainPassword][second]': {
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