<?php
namespace app\admin\validate;
use think\Validate;
class Device extends validate
{
	 protected $rule = [
        'macid'  =>  'require|length:12,12',
        'productid' =>  'require',
    ];
    protected $message = [
    'macid.require' => '设备MAC必须填写',
    'macid.length'    => '设备MAC为12位',
    'productid.require'    => 'product_id必须填写',
    'productid.length'    => 'product_id必须为5位',
    ];
    //验证场景
    protected $scene=[
    'add'=>['macid'=>'require|length:12,12','productid'=>'require|length:5,5'],
    'edit'=>['username'=>'require','password'],
    ];

}