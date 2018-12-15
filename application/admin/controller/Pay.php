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

class Pay extends Base
{
    public function paylst()
    {
        // $list=AdminModel::paginate(3);
        $list=Db::name('Payinfo')->paginate(13);
        $this->assign('paylist',$list);
//        var_dump($list);die;
        return $this->fetch();
    }
}