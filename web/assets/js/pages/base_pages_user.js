/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesUserForm = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationForm = function(){
        if(jQuery('.js-validation-create-user').length > 0 ) {
            jQuery('.js-validation-create-user').validate({
                errorClass: 'help-block text-right animated fadeInDown',
                errorElement: 'div',
                errorPlacement: function (error, e) {
                    jQuery(e).parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                    jQuery(e).closest('.help-block').remove();
                },
                success: function (e) {
                    jQuery(e).closest('.form-group').removeClass('has-error');
                    jQuery(e).closest('.help-block').remove();
                },
                rules: {
                    'user_create[name]': {
                        required: true,
                    },
                    'user_create[mobileNo]': {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    'user_create[userType]': {
                        required: true
                    },
                    'user_create[username]': {
                        required: true,
                        minlength: 3
                    },
                    'user_create[plainPassword][first]': {
                        required: true,
                        minlength: 5
                    },
                    'user_create[plainPassword][second]': {
                        required: true,
                        minlength: 5,
                        equalTo: '#user_create_plainPassword_first'
                    },
                    'user_create[roles][]': {
                        required: true
                    }
                },
                messages: {
                    'user_create[name]': {
                        required: 'Please enter a name'
                    },
                    'user_create[userType]': {
                        required: 'Please select a user type'
                    },
                    'user_create[mobileNo]': {
                        required: 'Please enter a mobile no',
                        number: 'Please enter a valid mobile number.'
                    },
                    'user_create[username]': {
                        required: 'Please enter a username/email',
                        minlength: 'Your username must consist of at least 3 characters'
                    },
                    'user_create[plainPassword][first]': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    'user_create[plainPassword][second]': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long',
                        equalTo: 'Please enter the same password as above'
                    },
                    'user_create[roles][]': 'You must assign atleast one role to the user!'
                }
            });
        }


        if(jQuery('.js-validation-edit-user').length > 0 ) {
            jQuery('.js-validation-edit-user').validate({
                errorClass: 'help-block text-right animated fadeInDown',
                errorElement: 'div',
                errorPlacement: function (error, e) {
                    jQuery(e).parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                    jQuery(e).closest('.help-block').remove();
                },
                success: function (e) {
                    jQuery(e).closest('.form-group').removeClass('has-error');
                    jQuery(e).closest('.help-block').remove();
                },
                rules: {
                    'user_edit[name]': {
                        required: true,
                    },
                    'user_edit[mobileNo]': {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    'user_edit[userType]': {
                        required: true
                    },
                    'user_edit[username]': {
                        required: true,
                        minlength: 3
                    },
                    'user_edit[plainPassword][first]': {
                        required: true,
                        minlength: 5
                    },
                    'user_edit[roles][]': {
                        required: true
                    }
                },
                messages: {
                    'user_edit[name]': {
                        required: 'Please enter a name'
                    },
                    'user_edit[userType]': {
                        required: 'Please select a user type'
                    },
                    'user_edit[mobileNo]': {
                        required: 'Please enter a mobile no',
                        number: 'Please enter a valid mobile number.'
                    },
                    'user_edit[username]': {
                        required: 'Please enter a username/email',
                        minlength: 'Your username must consist of at least 3 characters'
                    },
                    'user_edit[plainPassword][first]': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    'user_edit[roles][]': 'You must assign atleast one role to the user!'
                }
            });
        }


        if(jQuery('.js-validation-edit-user-password').length > 0 ) {
            jQuery('.js-validation-edit-user-password').validate({
                errorClass: 'help-block text-right animated fadeInDown',
                errorElement: 'div',
                errorPlacement: function (error, e) {
                    jQuery(e).parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                    jQuery(e).closest('.help-block').remove();
                },
                success: function (e) {
                    jQuery(e).closest('.form-group').removeClass('has-error');
                    jQuery(e).closest('.help-block').remove();
                },
                rules: {
                    'user_edit_password[password][first]': {
                        required: true,
                        minlength: 5
                    },
                    'user_edit_password[password][second]': {
                        required: true,
                        equalTo: "#user_edit_password_password_first"
                    },
                },
                messages: {
                    'user_edit_password[password][first]': {
                        required: 'Please enter new password',
                        minlength: 'Your password must be at least 5 characters long',
                    },
                    'user_edit_password[password][second]': {
                        required: 'Please enter repeat password',
                        equalTo: 'Your password does not match',
                    },
                }
            });
        }
    };

    return {
        init: function () {
            // Init Register Form Validation
            initValidationForm();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BasePagesUserForm.init(); });