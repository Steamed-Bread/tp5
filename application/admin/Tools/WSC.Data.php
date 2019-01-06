<?php
/**
 *
 * 数据对象基础类，该类中定义数据类最基本的行为
 * @author xuxing
 *
 */
namespace app\admin\tools;
class WSCData
{
    public static function Start_Code() {

          $url=WSCConfig::START_URL;
          $result=WSCApi::http_get($url);
          $code=json_decode($result,true);
          $code=$code['mcode'];
          return $code;
        }

    public static function Auth_menu($category){
          //获取用户身份openid
          $JsApi=new JsApi();
          $openid=$JsApi->getOpenid();
          // $_SESSION['passwd']="pioteks.?";
          // echo $_SESSION['passwd'];die;

          $con=WSCApi::conn();
          $sql="select $category from `wsc_user_menu` where openid='$openid'";
          $rs=mysql_query($sql);
          $r=mysql_fetch_array($rs,MYSQL_ASSOC);

          $menu_id=explode(",",$r[$category]);
          // var_dump($menu_id);die;
          $res=array();
          $i=1;
          while($i<10){
            if(in_array($i,$menu_id)){
              $param='wsc_'.$category;
              $sql="select name,url from `$param` where id='$i'";
                  $rs=mysql_query($sql);
                  $r=mysql_fetch_array($rs,MYSQL_ASSOC);
              array_push($res,$r);
            }else{
              array_push($res,['name'=>'Coming SOON!','url'=>'0']);
            }
            $i++;
          }
          mysql_close($con);
          return $res;
    }

    public static function Userinfo_Database($openid,$state)
    {

        $JsApi = new JsApi();
        $token = $JsApi->gettoken();
        // $token='11_jjSi6hu6YBKlGAS2d64j1J3nH7pEU5HSMFUHiazM_5Xfvt2P5jv2wmiCg76z9bactEWwFjKhptnrXDwYM1Y1I_jIy2NNtI9gksuO7XKkW9SEx8JI5jLcOX1CFpv-GUzCnghzaAVvvF3wrpb8WSHgAJAMIX';
        $info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $openid;
        $infos = WSCApi::http_get($info_url);
        $info = json_decode($infos, true);
        if ($state == "subscribe") {
            $nickname = $info['nickname'];
            $url = WSCConfig::USERINFO_ADD;//提交地址
            WSCApi::http_post_json($infos,$url);
            return $nickname;

        } else {
            $url = WSCConfig::USERINFO_DELETE;//提交地址
            WSCApi::http_post($infos, $url);
        }


    }

    public static function Userinfo($openid, $state, $location, $event)
    {
        $JsApi = new JsApi();
        $token = $JsApi->gettoken();
        // $token='11_zAn0J6XU5yoNvcHr4MUZzj2vIPjns1yFXOwv6CQ9BJwHhJQF4zRN7ubd_-BRxidM3OvJPkd81mBkVJEOAoe2FIVJOl4KesYcE5RtaLJHvq4cz91RRYT7nExW0gAAHBbAEAQXR';
        $con = WSCApi::conn();
        if ($state == "subscribe") {
            if ($event == "subscribe") {
                $info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $openid;
                $infos = WSCApi::http_get($info_url);
                $info = json_decode($infos, true);

                $nickname = $info['nickname'];
                $city = $info['city'];
                $sex = $info['sex'];
                $sql_insert = "insert into wsc_userinfo(Openid,Nickname,City,Sex,location) values('$openid','$nickname','$city','$sex','$location')";
                mysql_query($sql_insert);
            } else {

                $location_post = json_encode(['Openid' => "$openid", 'Location' => "$location"]);
                $sql_update = "UPDATE `wsc_userinfo` SET `location`='$location' WHERE Openid = '$openid' ";
                mysql_query($sql_update);
            }
        } else {
            $sql_delete = "delete from `wsc_userinfo` WHERE Openid = '$openid' ";
            mysql_query($sql_delete);
        }
        mysql_close($con);
    }

    public static function Device_Bind($deviceinfo,$openid,$state)
    {
        $con = WSCApi::conn();
        if($state=="bind"){
           $sql_device="INSERT INTO `wsc_deviceinfo_Bind` ( `Openid`, `Deviceid`) VALUES ('$openid', '$deviceinfo');";
           mysql_query($sql_device);

       }else{
        $sql_delete="delete from `wsc_deviceinfo_Bind`  WHERE  Deviceid = '$deviceinfo' and Openid = '$openid';";
        mysql_query($sql_delete);
       }
        mysql_close($con);   
    }

    public static function Device_Database($deviceinfo,$openid,$state)
    {

       $bind_info = array ('openid'=>"$openid",'deviceinfo'=>"$deviceinfo",'state'=>"$state");
       $bind_info=json_encode($bind_info);

       if($state=="bind"){
           $url=WSCConfig::DEVICE_ADD;//提交地址
           WSCApi::http_post_json($bind_info,$url);
       }else{
           $url=WSCConfig::DEVICE_DELETE;//提交地址
           WSCApi::http_post_json($bind_info,$url);
       }
   }

   public static function Feedback($openid,$pic_url,$text)
   {
    $con = WSCApi::conn();
    $sql_problem="INSERT INTO `wsc_feedback` (`Openid`, `pic_url`,`text`) VALUES ('$openid', '$pic_url','$text');";
    mysql_query($sql_problem);
    mysql_close($con); 
   }


}