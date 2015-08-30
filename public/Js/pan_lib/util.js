var util = {
    Limit : function(num){
        return Number(parseFloat(num).toFixed(2));
    },
    isNum : function(testee){
        return (!isNaN(testee) && testee!=null && testee.toString().trim()!="" );
    },
    deepCopy: function(copyee){
        return  JSON.parse(JSON.stringify(copyee));
    },
    array2Obj: function(targetArray,keyColumn,valueColumn){
        var resultObj = {};
        for(var i = 0; i<targetArray.length; i++){
            resultObj[targetArray[i][keyColumn]] = targetArray[i][valueColumn];
        }
        return resultObj;
    }
}

var show =function(showee){
    alert(JSON.stringify(showee));
}

//
//    ['基本信息','basicInfo'],["账单查看",'viewAccounting'],["叫醒服务",'wakeUp'],["退房办理",'checkOut'],
//    ["商品购买",'shopping']];               //有人房间菜单

