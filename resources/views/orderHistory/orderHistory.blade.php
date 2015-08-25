<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <!--以下div用于显示页面内filter等。可以通过checkbox、selector的方式。里面有几个例子 -->
        <div class="sideControl col-md-2">
            <div class="separator-group">
                <div class="separator-text">订单历史</div>
                <div class="separator-line"></div>
            </div>
            <div class="input-group input-customized datePick" ng-controller="Datepicker" >
                <label>从</label>
                <input type="text" show-weeks="false" datepicker-popup="yyyy-MM-dd"
                       ng-model="orderPanel.startDate" is-open="opened2" min-date="2000-0-01" max-date="orderPanel.CHECK_OT_DT"
                       datepicker-options="dateOptions" date-disabled="disabled(date, mode)"
                       ng-required="true" close-text="Close" ng-style="BookCommonInfo.CheckOTStyle"
                       datepicker-append-to-body="true"
                        />
                <span class="input-group-btn" style="display:none;">
                    <button type="button" class="btn btn-default" ng-click="open2($event)"><i class="icon-calendar-outline" style="font-size:17px;"></i></button>
                </span>
            </div>
            <div class="input-group input-customized datePick" ng-controller="Datepicker" >
                <label>到</label>
                <input type="text" show-weeks="false" datepicker-popup="yyyy-MM-dd"
                       ng-model="orderPanel.endDate" is-open="opened2" min-date="orderPanel.CHECK_IN_DT" max-date="'2020-06-22'"
                       datepicker-options="dateOptions" date-disabled="disabled(date, mode)"
                       ng-required="true" close-text="Close" ng-style="BookCommonInfo.CheckOTStyle"
                       datepicker-append-to-body="true"
                        />
                <span class="input-group-btn" style="display:none;">
                    <button type="button" class="btn btn-default" ng-click="open2($event)"><i class="icon-calendar-outline" style="font-size:17px;"></i></button>
                </span>
            </div>
        
        </div>
        <div class="col-md-10">
            <div class="table table-customized">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>交易号</th>
                            <th>品名</th>
                            <th>数量</th>
                            <th>时间</th>
                            <th>备注</th>
                            <th>姓名</th>
                            <th>电话</th>
                            <th>地址</th>
                            <th>酒店名</th>
                            <th>房间号</th>
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
    </div>
</body>
</html>