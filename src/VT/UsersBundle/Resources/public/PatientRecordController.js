sugarApp.controller('PatientRecordController', ['$scope', '$http', '$timeout', '$window', '$location', '$q', function ($scope, $http, $timeout, $window, $location, $q) {
    $scope.maxSize = "5";

    /** search form */
    $scope.searchSpec = {};

    $scope.freeCredits = TWIG.free_credits;

    /** pagination */
    $scope.pageSpec = {
        pageSize: '10',
        currentPage: 1
    };

    /** sort spec */
    $scope.sortSpec = "";

    /** list of patients */
    $scope.patients = [];
    $scope.tests = [];
    $scope.patientName = '';
    $scope.totalRecords = '';

    $scope.statusColors = {
        "Sample Collected": "bg-info",
        "Sample under testing": "bg-danger",
        "Sample testing done": "bg-warning",
        "Report Delivered": "bg-success"
    }

    /*request canceller*/
    var canceller,
    isSending = false;

    $scope.loadInitialData = function() {
        // before we apply the filter, we check if there is any search / page / sort information in the URL.
        // if present then we populate the appropriate state variables in the scope and then apply the filter.
        $scope.moveFromURLToScope();
    };

    $scope.getListingData = function(pagination) {
        // Jquery App
        App.loader('show');

        if (!pagination) {
            $scope.pageSpec.currentPage = 1;
            $scope.patients = [];
        }

        var fullSpec = { 'sortSpec': $scope.sortSpec, 'pageSpec': $scope.pageSpec, 'searchSpec': $scope.searchSpec };

        if(isSending) {
            canceller.resolve()
        }
        isSending = true;
        canceller = $q.defer();
        $http.post(TWIG.patient_data, fullSpec, {timeout: canceller.promise}).success(function(data, status, headers, config) {
            isSending = false;
            $scope.patients = data.patients;
            if (data.totalRecords.length == 0 || data.totalRecords[0][1] == 0) {
                $scope.totalRecords = 0;
                $scope.currentFirstRecord = 0;
                $scope.currentLastRecord = 0;

            } else {
                $scope.totalRecords = data.totalRecords[0][1];
                $scope.currentFirstRecord = ($scope.pageSpec.currentPage - 1) * $scope.pageSpec.pageSize + 1;
                $scope.currentLastRecord = $scope.pageSpec.currentPage * $scope.pageSpec.pageSize;
                if ($scope.currentLastRecord > $scope.totalRecords) {
                    $scope.currentLastRecord = $scope.totalRecords;
                }
            }

            // Jquery App
            App.loader('hide');
            $timeout(reinitTooltip, 300);

            // when applying the filter we are also updating the URL in the browser window.
            // this is done to create bookmarkable URLs.
            $scope.moveFromScopeToURL();
        });
    };

    function reinitTooltip() {
        $('[data-toggle="tooltip"], .js-tooltip').tooltip({
            container: 'body',
            animation: false,
            trigger: 'hover'
        });
    }

    $scope.moveFromURLToScope = function() {
        var searchObject = $scope.parseLocation(window.location.search);
        if (searchObject.k) {
            $scope.searchSpec.keyword = searchObject.k;
        }

        $timeout(function() {
            $scope.getListingData(false);
        }, 500);
    };

    $scope.moveFromScopeToURL = function() {
        var param = {};
        if (!_.isEmpty($scope.searchSpec.keyword)) {
            param.k = $scope.searchSpec.keyword;
        }

        $location.search(param).replace();
    };

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
        $scope.getListingData(true);
    };

    /** Utility to get params from URL */
    $scope.parseLocation = function(location) {
        var pairs = location.substring(1).split("&");
        var obj = {};
        var pair;
        var i;

        for (i in pairs) {
            if (pairs[i] === "") continue;
            pair = pairs[i].split("=");
            obj[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }
        return obj;
    };

    $scope.loadInitialData();

    $scope.setStatusColor = function(status) {
        return $scope.statusColors[status];
    }

    $scope.setStatus = function(id, status, event) {
        if(status == "Sample testing done")
            $(event.currentTarget).closest('td').next().find('.updateBtn').click();
        
        $serviceUrl = TWIG.update_user_visit + "?id=" + id + "&status=" + status;
        $http.get($serviceUrl).then(function(response) {
            var patient = _.findWhere($scope.patients, { 'id': id });
            patient.status = status;
        });
    }

    $('#updateRecords').on('show.bs.modal', function(e) {
        var $source = $(e.relatedTarget);

        $('.body-block').addClass('block-opt-refresh');
        $scope.patientName = $source.data('name');

        $serviceUrl = TWIG.tests_by_patient_id + "?id=" + $source.data('id');
        $scope.tests = [];
        $http.get($serviceUrl).then(function(response) {
            $scope.tests = response.data;
            $('.body-block').removeClass('block-opt-refresh');
        });
    });

    $scope.saveRecord = function() {
        $('.body-block').addClass('block-opt-refresh');
        $http.post(TWIG.update_user_visit_tests, { 'tests': $scope.tests }).success(function(data, status, headers, config) {
            $('#updateRecords').modal('hide');
        });
    }

    $scope.setUserView = function(id) {
        if($scope.freeCredits > 0){
            swal({
                title: 'Notice',
                text: '1 Free Credit will be deducted from your account',
                type: 'warning',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#5c90d2',
                confirmButtonText: 'OK',
                closeOnConfirm: false,
            },
            function(){
                var user = _.findWhere($scope.patients, { 'id': id });
                user.enableViewForUser = 'Yes';
                user.status = "Report Delivered";
                var serviceUrl = TWIG.deduct_free_credits + "?id=" + id + "&enableViewForUser=" + user.enableViewForUser;
                $http.get(serviceUrl).then(function(response) {
                    swal({
                        title: 'Success',
                        text: 'User View enabled',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        closeOnConfirm: true
                    });
                    $scope.freeCredits--;
                });
            });
        }
        else{
            swal({
                title: 'Notice',
                text: 'Amount of Rs. 1 will be deducted from your wallet',
                type: 'warning',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#5c90d2',
                confirmButtonText: 'OK',
                closeOnConfirm: false,
            }, function() {
                $http.get(TWIG.deduct_from_wallet).then(function(response) {
                    var res = response.data
                    if(res.response){
                        var user = _.findWhere($scope.patients, { 'id': id });
                        user.enableViewForUser = 'Yes';
                        user.status = "Report Delivered";
                        $serviceUrl = TWIG.update_user_visit + "?id=" + id + "&enableViewForUser=" + user.enableViewForUser;
                        $http.get($serviceUrl).then(function(response){
                            swal({
                                title: 'Success',
                                text: 'User View enabled',
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                closeOnConfirm: true
                            });
                        });
                    }
                    else{
                        if(res.wallet)
                            swal({
                                title: 'Not enough money!',
                                text: 'Please login to your PayU wallet and add money to it.',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'OK',
                                closeOnConfirm: true,
                                html: false
                            },
                            function(){
                                window.location = "https://payumoney.com/";
                            });
                        else
                            swal({
                                title: 'No wallet registered!',
                                text: 'Please register a wallet and add money to it.',
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                closeOnConfirm: true,
                                html: false
                            },
                            function(){
                                window.location = TWIG.wallet_render;
                            });
                    }
                });            
            });    
        }    
    }

    $scope.updatePaidAmt = function(id, amt) {
        if (amt) {
            // Init an example confirm alert on button click
            $serviceUrl = TWIG.update_user_visit + "?id=" + id + "&addAmt=" + amt;
            $http.get($serviceUrl).then(function(response) {
                var response = response.data.msg;
                if (response == false) {
                    swal({
                        title: 'Invalid Amount',
                        text: 'Payment cannot be more than balance amount.',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                        html: false
                    });
                } else {
                    swal({
                        title: 'Amount Updated!',
                        text: 'Amount of Rs. ' + amt + ' paid',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#8CD4F5',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true,
                        html: false
                    }, function() {
                        $scope.getListingData(true);
                    });
                }
            });
        }
    }

    $(document).ready(function() {
        $('.block-content').on('keydown', '.numberOnly', function(e) {
            console.log(e.keyCode);
            // Allow: backspace, delete, tab, escape
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 109]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }

            if (e.keyCode == 13) {
                $(this).parent().find('button').click();
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        $(document).on('show.bs.dropdown', '.dropdown', function () {
            $this = $(this);
            $timeout(function(){
                $this.find('input').focus();
            }, 1);
        });
    });
}]);
