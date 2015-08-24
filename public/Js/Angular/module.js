var app = angular.module('Operationer',['ngRoute','ngAnimate','ui.bootstrap']);
app.config(['$routeProvider',function ($routeProvider){
    $routeProvider
        .when('/menu',
        {
            controller:'menuCTRL',
            templateUrl: '../resources/views/menu/menu.blade.php'
        })
        .when('/orderHistory',
        {
            controller:'orderHistoryCTRL',
            templateUrl: '../resources/views/orderHistory/orderHistory.blade.php'
        })
        .otherwise({redirectTo: '/menu'})
    }
]);
