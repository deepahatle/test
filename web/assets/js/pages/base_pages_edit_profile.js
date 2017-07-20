var BasePagesUserForm = function() {
    var initValidationForm = function(){
        jQuery('.js-validation-register').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function (error, e) {
                if(e.attr('id') == 'lab_edit_signature'){
                    $('#signature').parent().append($(error).css('color', 'red'));
                }
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
            ignore: "",
            rules: {
                "lab_edit[name]":{
                    required: true
                },
                "lab_edit[email]":{
                    required: true,
                    email: true
                },
                "lab_edit[mobile]":{
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                "lab_edit[address]":{
                    required: true
                },
                "lab_edit[city]":{
                    required: true
                },
                "lab_edit[pincode]":{
                    required: true,
                    number: true
                },
                "lab_edit[doctor]":{
                    required: true
                },
                "lab_edit[signature]":{
                    required: true
                }
            },
            messages: {
                "lab_edit[signature]": {
                    required: "Doctor's Signature is required"
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