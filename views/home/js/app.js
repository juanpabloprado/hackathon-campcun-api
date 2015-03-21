'use strict';
var App = angular.module('campCunApp', []);

App.controller('AppCtrl', ['$scope', 'AppF','LocalS',
    function (scope, AppF, Local) {
        var setData = function(when){
            if(when === "afterLocal"){
                AppF.places = Local.getData("places");
            }
            scope.appF = AppF;
            console.log(scope.appF,"appF");
        }
        var localPlaces = Local.getData("places");
        if(!localPlaces){
            AppF.getAll().then(function(allData){
                Local.setData("places",allData[0].data);
                Local.setData("todos",allData[1].data);
                AppF.places = allData[0].data;
                AppF.todos = allData[0].data;
            }).then(function(){
                setData("afterAjax");
            });
        } else {
            setData("afterLocal");
        }
    }]);

App.controller('tabsCtrl', ['$scope', 'AppF',
    function (scope, AppF) {
        
    }]);

App.factory('AppF', ['$q','AjaxS',
    function ($q, Ajax) {
        return {
            mainView: "map",
            path: "views/home",
//            api: "http://tu-desarrollo.com/apps/camp-cun-api/",
            api: "index.php?url=",
            getAll: function(){
                return $q.all([
                    Ajax.request("post",this.api+"places/json",{}),
                    Ajax.request("post",this.api+"todos/json",{})
                ]);
            },
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

App.service('AjaxS', ['$http',
    function($http){
        return {
            request: function(method,url,params){
                if(angular.isUndefined(params)){ params = {}}
                params.apiKey = "2Q3xsKtpHe";
                var request = $http({
                    method: method, 
                    url: url, 
                    params: params,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                });
                return request;
            }
        }
}]);
App.service('LocalS',function(){
    return {
        getData: function(what){
            var localData = localStorage.getItem(what);
            var data = (localData == null) ? false : angular.fromJson(localData);
            return data;
        },
        cleanData: function (what){
            if(what instanceof Array){
                for(var w in what){
                    localStorage.removeItem(what[w]);
                }
            } else {
                localStorage.removeItem(what);
            }
            return true;
        },
        setData: function (name,data){
            var dataJson = angular.toJson(data);
            localStorage.setItem(name,dataJson);
            return true;
        }
    }
})