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
])
// for laravel Request::ajax() to find it's ajax;
.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    $httpProvider.interceptors.push('sessionTimeoutInterceptor');
}])
// for laravel Request::ajax() find it's ajax if session time out, then reload and logout
.factory('sessionTimeoutInterceptor', [function(){
    return {
        'response': function(response){
            if (response != null && response.data == 'logout!'){
                window.location.reload();
            }else{
                return response;
            }
        }
    }
}
]);