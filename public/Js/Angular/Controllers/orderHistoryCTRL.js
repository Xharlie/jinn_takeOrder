/**
 * Created by charlie on 8/20/15.
 */

app.controller('orderHistoryCTRL', function($scope,orderHistoryFactory) {

    /********************************************     validation       ***************************************************/


    /********************************************       utility       ****************************************************/

    var today = new Date();
    var yesterday = new Date(today.getTime()-86400000);

    $scope.$watch(function(){
            return $scope.orderPanel.startDate;
        },
        function(newValue, oldValue) {
            if(newValue == oldValue) return;
            getOrderHistory(newValue,$scope.orderPanel.endDate);
        },
        true
    );

    $scope.$watch(function(){
            return $scope.orderPanel.endDate;
        },
        function(newValue, oldValue) {
            if(newValue == oldValue) return;
            getOrderHistory($scope.orderPanel.startDate,newValue);
        },
        true
    );
    /********************************************      initial function     *****************************************/

    function getOrderHistory(startDate,endDate){
        orderHistoryFactory.getOrderHistory(2,
            dateUtil.dateFormat(startDate),
            dateUtil.dateFormat(new Date(endDate.getTime()+86400000)))
        .success(function(data){
            $scope.orders = data;
        });
    };


    /********************************************     common initial setting     *****************************************/
    $scope.orderPanel={startDate:yesterday,endDate:today};
    getOrderHistory($scope.orderPanel.startDate,$scope.orderPanel.endDate);

    /************** ********************************** submit  ********************************** *************/


});