app.factory('menuFactory',function($http){
    return{
        getMenu: function(HTL_ID){
            return $http({
                method: 'GET',
                heasders: {'content-Type':'application/json'},
                url: 'getMenu/'+HTL_ID.toString()
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
        getOrderHistory: function(HTL_ID,ST_TM,END_TM){
            return $http({
                method: 'GET',
                heasders: {'content-Type':'application/json'},
                url: 'getOrderHistory/'+HTL_ID.toString()+'/'+ST_TM+'/'+END_TM
            })
        }
    };
});