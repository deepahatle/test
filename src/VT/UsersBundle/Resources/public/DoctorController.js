/**
 * Created by ojas on 24/5/16.
 */

sugarApp.controller('DoctorController', ['$scope', '$http', '$timeout', '$window', '$location', function ($scope, $http, $timeout, $window, $location) {
    $scope.maxSize = "5";

    /** search form */
    $scope.searchSpec = {};

    /** pagination */
    $scope.pageSpec = {
        pageSize: '10',
        currentPage: 1
    };

    /** sort spec */
    $scope.sortSpec = "";

    /** list of tests */
    $scope.tests = [];
    $scope.totalRecords = '';

    $scope.loadInitialData = function () {
        // before we apply the filter, we check if there is any search / page / sort information in the URL.
        // if present then we populate the appropriate state variables in the scope and then apply the filter.
        $scope.moveFromURLToScope();
    };

    $scope.getListingData = function (pagination) {
        // Jquery App
        App.loader('show');

        if (!pagination) {
            $scope.pageSpec.currentPage = 1;
            $scope.tests = [];
        }

        var fullSpec = {'sortSpec': $scope.sortSpec, 'pageSpec': $scope.pageSpec, 'searchSpec': $scope.searchSpec};

        $http.post(TWIG.doctor_data, fullSpec).success(function (data, status, headers, config) {
            $scope.doctors = data.doctors;
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
            $timeout(function(){
                $('[data-toggle="tooltip"], .js-tooltip').tooltip({
                    container: 'body',
                    animation: false
                });
            }, 300);

            // when applying the filter we are also updating the URL in the browser window.
            // this is done to create bookmarkable URLs.
            $scope.moveFromScopeToURL();
        });
    };

    $scope.moveFromURLToScope = function () {
        var searchObject = $scope.parseLocation(window.location.search);
        if (searchObject.k) {
            $scope.searchSpec.keyword = searchObject.k;
        }

        $timeout(function () {
            $scope.getListingData(false);
        }, 500);
    };

    $scope.moveFromScopeToURL = function () {
        var param = {};
        if (!_.isEmpty($scope.searchSpec.keyword)) {
            param.k = $scope.searchSpec.keyword;
        }

        $location.search(param).replace();
    };

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
        $scope.getListingData(true);
    };

    $scope.renderEdit = function (id) {
        $(location).attr('href', TWIG.doctor_edit + "?id=" + id);
    };

    $scope.deleteByID = function (id) {
        // Init an example confirm alert on button click
        swal({
            title: 'Are you sure?',
            text: 'You will not be able to recover this record!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d26a5c',
            confirmButtonText: 'Yes, delete it!',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            html: false
        }, function () {
            $serviceUrl = TWIG.doctor_delete + "?id=" + id;
            $http.get($serviceUrl).then(function (response) {
                swal({
                    title: 'Deleted!',
                    text: 'Doctor has been deleted.',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#8CD4F5',
                    confirmButtonText: 'OK',
                    closeOnConfirm: true,
                    html: false
                }, function () {
                    $scope.getListingData(false);
                });
            });
        });
    };

    /** Utility to get params from URL */
    $scope.parseLocation = function (location) {
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
}]);
