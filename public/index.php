<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('SITE_URL', 'http://sip.pioteks.com/tp5');
define('TOKEN_URL', 'http://139.196.72.117:8080/Wechat/check/token');
define('appid', 'xxxx');
define('appsecret','xxxx');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
