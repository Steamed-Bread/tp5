<?php
namespace app\Index\controller;
use think\Controller;
use app\Index\model\Userlogin;
class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()){
            $admin=new Userlogin();
            $data=input('post.');
            $num=$admin->login($data);
            if($num==3){
                $this->success('信息正确，正在为您跳转...','index/index/index');
            }elseif($num==4){
                $this->error('验证码错误');
            }
            else{
                $this->error('用户名或者密码错误');
            }

        }
        return $this->fetch('login');
    }

    



}
