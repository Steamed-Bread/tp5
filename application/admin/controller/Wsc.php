<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 2018/7/1
 * Time: 下午10:57
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;

class WSC extends Base
{
    public function industry()
    {
        $list=Db::name('industry')->paginate(13);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function home()
    {
        $list=Db::name('home')->paginate(13);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function publicapp()
    {
        $list=Db::name('public')->paginate(13);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function service()
    {
        $list=Db::name('service')->paginate(13);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function auth()
    {
        $list=Db::name('user_menu')->paginate(13);
        $this->assign('list',$list);
        return $this->fetch();
    }
}