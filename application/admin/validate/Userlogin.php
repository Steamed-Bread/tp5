<?php
namespace app\admin\validate;
use think\Validate;
class Userlogin extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:25|unique:admin',
        'password' =>  'require',
    ];

    protected $message  =   [
        'username.require' => '管理员名称必须填写',
        'username.max' => '管理员名称长度不得大于25位',
        'username.unique' => '管理员名称不得重复',
        'password.require' => '管理员密码必须填写',

    ];

    protected $scene = [
        'add'  =>  ['username'=>'require|unique:userlogin','password'],
        'edit'  =>  ['username'=>'require|unique:userlogin'],
    ];




}
