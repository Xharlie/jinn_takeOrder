/**
 * Created by charlie on 8/20/15.
 */

app.controller('menuCTRL', function($scope,menuFactory,sessionFactory) {

    /********************************************     validation       ***************************************************/


    /********************************************       utility       ****************************************************/

    $scope.selectServiceType = function(serviceType,serviceTypeStyle){
        $scope.selectedType = serviceType;
        serviceActive.activeClass = '';
        serviceTypeStyle.activeClass = 'btn-active';
        serviceActive = serviceTypeStyle;
    }

    $scope.openModal = function(combo,id){
        $scope.cmbSelected = JSON.parse(JSON.stringify(combo));
        $scope.cmbSelected.AMNT = 1;
        if($scope.cmbSelected.payMethods == null){
            $scope.cmbSelected.payMethods = [];
            var payMethodArray = $scope.cmbSelected.CMB_PAY_MTHD.split(',');
            for(var i = 0; i < $scope.payMethods.length; i++){
                if(payMethodArray.indexOf($scope.payMethods[i].PAY_MTHD_ID.toString())>=0){
                    $scope.cmbSelected.payMethods.push($scope.payMethods[i]);
                }
            }
        }
        $scope.cmbSelected.PYMNT_MTHD = $scope.cmbSelected.payMethods[0].PAY_MTHD_NM;
        $('#'+id).modal({backdrop: true});
    }

    /********************************************      initial function     *****************************************/
    function getMenu(){
        menuFactory.getMenu().success(function(data){
            $scope.combos = data;
        });
    };

    function getServiceTypes(){
        menuFactory.getServiceTypes().success(function(data){
            $scope.serviceTypes = data;
            for(var i = 0; i< $scope.serviceTypes.length; i++){
                $scope.serviceTypes[i].serviceActiveClass = '';
            }
        });
    };

    function getPayMethods(){
        menuFactory.getPayMethods().success(function(data){
            $scope.payMethods = data;
        });
    };

    /*********   get userInfo   **********/
    function getUserInfo(func){
        sessionFactory.getUserInfo().success(function(data){
            if(data.userInfo != null){
                $scope.userInfo = data.userInfo;
            }
            func();
        });
    }

    /********************************************     common initial setting     *****************************************/
    var HTL_NM = '京华火车站店';
    $scope.cmbSelected = null;
    $scope.allService = {activeClass : 'btn-active'};
    var serviceActive = $scope.allService;
    $scope.userInfo ={};
    getUserInfo(function(){
        getServiceTypes();
        getPayMethods();
        getMenu();
    });
    setInterval(
        function(){
            getServiceTypes();
            getPayMethods();
            getMenu();
        }
        ,600000
    );



    /************** ********************************** submit  ********************************** *************/
    $scope.submit = function(cmbSelected,modalId){
        if(!util.isNum(cmbSelected.AMNT)){
            show('请填好数量');
            return;
        }
        if(cmbSelected.RM_ID=='' || cmbSelected.RM_ID==null){
            show('请填好房间号');
            return;
        }
        for(var i = 0; i < $scope.serviceTypes.length; i++ ){
            if($scope.serviceTypes[i].SRVC_TP_ID == cmbSelected.SRVC_TP_ID){
                var alert = includes.checkAll($scope.serviceTypes[i].SRVC_NCSSRY_INFO,cmbSelected.RMRK);
                if(alert!=null){
                    show('在备注里'+alert);
                    return;
                }else{
                    break;
                }
            }
        }
        var now = dateUtil.tstmpFormat(new Date());
        var order = {
            CMB_ID:cmbSelected.CMB_ID,
            AMNT:cmbSelected.AMNT,
            ORDR_TSTMP:now,
            RMRK:cmbSelected.RMRK,
            RCVR_NM:null,
            RCVR_PHN:null,
            RCVR_ADDRSS:null,
            HTL_ID:HTL_ID,
            RM_ID:cmbSelected.RM_ID,
            TKT_ID:cmbSelected.CMB_ID.toString()+now,
            STATUS:'已下单'
        }
        var transaction = {
            HTL_ID: HTL_ID,
            RM_ID:cmbSelected.RM_ID,
            TSTMP:now,
            CUS_PHN:null,
            CUS_NM:null,
            PYMNT_TTL:(cmbSelected.CMB_PRC+cmbSelected.CMB_TRANS_PRC)*cmbSelected.AMNT,
            STATUS:'已下单',
            PYMNT_MTHD:cmbSelected.PYMNT_MTHD
        }
        var yunpianInfo ={
            CMB_NM: cmbSelected.CMB_NM,
            HTL_NM: HTL_NM
        }

        menuFactory.postOrder(order,transaction,yunpianInfo).success(function(data){
            show(data);
            $('#'+modalId).modal('hide');
        });
    }
});