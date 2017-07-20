/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesUserForm = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationForm = function(){
        if(jQuery('.js-validation-create-executiveProfessionalUser').length > 0 ) {

            $.validator.addMethod('filesize', function(value, element, param) {
                // param = size (en bytes)
                // element = element to validate (<input>)
                // value = value of the element (file name)
                return this.optional(element) || (element.files[0].size <= param*1024*1024)
            }, 'File size must be less than {0}Mb');

            jQuery('.js-validation-create-executiveProfessionalUser').validate({
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
                    'executive_professional_user_create[formNo]': {
                        required: true,
                    },
                    'executive_professional_user_create[name]': {
                        required: true,
                    },
                    'executive_professional_user_create[mobileNo]': {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    'executive_professional_user_create[userPhoto]': {
                        required: false,
                        filesize: 0.5,
                        extension: "jpg|jpeg|bmp|gif|png",
                    }
                },
                messages: {
                    'executive_professional_user_create[formNo]': {
                        required: 'Please enter a form no.'
                    },
                    'executive_professional_user_create[name]': {
                        required: 'Please select a name.'
                    },
                    'executive_professional_user_create[mobileNo]': {
                        required: 'Please enter a mobile no.',
                        number: 'Please enter a valid mobile number.'
                    },
                    'executive_professional_user_create[userPhoto]': {
                        required: 'Please upload an image.',
                        extension: 'File extension must be .jpg, .jpeg, .bmp, .gif, .png only.'
                    }
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