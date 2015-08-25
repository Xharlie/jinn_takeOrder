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

    $scope.updateStatus = function(order){
        orderHistoryFactory.updateStatus(order).success(function(data){
            show(data);
        })
    }
    /********************************************      initial function     *****************************************/

    function getOrderHistory(startDate,endDate){
        orderHistoryFactory.getOrderHistory(2,
            dateUtil.dateFormat(startDate),
            dateUtil.dateFormat(new Date(endDate.getTime()+86400000)))
        .success(function(data){
            $scope.orders = data;
            var now = (new Date()).getTime()
            for(var i = 0; i < $scope.orders.length; i++){
                if($scope.orders[i].STATUS == '未确认'){
                    $scope.orders[i].orderTakenTime = util.Limit((now - (new Date($scope.orders[i].ORDR_TSTMP).getTime()))/1000/60 );
                    $scope.orders[i].deliveryTime = 0;
                }else if($scope.orders[i].STATUS == '已下单'){
                    $scope.orders[i].orderTakenTime = util.Limit(((new Date($scope.orders[i].ORDR_TAKEN_TSTMP).getTime())
                                                                - (new Date($scope.orders[i].ORDR_TSTMP).getTime()))/1000/60 );
                    $scope.orders[i].deliveryTime = util.Limit((now - (new Date($scope.orders[i].ORDR_TAKEN_TSTMP).getTime()))/1000/60 );
                }
            }
        });
    };

    setInterval(
        function(){
            getOrderHistory($scope.orderPanel.startDate,$scope.orderPanel.endDate);
        }
        ,30000
    );

    /********************************************     common initial setting     *****************************************/
    $scope.orderPanel={startDate:yesterday,endDate:today};
    getOrderHistory($scope.orderPanel.startDate,$scope.orderPanel.endDate);

    /************** ********************************** submit  ********************************** *************/


});