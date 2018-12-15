<?php
return [

   'view_replace_str'  =>  [
    '__PUBLIC__'=>SITE_URL.'/public/static/admin',
    '__IMG__'=>SITE_URL.'/public/static',

    //=======【token,ticket获取地址】===================================
	/**
     * TODO：向数据服务请求TOKEN和TICKET
     * TOKEN_URL：微信TOKEN
     * TICKET_URL：JSSDK
     * @var string
     */
    '__TOKEN_URL__'=> "http://139.196.72.117:8080/Wechat/check/token",
    '__TICKET_URL__'=> "http://localhost:8080/Wechat/check/ticket",
    '__START_URL__'=> "http://localhost:8080/Wechat/check/mcode",
    '__USERINFO_ADD__'=> "http://localhost:8080/Wechat/add/user",
    '__USERINFO_DELETE__'=> "http://localhost:8080/Wechat/delete/user",
    '__DEVICE_ADD__'=> "http://localhost:8080/Wechat/add/bindInfo",
    '__DEVICE_DELETE__'=> "http://localhost:8080/Wechat/update/bindInfo",
    ],

    'template'               => [
        // 模板后缀
        'view_suffix'  => 'htm',
    ],


    
];
