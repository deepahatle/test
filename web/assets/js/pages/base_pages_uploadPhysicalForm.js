/*
 *  Document   : base_pages_register.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Register Page
 */

var BasePagesUserForm = function() {
    // Init Register Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationForm = function(){
        if(jQuery('.js-validation-upload-physical-form').length > 0 ) {

            $.validator.addMethod('filesize', function(value, element, param) {
                // param = size (en bytes)
                // element = element to validate (<input>)
                // value = value of the element (file name)
                return this.optional(element) || (element.files[0].size <= param*1024*1024)
            }, 'File size must be less than {0}Mb');

            jQuery('.js-validation-upload-physical-form').validate({
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

                    'physical_form_upload[pdffile]': {
                        required: true,
                        filesize: 0.5,
                        extension: "pdf",
                    }
                },
                messages: {

                    'physical_form_upload[pdffile]': {
                        required: 'Please upload a pdf.',
                        extension: 'File extension must be .pdf only.'
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