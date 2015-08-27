<!DOCTYPE html>
<html>

<body>

<div class="container">
    <div class="col-sm-2 sideControl">
        <ul>
            <li class="btn btn-customized" ng-click="selectServiceType('',allService)" ng-class="allService.activeClass">
                <div ><p>全部</p></div>
            </li>
            <li class="btn btn-customized" ng-repeat="serviceType in serviceTypes"
                    ng-click="selectServiceType(serviceType,serviceType)" ng-class="serviceType.activeClass">
                <div ><p ng-bind="serviceType.SRVC_TP_NM"></p></div>
            </li>
        </ul>
    </div>

    <!--以下div用于显示服务菜单的主题。需要从数据库中读出的内容在comment里面标记 -->
    <div class="col-md-10">
        <!-- 循环显示所有可供选择的服务 -->
        <!-- 每一个服务都被放到一个card里面 -->
        <div class="card card-default" ng-repeat="combo in combos | filter: {SRVC_TP_ID: selectedType.SRVC_TP_ID}"
             ng-click="openModal(combo,'comboDetailModal')" ng-class="combo.CMB_STL_CLSS">
            <div class="card-body">
                <!-- 服务照片 -->
                <div class="card-img" style="background:url(images/combo/{{combo.CMB_PIC}});background-size:cover;">
                   <!-- <img src="images/combo/{{combo.CMB_PIC}}" /> -->
                </div>
                <!-- 服务名称 -->
                <div class="card-text">
                    <h5>{{combo.CMB_NM}}</h5>
                    <!-- 服务描述 -->
                    <p>{{combo.CMB_DSCRPT}}</p>
                </div>
                <div class="card-price">
                    <!-- 价钱 -->
                    <span>¥{{combo.CMB_PRC}}</span>
                </div>
            </div>
            <!-- Trigger the modal with a button -->
        </div>
        <!-- Modal -->

        <div class="modal fade" role="dialog" id="comboDetailModal">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content modal-customized">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">填写订单</h5>
                    </div>
                    <div class="modal-body">
                        <div class="modal-left" style="background:url(images/combo/{{cmbSelected.CMB_PIC}});background-size:cover;">
                        </div>
                        <div class="modal-right modal-text">
                            <!-- 提供商 -->
                            <h5 class="text-bold">{{cmbSelected.MRCHNT_NM}}提供</h5>
                            <!-- 服务名称 -->
                            <h3 class="text-bold">{{cmbSelected.CMB_NM}}</h3>
                            <!-- 价钱 -->
                            <h4 class="text-brand text-bold">¥{{cmbSelected.CMB_PRC}}</h4>
                            <!-- 分割线 -->
                            <div class="separator-group">
                                <div class="separator-text">详细信息</div>
                                <div class="separator-line"></div>
                            </div>
                            <!-- 服务描述 -->
                            <p>{{cmbSelected.CMB_DSCRPT}}</p>
                            <!-- 给前台的instruction -->
                            <div class="separator-group">
                                <div class="separator-text">服务方式</div>
                                <div class="separator-line"></div>
                            </div>
                            <p>{{cmbSelected.CMB_PRVD_MTHD}}</p>
                            <!-- 分割线 -->
                            <div class="separator-group">
                                <div class="separator-text">订单信息</div>
                                <div class="separator-line"></div>
                            </div>
                            <div>
                                <form>
                                    <!-- 房间号 -->
                                    <div class="input-group input-customized">
                                        <label>房间号</label>
                                        <input ng-model="cmbSelected.RM_ID"/>
                                    </div>
                                    <!-- 付款方式 -->
                                    <div class="input-group input-customized">
                                        <label>付款方式</label>
                                        <select ng-model="cmbSelected.PYMNT_MTHD"
                                                ng-options="payMethod.PAY_MTHD_NM as payMethod.PAY_MTHD_NM for payMethod in cmbSelected.payMethods " />
                                    </div>
                                    <!-- 数量 -->
                                    <div class="input-group input-customized">
                                        <label>数量</label>
                                        <input type="num" ng-model="cmbSelected.AMNT"  />
                                    </div>
                                    <!-- 备注 -->
                                    <div class="input-group input-customized">
                                        <label>备注</label>
                                        <textarea rows="1" ng-model="cmbSelected.RMRK"></textarea>
                                    </div>
                                </form>
                            </div>
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> -->
                            <button type="button" class="btn btn-customized" ng-click="submit(cmbSelected,'comboDetailModal')">立即下单</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
    </div>
</div>
</body>
</html>