/**
 * Created by charlie on 9/23/15.
 */

app.controller('greetingCTRL', function($scope,greetingFactory,sessionFactory) {

    /********************************************     validation       ***************************************************/


    /********************************************       utility       ****************************************************/
    $scope.addGuest = function(){
        $scope.guestInfo.push({
            name:null,
            phone:null
        });
    }


    /********************************************      initial function     *****************************************/
    function getMenu(length){
        $scope.guestInfo = [];
        for(var i = 0; i < length; i++) {
            $scope.guestInfo.push({
                name:null,
                phone:null
            });
        }
    };

    function getUserInfo(){
        sessionFactory.getUserInfo().success(function(data){
            if(data.userInfo != null){
                $scope.userInfo = data.userInfo;
            }else{
                $scope.userInfo = data;
            }
        });
    }

    /********************************************     common initial setting     *****************************************/
    getMenu(10);
    getUserInfo();

    /************** ********************************** submit  ********************************** *************/
    $scope.submit = function(){
        var guestInfo = [];
        for(var i = 0; i < $scope.guestInfo.length; i++){
            if(filterAlert.isNotEmpty($scope.guestInfo[i].phone) == null && filterAlert.isNumber($scope.guestInfo[i].phone) == null){
                guestInfo.push($scope.guestInfo[i]);
            }
        }
        greetingFactory.postGreetings(guestInfo,$scope.userInfo.HTL_NM,$scope.userInfo.HTL_ID).success(function(data){
            show(data['msg']);
        });
    }
});