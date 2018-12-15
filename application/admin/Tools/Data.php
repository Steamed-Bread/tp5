<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 2018/7/1
 * Time: 下午5:23
 */

namespace app\admin\tools;


class Data
{
//    public static function GetToken(){
//        //获取token请求
//        $url_token = TOKEN_URL;
//        $token = Http::http_get($url_token);
////        var_dump($token);die;
//        $token = json_decode($token, true);
//        $token = $token['accessToken'];
//        return $token;
//
//    }

//暂时使用，危险
     public static function GetToken() {
 	$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".appid."&secret=".appsecret;
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
     $dataBlock = curl_exec($ch);//这是json数据
     curl_close($ch);
 	$res = json_decode($dataBlock, true);
     return $res['access_token'];
 }

}