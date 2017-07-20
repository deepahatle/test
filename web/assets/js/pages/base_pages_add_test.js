$(function() {

    var getAjaxListData = function(params) {
        return {
            q: params.term,
            departmentId: $('#test_create_department').val()
        };
    };

    function setTestSelect() {
        var value = $(this).val();
        if (value) {
            $('#test_create_test').attr('disabled', false)
        } else {
            $('#test_create_test').attr('disabled', true)
        }
    }
    $('#test_create_department').on('change', setTestSelect);
    setTestSelect.call($('#test_create_department'));

    $('#test_create_test').select2({
        ajax: {
            url: TWIG.get_tests_by_dept,
            dataType: 'json',
            delay: 200,
            data: getAjaxListData,
            cache: false,
            tags: true,
        },
        placeholder: "Please select Test"
    });

    function setCost() {
        var value = $(this).val();
        if (value) {
            $.get(TWIG.get_cost_by_test, { testId: value }, function(data) {
                $('#test_create_cost').val(data.cost);
            });
        }
    }
    $('#test_create_test').on('change', setCost);

    $('.js-validation-register').validate({
        errorClass: 'help-block text-right animated fadeInDown',
        errorElement: 'div',
        errorPlacement: function (error, e) {
            $(e).parents('.form-group > div').append(error);
        },
        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');
            $(e).closest('.help-block').remove();
        },
        rules: {
            "test_create[department]": {
                required: true
            },
            "test_create[test]": {
                required: true
            },
            "test_create[cost]": {
                required: true,
                number: true
            }
        }
    });
});
