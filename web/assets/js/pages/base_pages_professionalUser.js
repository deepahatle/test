/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesUserForm = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationForm = function(){
        if(jQuery('.js-validation-create-professionalUser').length > 0 ) {

            $.validator.addMethod('filesize', function(value, element, param) {
                // param = size (en bytes)
                // element = element to validate (<input>)
                // value = value of the element (file name)
                return this.optional(element) || (element.files[0].size <= param*1024*1024)
            }, 'File size must be less than {0}Mb');

            $.validator.methods.url = function( value, element ) {
                return this.optional( element ) || /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test( value );
            };

            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);
            }, "Please enter a valid time.");

            jQuery('.js-validation-create-professionalUser').validate({
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
                    'professional_user_create[userType]': {
                        required: true,
                    },
                    'professional_user_create[name]': {
                        required: true,
                    },
                    //'professional_user_create[firstName]': {
                    //    required: true,
                    //},
                    //'professional_user_create[lastName]': {
                    //    required: true,
                    //},
                    'professional_user_create[mobileNo]': {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    'professional_user_create[landlineNo]': {
                        number: true,
                        minlength: 8,
                        maxlength: 16,
                    },
                    //'professional_user_create[firmName]': {
                    //    required: true,
                    //},
                    'professional_user_create[designation]': {
                        required: true,
                    },
                    'professional_user_create[gender]': {
                        required: true,
                    },
                    'professional_user_create[address]': {
                        required: true,
                    },
                    'professional_user_create[autolocation]': {
                        required: true,
                    },
                    'professional_user_create[email]': {
                        email: true,
                    },
                    'professional_user_create[website]': {
                        url: true,
                    },
                    'professional_user_create[subCategories][]': {
                        required: true,
                    },
                    'professional_user_create[bcen]': {
                        required: true,
                    },
                    'professional_user_create[dateOfCommencement]': {
                        required: true,
                    },
                    'professional_user_create[feesStart]': {
                        digits: true
                    },
                    'professional_user_create[morningTimeFrom]': {
                        time: true,
                    },
                    'professional_user_create[morningTimeTo]': {
                        time: true,
                    },
                    'professional_user_create[eveningTimeFrom]': {
                        time: true,
                    },
                    'professional_user_create[eveningTimeTo]': {
                        time: true,
                    },
                    'professional_user_create[daysAvailable][]': {
                        required: true,
                    },
                },
                messages: {
                    'professional_user_create[userType]': {
                        required: 'Please select user type.'
                    },
                    'professional_user_create[name]': {
                        required: 'Please enter full name.'
                    },
                    'professional_user_create[image]': {
                        filesize: 0.5,
                        extension: "jpg|jpeg|bmp|png",
                    },
                    'professional_user_create[mobileNo]': {
                        required: 'Please enter a mobile no.',
                        number: 'Please enter a valid mobile number.'
                    },
                    'professional_user_create[landlineNo]': {
                        number: 'Please enter a valid landline number.',
                    },
                    'professional_user_create[designation]': {
                        required: 'Please enter designation.',
                    },
                    'professional_user_create[gender]': {
                        required: 'Please select gender.',
                    },
                    'professional_user_create[address]': {
                        required: 'Please enter address.'
                    },
                    'professional_user_create[autolocation]': {
                        required: 'Please enter location.'
                    },
                    'professional_user_create[email]': {
                        email: 'Please enter valid email address.'
                    },
                    'professional_user_create[subCategories][]': {
                        required: "Please choose atleast one area of practice",
                    },
                    'professional_user_create[bcen]': {
                        required: "Please enter bar council / membership no.",
                    },
                    'professional_user_create[dateOfCommencement]': {
                        required: "Please enter date of commencement of practice",
                    },
                    'professional_user_create[website]': {
                        url: 'Please enter valid website url.'
                    },
                    'professional_user_create[morningTimeFrom]': {
                        time: 'Please enter a valid time, between 06:00 and 14:00'
                    },
                    'professional_user_create[morningTimeTo]': {
                        time: 'Please enter a valid time, between 07:00 and 14:00'
                    },
                    'professional_user_create[eveningTimeFrom]': {
                        time: 'Please enter a valid time, between 14:00 and 21:00'
                    },
                    'professional_user_create[eveningTimeTo]': {
                        time: 'Please enter a valid time, between 15:00 and 21:00'
                    },
                    'professional_user_create[daysAvailable][]': {
                        required: "Please choose at least one day in days available.",
                    },
                }
            });
        }

        if(jQuery('.js-validation-edit-professionalUser').length > 0 ) {

            $.validator.addMethod('filesize', function(value, element, param) {
                // param = size (en bytes)
                // element = element to validate (<input>)
                // value = value of the element (file name)
                return this.optional(element) || (element.files[0].size <= param*1024*1024)
            }, 'File size must be less than {0}Mb');

            $.validator.methods.url = function( value, element ) {
                return this.optional( element ) || /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test( value );
            };

            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);
            }, "Please enter a valid time.");

            jQuery('.js-validation-edit-professionalUser').validate({
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
                    'professional_user_edit[userType]': {
                        required: true,
                    },
                    'professional_user_edit[name]': {
                        required: true,
                    },
                    'professional_user_edit[image]': {
                        filesize: 0.5,
                        extension: "jpg|jpeg|bmp|png",
                    },
                    'professional_user_edit[mobileNo]': {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    'professional_user_edit[landlineNo]': {
                        number: true,
                        minlength: 8,
                        maxlength: 16,
                    },
                    'professional_user_edit[designation]': {
                        required: true,
                    },
                    'professional_user_edit[gender]': {
                        required: true,
                    },
                    'professional_user_edit[address1]': {
                        required: true,
                    },
                    'professional_user_edit[autolocation]': {
                        required: true,
                    },
                    'professional_user_edit[email]': {
                        email: true,
                    },
                    'professional_user_edit[website]': {
                        url: true,
                    },
                    'professional_user_edit[subCategories][]': {
                        required: true,
                    },
                    'professional_user_edit[bcen]': {
                        required: true,
                    },
                    'professional_user_edit[dateOfCommencement]': {
                        required: true,
                    },
                    'professional_user_edit[feesStart]': {
                        digits: true
                    },
                    'professional_user_edit[morningTimeFrom]': {
                        time: true,
                    },
                    'professional_user_edit[morningTimeTo]': {
                        time: true,
                    },
                    'professional_user_edit[eveningTimeFrom]': {
                        time: true,
                    },
                    'professional_user_edit[eveningTimeTo]': {
                        time: true,
                    },
                    'professional_user_edit[daysAvailable][]': {
                        required: true,
                    },
                },
                messages: {
                    'professional_user_edit[userType]': {
                        required: 'Please select user type.'
                    },
                    'professional_user_edit[name]': {
                        required: 'Please enter full name.'
                    },
                    //'professional_user_edit[fName]': {
                    //    required: 'Please enter first name.'
                    //},
                    //'professional_user_edit[lName]': {
                    //    required: 'Please enter last name.'
                    //},
                    'professional_user_edit[mobileNo]': {
                        required: 'Please enter a mobile no.',
                        number: 'Please enter a valid mobile number.'
                    },
                    'professional_user_edit[landlineNo]': {
                        number: 'Please enter a valid landline number.',
                    },
                    //'professional_user_edit[firmName]': {
                    //    required: 'Please enter firm name.',
                    //},
                    'professional_user_edit[designation]': {
                        required: 'Please enter designation.',
                    },
                    'professional_user_edit[gender]': {
                        required: 'Please select gender.',
                    },
                    'professional_user_edit[address1]': {
                        required: 'Please enter address.'
                    },
                    'professional_user_edit[autolocation]': {
                        required: 'Please enter location.'
                    },
                    'professional_user_edit[email]': {
                        email: 'Please enter valid email address.'
                    },
                    'professional_user_edit[subCategories][]': {
                        required: "Please choose atleast one area of practice",
                    },
                    'professional_user_edit[bcen]': {
                        required: "Please enter bar council / membership no.",
                    },
                    'professional_user_edit[dateOfCommencement]': {
                        required: "Please enter date of commencement of practice",
                    },
                    'professional_user_edit[website]': {
                        url: 'Please enter valid website url.'
                    },
                    'professional_user_edit[morningTimeFrom]': {
                        time: 'Please enter a valid time, between 06:00 and 14:00'
                    },
                    'professional_user_edit[morningTimeTo]': {
                        time: 'Please enter a valid time, between 07:00 and 14:00'
                    },
                    'professional_user_edit[eveningTimeFrom]': {
                        time: 'Please enter a valid time, between 14:00 and 21:00'
                    },
                    'professional_user_edit[eveningTimeTo]': {
                        time: 'Please enter a valid time, between 15:00 and 21:00'
                    },
                    'professional_user_edit[daysAvailable][]': {
                        required: "Please choose at least one day in days available.",
                    },
                }
            });
        }

        if(jQuery('.js-validation-edit-professionalUserChangePassword').length > 0 ) {

            $.validator.addMethod('filesize', function(value, element, param) {
                // param = size (en bytes)
                // element = element to validate (<input>)
                // value = value of the element (file name)
                return this.optional(element) || (element.files[0].size <= param*1024*1024)
            }, 'File size must be less than {0}Mb');

            $.validator.methods.url = function( value, element ) {
                return this.optional( element ) || /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test( value );
            };

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