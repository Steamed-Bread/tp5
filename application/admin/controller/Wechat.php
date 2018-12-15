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
class Wechat extends Base
{

    public function menu()
    {
        $list=Db::name('menu')->order('createtime desc')->limit(1)->select();
//        var_dump($list);die;
        $this->assign('list',$list);

        if(request()->isPost())
        {
            // dump(input('post.'));
            $menu=input('menudata');
            $data=
                [
                    'menu'=>input('menudata')
                ];
            // echo $menu;

            //获取token请求
            $accesstoken=Data::GetToken();
            //echo $accesstoken;die;

            //获取deviceid和ticket请求
            $url_menu="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$accesstoken;
            $menu=Http::http_post($menu,$url_menu);
            $menu=json_decode($menu,true);
            //dump($menu);
            $msg=$menu['errmsg'];
            //echo $msg;
            if($msg=="ok"){
                Db::name('menu')->insert($data);

                return $this->success("添加菜单成功",'menu');
            }else{
                return $this->error("添加菜单失败:".$msg);
            }
        }
        return $this->fetch();
    }

}