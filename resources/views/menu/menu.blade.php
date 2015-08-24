<!DOCTYPE html>
<html>

<body>

<div class="container">
    <div class="col-sm-1 sideControl">
        <ul>
            <li>
                <div ng-click="selectServiceType('')">
                        <div class=""><p>全部</p></div>
                </div>
            </li>
            <li ng-repeat="serviceType in serviceTypes">
                <div ng-click="selectServiceType(serviceType)">
                        <div class=""><p ng-bind="serviceType.SRVC_TP_NM"></p></div>
                </div>
            </li>
        </ul>
    </div>

    <!--以下div用于显示服务菜单的主题。需要从数据库中读出的内容在comment里面标记 -->
    <div class="col-md-11">
        <!-- 循环显示所有可供选择的服务 -->
        <!-- 每一个服务都被放到一个card里面 -->
        <div class="card card-default" ng-repeat="combo in combos | filter: {SRVC_TP_ID: selectedType.SRVC_TP_ID}"
             ng-click="openModal(combo,'comboDetailModal')" >
            <div class="card-body">
                <!-- 服务照片 -->
                <div class="card-img">
                    <img src="images/combo/{{combo.CMB_PIC}}">
                </div>
                <!-- 服务名称 -->
                <div class="card-text">
                    <h4>{{combo.CMB_NM}}</h4>
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
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">具体信息</h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <!-- 服务照片 -->
                            <img src="{{'images/combo/'+cmbSelected.CMB_PIC}}">
                            <!-- 服务名称 -->
                            <h3>{{cmbSelected.CMB_NM}}</h3>
                            <!-- 提供商 -->
                            <h4>由{{cmbSelected.MRCHNT_NM}}提供</h4>
                            <!-- 服务描述 -->
                            <p>{{cmbSelected.CMB_DSCRPT}}</p>
                            <!-- 价钱 -->
                            <p>¥{{cmbSelected.CMB_PRC}}</p>
                            <!-- 给前台的instruction -->
                            <p>提供商将与前台直接协商服务内容。</p>
                        </div>
                        <div>
                            <form>
                                <!-- 房间号 -->
                                <div class="input-group">
                                    <label>房间号</label>
                                    <input ng-model="cmbSelected.RM_ID"/>
                                </div>
                                <!-- 付款方式 -->
                                <div class="input-group">
                                    <label>付款方式</label>
                                    <select ng-model="cmbSelected.PYMNT_MTHD"
                                            ng-options="payMethod.PAY_MTHD_NM as payMethod.PAY_MTHD_NM for payMethod in payMethods" />
                                </div>
                                <!-- 数量 -->
                                <div class="input-group">
                                    <label>数量</label>
                                    <input type="num" ng-model="cmbSelected.AMNT"  />
                                </div>
                                <!-- 备注 -->
                                <div class="input-group">
                                    <label>备注</label>
                                    <textarea rows="3" ng-model="cmbSelected.RMRK"></textarea>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-default" ng-click="submit(cmbSelected,'comboDetailModal')">下单</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
    </div>
</div>
</body>
</html>