
sugarApp.controller('AddPatientController', ['$scope', '$http', '$timeout', '$window', '$location', function ($scope, $http, $timeout, $window, $location) {

    var selectedTests = [], 
        selectedCount = 0;
    $scope.tests = [];
    $scope.totalAmount = 0;
    $scope.discount = 0;
    $scope.netAmount = 0;
    $scope.paidAmount = 0;
    $scope.balAmt = 0;

    $('#patient_create_test').select2({placeholder:'Enter Test'});

    $('#patient_create_userVisit_doctor').select2({
        placeholder:'Select Doctor',
        "language": {
            "noResults": function(){
                return "No Results Found <br /> <a target='_blank' class='btn btn-xs btn-success' href='" + TWIG.add_doctor_render + "'>Add new Doctor</a>";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    $http.post(TWIG.test_data).success(function (data, status, headers, config) {
        $scope.testData = data;        
    });

    $scope.selectTest = function(){
        var testObj = [];
        angular.forEach($scope.testSelect, function(e){
            testObj.push(_.findWhere($scope.testData, {id:e}));
        });
        $scope.tests = testObj;
        setAmount();
    }

    $scope.removeTest = function(test, testId){
        $scope.tests.splice($scope.tests.indexOf(test), 1);
        $scope.testSelect.splice($scope.testSelect.indexOf(testId), 1);
        setAmount();
    }

    function setAmount(){
        var costArray = _.pluck($scope.tests, 'cost');
        $scope.totalAmount = costArray.reduce(function(pv, cv) { return parseInt(pv) + parseInt(cv); }, 0);
    }

    $(function(){
        $('#patient_create_userVisit_user_mobile').on('blur', function(){
            if($(this).val() && !$(this).closest('.form-group').hasClass('has-error')){
                $block = $(this).closest('.block');
                $block.addClass('block-opt-refresh');
                $http.get(TWIG.user_by_mobile+"?mobile="+$(this).val()).success(function (data, status, headers, config) {
                    if (data != "null") {
                        $("#patient_create_userVisit_user_name").val(data.name);
                        $("#patient_create_userVisit_user_email").val(data.email);
                        $("#patient_create_userVisit_user_address").val(data.address);
                        $("#patient_create_userVisit_user_city").val(data.city);
                        $("#patient_create_userVisit_user_gender").val(data.gender);
                        $('#patient_create_userVisit_user_dob').val(data.dob);
                    };
                    $block.removeClass('block-opt-refresh');
                });            
            }
        });

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
                "patient_create[userVisit][user][mobile]":{
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                },
                "patient_create[userVisit][user][name]":{
                    required: true
                },
                "patient_create[userVisit][user][email]":{
                    required: true,
                    email: true
                },
                "patient_create[userVisit][user][city]":{
                    required: true
                },
                "patient_create[userVisit][user][gender]":{
                    required: true
                },
                "patient_create[userVisit][user][dob]":{
                    required: true
                },
                "patient_create[userVisit][doctor]":{
                    required: true
                },
                "patient_create[test][]":{
                    required: true
                },
                "patient_create[userVisit][totalAmount]":{
                    required: true,
                    number: true
                },
                "patient_create[userVisit][discount]":{
                    required: true,
                    number: true
                },
                "patient_create[userVisit][netAmount]":{
                    required: true,
                    number: true
                },
                "patient_create[userVisit][paidAmount]":{
                    required: true,
                    number: true
                }
            },
            invalidHandler: function(e, validator){
                setTimeout(function(){
                    validator.resetForm();
                    $('.has-error').removeClass('has-error');
                    $('.help-block').remove();
                }, 3000);
            }
        });
    });
}]);
