/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesUserForm = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationForm = function(){

        if(jQuery('.js-validation-edit-end-user').length > 0 ) {
            jQuery('.js-validation-edit-end-user').validate({
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
                    'end_user_edit[name]': {
                        required: true,
                    },
                    'end_user_edit[mobileNo]': {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    'end_user_edit[userName]': {
                        required: true,
                        minlength: 3
                    },
                },
                messages: {
                    'end_user_edit[name]': {
                        required: 'Please enter a name'
                    },
                    'end_user_edit[mobileNo]': {
                        required: 'Please enter a mobile no',
                        number: 'Please enter a valid mobile number.'
                    },
                    'end_user_edit[username]': {
                        required: 'Please enter a username/email',
                        minlength: 'Your username must consist of at least 3 characters'
                    }
                }
            });
        }

        if(jQuery('.js-validation-edit-professionalUserChangePassword').length > 0 ) {

            //$.validator.addMethod('filesize', function(value, element, param) {
            //    // param = size (en bytes)
            //    // element = element to validate (<input>)
            //    // value = value of the element (file name)
            //    return this.optional(element) || (element.files[0].size <= param*1024*1024)
            //}, 'File size must be less than {0}Mb');

            //$.validator.methods.url = function( value, element ) {
            //    return this.optional( element ) || /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test( value );
            //};

            jQuery('.js-validation-edit-professionalUserChangePassword').validate({
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
                    'professional_user_edit_password[oldPassword]': {
                        required: true,
                        remote: {
                            url: TWIG.professional_user_crud_checkPassword,
                            type: "post",
                            data:{
                                id: $('#professional_user_edit_password_id').val(),
                            }
                        }
                    },
                    'professional_user_edit_password[newPassword][first]': {
                        required: true,
                        minlength: 5,
                    },
                    'professional_user_edit_password[newPassword][second]': {
                        required: true,
                        equalTo: "#professional_user_edit_password_newPassword_first"
                    },
                },
                messages: {
                    'professional_user_edit_password[oldPassword]': {
                        required: "Please enter current password",
                        remote: "Your current password is incorrect",
                    },
                    'professional_user_edit_password[newPassword][first]': {
                        required: 'Please enter new password',
                        minlength: 'Your password must be at least 5 characters long',
                    },
                    'professional_user_edit_password[newPassword][second]': {
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