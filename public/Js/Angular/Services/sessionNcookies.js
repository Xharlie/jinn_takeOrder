/**
 * Created by charlie on 7/13/15.
 */

app.factory('sessionFactory',function($http){
    var userInfo = null;
    return {
        getUserInfo: function(){
            if(userInfo != null){
                return { // unify the call back
                    success: function(exec){
                        exec(userInfo);
                    }
                };
            }else{
                if(uni.userInfo != null){
                    userInfo = uni.userInfo;
                    return { // unify the call back
                        success: function(exec){
                            exec(userInfo);
                        }
                    };
                }else{
                    return $http({
                        method: 'GET',
                        heasders: {'content-Type':'application/json'},
                        url: 'getUserInfo'
                    }).success(function(data){
                        if(data == null){
                            window.location.assign(window.location.href.substring(0, window.location.href.lastIndexOf('#'))+'logout');
                        }else{
                            userInfo = data;
                        }
                    });
                }
            }
        }
    }
});