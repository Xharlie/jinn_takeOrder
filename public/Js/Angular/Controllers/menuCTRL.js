/**
 * Created by charlie on 8/20/15.
 */

app.controller('menuCTRL', function($scope,menuFactory) {

    /********************************************     validation       ***************************************************/


    /********************************************       utility       ****************************************************/

    $scope.selectServiceType = function(serviceType){
        $scope.selectedType = serviceType;
    }

    $scope.openModal = function(combo,id){
        $scope.cmbSelected = JSON.parse(JSON.stringify(combo));
        $scope.cmbSelected.AMNT = 1;
        $scope.cmbSelected.PYMNT_MTHD = $scope.payMethods[0].PAY_MTHD_NM;
        $('#'+id).modal({backdrop: true});
    }

    /********************************************      initial function     *****************************************/
    function getMenu(HTL_ID){
        menuFactory.getMenu(HTL_ID).success(function(data){
            $scope.combos = data;
        });
    };

    function getServiceTypes(){
        menuFactory.getServiceTypes().success(function(data){
            $scope.serviceTypes = data;
        });
    };

    function getPayMethods(){
        menuFactory.getPayMethods().success(function(data){
            $scope.payMethods = data;
        });
    };

    function updateStatus(order){

    }
    /********************************************     common initial setting     *****************************************/
    var HTL_ID = 2;
    var HTL_NM = '京华火车站店';
    $scope.cmbSelected = null;
    getServiceTypes();
    getPayMethods();
    getMenu(HTL_ID);
    /************** ********************************** submit  ********************************** *************/
    $scope.submit = function(cmbSelected,modalId){
        if(!util.isNum(cmbSelected.AMNT)){
            show('请填好数量');
            return;
        };
        if(cmbSelected.RM_ID=='' || cmbSelected.RM_ID==null){
            show('请填好房间号');
            return;
        };
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
            STATUS:'未确认'
        }
        var transaction = {
            HTL_ID: HTL_ID,
            RM_ID:cmbSelected.RM_ID,
            TSTMP:now,
            CUS_PHN:null,
            CUS_NM:null,
            PYMNT_TTL:(cmbSelected.CMB_PRC+cmbSelected.CMB_TRANS_PRC)*cmbSelected.AMNT,
            STATUS:'未确认',
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