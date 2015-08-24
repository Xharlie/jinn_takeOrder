<!DOCTYPE html>
<html ng-app="Operationer" >
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-COMPATIBLE" content="IE-edge">
        <title>神灯后台</title>
        <link href="Stylesheets/app.css" rel="stylesheet">
        <!-- Javascript -->
        <!--        <script src="assets/javascripts/application.js"></script>-->
    </head>
    <body>
        <div class="sideNavContainer" ng-controller="generalNavCTRL" >
            @include('generalNav')
        </div>
        <div class="main contentContainer container-fluid "  ng-view></div>

        <!-- JS lib-->

        <script src="Scripts/Jquery/jquery-1.11.1.js"></script>
        <script src="Scripts/BootStrap/bootstrap.min.js"></script>
        <script src="Scripts/AngularJs/angular_1.4.1/angular.min.js"></script>
        <script src="Scripts/AngularJs/angular_1.4.1/ui-bootstrap-tpls.min.js"></script>
        <script src="Scripts/AngularJs/angular_1.4.1/angular-route.min.js"></script>
        <script src="Scripts/AngularJs/angular_1.4.1/angular-animate.min.js"></script>
        <script src="Scripts/AngularJs/angular_1.4.1/angular-cookies.min.js"></script>
        <script src="Scripts/AngularJs/angular_1.4.1/angular-locale_zh-cn.js"></script>
        <!-- JS Angular module-->
        <script src="Js/Angular/module.js"></script>
        <!-- JS Angular Controllers-->
        <script src="Js/Angular/Controllers/buildInDirController.js"></script>
        <script src="Js/Angular/Controllers/generalNavCTRL.js"></script>
        <script src="Js/Angular/Controllers/menuCTRL.js"></script>
        <script src="Js/Angular/Controllers/orderHistoryCTRL.js"></script>
        <!-- JS Angular Services-->
        <script src="Js/Angular/Services/menuService.js"></script>

        <!-- JS utility-->
        <script src="Js/pan_lib/dateUtil.js"></script>
        <script src="Js/pan_lib/util.js"></script>
    </body>
</html>

