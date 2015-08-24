<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <!--以下div用于显示页面内filter等。可以通过checkbox、selector的方式。里面有几个例子 -->
        <div class="control col-md-2">
            <h3>订单</h3>
            <div class="form-group col-sm-6">
                <label >从</label>
                <div class="input-group datePick" ng-controller="Datepicker" >
                    <input type="text" class="form-control input-lg" show-weeks="false" datepicker-popup="yyyy-MM-dd"
                           ng-model="orderPanel.startDate" is-open="opened2" min-date="2000-0-01" max-date="orderPanel.CHECK_OT_DT"
                           datepicker-options="dateOptions" date-disabled="disabled(date, mode)"
                           ng-required="true" close-text="Close" ng-style="BookCommonInfo.CheckOTStyle"
                           datepicker-append-to-body="true"
                            />
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-lg" ng-click="open2($event)"><i class="icon-calendar-outline" style="font-size:17px;"></i></button>
                            </span>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label >到</label>
                <div class="input-group datePick" ng-controller="Datepicker" >
                    <input type="text" class="form-control input-lg" show-weeks="false" datepicker-popup="yyyy-MM-dd"
                           ng-model="orderPanel.endDate" is-open="opened2" min-date="orderPanel.CHECK_IN_DT" max-date="'2020-06-22'"
                           datepicker-options="dateOptions" date-disabled="disabled(date, mode)"
                           ng-required="true" close-text="Close" ng-style="BookCommonInfo.CheckOTStyle"
                           datepicker-append-to-body="true"
                            />
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-lg" ng-click="open2($event)"><i class="icon-calendar-outline" style="font-size:17px;"></i></button>
                            </span>
                </div>
            </div>
        </div>
        <div class="table col-md-10">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>订单号</td>
                        <td>交易号</td>
                        <td>货品</td>
                        <td>数量</td>
                        <td>下单时间</td>
                        <td>订单备注</td>
                        <td>收件人姓名</td>
                        <td>收件人电话</td>
                        <td>收件人地址</td>
                        <td>酒店名称</td>
                        <td>房间号</td>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="order in orders">
                        <td>{{order.ORDR_ID}}</td>
                        <td>{{order.TRN_ID}}</td>
                        <td>{{order.CMB_NM}}</td>
                        <td>{{order.AMNT}}</td>
                        <td>{{order.ORDR_TSTMP}}</td>
                        <td>{{order.RMRK}}</td>
                        <td>{{order.RCVR_NM}}</td>
                        <td>{{order.RCVR_PHN}}</td>
                        <td>{{order.RCVR_ADDRSS}}</td>
                        <td>{{order.HTL_NM}}</td>
                        <td>{{order.RM_ID}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>