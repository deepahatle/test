var BasePagesUserForm = function() {
    var initValidationForm = function(){
        jQuery('.js-validation-register').validate({
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
                'doctor_create[name]':{
                    required: true
                },
                'doctor_create[email]':{
                    required: true,
                    email: true
                },
                'doctor_create[mobile]':{
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                'doctor_create[city]':{
                    required: true
                },
                'doctor_create[percentage]':{
                    required: true,
                    number: true
                }
            }
        });
    }

    return {
        init: function () {
            // Init Register Form Validation
            initValidationForm();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BasePagesUserForm.init(); });