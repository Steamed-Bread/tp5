<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 2018/7/1
 * Time: 下午4:15
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\tools\Http;
use app\admin\tools\Data;
class Device extends Base
{

    public function add()
    {
        if(request()->isPost())
        {
            // dump(input('post.'));
            $data=
                [
                    'macid'=>input('macid'),
                    'productid'=>input('productid')
                ];
            $validate = \think\Loader::validate('Device');

            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            //获取token请求
            $accesstoken=Data::GetToken();
            //echo $accesstoken;die;

            //获取deviceid和ticket请求
            $url_ticket="https://api.weixin.qq.com/device/getqrcode?access_token=".$accesstoken."&product_id=".$data['productid'];
            $ticket=Http::http_get($url_ticket);
            //echo  $ticket;

            $ticket=json_decode($ticket,true);
            //var_dump($ticket);
            $msg=$ticket['base_resp']['errcode'];
            if($msg==100020){
                return $this->error("设备配额不足！");
            }else{
                $deviceid=$ticket['deviceid'];
                $qrticket=$ticket['qrticket'];
                //dump($ticket);
            }


            //设备授权
            $auth_data=
                '{
                "device_num":"1",
                "device_list":[
                {
                "id":"'.$deviceid.'",
                "mac":"'.$data['macid'].'",
                "connect_protocol":"3",
                "auth_key":"",
                "close_strategy":"1",
                "conn_strategy":"1",
                "crypt_method":"0",
                "auth_ver":"0",
                "manu_mac_pos":"-1",
                "ser_mac_pos":"-2",
                "ble_simple_protocol": "0"
            }
            ],
            "op_type":"1"
            }';
            $url_auth="https://api.weixin.qq.com/device/authorize_device?access_token=".$accesstoken;
            $auth=Http::http_post($auth_data,$url_auth);
            $auth=json_decode($auth,true);
            //dump($auth);
            $msg=$auth['resp'][0]['errmsg'];
            //echo $msg;

            $device_data=
                [
                    'macid'=>$data['macid'],
                    'deviceid'=>$deviceid,
                    'qrticket'=>$qrticket,
                    'productid'=>$data['productid']
                ];

            if($msg=="ok"){
                if(Db::name('device')->insert($device_data)){
                    return $this->success("添加设备成功",'lst');
                }else{
                    return $this->error("添加设备失败");
                }
            }else{
                return $this->error("添加设备失败");
            }
        }
        return $this->fetch();
    }

    public function lst()
    {
        $list=Db::name('device')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function del()
    {
        $id=input('id');
        if($id!=1){
            if(Db::name('device')->delete(input('id'))){
                $this->success('删除成功!','lst');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('初始化管理员删除失败');
        }
        return $this->fetch('lst');
    }


    public function state()
    {
        $list=Db::name('machine_state')->paginate(14);
        $this->assign('list',$list);
        return $this->fetch();
    }

}