<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
    public function _initialize(){
        if(!session('adminname')){
            $this->error('请先登录系统！','Login/index');
        }
    }
}
