<!DOCTYPE html>
<html lang="es" ng-app="campCunApp">
    <head>
        <title>Camp-Cun</title>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="views/home/css/bootstrap.min.css">
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="views/home/css/styles.css">
    </head>
    <body ng-controller="AppCtrl">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="mainMenu">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuButtons">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><img class="logo" src="views/home/img/logo.png" /> Camp-cun</a>
            </div>
            <div class="collapse navbar-collapse" id="menuButtons">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="caret"></i></a>
                    </li>
                </ul>
                <div search-form></div>
            </div><!-- /.navbar-collapse -->
        </nav>
        <div id="viewContent">
            <div ng-show="appF.mainView == 'map'" id="map" class="viewC"></div>
            <div ng-show="appF.mainView == 'directory'" id="directory" class="viewC" directory></div>
            <div ng-show="appF.mainView == 'todos'" id="todos" class="viewC" todos></div>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a ng-class="{'current':appF.mainView == 'map'}"
                       ng-click="appF.mainView = 'map'">
                        <i class="glyphicon glyphicon-map-marker"></i>
                        Mapa
                    </a>
                </li>
                <li>
                    <a ng-class="{'current':appF.mainView == 'directory'}"
                       ng-click="appF.mainView = 'directory'">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Directorio
                    </a>
                </li>
                <li>
                    <a ng-class="{'current':appF.mainView == 'todos'}"
                       ng-click="appF.mainView = 'todos'">
                        <i class="glyphicon glyphicon-check"></i>
                        List@?
                    </a>
                </li>
            </ul>
        </div>
    </body>
    <script src="views/home/js/angular.js"></script>
    <script src="views/home/js/jquery.js"></script>
    <script src="views/home/js/bootstrap.js"></script>
    <script src="views/home/js/app.js"></script>
</html>