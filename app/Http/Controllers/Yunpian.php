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
    public static $apikey ='26b126ce6f0379478da7c98289ee9bf7';
    public static $url="http://yunpian.com/v1/sms/send.json";
    public static $mobiles=["18618148761","18092213579","18629088676"];

    public static function notifyFrontDeskOrder($ORDR_ID,$HTL_NM,$HTL_ID,$RM_ID,$ORDR_TSTMP,$CMB_ID,$CMB_NM,$AMNT,$CUS_PHN,$TSTMP,$MRCHNT_ID,$MRCHNT_NM,$MRCHNT_PHN){
        $text ="【神灯客房】(单号:$ORDR_ID) $HTL_NM"."酒店($HTL_ID), $RM_ID"."房间, 客人手机号:$CUS_PHN; 于$TSTMP"."请求下单: 服务ID: $CMB_ID, 服务名称:$CMB_NM; 数量: $AMNT,服务时间:$ORDR_TSTMP;商户ID:$MRCHNT_ID,商户名称:$MRCHNT_NM,商户电话$MRCHNT_PHN;";
        $encoded_text = urlencode("$text");
        foreach(self::$mobiles as $mobile){
            $mobile = urlencode($mobile);
            $post_string="apikey=".self::$apikey."&text=$encoded_text&mobile=$mobile";
            self::sock_post(self::$url, $post_string);
        }
    }

    public static function sendGreetings($HTL_NM,$mapURL,$appURL,$guestInfo){
        $mobilesString = urlencode($guestInfo[0]['phone']);
        $text ="【神灯客房】您好，您预定的".$HTL_NM."具体位置: ".$mapURL."。您可在前台扫码获得Wi-Fi，酒店提供免服务费的外卖送餐新体验。详情点击: ".$appURL."。".$HTL_NM."，祝您旅途一路好心情！";
        $encoded_text = urlencode("$text");
        for ( $counter = 1; $counter < sizeof($guestInfo); $counter += 1) {
            $mobilesString = $mobilesString.",".urlencode($guestInfo[$counter]['phone']);
        }
        $post_string="apikey=".self::$apikey."&text=$encoded_text&mobile=$mobilesString";
        return self::sock_post(self::$url, $post_string);
    }

    private static function sock_post($url,$query){
        $data = "";
        $info=parse_url($url);
        $fp=fsockopen($info["host"],80,$errno,$errstr,30);
        if(!$fp){
            return $data;
        }
        $head="POST ".$info['path']." HTTP/1.0\r\n";
        $head.="Host: ".$info['host']."\r\n";
        $head.="Referer: http://".$info['host'].$info['path']."\r\n";
        $head.="Content-type: application/x-www-form-urlencoded\r\n";
        $head.="Content-Length: ".strlen(trim($query))."\r\n";
        $head.="\r\n";
        $head.=trim($query);
        $write=fputs($fp,$head);
        $header = "";
        while ($str = trim(fgets($fp,4096))) {
            $header.=$str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp,4096);
        }
        return $data;
    }

}