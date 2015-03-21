'use strict';
var App = angular.module('campCunApp', []);

App.controller('AppCtrl', ['$scope', 'AppF',
    function (scope, AppF) {
        scope.appF = AppF;
    }]);

App.controller('tabsCtrl', ['$scope', 'AppF',
    function (scope, AppF) {
        
    }]);

App.factory('AppF', [
    function () {
        return {
            mainView: "map",
            path: "views/home"
        }
    }]);

App.directive('directory', ['AppF',
    function (AppF) {
        return {
            strict: "E",
            scope: true,
            transclude: true,
            templateUrl: AppF.path+"/directory.html",
            controller: "tabsCtrl",
            link: function (scope, ele, attr, ctrl) {
                
            }
        };
    }]);
App.directive('todos', ['AppF',
    function (AppF) {
        return {
            strict: "E",
            scope: true,
            transclude: true,
            templateUrl: AppF.path+"/todos.html",
            controller: "tabsCtrl",
            link: function (scope, ele, attr, ctrl) {
                
            }
        };
    }]);