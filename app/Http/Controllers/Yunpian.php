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

    public static function notifyFrontDeskOrder($ORDR_ID,$HTL_NM,$HTL_ID,$RM_ID,$ORDR_TSTMP,$CMB_ID,$CMB_NM,$AMNT){
        $text ="【斑鸠科技】(单号:$ORDR_ID) $HTL_NM"."酒店($HTL_ID), $RM_ID"."房间, 于$ORDR_TSTMP"."请求下单: 服务ID: $CMB_ID, 服务名称:$CMB_NM; 数量: $AMNT";
        $encoded_text = urlencode("$text");
        foreach(self::$mobiles as $mobile){
            $mobile = urlencode($mobile);
            $post_string="apikey=".self::$apikey."&text=$encoded_text&mobile=$mobile";
            self::sock_post(self::$url, $post_string);
        }
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