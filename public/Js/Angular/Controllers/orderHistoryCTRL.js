/**
 * Created by charlie on 8/20/15.
 */

app.controller('orderHistoryCTRL', function($scope,orderHistoryFactory) {

    /********************************************     validation       ***************************************************/


    /********************************************       utility       ****************************************************/

    var today = new Date();
    var yesterday = new Date(today.getTime()-86400000);
    var lastWeek = new Date(today.getTime()-6*86400000);

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
            getOrderHistory($scope.orderPanel.startDate,$scope.orderPanel.endDate);
        })
    };

    $scope.selectDate = function(date){
        if(date=='today'){
            $scope.orderPanel.startDate = today;
            $scope.orderPanel.endDate = today;
        }else if(date=='yesterday'){
            $scope.orderPanel.startDate = yesterday;
            $scope.orderPanel.endDate = yesterday;
        }else if(date=='thisWeek'){
            $scope.orderPanel.startDate = lastWeek;
            $scope.orderPanel.endDate = today;
        }
    };
    /********************************************      initial function     *****************************************/

    function getOrderHistory(startDate,endDate){
        orderHistoryFactory.getOrderHistory(2,
            dateUtil.dateFormat(startDate),
            dateUtil.dateFormat(new Date(endDate.getTime()+86400000)))
        .success(function(data){
            $scope.orders = data;
            var now = (new Date()).getTime()
            $scope.orderPanel.sumACCT_ON_RM = 0;
            for(var i = 0; i < $scope.orders.length; i++){
                ///// acct on room for every order
                $scope.orders[i].ACCT_ON_RM = ($scope.orders[i].PYMNT_MTHD == '酒店挂账' && $scope.orders[i].STATUS != '已取消')?
                ($scope.orders[i].AMNT * (parseFloat($scope.orders[i].CMB_TRANS_PRC) + parseFloat($scope.orders[i].CMB_PRC))):0;
                $scope.orderPanel.sumACCT_ON_RM = $scope.orderPanel.sumACCT_ON_RM + $scope.orders[i].ACCT_ON_RM;
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
    $scope.orderPanel={startDate:yesterday,endDate:today,sumACCT_ON_RM:0};
    getOrderHistory($scope.orderPanel.startDate,$scope.orderPanel.endDate);

    /************** ********************************** submit  ********************************** *************/


});