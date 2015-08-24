<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 8/24/15
 * Time: 11:19 PM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Session, Validator, Input, Redirect, DB;


class Yunpian extends Controller
{
    public static $apikey =1;
    public static $url="http://yunpian.com/v1/sms/send.json";
    public static $mobiles=["18618148761"];

    public static function notifyFrontDeskOrder($ORDR_ID,$HTL_NM,$HTL_ID,$RM_ID,$ORDR_TSTMP,$CMB_ID,$CMB_NM,$AMNT){
        $text ="【斑鸠科技】(单号:$ORDR_ID) $HTL_NM"."酒店($HTL_ID), $RM_ID"."房间, 于$ORDR_TSTMP"."请求下单: 服务ID: $CMB_ID, 服务名称:$CMB_NM; 数量: $AMNT";
        $encoded_text = urlencode("$text");
        foreach(self::$mobiles as $mobile){
            $mobile = urlencode(self::$mobile);
            $post_string="apikey=".self::$apikey."&text=$encoded_text&mobile=$mobile";
            sock_post(self::$url, $post_string);
        }
    }

}