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

class User extends Base
{

    public function userlst()
    {
        $list=Db::name('Userinfo')->paginate(13);
        $this->assign('list',$list);
        return $this->fetch();
    }
}