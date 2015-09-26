app.factory('menuFactory',function($http){
    return{
        getMenu: function(){
            return $http({
                method: 'GET',
                heasders: {'content-Type':'application/json'},
                url: 'getMenu'
            })
        },
        getServiceTypes: function(){
            return $http({
                method: 'GET',
                heasders: {'content-Type':'application/json'},
                url: 'getServiceTypes'
            })
        },
        getPayMethods: function(){
            return $http({
                method: 'GET',
                heasders: {'content-Type':'application/json'},
                url: 'getPayMethods'
            })
        },
        postOrder: function(order,transaction,yunpianInfo){
            return $http({
                method: 'POST',
                heasders: {'content-Type':'application/json'},
                url: 'postOrder',
                data: {order:order,transaction:transaction,yunpianInfo:yunpianInfo}
            })
        }
    };
});

app.factory('orderHistoryFactory',function($http){
    return{
        getOrderHistory: function(ST_TM,END_TM){
            return $http({
                method: 'GET',
                heasders: {'content-Type':'application/json'},
                url: 'getOrderHistory/'+ST_TM+'/'+END_TM
            })
        }
        ,updateStatus: function(order){
            return $http({
                method: 'POST',
                heasders: {'content-Type':'application/json'},
                url: 'updateStatus',
                data: {ORDR_ID:order.ORDR_ID,STATUS:order.STATUS}
            })
        }
    };
});

app.factory('greetingFactory',function($http){
    return{
        postGreetings: function(guestInfo,HTL_NM,HTL_ID){
            return $http({
                method: 'POST',
                heasders: {'content-Type':'application/json'},
                url: 'postGreetings',
                data: {guestInfo:guestInfo,HTL_NM:HTL_NM,HTL_ID:HTL_ID.toString()}
            })
        }
    };
});