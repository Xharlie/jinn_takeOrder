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
            <div>
                <div class="btn-customized btn-block" ng-click="selectDate('today')">今天</div>
                <div class="btn-customized btn-block" ng-click="selectDate('yesterday')">昨天</div>
                <div class="btn-customized btn-block" ng-click="selectDate('thisWeek')">本周</div>
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
                            <th>已等待</th>
                            <th>订单号</th>
                            <!--<th>交易号</th>-->
                            <th>服务名</th>
                            <th>数量</th>
                            <th>下单时间</th>
                            <th width=200>备注</th>
                            <!--<th>姓名</th>-->
                            <!--<th>电话</th>-->
                            <!--<th>地址</th>-->
                            <th>酒店名</th>
                            <th>房间号</th>
                            <th>状态</th>
                            <th>挂账金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="order in orders | orderBy:'ORDR_ID':'true'">
                            <td>
                                <div class="progress" ng-if="order.STATUS == '未确认' || order.STATUS == '已下单'"
                                     popover="号台接单:{{order.orderTakenTime}}分钟,商家准备:{{order.deliveryTime}}分钟" popover-trigger="mouseenter"
                                     popover-append-to-body popover-placement="right" style="height:5px;margin:5px 0 0 0;border-radius:0;">
                                    <div class="progress-bar active" role="progressbar"
                                         style="width:{{(order.deliveryTime+order.orderTakenTime > 60)?
                                            order.orderTakenTime*100/(order.deliveryTime+order.orderTakenTime):order.orderTakenTime *100/60}}%;">
                                    </div>
                                    <div class="progress-bar progress-bar-warning active" role="progressbar"
                                         style="width:{{(order.deliveryTime+order.orderTakenTime > 60)?
                                            order.deliveryTime*100/(order.deliveryTime+order.orderTakenTime):order.deliveryTime *100/60 }}%;">
                                    </div>
                                </div>
                                <div ng-if="order.STATUS != '未确认' && order.STATUS != '已下单'">
                                        已完成
                                </div>
                            </td>
                            <td>{{order.ORDR_ID}}</td>
                            <!--<td>{{order.TRN_ID}}</td>-->
                            <td>{{order.CMB_NM}}</td>
                            <td>{{order.AMNT}}</td>
                            <td>{{order.ORDR_TSTMP}}</td>
                            <td>{{order.RMRK}}</td>
                            <!--<td>{{order.RCVR_NM}}</td>-->
                            <!--<td>{{order.RCVR_PHN}}</td>-->
                            <!--<td>{{order.RCVR_ADDRSS}}</td>-->
                            <td>{{order.HTL_NM}}</td>
                            <td>{{order.RM_ID}}</td>
                            <td>
                                <select ng-model="order.STATUS" ng-change="updateStatus(order)">
                                    <option value="未确认">未确认</option>
                                    <option value="已下单">已下单</option>
                                    <option value="已送达">已送达</option>
                                    <!--<option value="申请取消">申请取消</option>-->
                                    <option value="已取消">已取消</option>
                                </select>
                            </td>
                            <td>{{order.ACCT_ON_RM}}元</td>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>挂账总计:</td>
                            <td>{{orderPanel.sumACCT_ON_RM}}元</td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>