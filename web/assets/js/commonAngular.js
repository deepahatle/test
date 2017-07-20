/**
 * Created by root on 11/5/16.
 */

var sugarApp = angular.module('SugarApp', ['ui.bootstrap']).config(function ($locationProvider, $interpolateProvider) {
    $locationProvider.html5Mode(true).hashPrefix('!');
    $interpolateProvider.startSymbol('{[').endSymbol(']}');
});
