<!DOCTYPE html>
<html>

<body>

<div class="container">
    <div class="col-md-6" >
        <table class="table table-striped table-acct">
            <tr>
                <th>姓名</th>
                <th>电话</th>
            </tr>
            <tr ng-repeat="guest in guestInfo">
                <td>
                    <input ng-model="guest.name"
                       xlabel checker="isChineseOrEnglishOrSpace" checkee="guest.name" ng-transclude btn-pass="infoError"/>
                </td>
                <td>
                    <input ng-model="guest.phone"
                       xlabel checker="isNumber" checkee="guest.phone" ng-transclude btn-pass="infoError"/>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <button ng-click="addGuest()" style="margin-top:20px;">添加客人</button>
    </div>
    <div>
        <button ng-click="submit()" style="margin-top:20px;">发送欢迎短信</button>
    </div>
</div>
</body>
</html>